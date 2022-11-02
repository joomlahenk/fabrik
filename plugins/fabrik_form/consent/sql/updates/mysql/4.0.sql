ALTER TABLE IF EXISTS `#__fabrik_privacy` MODIFY `date_time` datetime NULL DEFAULT NULL;
ALTER TABLE IF EXISTS `#__fabrik_privacy` ALTER `list_id` SET DEFAULT 0;
ALTER TABLE IF EXISTS `#__fabrik_privacy` ALTER `form_id` SET DEFAULT 0;
ALTER TABLE IF EXISTS `#__fabrik_privacy` ALTER `row_id` SET DEFAULT 0;
ALTER TABLE IF EXISTS `#__fabrik_privacy` ALTER `user_id` SET DEFAULT 0;
ALTER TABLE IF EXISTS `#__fabrik_privacy` ALTER `update_record` SET DEFAULT 0;
ALTER TABLE IF EXISTS `#__fabrik_privacy` ALTER `ip` SET DEFAULT '';
ALTER TABLE IF EXISTS `#__fabrik_privacy` ALTER `newsletter_engine` SET DEFAULT '';
ALTER TABLE IF EXISTS `#__fabrik_privacy` ALTER `sublist_id` SET DEFAULT 0;
ALTER TABLE IF EXISTS `#__fabrik_privacy` ALTER `subid` SET DEFAULT 0;

