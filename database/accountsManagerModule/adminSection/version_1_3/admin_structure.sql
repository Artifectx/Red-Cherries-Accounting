
/*Data for the table `acm_admin_chart_of_accounts` */
INSERT INTO `acm_admin_chart_of_accounts` (`chart_of_account_id`, `chart_of_account_code`, `text`, `parent_id`, `level`, `actioned_user_id`, `action_date`, `last_action_status`)
SELECT (MAX(`chart_of_account_id`) + 1), '', 'Unearned Gift Voucher Revenue', 10, 3, 1, '2021-12-13 22:50:00', 'added' FROM `acm_admin_chart_of_accounts`;

/*Data for the table `acm_admin_prime_entry_books` */
INSERT INTO `acm_admin_prime_entry_books` (`prime_entry_book_id`, `prime_entry_book_name`, `description`, `actioned_user_id`, `action_date`, `last_action_status`)
SELECT (MAX(`prime_entry_book_id`) + 1), 'Receive Payment from a Debtor in Gift Voucher', '', 1, '2021-12-13 22:50:00', 'added' FROM `acm_admin_prime_entry_books`;

SELECT @primeEntryBookId := (MAX(prime_entry_book_id)) FROM `acm_admin_prime_entry_books`;
SELECT @chartOfAccountId := (MAX(chart_of_account_id)) FROM `acm_admin_chart_of_accounts`;

/*Data for the table `acm_admin_prime_entry_book_chart_of_accounts` */
INSERT INTO `acm_admin_prime_entry_book_chart_of_accounts` (`prime_entry_book_id`, `chart_of_account_id`, `debit_or_credit`, `actioned_user_id`, `action_date`, `last_action_status`) VALUES
(@primeEntryBookId, @chartOfAccountId, 'debit', 1, '2021-12-13 22:50:00', 'added');

INSERT INTO `acm_admin_prime_entry_book_chart_of_accounts` (`prime_entry_book_id`, `chart_of_account_id`, `debit_or_credit`, `actioned_user_id`, `action_date`, `last_action_status`) VALUES
(@primeEntryBookId, 102, 'credit', 1, '2021-12-13 22:50:00', 'added');