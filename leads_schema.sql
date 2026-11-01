-- ============================================================
--  Bosk Furniture - Leads & Enquiries table
--
--  The website creates this table AUTOMATICALLY the first time
--  someone submits a form or an admin opens Admin > Leads.
--  Run this manually only if your database user is not allowed
--  to create tables:
--    cPanel / hPanel -> phpMyAdmin -> select the database ->
--    SQL tab -> paste -> Go
--  Safe to run more than once.
-- ============================================================

CREATE TABLE IF NOT EXISTS `leads` (
    `id`                 INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `source`             VARCHAR(30)   NOT NULL DEFAULT 'contact',  -- contact | customize | blog_comment | newsletter
    `name`               VARCHAR(100)  NOT NULL DEFAULT '',
    `email`              VARCHAR(150)  NOT NULL DEFAULT '',
    `phone`              VARCHAR(20)   NOT NULL DEFAULT '',
    `message`            TEXT          NULL,
    `context`            VARCHAR(255)  NULL DEFAULT NULL,           -- e.g. blog article title
    `attachment`         VARCHAR(255)  NULL DEFAULT NULL,           -- file name inside /lead_attachments
    `attachment_name`    VARCHAR(255)  NULL DEFAULT NULL,           -- original file name
    `page_url`           VARCHAR(500)  NULL DEFAULT NULL,
    `status`             VARCHAR(20)   NOT NULL DEFAULT 'new',      -- new | contacted | in_progress | converted | closed | spam
    `admin_note`         TEXT          NULL,
    `is_read`            TINYINT(1)    NOT NULL DEFAULT 0,
    `customer_mail_sent` TINYINT(1)    NOT NULL DEFAULT 0,
    `owner_mail_sent`    TINYINT(1)    NOT NULL DEFAULT 0,
    `mail_error`         VARCHAR(1000) NULL DEFAULT NULL,
    `ip_address`         VARCHAR(45)   NULL DEFAULT NULL,
    `user_agent`         VARCHAR(255)  NULL DEFAULT NULL,
    `created_at`         DATETIME      NOT NULL DEFAULT CURRENT_TIMESTAMP,  -- India time (IST)
    `updated_at`         DATETIME      NULL DEFAULT NULL,
    PRIMARY KEY (`id`),
    KEY `idx_leads_status`  (`status`),
    KEY `idx_leads_source`  (`source`),
    KEY `idx_leads_created` (`created_at`),
    KEY `idx_leads_email`   (`email`),
    KEY `idx_leads_ip`      (`ip_address`, `created_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
