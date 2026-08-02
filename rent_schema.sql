-- =============================================================================
-- BOSK FURNITURE — RENT MODULE SCHEMA
-- Run once on local (bosk_furniture) and on live (u583659604_furniture)
-- All statements use IF NOT EXISTS / IF EXISTS guards to be idempotent.
-- =============================================================================

-- ---------------------------------------------------------------------------
-- 1.  EXTEND EXISTING TABLES (safe, idempotent)
-- ---------------------------------------------------------------------------

-- products: rental & listing flags
ALTER TABLE `products`
    ADD COLUMN IF NOT EXISTS `available_for_rent` TINYINT(1) NOT NULL DEFAULT 0,
    ADD COLUMN IF NOT EXISTS `available_for_sale` TINYINT(1) NOT NULL DEFAULT 1,
    ADD COLUMN IF NOT EXISTS `is_package`         TINYINT(1) NOT NULL DEFAULT 0,
    ADD COLUMN IF NOT EXISTS `badge_label`        VARCHAR(30)          DEFAULT NULL;

-- category: ordering and soft-delete
ALTER TABLE `category`
    ADD COLUMN IF NOT EXISTS `display_order` INT  NOT NULL DEFAULT 0,
    ADD COLUMN IF NOT EXISTS `is_active`     TINYINT(1) NOT NULL DEFAULT 1;

-- ---------------------------------------------------------------------------
-- 2.  CITIES
-- ---------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `cities` (
    `id`           INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `name`         VARCHAR(100) NOT NULL,
    `state`        VARCHAR(100)          DEFAULT NULL,
    `is_serviceable` TINYINT(1) NOT NULL DEFAULT 1,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ---------------------------------------------------------------------------
-- 3.  RENTAL PLANS  (per product × per city)
-- ---------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `rental_plans` (
    `id`          INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `product_id`  INT          NOT NULL,               -- FK → products.id
    `city_id`     INT UNSIGNED             DEFAULT NULL, -- NULL = applies to all cities
    `tenure_months` TINYINT UNSIGNED NOT NULL,          -- 3, 6, or 12
    `monthly_rent`  INT UNSIGNED NOT NULL,
    `deposit`       INT UNSIGNED NOT NULL,
    `save_label`    VARCHAR(30)            DEFAULT NULL,
    `is_active`   TINYINT(1) NOT NULL DEFAULT 1,
    `created_at`  TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    KEY `idx_rp_product` (`product_id`),
    KEY `idx_rp_city`    (`city_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ---------------------------------------------------------------------------
-- 4.  PRODUCT CITY STOCK
-- ---------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `product_city_stock` (
    `id`          INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `product_id`  INT          NOT NULL,
    `city_id`     INT UNSIGNED NOT NULL,
    `stock_qty`   INT          NOT NULL DEFAULT 0,
    `updated_at`  TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    UNIQUE KEY `uq_prod_city` (`product_id`, `city_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ---------------------------------------------------------------------------
-- 5.  PACKAGE ITEMS  (for bundled rental packages)
-- ---------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `package_items` (
    `id`          INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `package_id`  INT          NOT NULL,    -- products.id where is_package=1
    `item_id`     INT          NOT NULL,    -- products.id of individual item
    `qty`         TINYINT UNSIGNED NOT NULL DEFAULT 1,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ---------------------------------------------------------------------------
-- 6.  PRODUCT IMAGES  (additional images beyond main image)
-- ---------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `product_images` (
    `id`          INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `product_id`  INT          NOT NULL,
    `filename`    VARCHAR(255) NOT NULL,
    `sort_order`  TINYINT UNSIGNED NOT NULL DEFAULT 0,
    PRIMARY KEY (`id`),
    KEY `idx_pi_product` (`product_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ---------------------------------------------------------------------------
-- 7.  KYC VERIFICATIONS
-- ---------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `kyc_verifications` (
    `id`              INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `user_id`         INT          NOT NULL,
    `doc_type`        ENUM('aadhaar','pan','passport','voter_id','driving_licence') NOT NULL DEFAULT 'aadhaar',
    `doc_front_file`  VARCHAR(255)          DEFAULT NULL,
    `doc_back_file`   VARCHAR(255)          DEFAULT NULL,
    `selfie_file`     VARCHAR(255)          DEFAULT NULL,
    `status`          ENUM('pending','approved','rejected') NOT NULL DEFAULT 'pending',
    `admin_note`      TEXT                  DEFAULT NULL,
    `reviewed_by`     INT UNSIGNED          DEFAULT NULL,
    `submitted_at`    TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `reviewed_at`     TIMESTAMP NULL DEFAULT NULL,
    PRIMARY KEY (`id`),
    KEY `idx_kyc_user`   (`user_id`),
    KEY `idx_kyc_status` (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ---------------------------------------------------------------------------
-- 8.  RENTAL CARTS  (separate from buy cart)
-- ---------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `carts` (
    `id`             INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `user_id`        INT          DEFAULT NULL,     -- NULL = guest
    `session_token`  VARCHAR(64)  DEFAULT NULL,
    `city_id`        INT UNSIGNED DEFAULT NULL,
    `created_at`     TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at`     TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    KEY `idx_cart_user`    (`user_id`),
    KEY `idx_cart_session` (`session_token`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `cart_items` (
    `id`             INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `cart_id`        INT UNSIGNED NOT NULL,
    `product_id`     INT          NOT NULL,
    `plan_id`        INT UNSIGNED NOT NULL,         -- FK → rental_plans.id
    `qty`            TINYINT UNSIGNED NOT NULL DEFAULT 1,
    `protection_addon` TINYINT(1) NOT NULL DEFAULT 0,
    `added_at`       TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    KEY `idx_ci_cart`    (`cart_id`),
    KEY `idx_ci_product` (`product_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ---------------------------------------------------------------------------
-- 9.  DELIVERY ADDRESSES
-- ---------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `delivery_addresses` (
    `id`          INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `user_id`     INT          NOT NULL,
    `full_name`   VARCHAR(120) NOT NULL,
    `mobile`      VARCHAR(15)  NOT NULL,
    `address_line` VARCHAR(255) NOT NULL,
    `city`        VARCHAR(100) NOT NULL,
    `state`       VARCHAR(100)           DEFAULT NULL,
    `pincode`     VARCHAR(10)  NOT NULL,
    `is_default`  TINYINT(1) NOT NULL DEFAULT 0,
    `created_at`  TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    KEY `idx_da_user` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ---------------------------------------------------------------------------
-- 10. RENTAL ORDERS
-- ---------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `rental_orders` (
    `id`              INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `order_ref`       VARCHAR(20)  NOT NULL UNIQUE,
    `user_id`         INT          NOT NULL,
    `kyc_id`          INT UNSIGNED          DEFAULT NULL,
    `address_id`      INT UNSIGNED          DEFAULT NULL,
    `city_id`         INT UNSIGNED          DEFAULT NULL,
    `delivery_slot`   VARCHAR(80)           DEFAULT NULL,
    `status`          ENUM('pending','kyc_pending','confirmed','delivered','active','overdue','return_requested','returned','cancelled') NOT NULL DEFAULT 'pending',
    `total_monthly_rent` INT UNSIGNED NOT NULL DEFAULT 0,
    `total_deposit`      INT UNSIGNED NOT NULL DEFAULT 0,
    `notes`           TEXT                  DEFAULT NULL,
    `created_at`      TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at`      TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    KEY `idx_ro_user`   (`user_id`),
    KEY `idx_ro_status` (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `rental_order_items` (
    `id`             INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `order_id`       INT UNSIGNED NOT NULL,
    `product_id`     INT          NOT NULL,
    `plan_id`        INT UNSIGNED          DEFAULT NULL,
    `tenure_months`  TINYINT UNSIGNED NOT NULL,
    `monthly_rent`   INT UNSIGNED NOT NULL,
    `deposit`        INT UNSIGNED NOT NULL,
    `qty`            TINYINT UNSIGNED NOT NULL DEFAULT 1,
    `protection_addon` TINYINT(1) NOT NULL DEFAULT 0,
    `start_date`     DATE                  DEFAULT NULL,
    `end_date`       DATE                  DEFAULT NULL,
    `status`         ENUM('active','returned','extended','bought_out') NOT NULL DEFAULT 'active',
    PRIMARY KEY (`id`),
    KEY `idx_roi_order`   (`order_id`),
    KEY `idx_roi_product` (`product_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ---------------------------------------------------------------------------
-- 11. ORDER LIFECYCLE REQUESTS  (return / relocation / repair / buyout)
-- ---------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `order_lifecycle_requests` (
    `id`          INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `order_id`    INT UNSIGNED NOT NULL,
    `item_id`     INT UNSIGNED          DEFAULT NULL,
    `user_id`     INT          NOT NULL,
    `type`        ENUM('return','relocation','repair','buyout','extension') NOT NULL,
    `status`      ENUM('pending','approved','rejected','completed') NOT NULL DEFAULT 'pending',
    `notes`       TEXT                  DEFAULT NULL,
    `admin_note`  TEXT                  DEFAULT NULL,
    `requested_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `resolved_at`  TIMESTAMP NULL DEFAULT NULL,
    PRIMARY KEY (`id`),
    KEY `idx_olr_order` (`order_id`),
    KEY `idx_olr_user`  (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ---------------------------------------------------------------------------
-- 12. PAYMENT METHODS ON FILE
-- ---------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `payment_methods_on_file` (
    `id`          INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `user_id`     INT          NOT NULL,
    `type`        ENUM('upi','card','netbanking','mandate') NOT NULL DEFAULT 'upi',
    `masked_info` VARCHAR(60)           DEFAULT NULL,   -- e.g. "****1234" or UPI handle
    `is_autopay`  TINYINT(1) NOT NULL DEFAULT 0,
    `gateway_ref` VARCHAR(120)          DEFAULT NULL,
    `is_active`   TINYINT(1) NOT NULL DEFAULT 1,
    `created_at`  TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    KEY `idx_pmof_user` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ---------------------------------------------------------------------------
-- 13. PAYMENTS
-- ---------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `payments` (
    `id`            INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `order_id`      INT UNSIGNED NOT NULL,
    `user_id`       INT          NOT NULL,
    `type`          ENUM('deposit','monthly_rent','buyout','refund') NOT NULL,
    `amount`        INT UNSIGNED NOT NULL,
    `status`        ENUM('pending','paid','failed','refunded') NOT NULL DEFAULT 'pending',
    `gateway`       VARCHAR(40)           DEFAULT NULL,
    `gateway_txn`   VARCHAR(120)          DEFAULT NULL,
    `due_date`      DATE                  DEFAULT NULL,
    `paid_at`       TIMESTAMP NULL DEFAULT NULL,
    `created_at`    TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    KEY `idx_pay_order`  (`order_id`),
    KEY `idx_pay_user`   (`user_id`),
    KEY `idx_pay_status` (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ---------------------------------------------------------------------------
-- 14. MONTHLY RENT INVOICES
-- ---------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `monthly_rent_invoices` (
    `id`           INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `order_id`     INT UNSIGNED NOT NULL,
    `invoice_no`   VARCHAR(30)  NOT NULL UNIQUE,
    `period_month` TINYINT UNSIGNED NOT NULL,  -- 1-based month number in tenure
    `amount`       INT UNSIGNED NOT NULL,
    `due_date`     DATE         NOT NULL,
    `paid_at`      TIMESTAMP NULL DEFAULT NULL,
    `status`       ENUM('upcoming','due','paid','overdue') NOT NULL DEFAULT 'upcoming',
    `payment_id`   INT UNSIGNED          DEFAULT NULL,
    `created_at`   TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    KEY `idx_mri_order`  (`order_id`),
    KEY `idx_mri_status` (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ---------------------------------------------------------------------------
-- 15. DEPOSIT REFUNDS
-- ---------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `deposit_refunds` (
    `id`            INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `order_id`      INT UNSIGNED NOT NULL,
    `user_id`       INT          NOT NULL,
    `gross_deposit` INT UNSIGNED NOT NULL,
    `damage_charge` INT UNSIGNED NOT NULL DEFAULT 0,
    `net_refund`    INT UNSIGNED NOT NULL,
    `status`        ENUM('pending','processed','rejected') NOT NULL DEFAULT 'pending',
    `admin_note`    TEXT                  DEFAULT NULL,
    `processed_at`  TIMESTAMP NULL DEFAULT NULL,
    `created_at`    TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    KEY `idx_dr_order` (`order_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ---------------------------------------------------------------------------
-- 16. ADMIN ROLES & USERS  (for role-based rent module access)
-- ---------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `admin_roles` (
    `id`          TINYINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `name`        VARCHAR(40)  NOT NULL UNIQUE,
    `permissions` JSON                      DEFAULT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `admin_users` (
    `id`          INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `email`       VARCHAR(120) NOT NULL UNIQUE,
    `name`        VARCHAR(100) NOT NULL,
    `role_id`     TINYINT UNSIGNED          DEFAULT NULL,
    `is_active`   TINYINT(1) NOT NULL DEFAULT 1,
    `created_at`  TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ---------------------------------------------------------------------------
-- 17. AUDIT LOG
-- ---------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `audit_log` (
    `id`          BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `actor_type`  ENUM('admin','user','system') NOT NULL DEFAULT 'admin',
    `actor_id`    INT UNSIGNED          DEFAULT NULL,
    `action`      VARCHAR(80)  NOT NULL,
    `entity`      VARCHAR(60)           DEFAULT NULL,
    `entity_id`   INT UNSIGNED          DEFAULT NULL,
    `old_value`   TEXT                  DEFAULT NULL,
    `new_value`   TEXT                  DEFAULT NULL,
    `ip_address`  VARCHAR(45)           DEFAULT NULL,
    `created_at`  TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    KEY `idx_al_entity` (`entity`, `entity_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ---------------------------------------------------------------------------
-- 18. OTP VERIFICATIONS
-- ---------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `otp_verifications` (
    `id`          INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `mobile`      VARCHAR(15)  NOT NULL,
    `otp_hash`    VARCHAR(64)  NOT NULL,
    `purpose`     VARCHAR(40)  NOT NULL DEFAULT 'checkout',
    `expires_at`  TIMESTAMP    NOT NULL,
    `verified_at` TIMESTAMP NULL DEFAULT NULL,
    `created_at`  TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    KEY `idx_otp_mobile` (`mobile`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ---------------------------------------------------------------------------
-- 19. NOTIFICATIONS LOG
-- ---------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `notifications_log` (
    `id`          BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `user_id`     INT                       DEFAULT NULL,
    `channel`     ENUM('sms','email','push','whatsapp') NOT NULL DEFAULT 'email',
    `template`    VARCHAR(80)               DEFAULT NULL,
    `recipient`   VARCHAR(120) NOT NULL,
    `subject`     VARCHAR(200)              DEFAULT NULL,
    `body`        TEXT                      DEFAULT NULL,
    `status`      ENUM('queued','sent','failed') NOT NULL DEFAULT 'queued',
    `sent_at`     TIMESTAMP NULL DEFAULT NULL,
    `created_at`  TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ---------------------------------------------------------------------------
-- 20. SEED: default cities
-- ---------------------------------------------------------------------------
INSERT IGNORE INTO `cities` (`id`, `name`, `state`, `is_serviceable`) VALUES
(1, 'Bhavnagar',   'Gujarat',      1),
(2, 'Ahmedabad',   'Gujarat',      1),
(3, 'Surat',       'Gujarat',      1),
(4, 'Mumbai',      'Maharashtra',  1),
(5, 'Pune',        'Maharashtra',  1),
(6, 'Bengaluru',   'Karnataka',    1),
(7, 'Delhi',       'Delhi',        1),
(8, 'Hyderabad',   'Telangana',    1);

-- ---------------------------------------------------------------------------
-- 21. SEED: default admin role
-- ---------------------------------------------------------------------------
INSERT IGNORE INTO `admin_roles` (`id`, `name`) VALUES
(1, 'super_admin'),
(2, 'rent_ops');

-- End of rent_schema.sql
