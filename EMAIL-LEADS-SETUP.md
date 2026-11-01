# Email & Leads Setup (info@boskfurniture.com)

## What happens when someone submits a form

Covers the **Contact page**, **Customize Furniture page**, **Blog comments** and the **Newsletter** box in the footer.

1. The enquiry is saved in **Admin Panel > Leads & Enquiries**, so no lead is ever lost.
2. **Website owner** gets a "New Lead" email at `info@boskfurniture.com`, with Reply, Call, WhatsApp and Admin buttons. Hitting *Reply* answers the customer directly. If the customer attached a reference image, it is attached to this email.
3. **Customer** gets a branded thank-you email from `info@boskfurniture.com` with a reference number (for example `BSK-000042`) and what happens next. Newsletter subscribers get a welcome email instead.

## One-time setup (5 minutes)

1. **Create the mailbox.** In Hostinger hPanel, go to *Emails* and create `info@boskfurniture.com` (skip this if it already exists).
2. **Add the mailbox password.** Open `config/mail.php` and fill in:
   ```php
   'smtp_password'  => 'your-mailbox-password',
   ```
   To keep the password out of git, you can create `config/mail.local.php` instead:
   ```php
   <?php return ['smtp_password' => 'your-mailbox-password'];
   ```
   Without a password the site falls back to PHP `mail()`. That also works on Hostinger, but SMTP has better delivery.
3. **Upload the files** listed below to `public_html`.
4. **Test it.** Submit the Contact form using your own email address. You should get both emails, and the lead should appear in *Admin > Leads & Enquiries*.

The `leads` table is created automatically. If your database user is not allowed to create tables, run `leads_schema.sql` once in phpMyAdmin.

## Keep emails out of spam

In hPanel, go to *Emails > DNS records / Email deliverability* and make sure **SPF, DKIM and DMARC** are all set. Hostinger shows a "Fix" button if any of them is missing.

## Settings (config/mail.php)

| Setting | What it does |
|---|---|
| `owner_emails` | Who receives new-lead alerts. Add more addresses if needed, e.g. `['info@boskfurniture.com', 'boskinfracon@gmail.com']` |
| `send_customer_copy` | Set to `false` to stop the customer thank-you emails |
| `reply_within` | The "within 24 hours" promise used in the emails and on-screen messages |
| `smtp_port` / `smtp_secure` | `465` + `ssl` (default) or `587` + `tls` |

## Admin panel

- **Sidebar > Leads & Enquiries.** The orange badge shows how many leads are unread.
- **Click any lead** to see the full message, the reference image, Call / WhatsApp / Email buttons, a status selector (New, Contacted, In Progress, Converted, Closed, Spam) and private notes.
- **Export CSV** downloads all leads (or only the current filter) for Excel.
- The **Dashboard** shows a leads snapshot with the latest enquiries.
- The **Email delivery** box on each lead shows whether both emails were sent. If SMTP fails, a note there explains why.

## Spam protection

- A hidden "honeypot" field silently drops bot submissions.
- Each IP address can submit at most 8 forms per 15 minutes.
- Each email address gets at most 3 confirmation emails per hour, so the form cannot be used to flood someone's inbox.

## Files to upload

**New:** `lib/` (whole folder), `config/mail.php`, `config/.htaccess`, `lead_attachments/` (folder with its `.htaccess`), `Admin/leads.php`, `Admin/lead-attachment.php`, `css/lead-form.css`, `js/add/lead-form.js`, `leads_schema.sql` (optional)

**Changed:** `back/contact.php`, `back/comment.php`, `back/modest_customize.php`, `back/newsletter.php`, `js/add/contact.js`, `js/add/comment.js`, `js/add/modest_customize.js`, `contact.php`, `details.php`, `ex-customize_furniture.php`, `return_request.php`, `warranty_policy.php`, `design/footer.php`, `design/footer1.php`, `design/seo-meta.php`, `Admin/Dash.php`, `Admin/design/sidebar.php`, `Admin/back/signin.php`

The `lead_attachments/` folder must be writable by PHP (permission 755 is fine on Hostinger).
