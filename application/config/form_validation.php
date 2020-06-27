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
///////////////////////////////////////////////////////////////////////////////////---------Stock Manager Module-----------///////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////---------Administration Section-----------////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	//---------Vehicles Screen
	//validate from add
	'vehicles_controller/add' => array(
		array(
			'field' => 'vehicle_code',
			'label' => 'lang:vehicle_code',
			'rules' => 'trim|required|callback_check_existing'
		),
		array(
			'field' => 'vehicle_number',
			'label' => 'lang:vehicle_number',
			'rules' => 'trim|required'
		),
		array(
			'field' => 'vehicle_owner_type',
			'label' => 'lang:vehicle_owner_type',
			'rules' => 'trim|required'
		),
		array(
			'field' => 'location_id',
			'label' => 'lang:location_id',
			'rules' => 'trim|required'
		)
	),

	//validate from edit
	'vehicles_controller/edit' => array(
		array(
			'field' => 'vehicle_code',
			'label' => 'lang:vehicle_code',
			'rules' => 'trim|required|callback_check_existing'
		),
		array(
			'field' => 'vehicle_number',
			'label' => 'lang:vehicle_number',
			'rules' => 'trim|required'
		),
		array(
			'field' => 'vehicle_owner_type',
			'label' => 'lang:vehicle_owner_type',
			'rules' => 'trim|required'
		),
		array(
			'field' => 'location_id',
			'label' => 'lang:location_id',
			'rules' => 'trim|required'
		)
	),

	//---------Unit Screen
	//validate from add
	'units_controller/add' => array(
		array(
			'field' => 'unit_name',
			'label' => 'lang:unit_name',
			'rules' => 'trim|required|callback_check_existing'
		)
	),

	//validate from edit
	'units_controller/edit' => array(
		array(
			'field' => 'unit_name',
			'label' => 'lang:unit_name',
			'rules' => 'trim|required|callback_check_existing'
		)
	),

	//---------Unit Conversion Screen
	//validate from add
	'unit_conversions_controller/add' => array(
		array(
			'field' => 'unit_conversion_name',
			'label' => 'lang:unit_conversion_name',
			'rules' => 'trim|required|callback_check_existing'
		)
	),

	//validate from edit
	'unit_conversions_controller/edit' => array(
		array(
			'field' => 'unit_conversion_name',
			'label' => 'lang:unit_conversion_name',
			'rules' => 'trim|required|callback_check_existing'
		)
	),

	//---------Tax Type Screen
	//validate from add
	'tax_types_controller/add' => array(
		array(
			'field' => 'tax_name',
			'label' => 'lang:tax_name',
			'rules' => 'trim|required|callback_check_existing'
		),
		array(
			'field' => 'tax_percentage',
			'label' => 'lang:tax_percentage',
			'rules' => 'trim|required'
		)
	),

	//validate from edit
	'tax_types_controller/edit' => array(
		array(
			'field' => 'tax_name',
			'label' => 'lang:tax_name',
			'rules' => 'trim|required|callback_check_existing'
		),
		array(
			'field' => 'tax_percentage',
			'label' => 'lang:tax_percentage',
			'rules' => 'trim|required'
		)
	),

	//---------Tax Chain Screen
	//validate from add
	'tax_chains_controller/add' => array(
		array(
			'field' => 'tax_chain_name',
			'label' => 'lang:tax_chain_name',
			'rules' => 'trim|required|callback_check_existing'
		)
	),

	//validate from edit
	'tax_chains_controller/edit' => array(
		array(
			'field' => 'tax_chain_name',
			'label' => 'lang:tax_chain_name',
			'rules' => 'trim|required|callback_check_existing'
		)
	),

	//---------Warehouse Screen
	//validate from add
	'warehouses_controller/add' => array(
		array(
			'field' => 'warehouse_code',
			'label' => 'lang:warehouse_code',
			'rules' => 'trim|required|callback_check_existing'
		),
		array(
			'field' => 'warehouse_name',
			'label' => 'lang:warehouse_name',
			'rules' => 'trim|required'
		),
		array(
			'field' => 'location_id',
			'label' => 'lang:location_id',
			'rules' => 'trim|required'
		)
	),

	//validate from edit
	'warehouses_controller/edit' => array(
		array(
			'field' => 'warehouse_code',
			'label' => 'lang:warehouse_code',
			'rules' => 'trim|required|callback_check_existing'
		),
		array(
			'field' => 'warehouse_name',
			'label' => 'lang:warehouse_name',
			'rules' => 'trim|required'
		),
		array(
			'field' => 'location_id',
			'label' => 'lang:location_id',
			'rules' => 'trim|required'
		)
	),

	//---------Sales Terminals Screen
	//validate from add
	'sales_terminals_controller/add' => array(
		array(
			'field' => 'sales_terminal_code',
			'label' => 'lang:sales_terminal_code',
			'rules' => 'trim|required|callback_check_existing_terminal_code'
		),
		array(
			'field' => 'sales_terminal_name',
			'label' => 'lang:sales_terminal_name',
			'rules' => 'trim|required|callback_check_existing_terminal_name'
		),
		array(
			'field' => 'warehouse_id',
			'label' => 'lang:warehouse_id',
			'rules' => 'trim|required'
		)
	),

	//validate from edit
	'sales_terminals_controller/edit' => array(
		array(
			'field' => 'sales_terminal_code',
			'label' => 'lang:sales_terminal_code',
			'rules' => 'trim|required|callback_check_existing_terminal_code'
		),
		array(
			'field' => 'sales_terminal_name',
			'label' => 'lang:sales_terminal_code',
			'rules' => 'trim|required|callback_check_existing_terminal_name'
		),
		array(
			'field' => 'warehouse_id',
			'label' => 'lang:warehouse_id',
			'rules' => 'trim|required'
		)
	),

	//---------Cash Units Screen
	//validate from add
	'cash_units_controller/add' => array(
		array(
			'field' => 'cash_unit_name',
			'label' => 'lang:cash_unit_name',
			'rules' => 'trim|required|callback_check_existing'
		)
	),

	//validate from edit
	'cash_units_controller/edit' => array(
		array(
			'field' => 'cash_unit_name',
			'label' => 'lang:cash_unit_name',
			'rules' => 'trim|required|callback_check_existing'
		)
	),
    
    //---------Wholesales Category Screen
	//validate from add
	'wholesales_category_controller/add' => array(
		array(
			'field' => 'wholesales_category_code',
			'label' => 'lang:wholesales_category_code',
			'rules' => 'trim|required'
		),
        array(
			'field' => 'wholesales_category_name',
			'label' => 'lang:wholesales_category_name',
			'rules' => 'trim|required|callback_check_existing'
		)
	),

	//validate from edit
	'wholesales_category_controller/edit' => array(
		array(
			'field' => 'wholesales_category_code',
			'label' => 'lang:wholesales_category_code',
			'rules' => 'trim|required'
		),
        array(
			'field' => 'wholesales_category_name',
			'label' => 'lang:wholesales_category_name',
			'rules' => 'trim|required|callback_check_existing'
		)
	),
	
	//---------Category Screen
	//validate from add
	'categories_fg_controller/add' => array(
		array(
			'field' => 'category_name',
			'label' => 'lang:category_name',
			'rules' => 'trim|required|callback_check_existing'
		)
	),

	//validate from edit
	'categories_fg_controller/edit' => array(
		array(
			'field' => 'category_name',
			'label' => 'lang:category_name',
			'rules' => 'trim|required|callback_check_existing'
		)
	),

	//---------Sub Category Screen
	//validate from add
	'sub_categories_fg_controller/add' => array(
		array(
			'field' => 'category_id',
			'label' => 'lang:category_name',
			'rules' => 'trim|required'
		),
		array(
			'field' => 'sub_category_name',
			'label' => 'lang:sub_category_name',
			'rules' => 'trim|required|callback_check_existing'
		)
	),

	//validate from edit
	'sub_categories_fg_controller/edit' => array(
		array(
			'field' => 'category_id',
			'label' => 'lang:category_name',
			'rules' => 'trim|required'
		),
		array(
			'field' => 'sub_category_name',
			'label' => 'lang:sub_category_name',
			'rules' => 'trim|required|callback_check_existing'
		)
	),

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////---------Finish Good Inventory Section-----------//////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	//---------Product Screen
	//validate from add
	'products_fg_controller/add' => array(
		array(
			'field' => 'category_id',
			'label' => 'lang:category_name',
			'rules' => 'trim|required'
		),
		array(
			'field' => 'unit_id',
			'label' => 'lang:unit_name',
			'rules' => 'trim|required'
		),
		array(
			'field' => 'product_code',
			'label' => 'lang:product_code',
			'rules' => 'trim|required|callback_check_existing'
		),
		array(
			'field' => 'product_name',
			'label' => 'lang:product_name',
			'rules' => 'trim|required'
		),
		array(
			'field' => 'display_unit_id',
			'label' => 'lang:display_unit',
			'rules' => 'trim|required'
		)
	),

	//validate from edit
	'products_fg_controller/edit' => array(
		array(
			'field' => 'category_id',
			'label' => 'lang:category_name',
			'rules' => 'trim|required'
		),
		array(
			'field' => 'unit_id',
			'label' => 'lang:unit_name',
			'rules' => 'trim|required'
		),
		array(
			'field' => 'product_code',
			'label' => 'lang:product_code',
			'rules' => 'trim|required|callback_check_existing'
		),
		array(
			'field' => 'product_name',
			'label' => 'lang:product_name',
			'rules' => 'trim|required'
		),
		array(
			'field' => 'display_unit_id',
			'label' => 'lang:display_unit',
			'rules' => 'trim|required'
		)
	),

	//---------Open Stock Screen
	//validate from add
	'warehouse_opening_stock_fg_controller/add' => array(
		array(
			'field' => 'stock_date',
			'label' => 'lang:stock_date',
			'rules' => 'trim|required'
		),
		array(
			'field' => 'warehouse_id',
			'label' => 'lang:Warehouse',
			'rules' => 'trim|required'
		),
		array(
			'field' => 'unit_id',
			'label' => 'lang:unit',
			'rules' => 'trim|required'
		),
		array(
			'field' => 'product_quantity',
			'label' => 'lang:quantity',
			'rules' => 'trim|required|numeric'
		),
		array(
			'field' => 'product_id',
			'label' => 'lang:product',
			'rules' => 'trim|required'
		)
	),

	//validate from edit
	'warehouse_opening_stock_fg_controller/edit' => array(
		array(
			'field' => 'stock_date',
			'label' => 'lang:stock_date',
			'rules' => 'trim|required'
		),
		array(
			'field' => 'warehouse_id',
			'label' => 'lang:Warehouse',
			'rules' => 'trim|required'
		),
		array(
			'field' => 'unit_id',
			'label' => 'lang:unit',
			'rules' => 'trim|required'
		),
		array(
			'field' => 'product_quantity',
			'label' => 'lang:quantity',
			'rules' => 'trim|required|numeric'
		),
		array(
			'field' => 'product_id',
			'label' => 'lang:product',
			'rules' => 'trim|required'
		)
	),

	//---------PO Screen
	//validate from add
	'purchase_order_fg_controller/add' => array(
		array(
			'field' => 'reference_no',
			'label' => 'lang:reference_no',
			'rules' => 'trim|required|callback_check_existing'
		),
		array(
			'field' => 'po_date',
			'label' => 'lang:po_date',
			'rules' => 'trim|required'
		),
		array(
			'field' => 'supplier_id',
			'label' => 'lang:supplier_id',
			'rules' => 'trim|required'
		),
		array(
			'field' => 'warehouse_id',
			'label' => 'lang:warehouse_id',
			'rules' => 'trim|required'
		)
	),

	//validate from edit
	'purchase_order_fg_controller/editPOProductData' => array(
		array(
			'field' => 'product_id',
			'label' => 'lang:product',
			'rules' => 'trim|required'
		),
		array(
			'field' => 'product_quantity',
			'label' => 'lang:quantity',
			'rules' => 'trim|required|numeric'
		),
		array(
			'field' => 'unit_id',
			'label' => 'lang:unit',
			'rules' => 'trim|required'
		)
	),

	//validate from edit
	'purchase_order_fg_controller/editPOProductIssueData' => array(
		array(
			'field' => 'product_id',
			'label' => 'lang:product',
			'rules' => 'trim|required'
		),
		array(
			'field' => 'product_quantity',
			'label' => 'lang:quantity',
			'rules' => 'trim|required|numeric'
		),
		array(
			'field' => 'unit_id',
			'label' => 'lang:unit',
			'rules' => 'trim|required'
		)
	),

	//validate from edit
	'purchase_order_fg_controller/editPOData' => array(
		array(
			'field' => 'reference_no',
			'label' => 'lang:reference_no',
			'rules' => 'trim|required|callback_check_existing'
		),
		array(
			'field' => 'po_date',
			'label' => 'lang:po_date',
			'rules' => 'trim|required'
		),
		array(
			'field' => 'supplier_id',
			'label' => 'lang:supplier_id',
			'rules' => 'trim|required'
		),
		array(
			'field' => 'warehouse_id',
			'label' => 'lang:warehouse_id',
			'rules' => 'trim|required'
		)
	),

	//validate from add PO product
	'purchase_order_fg_controller/savePOProductData' => array(
		array(
			'field' => 'product_id',
			'label' => 'lang:product',
			'rules' => 'trim|required'
		),
		array(
			'field' => 'po_quantity',
			'label' => 'lang:quantity',
			'rules' => 'trim|required|numeric'
		),
		array(
			'field' => 'unit_id',
			'label' => 'lang:unit',
			'rules' => 'trim|required'
		)
	),

	//---------GRN Screen
	//validate from add
	'good_receive_note_fg_controller/add' => array(
		array(
			'field' => 'reference_no',
			'label' => 'lang:reference_no',
			'rules' => 'trim|required|callback_check_existing'
		),
		array(
			'field' => 'grn_date',
			'label' => 'lang:grn_date',
			'rules' => 'trim|required'
		),
		array(
			'field' => 'supplier_id',
			'label' => 'lang:supplier_id',
			'rules' => 'trim|required'
		),
		array(
			'field' => 'warehouse_id',
			'label' => 'lang:warehouse_id',
			'rules' => 'trim|required'
		)
	),

	//validate from edit
	'good_receive_note_fg_controller/editGRNProductData' => array(
		array(
			'field' => 'product_id',
			'label' => 'lang:product',
			'rules' => 'trim|required'
		),
		array(
			'field' => 'product_quantity',
			'label' => 'lang:quantity',
			'rules' => 'trim|required|numeric'
		)
	),

	'good_receive_note_fg_controller/editGRNData' => array(
		array(
			'field' => 'reference_no',
			'label' => 'lang:reference_no',
			'rules' => 'trim|required|callback_check_existing'
		),
		array(
			'field' => 'grn_date',
			'label' => 'lang:grn_date',
			'rules' => 'trim|required'
		),
		array(
			'field' => 'supplier_id',
			'label' => 'lang:supplier_id',
			'rules' => 'trim|required'
		),
		array(
			'field' => 'warehouse_id',
			'label' => 'lang:warehouse_id',
			'rules' => 'trim|required'
		)
	),

	//validate from add GRN product
	'good_receive_note_fg_controller/saveGRNProductData' => array(
		array(
			'field' => 'product_id',
			'label' => 'lang:product',
			'rules' => 'trim|required'
		)
	),

	//---------GDN Screen
	//validate from add
	'good_dispatch_note_fg_controller/add' => array(
		array(
			'field' => 'reference_no',
			'label' => 'lang:reference_no',
			'rules' => 'trim|required|callback_check_existing'
		),
		array(
			'field' => 'gdn_date',
			'label' => 'lang:gdn_date',
			'rules' => 'trim|required'
		),
		array(
			'field' => 'warehouse_id',
			'label' => 'lang:warehouse_id',
			'rules' => 'trim|required'
		)
	),
	
	 //validate from edit
	'good_dispatch_note_fg_controller/editGDNData' => array(
		array(
			'field' => 'reference_no',
			'label' => 'lang:reference_no',
			'rules' => 'trim|required|callback_check_existing'
		),
		array(
			'field' => 'gdn_date',
			'label' => 'lang:gdn_date',
			'rules' => 'trim|required'
		),
		array(
			'field' => 'warehouse_id',
			'label' => 'lang:warehouse_id',
			'rules' => 'trim|required'
		)
	),

	//validate from edit
	'good_dispatch_note_fg_controller/editGDNProductData' => array(
		array(
			'field' => 'product_id',
			'label' => 'lang:product',
			'rules' => 'trim|required'
		),
		array(
			'field' => 'product_quantity',
			'label' => 'lang:quantity',
			'rules' => 'trim|required|numeric'
		),
		array(
			'field' => 'unit_id',
			'label' => 'lang:unit',
			'rules' => 'trim|required'
		)
	),

	//validate from add GDN product
	'good_dispatch_note_fg_controller/saveGDNProductData' => array(
		array(
			'field' => 'product_id',
			'label' => 'lang:product',
			'rules' => 'trim|required'
		),
		array(
			'field' => 'gdn_quantity',
			'label' => 'lang:quantity',
			'rules' => 'trim|required|numeric'
		),
		array(
			'field' => 'unit_id',
			'label' => 'lang:unit',
			'rules' => 'trim|required'
		)
	),

	//---------GIN Screen
	//validate from add
	'good_issue_note_fg_controller/add' => array(
		array(
			'field' => 'reference_no',
			'label' => 'lang:reference_no',
			'rules' => 'trim|required|callback_check_existing'
		),
		array(
			'field' => 'gin_date',
			'label' => 'lang:gin_date',
			'rules' => 'trim|required'
		),
		array(
			'field' => 'people_id',
			'label' => 'lang:people_id',
			'rules' => 'trim|required'
		),
		array(
			'field' => 'warehouse_id',
			'label' => 'lang:warehouse_id',
			'rules' => 'trim|required'
		)
	),

	//validate from edit
	'good_issue_note_fg_controller/editGINProductData' => array(
		array(
			'field' => 'product_id',
			'label' => 'lang:product',
			'rules' => 'trim|required'
		),
		array(
			'field' => 'product_quantity',
			'label' => 'lang:quantity',
			'rules' => 'trim|required|numeric'
		),
		array(
			'field' => 'unit_id',
			'label' => 'lang:unit',
			'rules' => 'trim|required'
		)
	),

	//validate from edit
	'good_issue_note_fg_controller/editGINData' => array(
		array(
			'field' => 'reference_no',
			'label' => 'lang:reference_no',
			'rules' => 'trim|required|callback_check_existing'
		),
		array(
			'field' => 'gin_date',
			'label' => 'lang:gin_date',
			'rules' => 'trim|required'
		),
		array(
			'field' => 'people_id',
			'label' => 'lang:people_id',
			'rules' => 'trim|required'
		),
		array(
			'field' => 'warehouse_id',
			'label' => 'lang:warehouse_id',
			'rules' => 'trim|required'
		)
	),

	//validate from add GIN product
	'good_issue_note_fg_controller/saveGINProductData' => array(
		array(
			'field' => 'product_id',
			'label' => 'lang:product',
			'rules' => 'trim|required'
		),
		array(
			'field' => 'gin_quantity',
			'label' => 'lang:quantity',
			'rules' => 'trim|required|numeric'
		),
		array(
			'field' => 'unit_id',
			'label' => 'lang:unit',
			'rules' => 'trim|required'
		)
	),

	//---------GRTN Screen
	//validate from add
	'good_return_note_fg_controller/add' => array(
		array(
			'field' => 'reference_no',
			'label' => 'lang:reference_no',
			'rules' => 'trim|required|callback_check_existing'
		),
		array(
			'field' => 'grtn_date',
			'label' => 'lang:grtn_date',
			'rules' => 'trim|required'
		),
		array(
			'field' => 'warehouse_id',
			'label' => 'lang:warehouse_id',
			'rules' => 'trim|required'
		)
	),

	//validate from edit
	'good_return_note_fg_controller/editGRTNData' => array(
		array(
			'field' => 'reference_no',
			'label' => 'lang:reference_no',
			'rules' => 'trim|required|callback_check_existing'
		),
		array(
			'field' => 'grtn_date',
			'label' => 'lang:grtn_date',
			'rules' => 'trim|required'
		),
		array(
			'field' => 'warehouse_id',
			'label' => 'lang:warehouse_id',
			'rules' => 'trim|required'
		)
	),

	'good_return_note_fg_controller/editGRTNProductData' => array(
		array(
			'field' => 'product_id',
			'label' => 'lang:product',
			'rules' => 'trim|required'
		),
		array(
			'field' => 'product_quantity',
			'label' => 'lang:quantity',
			'rules' => 'trim|required|numeric'
		),
		array(
			'field' => 'unit_id',
			'label' => 'lang:unit',
			'rules' => 'trim|required'
		)
	),

	//validate from add GRTN product
	'good_return_note_fg_controller/saveGRTNProductData' => array(
		array(
			'field' => 'product_id',
			'label' => 'lang:product',
			'rules' => 'trim|required'
		),
		array(
			'field' => 'grtn_quantity',
			'label' => 'lang:quantity',
			'rules' => 'trim|required|numeric'
		),
		array(
			'field' => 'unit_id',
			'label' => 'lang:unit',
			'rules' => 'trim|required'
		)
	),
	
	//---------Supplier Return Screen
	//Validate form add supplier return
	'supplier_return_fg_controller/add' => array(
		array(
			'field' => 'reference_no',
			'label' => 'lang:reference_no',
			'rules' => 'trim|required|callback_check_existing'
		),
		array(
			'field' => 'supplier_return_date',
			'label' => 'lang:supplier_return_date',
			'rules' => 'trim|required'
		),
		array(
			'field' => 'people_id',
			'label' => 'lang:people_id',
			'rules' => 'trim|required'
		),
		array(
			'field' => 'warehouse_id',
			'label' => 'lang:warehouse_id',
			'rules' => 'trim|required'
		)
	),

	//Validate form edit supplier return
	'supplier_return_fg_controller/editSupplierReturnData' => array(
		array(
			'field' => 'reference_no',
			'label' => 'lang:reference_no',
			'rules' => 'trim|required|callback_check_existing'
		),
		array(
			'field' => 'supplier_return_date',
			'label' => 'lang:supplier_return_date',
			'rules' => 'trim|required'
		),
		array(
			'field' => 'people_id',
			'label' => 'lang:people_id',
			'rules' => 'trim|required'
		),
		array(
			'field' => 'warehouse_id',
			'label' => 'lang:warehouse_id',
			'rules' => 'trim|required'
		)
	),

	//Validate form add supplier return product
	'supplier_return_fg_controller/saveSupplierReturnProductData' => array(
		array(
			'field' => 'product_id',
			'label' => 'lang:product',
			'rules' => 'trim|required'
		),
		array(
			'field' => 'supplier_return_quantity',
			'label' => 'lang:quantity',
			'rules' => 'trim|required|numeric'
		),
		array(
			'field' => 'unit_id',
			'label' => 'lang:unit',
			'rules' => 'trim|required'
		)
	),
	
	//Validate form edit supplier return product
	'supplier_return_fg_controller/editSupplierReturnProductData' => array(
		array(
			'field' => 'product_id',
			'label' => 'lang:product',
			'rules' => 'trim|required'
		),
		array(
			'field' => 'product_quantity',
			'label' => 'lang:quantity',
			'rules' => 'trim|required|numeric'
		),
		array(
			'field' => 'unit_id',
			'label' => 'lang:unit',
			'rules' => 'trim|required'
		)
	),
	
	//---------Product Disposal Screen
	//Validate form add product disposal
	'product_disposal_fg_controller/add' => array(
		array(
			'field' => 'reference_no',
			'label' => 'lang:reference_no',
			'rules' => 'trim|required|callback_check_existing'
		),
		array(
			'field' => 'product_disposal_date',
			'label' => 'lang:product_disposal_date',
			'rules' => 'trim|required'
		),
		array(
			'field' => 'warehouse_id',
			'label' => 'lang:warehouse_id',
			'rules' => 'trim|required'
		)
	),

	//Validate form edit product disposal
	'product_disposal_fg_controller/editProductDisposalData' => array(
		array(
			'field' => 'reference_no',
			'label' => 'lang:reference_no',
			'rules' => 'trim|required|callback_check_existing'
		),
		array(
			'field' => 'product_disposal_date',
			'label' => 'lang:product_disposal_date',
			'rules' => 'trim|required'
		),
		array(
			'field' => 'warehouse_id',
			'label' => 'lang:warehouse_id',
			'rules' => 'trim|required'
		)
	),

	//Validate form add product disposal product
	'product_disposal_fg_controller/saveProductDisposalProductData' => array(
		array(
			'field' => 'product_id',
			'label' => 'lang:product',
			'rules' => 'trim|required'
		),
		array(
			'field' => 'product_quantity',
			'label' => 'lang:quantity',
			'rules' => 'trim|required|numeric'
		),
		array(
			'field' => 'unit_id',
			'label' => 'lang:unit',
			'rules' => 'trim|required'
		)
	),
	
	//Validate form edit product disposal product
	'product_disposal_fg_controller/editProductDisposalProductData' => array(
		array(
			'field' => 'product_id',
			'label' => 'lang:product',
			'rules' => 'trim|required'
		),
		array(
			'field' => 'product_quantity',
			'label' => 'lang:quantity',
			'rules' => 'trim|required|numeric'
		),
		array(
			'field' => 'unit_id',
			'label' => 'lang:unit',
			'rules' => 'trim|required'
		)
	),

	//---------Stock Update Screen
	//validate from add
	'warehouse_stock_update_fg_controller/add' => array(
		array(
			'field' => 'stock_date',
			'label' => 'lang:stock_date',
			'rules' => 'trim|required'
		),
		array(
			'field' => 'warehouse_id',
			'label' => 'lang:Warehouse',
			'rules' => 'trim|required'
		),
		array(
			'field' => 'unit_id',
			'label' => 'lang:unit',
			'rules' => 'trim|required'
		),
		array(
			'field' => 'physical_quantity',
			'label' => 'lang:quantity',
			'rules' => 'trim|required|numeric'
		),
		array(
			'field' => 'product_id',
			'label' => 'lang:product',
			'rules' => 'trim|required'
		)
	),

	//validate from edit
	'warehouse_stock_update_fg_controller/edit' => array(
		array(
			'field' => 'stock_date',
			'label' => 'lang:stock_date',
			'rules' => 'trim|required'
		),
		array(
			'field' => 'warehouse_id',
			'label' => 'lang:Warehouse',
			'rules' => 'trim|required'
		),
		array(
			'field' => 'unit_id',
			'label' => 'lang:unit',
			'rules' => 'trim|required'
		),
		array(
			'field' => 'physical_quantity',
			'label' => 'lang:quantity',
			'rules' => 'trim|required|numeric'
		),
		array(
			'field' => 'product_id',
			'label' => 'lang:product',
			'rules' => 'trim|required'
		)
	),
	
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////---------Raw Material Inventory Section-----------/////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	//---------Category Screen
	//validate from add
	'categories_rm_controller/add' => array(
		array(
			'field' => 'category_name',
			'label' => 'lang:category_name',
			'rules' => 'trim|required|callback_check_existing'
		)
	),

	//validate from edit
	'categories_rm_controller/edit' => array(
		array(
			'field' => 'category_name',
			'label' => 'lang:category_name',
			'rules' => 'trim|required|callback_check_existing'
		)
	),

	//---------Sub Category Screen
	//validate from add
	'sub_categories_rm_controller/add' => array(
		array(
			'field' => 'category_id',
			'label' => 'lang:category_name',
			'rules' => 'trim|required'
		),
		array(
			'field' => 'sub_category_name',
			'label' => 'lang:sub_category_name',
			'rules' => 'trim|required|callback_check_existing'
		)
	),

	//validate from edit
	'sub_categories_rm_controller/edit' => array(
		array(
			'field' => 'category_id',
			'label' => 'lang:category_name',
			'rules' => 'trim|required'
		),
		array(
			'field' => 'sub_category_name',
			'label' => 'lang:sub_category_name',
			'rules' => 'trim|required|callback_check_existing'
		)
	),

	//---------Production Output Note Screen
	//Validate form add production output note
	'production_output_note_fg_controller/add' => array(
		array(
			'field' => 'reference_no',
			'label' => 'lang:reference_no',
			'rules' => 'trim|required|callback_check_existing'
		),
		array(
			'field' => 'pon_date',
			'label' => 'lang:pon_date',
			'rules' => 'trim|required'
		),
		array(
			'field' => 'warehouse_id',
			'label' => 'lang:warehouse_id',
			'rules' => 'trim|required'
		)
	),

	//Validate form edit production output note
	'production_output_note_fg_controller/editPONData' => array(
		array(
			'field' => 'reference_no',
			'label' => 'lang:reference_no',
			'rules' => 'trim|required|callback_check_existing'
		),
		array(
			'field' => 'pon_date',
			'label' => 'lang:pon_date',
			'rules' => 'trim|required'
		)
	),

	//Validate form add production output note product
	'production_output_note_fg_controller/savePONProductData' => array(
		array(
			'field' => 'product_id',
			'label' => 'lang:product',
			'rules' => 'trim|required'
		),
		array(
			'field' => 'product_quantity',
			'label' => 'lang:quantity',
			'rules' => 'trim|required|numeric'
		),
		array(
			'field' => 'unit_id',
			'label' => 'lang:unit',
			'rules' => 'trim|required'
		)
	),
	
	//Validate form edit production output note product
	'production_output_note_fg_controller/editPONProductData' => array(
		array(
			'field' => 'product_id',
			'label' => 'lang:product',
			'rules' => 'trim|required'
		),
		array(
			'field' => 'product_quantity',
			'label' => 'lang:quantity',
			'rules' => 'trim|required|numeric'
		),
		array(
			'field' => 'unit_id',
			'label' => 'lang:unit',
			'rules' => 'trim|required'
		)
	),

	//---------Raw Material Screen
	//validate from add
	'raw_materials_rm_controller/add' => array(
		array(
			'field' => 'category_id',
			'label' => 'lang:category_name',
			'rules' => 'trim|required'
		),
		array(
			'field' => 'unit_id',
			'label' => 'lang:unit_name',
			'rules' => 'trim|required'
		),
		array(
			'field' => 'raw_material_code',
			'label' => 'lang:raw_material_code',
			'rules' => 'trim|required|callback_check_existing'
		),
		array(
			'field' => 'raw_material_name',
			'label' => 'lang:raw_material_name',
			'rules' => 'trim|required'
		),
		array(
			'field' => 'display_unit_id',
			'label' => 'lang:display_unit',
			'rules' => 'trim|required'
		)
	),

	//validate from edit
	'raw_materials_rm_controller/edit' => array(
		array(
			'field' => 'category_id',
			'label' => 'lang:category_name',
			'rules' => 'trim|required'
		),
		array(
			'field' => 'unit_id',
			'label' => 'lang:unit_name',
			'rules' => 'trim|required'
		),
		array(
			'field' => 'raw_material_code',
			'label' => 'lang:raw_material_code',
			'rules' => 'trim|required|callback_check_existing'
		),
		array(
			'field' => 'raw_material_name',
			'label' => 'lang:raw_material_name',
			'rules' => 'trim|required'
		),
		array(
			'field' => 'display_unit_id',
			'label' => 'lang:display_unit',
			'rules' => 'trim|required'
		)
	),

	//---------Open Stock Screen
	//validate from add
	'warehouse_opening_stock_rm_controller/add' => array(
		array(
			'field' => 'stock_date',
			'label' => 'lang:stock_date',
			'rules' => 'trim|required'
		),
		array(
			'field' => 'warehouse_id',
			'label' => 'lang:Warehouse',
			'rules' => 'trim|required'
		),
		array(
			'field' => 'unit_id',
			'label' => 'lang:unit',
			'rules' => 'trim|required'
		),
		array(
			'field' => 'raw_material_quantity',
			'label' => 'lang:quantity',
			'rules' => 'trim|required|numeric'
		),
		array(
			'field' => 'raw_material_id',
			'label' => 'lang:raw_material',
			'rules' => 'trim|required'
		)
	),

	//validate from edit
	'warehouse_opening_stock_rm_controller/edit' => array(
		array(
			'field' => 'stock_date',
			'label' => 'lang:stock_date',
			'rules' => 'trim|required'
		),
		array(
			'field' => 'warehouse_id',
			'label' => 'lang:Warehouse',
			'rules' => 'trim|required'
		),
		array(
			'field' => 'unit_id',
			'label' => 'lang:unit',
			'rules' => 'trim|required'
		),
		array(
			'field' => 'raw_material_quantity',
			'label' => 'lang:quantity',
			'rules' => 'trim|required|numeric'
		),
		array(
			'field' => 'raw_material_id',
			'label' => 'lang:raw_material',
			'rules' => 'trim|required'
		)
	),

	//---------GRN Screen
	//validate from add
	'good_receive_note_rm_controller/add' => array(
		array(
			'field' => 'reference_no',
			'label' => 'lang:reference_no',
			'rules' => 'trim|required|callback_check_existing'
		),
		array(
			'field' => 'grn_date',
			'label' => 'lang:grn_date',
			'rules' => 'trim|required'
		),
		array(
			'field' => 'supplier_id',
			'label' => 'lang:supplier_id',
			'rules' => 'trim|required'
		),
		array(
			'field' => 'warehouse_id',
			'label' => 'lang:warehouse_id',
			'rules' => 'trim|required'
		)
	),

	//validate from edit
	'good_receive_note_rm_controller/editGRNRawMaterialData' => array(
		array(
			'field' => 'raw_material_id',
			'label' => 'lang:raw_material',
			'rules' => 'trim|required'
		),
		array(
			'field' => 'raw_material_quantity',
			'label' => 'lang:quantity',
			'rules' => 'trim|required|numeric'
		),
		array(
			'field' => 'unit_id',
			'label' => 'lang:unit',
			'rules' => 'trim|required'
		)
	),

	'good_receive_note_rm_controller/editGRNData' => array(
		array(
			'field' => 'reference_no',
			'label' => 'lang:reference_no',
			'rules' => 'trim|required|callback_check_existing'
		),
		array(
			'field' => 'grn_date',
			'label' => 'lang:grn_date',
			'rules' => 'trim|required'
		),
		array(
			'field' => 'supplier_id',
			'label' => 'lang:supplier_id',
			'rules' => 'trim|required'
		),
		array(
			'field' => 'warehouse_id',
			'label' => 'lang:warehouse_id',
			'rules' => 'trim|required'
		)
	),

	//validate from add GRN raw material
	'good_receive_note_rm_controller/saveGRNRawMaterialData' => array(
		array(
			'field' => 'raw_material_id',
			'label' => 'lang:product',
			'rules' => 'trim|required'
		),
		array(
			'field' => 'grn_quantity',
			'label' => 'lang:quantity',
			'rules' => 'trim|required|numeric'
		),
		array(
			'field' => 'unit_id',
			'label' => 'lang:unit',
			'rules' => 'trim|required'
		)
	),

	//---------GDN Screen
	//validate from add
	'good_dispatch_note_rm_controller/add' => array(
		array(
			'field' => 'reference_no',
			'label' => 'lang:reference_no',
			'rules' => 'trim|required|callback_check_existing'
		),
		array(
			'field' => 'gdn_date',
			'label' => 'lang:gdn_date',
			'rules' => 'trim|required'
		),
		array(
			'field' => 'warehouse_id',
			'label' => 'lang:warehouse_id',
			'rules' => 'trim|required'
		)
	),

	//validate from edit
	'good_dispatch_note_rm_controller/editGDNRawMaterialData' => array(
		array(
			'field' => 'raw_material_id',
			'label' => 'lang:raw_material',
			'rules' => 'trim|required'
		),
		array(
			'field' => 'raw_material_quantity',
			'label' => 'lang:quantity',
			'rules' => 'trim|required|numeric'
		),
		array(
			'field' => 'unit_id',
			'label' => 'lang:unit',
			'rules' => 'trim|required'
		)
	),

	 //validate from edit
	'good_dispatch_note_rm_controller/editGDNData' => array(
		array(
			'field' => 'reference_no',
			'label' => 'lang:reference_no',
			'rules' => 'trim|required|callback_check_existing'
		),
		array(
			'field' => 'gdn_date',
			'label' => 'lang:gdn_date',
			'rules' => 'trim|required'
		),
		array(
			'field' => 'warehouse_id',
			'label' => 'lang:warehouse_id',
			'rules' => 'trim|required'
		)
	),

	//validate from add GDN raw material
	'good_dispatch_note_rm_controller/saveGDNRawMaterialData' => array(
		array(
			'field' => 'raw_material_id',
			'label' => 'lang:raw_material',
			'rules' => 'trim|required'
		),
		array(
			'field' => 'gdn_quantity',
			'label' => 'lang:quantity',
			'rules' => 'trim|required|numeric'
		),
		array(
			'field' => 'unit_id',
			'label' => 'lang:unit',
			'rules' => 'trim|required'
		)
	),

	//---------GIN Screen
	//validate from add
	'good_issue_note_rm_controller/add' => array(
		array(
			'field' => 'reference_no',
			'label' => 'lang:reference_no',
			'rules' => 'trim|required|callback_check_existing'
		),
		array(
			'field' => 'gin_date',
			'label' => 'lang:gin_date',
			'rules' => 'trim|required'
		),
		array(
			'field' => 'issue_return_type_id',
			'label' => 'lang:issue_return_type_id',
			'rules' => 'trim|required'
		),
		array(
			'field' => 'people_id',
			'label' => 'lang:people_id',
			'rules' => 'trim|required'
		),
		array(
			'field' => 'warehouse_id',
			'label' => 'lang:warehouse_id',
			'rules' => 'trim|required'
		)
	),

	//validate from edit
	'good_issue_note_rm_controller/editGINRawMaterialData' => array(
		array(
			'field' => 'raw_material_id',
			'label' => 'lang:raw_material',
			'rules' => 'trim|required'
		),
		array(
			'field' => 'raw_material_quantity',
			'label' => 'lang:quantity',
			'rules' => 'trim|required|numeric'
		),
		array(
			'field' => 'unit_id',
			'label' => 'lang:unit',
			'rules' => 'trim|required'
		)
	),

	//validate from edit
	'good_issue_note_rm_controller/editGINData' => array(
		array(
			'field' => 'reference_no',
			'label' => 'lang:reference_no',
			'rules' => 'trim|required|callback_check_existing'
		),
		array(
			'field' => 'gin_date',
			'label' => 'lang:gin_date',
			'rules' => 'trim|required'
		),
		array(
			'field' => 'issue_return_type_id',
			'label' => 'lang:issue_return_type_id',
			'rules' => 'trim|required'
		),
		array(
			'field' => 'people_id',
			'label' => 'lang:people_id',
			'rules' => 'trim|required'
		),
		array(
			'field' => 'warehouse_id',
			'label' => 'lang:warehouse_id',
			'rules' => 'trim|required'
		)
	),

	//validate from add GIN raw material
	'good_issue_note_rm_controller/saveGINRawMaterialData' => array(
		array(
			'field' => 'raw_material_id',
			'label' => 'lang:raw_material',
			'rules' => 'trim|required'
		),
		array(
			'field' => 'gin_quantity',
			'label' => 'lang:quantity',
			'rules' => 'trim|required|numeric'
		),
		array(
			'field' => 'unit_id',
			'label' => 'lang:unit',
			'rules' => 'trim|required'
		)
	),

	//---------GRTN Screen
	//validate from add
	'good_return_note_rm_controller/add' => array(
		array(
			'field' => 'reference_no',
			'label' => 'lang:reference_no',
			'rules' => 'trim|required|callback_check_existing'
		),
		array(
			'field' => 'grtn_date',
			'label' => 'lang:grtn_date',
			'rules' => 'trim|required'
		),
		array(
			'field' => 'issue_return_type_id',
			'label' => 'lang:issue_return_type_id',
			'rules' => 'trim|required'
		),
		array(
			'field' => 'people_id',
			'label' => 'lang:people_id',
			'rules' => 'trim|required'
		),
		array(
			'field' => 'warehouse_id',
			'label' => 'lang:warehouse_id',
			'rules' => 'trim|required'
		)
	),

	//validate from edit
	'good_return_note_rm_controller/editGRTNData' => array(
		array(
			'field' => 'reference_no',
			'label' => 'lang:reference_no',
			'rules' => 'trim|required|callback_check_existing'
		),
		array(
			'field' => 'grtn_date',
			'label' => 'lang:grtn_date',
			'rules' => 'trim|required'
		),
		array(
			'field' => 'issue_return_type_id',
			'label' => 'lang:issue_return_type_id',
			'rules' => 'trim|required'
		),
		array(
			'field' => 'people_id',
			'label' => 'lang:people_id',
			'rules' => 'trim|required'
		),
		array(
			'field' => 'warehouse_id',
			'label' => 'lang:warehouse_id',
			'rules' => 'trim|required'
		)
	),

	'good_return_note_rm_controller/editGRTNRawMaterialData' => array(
		array(
			'field' => 'raw_material_id',
			'label' => 'lang:raw_material',
			'rules' => 'trim|required'
		),
		array(
			'field' => 'raw_material_quantity',
			'label' => 'lang:quantity',
			'rules' => 'trim|required|numeric'
		),
		array(
			'field' => 'unit_id',
			'label' => 'lang:unit',
			'rules' => 'trim|required'
		)
	),

	//validate from add GRTN raw material
	'good_return_note_rm_controller/saveGRTNRawMaterialData' => array(
		array(
			'field' => 'raw_material_id',
			'label' => 'lang:raw_material',
			'rules' => 'trim|required'
		),
		array(
			'field' => 'grtn_quantity',
			'label' => 'lang:quantity',
			'rules' => 'trim|required|numeric'
		),
		array(
			'field' => 'unit_id',
			'label' => 'lang:unit',
			'rules' => 'trim|required'
		)
	),

	//---------PO Screen
	//validate from add
	'purchase_order_rm_controller/add' => array(
		array(
			'field' => 'reference_no',
			'label' => 'lang:reference_no',
			'rules' => 'trim|required|callback_check_existing'
		),
		array(
			'field' => 'po_date',
			'label' => 'lang:po_date',
			'rules' => 'trim|required'
		),
		array(
			'field' => 'supplier_id',
			'label' => 'lang:supplier_id',
			'rules' => 'trim|required'
		),
		array(
			'field' => 'warehouse_id',
			'label' => 'lang:warehouse_id',
			'rules' => 'trim|required'
		)
	),

	//validate from edit
	'purchase_order_rm_controller/editPORawMaterialData' => array(
		array(
			'field' => 'raw_material_id',
			'label' => 'lang:raw_material',
			'rules' => 'trim|required'
		),
		array(
			'field' => 'raw_material_quantity',
			'label' => 'lang:quantity',
			'rules' => 'trim|required|numeric'
		),
		array(
			'field' => 'unit_id',
			'label' => 'lang:unit',
			'rules' => 'trim|required'
		)
	),

	//validate from edit
	'purchase_order_rm_controller/editPORawMaterialIssueData' => array(
		array(
			'field' => 'raw_material_id',
			'label' => 'lang:raw_material',
			'rules' => 'trim|required'
		),
		array(
			'field' => 'raw_material_quantity',
			'label' => 'lang:quantity',
			'rules' => 'trim|required|numeric'
		),
		array(
			'field' => 'unit_id',
			'label' => 'lang:unit',
			'rules' => 'trim|required'
		)
	),

	//validate from edit
	'purchase_order_rm_controller/editPOData' => array(
		array(
			'field' => 'reference_no',
			'label' => 'lang:reference_no',
			'rules' => 'trim|required|callback_check_existing'
		),
		array(
			'field' => 'po_date',
			'label' => 'lang:po_date',
			'rules' => 'trim|required'
		),
		array(
			'field' => 'supplier_id',
			'label' => 'lang:supplier_id',
			'rules' => 'trim|required'
		),
		array(
			'field' => 'warehouse_id',
			'label' => 'lang:warehouse_id',
			'rules' => 'trim|required'
		)
	),

	//validate from add PO raw material
	'purchase_order_rm_controller/savePORawMaterialData' => array(
		array(
			'field' => 'raw_material_id',
			'label' => 'lang:raw_material',
			'rules' => 'trim|required'
		),
		array(
			'field' => 'po_quantity',
			'label' => 'lang:quantity',
			'rules' => 'trim|required|numeric'
		),
		array(
			'field' => 'unit_id',
			'label' => 'lang:unit',
			'rules' => 'trim|required'
		)
	),

	//---------Stock Update Screen
	//validate from add
	'warehouse_stock_update_rm_controller/add' => array(
		array(
			'field' => 'stock_date',
			'label' => 'lang:stock_date',
			'rules' => 'trim|required'
		),
		array(
			'field' => 'warehouse_id',
			'label' => 'lang:Warehouse',
			'rules' => 'trim|required'
		),
		array(
			'field' => 'unit_id',
			'label' => 'lang:unit',
			'rules' => 'trim|required'
		),
		array(
			'field' => 'physical_quantity',
			'label' => 'lang:quantity',
			'rules' => 'trim|required|numeric'
		),
		array(
			'field' => 'raw_material_id',
			'label' => 'lang:raw_material',
			'rules' => 'trim|required'
		)
	),

	//validate from edit
	'warehouse_stock_update_rm_controller/edit' => array(
		array(
			'field' => 'stock_date',
			'label' => 'lang:stock_date',
			'rules' => 'trim|required'
		),
		array(
			'field' => 'warehouse_id',
			'label' => 'lang:Warehouse',
			'rules' => 'trim|required'
		),
		array(
			'field' => 'unit_id',
			'label' => 'lang:unit',
			'rules' => 'trim|required'
		),
		array(
			'field' => 'physical_quantity',
			'label' => 'lang:quantity',
			'rules' => 'trim|required|numeric'
		),
		array(
			'field' => 'raw_material_id',
			'label' => 'lang:raw_material',
			'rules' => 'trim|required'
		)
	),
	
	//---------Supplier Return Screen
	//Validate form add supplier return
	'supplier_return_rm_controller/add' => array(
		array(
			'field' => 'reference_no',
			'label' => 'lang:reference_no',
			'rules' => 'trim|required|callback_check_existing'
		),
		array(
			'field' => 'supplier_return_date',
			'label' => 'lang:supplier_return_date',
			'rules' => 'trim|required'
		),
		array(
			'field' => 'people_id',
			'label' => 'lang:people_id',
			'rules' => 'trim|required'
		),
		array(
			'field' => 'warehouse_id',
			'label' => 'lang:warehouse_id',
			'rules' => 'trim|required'
		)
	),

	//Validate form edit supplier return
	'supplier_return_rm_controller/editSupplierReturnData' => array(
		array(
			'field' => 'reference_no',
			'label' => 'lang:reference_no',
			'rules' => 'trim|required|callback_check_existing'
		),
		array(
			'field' => 'supplier_return_date',
			'label' => 'lang:supplier_return_date',
			'rules' => 'trim|required'
		),
		array(
			'field' => 'people_id',
			'label' => 'lang:people_id',
			'rules' => 'trim|required'
		),
		array(
			'field' => 'warehouse_id',
			'label' => 'lang:warehouse_id',
			'rules' => 'trim|required'
		)
	),

	//Validate form add supplier return raw material
	'supplier_return_rm_controller/saveSupplierReturnRawMaterialData' => array(
		array(
			'field' => 'raw_material_id',
			'label' => 'lang:raw_material',
			'rules' => 'trim|required'
		),
		array(
			'field' => 'supplier_return_quantity',
			'label' => 'lang:quantity',
			'rules' => 'trim|required|numeric'
		),
		array(
			'field' => 'unit_id',
			'label' => 'lang:unit',
			'rules' => 'trim|required'
		)
	),
	
	//Validate form edit supplier return raw material
	'supplier_return_rm_controller/editSupplierReturnRawMaterialData' => array(
		array(
			'field' => 'raw_material_id',
			'label' => 'lang:product',
			'rules' => 'trim|required'
		),
		array(
			'field' => 'raw_material_quantity',
			'label' => 'lang:quantity',
			'rules' => 'trim|required|numeric'
		),
		array(
			'field' => 'unit_id',
			'label' => 'lang:unit',
			'rules' => 'trim|required'
		)
	),
	
	//---------Raw Material Disposal Screen
	//Validate form add raw material disposal
	'raw_material_disposal_rm_controller/add' => array(
		array(
			'field' => 'reference_no',
			'label' => 'lang:reference_no',
			'rules' => 'trim|required|callback_check_existing'
		),
		array(
			'field' => 'raw_material_disposal_date',
			'label' => 'lang:raw_material_disposal_date',
			'rules' => 'trim|required'
		),
		array(
			'field' => 'warehouse_id',
			'label' => 'lang:warehouse_id',
			'rules' => 'trim|required'
		)
	),

	//Validate form edit raw material disposal
	'raw_material_disposal_rm_controller/editRawMaterialDisposalData' => array(
		array(
			'field' => 'reference_no',
			'label' => 'lang:reference_no',
			'rules' => 'trim|required|callback_check_existing'
		),
		array(
			'field' => 'raw_material_disposal_date',
			'label' => 'lang:raw_material_disposal_date',
			'rules' => 'trim|required'
		),
		array(
			'field' => 'warehouse_id',
			'label' => 'lang:warehouse_id',
			'rules' => 'trim|required'
		)
	),

	//Validate form add raw material disposal raw material
	'raw_material_disposal_rm_controller/saveRawMaterialDisposalRawMaterialData' => array(
		array(
			'field' => 'raw_material_id',
			'label' => 'lang:raw_material',
			'rules' => 'trim|required'
		),
		array(
			'field' => 'raw_material_quantity',
			'label' => 'lang:quantity',
			'rules' => 'trim|required|numeric'
		),
		array(
			'field' => 'unit_id',
			'label' => 'lang:unit',
			'rules' => 'trim|required'
		)
	),
	
	//Validate form edit raw material disposal raw material
	'raw_material_disposal_rm_controller/editRawMaterialDisposalRawMaterialData' => array(
		array(
			'field' => 'raw_material_id',
			'label' => 'lang:raw_material',
			'rules' => 'trim|required'
		),
		array(
			'field' => 'raw_material_quantity',
			'label' => 'lang:quantity',
			'rules' => 'trim|required|numeric'
		),
		array(
			'field' => 'unit_id',
			'label' => 'lang:unit',
			'rules' => 'trim|required'
		)
	),

	//---------Production Output Note Screen
	//Validate form add production output note
	'production_output_note_rm_controller/add' => array(
		array(
			'field' => 'reference_no',
			'label' => 'lang:reference_no',
			'rules' => 'trim|required|callback_check_existing'
		),
		array(
			'field' => 'pon_date',
			'label' => 'lang:pon_date',
			'rules' => 'trim|required'
		),
		array(
			'field' => 'warehouse_id',
			'label' => 'lang:warehouse_id',
			'rules' => 'trim|required'
		)
	),

	//Validate form edit raw material disposal
	'production_output_note_rm_controller/editPONData' => array(
		array(
			'field' => 'reference_no',
			'label' => 'lang:reference_no',
			'rules' => 'trim|required|callback_check_existing'
		),
		array(
			'field' => 'pon_date',
			'label' => 'lang:pon_date',
			'rules' => 'trim|required'
		)
	),

	//Validate form add raw material disposal raw material
	'production_output_note_rm_controller/savePONRawMaterialData' => array(
		array(
			'field' => 'raw_material_id',
			'label' => 'lang:raw_material',
			'rules' => 'trim|required'
		),
		array(
			'field' => 'raw_material_quantity',
			'label' => 'lang:quantity',
			'rules' => 'trim|required|numeric'
		),
		array(
			'field' => 'unit_id',
			'label' => 'lang:unit',
			'rules' => 'trim|required'
		)
	),
	
	//Validate form edit raw material disposal raw material
	'production_output_note_rm_controller/editPONRawMaterialData' => array(
		array(
			'field' => 'raw_material_id',
			'label' => 'lang:raw_material',
			'rules' => 'trim|required'
		),
		array(
			'field' => 'raw_material_quantity',
			'label' => 'lang:quantity',
			'rules' => 'trim|required|numeric'
		),
		array(
			'field' => 'unit_id',
			'label' => 'lang:unit',
			'rules' => 'trim|required'
		)
	),
	
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////---------Sales Section-----------////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	
	//---------Sales Invoice Screen
	//validate from add
	'sales_invoice_controller/add' => array(
		array(
			'field' => 'reference_no',
			'label' => 'lang:reference_no',
			'rules' => 'trim|required|callback_check_existing'
		),
		array(
			'field' => 'sales_invoice_date',
			'label' => 'lang:sales_invoice_date',
			'rules' => 'trim|required'
		),
		array(
			'field' => 'issue_type',
			'label' => 'lang:issue_type',
			'rules' => 'trim|required'
		)
	),

	//validate from edit
	'sales_invoice_controller/editSalesInvoiceData' => array(
		array(
			'field' => 'reference_no',
			'label' => 'lang:reference_no',
			'rules' => 'trim|required|callback_check_existing'
		),
		array(
			'field' => 'sales_invoice_date',
			'label' => 'lang:sales_invoice_date',
			'rules' => 'trim|required'
		),
		array(
			'field' => 'issue_type',
			'label' => 'lang:issue_type',
			'rules' => 'trim|required'
		)
	),

	//validate from add sales invoice item
	'sales_invoice_controller/saveSalesInvoiceItemData' => array(
		array(
			'field' => 'item_id',
			'label' => 'lang:item_id',
			'rules' => 'trim|required'
		),
		array(
			'field' => 'sales_unit_id',
			'label' => 'lang:sales_unit_id',
			'rules' => 'trim|required'
		)
	),

	'sales_invoice_controller/saveCashierCashAndChequeHandoverData' => array(
		array(
			'field' => 'receiver_id',
			'label' => 'lang:receiver_id',
			'rules' => 'trim|required'
		),
		array(
			'field' => 'cash_amount',
			'label' => 'lang:cash_amount',
			'rules' => 'trim|required'
		),
		array(
			'field' => 'note',
			'label' => 'lang:note',
			'rules' => 'trim|required'
		)
	),

	'sales_invoice_controller/editCashierCashAndChequeHandoverData' => array(
		array(
			'field' => 'receiver_id',
			'label' => 'lang:receiver_id',
			'rules' => 'trim|required'
		),
		array(
			'field' => 'cash_amount',
			'label' => 'lang:cash_amount',
			'rules' => 'trim|required'
		),
		array(
			'field' => 'note',
			'label' => 'lang:note',
			'rules' => 'trim|required'
		)
	),

	//---------Sales Return Screen
	//validate from add
	'sales_return_controller/add' => array(
		array(
			'field' => 'reference_no',
			'label' => 'lang:reference_no',
			'rules' => 'trim|required|callback_check_existing'
		),
		array(
			'field' => 'sales_return_type',
			'label' => 'lang:sales_return_type',
			'rules' => 'trim|required'
		),
		array(
			'field' => 'sales_return_date',
			'label' => 'lang:sales_invoice_date',
			'rules' => 'trim|required'
		),
		array(
			'field' => 'issue_return_type',
			'label' => 'lang:issue_return_type',
			'rules' => 'trim|required'
		),array(
			'field' => 'people_id',
			'label' => 'lang:people_id',
			'rules' => 'trim|required'
		)
	),

	'sales_return_controller/saveSalesReturnItemData' => array(
		array(
			'field' => 'item_quantity',
			'label' => 'lang:item_quantity',
			'rules' => 'trim|required|numeric'
		),
		array(
			'field' => 'return_unit_id',
			'label' => 'lang:return_unit_id',
			'rules' => 'trim|required'
		)
	),

	//validate from edit
	'sales_return_controller/editSalesReturnData' => array(
		array(
			'field' => 'reference_no',
			'label' => 'lang:reference_no',
			'rules' => 'trim|required'
		),
		array(
			'field' => 'sales_return_date',
			'label' => 'lang:sales_return_date',
			'rules' => 'trim|required'
		),
		array(
			'field' => 'people_id',
			'label' => 'lang:people_id',
			'rules' => 'trim|required'
		)
	),

	'sales_return_controller/editSalesReturnItemData' => array(
		array(
			'field' => 'item_id',
			'label' => 'lang:item_id',
			'rules' => 'trim|required'
		),
		array(
			'field' => 'item_quantity',
			'label' => 'lang:item_quantity',
			'rules' => 'trim|required|numeric'
		),
		array(
			'field' => 'unit_id',
			'label' => 'lang:unit_id',
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

	//---------Sign Up Screen
	'login/signUp' => array(
		array(
			'field' => 'first_name',
			'label' => 'lang:first_name',
			'rules' => 'trim|required'
		),
		array(
			'field' => 'last_name',
			'label' => 'lang:last_name',
			'rules' => 'trim|required'
		),
		array(
			'field' => 'comapany_name',
			'label' => 'lang:comapany_name',
			'rules' => 'trim|required'
		),
		array(
			'field' => 'job_title',
			'label' => 'lang:job_title',
			'rules' => 'trim|required'
		),
		array(
			'field' => 'contact_email',
			'label' => 'lang:contact_email',
			'rules' => 'trim|required|valid_email'
		),
		array(
			'field' => 'contact_phone',
			'label' => 'lang:contact_phone',
			'rules' => 'trim|required|numeric'
		),
		array(
			'field' => 'country',
			'label' => 'lang:country',
			'rules' => 'trim|required'
		),
		array(
			'field' => 'no_of_employees',
			'label' => 'lang:no_of_employees',
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
///////////////////////////////////////////////////////////////////////////////////---------HR Manager Module-----------//////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////---------Administration Section-----------/////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	//---------Departments Screen
	'departments_controller/add' => array(
		array(
			'field' => 'department_code',
			'label' => 'lang:department_code',
			'rules' => 'trim|required|callback_check_existing'
		),
		array(
			'field' => 'department',
			'label' => 'Department',
			'rules' => 'trim|required'
		)
	),
	
	'departments_controller/edit' => array(
		array(
			'field' => 'department_code',
			'label' => 'lang:department_code',
			'rules' => 'trim|required|callback_check_existing'
		),
		array(
			'field' => 'department',
			'label' => 'Department',
			'rules' => 'trim|required'
		)
	),

	//---------Job Title Screen
	//add
	'job_titles_controller/add' => array(
		array(
			'field' => 'job_title',
			'label' => 'lang:job_title',
			'rules' => 'trim|required|callback_check_existing'
		)
	),
	
	//edit
	'job_titles_controller/edit' => array(
		array(
			'field' => 'job_title',
			'label' => 'lang:job_title',
			'rules' => 'trim|required'
		)
	),

	//---------Employement Status Screen
	//validate from add
	'employment_status_controller/add' => array(
		array(
			'field' => 'employment_status',//field name text box name
			'label' => 'lang:employment_status',//set in language/english/message_lang.php also set french
			'rules' => 'trim|required|callback_check_existing'
		)
	),

	//validate from edit
	'employment_status_controller/edit' => array(
		array(
			'field' => 'employment_status',//field name text box name
			'label' => 'lang:employment_status',//set in language/english/message_lang.php also set french
			'rules' => 'trim|required'
		)
	),

	//---------Job Category Screen
	'job_categories_controller/add' => array(
		array(
			'field' => 'job_category',
			'label' => 'lang:job_category',
			'rules' => 'trim|required|callback_check_existing'
		)
	),
	
	'job_categories_controller/edit' => array(
		array(
			'field' => 'job_category',
			'label' => 'lang:job_category',
			'rules' => 'trim|required'
		)
	),
	

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////---------Personal Details Section-----------/////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	//---------Personal Details Screen
	//validate from add
	'personal_details_controller/add' => array(
		array(
			'field' => 'first_name',//field name text box name
			'label' => 'lang:first_name',//set in language/english/message_lang.php also set french
			'rules' => 'trim|required'
		)
	),
	'personal_details_controller/edit' => array(
		array(
			'field' => 'first_name',//field name text box name
			'label' => 'lang:first_name',//set in language/english/message_lang.php also set french
			'rules' => 'trim|required'
		)
	),

	//validate from uploadEmployeePhoto
	'personal_details_controller/uploadEmployeePhoto' => array(
		array(
			'field' => 'file_to_upload',//field name text box name
			'label' => 'lang:file_to_upload',//set in language/english/message_lang.php also set french
			'rules' => 'required'
		)
	),

	//---------Job Details Screen
	//validate from edit
	'job_details_controller/edit' => array(
		array(
			'field' => 'employee_code',//field name text box name
			'label' => 'lang:employee_code',//set in language/english/message_lang.php also set french
			'rules' => 'trim|required|callback_check_existing'
		)
	),

	//---------Performance Details Screen
	//validate from add
	'performance_details_controller/savePerformanceTrackingData' => array(
		array(
			'field' => 'performance_tracking_date',
			'label' => 'lang:performance_tracking_date',
			'rules' => 'trim|required'
		),
		array(
			'field' => 'performance_type',
			'label' => 'lang:performance_type',
			'rules' => 'trim|required'
		),
		array(
			'field' => 'description',
			'label' => 'lang:description',
			'rules' => 'trim|required'
		)
	),

	'performance_details_controller/editPerformanceTrackingData' => array(
		array(
			'field' => 'performance_tracking_date_edit',
			'label' => 'lang:performance_tracking_date',
			'rules' => 'trim|required'
		),
		array(
			'field' => 'performance_type_edit',
			'label' => 'lang:performance_type',
			'rules' => 'trim|required'
		),
		array(
			'field' => 'description_edit',
			'label' => 'lang:description',
			'rules' => 'trim|required'
		)
	),

	
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////---------Time & Attendance Section-----------///////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	//---------Working Shift Screen
	'working_shift_controller/addShiftDetails' => array(
		array(
			'field' => 'shift_code',
			'label' => 'lang:shift_code',
			'rules' => 'trim|required|callback_check_existing'
		),
		array(
			'field' => 'shift_name',
			'label' => 'Shift Name',
			'rules' => 'trim|required'
		)
	),
	'working_shift_controller/editShiftDetails' => array(
		array(
			'field' => 'shift_code',
			'label' => 'lang:shift_code',
			'rules' => 'trim|required|callback_check_existing'
		),
		array(
			'field' => 'shift_name',
			'label' => 'Shift Name',
			'rules' => 'trim|required'
		)
	),
    
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////---------Employee Leave Section-----------///////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    //validate from add
	'leave_types_controller/add' => array(
		array(
			'field' => 'leave_type_code',
			'label' => 'lang:leave_type_code',
			'rules' => 'trim|required'
		),
		array(
			'field' => 'leave_type_name',
			'label' => 'lang:leave_type_name',
			'rules' => 'trim|required'
		)
	),
	
	//validate from edit
	'leave_types_controller/edit' => array(
		array(
			'field' => 'leave_type_code',
			'label' => 'lang:leave_type_code',
			'rules' => 'trim|required'
		),
		array(
			'field' => 'leave_type_name',
			'label' => 'lang:leave_type_name',
			'rules' => 'trim|required'
		)
	),

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////---------Analytics Section-----------///////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	//---------Reports Screen
	//validate from addReportFolder
	'reports_controller/addReportFolder' => array(
		array(
			'field' => 'folder_name',//field name text box name
			'label' => 'lang:folder_name',//set in language/english/message_lang.php also set french
			'rules' => 'required|callback_check_existing'
		)
	),

	//validate from addReportDetails
	'reports_controller/addReportDetails' => array(
		array(
			'field' => 'report_name',//field name text box name
			'label' => 'lang:report_name',//set in language/english/message_lang.php also set french
			'rules' => 'required'
		)
	),

	//validate from addReportFields
	'reports_controller/addReportFields' => array(
		array(
			'field' => 'report_fields_list',//field name text box name
			'label' => 'lang:report_fields_list',//set in language/english/message_lang.php also set french
			'rules' => 'required'
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
	),

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////---------Production Manager Module-----------/////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////---------Administration Section-----------/////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	//---------Machines Screen
	//validate from add
	'machines_controller/add' => array(
		array(
			'field' => 'machine_code',
			'label' => 'lang:machine_code',
			'rules' => 'trim|required|callback_check_existing'
		),
		array(
			'field' => 'machine_name',
			'label' => 'lang:machine_name',
			'rules' => 'trim|required'
		)
	),
	
	//validate from edit
	'machines_controller/edit' => array(
		array(
			'field' => 'machine_code',
			'label' => 'lang:machine_code',
			'rules' => 'trim|required|callback_check_existing'
		),
		array(
			'field' => 'machine_name',
			'label' => 'lang:machine_name',
			'rules' => 'trim|required'
		)
	),

	//---------Production Cost Components Screen
	//validate from add
	'production_cost_components_controller/add' => array(
		array(
			'field' => 'cost_component_code',
			'label' => 'lang:cost_component_code',
			'rules' => 'trim|required|callback_check_existing'
		),
		array(
			'field' => 'cost_component_name',
			'label' => 'lang:cost_component_name',
			'rules' => 'trim|required'
		)
	),
	
	//validate from edit
	'production_cost_components_controller/edit' => array(
		array(
			'field' => 'cost_component_code',
			'label' => 'lang:cost_component_code',
			'rules' => 'trim|required|callback_check_existing'
		),
		array(
			'field' => 'cost_component_name',
			'label' => 'lang:cost_component_name',
			'rules' => 'trim|required'
		)
	),

	//---------Production Process Components Screen
	//validate from add
	'production_process_components_controller/add' => array(
		array(
			'field' => 'process_component_code',
			'label' => 'lang:process_component_code',
			'rules' => 'trim|required|callback_check_existing'
		),
		array(
			'field' => 'process_component_name',
			'label' => 'lang:process_component_name',
			'rules' => 'trim|required'
		)
	),
	
	//validate from edit
	'production_process_components_controller/edit' => array(
		array(
			'field' => 'process_component_code',
			'label' => 'lang:process_component_code',
			'rules' => 'trim|required|callback_check_existing'
		),
		array(
			'field' => 'process_component_name',
			'label' => 'lang:process_component_name',
			'rules' => 'trim|required'
		)
	),

//---------Production Process Screen
	//validate from add
	'production_processes_controller/add' => array(
		array(
			'field' => 'production_process_code',
			'label' => 'lang:production_process_code',
			'rules' => 'trim|required|callback_check_existing'
		),
		array(
			'field' => 'production_process_name',
			'label' => 'lang:production_process_name',
			'rules' => 'trim|required'
		),
		array(
			'field' => 'production_category',
			'label' => 'lang:production_category',
			'rules' => 'trim|required'
		)
	),
	
	//validate from edit
	'production_processes_controller/edit' => array(
		array(
			'field' => 'production_process_code',
			'label' => 'lang:production_process_code',
			'rules' => 'trim|required|callback_check_existing'
		),
		array(
			'field' => 'production_process_name',
			'label' => 'lang:production_process_name',
			'rules' => 'trim|required'
		),
		array(
			'field' => 'production_category',
			'label' => 'lang:production_category',
			'rules' => 'trim|required'
		)
	),

//---------Raw Material Preparation Screen
	//validate from add
	'raw_material_preparation_controller/add' => array(
		array(
			'field' => 'date',
			'label' => 'lang:date',
			'rules' => 'trim|required'
		),
		array(
			'field' => 'location_id',
			'label' => 'lang:location_id',
			'rules' => 'trim|required'
		),
		array(
			'field' => 'warehouse_id',
			'label' => 'lang:warehouse_id',
			'rules' => 'trim|required'
		),
		array(
			'field' => 'production_process',
			'label' => 'lang:production_process',
			'rules' => 'trim|required'
		)
	),
	
	//validate from edit
	'raw_material_preparation_controller/edit' => array(
		array(
			'field' => 'date',
			'label' => 'lang:date',
			'rules' => 'trim|required'
		),
		array(
			'field' => 'location_id',
			'label' => 'lang:location_id',
			'rules' => 'trim|required'
		),
		array(
			'field' => 'warehouse_id',
			'label' => 'lang:warehouse_id',
			'rules' => 'trim|required'
		),
		array(
			'field' => 'production_process',
			'label' => 'lang:production_process',
			'rules' => 'trim|required'
		)
	),

	//validate from add
	'raw_material_preparation_controller/saveWorkHoursData' => array(
		array(
			'field' => 'work_start_time',
			'label' => 'lang:work_start_time',
			'rules' => 'trim|required'
		),
		array(
			'field' => 'work_end_time',
			'label' => 'lang:work_end_time',
			'rules' => 'trim|required'
		)
	),
	
	//validate from edit
	'raw_material_preparation_controller/editWorkHoursData' => array(
		array(
			'field' => 'work_start_time',
			'label' => 'lang:work_start_time',
			'rules' => 'trim|required'
		),
		array(
			'field' => 'work_end_time',
			'label' => 'lang:work_end_time',
			'rules' => 'trim|required'
		)
	),

	//validate from add
	'raw_material_preparation_controller/saveMachineWorkHoursData' => array(
		array(
			'field' => 'machine_start_at',
			'label' => 'lang:machine_start_at',
			'rules' => 'trim|required'
		),
		array(
			'field' => 'machine_stopped_at',
			'label' => 'lang:machine_stopped_at',
			'rules' => 'trim|required'
		)
	),
	
	//validate from edit
	'raw_material_preparation_controller/editMachineWorkHoursData' => array(
		array(
			'field' => 'machine_start_at',
			'label' => 'lang:machine_start_at',
			'rules' => 'trim|required'
		),
		array(
			'field' => 'machine_stopped_at',
			'label' => 'lang:machine_stopped_at',
			'rules' => 'trim|required'
		)
	),

//---------Finish Good Production Screen
	//validate from add
	'finish_good_production_controller/add' => array(
		array(
			'field' => 'date',
			'label' => 'lang:date',
			'rules' => 'trim|required'
		),
		array(
			'field' => 'location_id',
			'label' => 'lang:location_id',
			'rules' => 'trim|required'
		),
		array(
			'field' => 'warehouse_id',
			'label' => 'lang:warehouse_id',
			'rules' => 'trim|required'
		),
		array(
			'field' => 'production_process',
			'label' => 'lang:production_process',
			'rules' => 'trim|required'
		)
	),
	
	//validate from edit
	'finish_good_production_controller/edit' => array(
		array(
			'field' => 'date',
			'label' => 'lang:date',
			'rules' => 'trim|required'
		),
		array(
			'field' => 'location_id',
			'label' => 'lang:location_id',
			'rules' => 'trim|required'
		),
		array(
			'field' => 'warehouse_id',
			'label' => 'lang:warehouse_id',
			'rules' => 'trim|required'
		),
		array(
			'field' => 'production_process',
			'label' => 'lang:production_process',
			'rules' => 'trim|required'
		)
	),

	//validate from add
	'finish_good_production_controller/saveWorkHoursData' => array(
		array(
			'field' => 'work_start_time',
			'label' => 'lang:work_start_time',
			'rules' => 'trim|required'
		),
		array(
			'field' => 'work_end_time',
			'label' => 'lang:work_end_time',
			'rules' => 'trim|required'
		)
	),
	
	//validate from edit
	'finish_good_production_controller/editWorkHoursData' => array(
		array(
			'field' => 'work_start_time',
			'label' => 'lang:work_start_time',
			'rules' => 'trim|required'
		),
		array(
			'field' => 'work_end_time',
			'label' => 'lang:work_end_time',
			'rules' => 'trim|required'
		)
	),

	//validate from add
	'finish_good_production_controller/saveMachineWorkHoursData' => array(
		array(
			'field' => 'machine_start_at',
			'label' => 'lang:machine_start_at',
			'rules' => 'trim|required'
		),
		array(
			'field' => 'machine_stopped_at',
			'label' => 'lang:machine_stopped_at',
			'rules' => 'trim|required'
		)
	),
	
	//validate from edit
	'finish_good_production_controller/editMachineWorkHoursData' => array(
		array(
			'field' => 'machine_start_at',
			'label' => 'lang:machine_start_at',
			'rules' => 'trim|required'
		),
		array(
			'field' => 'machine_stopped_at',
			'label' => 'lang:machine_stopped_at',
			'rules' => 'trim|required'
		)
	)
);
