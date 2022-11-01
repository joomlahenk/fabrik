ALTER TABLE IF EXISTS `#__fabrik_ratings` ALTER `user_id` SET DEFAULT '';
ALTER TABLE IF EXISTS `#__fabrik_ratings` ALTER `listid` SET DEFAULT 0;
ALTER TABLE IF EXISTS `#__fabrik_ratings` ALTER `formid` SET DEFAULT 0;
ALTER TABLE IF EXISTS `#__fabrik_ratings` ALTER `row_id` SET DEFAULT 0;
ALTER TABLE IF EXISTS `#__fabrik_ratings` ALTER `rating` SET DEFAULT 0;
ALTER TABLE IF EXISTS `#__fabrik_ratings` MODIFY `date_created` datetime NULL DEFAULT NULL;
ALTER TABLE IF EXISTS `#__fabrik_ratings` ALTER `element_id` SET DEFAULT 0;