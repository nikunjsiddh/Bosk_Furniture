<?php
/* ============================================================
   Bosk Furniture - Branded HTML email templates
   ------------------------------------------------------------
   Table-based, inline-styled markup so the emails render well in
   Gmail, Outlook, Apple Mail and mobile apps.
     bosk_email_for_customer($lead) -> thank-you / welcome email
     bosk_email_for_owner($lead)    -> new-lead notification
   Both return ['subject' => ..., 'html' => ..., 'text' => ...].
   ============================================================ */

require_once __DIR__ . '/bosk-mailer.php';

if (!function_exists('bosk_e')) {
    function bosk_e($value)
    {
        return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
    }
}

/** "Ravi Kumar Patel" -> "Ravi" */
function bosk_email_first_name($name)
{
    $name  = trim((string) $name);
    $parts = preg_split('/\s+/', $name);
    return ($parts && $parts[0] !== '') ? $parts[0] : 'there';
}

/** Shortens long text for previews without cutting multi-byte characters. */
function bosk_email_excerpt($text, $limit)
{
    $text = trim(preg_replace('/\s+/u', ' ', (string) $text));
    if (mb_strlen($text, 'UTF-8') <= $limit) {
        return $text;
    }
    return rtrim(mb_substr($text, 0, $limit - 1, 'UTF-8')) . '…';
}

/** "2026-11-01 17:45:00" -> "01 Nov 2026, 05:45 PM IST" */
function bosk_email_datetime($datetime)
{
    $ts = strtotime((string) $datetime);
    return $ts ? date('d M Y, h:i A', $ts) . ' IST' : '';
}

/** 9876543210 -> "+91 98765 43210" */
function bosk_email_phone_display($phone)
{
    $digits = preg_replace('/\D/', '', (string) $phone);
    if (strlen($digits) === 10) {
        return '+91 ' . substr($digits, 0, 5) . ' ' . substr($digits, 5);
    }
    return (string) $phone;
}

/** Bulletproof (table based) call-to-action button. */
function bosk_email_button($url, $label, $variant = 'primary')
{
    $styles = [
        'primary'  => ['bg' => '#532A1A', 'color' => '#ffffff', 'border' => '#532A1A'],
        'whatsapp' => ['bg' => '#1faa59', 'color' => '#ffffff', 'border' => '#1faa59'],
        'outline'  => ['bg' => '#ffffff', 'color' => '#532A1A', 'border' => '#d9c6b8'],
    ];
    $s = isset($styles[$variant]) ? $styles[$variant] : $styles['primary'];

    return '<table role="presentation" cellpadding="0" cellspacing="0" border="0" class="bf-btn" style="display:inline-block;margin:0 6px 10px 0;">'
        . '<tr><td align="center" bgcolor="' . $s['bg'] . '" style="border-radius:10px;background-color:' . $s['bg'] . ';border:1.5px solid ' . $s['border'] . ';">'
        . '<a href="' . bosk_e($url) . '" target="_blank" style="display:inline-block;padding:12px 22px;font-family:\'Segoe UI\',Roboto,Helvetica,Arial,sans-serif;font-size:14px;font-weight:700;letter-spacing:.3px;color:' . $s['color'] . ';text-decoration:none;border-radius:10px;">'
        . $label
        . '</a></td></tr></table>';
}

/** Label / value rows. Values must already be escaped HTML. */
function bosk_email_detail_rows(array $rows)
{
    $html = '<table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" style="border:1px solid #eadfd6;border-radius:12px;border-collapse:separate;overflow:hidden;">';
    $i = 0;
    foreach ($rows as $row) {
        $border = ($i++ > 0) ? 'border-top:1px solid #f1e8e1;' : '';
        $html .= '<tr>'
            . '<td class="bf-stack" width="34%" valign="top" style="' . $border . 'padding:12px 16px;background-color:#fbf7f4;font-family:\'Segoe UI\',Roboto,Helvetica,Arial,sans-serif;font-size:12px;font-weight:700;letter-spacing:.6px;text-transform:uppercase;color:#8a7466;">' . bosk_e($row[0]) . '</td>'
            . '<td class="bf-stack" valign="top" style="' . $border . 'padding:12px 16px;font-family:\'Segoe UI\',Roboto,Helvetica,Arial,sans-serif;font-size:14px;line-height:21px;color:#2b2420;word-break:break-word;">' . $row[1] . '</td>'
            . '</tr>';
    }
    return $html . '</table>';
}

function bosk_email_section_title($title)
{
    return '<h3 style="margin:0 0 12px;font-family:Georgia,\'Times New Roman\',serif;font-size:18px;line-height:24px;color:#532A1A;">' . bosk_e($title) . '</h3>';
}

/**
 * Shared shell: logo header, brown hero band, white content, cream footer.
 *  $o = [title, preheader, hero_badge, hero_title, hero_sub, content, footer_note]
 */
function bosk_email_layout(array $o)
{
    $cfg  = bosk_mail_config();
    $site = rtrim($cfg['site_url'], '/');
    $font = "'Segoe UI',Roboto,Helvetica,Arial,sans-serif";

    $badge = '';
    if (!empty($o['hero_badge'])) {
        $badge = '<div style="margin:0 0 12px;"><span style="display:inline-block;padding:5px 12px;border-radius:30px;background-color:#f6e7d8;color:#532A1A;font-family:' . $font . ';font-size:11px;font-weight:800;letter-spacing:1.4px;text-transform:uppercase;">' . bosk_e($o['hero_badge']) . '</span></div>';
    }

    $footerNote = !empty($o['footer_note'])
        ? '<p style="margin:14px 0 0;font-family:' . $font . ';font-size:12px;line-height:18px;color:#9a8678;">' . $o['footer_note'] . '</p>'
        : '';

    $preheaderPad = str_repeat('&#8199;&#65279;&#847; ', 40);

    return '<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="x-apple-disable-message-reformatting">
<meta name="color-scheme" content="light">
<meta name="supported-color-schemes" content="light">
<title>' . bosk_e($o['title']) . '</title>
<style>
  body{margin:0;padding:0;width:100%!important;-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%;}
  table,td{mso-table-lspace:0pt;mso-table-rspace:0pt;}
  img{border:0;outline:none;text-decoration:none;-ms-interpolation-mode:bicubic;}
  a{color:#532A1A;}
  @media only screen and (max-width:620px){
    .bf-container{width:100%!important;border-radius:0!important;}
    .bf-px{padding-left:22px!important;padding-right:22px!important;}
    .bf-hero-title{font-size:25px!important;line-height:31px!important;}
    .bf-stack{display:block!important;width:100%!important;box-sizing:border-box;}
    .bf-btn{display:table!important;width:100%!important;margin:0 0 10px 0!important;}
    .bf-btn td{width:100%!important;}
    .bf-btn a{display:block!important;box-sizing:border-box;text-align:center!important;}
    .bf-ref td{display:block!important;width:100%!important;box-sizing:border-box;}
  }
</style>
</head>
<body style="margin:0;padding:0;background-color:#f3ede7;">
<div style="display:none;max-height:0;max-width:0;overflow:hidden;opacity:0;color:transparent;mso-hide:all;font-size:1px;line-height:1px;">' . bosk_e($o['preheader']) . $preheaderPad . '</div>
<table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" bgcolor="#f3ede7" style="background-color:#f3ede7;">
<tr><td align="center" style="padding:28px 12px 36px;">

  <table role="presentation" class="bf-container" width="600" cellpadding="0" cellspacing="0" border="0" style="width:600px;max-width:600px;background-color:#ffffff;border-radius:18px;overflow:hidden;box-shadow:0 8px 28px rgba(83,42,26,.10);">
    <tr><td height="6" bgcolor="#532A1A" style="height:6px;line-height:6px;font-size:6px;background-color:#532A1A;">&nbsp;</td></tr>
    <tr><td align="center" style="padding:22px 24px 18px;background-color:#ffffff;">
      <a href="' . bosk_e($site) . '" target="_blank" style="text-decoration:none;">
        <img src="' . bosk_e($cfg['logo_url']) . '" width="150" height="80" alt="BOSK FURNITURE" style="display:block;width:150px;height:80px;border:0;font-family:Georgia,serif;font-size:22px;font-weight:bold;letter-spacing:3px;color:#532A1A;">
      </a>
    </td></tr>
    <tr><td class="bf-px" align="center" bgcolor="#532A1A" style="padding:34px 40px 32px;background-color:#532A1A;background-image:linear-gradient(135deg,#6b3823 0%,#532A1A 55%,#3a1c10 100%);text-align:center;">
      ' . $badge . '
      <h1 class="bf-hero-title" style="margin:0;font-family:Georgia,\'Times New Roman\',serif;font-size:30px;line-height:37px;font-weight:700;color:#ffffff;">' . bosk_e($o['hero_title']) . '</h1>
      <p style="margin:10px 0 0;font-family:' . $font . ';font-size:15px;line-height:22px;color:#f1e4da;">' . bosk_e($o['hero_sub']) . '</p>
    </td></tr>

    ' . $o['content'] . '

    <tr><td class="bf-px" style="padding:26px 40px 30px;background-color:#faf6f2;border-top:1px solid #efe5dd;text-align:center;">
      <p style="margin:0 0 6px;font-family:Georgia,\'Times New Roman\',serif;font-size:16px;font-weight:700;color:#532A1A;">' . bosk_e($cfg['company_name']) . '</p>
      <p style="margin:0 0 12px;font-family:' . $font . ';font-size:12px;line-height:18px;color:#8a7466;">' . bosk_e($cfg['company_address']) . '</p>
      <p style="margin:0;font-family:' . $font . ';font-size:13px;line-height:24px;color:#5b4a40;">
        <span style="display:inline-block;margin:0 9px;white-space:nowrap;">&#9993;&nbsp;<a href="mailto:' . bosk_e($cfg['from_email']) . '" style="color:#532A1A;font-weight:700;text-decoration:none;">' . bosk_e($cfg['from_email']) . '</a></span>
        <span style="display:inline-block;margin:0 9px;white-space:nowrap;">&#9742;&nbsp;<a href="tel:' . bosk_e($cfg['phone_link']) . '" style="color:#532A1A;text-decoration:none;">' . bosk_e($cfg['phone_display']) . '</a></span>
        <span style="display:inline-block;margin:0 9px;white-space:nowrap;">&#127968;&nbsp;<a href="' . bosk_e($site) . '" target="_blank" style="color:#532A1A;text-decoration:none;">www.boskfurniture.com</a></span>
      </p>
      ' . $footerNote . '
    </td></tr>
  </table>

  <p style="margin:18px 0 0;font-family:' . $font . ';font-size:11px;line-height:16px;color:#a8968a;">&copy; ' . date('Y') . ' ' . bosk_e($cfg['company_legal']) . '. All rights reserved.</p>

</td></tr>
</table>
</body>
</html>';
}

/* ------------------------------------------------------------
   Copy that changes with the form the visitor used
   ------------------------------------------------------------ */
function bosk_email_customer_copy($lead)
{
    $cfg    = bosk_mail_config();
    $within = $cfg['reply_within'];
    $first  = bosk_email_first_name($lead['name']);
    $ref    = $lead['reference'];

    switch ($lead['source']) {
        case 'customize':
            return [
                'subject'    => 'Your custom furniture request is received (Ref: ' . $ref . ')',
                'preheader'  => 'Our designers have your requirement and will call you within ' . $within . '.',
                'hero_title' => 'Thank you, ' . $first . '!',
                'hero_sub'   => 'Your custom furniture request is with our designers.',
                'intro'      => 'Thank you for your interest in made-to-measure furniture from Bosk. Our designers have received your requirement and will call you within <strong>' . bosk_e($within) . '</strong> to discuss size, material, finish and budget.',
                'steps'      => true,
            ];
        case 'blog_comment':
            $about = !empty($lead['context']) ? ' on &ldquo;' . bosk_e($lead['context']) . '&rdquo;' : '';
            return [
                'subject'    => 'Thanks for your comment - Bosk Furniture',
                'preheader'  => 'We have received your comment. Our team reads every message.',
                'hero_title' => 'Thanks for your comment, ' . $first . '!',
                'hero_sub'   => 'Your thoughts mean a lot to us.',
                'intro'      => 'Thank you for taking the time to share your thoughts' . $about . '. Our team reads every comment &mdash; if you have asked a question, we will get back to you shortly.',
                'steps'      => false,
            ];
        case 'newsletter':
            return [
                'subject'    => "Welcome to Bosk Furniture - you're subscribed!",
                'preheader'  => 'New designs, seasonal offers and interior ideas - straight to your inbox.',
                'hero_title' => 'Welcome to the Bosk family!',
                'hero_sub'   => 'You are now subscribed to our newsletter.',
                'intro'      => 'Thank you for subscribing to the Bosk Furniture newsletter. You will be the first to hear about:',
                'steps'      => false,
            ];
        default:
            return [
                'subject'    => 'Thank you for contacting Bosk Furniture (Ref: ' . $ref . ')',
                'preheader'  => 'We have received your enquiry. Our design team will contact you within ' . $within . '.',
                'hero_title' => 'Thank you, ' . $first . '!',
                'hero_sub'   => 'We have received your enquiry.',
                'intro'      => 'Thank you for reaching out to Bosk Furniture. Your enquiry has reached our design team and one of our experts will get in touch with you within <strong>' . bosk_e($within) . '</strong>.',
                'steps'      => true,
            ];
    }
}

/* ------------------------------------------------------------
   1) CUSTOMER EMAIL
   ------------------------------------------------------------ */
function bosk_email_for_customer(array $lead)
{
    $cfg   = bosk_mail_config();
    $site  = rtrim($cfg['site_url'], '/');
    $font  = "'Segoe UI',Roboto,Helvetica,Arial,sans-serif";
    $copy  = bosk_email_customer_copy($lead);
    $isNews = ($lead['source'] === 'newsletter');
    $when  = bosk_email_datetime($lead['created_at']);
    $wa    = 'https://wa.me/' . $cfg['whatsapp_number'] . '?text=' . rawurlencode('Hello Bosk Furniture, I have submitted an enquiry on your website (Ref: ' . $lead['reference'] . ').');

    $c  = '';
    $greeting = $isNews ? 'Hello,' : 'Dear ' . bosk_e($lead['name']) . ',';
    $c .= '<tr><td class="bf-px" style="padding:30px 40px 6px;font-family:' . $font . ';font-size:15px;line-height:25px;color:#3d332d;">'
        . '<p style="margin:0 0 14px;">' . $greeting . '</p>'
        . '<p style="margin:0;">' . $copy['intro'] . '</p>'
        . '</td></tr>';

    if ($isNews) {
        $perks = [
            ['&#10022;', 'New collections &amp; designs', 'Fresh wardrobes, kitchens, beds and living room pieces.'],
            ['&#10022;', 'Seasonal offers &amp; exclusive discounts', 'Subscriber-only deals before anyone else.'],
            ['&#10022;', 'Interior ideas &amp; care tips', 'Inspiration and simple ways to keep your furniture new.'],
        ];
        $rows = '';
        foreach ($perks as $p) {
            $rows .= '<tr><td width="34" valign="top" style="padding:8px 0;font-size:16px;color:#b07a52;">' . $p[0] . '</td>'
                . '<td style="padding:8px 0;font-family:' . $font . ';"><strong style="display:block;font-size:14px;color:#2b2420;">' . $p[1] . '</strong>'
                . '<span style="font-size:13px;line-height:19px;color:#7a6a60;">' . $p[2] . '</span></td></tr>';
        }
        $c .= '<tr><td class="bf-px" style="padding:14px 40px 4px;"><table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0">' . $rows . '</table></td></tr>';
        $c .= '<tr><td class="bf-px" align="center" style="padding:18px 40px 8px;text-align:center;">'
            . bosk_email_button($site . '/all_products', 'Explore Our Collection &rarr;', 'primary')
            . '</td></tr>';
    } else {
        // Reference card
        $c .= '<tr><td class="bf-px" style="padding:22px 40px 6px;">'
            . '<table role="presentation" class="bf-ref" width="100%" cellpadding="0" cellspacing="0" border="0" style="border-radius:14px;background-color:#fbf4ee;border:1px dashed #d9bfae;border-collapse:separate;">'
            . '<tr>'
            . '<td width="50%" style="padding:16px 20px;font-family:' . $font . ';">'
            . '<span style="display:block;font-size:11px;font-weight:700;letter-spacing:1.2px;text-transform:uppercase;color:#9a8678;">Reference No.</span>'
            . '<span style="display:block;margin-top:4px;font-family:\'Courier New\',monospace;font-size:20px;font-weight:700;color:#532A1A;letter-spacing:1px;">' . bosk_e($lead['reference']) . '</span></td>'
            . '<td width="50%" style="padding:16px 20px;font-family:' . $font . ';">'
            . '<span style="display:block;font-size:11px;font-weight:700;letter-spacing:1.2px;text-transform:uppercase;color:#9a8678;">Received On</span>'
            . '<span style="display:block;margin-top:6px;font-size:14px;font-weight:600;color:#2b2420;">' . bosk_e($when) . '</span></td>'
            . '</tr></table>'
            . '<p style="margin:8px 2px 0;font-family:' . $font . ';font-size:12px;color:#9a8678;">Please quote this reference number when you contact us.</p>'
            . '</td></tr>';

        // Summary
        $rows = [
            ['Name', bosk_e($lead['name'])],
            ['Email', bosk_e($lead['email'])],
        ];
        if (!empty($lead['phone'])) {
            $rows[] = ['Phone', bosk_e(bosk_email_phone_display($lead['phone']))];
        }
        $rows[] = ['Enquiry Type', bosk_e($lead['source_label'])];
        if (!empty($lead['context'])) {
            $rows[] = ['Article', bosk_e($lead['context'])];
        }
        if (!empty($lead['message'])) {
            $rows[] = [$lead['source'] === 'blog_comment' ? 'Your Comment' : 'Your Message', nl2br(bosk_e(bosk_email_excerpt($lead['message'], 600)))];
        }
        if (!empty($lead['attachment_name'])) {
            $rows[] = ['Attachment', '&#128206; ' . bosk_e($lead['attachment_name'])];
        }
        $c .= '<tr><td class="bf-px" style="padding:24px 40px 4px;">'
            . bosk_email_section_title($lead['source'] === 'blog_comment' ? 'Your comment' : 'Your enquiry summary')
            . bosk_email_detail_rows($rows)
            . '</td></tr>';

        // What happens next
        if ($copy['steps']) {
            $steps = [
                ['1', 'We review your requirement', 'A Bosk design expert studies your message and any reference you shared.'],
                ['2', 'We call you', 'We discuss your space, style, material, finish and budget.'],
                ['3', 'Design &amp; quotation', 'You receive a personalised design suggestion and a transparent quote.'],
            ];
            $rows = '';
            foreach ($steps as $s) {
                $rows .= '<tr>'
                    . '<td width="46" valign="top" style="padding:0 0 16px;">'
                    . '<div style="width:32px;height:32px;line-height:32px;border-radius:50%;background-color:#532A1A;color:#ffffff;text-align:center;font-family:' . $font . ';font-size:14px;font-weight:800;">' . $s[0] . '</div></td>'
                    . '<td valign="top" style="padding:0 0 16px;font-family:' . $font . ';">'
                    . '<strong style="display:block;font-size:14px;line-height:20px;color:#2b2420;">' . $s[1] . '</strong>'
                    . '<span style="display:block;font-size:13px;line-height:19px;color:#7a6a60;">' . $s[2] . '</span></td>'
                    . '</tr>';
            }
            $c .= '<tr><td class="bf-px" style="padding:26px 40px 0;">'
                . bosk_email_section_title('What happens next?')
                . '<table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0">' . $rows . '</table>'
                . '</td></tr>';
        }

        // Quick help
        $c .= '<tr><td class="bf-px" style="padding:14px 40px 4px;">'
            . '<table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" style="border-radius:14px;background-color:#f7f1ec;border-collapse:separate;">'
            . '<tr><td style="padding:20px 22px 12px;font-family:' . $font . ';">'
            . '<strong style="display:block;font-size:15px;color:#2b2420;margin-bottom:4px;">Need help sooner?</strong>'
            . '<span style="display:block;font-size:13px;line-height:19px;color:#7a6a60;margin-bottom:14px;">Chat with us on WhatsApp or give us a call &mdash; we are happy to help.</span>'
            . bosk_email_button($wa, '&#128172;&nbsp; WhatsApp Us', 'whatsapp')
            . bosk_email_button('tel:' . $cfg['phone_link'], '&#9742;&nbsp; ' . bosk_e($cfg['phone_display']), 'outline')
            . '</td></tr></table>'
            . '</td></tr>';

        $c .= '<tr><td class="bf-px" align="center" style="padding:20px 40px 0;text-align:center;">'
            . bosk_email_button($site . '/all_products', 'Explore Our Collection &rarr;', 'primary')
            . '</td></tr>';
    }

    $c .= '<tr><td class="bf-px" style="padding:22px 40px 30px;font-family:' . $font . ';font-size:15px;line-height:24px;color:#3d332d;">'
        . 'Warm regards,<br><strong style="color:#532A1A;">Team Bosk Furniture</strong><br>'
        . '<a href="mailto:' . bosk_e($cfg['from_email']) . '" style="font-size:13px;color:#8a7466;text-decoration:none;">' . bosk_e($cfg['from_email']) . '</a>'
        . '</td></tr>';

    $footerNote = $isNews
        ? 'You are receiving this email because you subscribed on boskfurniture.com. Do not want these emails? Simply reply with &ldquo;Unsubscribe&rdquo;.'
        : 'This is an automatic confirmation of the form you submitted on boskfurniture.com. You can reply to this email to reach our team.';

    $html = bosk_email_layout([
        'title'       => $copy['subject'],
        'preheader'   => $copy['preheader'],
        'hero_badge'  => $isNews ? 'Newsletter' : 'Enquiry Received',
        'hero_title'  => $copy['hero_title'],
        'hero_sub'    => $copy['hero_sub'],
        'content'     => $c,
        'footer_note' => $footerNote,
    ]);

    // Plain-text version
    $t  = $copy['hero_title'] . "\n";
    $t .= $copy['hero_sub'] . "\n\n";
    $t .= ($isNews ? 'Hello,' : 'Dear ' . $lead['name'] . ',') . "\n\n";
    $t .= html_entity_decode(strip_tags($copy['intro']), ENT_QUOTES, 'UTF-8') . "\n\n";
    if ($isNews) {
        $t .= "- New collections & designs\n- Seasonal offers & exclusive discounts\n- Interior ideas & furniture care tips\n\n";
    } else {
        $t .= 'Reference No.: ' . $lead['reference'] . "\n";
        $t .= 'Received On : ' . $when . "\n";
        $t .= 'Enquiry Type: ' . $lead['source_label'] . "\n";
        if (!empty($lead['message'])) {
            $t .= "\nYour message:\n" . bosk_email_excerpt($lead['message'], 600) . "\n";
        }
        $t .= "\nNeed help sooner?\nWhatsApp: " . $cfg['whatsapp_display'] . "\nCall: " . $cfg['phone_display'] . "\n";
    }
    $t .= "\nExplore our collection: " . $site . "/all_products\n\nWarm regards,\nTeam Bosk Furniture\n" . $cfg['from_email'] . "\n" . $cfg['company_address'] . "\n";

    return ['subject' => $copy['subject'], 'html' => $html, 'text' => $t];
}

/* ------------------------------------------------------------
   2) WEBSITE OWNER EMAIL (new lead notification)
   ------------------------------------------------------------ */
function bosk_email_for_owner(array $lead)
{
    $cfg    = bosk_mail_config();
    $font   = "'Segoe UI',Roboto,Helvetica,Arial,sans-serif";
    $isNews = ($lead['source'] === 'newsletter');
    $when   = bosk_email_datetime($lead['created_at']);
    $who    = $lead['name'] !== '' ? $lead['name'] : $lead['email'];
    $phone  = preg_replace('/\D/', '', (string) $lead['phone']);

    $subject = $isNews
        ? 'New Newsletter Subscriber: ' . $lead['email'] . ' [' . $lead['reference'] . ']'
        : 'New Lead: ' . $who . ' - ' . $lead['source_label'] . ' [' . $lead['reference'] . ']';

    $preheader = $isNews
        ? $lead['email'] . ' subscribed to the newsletter.'
        : $who . ($phone ? ' (' . bosk_email_phone_display($phone) . ')' : '') . ' via ' . $lead['source_label'] . ': ' . bosk_email_excerpt($lead['message'], 90);

    $replySubject = 'Re: Your enquiry with Bosk Furniture (Ref: ' . $lead['reference'] . ')';
    $mailto = 'mailto:' . $lead['email'] . '?subject=' . rawurlencode($replySubject);

    $c = '';

    // Quick actions
    $actions = bosk_email_button($mailto, '&#9993;&nbsp; Reply by Email', 'primary');
    if ($phone !== '') {
        $actions .= bosk_email_button('tel:+91' . $phone, '&#9742;&nbsp; Call ' . bosk_e(bosk_email_phone_display($phone)), 'outline');
        $waText   = 'Hello ' . bosk_email_first_name($lead['name']) . ', this is Bosk Furniture regarding your enquiry (Ref: ' . $lead['reference'] . ').';
        $actions .= bosk_email_button('https://wa.me/91' . $phone . '?text=' . rawurlencode($waText), '&#128172;&nbsp; WhatsApp', 'whatsapp');
    }
    $c .= '<tr><td class="bf-px" align="center" style="padding:26px 40px 6px;text-align:center;">' . $actions . '</td></tr>';

    // Message
    if (!empty($lead['message'])) {
        $c .= '<tr><td class="bf-px" style="padding:16px 40px 4px;">'
            . bosk_email_section_title($lead['source'] === 'blog_comment' ? 'Comment' : 'Message')
            . '<table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" style="border-collapse:separate;"><tr>'
            . '<td width="4" bgcolor="#532A1A" style="width:4px;background-color:#532A1A;border-radius:4px;">&nbsp;</td>'
            . '<td style="padding:16px 18px;background-color:#fbf7f4;font-family:' . $font . ';font-size:15px;line-height:24px;color:#2b2420;word-break:break-word;">'
            . nl2br(bosk_e($lead['message']))
            . '</td></tr></table></td></tr>';
    }

    // Details
    $rows = [];
    if ($lead['name'] !== '') {
        $rows[] = ['Name', '<strong>' . bosk_e($lead['name']) . '</strong>'];
    }
    $rows[] = ['Email', '<a href="' . bosk_e($mailto) . '" style="color:#532A1A;font-weight:600;">' . bosk_e($lead['email']) . '</a>'];
    if ($phone !== '') {
        $rows[] = ['Phone', '<a href="tel:+91' . bosk_e($phone) . '" style="color:#532A1A;font-weight:600;text-decoration:none;">' . bosk_e(bosk_email_phone_display($phone)) . '</a>'];
    }
    $rows[] = ['Source', bosk_e($lead['source_label'])];
    if (!empty($lead['context'])) {
        $rows[] = ['Article', bosk_e($lead['context'])];
    }
    if (!empty($lead['attachment_name'])) {
        $att = '&#128206; ' . bosk_e($lead['attachment_name']) . ' <span style="color:#8a7466;">(attached to this email)</span>';
        if (!empty($lead['attachment_url'])) {
            $att .= '<br><a href="' . bosk_e($lead['attachment_url']) . '" target="_blank" style="color:#532A1A;font-size:13px;">View image online</a>';
        }
        $rows[] = ['Attachment', $att];
    }
    $rows[] = ['Received', bosk_e($when)];
    $rows[] = ['Reference', '<span style="font-family:\'Courier New\',monospace;font-weight:700;color:#532A1A;">' . bosk_e($lead['reference']) . '</span>'];

    $c .= '<tr><td class="bf-px" style="padding:22px 40px 4px;">'
        . bosk_email_section_title($isNews ? 'Subscriber details' : 'Lead details')
        . bosk_email_detail_rows($rows)
        . '</td></tr>';

    // Admin panel
    if (!empty($lead['admin_url'])) {
        $c .= '<tr><td class="bf-px" align="center" style="padding:24px 40px 4px;text-align:center;">'
            . bosk_email_button($lead['admin_url'], 'Open in Admin Panel &rarr;', 'primary')
            . '<p style="margin:4px 0 0;font-family:' . $font . ';font-size:12px;color:#9a8678;">Update the status, add notes and track this lead in Admin &rsaquo; Leads &amp; Enquiries.</p>'
            . '</td></tr>';
    }

    // Technical info
    $meta = [];
    if (!empty($lead['page_url'])) {
        $meta[] = 'Page: ' . bosk_e($lead['page_url']);
    }
    if (!empty($lead['device'])) {
        $meta[] = 'Device: ' . bosk_e($lead['device']);
    }
    if (!empty($lead['ip'])) {
        $meta[] = 'IP: ' . bosk_e($lead['ip']);
    }
    if ($meta) {
        $c .= '<tr><td class="bf-px" style="padding:20px 40px 4px;font-family:' . $font . ';font-size:12px;line-height:19px;color:#9a8678;word-break:break-all;">' . implode('<br>', $meta) . '</td></tr>';
    }
    $c .= '<tr><td style="padding:0 0 26px;font-size:1px;line-height:1px;">&nbsp;</td></tr>';

    $html = bosk_email_layout([
        'title'       => $subject,
        'preheader'   => $preheader,
        'hero_badge'  => $isNews ? 'New Subscriber' : 'New Lead · ' . $lead['source_label'],
        'hero_title'  => $who,
        'hero_sub'    => ($isNews ? 'subscribed to the newsletter' : 'sent an enquiry from the website') . ' · ' . $when,
        'content'     => $c,
        'footer_note' => $isNews ? '' : 'Tip: simply hit <strong>Reply</strong> &mdash; your answer goes straight to ' . bosk_e($lead['email']) . '.',
    ]);

    $t  = ($isNews ? 'NEW NEWSLETTER SUBSCRIBER' : 'NEW LEAD - ' . strtoupper($lead['source_label'])) . "\n";
    $t .= str_repeat('=', 40) . "\n\n";
    if ($lead['name'] !== '') {
        $t .= 'Name      : ' . $lead['name'] . "\n";
    }
    $t .= 'Email     : ' . $lead['email'] . "\n";
    if ($phone !== '') {
        $t .= 'Phone     : ' . bosk_email_phone_display($phone) . "\n";
    }
    $t .= 'Source    : ' . $lead['source_label'] . "\n";
    if (!empty($lead['context'])) {
        $t .= 'Article   : ' . $lead['context'] . "\n";
    }
    $t .= 'Received  : ' . $when . "\n";
    $t .= 'Reference : ' . $lead['reference'] . "\n";
    if (!empty($lead['attachment_name'])) {
        $t .= 'Attachment: ' . $lead['attachment_name'] . " (attached)\n";
    }
    if (!empty($lead['message'])) {
        $t .= "\nMessage:\n" . $lead['message'] . "\n";
    }
    if (!empty($lead['admin_url'])) {
        $t .= "\nOpen in Admin Panel: " . $lead['admin_url'] . "\n";
    }
    if (!empty($lead['page_url'])) {
        $t .= "\nPage: " . $lead['page_url'];
    }
    if (!empty($lead['device'])) {
        $t .= "\nDevice: " . $lead['device'];
    }
    if (!empty($lead['ip'])) {
        $t .= "\nIP: " . $lead['ip'];
    }
    $t .= "\n";

    return ['subject' => $subject, 'html' => $html, 'text' => $t];
}
