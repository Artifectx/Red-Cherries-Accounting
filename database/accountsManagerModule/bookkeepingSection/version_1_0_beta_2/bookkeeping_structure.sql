
/*Alter `acm_bookkeeping_make_payment_reference_transactions` Table*/
ALTER TABLE `acm_bookkeeping_make_payment_reference_transactions`
    ADD COLUMN `reference_transaction_note` varchar(50) DEFAULT '' AFTER `reference_transaction_id`;

/*Alter `acm_bookkeeping_make_payment_reference_trans_histry` Table*/
ALTER TABLE `acm_bookkeeping_make_payment_reference_trans_histry`
    ADD COLUMN `reference_transaction_note` varchar(50) DEFAULT '' AFTER `reference_transaction_id`;

/*Alter `acm_bookkeeping_receive_payment_reference_transactions` Table*/
ALTER TABLE `acm_bookkeeping_receive_payment_reference_transactions`
    ADD COLUMN `reference_transaction_note` varchar(50) DEFAULT '' AFTER `reference_transaction_id`;

/*Alter `acm_bookkeeping_receive_payment_reference_trans_histry` Table*/
ALTER TABLE `acm_bookkeeping_receive_payment_reference_trans_histry`
    ADD COLUMN `reference_transaction_note` varchar(50) DEFAULT '' AFTER `reference_transaction_id`;