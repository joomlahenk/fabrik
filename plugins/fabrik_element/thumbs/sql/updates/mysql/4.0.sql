ALTER TABLE IF EXISTS `#__fabrik_thumbs` ALTER `user_id` SET DEFAULT '';
ALTER TABLE IF EXISTS `#__fabrik_thumbs` ALTER `listid` SET DEFAULT 0;
ALTER TABLE IF EXISTS `#__fabrik_thumbs` ALTER `formid` SET DEFAULT 0;
ALTER TABLE IF EXISTS `#__fabrik_thumbs` ALTER `row_id` SET DEFAULT 0;
ALTER TABLE IF EXISTS `#__fabrik_thumbs` ALTER `thumb` SET DEFAULT '';
ALTER TABLE IF EXISTS `#__fabrik_thumbs` MODIFY `date_created` datetime NULL DEFAULT NULL;
ALTER TABLE IF EXISTS `#__fabrik_thumbs` ALTER `element_id` SET DEFAULT 0;
ALTER TABLE IF EXISTS `#__fabrik_thumbs` ALTER `special` SET DEFAULT '';