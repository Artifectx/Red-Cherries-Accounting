<?php
$config = array(

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////---------Organization Manager Module-----------////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////---------Administration Section-----------/////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	//---------Location Screen
	//validate from add
	'locations_controller/add' => array(
		array(
			'field' => 'location_code',
			'label' => 'lang:location_code',
			//'rules' => 'trim|required|is_unique[locations.location_code]',
			'rules' => 'trim|required|callback_check_existing'
		),
		array(
			'field' => 'location_name',
			'label' => 'lang:location_name',
			'rules' => 'trim|required|is_unique[locations.location_name]',
			'rules' => 'trim|required'
		)
	),
	
	//validate from edit
	'locations_controller/edit' => array(
		array(
			'field' => 'location_code',
			'label' => 'lang:location_code',
			'rules' => 'trim|required|callback_check_existing'
		),
		array(
			'field' => 'location_name',
			'label' => 'lang:location_name',
			'rules' => 'trim|required'
		)
	),

	//---------Territory Screen
	//validate from add
	'territories_controller/add' => array(
		array(
			'field' => 'territory_code',
			'label' => 'lang:territory_code',
			//'rules' => 'trim|required|is_unique[locations.location_code]',
			'rules' => 'trim|required|callback_check_existing'
		),
		array(
			'field' => 'territory_name',
			'label' => 'lang:territory_name',
			'rules' => 'trim|required|is_unique[territories.territory_name]',
			'rules' => 'trim|required'
		)
	),

	//validate from edit
	'territories_controller/edit' => array(
		array(
			'field' => 'territory_code',
			'label' => 'lang:territory_code',
			'rules' => 'trim|required|callback_check_existing'
		),
		array(
			'field' => 'territory_name',
			'label' => 'lang:territory_name',
			'rules' => 'trim|required'
		)
	),

	//---------Calendar Day Types Screen
	//validate from add
	'calendar_day_types_controller/add' => array(
		array(
			'field' => 'day_type_code',
			'label' => 'lang:day_type_code',
			//'rules' => 'trim|required|is_unique[locations.location_code]',
			'rules' => 'trim|required|callback_check_existing'
		),
		array(
			'field' => 'day_type_name',
			'label' => 'lang:day_type_name',
			'rules' => 'trim|required|is_unique[territories.day_type_name]',
			'rules' => 'trim|required'
		)
	),

	//validate from edit
	'calendar_day_types_controller/edit' => array(
		array(
			'field' => 'day_type_code',
			'label' => 'lang:day_type_code',
			'rules' => 'trim|required|callback_check_existing'
		),
		array(
			'field' => 'day_type_name',
			'label' => 'lang:day_type_name',
			'rules' => 'trim|required'
		)
	),

	//---------People Screen
	//validate from add
	'peoples_controller/add' => array(
		array(
			'field' => 'people_type',
			'label' => 'lang:people_type',
			'rules' => 'trim|required'
		),
		array(
			'field' => 'people_code',
			'label' => 'lang:people_code',
			'rules' => 'trim|required|callback_check_existing'
		),
		array(
			'field' => 'people_name',
			'label' => 'lang:people_name',
			'rules' => 'trim|required'
		)
	),

	//validate from edit
	'peoples_controller/edit' => array(
		array(
			'field' => 'people_type',
			'label' => 'lang:people_type',
			'rules' => 'trim|required'
		),
		array(
			'field' => 'people_code',
			'label' => 'lang:people_code',
			'rules' => 'trim|required|callback_check_existing'
		),
		array(
			'field' => 'people_name',
			'label' => 'lang:people_name',
			'rules' => 'trim|required'
		)
	),

	//validate from add
	'peoples_controller/saveCashierSalesPerformanceData' => array(
		array(
			'field' => 'sales_performance_month',
			'label' => 'lang:sales_performance_month',
			'rules' => 'trim|required'
		),
		array(
			'field' => 'sales_target',
			'label' => 'lang:sales_target',
			'rules' => 'trim|required'
		)
	),

	//validate from edit
	'peoples_controller/editCashierSalesPerformanceData' => array(
		array(
			'field' => 'sales_performance_month',
			'label' => 'lang:sales_performance_month',
			'rules' => 'trim|required'
		),
		array(
			'field' => 'sales_target',
			'label' => 'lang:sales_target',
			'rules' => 'trim|required'
		)
	),
	
	//-----------About system feature screen
	'about_system_controller/send' => array(
		array(
			'field' => 'email',
			'label' => 'lang:E-mail',
			'rules' => 'trim|required|valid_email'
		)
	),
	
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////---------Organization Section-----------/////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	
	//---------Company Information Screen
	'company_information_controller/editCompany' => array(
		array(
			'field' => 'company_name',
			'label' => 'lang:Company Name',
			'rules' => 'trim|required'
		),
		array(
			'field' => 'email',
			'label' => 'lang:E-mail',
			'rules' => 'trim|required|valid_email'
		),
		array(
			'field' => 'address',
			'label' => 'lang:Address',
			'rules' => 'trim|required'
		)
	),

	//---------Company Structure Screen
	'company_structure_controller/add' => array(
		array(
			'field' => 'company_name',
			'label' => 'Company Name',
			'rules' => 'trim|required'
		)
	),
	'company_structure_controller/edit' => array(
		array(
			'field' => 'company_name',
			'label' => 'Company Name',
			'rules' => 'trim|required'
		)
	),

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////---------User Roles Manager Module-----------////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////---------User Roles Section-----------////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	//---------User Screen
	//validate from add
	'users_controller/add' => array(
		array(
			'field' => 'people_id',
			'label' => 'lang:people_id',
			'rules' => 'trim|required|callback_check_existing'
		),
		array(
			'field' => 'user_name',
			'label' => 'lang:error_user',
			'rules' => 'trim|required'
		),
		array(
			'field' => 'user_password',
			'label' => 'lang:Password',
			'rules' => 'trim|required|min_length[6]|max_length[12]'
			//'rules' => 'trim|required'
		),
		array(
			'field' => 'confirm_password',
			'label' => 'lang:confirm_password',
			'rules' => 'trim|required|matches[user_password]'
		),
		array(
			'field' => 'status',
			'label' => 'lang:Status',
			'rules' => 'trim|required'
		),
	),

	//validate from edit
	'users_controller/edit' => array(
		array(
			'field' => 'people_id_new',
			'label' => 'lang:people_id_new',
			'rules' => 'trim|required|callback_check_existing'
		),
		array(
			'field' => 'user_name',
			'label' => 'lang:error_user',
			'rules' => 'trim|required'
		),
		array(
			'field' => 'user_password',
			'label' => 'lang:Password',
			'rules' => 'trim|required|min_length[6]|max_length[12]'
		),
		array(
			'field' => 'confirm_password',
			'label' => 'lang:confirm_password',
			'rules' => 'trim|required|matches[user_password]'
		),
		array(
			'field' => 'status',
			'label' => 'lang:Status',
			'rules' => 'trim|required'
		),
	),

	//---------Login Screen
	'login/index' => array(
		array(
			'field' => 'username',
			'label' => 'lang:error_user',
			'rules' => 'trim|required'
		),
		array(
			'field' => 'password',
			'label' => 'lang:error_password',
			'rules' => 'trim|required|callback_check_user'
		)
	),

	//---------Forgot password Screen
	'login/resetPassword' => array(
		array(
			'field' => 'email',
			'label' => 'lang:email',
			'rules' => 'trim|required|valid_email'
		)
	),

	//-----------change password screen
	'profile_controller/changePassword' => array(
		array(
			'field' => 'current_password',
			'label' => 'lang:current_password',
			'rules' => 'trim|required'
		),
		array(
			'field' => 'new_password',
			'label' => 'lang:new_password',
			'rules' => 'trim|required|min_length[6]|max_length[12]'
		),
		array(
			'field' => 'confirm_password',
			'label' => 'lang:confirm_password',
			'rules' => 'trim|required|matches[new_password]'
		)
	),
	
	//-----------change language screen
	'profile_controller/changeLanguage' => array(
		array(
			'field' => 'new_language',
			'label' => 'lang:new_language',
			'rules' => 'trim|required'
		)
	),

	//derive user roles
	'derive_user_roles_controller/add' => array(
		array(
			'field' => 'derive_user_role_name',
			'label' => 'lang:derive_user_role_name',
			'rules' => 'trim|required|is_unique[urm_user_roles_derive_user_roles.derive_user_role_name]'
		),
		array(
			'field' => 'role_id',
			'label' => 'lang:user_role',
			'rules' => 'trim|required'
		)
	),

	'derive_user_roles_controller/edit' => array(
		array(
			'field' => 'derive_user_role_name',
			'label' => 'lang:derive_user_role_name',
			'rules' => 'trim|required'
		),
		array(
			'field' => 'role_id',
			'label' => 'lang:user_role',
			'rules' => 'trim|required'
		)
	),
	
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////---------Accounts  Manager Module-----------///////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////---------Administration Section-----------//////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	//---------Chart of Accounts
	'chart_of_accounts_controller/add' => array(
		array(
			'field' => 'account_type',
			'label' => 'Account Type',
			'rules' => 'trim|required'
		),
		array(
			'field' => 'chart_of_account_name',
			'label' => 'Chart of Account Name',
			'rules' => 'trim|required'
		)
	),

	'chart_of_accounts_controller/edit' => array(
		array(
			'field' => 'account_type',
			'label' => 'Account Type',
			'rules' => 'trim|required'
		),
		array(
			'field' => 'chart_of_account_name',
			'label' => 'Chart of Account Name',
			'rules' => 'trim|required'
		)
	),

	//---------Prime Entry Book Screen
	//validate from add
	'prime_entry_book_controller/add' => array(
		array(
			'field' => 'prime_entry_book_name',
			'label' => 'lang:prime_entry_book_name',
			'rules' => 'trim|required|callback_check_existing'
		)
	),

	//validate from edit
	'prime_entry_book_controller/edit' => array(
		array(
			'field' => 'prime_entry_book_name',
			'label' => 'lang:prime_entry_book_name',
			'rules' => 'trim|required|callback_check_existing'
		)
	),

	//---------Bank Screen
	//validate from add
	'bank_controller/add' => array(
		array(
			'field' => 'bank_name',
			'label' => 'lang:bank_name',
			'rules' => 'trim|required|callback_check_existing'
		)
	),

	//validate from edit
	'bank_controller/edit' => array(
		array(
			'field' => 'bank_name',
			'label' => 'lang:bank_name',
			'rules' => 'trim|required|callback_check_existing'
		)
	),
	
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////---------Bookkeeping Section-----------//////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	//---------Journal Entries Screen
	//validate from add
	'journal_entries_controller/add' => array(
		array(
			'field' => 'transaction_date',
			'label' => 'lang:transaction_date',
			'rules' => 'trim|required'
		)
	),

	//validate from edit
	'journal_entries_controller/edit' => array(
		array(
			'field' => 'transaction_date',
			'label' => 'lang:transaction_date',
			'rules' => 'trim|required'
		)
	),
	
	//---------Purchase Note Screen
	//validate from add
	'purchase_note_controller/add' => array(
		array(
			'field' => 'reference_no',
			'label' => 'lang:reference_no',
			'rules' => 'trim|required|callback_check_existing'
		),
		array(
			'field' => 'purchase_note_date',
			'label' => 'lang:purchase_note_date',
			'rules' => 'trim|required'
		),
		array(
			'field' => 'supplier_id',
			'label' => 'lang:supplier_id',
			'rules' => 'trim|required'
		),
		array(
			'field' => 'location_id',
			'label' => 'lang:location_id',
			'rules' => 'trim|required'
		),
		array(
			'field' => 'amount',
			'label' => 'lang:amount',
			'rules' => 'trim|required'
		)
	),

	//validate from edit
	'purchase_note_controller/editPurchaseNoteData' => array(
		array(
			'field' => 'reference_no',
			'label' => 'lang:reference_no',
			'rules' => 'trim|required|callback_check_existing'
		),
		array(
			'field' => 'purchase_note_date',
			'label' => 'lang:purchase_note_date',
			'rules' => 'trim|required'
		),
		array(
			'field' => 'supplier_id',
			'label' => 'lang:supplier_id',
			'rules' => 'trim|required'
		),
		array(
			'field' => 'location_id',
			'label' => 'lang:location_id',
			'rules' => 'trim|required'
		),
		array(
			'field' => 'amount',
			'label' => 'lang:amount',
			'rules' => 'trim|required'
		)
	),
	
	//---------Sales Note Screen
	//validate from add
	'sales_note_controller/add' => array(
		array(
			'field' => 'reference_no',
			'label' => 'lang:reference_no',
			'rules' => 'trim|required|callback_check_existing'
		),
		array(
			'field' => 'sales_note_date',
			'label' => 'lang:sales_note_date',
			'rules' => 'trim|required'
		),
		array(
			'field' => 'location_id',
			'label' => 'lang:location_id',
			'rules' => 'trim|required'
		),
		array(
			'field' => 'sales_amount',
			'label' => 'lang:sales_amount',
			'rules' => 'trim|required'
		)
	),

	//validate from edit
	'sales_note_controller/editSalesNoteData' => array(
		array(
			'field' => 'reference_no',
			'label' => 'lang:reference_no',
			'rules' => 'trim|required|callback_check_existing'
		),
		array(
			'field' => 'sales_note_date',
			'label' => 'lang:sales_note_date',
			'rules' => 'trim|required'
		),
		array(
			'field' => 'location_id',
			'label' => 'lang:location_id',
			'rules' => 'trim|required'
		),
		array(
			'field' => 'sales_amount',
			'label' => 'lang:sales_amount',
			'rules' => 'trim|required'
		)
	),
	
	//---------Customer Return Note Screen
	//validate from add
	'customer_return_note_controller/add' => array(
		array(
			'field' => 'reference_no',
			'label' => 'lang:reference_no',
			'rules' => 'trim|required|callback_check_existing'
		),
		array(
			'field' => 'customer_return_note_date',
			'label' => 'lang:customer_return_note_date',
			'rules' => 'trim|required'
		),
		array(
			'field' => 'customer_id',
			'label' => 'lang:customer_id',
			'rules' => 'trim|required'
		),
		array(
			'field' => 'location_id',
			'label' => 'lang:location_id',
			'rules' => 'trim|required'
		),
		array(
			'field' => 'customer_return_amount',
			'label' => 'lang:customer_return_amount',
			'rules' => 'trim|required'
		)
	),

	//validate from edit
	'customer_return_note_controller/editCustomerReturnNoteData' => array(
		array(
			'field' => 'reference_no',
			'label' => 'lang:reference_no',
			'rules' => 'trim|required|callback_check_existing'
		),
		array(
			'field' => 'customer_return_note_date',
			'label' => 'lang:customer_return_note_date',
			'rules' => 'trim|required'
		),
		array(
			'field' => 'customer_id',
			'label' => 'lang:customer_id',
			'rules' => 'trim|required'
		),
		array(
			'field' => 'location_id',
			'label' => 'lang:location_id',
			'rules' => 'trim|required'
		),
		array(
			'field' => 'customer_return_amount',
			'label' => 'lang:customer_return_amount',
			'rules' => 'trim|required'
		)
	),
	
	//---------Supplier Return Note Screen
	//validate from add
	'supplier_return_note_controller/add' => array(
		array(
			'field' => 'reference_no',
			'label' => 'lang:reference_no',
			'rules' => 'trim|required|callback_check_existing'
		),
		array(
			'field' => 'supplier_return_note_date',
			'label' => 'lang:supplier_return_note_date',
			'rules' => 'trim|required'
		),
		array(
			'field' => 'supplier_id',
			'label' => 'lang:supplier_id',
			'rules' => 'trim|required'
		),
		array(
			'field' => 'location_id',
			'label' => 'lang:location_id',
			'rules' => 'trim|required'
		),
		array(
			'field' => 'supplier_return_amount',
			'label' => 'lang:supplier_return_amount',
			'rules' => 'trim|required'
		)
	),

	//validate from edit
	'supplier_return_note_controller/editSupplierReturnNoteData' => array(
		array(
			'field' => 'reference_no',
			'label' => 'lang:reference_no',
			'rules' => 'trim|required|callback_check_existing'
		),
		array(
			'field' => 'supplier_return_note_date',
			'label' => 'lang:supplier_return_note_date',
			'rules' => 'trim|required'
		),
		array(
			'field' => 'supplier_id',
			'label' => 'lang:supplier_id',
			'rules' => 'trim|required'
		),
		array(
			'field' => 'location_id',
			'label' => 'lang:location_id',
			'rules' => 'trim|required'
		),
		array(
			'field' => 'supplier_return_amount',
			'label' => 'lang:supplier_return_amount',
			'rules' => 'trim|required'
		)
	),
	
	//---------Receive Payment Screen
	//validate from add
	'receive_payment_controller/add' => array(
		array(
			'field' => 'reference_no',
			'label' => 'lang:reference_no',
			'rules' => 'trim|required|callback_check_existing'
		),
		array(
			'field' => 'receive_payment_date',
			'label' => 'lang:receive_payment_date',
			'rules' => 'trim|required'
		),
		array(
			'field' => 'payer_type',
			'label' => 'lang:payer_type',
			'rules' => 'trim|required'
		),
		array(
			'field' => 'payer_id',
			'label' => 'lang:payer_id',
			'rules' => 'trim|required'
		),
		array(
			'field' => 'location_id',
			'label' => 'lang:location_id',
			'rules' => 'trim|required'
		)
	),

	//validate from edit
	'receive_payment_controller/editReceivePaymentData' => array(
		array(
			'field' => 'reference_no',
			'label' => 'lang:reference_no',
			'rules' => 'trim|required|callback_check_existing'
		),
		array(
			'field' => 'receive_payment_date',
			'label' => 'lang:receive_payment_date',
			'rules' => 'trim|required'
		)
	),
	
	//---------Make Payment Screen
	//validate from add
	'make_payment_controller/add' => array(
		array(
			'field' => 'reference_no',
			'label' => 'lang:reference_no',
			'rules' => 'trim|required|callback_check_existing'
		),
		array(
			'field' => 'make_payment_date',
			'label' => 'lang:make_payment_date',
			'rules' => 'trim|required'
		),
		array(
			'field' => 'payee_type',
			'label' => 'lang:payee_type',
			'rules' => 'trim|required'
		),
		array(
			'field' => 'payee_id',
			'label' => 'lang:payee_id',
			'rules' => 'trim|required'
		),
		array(
			'field' => 'location_id',
			'label' => 'lang:location_id',
			'rules' => 'trim|required'
		)
	),

	//validate from edit
	'make_payment_controller/editMakePaymentData' => array(
		array(
			'field' => 'reference_no',
			'label' => 'lang:reference_no',
			'rules' => 'trim|required|callback_check_existing'
		),
		array(
			'field' => 'make_payment_date',
			'label' => 'lang:make_payment_date',
			'rules' => 'trim|required'
		)
	),

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////---------Service Manager Module-----------//////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////---------Reservation Manager-----------/////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////---------Administration Section-----------/////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	//---------Buildings Screen
	//validate from add building
	'buildings_controller/add' => array(
		array(
			'field' => 'building_name',
			'label' => 'lang:building_name',
			'rules' => 'trim|required|callback_check_existing'
		),
		array(
			'field' => 'location_id',
			'label' => 'location_id',
			'rules' => 'trim|required'
		)
	),

	//validate from edit building
	'buildings_controller/edit' => array(
		array(
			'field' => 'building_name',
			'label' => 'lang:building_name',
			'rules' => 'trim|required|callback_check_existing'
		),
		array(
			'field' => 'location_id',
			'label' => 'location_id',
			'rules' => 'trim|required'
		)
	),
	
	
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////---------Donation Manager-----------/////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////---------Administration Section-----------/////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	//---------Programs Screen
	//validate from add program
	'programs_controller/add' => array(
		array(
			'field' => 'program_name',
			'label' => 'lang:program_name',
			'rules' => 'trim|required|callback_check_existing'
		),
		array(
			'field' => 'coordinator_id',
			'label' => 'coordinator_id',
			'rules' => 'trim|required'
		)
	),

	//validate from edit program
	'programs_controller/edit' => array(
		array(
			'field' => 'program_name',
			'label' => 'lang:program_name',
			'rules' => 'trim|required|callback_check_existing'
		),
		array(
			'field' => 'coordinator_id',
			'label' => 'coordinator_id',
			'rules' => 'trim|required'
		)
	),
	
	//---------Collect Donations Screen
	//validate from add collect donation
	'collect_donations_controller/add' => array(
		array(
			'field' => 'program_id',
			'label' => 'lang:program_id',
			'rules' => 'trim|required'
		),
		array(
			'field' => 'date',
			'label' => 'date',
			'rules' => 'trim|required'
		),
		array(
			'field' => 'donor_id',
			'label' => 'donor_id',
			'rules' => 'trim|required'
		),
		array(
			'field' => 'amount',
			'label' => 'amount',
			'rules' => 'trim|required'
		)
	),

	//validate from edit collect donation
	'collect_donations_controller/edit' => array(
		array(
			'field' => 'program_id',
			'label' => 'lang:program_id',
			'rules' => 'trim|required'
		),
		array(
			'field' => 'date',
			'label' => 'date',
			'rules' => 'trim|required'
		),
		array(
			'field' => 'donor_id',
			'label' => 'donor_id',
			'rules' => 'trim|required'
		),
		array(
			'field' => 'amount',
			'label' => 'amount',
			'rules' => 'trim|required'
		)
	),
	
	//---------Program Progress Screen
	//validate from add collect donation
	'program_progress_controller/saveProgramActivityData' => array(
		array(
			'field' => 'activity_name',
			'label' => 'lang:activity_name',
			'rules' => 'trim|required|callback_check_existing'
		),
		array(
			'field' => 'start_date',
			'label' => 'start_date',
			'rules' => 'trim|required'
		),
		array(
			'field' => 'finish_date',
			'label' => 'finish_date',
			'rules' => 'trim|required'
		),
		array(
			'field' => 'activity_owner_id',
			'label' => 'activity_owner_id',
			'rules' => 'trim|required'
		),
		array(
			'field' => 'activity_budget',
			'label' => 'activity_budget',
			'rules' => 'trim|required'
		)
	),

	//validate from budget issue
	'program_progress_controller/saveProgramActivityBudgetIssue' => array(
		array(
			'field' => 'issue_date',
			'label' => 'lang:issue_date',
			'rules' => 'trim|required'
		),
		array(
			'field' => 'budget_issue_amount',
			'label' => 'budget_issue_amount',
			'rules' => 'trim|required'
		)
	),
	
	//validate from collect budget return
	'program_progress_controller/saveProgramActivityBudgetReturn' => array(
		array(
			'field' => 'return_date',
			'label' => 'lang:return_date',
			'rules' => 'trim|required'
		),
		array(
			'field' => 'budget_return_amount',
			'label' => 'budget_return_amount',
			'rules' => 'trim|required'
		)
	)
);
