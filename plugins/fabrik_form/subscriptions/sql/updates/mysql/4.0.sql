ALTER TABLE IF EXISTS `#__fabrik_subs_invoices` ALTER `subscr_id` SET DEFAULT 0;
ALTER TABLE IF EXISTS `#__fabrik_subs_invoices` ALTER `invoice_number` SET DEFAULT '';
ALTER TABLE IF EXISTS `#__fabrik_subs_invoices` MODIFY `transaction_date` datetime NULL DEFAULT NULL;
ALTER TABLE IF EXISTS `#__fabrik_subs_invoices` ALTER `gateway_id` SET DEFAULT 0;
ALTER TABLE IF EXISTS `#__fabrik_subs_invoices` ALTER `amount` SET DEFAULT 0;
ALTER TABLE IF EXISTS `#__fabrik_subs_invoices` ALTER `currency` SET DEFAULT '';
ALTER TABLE IF EXISTS `#__fabrik_subs_invoices` ALTER `paid` SET DEFAULT 0;
ALTER TABLE IF EXISTS `#__fabrik_subs_invoices` ALTER `pp_txn_id` SET DEFAULT '';
ALTER TABLE IF EXISTS `#__fabrik_subs_invoices` ALTER `pp_payment_amount` SET DEFAULT '';
ALTER TABLE IF EXISTS `#__fabrik_subs_invoices` ALTER `pp_payment_status` SET DEFAULT '';
ALTER TABLE IF EXISTS `#__fabrik_subs_invoices` ALTER `pp_txn_type` SET DEFAULT '';
ALTER TABLE IF EXISTS `#__fabrik_subs_invoices` ALTER `pp_fee` SET DEFAULT '';
ALTER TABLE IF EXISTS `#__fabrik_subs_invoices` ALTER `pp_payer_email` SET DEFAULT '';

ALTER TABLE IF EXISTS `#__fabrik_subs_plans` ALTER `active` SET DEFAULT 0;
ALTER TABLE IF EXISTS `#__fabrik_subs_plans` ALTER `visible` SET DEFAULT 0;
ALTER TABLE IF EXISTS `#__fabrik_subs_plans` ALTER `ordering` SET DEFAULT '999999';
ALTER TABLE IF EXISTS `#__fabrik_subs_plans` ALTER `plan_name` SET DEFAULT '';
ALTER TABLE IF EXISTS `#__fabrik_subs_plans` ALTER `usergroup` SET DEFAULT 0;
ALTER TABLE IF EXISTS `#__fabrik_subs_plans` ALTER `strapline` SET DEFAULT '';

ALTER TABLE IF EXISTS `#__fabrik_subs_cron_emails` ALTER `subject` SET DEFAULT '';
ALTER TABLE IF EXISTS `#__fabrik_subs_cron_emails` ALTER `event_type` SET DEFAULT '';
ALTER TABLE IF EXISTS `#__fabrik_subs_cron_emails` ALTER `timeunit` SET DEFAULT '';
ALTER TABLE IF EXISTS `#__fabrik_subs_cron_emails` ALTER `time_value` SET DEFAULT 0;

ALTER TABLE IF EXISTS `#__fabrik_subs_payment_gateways` ALTER `name` SET DEFAULT '';

ALTER TABLE IF EXISTS `#__fabrik_subs_plan_billing_cycle` ALTER `plan_id` SET DEFAULT 0;
ALTER TABLE IF EXISTS `#__fabrik_subs_plan_billing_cycle` ALTER `duration` SET DEFAULT 0;
ALTER TABLE IF EXISTS `#__fabrik_subs_plan_billing_cycle` ALTER `period_unit` SET DEFAULT '';
ALTER TABLE IF EXISTS `#__fabrik_subs_plan_billing_cycle` ALTER `cost` SET DEFAULT 0;
ALTER TABLE IF EXISTS `#__fabrik_subs_plan_billing_cycle` ALTER `currency` SET DEFAULT '';
ALTER TABLE IF EXISTS `#__fabrik_subs_plan_billing_cycle` ALTER `description` SET DEFAULT '';
ALTER TABLE IF EXISTS `#__fabrik_subs_plan_billing_cycle` ALTER `label` SET DEFAULT '';
ALTER TABLE IF EXISTS `#__fabrik_subs_plan_billing_cycle` ALTER `plan_name` SET DEFAULT '';

ALTER TABLE IF EXISTS `#__fabrik_subs_subscriptions` ALTER `userid` SET DEFAULT 0;
ALTER TABLE IF EXISTS `#__fabrik_subs_subscriptions` ALTER `primary` SET DEFAULT 0;
ALTER TABLE IF EXISTS `#__fabrik_subs_subscriptions` ALTER `type` SET DEFAULT 0;
ALTER TABLE IF EXISTS `#__fabrik_subs_subscriptions` ALTER `status` SET DEFAULT '';
ALTER TABLE IF EXISTS `#__fabrik_subs_subscriptions` MODIFY `signup_date` datetime NULL DEFAULT NULL;
ALTER TABLE IF EXISTS `#__fabrik_subs_subscriptions` MODIFY `lastpay_date` datetime NULL DEFAULT NULL;
ALTER TABLE IF EXISTS `#__fabrik_subs_subscriptions` MODIFY `cancel_date` datetime NULL DEFAULT NULL;
ALTER TABLE IF EXISTS `#__fabrik_subs_subscriptions` MODIFY `eot_date` datetime NULL DEFAULT NULL;
ALTER TABLE IF EXISTS `#__fabrik_subs_subscriptions` ALTER `eot_cause` SET DEFAULT '';
ALTER TABLE IF EXISTS `#__fabrik_subs_subscriptions` ALTER `plan` SET DEFAULT 0;
ALTER TABLE IF EXISTS `#__fabrik_subs_subscriptions` ALTER `recurring` SET DEFAULT 0;
ALTER TABLE IF EXISTS `#__fabrik_subs_subscriptions` ALTER `lifetime` SET DEFAULT 0;
ALTER TABLE IF EXISTS `#__fabrik_subs_subscriptions` MODIFY `expiration` datetime NULL DEFAULT NULL;

ALTER TABLE IF EXISTS `#__fabrik_subs_users` MODIFY `time_date` datetime NULL DEFAULT NULL;
ALTER TABLE IF EXISTS `#__fabrik_subs_users` ALTER `userid` SET DEFAULT '';
ALTER TABLE IF EXISTS `#__fabrik_subs_users` ALTER `name` SET DEFAULT '';
ALTER TABLE IF EXISTS `#__fabrik_subs_users` ALTER `username` SET DEFAULT '';
ALTER TABLE IF EXISTS `#__fabrik_subs_users` ALTER `email` SET DEFAULT '';
ALTER TABLE IF EXISTS `#__fabrik_subs_users` ALTER `password` SET DEFAULT '';
ALTER TABLE IF EXISTS `#__fabrik_subs_users` ALTER `plan_id` SET DEFAULT 0;
ALTER TABLE IF EXISTS `#__fabrik_subs_users` ALTER `gateway` SET DEFAULT 0;
ALTER TABLE IF EXISTS `#__fabrik_subs_users` ALTER `pp_txn_id` SET DEFAULT '';
ALTER TABLE IF EXISTS `#__fabrik_subs_users` ALTER `pp_payment_amount` SET DEFAULT '';
ALTER TABLE IF EXISTS `#__fabrik_subs_users` ALTER `pp_payment_status` SET DEFAULT '';
ALTER TABLE IF EXISTS `#__fabrik_subs_users` ALTER `billing_cycle` SET DEFAULT 0;
ALTER TABLE IF EXISTS `#__fabrik_subs_users` ALTER `billing_duration` SET DEFAULT '';
ALTER TABLE IF EXISTS `#__fabrik_subs_users` ALTER `billing_period` SET DEFAULT '';