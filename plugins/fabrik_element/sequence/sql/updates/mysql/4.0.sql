ALTER TABLE IF EXISTS `#__fabrik_sequences` ALTER `table_name` SET DEFAULT '';
ALTER TABLE IF EXISTS `#__fabrik_sequences` ALTER `affix` SET DEFAULT '';
ALTER TABLE IF EXISTS `#__fabrik_sequences` ALTER `sequence` SET DEFAULT 0;
ALTER TABLE IF EXISTS `#__fabrik_sequences` ALTER `element_id` SET DEFAULT 0;
ALTER TABLE IF EXISTS `#__fabrik_sequences` MODIFY `date_created` datetime NULL DEFAULT NULL;