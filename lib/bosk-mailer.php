<?php
/* ============================================================
   Bosk Furniture - Central mailer
   ------------------------------------------------------------
   Sends every website email from info@boskfurniture.com.
     - SMTP (Hostinger) when a password is set in config/mail.php
     - PHP mail() otherwise, or as a backup when SMTP fails
   Settings: config/mail.php (+ optional config/mail.local.php)
   ============================================================ */

/**
 * Mail settings merged from defaults, config/mail.php and the optional,
 * git-ignored config/mail.local.php (handy for keeping the SMTP password
 * out of the repository).
 */
function bosk_mail_config()
{
    static $cfg = null;
    if ($cfg !== null) {
        return $cfg;
    }

    $cfg = [
        'from_email'           => 'info@boskfurniture.com',
        'from_name'            => 'Bosk Furniture',
        'owner_emails'         => ['info@boskfurniture.com'],
        'send_customer_copy'   => true,
        'smtp_host'            => 'smtp.hostinger.com',
        'smtp_port'            => 465,
        'smtp_secure'          => 'ssl',
        'smtp_username'        => 'info@boskfurniture.com',
        'smtp_password'        => '',
        'smtp_timeout'         => 15,
        'fallback_to_php_mail' => true,
        'site_url'             => 'https://www.boskfurniture.com',
        'logo_url'             => 'https://www.boskfurniture.com/images/logo-black1.png',
        'company_name'         => 'Bosk Furniture',
        'company_legal'        => 'Bosk Infracon Private Limited',
        'company_address'      => '5, Aryamaan Complex, Near Meghani Circle, Sir Patanni Road, Bhavnagar - 364001, Gujarat, India',
        'phone_display'        => '+91 88666 47777',
        'phone_link'           => '+918866647777',
        'whatsapp_display'     => '+91 97378 17777',
        'whatsapp_number'      => '919737817777',
        'reply_within'         => '24 hours',
    ];

    $configDir = dirname(__DIR__) . '/config';
    foreach (['mail.php', 'mail.local.php'] as $file) {
        if (is_file($configDir . '/' . $file)) {
            $loaded = include $configDir . '/' . $file;
            if (is_array($loaded)) {
                $cfg = array_merge($cfg, $loaded);
            }
        }
    }

    $envPassword = getenv('BOSK_SMTP_PASSWORD');
    if (is_string($envPassword) && $envPassword !== '') {
        $cfg['smtp_password'] = $envPassword;
    }

    $cfg['owner_emails'] = array_values(array_filter((array) $cfg['owner_emails'], function ($email) {
        return is_string($email) && filter_var(trim($email), FILTER_VALIDATE_EMAIL);
    }));

    return $cfg;
}

/** True when enough SMTP details are configured to try SMTP first. */
function bosk_mail_smtp_ready(array $cfg)
{
    return trim((string) $cfg['smtp_host']) !== ''
        && trim((string) $cfg['smtp_username']) !== ''
        && (string) $cfg['smtp_password'] !== '';
}

/**
 * Send one email.
 *
 * $message keys:
 *   to          string|array  one address, or a list of addresses
 *   to_name     string        optional display name (single recipient)
 *   subject     string
 *   html        string        HTML body
 *   text        string        plain-text alternative
 *   reply_to    string        optional Reply-To address
 *   reply_name  string        optional Reply-To name
 *   attachments array         optional [['path' => ..., 'name' => ...], ...]
 *   headers     array         optional extra headers ['Name' => 'value']
 *
 * Returns ['ok' => bool, 'transport' => 'smtp'|'mail'|'', 'error' => string,
 *          'warning' => string]  (warning = SMTP failed but the backup worked)
 */
function bosk_send_mail(array $message)
{
    // PHPMailer is only loaded when an email is actually sent.
    require_once __DIR__ . '/PHPMailer/src/Exception.php';
    require_once __DIR__ . '/PHPMailer/src/PHPMailer.php';
    require_once __DIR__ . '/PHPMailer/src/SMTP.php';

    $cfg = bosk_mail_config();

    $recipients = array_values(array_filter((array) ($message['to'] ?? []), function ($email) {
        return is_string($email) && filter_var(trim($email), FILTER_VALIDATE_EMAIL);
    }));
    if (!$recipients) {
        return ['ok' => false, 'transport' => '', 'error' => 'No valid recipient address.', 'warning' => ''];
    }

    $transports = [];
    if (bosk_mail_smtp_ready($cfg)) {
        $transports[] = 'smtp';
    }
    if (!$transports || !empty($cfg['fallback_to_php_mail'])) {
        $transports[] = 'mail';
    }

    $errors = [];
    foreach ($transports as $transport) {
        $mail = new \PHPMailer\PHPMailer\PHPMailer(true);
        try {
            if ($transport === 'smtp') {
                $mail->isSMTP();
                $mail->Host       = $cfg['smtp_host'];
                $mail->Port       = (int) $cfg['smtp_port'];
                $mail->SMTPAuth   = true;
                $mail->Username   = $cfg['smtp_username'];
                $mail->Password   = $cfg['smtp_password'];
                $mail->Timeout    = max(5, (int) $cfg['smtp_timeout']);
                $secure = strtolower((string) $cfg['smtp_secure']);
                if ($secure === 'ssl') {
                    $mail->SMTPSecure = \PHPMailer\PHPMailer\PHPMailer::ENCRYPTION_SMTPS;
                } elseif ($secure === 'tls') {
                    $mail->SMTPSecure = \PHPMailer\PHPMailer\PHPMailer::ENCRYPTION_STARTTLS;
                } else {
                    $mail->SMTPSecure  = '';
                    $mail->SMTPAutoTLS = false;
                }
            } else {
                $mail->isMail();
            }

            $mail->CharSet  = \PHPMailer\PHPMailer\PHPMailer::CHARSET_UTF8;
            $mail->Encoding = \PHPMailer\PHPMailer\PHPMailer::ENCODING_QUOTED_PRINTABLE;
            $mail->XMailer  = 'Bosk Furniture Website';

            // From + envelope sender (-f) = info@boskfurniture.com, so SPF/DKIM align.
            $mail->setFrom($cfg['from_email'], $cfg['from_name'], true);

            if (count($recipients) === 1) {
                $mail->addAddress(trim($recipients[0]), (string) ($message['to_name'] ?? ''));
            } else {
                foreach ($recipients as $email) {
                    $mail->addAddress(trim($email));
                }
            }

            $replyTo = trim((string) ($message['reply_to'] ?? ''));
            if ($replyTo !== '' && filter_var($replyTo, FILTER_VALIDATE_EMAIL)) {
                $mail->addReplyTo($replyTo, (string) ($message['reply_name'] ?? ''));
            } else {
                $mail->addReplyTo($cfg['from_email'], $cfg['from_name']);
            }

            foreach ((array) ($message['headers'] ?? []) as $name => $value) {
                $mail->addCustomHeader($name, $value);
            }

            foreach ((array) ($message['attachments'] ?? []) as $file) {
                if (!empty($file['path']) && is_file($file['path'])) {
                    $mail->addAttachment($file['path'], (string) ($file['name'] ?? basename($file['path'])));
                }
            }

            $mail->isHTML(true);
            $mail->Subject = (string) ($message['subject'] ?? '');
            $mail->Body    = (string) ($message['html'] ?? '');
            $mail->AltBody = (string) ($message['text'] ?? '');

            $mail->send();
            $warning = '';
            if ($errors) {
                $warning = 'Sent with PHP mail() because SMTP failed (' . implode(' | ', $errors) . ') - check the SMTP settings in config/mail.php.';
                error_log('[Bosk mailer] ' . $warning);
            }
            return ['ok' => true, 'transport' => $transport, 'error' => '', 'warning' => $warning];
        } catch (\Throwable $e) {
            $detail = ($mail->ErrorInfo !== '') ? $mail->ErrorInfo : $e->getMessage();
            $errors[] = strtoupper($transport) . ': ' . $detail;
        }
    }

    $error = implode(' | ', $errors);
    error_log('[Bosk mailer] ' . $error);
    return ['ok' => false, 'transport' => '', 'error' => $error, 'warning' => ''];
}
