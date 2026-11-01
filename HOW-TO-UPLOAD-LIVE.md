# How to Upload Bosk Furniture to Live Server (cPanel) - Step by Step

This guide explains how to upload your updated website from your computer
(`C:\xampp2\htdocs\bosk\`) to your live server `www.boskfurniture.com`
using cPanel File Manager. An FTP method is also included.

---

## BEFORE YOU START - 3 Important Things

### 1. Take a backup of the live site (very important!)
If something goes wrong, you can restore the old version.
- Log into cPanel → **File Manager** → open `public_html`
- Select all files → **Compress** → make a `.zip` → **Download** it to your computer
- Keep this backup safe. (Naam aapo: `bosk-backup-before-seo.zip`)

### 2. Take a backup of the live database (optional but recommended)
- cPanel → **phpMyAdmin** → select your database → **Export** → **Go**
- This downloads a `.sql` file. Keep it safe.

### 3. Live database password file (one-time setup)
Your `connect.php` auto-detects localhost vs live:
- On localhost (XAMPP) → uses `root` / no password. Nothing to set up.
- On live server → reads the database login from **`config/db.local.php`**.

`config/db.local.php` is **not** in git and **not** in your upload zip, so the
password never ends up in the code. (`config/.htaccess` also blocks it from
the browser.) You create it **once** on the server:

1. hPanel → **Databases → Management**: note the **database name** and the
   **database user** (both start with `u583659604_`). You need the password
   for that user too. If you don't have it, use **Change password** there
   (see the security note below).
2. hPanel → **File Manager** → open `public_html/config`
3. Click **New File** → name it exactly `db.local.php` → open it → paste:
   ```php
   <?php
   return [
       'host'     => 'localhost',
       'user'     => 'PUT_DATABASE_USER_HERE',
       'password' => 'PUT_DATABASE_PASSWORD_HERE',
       'database' => 'PUT_DATABASE_NAME_HERE',
   ];
   ```
4. Replace the three `PUT_..._HERE` values with your real ones → **Save**.

Do this **before or right after** you upload the new `connect.php` and
`Admin/connect.php`. If the file is missing, the live site shows
*"live database settings are missing"*.

After this, **you never need to edit `connect.php`**. Later uploads don't touch
`db.local.php`: "Extract → Overwrite All" only replaces files that are inside
your zip. **Never** send this file to anyone or add it to git.

> **Security: change the database password now.** The old live password was
> saved in git, so anyone who can see the repository history can read it.
> In hPanel → **Databases → Management**, find the database user → **Change
> password** → choose a new strong password (16+ characters, random). Then
> **immediately** put the new password in `public_html/config/db.local.php`
> and save. The site gets a database error for the minute between those two
> steps. If you used the old password anywhere else (hPanel login, email,
> admin panel), change it there too.
>
> Also delete `public_html/Admin/Admin.zip` from the server if it is there.
> It is an old backup that anyone could download, and it holds an old
> database password.

---

## METHOD 1 - Upload via cPanel File Manager (Easiest)

### Step 1: Zip your local site
On your computer:
1. Open `C:\xampp2\htdocs\`
2. Right-click the **`bosk`** folder → **Send to → Compressed (zipped) folder**
   - This creates `bosk.zip`
   - (Or zip only the changed files - see "Which files changed" list below)

### Step 2: Log into cPanel
1. Go to your hosting login (Hostinger: https://hpanel.hostinger.com
   or your host's cPanel URL like `https://yourserver.com:2083`)
2. Enter username + password
3. Open **File Manager**

### Step 3: Go to the website root folder
1. In File Manager, open **`public_html`**
   - This is where boskfurniture.com lives.
   - (If your site is in a subfolder like `public_html/bosk`, open that instead.)

### Step 4: Upload the zip
1. Click **Upload** (top toolbar)
2. Drag `bosk.zip` into the upload box (or click "Select File")
3. Wait for it to reach **100%**
4. Go **Back to File Manager**

### Step 5: Extract the zip
1. Right-click `bosk.zip` → **Extract**
2. Choose to extract into the current folder (`public_html`)
3. When asked to overwrite existing files → **Yes / Overwrite All**
4. After extracting, **delete `bosk.zip`** to keep things tidy

> NOTE: If your zip created a folder `public_html/bosk/...` but the site
> should be at the root, move the files up one level, OR just upload the
> individual files instead (Method 1B below).

### Step 5B (alternative): Upload only the changed files
If you don't want to overwrite everything, upload just the files that changed.
In File Manager, navigate to each folder and upload these:

**Root files (upload to `public_html/`):**
- `.htaccess`
- `robots.txt`
- `sitemap.xml`
- `sitemap-generator.php`
- `manifest.json`
- `index.php`
- `about-us.php`, `contact.php`, `shop.php`, `product.php`, `all_products.php`
- `cart.php`, `cart1.php`, `checkout.php`, `wishlist.php`
- `login.php`, `register.php`, `logout.php`, `profile.php`
- `testimonial.php`, `blog-full-list.php`, `details.php`
- `projects.php`, `project-details.php`
- `all-services.php`, `404.php`
- `warranty.php`, `warranty_policy.php`, `hardware_warranty.php`, `care_and_maintenance_policy.php`
- `design-order-process.php`, `ex-customize_furniture.php`
- `order_details.php`, `return_request.php`, `invoice.php`

**Design partials (upload to `public_html/design/`):**
- `seo-meta.php` (NEW file - must upload)
- `header.php`
- `nav.php`, `nav1.php`

> TIP: To see the "Hidden" `.htaccess` file in File Manager, click
> **Settings** (top right) → tick **"Show Hidden Files (dotfiles)"** → Save.

### Step 6: Set correct permissions (if needed)
Usually automatic, but if a page errors:
- Files should be **644**
- Folders should be **755**
- Right-click a file → **Change Permissions** to fix.

---

## METHOD 2 - Upload via FTP (FileZilla)

Good if you upload often.

### Step 1: Get FTP details from cPanel
- cPanel → **FTP Accounts** → note: Host, Username, Password, Port (usually 21)

### Step 2: Install & open FileZilla
- Download: https://filezilla-project.org/
- Open it → top bar enter:
  - **Host:** your FTP host (e.g. `ftp.boskfurniture.com`)
  - **Username / Password:** from cPanel
  - **Port:** 21
- Click **Quickconnect**

### Step 3: Upload
- **Left panel** = your computer → go to `C:\xampp2\htdocs\bosk`
- **Right panel** = server → go to `public_html`
- Select your files on the left → drag them to the right
- When asked to overwrite → choose **Overwrite** (and "Always use this action")

---

## AFTER UPLOAD - Required Steps (do these in order)

### 1. Test the homepage
Open `https://www.boskfurniture.com/` in your browser.
- It should load with NO PHP errors/warnings at the top.
- View page source (Ctrl+U) → confirm you see new `<title>`, `<meta name="description">`,
  and `<script type="application/ld+json">` blocks in the `<head>`.

### 2. Test clean URLs
Open these — they should all work (no .php):
- `https://www.boskfurniture.com/about-us`
- `https://www.boskfurniture.com/contact`
- `https://www.boskfurniture.com/all_products`
- And old links should auto-redirect: `/about-us.php` → `/about-us`

### 3. Generate the full sitemap
Open once in your browser:
`https://www.boskfurniture.com/sitemap-generator.php`
- It should say "sitemap.xml regenerated successfully".
- Then check: `https://www.boskfurniture.com/sitemap.xml` shows all your pages + products.

### 4. Enable canonical domain (in .htaccess)
Decide www vs non-www (recommend **www**). In `.htaccess`, uncomment:
```apache
RewriteCond %{HTTP_HOST} ^boskfurniture\.com [NC]
RewriteRule ^(.*)$ https://www.boskfurniture.com/$1 [L,R=301]
```
And uncomment the HTTPS block (your SSL is already active):
```apache
RewriteCond %{HTTPS} off
RewriteRule ^(.*)$ https://%{HTTP_HOST}%{REQUEST_URI} [L,R=301]
```
Save. Test the site still loads.

### 5. Submit to Google Search Console
- Go to https://search.google.com/search-console
- Add property `https://www.boskfurniture.com` (verify via HTML meta tag or DNS)
- **Sitemaps** → submit `sitemap.xml`
- **URL Inspection** → paste homepage URL → **Request Indexing**

### 6. Create the OG share image (if not done)
Make a 1200x630 image and upload it to `public_html/images/og-default.jpg`
(used when your site is shared on WhatsApp / Facebook).

---

## IF SOMETHING BREAKS - Quick Fixes

| Problem | Fix |
|---|---|
| **500 Internal Server Error** | Usually `.htaccess`. Rename it to `.htaccess_off` to test. If site works, a rule isn't supported - re-check the file or contact host. |
| **Page shows PHP code as text** | PHP not parsing - check file uploaded as `.php`, not `.txt`. |
| **"Headers already sent" warning** | Already fixed in the new files - make sure you uploaded the latest `index.php`, `design/nav.php`, `design/nav1.php`. |
| **Clean URLs give 404** | `mod_rewrite` may be off. In cPanel contact support to enable it, or check the `.htaccess` uploaded correctly. |
| **"live database settings are missing"** | `public_html/config/db.local.php` doesn't exist or is incomplete. Create it (see "3. Live database password file" above). |
| **Database connection failed** | The values in `public_html/config/db.local.php` don't match the database. Check hPanel → Databases → Management for the correct DB name/user, and reset the password there if needed. |
| **Old version still showing** | Clear browser cache (Ctrl+Shift+R) or clear any caching plugin / Cloudflare cache. |

---

## RESTORE (if you must roll back)
1. cPanel File Manager → `public_html`
2. Upload your backup `bosk-backup-before-seo.zip`
3. Extract → Overwrite All
4. Site is back to the previous version.

---

## Quick Checklist

- [ ] Backup live files (zip + download)
- [ ] Backup database (phpMyAdmin export)
- [ ] `public_html/config/db.local.php` exists on the server (one-time)
- [ ] Database password changed in hPanel and updated in `db.local.php` (one-time)
- [ ] Upload all changed files to `public_html`
- [ ] Confirm `design/seo-meta.php` and `manifest.json` are uploaded (NEW files)
- [ ] Test homepage loads with no errors
- [ ] Run `sitemap-generator.php` once
- [ ] Uncomment www + HTTPS redirect in `.htaccess`
- [ ] Submit sitemap to Google Search Console
- [ ] Upload `images/og-default.jpg`

*Guide prepared for boskfurniture.com deployment.*
