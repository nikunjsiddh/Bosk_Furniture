-- ============================================================
--  Bosk Furniture - LIVE database migration
--  Run this ONCE on the live database (furniturelive) via
--  cPanel -> phpMyAdmin -> select "furniturelive" -> SQL tab -> paste -> Go
--
--  IMPORTANT: Take a FULL backup of the database first
--  (phpMyAdmin -> Export) before running this.
--
--  These are the schema changes the new code needs. They only
--  change column types / add columns - your existing data is kept.
-- ============================================================

-- 1) Products: publish date now stores DATE + TIME (was DATE only)
--    Existing dates become "YYYY-MM-DD 00:00:00".
ALTER TABLE `products` MODIFY `publish_date` DATETIME NOT NULL;

-- 2) Blog: publish date now stores DATE + TIME (was DATE only)
ALTER TABLE `blog` MODIFY `blog_date` DATETIME NOT NULL;

-- 3) Projects: support up to 5 images (add img3, img4, img5)
--    NOTE: If you get "Duplicate column name" here, these columns
--    already exist - just ignore that error, it means it's done.
ALTER TABLE `projects`
    ADD COLUMN `img3` VARCHAR(999) NOT NULL DEFAULT 'noimg.jpg' AFTER `img2`,
    ADD COLUMN `img4` VARCHAR(999) NOT NULL DEFAULT 'noimg.jpg' AFTER `img3`,
    ADD COLUMN `img5` VARCHAR(999) NOT NULL DEFAULT 'noimg.jpg' AFTER `img4`;

-- Done. After this, upload the updated PHP/JS files and test the live site.
