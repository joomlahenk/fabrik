ALTER TABLE IF EXISTS `#__fabrik_notification` ALTER `reference` SET DEFAULT '';
ALTER TABLE IF EXISTS `#__fabrik_notification` ALTER `user_id` SET DEFAULT 0;
ALTER TABLE IF EXISTS `#__fabrik_notification` ALTER `reason` SET DEFAULT '';
ALTER TABLE IF EXISTS `#__fabrik_notification` ALTER `label` SET DEFAULT '';

ALTER TABLE IF EXISTS `#__fabrik_notification_event` ALTER `reference` SET DEFAULT '';
ALTER TABLE IF EXISTS `#__fabrik_notification_event` ALTER `event` SET DEFAULT '';
ALTER TABLE IF EXISTS `#__fabrik_notification_event` ALTER `user_id` SET DEFAULT 0;
ALTER TABLE IF EXISTS `#__fabrik_notification_event` MODIFY `date_time` datetime NULL DEFAULT NULL;

ALTER TABLE IF EXISTS `#__fabrik_notification_event_sent` ALTER `notification_event_id` SET DEFAULT 0;
ALTER TABLE IF EXISTS `#__fabrik_notification_event_sent` ALTER `user_id` SET DEFAULT 0;
ALTER TABLE IF EXISTS `#__fabrik_notification_event_sent` ALTER `sent` SET DEFAULT 0;