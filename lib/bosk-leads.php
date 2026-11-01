<?php
/* ============================================================
   Bosk Furniture - Lead capture
   ------------------------------------------------------------
   One place that handles every enquiry form on the website:
     1. validates the input (same rules as the browser)
     2. blocks bots (honeypot) and floods (per-IP limit)
     3. saves the lead in the `leads` table (created automatically)
     4. emails the website owner  (new lead notification)
     5. emails the customer       (branded thank-you / welcome)
     6. answers the browser with JSON

   Used by: back/contact.php, back/modest_customize.php,
            back/comment.php, back/newsletter.php
   Admin  : Admin/leads.php
   ============================================================ */

require_once __DIR__ . '/bosk-mailer.php';
require_once __DIR__ . '/bosk-email-templates.php';

/* ------------------------------------------------------------
   Lookups shared by the website, the emails and the admin panel
   ------------------------------------------------------------ */
function bosk_lead_sources()
{
    return [
        'contact'      => ['label' => 'Contact Form',        'icon' => 'icofont-envelope',     'color' => '#3b6fe0', 'bg' => '#eef3ff'],
        'customize'    => ['label' => 'Customize Furniture', 'icon' => 'icofont-ruler-pencil', 'color' => '#b35c1e', 'bg' => '#fff1e6'],
        'blog_comment' => ['label' => 'Blog Comment',        'icon' => 'icofont-comment',      'color' => '#8b5cf6', 'bg' => '#f3eefe'],
        'newsletter'   => ['label' => 'Newsletter',          'icon' => 'icofont-paper-plane',  'color' => '#0e9f9a', 'bg' => '#e6f7f6'],
    ];
}

function bosk_lead_statuses()
{
    return [
        'new'         => ['label' => 'New',         'color' => '#d9480f', 'bg' => '#fff1e6'],
        'contacted'   => ['label' => 'Contacted',   'color' => '#3b6fe0', 'bg' => '#eef3ff'],
        'in_progress' => ['label' => 'In Progress', 'color' => '#8b5cf6', 'bg' => '#f3eefe'],
        'converted'   => ['label' => 'Converted',   'color' => '#1aa260', 'bg' => '#e6f7ee'],
        'closed'      => ['label' => 'Closed',      'color' => '#6c757d', 'bg' => '#f1f3f5'],
        'spam'        => ['label' => 'Spam',        'color' => '#c0392b', 'bg' => '#fdeef0'],
    ];
}

/** BSK-000042 */
function bosk_lead_ref($id)
{
    return 'BSK-' . str_pad((string) (int) $id, 6, '0', STR_PAD_LEFT);
}

/** Current date-time in India (stored in the DB, shown everywhere). */
function bosk_lead_now($modify = '')
{
    $dt = new DateTime('now', new DateTimeZone('Asia/Kolkata'));
    if ($modify !== '') {
        $dt->modify($modify);
    }
    return $dt->format('Y-m-d H:i:s');
}

/** utf8mb4 connection + make sure the `leads` table exists. */
function bosk_leads_prepare_db($con)
{
    static $ready = null;
    if ($ready !== null) {
        return $ready;
    }
    if (!$con) {
        return $ready = false;
    }
    @mysqli_set_charset($con, 'utf8mb4');

    $sql = "CREATE TABLE IF NOT EXISTS `leads` (
        `id`                 INT UNSIGNED NOT NULL AUTO_INCREMENT,
        `source`             VARCHAR(30)   NOT NULL DEFAULT 'contact',
        `name`               VARCHAR(100)  NOT NULL DEFAULT '',
        `email`              VARCHAR(150)  NOT NULL DEFAULT '',
        `phone`              VARCHAR(20)   NOT NULL DEFAULT '',
        `message`            TEXT          NULL,
        `context`            VARCHAR(255)  NULL DEFAULT NULL,
        `attachment`         VARCHAR(255)  NULL DEFAULT NULL,
        `attachment_name`    VARCHAR(255)  NULL DEFAULT NULL,
        `page_url`           VARCHAR(500)  NULL DEFAULT NULL,
        `status`             VARCHAR(20)   NOT NULL DEFAULT 'new',
        `admin_note`         TEXT          NULL,
        `is_read`            TINYINT(1)    NOT NULL DEFAULT 0,
        `customer_mail_sent` TINYINT(1)    NOT NULL DEFAULT 0,
        `owner_mail_sent`    TINYINT(1)    NOT NULL DEFAULT 0,
        `mail_error`         VARCHAR(1000) NULL DEFAULT NULL,
        `ip_address`         VARCHAR(45)   NULL DEFAULT NULL,
        `user_agent`         VARCHAR(255)  NULL DEFAULT NULL,
        `created_at`         DATETIME      NOT NULL DEFAULT CURRENT_TIMESTAMP,
        `updated_at`         DATETIME      NULL DEFAULT NULL,
        PRIMARY KEY (`id`),
        KEY `idx_leads_status`  (`status`),
        KEY `idx_leads_source`  (`source`),
        KEY `idx_leads_created` (`created_at`),
        KEY `idx_leads_email`   (`email`),
        KEY `idx_leads_ip`      (`ip_address`, `created_at`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";

    $ready = (bool) mysqli_query($con, $sql);
    if (!$ready) {
        error_log('[Bosk leads] Could not create leads table: ' . mysqli_error($con));
    }
    return $ready;
}

/** Runs a prepared COUNT(*) style query and returns the integer result. */
function bosk_leads_scalar($con, $sql, $types = '', array $params = [])
{
    $stmt = mysqli_prepare($con, $sql);
    if (!$stmt) {
        return 0;
    }
    if ($types !== '') {
        mysqli_stmt_bind_param($stmt, $types, ...$params);
    }
    $value = 0;
    if (mysqli_stmt_execute($stmt)) {
        mysqli_stmt_bind_result($stmt, $value);
        mysqli_stmt_fetch($stmt);
    }
    mysqli_stmt_close($stmt);
    return (int) $value;
}

/* ------------------------------------------------------------
   Admin panel helpers
   ------------------------------------------------------------ */

/**
 * True only for a logged-in ADMIN. The shop's customer login also sets
 * $_SESSION['email'], so the address must exist in the `admin` table.
 */
function bosk_leads_is_admin($con)
{
    if (empty($_SESSION['email']) || !$con) {
        return false;
    }
    return bosk_leads_scalar($con, 'SELECT COUNT(*) FROM admin WHERE email = ?', 's', [(string) $_SESSION['email']]) > 0;
}

/** "just now", "5 min ago", "3 hours ago", "2 days ago", "12 Oct 2026" */
function bosk_lead_time_ago($datetime)
{
    $tz = new DateTimeZone('Asia/Kolkata');
    try {
        $then = new DateTime((string) $datetime, $tz);
    } catch (Exception $e) {
        return '';
    }
    $diff = (new DateTime('now', $tz))->getTimestamp() - $then->getTimestamp();
    if ($diff < 60) {
        return 'just now';
    }
    if ($diff < 3600) {
        return floor($diff / 60) . ' min ago';
    }
    if ($diff < 86400) {
        $h = floor($diff / 3600);
        return $h . ($h == 1 ? ' hour ago' : ' hours ago');
    }
    if ($diff < 7 * 86400) {
        $d = floor($diff / 86400);
        return $d == 1 ? 'yesterday' : $d . ' days ago';
    }
    return $then->format('d M Y');
}

/** "Ravi Patel" -> "RP" (falls back to the e-mail address). */
function bosk_lead_initials($name, $email = '')
{
    $source = trim((string) $name) !== '' ? trim((string) $name) : (string) $email;
    $parts  = preg_split('/[\s._@-]+/u', $source, -1, PREG_SPLIT_NO_EMPTY);
    $out    = '';
    foreach (array_slice($parts, 0, 2) as $p) {
        $out .= mb_strtoupper(mb_substr($p, 0, 1, 'UTF-8'), 'UTF-8');
    }
    return $out !== '' ? $out : '?';
}

/** Stable avatar colour for a person. */
function bosk_lead_avatar_color($seed)
{
    $palette = ['#532A1A', '#3b6fe0', '#1aa260', '#d98a00', '#8b5cf6', '#0e9f9a', '#e23b3b', '#b35c1e'];
    return $palette[abs(crc32(strtolower((string) $seed))) % count($palette)];
}

/** Visitor IP (looks behind a local reverse proxy / CDN only when needed). */
function bosk_lead_client_ip()
{
    $ip = isset($_SERVER['REMOTE_ADDR']) ? trim($_SERVER['REMOTE_ADDR']) : '';
    $public = FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE;
    if ($ip !== '' && filter_var($ip, FILTER_VALIDATE_IP, $public)) {
        return $ip;
    }
    foreach (['HTTP_CF_CONNECTING_IP', 'HTTP_X_FORWARDED_FOR', 'HTTP_X_REAL_IP'] as $header) {
        if (empty($_SERVER[$header])) {
            continue;
        }
        foreach (explode(',', $_SERVER[$header]) as $candidate) {
            $candidate = trim($candidate);
            if (filter_var($candidate, FILTER_VALIDATE_IP, $public)) {
                return $candidate;
            }
        }
    }
    return $ip !== '' ? substr($ip, 0, 45) : '';
}

/** "Mobile · Chrome on Android" from a user-agent string. */
function bosk_lead_device($ua)
{
    $ua = (string) $ua;
    if ($ua === '') {
        return '';
    }
    if (preg_match('/iPad|Tablet/i', $ua) || (preg_match('/Android/i', $ua) && !preg_match('/Mobi/i', $ua))) {
        $type = 'Tablet';
    } elseif (preg_match('/Mobi|iPhone|iPod/i', $ua)) {
        $type = 'Mobile';
    } else {
        $type = 'Desktop';
    }

    $os = 'Unknown OS';
    if (preg_match('/Windows NT/i', $ua)) {
        $os = 'Windows';
    } elseif (preg_match('/iPhone|iPad|iPod/i', $ua)) {
        $os = 'iOS';
    } elseif (preg_match('/Android/i', $ua)) {
        $os = 'Android';
    } elseif (preg_match('/Macintosh|Mac OS X/i', $ua)) {
        $os = 'macOS';
    } elseif (preg_match('/Linux|X11/i', $ua)) {
        $os = 'Linux';
    }

    $browser = 'Browser';
    if (preg_match('/Edg(e|A|iOS)?\//i', $ua)) {
        $browser = 'Edge';
    } elseif (preg_match('/OPR\/|Opera/i', $ua)) {
        $browser = 'Opera';
    } elseif (preg_match('/SamsungBrowser/i', $ua)) {
        $browser = 'Samsung Internet';
    } elseif (preg_match('/CriOS|Chrome\//i', $ua)) {
        $browser = 'Chrome';
    } elseif (preg_match('/FxiOS|Firefox\//i', $ua)) {
        $browser = 'Firefox';
    } elseif (preg_match('/Safari\//i', $ua)) {
        $browser = 'Safari';
    }

    return $type . ' · ' . $browser . ' on ' . $os;
}

/** Single-line text: no control characters, collapsed spaces, max length. */
function bosk_lead_clean_line($value, $max)
{
    $value = preg_replace('/[\p{C}]+/u', ' ', (string) $value);
    $value = trim(preg_replace('/\s+/u', ' ', (string) $value));
    return mb_substr($value, 0, $max, 'UTF-8');
}

/** Multi-line text: keeps line breaks, removes other control characters. */
function bosk_lead_clean_text($value, $max)
{
    $value = str_replace(["\r\n", "\r"], "\n", (string) $value);
    $value = preg_replace('/[^\P{C}\n\t]+/u', '', $value);
    $value = preg_replace("/\n{3,}/", "\n\n", (string) $value);
    return mb_substr(trim((string) $value), 0, $max, 'UTF-8');
}

/** +91 98765-43210 / 098765 43210 / 9876543210 -> 9876543210 */
function bosk_lead_normalize_phone($raw)
{
    $digits = preg_replace('/\D/', '', (string) $raw);
    if (strlen($digits) === 12 && strpos($digits, '91') === 0) {
        $digits = substr($digits, 2);
    } elseif (strlen($digits) === 11 && $digits[0] === '0') {
        $digits = substr($digits, 1);
    }
    return $digits;
}

/** Name of the admin folder on disk ("Admin" locally, may be "admin" on the server). */
function bosk_lead_admin_dir()
{
    $root = dirname(__DIR__);
    foreach (['Admin', 'admin'] as $candidate) {
        if (is_dir($root . '/' . $candidate)) {
            return $candidate;
        }
    }
    return 'Admin';
}

/**
 * Absolute URL of a page inside the admin panel, used in owner emails.
 * Live site: always the configured site_url (never trusts the Host header).
 * localhost: built from the current request so links work while testing.
 */
function bosk_lead_admin_url($page)
{
    $cfg  = bosk_mail_config();
    $host = isset($_SERVER['HTTP_HOST']) ? strtolower($_SERVER['HTTP_HOST']) : '';
    $path = '/' . bosk_lead_admin_dir() . '/' . ltrim($page, '/');

    if (preg_match('/^(localhost|127\.0\.0\.1)(:\d+)?$/', $host)) {
        $https  = !empty($_SERVER['HTTPS']) && strtolower((string) $_SERVER['HTTPS']) !== 'off';
        $script = str_replace('\\', '/', isset($_SERVER['SCRIPT_NAME']) ? $_SERVER['SCRIPT_NAME'] : '/back/x.php');
        $base   = rtrim(dirname(dirname($script)), '/');
        return ($https ? 'https' : 'http') . '://' . $host . $base . $path;
    }
    return rtrim($cfg['site_url'], '/') . $path;
}

/**
 * Validates and stores an optional uploaded image.
 * Returns null (no file), false (invalid - $error is set) or
 * ['file' => stored name|null, 'path' => absolute path, 'name' => original name].
 */
function bosk_lead_store_attachment($field, &$error)
{
    $error = '';
    if (empty($_FILES[$field]) || !isset($_FILES[$field]['error'])) {
        return null;
    }
    $f = $_FILES[$field];
    if (is_array($f['error'])) {
        $error = 'Please attach a single image.';
        return false;
    }
    if ((int) $f['error'] === UPLOAD_ERR_NO_FILE) {
        return null;
    }
    if ((int) $f['error'] === UPLOAD_ERR_INI_SIZE || (int) $f['error'] === UPLOAD_ERR_FORM_SIZE || (int) $f['size'] > 5 * 1024 * 1024) {
        $error = 'The image is too large. Please upload a file under 5 MB.';
        return false;
    }
    if ((int) $f['error'] !== UPLOAD_ERR_OK || !is_uploaded_file($f['tmp_name'])) {
        $error = 'The image could not be uploaded. Please try again.';
        return false;
    }

    $types = [IMAGETYPE_JPEG => 'jpg', IMAGETYPE_PNG => 'png', IMAGETYPE_WEBP => 'webp'];
    $info  = @getimagesize($f['tmp_name']);
    if (!$info || !isset($types[$info[2]])) {
        $error = 'Only JPG, PNG or WEBP images are allowed.';
        return false;
    }
    $ext = $types[$info[2]];

    $original = preg_replace('/[^\w.\- ]+/u', '', basename((string) $f['name']));
    $original = mb_substr(trim($original) !== '' ? trim($original) : 'reference.' . $ext, 0, 120, 'UTF-8');

    $dir    = dirname(__DIR__) . '/lead_attachments';
    $stored = date('Ymd') . '_' . bin2hex(random_bytes(12)) . '.' . $ext;
    if ((is_dir($dir) || @mkdir($dir, 0755, true)) && @move_uploaded_file($f['tmp_name'], $dir . '/' . $stored)) {
        return ['file' => $stored, 'path' => $dir . '/' . $stored, 'name' => $original];
    }

    // Folder not writable: still email the image (from PHP's temp file) so it is not lost.
    error_log('[Bosk leads] Could not save attachment in ' . $dir);
    return ['file' => null, 'path' => $f['tmp_name'], 'name' => $original];
}

/**
 * Sends the JSON answer and stops the script. Form errors use HTTP 200 with
 * success=false so every page script (old and new) can read the message.
 */
function bosk_lead_respond($ok, $title, $message, array $extra = [], $httpCode = 200)
{
    while (ob_get_level() > 0) {
        ob_end_clean();
    }
    if (!headers_sent()) {
        http_response_code($httpCode);
        header('Content-Type: application/json; charset=utf-8');
        header('Cache-Control: no-store');
    }
    echo json_encode(array_merge(['success' => (bool) $ok, 'title' => $title, 'message' => $message], $extra), JSON_INVALID_UTF8_SUBSTITUTE);
    exit;
}

/* ------------------------------------------------------------
   MAIN ENTRY POINT - called by the back/*.php form endpoints
   ------------------------------------------------------------ */
function bosk_handle_lead_submission($con, $source)
{
    ob_start();
    $cfg     = bosk_mail_config();
    $sources = bosk_lead_sources();
    $help    = 'Please try again, or call us at ' . $cfg['phone_display'] . '.';

    if (!isset($_SERVER['REQUEST_METHOD']) || $_SERVER['REQUEST_METHOD'] !== 'POST') {
        bosk_lead_respond(false, 'Invalid request', 'This address only accepts form submissions.', [], 405);
    }
    if (!isset($sources[$source])) {
        bosk_lead_respond(false, 'Invalid request', 'Unknown form.', [], 400);
    }

    // Bots fill every field, including this one hidden from humans: pretend success.
    if (trim((string) ($_POST['bf_website'] ?? '')) !== '') {
        bosk_lead_respond(true, 'Thank you!', 'Your message has been received.');
    }

    // ---------- 1. Collect + validate ----------
    $isNews = ($source === 'newsletter');
    $name   = $isNews ? '' : bosk_lead_clean_line($_POST['name'] ?? '', 60);
    $email  = strtolower(trim((string) ($isNews ? ($_POST['newsemail'] ?? '') : ($_POST['email'] ?? ''))));
    $phone  = $isNews ? '' : bosk_lead_normalize_phone($_POST['phone'] ?? '');
    $msg    = $isNews ? '' : bosk_lead_clean_text($_POST['msg'] ?? '', 2000);

    $errors = [];
    if (!$isNews) {
        if ($name === '') {
            $errors['name'] = 'Please enter your name.';
        } elseif (mb_strlen($name, 'UTF-8') < 2 || !preg_match("/^[\\p{L}\\p{M}\\s.'\\-]{2,60}$/u", $name)) {
            $errors['name'] = "Please enter a valid name (letters, spaces and . ' - only).";
        }
    }
    if ($email === '') {
        $errors[$isNews ? 'newsemail' : 'email'] = 'Please enter your email address.';
    } elseif (strlen($email) > 150 || preg_match('/[\r\n]/', $email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[$isNews ? 'newsemail' : 'email'] = 'Please enter a valid email address.';
    }
    if (!$isNews) {
        if ($phone === '') {
            $errors['phone'] = 'Please enter your contact number.';
        } elseif (!preg_match('/^[6-9]\d{9}$/', $phone)) {
            $errors['phone'] = 'Please enter a valid 10-digit Indian mobile number.';
        }
        $what = ($source === 'blog_comment') ? 'comment' : 'message';
        if ($msg === '') {
            $errors['msg'] = 'Please type your ' . $what . '.';
        } elseif (mb_strlen($msg, 'UTF-8') < 10) {
            $errors['msg'] = ucfirst($what) . ' should be at least 10 characters.';
        }
    }
    if ($errors) {
        bosk_lead_respond(false, 'Please check the form', reset($errors), ['errors' => $errors]);
    }

    // ---------- 2. Database + flood protection ----------
    $dbOk = bosk_leads_prepare_db($con);
    $ip   = bosk_lead_client_ip();
    $ua   = mb_substr(mb_scrub((string) ($_SERVER['HTTP_USER_AGENT'] ?? ''), 'UTF-8'), 0, 255, 'UTF-8');

    if ($dbOk && $ip !== '') {
        $recent = bosk_leads_scalar($con, 'SELECT COUNT(*) FROM leads WHERE ip_address = ? AND created_at >= ?', 'ss', [$ip, bosk_lead_now('-15 minutes')]);
        if ($recent >= 8) {
            bosk_lead_respond(false, 'Too many requests', 'You have sent several messages in a short time. Please wait a few minutes, or call us at ' . $cfg['phone_display'] . '.');
        }
    }

    if ($isNews && $dbOk) {
        $already = bosk_leads_scalar($con, "SELECT COUNT(*) FROM leads WHERE source = 'newsletter' AND email = ? AND status <> 'spam'", 's', [$email]);
        if ($already > 0) {
            bosk_lead_respond(true, 'Already subscribed', "You're already subscribed - thank you for being part of the Bosk family!", ['already' => true]);
        }
    }

    // ---------- 3. Optional reference image (contact form) ----------
    $attachment = null;
    if ($source === 'contact') {
        $attachment = bosk_lead_store_attachment('img', $attError);
        if ($attachment === false) {
            bosk_lead_respond(false, 'Please check the image', $attError, ['errors' => ['img' => $attError]]);
        }
    }

    // ---------- 4. Extra context ----------
    $context = null;
    if ($source === 'blog_comment' && $dbOk && !empty($_POST['blog_id'])) {
        $blogId = (int) $_POST['blog_id'];
        $stmt   = mysqli_prepare($con, 'SELECT blog_title FROM blog WHERE id = ? LIMIT 1');
        if ($stmt) {
            mysqli_stmt_bind_param($stmt, 'i', $blogId);
            $title = null;
            if (mysqli_stmt_execute($stmt)) {
                mysqli_stmt_bind_result($stmt, $title);
                mysqli_stmt_fetch($stmt);
            }
            mysqli_stmt_close($stmt);
            if ($title) {
                $context = bosk_lead_clean_line($title, 255);
            }
        }
    }

    $pageUrl = mb_scrub((string) ($_SERVER['HTTP_REFERER'] ?? ''), 'UTF-8');
    $pageUrl = preg_match('#^https?://#i', $pageUrl) ? mb_substr($pageUrl, 0, 500, 'UTF-8') : null;

    // ---------- 5. Save ----------
    $now    = bosk_lead_now();
    $leadId = 0;
    if ($dbOk) {
        $stmt = mysqli_prepare($con, "INSERT INTO leads
            (source, name, email, phone, message, context, attachment, attachment_name, page_url, status, ip_address, user_agent, created_at)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, 'new', ?, ?, ?)");
        if ($stmt) {
            $attFile = $attachment ? $attachment['file'] : null;
            $attName = $attachment ? $attachment['name'] : null;
            $msgDb   = $msg !== '' ? $msg : null;
            mysqli_stmt_bind_param($stmt, 'ssssssssssss', $source, $name, $email, $phone, $msgDb, $context, $attFile, $attName, $pageUrl, $ip, $ua, $now);
            if (mysqli_stmt_execute($stmt)) {
                $leadId = (int) mysqli_insert_id($con);
            } else {
                error_log('[Bosk leads] Insert failed: ' . mysqli_stmt_error($stmt));
            }
            mysqli_stmt_close($stmt);
        }
    }

    $reference = $leadId ? bosk_lead_ref($leadId) : 'BSK-' . date('ymdHis');
    $lead = [
        'id'              => $leadId,
        'reference'       => $reference,
        'source'          => $source,
        'source_label'    => $sources[$source]['label'],
        'name'            => $name,
        'email'           => $email,
        'phone'           => $phone,
        'message'         => $msg,
        'context'         => $context,
        'attachment_name' => $attachment ? $attachment['name'] : '',
        'attachment_url'  => ($leadId && $attachment && $attachment['file']) ? bosk_lead_admin_url('lead-attachment.php?id=' . $leadId) : '',
        'page_url'        => $pageUrl,
        'ip'              => $ip,
        'device'          => bosk_lead_device($ua),
        'created_at'      => $now,
        'admin_url'       => $leadId ? bosk_lead_admin_url('leads.php?id=' . $leadId) : '',
    ];

    // Keep sending even if the visitor closes the page.
    ignore_user_abort(true);
    @set_time_limit(90);

    // ---------- 6. Email the website owner ----------
    $ownerResult = ['ok' => false, 'error' => 'No owner email address configured.'];
    if (!empty($cfg['owner_emails'])) {
        $mailOwner   = bosk_email_for_owner($lead);
        $ownerResult = bosk_send_mail([
            'to'          => $cfg['owner_emails'],
            'subject'     => $mailOwner['subject'],
            'html'        => $mailOwner['html'],
            'text'        => $mailOwner['text'],
            'reply_to'    => $email,
            'reply_name'  => $name,
            'attachments' => $attachment ? [['path' => $attachment['path'], 'name' => $attachment['name']]] : [],
        ]);
    }

    // ---------- 7. Email the customer ----------
    $customerResult = ['ok' => false, 'error' => ''];
    if (!empty($cfg['send_customer_copy'])) {
        // Never let the form be used to flood someone's inbox.
        $sentToday = $dbOk ? bosk_leads_scalar($con, 'SELECT COUNT(*) FROM leads WHERE email = ? AND customer_mail_sent = 1 AND created_at >= ?', 'ss', [$email, bosk_lead_now('-1 hour')]) : 0;
        if ($sentToday < 3) {
            $mailCustomer   = bosk_email_for_customer($lead);
            $customerResult = bosk_send_mail([
                'to'      => $email,
                'to_name' => $name,
                'subject' => $mailCustomer['subject'],
                'html'    => $mailCustomer['html'],
                'text'    => $mailCustomer['text'],
                'headers' => $isNews ? ['List-Unsubscribe' => '<mailto:' . $cfg['from_email'] . '?subject=Unsubscribe>'] : [],
            ]);
        } else {
            $customerResult['error'] = 'Confirmation skipped: hourly limit reached for this address.';
        }
    }

    if ($leadId) {
        $warning   = !empty($ownerResult['warning']) ? $ownerResult['warning'] : (!empty($customerResult['warning']) ? $customerResult['warning'] : '');
        $errorText = trim(implode(' | ', array_filter([
            $ownerResult['ok'] ? '' : 'Owner: ' . $ownerResult['error'],
            ($customerResult['ok'] || $customerResult['error'] === '') ? '' : 'Customer: ' . $customerResult['error'],
            $warning !== '' ? 'Note: ' . $warning : '',
        ])));
        $errorText = $errorText !== '' ? mb_substr($errorText, 0, 1000, 'UTF-8') : null;
        $ownerSent = $ownerResult['ok'] ? 1 : 0;
        $custSent  = $customerResult['ok'] ? 1 : 0;
        $stmt = mysqli_prepare($con, 'UPDATE leads SET owner_mail_sent = ?, customer_mail_sent = ?, mail_error = ? WHERE id = ?');
        if ($stmt) {
            mysqli_stmt_bind_param($stmt, 'iisi', $ownerSent, $custSent, $errorText, $leadId);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);
        }
    }

    // Not saved AND owner not notified = the lead would be lost, so say so honestly.
    if (!$leadId && !$ownerResult['ok']) {
        bosk_lead_respond(false, 'Sorry, something went wrong', 'We could not send your message right now. ' . $help . ' You can also WhatsApp us at ' . $cfg['whatsapp_display'] . '.');
    }

    // ---------- 8. Thank the visitor ----------
    $first  = bosk_email_first_name($name);
    $copyTo = $customerResult['ok'] ? ' We have emailed a confirmation to ' . $email . '.' : '';
    switch ($source) {
        case 'newsletter':
            $title   = 'Subscribed successfully!';
            $message = $customerResult['ok'] ? 'A welcome email is on its way to your inbox.' : 'Thank you for subscribing - we will keep you posted.';
            break;
        case 'blog_comment':
            $title   = 'Thank you, ' . $first . '!';
            $message = 'Your comment has been received.' . ($customerResult['ok'] ? ' We have emailed you a copy.' : '');
            break;
        case 'customize':
            $title   = 'Thank you, ' . $first . '!';
            $message = 'Your custom furniture request has been received (Ref: ' . $reference . ').' . $copyTo . ' Our designers will call you within ' . $cfg['reply_within'] . '.';
            break;
        default:
            $title   = 'Thank you, ' . $first . '!';
            $message = 'Your enquiry has been received (Ref: ' . $reference . ').' . $copyTo . ' Our team will contact you within ' . $cfg['reply_within'] . '.';
    }

    bosk_lead_respond(true, $title, $message, [
        'reference'     => $reference,
        'customer_mail' => (bool) $customerResult['ok'],
    ]);
}
