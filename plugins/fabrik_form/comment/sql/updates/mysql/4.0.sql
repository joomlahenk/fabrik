
ALTER TABLE IF EXISTS `#__fabrik_comments` ALTER `user_id` SET DEFAULT 0;
ALTER TABLE IF EXISTS `#__fabrik_comments` ALTER `ipaddress` SET DEFAULT '';
ALTER TABLE IF EXISTS `#__fabrik_comments` ALTER `reply_to` SET DEFAULT 0;
ALTER TABLE IF EXISTS `#__fabrik_comments` ALTER `approved` SET DEFAULT 0;
ALTER TABLE IF EXISTS `#__fabrik_comments` ALTER `url` SET DEFAULT '';
ALTER TABLE IF EXISTS `#__fabrik_comments` ALTER `name` SET DEFAULT '';
ALTER TABLE IF EXISTS `#__fabrik_comments` ALTER `email` SET DEFAULT '';
ALTER TABLE IF EXISTS `#__fabrik_comments` ALTER `formid` SET DEFAULT 0;
ALTER TABLE IF EXISTS `#__fabrik_comments` ALTER `row_id` SET DEFAULT 0;
ALTER TABLE IF EXISTS `#__fabrik_comments` ALTER `rating` SET DEFAULT '';
ALTER TABLE IF EXISTS `#__fabrik_comments` ALTER `annonymous` SET DEFAULT 0;
ALTER TABLE IF EXISTS `#__fabrik_comments` ADD COLUMN IF NOT EXISTS `notify` TINYINT(1) NOT NULL DEFAULT 0;
ALTER TABLE IF EXISTS `#__fabrik_comments` ALTER COLUMN IF EXISTS `notify` SET DEFAULT 0;
ALTER TABLE IF EXISTS `#__fabrik_comments` ALTER `diggs` SET DEFAULT 0;
