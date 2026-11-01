<?php
/* ============================================================
   Admin > Leads & Enquiries
   ------------------------------------------------------------
   Every enquiry from the website (Contact form, Customize
   Furniture, Blog comments, Newsletter) with status tracking,
   notes, quick Call / WhatsApp / Email actions and CSV export.
   Data: `leads` table, filled by lib/bosk-leads.php
   ============================================================ */
session_start();
include_once "connect.php";
require_once __DIR__ . '/../lib/bosk-leads.php';

$isPost = (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] === 'POST');

if (!bosk_leads_is_admin($con)) {
    if ($isPost) {
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode(['ok' => false, 'msg' => 'Please log in again.']);
        exit;
    }
    // Come back to this lead right after logging in (see back/signin.php).
    $_SESSION['bosk_after_login'] = 'leads.php' . (!empty($_GET['id']) ? '?id=' . (int) $_GET['id'] : '');
    header('Location: index.php');
    exit;
}

$dbReady  = bosk_leads_prepare_db($con);
$statuses = bosk_lead_statuses();
$sources  = bosk_lead_sources();
$mailCfg  = bosk_mail_config();

if (empty($_SESSION['bosk_leads_csrf'])) {
    $_SESSION['bosk_leads_csrf'] = bin2hex(random_bytes(16));
}
$csrf = $_SESSION['bosk_leads_csrf'];

function leads_unread_count($con)
{
    return bosk_leads_scalar($con, "SELECT COUNT(*) FROM leads WHERE is_read = 0 AND status <> 'spam'");
}

/* ------------------------------------------------------------
   AJAX actions (mark read, save status/note, delete)
   ------------------------------------------------------------ */
if ($isPost && isset($_POST['action'])) {
    header('Content-Type: application/json; charset=utf-8');
    if (!$dbReady) {
        echo json_encode(['ok' => false, 'msg' => 'The leads table is not available.']);
        exit;
    }
    if (!hash_equals($csrf, (string) ($_POST['csrf'] ?? ''))) {
        echo json_encode(['ok' => false, 'msg' => 'Your session has expired. Please reload the page.']);
        exit;
    }

    $action = (string) $_POST['action'];
    $id     = (int) ($_POST['id'] ?? 0);

    if ($action === 'mark_read' && $id > 0) {
        $stmt = mysqli_prepare($con, 'UPDATE leads SET is_read = 1 WHERE id = ?');
        mysqli_stmt_bind_param($stmt, 'i', $id);
        $ok = mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        echo json_encode(['ok' => (bool) $ok, 'unread' => leads_unread_count($con)]);
        exit;
    }

    if ($action === 'mark_all_read') {
        $ok = mysqli_query($con, 'UPDATE leads SET is_read = 1 WHERE is_read = 0');
        echo json_encode(['ok' => (bool) $ok, 'msg' => 'All leads marked as read.', 'unread' => 0]);
        exit;
    }

    if ($action === 'save' && $id > 0) {
        $status = (string) ($_POST['status'] ?? '');
        if (!isset($statuses[$status])) {
            echo json_encode(['ok' => false, 'msg' => 'Please choose a valid status.']);
            exit;
        }
        $note   = bosk_lead_clean_text($_POST['admin_note'] ?? '', 2000);
        $noteDb = ($note !== '') ? $note : null;
        $now    = bosk_lead_now();
        $stmt   = mysqli_prepare($con, 'UPDATE leads SET status = ?, admin_note = ?, is_read = 1, updated_at = ? WHERE id = ?');
        mysqli_stmt_bind_param($stmt, 'sssi', $status, $noteDb, $now, $id);
        $ok = mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        echo json_encode([
            'ok'      => (bool) $ok,
            'msg'     => $ok ? 'Lead updated - status: ' . $statuses[$status]['label'] : 'Could not save the lead.',
            'status'  => $status,
            'note'    => $note,
            'updated' => date('d M Y, h:i A', strtotime($now)),
            'unread'  => leads_unread_count($con),
        ]);
        exit;
    }

    if ($action === 'delete' && $id > 0) {
        $file = null;
        $stmt = mysqli_prepare($con, 'SELECT attachment FROM leads WHERE id = ? LIMIT 1');
        mysqli_stmt_bind_param($stmt, 'i', $id);
        if (mysqli_stmt_execute($stmt)) {
            mysqli_stmt_bind_result($stmt, $file);
            mysqli_stmt_fetch($stmt);
        }
        mysqli_stmt_close($stmt);

        $stmt = mysqli_prepare($con, 'DELETE FROM leads WHERE id = ?');
        mysqli_stmt_bind_param($stmt, 'i', $id);
        $ok = mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);

        if ($ok && is_string($file) && preg_match('/^[A-Za-z0-9_]+\.(jpg|png|webp)$/', $file)) {
            @unlink(dirname(__DIR__) . '/lead_attachments/' . $file);
        }
        echo json_encode(['ok' => (bool) $ok, 'msg' => $ok ? 'Lead deleted.' : 'Could not delete the lead.', 'unread' => leads_unread_count($con)]);
        exit;
    }

    echo json_encode(['ok' => false, 'msg' => 'Unknown action.']);
    exit;
}

/* ------------------------------------------------------------
   Filters
   ------------------------------------------------------------ */
$fStatus = (isset($_GET['status']) && isset($statuses[$_GET['status']])) ? $_GET['status'] : '';
$fSource = (isset($_GET['source']) && isset($sources[$_GET['source']])) ? $_GET['source'] : '';

$where = [];
if ($fStatus !== '') {
    $where[] = "status = '" . mysqli_real_escape_string($con, $fStatus) . "'";
}
if ($fSource !== '') {
    $where[] = "source = '" . mysqli_real_escape_string($con, $fSource) . "'";
}
$whereSql = $where ? 'WHERE ' . implode(' AND ', $where) : '';

function leads_filter_url(array $changes)
{
    global $fStatus, $fSource;
    $q = array_merge(['status' => $fStatus, 'source' => $fSource], $changes);
    $q = array_filter($q, function ($v) { return $v !== '' && $v !== null; });
    return 'leads.php' . ($q ? '?' . http_build_query($q) : '');
}

/* ------------------------------------------------------------
   CSV export (respects the current filters)
   ------------------------------------------------------------ */
if (isset($_GET['export']) && $_GET['export'] === 'csv' && $dbReady) {
    $safe = function ($v) {
        $v = (string) $v;
        return ($v !== '' && strpos("=+-@\t\r", $v[0]) !== false) ? "'" . $v : $v;
    };
    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename="bosk-leads-' . date('Y-m-d') . '.csv"');
    $out = fopen('php://output', 'w');
    fwrite($out, "\xEF\xBB\xBF");
    fputcsv($out, ['Reference', 'Received (IST)', 'Source', 'Status', 'Name', 'Email', 'Phone', 'Message', 'Article', 'Attachment', 'Page', 'Device', 'IP', 'Admin Note', 'Owner Email Sent', 'Customer Email Sent'], ',', '"', '');
    $res = mysqli_query($con, "SELECT * FROM leads $whereSql ORDER BY id DESC");
    while ($res && ($r = mysqli_fetch_assoc($res))) {
        fputcsv($out, array_map($safe, [
            bosk_lead_ref($r['id']),
            $r['created_at'],
            isset($sources[$r['source']]) ? $sources[$r['source']]['label'] : $r['source'],
            isset($statuses[$r['status']]) ? $statuses[$r['status']]['label'] : $r['status'],
            $r['name'],
            $r['email'],
            $r['phone'],
            $r['message'],
            $r['context'],
            $r['attachment_name'],
            $r['page_url'],
            bosk_lead_device($r['user_agent']),
            $r['ip_address'],
            $r['admin_note'],
            $r['owner_mail_sent'] ? 'Yes' : 'No',
            $r['customer_mail_sent'] ? 'Yes' : 'No',
        ]), ',', '"', '');
    }
    fclose($out);
    exit;
}

/* ------------------------------------------------------------
   Numbers for the cards, filters and charts
   ------------------------------------------------------------ */
$stats = ['total' => 0, 'unread' => 0, 'today' => 0, 'week' => 0, 'converted' => 0, 'rate' => 0];
$statusCounts = array_fill_keys(array_keys($statuses), 0);
$sourceCounts = array_fill_keys(array_keys($sources), 0);
$trendLabels  = [];
$trendValues  = [];
$leads        = [];

if ($dbReady) {
    $todayStart = (new DateTime('today', new DateTimeZone('Asia/Kolkata')))->format('Y-m-d H:i:s');
    $stats['total']     = bosk_leads_scalar($con, "SELECT COUNT(*) FROM leads WHERE status <> 'spam'");
    $stats['unread']    = leads_unread_count($con);
    $stats['today']     = bosk_leads_scalar($con, "SELECT COUNT(*) FROM leads WHERE status <> 'spam' AND created_at >= ?", 's', [$todayStart]);
    $stats['week']      = bosk_leads_scalar($con, "SELECT COUNT(*) FROM leads WHERE status <> 'spam' AND created_at >= ?", 's', [bosk_lead_now('-7 days')]);
    $stats['converted'] = bosk_leads_scalar($con, "SELECT COUNT(*) FROM leads WHERE status = 'converted'");
    $enquiries          = bosk_leads_scalar($con, "SELECT COUNT(*) FROM leads WHERE status <> 'spam' AND source <> 'newsletter'");
    $stats['rate']      = $enquiries > 0 ? round($stats['converted'] / $enquiries * 100) : 0;

    $res = mysqli_query($con, 'SELECT status, COUNT(*) c FROM leads GROUP BY status');
    while ($res && ($r = mysqli_fetch_assoc($res))) {
        if (isset($statusCounts[$r['status']])) {
            $statusCounts[$r['status']] = (int) $r['c'];
        }
    }
    $res = mysqli_query($con, "SELECT source, COUNT(*) c FROM leads WHERE status <> 'spam' GROUP BY source");
    while ($res && ($r = mysqli_fetch_assoc($res))) {
        if (isset($sourceCounts[$r['source']])) {
            $sourceCounts[$r['source']] = (int) $r['c'];
        }
    }

    // Last 30 days, one bar per day (days without leads = 0)
    $from  = new DateTime('today -29 days', new DateTimeZone('Asia/Kolkata'));
    $daily = [];
    $res   = mysqli_query($con, "SELECT DATE(created_at) d, COUNT(*) c FROM leads WHERE status <> 'spam' AND created_at >= '" . $from->format('Y-m-d') . " 00:00:00' GROUP BY DATE(created_at)");
    while ($res && ($r = mysqli_fetch_assoc($res))) {
        $daily[$r['d']] = (int) $r['c'];
    }
    for ($i = 0; $i < 30; $i++) {
        $key           = $from->format('Y-m-d');
        $trendLabels[] = $from->format('d M');
        $trendValues[] = isset($daily[$key]) ? $daily[$key] : 0;
        $from->modify('+1 day');
    }

    $res = mysqli_query($con, "SELECT * FROM leads $whereSql ORDER BY id DESC LIMIT 1000");
    while ($res && ($r = mysqli_fetch_assoc($res))) {
        $leads[] = $r;
    }
}

// Lead opened from an email link (?id=42) - include it even if filtered out.
$focusId = isset($_GET['id']) ? (int) $_GET['id'] : 0;
$extra   = [];
if ($focusId > 0 && $dbReady) {
    $found = false;
    foreach ($leads as $l) {
        if ((int) $l['id'] === $focusId) {
            $found = true;
            break;
        }
    }
    if (!$found) {
        $res = mysqli_query($con, 'SELECT * FROM leads WHERE id = ' . $focusId . ' LIMIT 1');
        if ($res && ($r = mysqli_fetch_assoc($res))) {
            $extra[] = $r;
        }
    }
}

/** Data handed to the details pop-up (rendered with textContent, never as HTML). */
function leads_js_row(array $r)
{
    global $sources, $statuses;
    $src   = isset($sources[$r['source']]) ? $sources[$r['source']] : ['label' => ucfirst($r['source']), 'icon' => 'icofont-ui-message', 'color' => '#6c757d', 'bg' => '#f1f3f5'];
    $phone = preg_replace('/\D/', '', (string) $r['phone']);
    return [
        'id'            => (int) $r['id'],
        'ref'           => bosk_lead_ref($r['id']),
        'name'          => (string) $r['name'],
        'email'         => (string) $r['email'],
        'phone'         => $phone,
        'phone_display' => $phone !== '' ? bosk_email_phone_display($phone) : '',
        'message'       => (string) $r['message'],
        'context'       => (string) $r['context'],
        'source'        => (string) $r['source'],
        'source_label'  => $src['label'],
        'source_icon'   => $src['icon'],
        'source_color'  => $src['color'],
        'source_bg'     => $src['bg'],
        'status'        => isset($statuses[$r['status']]) ? $r['status'] : 'new',
        'note'          => (string) $r['admin_note'],
        'attachment'    => !empty($r['attachment']),
        'attachment_name' => (string) $r['attachment_name'],
        'page_url'      => preg_match('#^https?://#i', (string) $r['page_url']) ? (string) $r['page_url'] : '',
        'ip'            => (string) $r['ip_address'],
        'device'        => bosk_lead_device($r['user_agent']),
        'created'       => date('d M Y, h:i A', strtotime($r['created_at'])),
        'ago'           => bosk_lead_time_ago($r['created_at']),
        'updated'       => !empty($r['updated_at']) ? date('d M Y, h:i A', strtotime($r['updated_at'])) : '',
        'owner_mail'    => (int) $r['owner_mail_sent'],
        'customer_mail' => (int) $r['customer_mail_sent'],
        'mail_error'    => (string) $r['mail_error'],
        'is_read'       => (int) $r['is_read'],
        'initials'      => bosk_lead_initials($r['name'], $r['email']),
        'color'         => bosk_lead_avatar_color($r['email'] !== '' ? $r['email'] : $r['name']),
    ];
}

$jsLeads = [];
foreach (array_merge($leads, $extra) as $r) {
    $jsLeads[(int) $r['id']] = leads_js_row($r);
}
$jsonFlags = JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_INVALID_UTF8_SUBSTITUTE;
$smtpOn    = bosk_mail_smtp_ready($mailCfg);
?>
<!doctype html>
<html class="no-js" lang="en" dir="ltr">

<head>
    <?php include_once "design/header.php" ?>
    <link rel="stylesheet" href="assets/plugin/datatables/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="toastr/toastr.css">
    <style>
        :root { --bk-brown: #532A1A; --bk-brown-2: #6b3823; --bk-brown-3: #3a1c10; --bk-cream: #fbf7f4; }

        /* ---------- Hero ---------- */
        .leads-hero {
            position: relative; overflow: hidden; color: #fff; border-radius: 18px; padding: 24px 26px;
            background: linear-gradient(135deg, var(--bk-brown-2) 0%, var(--bk-brown) 55%, var(--bk-brown-3) 100%);
            box-shadow: 0 12px 30px rgba(83, 42, 26, .25);
        }
        .leads-hero::before, .leads-hero::after {
            content: ""; position: absolute; border-radius: 50%; background: rgba(255, 255, 255, .07); pointer-events: none;
        }
        .leads-hero::before { width: 260px; height: 260px; right: -70px; top: -120px; }
        .leads-hero::after  { width: 160px; height: 160px; right: 160px; bottom: -110px; }
        .leads-hero .hero-icon {
            flex: 0 0 56px; width: 56px; height: 56px; border-radius: 16px; display: flex; align-items: center; justify-content: center;
            font-size: 26px; background: rgba(255, 255, 255, .16); border: 1px solid rgba(255, 255, 255, .25);
        }
        .leads-hero h3 { color: #fff; margin: 0; font-weight: 800; letter-spacing: .2px; }
        .leads-hero p  { color: rgba(255, 255, 255, .82); margin: 4px 0 0; font-size: 13.5px; }
        .btn-hero {
            position: relative; z-index: 1; background: rgba(255, 255, 255, .14); color: #fff !important; border: 1px solid rgba(255, 255, 255, .32);
            border-radius: 10px; font-weight: 600; font-size: 13px; padding: 8px 14px; transition: all .2s ease;
        }
        .btn-hero:hover { background: #fff; color: var(--bk-brown) !important; }

        .mail-strip {
            display: flex; flex-wrap: wrap; gap: 8px 18px; align-items: center; margin-top: 18px; padding-top: 14px;
            border-top: 1px solid rgba(255, 255, 255, .18); font-size: 12.5px; color: rgba(255, 255, 255, .88); position: relative; z-index: 1;
        }
        .mail-strip b { color: #fff; }
        .mail-strip .chip { display: inline-flex; align-items: center; gap: 6px; padding: 3px 10px; border-radius: 20px; background: rgba(255, 255, 255, .14); }
        .mail-strip .chip.ok  { background: rgba(46, 204, 113, .22); }
        .mail-strip .chip.warn { background: rgba(255, 193, 7, .22); }

        /* ---------- Stat cards ---------- */
        .stat-card { border: 0; border-radius: 14px; overflow: hidden; transition: transform .15s ease, box-shadow .15s ease; box-shadow: 0 2px 12px rgba(0, 0, 0, .05); }
        .stat-card:hover { transform: translateY(-3px); box-shadow: 0 10px 26px rgba(0, 0, 0, .10); }
        .stat-icon { flex: 0 0 48px; width: 48px; height: 48px; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 22px; }
        .stat-value { font-size: 24px; font-weight: 800; line-height: 1; color: #2d2f39; }
        .stat-label { font-size: 12px; letter-spacing: .3px; color: #7a7f8a; margin-top: 4px; }
        .stat-sub   { font-size: 11.5px; color: #1aa260; font-weight: 700; }

        .chart-card { border: 0; border-radius: 14px; box-shadow: 0 2px 12px rgba(0, 0, 0, .05); }
        .chart-card .card-header { background: transparent; border-bottom: 1px solid #f0f2f5; }
        .chart-title { font-weight: 700; color: #2d2f39; margin: 0; font-size: 15px; }
        #chartSource .apexcharts-datalabels text { fill: #ffffff !important; font-weight: 800 !important; }

        /* ---------- Filters ---------- */
        .filter-bar { display: flex; flex-wrap: wrap; gap: 8px; align-items: center; }
        .filter-label { font-size: 11.5px; font-weight: 700; letter-spacing: .6px; text-transform: uppercase; color: #9aa0ab; margin-right: 4px; }
        .filter-pill {
            display: inline-flex; align-items: center; border-radius: 30px; padding: 6px 14px; font-size: 13px; font-weight: 600;
            border: 1px solid #e6e8ee; background: #fff; color: #4b5160 !important; text-decoration: none; transition: all .15s ease;
        }
        .filter-pill:hover { border-color: var(--bk-brown); color: var(--bk-brown) !important; }
        .filter-pill.active { background: var(--bk-brown); border-color: var(--bk-brown); color: #fff !important; box-shadow: 0 6px 14px rgba(83, 42, 26, .22); }
        .filter-pill .count { background: rgba(0, 0, 0, .06); border-radius: 20px; padding: 1px 8px; margin-left: 7px; font-size: 11.5px; }
        .filter-pill.active .count { background: rgba(255, 255, 255, .22); }
        .filter-pill .dot { width: 8px; height: 8px; border-radius: 50%; margin-right: 7px; }

        /* ---------- Table ---------- */
        .leads-card { border: 0; border-radius: 16px; box-shadow: 0 2px 14px rgba(0, 0, 0, .05); }
        #leadsTable thead th { text-transform: uppercase; font-size: 11.5px; letter-spacing: .6px; color: #6c757d; font-weight: 700; white-space: nowrap; border-bottom: 2px solid #eef0f4; }
        #leadsTable td { vertical-align: middle; border-color: #f2f3f6; }
        #leadsTable tbody tr { cursor: pointer; transition: background .12s ease; }
        #leadsTable tbody tr:hover td { background: #f8f6f4; }
        #leadsTable tbody tr.is-unread td { background: #fffaf4; }
        #leadsTable tbody tr.is-unread:hover td { background: #fff3e6; }
        .lead-avatar {
            flex: 0 0 40px; width: 40px; height: 40px; border-radius: 50%; color: #fff; font-weight: 800; font-size: 14px;
            display: flex; align-items: center; justify-content: center; box-shadow: 0 4px 10px rgba(0, 0, 0, .12);
        }
        .lead-name { font-weight: 600; color: #2d2f39; }
        tr.is-unread .lead-name { font-weight: 800; }
        .lead-ref { font-family: SFMono-Regular, Menlo, Consolas, monospace; font-size: 11.5px; color: #9aa0ab; }
        .unread-dot { display: none; width: 8px; height: 8px; border-radius: 50%; background: #ff6b35; box-shadow: 0 0 0 3px rgba(255, 107, 53, .18); margin-left: 6px; }
        tr.is-unread .unread-dot { display: inline-block; }
        .lead-contact a { color: #4b5160; text-decoration: none; font-size: 13px; display: block; white-space: nowrap; }
        .lead-contact a:hover { color: var(--bk-brown); }
        .lead-contact i { color: #b89e92; width: 16px; }
        .lead-msg { color: #6c757d; font-size: 13px; max-width: 330px; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }
        .lead-pill { display: inline-flex; align-items: center; gap: 6px; font-size: 11.5px; font-weight: 700; padding: 4px 10px; border-radius: 20px; white-space: nowrap; }
        .lead-when b { display: block; font-size: 13px; color: #2d2f39; font-weight: 600; white-space: nowrap; }
        .lead-when small { color: #9aa0ab; white-space: nowrap; }
        .lead-actions { white-space: nowrap; }
        .lead-actions .btn { width: 32px; height: 32px; padding: 0; display: inline-flex; align-items: center; justify-content: center; border-radius: 9px; font-size: 15px; }
        .btn-wa { background: #e8f8ef; color: #1faa59; border: 0; }
        .btn-wa:hover { background: #1faa59; color: #fff; }
        .btn-soft { background: #f3f4f7; color: #4b5160; border: 0; }
        .btn-soft:hover { background: var(--bk-brown); color: #fff; }
        .btn-soft-danger { background: #fdeef0; color: #c0392b; border: 0; }
        .btn-soft-danger:hover { background: #c0392b; color: #fff; }

        .empty-state { text-align: center; padding: 50px 20px; color: #7a7f8a; }
        .empty-state .icon { width: 74px; height: 74px; margin: 0 auto 14px; border-radius: 50%; background: var(--bk-cream); color: var(--bk-brown); display: flex; align-items: center; justify-content: center; font-size: 32px; }

        /* ---------- Details pop-up ---------- */
        .lead-modal .modal-content { border: 0; border-radius: 20px; overflow: hidden; }
        .lm-head { position: relative; color: #fff; padding: 24px 26px; background: linear-gradient(135deg, var(--bk-brown-2) 0%, var(--bk-brown) 55%, var(--bk-brown-3) 100%); }
        .lm-close {
            position: absolute; top: 16px; right: 16px; width: 36px; height: 36px; border-radius: 50%; border: 1px solid rgba(255, 255, 255, .3);
            background: rgba(255, 255, 255, .14); color: #fff; font-size: 16px; display: flex; align-items: center; justify-content: center; transition: all .2s ease;
        }
        .lm-close:hover { background: #fff; color: var(--bk-brown); }
        .lm-avatar { flex: 0 0 62px; width: 62px; height: 62px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 22px; font-weight: 800; color: #fff; border: 3px solid rgba(255, 255, 255, .35); }
        .lm-name { font-size: 21px; font-weight: 800; color: #fff; margin: 0; word-break: break-word; }
        .lm-meta { font-size: 12.5px; color: rgba(255, 255, 255, .8); }
        .lm-head .lead-pill { background: rgba(255, 255, 255, .16) !important; color: #fff !important; }
        .lm-section-title { font-size: 11.5px; font-weight: 800; letter-spacing: .8px; text-transform: uppercase; color: #9aa0ab; margin: 0 0 10px; }
        .lm-quote { background: var(--bk-cream); border-left: 4px solid var(--bk-brown); border-radius: 12px; padding: 16px 18px; white-space: pre-wrap; word-break: break-word; font-size: 14.5px; line-height: 1.65; color: #2b2420; max-height: 320px; overflow: auto; }
        .lm-attach { display: flex; align-items: center; gap: 14px; padding: 12px; border: 1px dashed #dcc7b9; border-radius: 12px; background: #fff; }
        .lm-attach img { width: 92px; height: 72px; object-fit: cover; border-radius: 10px; border: 1px solid #eee; }
        .lm-card { border: 1px solid #eef0f4; border-radius: 14px; padding: 16px; background: #fff; }
        .lm-row { display: flex; gap: 10px; align-items: flex-start; padding: 9px 0; border-bottom: 1px dashed #eef0f4; font-size: 13.5px; color: #2d2f39; }
        .lm-row:last-child { border-bottom: 0; }
        .lm-row i { color: var(--bk-brown); font-size: 16px; margin-top: 1px; width: 18px; text-align: center; }
        .lm-row .lbl { display: block; font-size: 11px; color: #9aa0ab; text-transform: uppercase; letter-spacing: .5px; }
        .lm-row .val { word-break: break-word; }
        .lm-row a { color: var(--bk-brown); text-decoration: none; }
        .lm-actions { display: grid; grid-template-columns: repeat(3, 1fr); gap: 8px; }
        .lm-actions .btn { border-radius: 11px; font-weight: 700; font-size: 13px; padding: 10px 6px; display: flex; flex-direction: column; align-items: center; gap: 3px; }
        .lm-actions .btn i { font-size: 18px; }
        .btn-brown { background: var(--bk-brown); color: #fff; border: 0; }
        .btn-brown:hover { background: var(--bk-brown-3); color: #fff; }
        .btn-brown-outline { background: #fff; color: var(--bk-brown); border: 1.5px solid #dcc7b9; }
        .btn-brown-outline:hover { background: var(--bk-brown); color: #fff; border-color: var(--bk-brown); }
        .btn-whatsapp { background: #1faa59; color: #fff; border: 0; }
        .btn-whatsapp:hover { background: #178c48; color: #fff; }
        .btn.disabled-link { opacity: .45; pointer-events: none; }
        .mail-pill { display: inline-flex; align-items: center; gap: 6px; font-size: 12px; font-weight: 700; padding: 4px 10px; border-radius: 20px; }
        .mail-pill.ok   { color: #1aa260; background: #e6f7ee; }
        .mail-pill.fail { color: #c0392b; background: #fdeef0; }
        .status-chooser { display: flex; flex-wrap: wrap; gap: 8px; }
        .status-chooser input { display: none; }
        .status-chooser label {
            cursor: pointer; border-radius: 30px; padding: 6px 14px; font-size: 12.5px; font-weight: 700; border: 1.5px solid #e6e8ee;
            color: #4b5160; background: #fff; transition: all .15s ease; user-select: none;
        }
        .status-chooser label:hover { border-color: #c9ccd4; }
        .copy-btn { border: 0; background: transparent; color: #9aa0ab; padding: 0 4px; }
        .copy-btn:hover { color: var(--bk-brown); }

        @keyframes fadeInUp { from { opacity: 0; transform: translateY(14px); } to { opacity: 1; transform: none; } }
        .anim { animation: fadeInUp .45s ease both; }
        @media (prefers-reduced-motion: reduce) { .anim { animation: none; } }
        @media (max-width: 767px) {
            .leads-hero { padding: 20px; }
            .lm-actions { grid-template-columns: 1fr 1fr 1fr; }
            .lead-msg { max-width: 220px; }
        }
    </style>
</head>

<body>
    <div id="ebazar-layout" class="theme-blue">

        <?php include_once "design/sidebar.php" ?>

        <div class="main px-lg-4 px-md-4">

            <?php include_once "design/nav.php" ?>

            <div class="body d-flex py-3">
                <div class="container-xxl">

                    <!-- Hero -->
                    <div class="leads-hero mb-3 anim">
                        <div class="d-flex flex-wrap align-items-center justify-content-between gap-3">
                            <div class="d-flex align-items-center gap-3">
                                <div class="hero-icon"><i class="icofont-inbox"></i></div>
                                <div>
                                    <h3>Leads &amp; Enquiries</h3>
                                    <p>Every enquiry from your website in one place &mdash; reply fast, convert more.</p>
                                </div>
                            </div>
                            <div class="d-flex flex-wrap gap-2">
                                <button type="button" class="btn btn-hero" onclick="markAllRead()"><i class="icofont-check-circled me-1"></i> Mark all as read</button>
                                <a class="btn btn-hero" href="<?php echo bosk_e(leads_filter_url(['export' => 'csv'])); ?>"><i class="icofont-download me-1"></i> Export CSV</a>
                            </div>
                        </div>
                        <div class="mail-strip">
                            <span class="chip"><i class="icofont-email"></i> Sending from <b><?php echo bosk_e($mailCfg['from_email']); ?></b></span>
                            <span class="chip"><i class="icofont-users-social"></i> Notifications to <b><?php echo bosk_e(implode(', ', $mailCfg['owner_emails']) ?: 'not set'); ?></b></span>
                            <?php if ($smtpOn): ?>
                                <span class="chip ok"><i class="icofont-check-circled"></i> Hostinger SMTP active</span>
                            <?php else: ?>
                                <span class="chip warn"><i class="icofont-info-circle"></i> Using PHP mail() &mdash; add the mailbox password in config/mail.php for best delivery</span>
                            <?php endif; ?>
                        </div>
                    </div>

                    <?php if (!$dbReady): ?>
                        <div class="alert alert-danger">The <b>leads</b> table could not be created automatically. Please run <code>leads_schema.sql</code> in phpMyAdmin.</div>
                    <?php endif; ?>

                    <!-- Stat cards -->
                    <div class="row g-3 mb-3">
                        <div class="col-6 col-md-4 col-xl">
                            <a href="leads.php" class="card stat-card bg-white h-100 text-decoration-none anim">
                                <div class="card-body d-flex align-items-center">
                                    <div class="stat-icon" style="background:#f6ede7;color:#532A1A;"><i class="icofont-inbox"></i></div>
                                    <div class="ms-3"><div class="stat-value"><?php echo number_format($stats['total']); ?></div><div class="stat-label">Total Leads</div></div>
                                </div>
                            </a>
                        </div>
                        <div class="col-6 col-md-4 col-xl">
                            <a href="<?php echo bosk_e(leads_filter_url(['status' => 'new'])); ?>" class="card stat-card bg-white h-100 text-decoration-none anim">
                                <div class="card-body d-flex align-items-center">
                                    <div class="stat-icon" style="background:#fff1e6;color:#d9480f;"><i class="icofont-email"></i></div>
                                    <div class="ms-3"><div class="stat-value" id="statUnread"><?php echo number_format($stats['unread']); ?></div><div class="stat-label">Unread</div></div>
                                </div>
                            </a>
                        </div>
                        <div class="col-6 col-md-4 col-xl">
                            <div class="card stat-card bg-white h-100 anim">
                                <div class="card-body d-flex align-items-center">
                                    <div class="stat-icon" style="background:#eef3ff;color:#3b6fe0;"><i class="icofont-clock-time"></i></div>
                                    <div class="ms-3"><div class="stat-value"><?php echo number_format($stats['today']); ?></div><div class="stat-label">Today</div></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-6 col-md-6 col-xl">
                            <div class="card stat-card bg-white h-100 anim">
                                <div class="card-body d-flex align-items-center">
                                    <div class="stat-icon" style="background:#f3eefe;color:#8b5cf6;"><i class="icofont-ui-calendar"></i></div>
                                    <div class="ms-3"><div class="stat-value"><?php echo number_format($stats['week']); ?></div><div class="stat-label">Last 7 Days</div></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-xl">
                            <a href="<?php echo bosk_e(leads_filter_url(['status' => 'converted'])); ?>" class="card stat-card bg-white h-100 text-decoration-none anim">
                                <div class="card-body d-flex align-items-center">
                                    <div class="stat-icon" style="background:#e6f7ee;color:#1aa260;"><i class="icofont-trophy"></i></div>
                                    <div class="ms-3">
                                        <div class="stat-value"><?php echo number_format($stats['converted']); ?></div>
                                        <div class="stat-label" title="Conversion rate: converted leads out of all enquiries (newsletter and spam excluded)">Converted &middot; <span class="stat-sub"><?php echo (int) $stats['rate']; ?>%</span></div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>

                    <!-- Charts -->
                    <div class="row g-3 mb-3">
                        <div class="col-xl-8">
                            <div class="card chart-card h-100 anim">
                                <div class="card-header py-3"><h6 class="chart-title">Leads <span class="text-muted fw-light">(last 30 days)</span></h6></div>
                                <div class="card-body"><div id="chartTrend"></div></div>
                            </div>
                        </div>
                        <div class="col-xl-4">
                            <div class="card chart-card h-100 anim">
                                <div class="card-header py-3"><h6 class="chart-title">Leads by Source</h6></div>
                                <div class="card-body">
                                    <?php if (array_sum($sourceCounts) > 0): ?>
                                        <div id="chartSource"></div>
                                    <?php else: ?>
                                        <div class="empty-state py-4"><div class="icon"><i class="icofont-chart-growth"></i></div>No leads yet</div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Leads table -->
                    <div class="card leads-card mb-3 anim">
                        <div class="card-body">
                            <div class="filter-bar mb-2">
                                <span class="filter-label">Status</span>
                                <a class="filter-pill <?php echo $fStatus === '' ? 'active' : ''; ?>" href="<?php echo bosk_e(leads_filter_url(['status' => ''])); ?>">All<span class="count"><?php echo array_sum($statusCounts); ?></span></a>
                                <?php foreach ($statuses as $key => $st): ?>
                                    <a class="filter-pill <?php echo $fStatus === $key ? 'active' : ''; ?>" href="<?php echo bosk_e(leads_filter_url(['status' => $key])); ?>">
                                        <span class="dot" style="background:<?php echo $st['color']; ?>;"></span><?php echo bosk_e($st['label']); ?><span class="count"><?php echo (int) $statusCounts[$key]; ?></span>
                                    </a>
                                <?php endforeach; ?>
                            </div>
                            <div class="filter-bar mb-3">
                                <span class="filter-label">Source</span>
                                <a class="filter-pill <?php echo $fSource === '' ? 'active' : ''; ?>" href="<?php echo bosk_e(leads_filter_url(['source' => ''])); ?>">All sources</a>
                                <?php foreach ($sources as $key => $sc): ?>
                                    <a class="filter-pill <?php echo $fSource === $key ? 'active' : ''; ?>" href="<?php echo bosk_e(leads_filter_url(['source' => $key])); ?>">
                                        <i class="<?php echo $sc['icon']; ?> me-1"></i><?php echo bosk_e($sc['label']); ?><span class="count"><?php echo (int) $sourceCounts[$key]; ?></span>
                                    </a>
                                <?php endforeach; ?>
                            </div>

                            <?php if (!$leads): ?>
                                <div class="empty-state">
                                    <div class="icon"><i class="icofont-inbox"></i></div>
                                    <h5 class="fw-bold mb-1">No leads <?php echo ($fStatus || $fSource) ? 'match this filter' : 'yet'; ?></h5>
                                    <p class="mb-0">New enquiries from the Contact, Customize Furniture, Blog and Newsletter forms will appear here instantly.</p>
                                </div>
                            <?php else: ?>
                                <table id="leadsTable" class="table align-middle mb-0" style="width:100%;">
                                    <thead>
                                        <tr>
                                            <th>Lead</th>
                                            <th>Contact</th>
                                            <th>Source</th>
                                            <th>Message</th>
                                            <th>Status</th>
                                            <th>Received</th>
                                            <th class="text-end">Actions</th>
                                            <th>Search</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($leads as $r):
                                            $L  = $jsLeads[(int) $r['id']];
                                            $st = $statuses[$L['status']];
                                            $waText = 'Hello ' . bosk_email_first_name($L['name']) . ', this is Bosk Furniture regarding your enquiry (Ref: ' . $L['ref'] . ').';
                                        ?>
                                            <tr id="lead-row-<?php echo $L['id']; ?>" class="lead-row <?php echo $L['is_read'] ? '' : 'is-unread'; ?>" data-id="<?php echo $L['id']; ?>">
                                                <td>
                                                    <div class="d-flex align-items-center gap-2">
                                                        <div class="lead-avatar" style="background:<?php echo $L['color']; ?>;"><?php echo bosk_e($L['initials']); ?></div>
                                                        <div>
                                                            <div class="lead-name"><?php echo bosk_e($L['name'] !== '' ? $L['name'] : $L['email']); ?><span class="unread-dot" title="Unread"></span></div>
                                                            <div class="lead-ref"><?php echo bosk_e($L['ref']); ?></div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="lead-contact">
                                                    <a href="mailto:<?php echo bosk_e($L['email']); ?>" onclick="event.stopPropagation();"><i class="icofont-email"></i> <?php echo bosk_e($L['email']); ?></a>
                                                    <?php if ($L['phone'] !== ''): ?>
                                                        <a href="tel:+91<?php echo bosk_e($L['phone']); ?>" onclick="event.stopPropagation();"><i class="icofont-phone"></i> <?php echo bosk_e($L['phone_display']); ?></a>
                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                    <span class="lead-pill" style="background:<?php echo $L['source_bg']; ?>;color:<?php echo $L['source_color']; ?>;"><i class="<?php echo $L['source_icon']; ?>"></i> <?php echo bosk_e($L['source_label']); ?></span>
                                                </td>
                                                <td>
                                                    <div class="lead-msg">
                                                        <?php if ($L['attachment']): ?><i class="icofont-attachment text-muted" title="Has attachment"></i> <?php endif; ?>
                                                        <?php echo $L['message'] !== '' ? bosk_e(bosk_email_excerpt($L['message'], 140)) : '<span class="fst-italic">Newsletter subscription</span>'; ?>
                                                    </div>
                                                </td>
                                                <td>
                                                    <span class="lead-pill js-status" style="background:<?php echo $st['bg']; ?>;color:<?php echo $st['color']; ?>;"><?php echo bosk_e($st['label']); ?></span>
                                                </td>
                                                <td class="lead-when" data-order="<?php echo strtotime($r['created_at']); ?>">
                                                    <b><?php echo date('d M Y', strtotime($r['created_at'])); ?></b>
                                                    <small><?php echo date('h:i A', strtotime($r['created_at'])); ?> &middot; <?php echo bosk_e($L['ago']); ?></small>
                                                </td>
                                                <td class="lead-actions text-end">
                                                    <button type="button" class="btn btn-soft" title="View details" onclick="event.stopPropagation(); openLead(<?php echo $L['id']; ?>);"><i class="icofont-eye"></i></button>
                                                    <?php if ($L['phone'] !== ''): ?>
                                                        <a class="btn btn-wa" title="WhatsApp" target="_blank" rel="noopener" href="https://wa.me/91<?php echo bosk_e($L['phone']); ?>?text=<?php echo rawurlencode($waText); ?>" onclick="event.stopPropagation();"><i class="icofont-whatsapp"></i></a>
                                                    <?php endif; ?>
                                                    <button type="button" class="btn btn-soft-danger" title="Delete" onclick="event.stopPropagation(); deleteLead(<?php echo $L['id']; ?>);"><i class="icofont-ui-delete"></i></button>
                                                </td>
                                                <td><?php echo bosk_e($L['ref'] . ' ' . $L['message'] . ' ' . $L['context'] . ' ' . $L['phone']); ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            <?php endif; ?>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <!-- Lead details pop-up -->
    <div class="modal fade lead-modal" id="leadModal" tabindex="-1" aria-labelledby="lmName" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="lm-head">
                    <button type="button" class="lm-close" data-bs-dismiss="modal" aria-label="Close"><i class="icofont-close-line"></i></button>
                    <div class="d-flex align-items-center gap-3 pe-4">
                        <div class="lm-avatar" id="lmAvatar"></div>
                        <div class="flex-fill">
                            <h4 class="lm-name" id="lmName"></h4>
                            <div class="lm-meta mt-1">
                                <span id="lmRef" style="font-family:monospace;font-weight:700;"></span> &middot; <span id="lmWhen"></span>
                            </div>
                            <div class="d-flex flex-wrap gap-2 mt-2">
                                <span class="lead-pill" id="lmSource"></span>
                                <span class="lead-pill" id="lmStatusPill"></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-body p-4">
                    <div class="row g-4">
                        <div class="col-lg-7">
                            <div id="lmMessageWrap" class="mb-4">
                                <p class="lm-section-title" id="lmMessageTitle">Message</p>
                                <div class="lm-quote" id="lmMessage"></div>
                            </div>
                            <div id="lmAttachWrap" class="mb-4">
                                <p class="lm-section-title">Reference image</p>
                                <div class="lm-attach">
                                    <a id="lmAttachLink" href="#" target="_blank" rel="noopener"><img id="lmAttachImg" src="data:," alt="Attachment"></a>
                                    <div class="flex-fill" style="min-width:0;">
                                        <div class="fw-bold text-truncate" id="lmAttachName"></div>
                                        <a id="lmAttachDownload" href="#" class="small" style="color:#532A1A;"><i class="icofont-download"></i> Download</a>
                                    </div>
                                </div>
                            </div>

                            <div class="lm-card">
                                <p class="lm-section-title">Update lead</p>
                                <div class="status-chooser mb-3" id="lmStatusChooser">
                                    <?php foreach ($statuses as $key => $st): ?>
                                        <input type="radio" name="lm_status" id="lm-st-<?php echo $key; ?>" value="<?php echo $key; ?>">
                                        <label for="lm-st-<?php echo $key; ?>" data-color="<?php echo $st['color']; ?>" data-bg="<?php echo $st['bg']; ?>"><?php echo bosk_e($st['label']); ?></label>
                                    <?php endforeach; ?>
                                </div>
                                <label class="form-label small fw-bold" for="lmNote">Internal note <span class="text-muted fw-normal">(only visible to admins)</span></label>
                                <textarea class="form-control" id="lmNote" rows="3" maxlength="2000" placeholder="e.g. Called on Monday, sent quotation for 2 wardrobes, follow up on Friday."></textarea>
                                <div class="d-flex flex-wrap align-items-center justify-content-between gap-2 mt-3">
                                    <small class="text-muted" id="lmUpdated"></small>
                                    <button type="button" class="btn btn-brown px-4" id="lmSave" onclick="saveLead()"><i class="icofont-check-circled me-1"></i> Save changes</button>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-5">
                            <p class="lm-section-title">Quick actions</p>
                            <div class="lm-actions mb-4">
                                <a class="btn btn-brown" id="lmEmailBtn" href="#"><i class="icofont-email"></i> Email</a>
                                <a class="btn btn-brown-outline" id="lmCallBtn" href="#"><i class="icofont-phone"></i> Call</a>
                                <a class="btn btn-whatsapp" id="lmWaBtn" href="#" target="_blank" rel="noopener"><i class="icofont-whatsapp"></i> WhatsApp</a>
                            </div>

                            <div class="lm-card mb-3">
                                <p class="lm-section-title">Contact details</p>
                                <div class="lm-row"><i class="icofont-ui-user"></i><div><span class="lbl">Name</span><span class="val" id="lmNameRow"></span></div></div>
                                <div class="lm-row"><i class="icofont-email"></i><div class="flex-fill"><span class="lbl">Email</span><a class="val" id="lmEmail" href="#"></a><button type="button" class="copy-btn" title="Copy email" onclick="copyText(document.getElementById('lmEmail').textContent)"><i class="icofont-copy"></i></button></div></div>
                                <div class="lm-row" id="lmPhoneRow"><i class="icofont-phone"></i><div class="flex-fill"><span class="lbl">Phone</span><a class="val" id="lmPhone" href="#"></a><button type="button" class="copy-btn" title="Copy phone" onclick="copyText(document.getElementById('lmPhone').textContent)"><i class="icofont-copy"></i></button></div></div>
                            </div>

                            <div class="lm-card mb-3">
                                <p class="lm-section-title">Enquiry details</p>
                                <div class="lm-row"><i class="icofont-clock-time"></i><div><span class="lbl">Received</span><span class="val" id="lmReceived"></span></div></div>
                                <div class="lm-row" id="lmContextRow"><i class="icofont-newspaper"></i><div><span class="lbl">Article</span><span class="val" id="lmContext"></span></div></div>
                                <div class="lm-row" id="lmPageRow"><i class="icofont-ui-browser"></i><div style="min-width:0;"><span class="lbl">Submitted from</span><a class="val" id="lmPage" href="#" target="_blank" rel="noopener noreferrer"></a></div></div>
                                <div class="lm-row" id="lmDeviceRow"><i class="icofont-mobile-phone"></i><div><span class="lbl">Device</span><span class="val" id="lmDevice"></span></div></div>
                                <div class="lm-row" id="lmIpRow"><i class="icofont-globe"></i><div><span class="lbl">IP address</span><span class="val" id="lmIp"></span></div></div>
                            </div>

                            <div class="lm-card">
                                <p class="lm-section-title">Email delivery</p>
                                <div class="d-flex flex-wrap gap-2">
                                    <span class="mail-pill" id="lmOwnerMail"></span>
                                    <span class="mail-pill" id="lmCustomerMail"></span>
                                </div>
                                <div class="small text-danger mt-2" id="lmMailError" style="word-break:break-word;"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-soft-danger px-3" id="lmDelete"><i class="icofont-ui-delete me-1"></i> Delete lead</button>
                    <button type="button" class="btn btn-light border px-4" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <script src="assets/bundles/libscripts.bundle.js"></script>
    <script src="assets/bundles/dataTables.bundle.js"></script>
    <script src="assets/bundles/apexcharts.bundle.js"></script>
    <script src="javascript/template.js?v=2"></script>
    <script src="toastr/toastr.min.js"></script>

    <script>
        var CSRF      = <?php echo json_encode($csrf); ?>;
        var LEADS     = <?php echo json_encode((object) $jsLeads, $jsonFlags); ?>;
        var STATUSES  = <?php echo json_encode($statuses, $jsonFlags); ?>;
        var FOCUS_ID  = <?php echo (int) $focusId; ?>;
        var leadTable = null;
        var leadModal = null;
        var currentId = null;

        toastr.options = { closeButton: true, progressBar: true, positionClass: 'toast-top-right', timeOut: 3500 };

        function $id(id) { return document.getElementById(id); }
        function setText(id, text) { $id(id).textContent = text || ''; }
        function show(id, visible) { $id(id).style.display = visible ? '' : 'none'; }
        function firstName(name) { var p = String(name || '').trim().split(/\s+/); return p[0] || 'there'; }

        function paintPill(el, color, bg) { el.style.color = color; el.style.background = bg; }

        function paintStatusChooser(selected) {
            document.querySelectorAll('#lmStatusChooser label').forEach(function (lbl) {
                var input = $id(lbl.getAttribute('for'));
                var on = input.value === selected;
                input.checked = on;
                lbl.style.background  = on ? lbl.getAttribute('data-bg') : '#fff';
                lbl.style.color       = on ? lbl.getAttribute('data-color') : '#4b5160';
                lbl.style.borderColor = on ? lbl.getAttribute('data-color') : '#e6e8ee';
            });
        }

        function updateUnread(n) {
            n = parseInt(n, 10) || 0;
            if ($id('statUnread')) $id('statUnread').textContent = n;
            document.querySelectorAll('.lead-badge').forEach(function (b) {
                b.textContent = n > 99 ? '99+' : n;
                b.style.display = n > 0 ? '' : 'none';
            });
        }

        function openLead(id) {
            var l = LEADS[id];
            if (!l) return;
            currentId = id;

            var av = $id('lmAvatar');
            av.textContent = l.initials;
            av.style.background = l.color;
            setText('lmName', l.name || l.email);
            setText('lmRef', l.ref);
            setText('lmWhen', l.created + ' (' + l.ago + ')');

            var src = $id('lmSource');
            src.textContent = l.source_label;
            var st = STATUSES[l.status];
            var pill = $id('lmStatusPill');
            pill.textContent = st.label;

            show('lmMessageWrap', !!l.message);
            setText('lmMessageTitle', l.source === 'blog_comment' ? 'Comment' : 'Message');
            setText('lmMessage', l.message);

            show('lmAttachWrap', l.attachment);
            if (l.attachment) {
                var url = 'lead-attachment.php?id=' + l.id;
                $id('lmAttachImg').src = url;
                $id('lmAttachLink').href = url;
                $id('lmAttachDownload').href = url + '&download=1';
                setText('lmAttachName', l.attachment_name || 'Reference image');
            }

            paintStatusChooser(l.status);
            $id('lmNote').value = l.note || '';
            setText('lmUpdated', l.updated ? 'Last updated ' + l.updated : '');

            var subject = 'Re: Your enquiry with Bosk Furniture (Ref: ' + l.ref + ')';
            var greeting = 'Dear ' + (l.name || 'Customer') + ',\n\nThank you for contacting Bosk Furniture.\n\n';
            $id('lmEmailBtn').href = 'mailto:' + l.email + '?subject=' + encodeURIComponent(subject) + '&body=' + encodeURIComponent(greeting);
            var hasPhone = !!l.phone;
            $id('lmCallBtn').href = hasPhone ? 'tel:+91' + l.phone : '#';
            $id('lmWaBtn').href = hasPhone ? 'https://wa.me/91' + l.phone + '?text=' + encodeURIComponent('Hello ' + firstName(l.name) + ', this is Bosk Furniture regarding your enquiry (Ref: ' + l.ref + ').') : '#';
            $id('lmCallBtn').classList.toggle('disabled-link', !hasPhone);
            $id('lmWaBtn').classList.toggle('disabled-link', !hasPhone);

            setText('lmNameRow', l.name || '—');
            setText('lmEmail', l.email);
            $id('lmEmail').href = 'mailto:' + l.email;
            show('lmPhoneRow', hasPhone);
            setText('lmPhone', l.phone_display);
            $id('lmPhone').href = hasPhone ? 'tel:+91' + l.phone : '#';

            setText('lmReceived', l.created + ' · ' + l.ago);
            show('lmContextRow', !!l.context);
            setText('lmContext', l.context);
            var safePage = /^https?:\/\//i.test(l.page_url) ? l.page_url : '';
            show('lmPageRow', !!safePage);
            setText('lmPage', safePage);
            $id('lmPage').href = safePage || '#';
            show('lmDeviceRow', !!l.device);
            setText('lmDevice', l.device);
            show('lmIpRow', !!l.ip);
            setText('lmIp', l.ip);

            var om = $id('lmOwnerMail'), cm = $id('lmCustomerMail');
            om.className = 'mail-pill ' + (l.owner_mail ? 'ok' : 'fail');
            om.textContent = (l.owner_mail ? '✓ ' : '✕ ') + 'Owner notified';
            cm.className = 'mail-pill ' + (l.customer_mail ? 'ok' : 'fail');
            cm.textContent = (l.customer_mail ? '✓ ' : '✕ ') + 'Customer confirmation';
            setText('lmMailError', l.mail_error);

            src.style.background = ''; pill.style.background = '';
            $id('lmDelete').onclick = function () { deleteLead(l.id); };

            leadModal = leadModal || new bootstrap.Modal($id('leadModal'));
            leadModal.show();

            if (!l.is_read) markRead(l.id);
        }

        function markRead(id) {
            $.post('leads.php', { action: 'mark_read', id: id, csrf: CSRF }, function (res) {
                if (res && res.ok) {
                    LEADS[id].is_read = 1;
                    $('#lead-row-' + id).removeClass('is-unread');
                    updateUnread(res.unread);
                }
            }, 'json');
        }

        function markAllRead() {
            $.post('leads.php', { action: 'mark_all_read', csrf: CSRF }, function (res) {
                if (res && res.ok) {
                    Object.keys(LEADS).forEach(function (k) { LEADS[k].is_read = 1; });
                    $('.lead-row').removeClass('is-unread');
                    updateUnread(0);
                    toastr.success(res.msg, 'Done');
                } else {
                    toastr.error((res && res.msg) || 'Something went wrong.', 'Error');
                }
            }, 'json').fail(function () { toastr.error('Network error. Please try again.', 'Error'); });
        }

        function saveLead() {
            if (!currentId) return;
            var checked = document.querySelector('#lmStatusChooser input:checked');
            var btn = $id('lmSave');
            btn.disabled = true;
            $.post('leads.php', {
                action: 'save', id: currentId, csrf: CSRF,
                status: checked ? checked.value : 'new',
                admin_note: $id('lmNote').value
            }, function (res) {
                btn.disabled = false;
                if (!res || !res.ok) { toastr.error((res && res.msg) || 'Could not save.', 'Error'); return; }
                var l = LEADS[currentId];
                l.status = res.status; l.note = res.note; l.updated = res.updated; l.is_read = 1;
                var st = STATUSES[res.status];
                var pill = $id('lmStatusPill');
                pill.textContent = st.label;
                setText('lmUpdated', 'Last updated ' + res.updated);
                var cell = document.querySelector('#lead-row-' + currentId + ' .js-status');
                if (cell) { cell.textContent = st.label; paintPill(cell, st.color, st.bg); }
                $('#lead-row-' + currentId).removeClass('is-unread');
                if (leadTable) leadTable.row('#lead-row-' + currentId).invalidate('dom');
                updateUnread(res.unread);
                toastr.success(res.msg, 'Saved');
            }, 'json').fail(function () { btn.disabled = false; toastr.error('Network error. Please try again.', 'Error'); });
        }

        function deleteLead(id) {
            var l = LEADS[id];
            if (!l || !confirm('Delete lead ' + l.ref + ' (' + (l.name || l.email) + ') permanently?\nThis cannot be undone.')) return;
            $.post('leads.php', { action: 'delete', id: id, csrf: CSRF }, function (res) {
                if (!res || !res.ok) { toastr.error((res && res.msg) || 'Could not delete.', 'Error'); return; }
                if (leadTable) { leadTable.row('#lead-row-' + id).remove().draw(false); } else { $('#lead-row-' + id).remove(); }
                delete LEADS[id];
                if (leadModal && currentId === id) leadModal.hide();
                updateUnread(res.unread);
                toastr.success(res.msg, 'Deleted');
            }, 'json').fail(function () { toastr.error('Network error. Please try again.', 'Error'); });
        }

        function copyText(text) {
            if (!text) return;
            var done = function () { toastr.info('Copied: ' + text); };
            if (navigator.clipboard && window.isSecureContext) {
                navigator.clipboard.writeText(text).then(done);
            } else {
                var ta = document.createElement('textarea');
                ta.value = text; document.body.appendChild(ta); ta.select();
                try { document.execCommand('copy'); done(); } catch (e) { /* ignore */ }
                document.body.removeChild(ta);
            }
        }

        // Status pills inside the pop-up
        document.querySelectorAll('#lmStatusChooser input').forEach(function (input) {
            input.addEventListener('change', function () { paintStatusChooser(input.value); });
        });

        $(function () {
            if ($('#leadsTable').length && $.fn.DataTable) {
                leadTable = $('#leadsTable').DataTable({
                    order: [],
                    pageLength: 25,
                    lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, 'All']],
                    dom: "<'row align-items-center mb-2'<'col-sm-6'l><'col-sm-6'f>><'table-responsive'tr><'row align-items-center mt-2'<'col-sm-5'i><'col-sm-7'p>>",
                    columnDefs: [
                        { targets: [6], orderable: false, searchable: false },
                        { targets: [7], visible: false, searchable: true }
                    ],
                    language: {
                        search: '',
                        searchPlaceholder: 'Search name, email, phone, message…',
                        lengthMenu: 'Show _MENU_ leads',
                        info: 'Showing _START_–_END_ of _TOTAL_ leads',
                        zeroRecords: 'No matching leads found'
                    }
                });
            }

            $('#leadsTable tbody').on('click', 'tr.lead-row', function () {
                openLead(parseInt(this.getAttribute('data-id'), 10));
            });

            if (FOCUS_ID && LEADS[FOCUS_ID]) openLead(FOCUS_ID);

            if (typeof ApexCharts !== 'undefined') {
                if ($id('chartTrend')) {
                    new ApexCharts($id('chartTrend'), {
                        chart: { type: 'area', height: 290, toolbar: { show: false }, fontFamily: 'inherit' },
                        series: [{ name: 'Leads', data: <?php echo json_encode($trendValues); ?> }],
                        xaxis: { categories: <?php echo json_encode($trendLabels); ?>, labels: { rotate: -45, style: { colors: '#9aa0ab' } }, tickAmount: 10 },
                        yaxis: { min: 0, forceNiceScale: true, labels: { formatter: function (v) { return Math.round(v); }, style: { colors: '#9aa0ab' } } },
                        colors: ['#532A1A'],
                        dataLabels: { enabled: false },
                        stroke: { curve: 'smooth', width: 3 },
                        fill: { type: 'gradient', gradient: { shadeIntensity: 1, opacityFrom: 0.45, opacityTo: 0.05, stops: [0, 90, 100] } },
                        grid: { borderColor: '#eef0f4', strokeDashArray: 4 },
                        markers: { size: 3, colors: ['#532A1A'], strokeWidth: 2, strokeColors: '#fff' },
                        tooltip: { theme: 'light' }
                    }).render();
                }
                if ($id('chartSource')) {
                    new ApexCharts($id('chartSource'), {
                        chart: { type: 'donut', height: 300, fontFamily: 'inherit' },
                        series: <?php echo json_encode(array_values($sourceCounts)); ?>,
                        labels: <?php echo json_encode(array_values(array_map(function ($s) { return $s['label']; }, $sources))); ?>,
                        colors: <?php echo json_encode(array_values(array_map(function ($s) { return $s['color']; }, $sources))); ?>,
                        legend: { position: 'bottom', fontSize: '13px' },
                        dataLabels: { enabled: true, formatter: function (v) { return Math.round(v) + '%'; }, style: { fontSize: '12px', fontWeight: 800, colors: ['#ffffff'] }, dropShadow: { enabled: true, top: 1, left: 1, blur: 2, color: '#000000', opacity: 0.45 } },
                        plotOptions: { pie: { donut: { size: '62%', labels: { show: true, total: { show: true, label: 'Total', formatter: function (w) { return w.globals.seriesTotals.reduce(function (a, b) { return a + b; }, 0); } } } } } },
                        stroke: { width: 3, colors: ['#fff'] }
                    }).render();
                }
            }
        });
    </script>
</body>

</html>
