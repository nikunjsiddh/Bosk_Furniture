<?php
/* ============================================================
   Bosk Furniture - Email settings
   ------------------------------------------------------------
   Every enquiry form on the website (Contact, Customize Furniture,
   Blog Comment, Newsletter) sends TWO emails from
   info@boskfurniture.com:

     1. A branded "thank you" confirmation to the CUSTOMER.
     2. A "new lead" notification to the WEBSITE OWNER
        (the addresses in 'owner_emails' below).

   Every enquiry is also saved in the database and shown in
   Admin Panel -> Leads & Enquiries, so no lead is ever lost even
   if an email fails.

   HOW SENDING WORKS
   - If 'smtp_password' is filled in, emails go through Hostinger
     SMTP (best delivery, recommended).
   - If it is empty, the server's PHP mail() is used instead
     (works on Hostinger as long as info@boskfurniture.com exists
     as a mailbox in hPanel -> Emails).

   KEEPING THE PASSWORD OUT OF GIT (optional)
   Instead of typing the password here, you can create the file
   config/mail.local.php containing:
       <?php return ['smtp_password' => 'your-mailbox-password'];
   That file is ignored by git and overrides the values below.
   ============================================================ */

return [

    // ---- Sender (all emails are sent from this address) ----
    'from_email'     => 'info@boskfurniture.com',
    'from_name'      => 'Bosk Furniture',

    // ---- Website owner: new-lead notifications go here ----
    // Add more addresses to the list if needed, e.g.
    // ['info@boskfurniture.com', 'boskinfracon@gmail.com']
    'owner_emails'   => ['info@boskfurniture.com'],

    // Send the "thank you" confirmation email to the customer?
    'send_customer_copy' => true,

    // ---- Hostinger SMTP (hPanel -> Emails -> info@boskfurniture.com) ----
    'smtp_host'      => 'smtp.hostinger.com',
    'smtp_port'      => 465,          // 465 = SSL, 587 = TLS
    'smtp_secure'    => 'ssl',        // 'ssl' for 465, 'tls' for 587
    'smtp_username'  => 'info@boskfurniture.com',
    'smtp_password'  => '',           // <-- mailbox password of info@boskfurniture.com
    'smtp_timeout'   => 15,           // seconds

    // If SMTP fails (wrong password, server down) try PHP mail() as backup.
    'fallback_to_php_mail' => true,

    // ---- Brand details used inside the emails ----
    'site_url'        => 'https://www.boskfurniture.com',
    'logo_url'        => 'https://www.boskfurniture.com/images/logo-black1.png',
    'company_name'    => 'Bosk Furniture',
    'company_legal'   => 'Bosk Infracon Private Limited',
    'company_address' => '5, Aryamaan Complex, Near Meghani Circle, Sir Patanni Road, Bhavnagar - 364001, Gujarat, India',
    'phone_display'   => '+91 88666 47777',
    'phone_link'      => '+918866647777',
    'whatsapp_display'=> '+91 97378 17777',
    'whatsapp_number' => '919737817777',
    'reply_within'    => '24 hours',
];
