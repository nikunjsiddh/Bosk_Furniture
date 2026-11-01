<?php
/* ============================================================
   Blog comment form (details.php)
   ------------------------------------------------------------
   Saves the enquiry in Admin > Leads & Enquiries, emails the
   website owner and sends the customer a branded confirmation
   from info@boskfurniture.com. Answers with JSON.
   Logic lives in lib/bosk-leads.php (settings: config/mail.php).
   ============================================================ */
include_once __DIR__ . '/../connect.php';
require_once __DIR__ . '/../lib/bosk-leads.php';

bosk_handle_lead_submission($con, 'blog_comment');
