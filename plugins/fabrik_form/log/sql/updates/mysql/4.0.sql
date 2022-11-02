ALTER TABLE IF EXISTS `#__fabrik_change_log_fields` ALTER `parent_id` SET DEFAULT 0;
ALTER TABLE IF EXISTS `#__fabrik_change_log_fields` ALTER `user_id` SET DEFAULT 0;
ALTER TABLE IF EXISTS `#__fabrik_change_log_fields` MODIFY `time_date` datetime NULL DEFAULT NULL;
ALTER TABLE IF EXISTS `#__fabrik_change_log_fields` ALTER `form_id` SET DEFAULT 0;
ALTER TABLE IF EXISTS `#__fabrik_change_log_fields` ALTER `list_id` SET DEFAULT 0;
ALTER TABLE IF EXISTS `#__fabrik_change_log_fields` ALTER `element_id` SET DEFAULT 0;
ALTER TABLE IF EXISTS `#__fabrik_change_log_fields` ALTER `row_id` SET DEFAULT 0;
ALTER TABLE IF EXISTS `#__fabrik_change_log_fields` ALTER `join_id` SET DEFAULT 0;
ALTER TABLE IF EXISTS `#__fabrik_change_log_fields` ALTER `pk_id` SET DEFAULT 0;
ALTER TABLE IF EXISTS `#__fabrik_change_log_fields` ALTER `table_name` SET DEFAULT '';
ALTER TABLE IF EXISTS `#__fabrik_change_log_fields` ALTER `field_name` SET DEFAULT '';
ALTER TABLE IF EXISTS `#__fabrik_change_log_fields` ALTER `log_type_id` SET DEFAULT 0;
ALTER TABLE IF EXISTS `#__fabrik_change_log_fields` ALTER `newsletter_engine` SET DEFAULT '';

ALTER TABLE IF EXISTS `#__fabrik_change_log` ALTER `user_id` SET DEFAULT 0;
ALTER TABLE IF EXISTS `#__fabrik_change_log` ALTER `ip_address` SET DEFAULT '';
ALTER TABLE IF EXISTS `#__fabrik_change_log` MODIFY `time_date` datetime NULL DEFAULT NULL;
ALTER TABLE IF EXISTS `#__fabrik_change_log` ALTER `form_id` SET DEFAULT 0;
ALTER TABLE IF EXISTS `#__fabrik_change_log` ALTER `list_id` SET DEFAULT 0;
ALTER TABLE IF EXISTS `#__fabrik_change_log` ALTER `row_id` SET DEFAULT 0;
ALTER TABLE IF EXISTS `#__fabrik_change_log` ALTER `join_id` SET DEFAULT 0;
ALTER TABLE IF EXISTS `#__fabrik_change_log` ALTER `log_type_id` SET DEFAULT 0;
ALTER TABLE IF EXISTS `#__fabrik_change_log` ALTER `parent_id` SET DEFAULT 0;

ALTER TABLE IF EXISTS `#__fabrik_change_log_types` ALTER `type` SET DEFAULT '';