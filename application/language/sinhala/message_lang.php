<?php

////////////  Guidelines for Developers //////////////////////////////////////////////////////////////////////////////////////

// 1. Developer MUST add new language strings only to English language file.
// 2. Any new language string additions MUST be added to the appropriate module and the screen.
// 3. Such new language strings MUST be added after the "New Additions" tag.
// 4. When such new additions are available, code maintenance engineer MUST add all new strings to
//    other all language files and those words should move just above the "New Additions" tag in this file.
// 5. Code maintenance engineer MUST add proper language translations for new language strings. Code maintenance 
//    engineer MUST refer Google Translate to find translations for new strings.
// 6. When adding language strings for new modules, developer should add those by adding a section for the new module.
//    New module should be placed in the order it displayes in front end. New modules should be indicated with "(New)" tag
//    after the module name.

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

defined('BASEPATH') OR exit('No direct script access allowed');

//Validation Messages

////////////////////////////////////////  Common Messages ////////////////////////////////////////////////////////////////////
/* New Additions */
$lang['success'] = 'සාර්ථකයි';
$lang['error'] = 'Error';
$lang['warning'] = 'Warning';
$lang['success_saved'] = 'දත්ත සාර්ථකව සුරකින ලදි';
$lang['success_populated'] = 'Master data successfully populated';
$lang['success_updated'] = 'Data sucessfully updated';
$lang['success_deleted'] = 'Data sucessfully deleted';
$lang['delete_failed'] = 'Data not deleted successfully';
$lang['Are you sure you want to delete'] = 'Are you sure you want to delete ';
$lang['Are you sure you want to delete this'] = 'Are you sure you want to delete this ';
$lang['already added'] = ' already added';
$lang['field is required'] ='ඇතුලත් කිරීම අත්‍යවශයි';
$lang['Are you sure you want to change this'] = 'Are you sure you want to change this';
$lang['success_submit'] = 'Data sucessfully submited';
$lang['is not valid'] = 'is not valid';
$lang['success_sent'] = 'Email sucessfully sent';
$lang['Not a valid percentage'] = 'Not a valid percentage';
$lang['Not a valid price'] = 'Not a valid price';
$lang['master_data_already_populated'] = 'Master data already populated';

////////////////////////////////////////  Administration Module Messages ////////////////////////////////////////////////////
//Company Information Screen
/* New Additions */
$lang['company_name'] = 'The Company Name field is required';
$lang['email'] = 'E-mail field is required';
$lang['primary_telephone_number'] = 'Primary Phone Number field is required';
$lang['company_address'] = 'Address field is required';


//Company Structure Screen
/* New Additions */
$lang['Mother Company Cannot Be Deleted!'] = 'Mother Company Cannot Be Deleted!';


//Location Screen
/* New Additions */
$lang['location_name'] = 'Location Name';
$lang['company'] = 'Company';
$lang['country'] = 'Country';
$lang['city'] = 'City';
$lang['state'] = 'State';
$lang['primary_phone_no'] = 'Primary Phone No';
$lang['address'] = 'Address';
$lang['Location code is already in use'] = 'Location code is already in use';


//People Screen
/* New Additions */
$lang['people details'] = 'people details';
$lang['People Code is already in use'] = 'People Code is already in use';
$lang['people_type'] = 'people type';
$lang['people_code'] = 'people code';
$lang['people_name'] = 'people name';
$lang['email'] ='email';
$lang['vehicle_already_assigned_to_a_sales_rep'] = 'Selected vehicle is already assigned to another sales rep.';
$lang['stock_is_not_monitoring_for_new_vehicle'] = 'Vehicle stock is not monitoring for the selected vehicle.';
$lang['stock_is_not_monitoring_for_new_vehicle_sure_to_update'] = 'Vehicle stock is not monitoring for the selected vehicle. Are you sure to change the vehicle?';
$lang['stock_can_be_moved_to_new_vehicle'] = 'Vehicle stock of current vehicle can be moved to new vehicle selected. Are you sure to move stock of old vehicle to the new vehicle?';
$lang['do_you_want_change_vehicle'] = 'Do you want to change the vehicle without moving stock from old vehicle to the new vehicle?';
$lang['Document Successfuly Uploaded'] = 'Document Successfuly Uploaded';
$lang['the document'] = 'the document';


//Vehicle Screen
/* New Additions */
$lang['vehicle'] = 'vehicle';
$lang['vehicle_code'] = 'Vehicle Code';
$lang['vehicle_number'] = 'Vehicle Number';
$lang['owner_type'] = 'Owner Type';
$lang['Vehicle Code'] = 'Vehicle Code';
$lang['supplier'] = 'Supplier';


//Delivery Routes Screen
/* New Additions */
$lang['delivery_route_name'] = 'Delivery Route Name';
$lang['delivery route'] = 'delivery route';
$lang['Delivery Route'] = 'Delivery Route';


//Delivery Routes Screen
/* New Additions */
$lang['sales_terminal_code'] = 'Sales Terminal Code';
$lang['sales_terminal_name'] = 'Sales Terminal Name';
$lang['Sales Terminal'] = 'Sales Terminal';
$lang['Sales Terminal Code'] = 'Sales Terminal Code';
$lang['sales terminal'] = 'sales terminal';



////////////////////////////////////////  User Roles Module //////////////////////////////////////////////////////////////////
//Login Screen
/* New Additions */
$lang['error_user'] = 'User Name';
$lang['error_password'] = 'Password';
$lang['error_check_user'] = 'Invalid User Name or Password';

//Forgot password Screen
/* New Additions */
$lang['valid email'] = 'valid email';
$lang['Sorry, we could not send your password. No account was found with the email address you entered']='Sorry, we could not send your password. No account was found with the email address you entered';
$lang['Your account password has been reset and you can now login to your account area using the details below']='Your account password has been reset and you can now login to your account area using the details below';
$lang['Login to visit']='Login to visit';
$lang['Forgotten your password at eStock Manager System']='Forgotten your password at eStock Manager System';
$lang['Sorry, Email sending fail.']='Sorry, Email sending fail.';


//Sign Up
/* New Additions */
$lang['first_name'] = 'First Name';
$lang['last_name'] = 'Last Name';
$lang['comapany_name'] = 'Comapany Name';
$lang['job_title'] = 'Job Title';
$lang['contact_email'] = 'Contact Email';
$lang['contact_phone'] = 'Contact Phone';
$lang['country'] = 'Country';
$lang['no_of_employees'] = 'No of Employees';


//Change Password Screen
/* New Additions */
$lang['current_password'] = 'Current Password';
$lang['new_password'] = 'New Password';
$lang['confirm_password'] = 'Confirm Password';
$lang['Password Sucessfully Changed'] = 'Password Sucessfully Changed';
$lang['Incorrect Current Password'] = 'Incorrect Current Password';
$lang['veryfy_password'] = 'මුරපදය තහවුරු කිරීම, මුරපදය සමඟ ගැලපෙන්නේ නැත.';
$lang['new_password2'] = ' (must be at least 6 characters in length)';


//Change Language Screen
/* New Additions */
$lang['new_language'] = 'භාෂාව තෝරාගැනීම අනිවාර්යයි';
$lang['Language Sucessfully Changed'] = 'Language Sucessfully Changed';


//Derive User Roles
/* New Additions */
$lang['derive_user_role_name'] = 'Derive User Roles';
$lang['user_role'] = 'User Role';


//Main Modules
/* New Additions */
$lang['main_module'] = 'Main Module';


//Modules
/* New Additions */
$lang['module'] = 'Module';

//Users
/* New Additions */
$lang['User account'] = 'User account';


//Category Screen
/* New Additions */
$lang['category_name'] = 'Category Name';


//Unit Screen
/* New Additions */
$lang['unit_name'] = 'Unit Name';
$lang['unit'] = 'Unit';

//Unit Conversion Screen
/* New Additions */
$lang['Unit Conversion'] = 'Unit Conversion';
$lang['unit_conversion_name'] = 'Unit Conversion Name';
$lang['from_amount_not_valid'] = 'From amount is not valid';
$lang['to_amount_not_valid'] = 'To amount is not valid';
$lang['from_unit_required'] = 'From unit is required';
$lang['to_unit_required'] = 'To unit is required';
$lang['from_amount'] = 'From Amount';
$lang['to_amount'] = 'To Amount';
$lang['unit conversion'] = 'unit conversion';
$lang['unit_conversion_already_in_use_cannot_modify'] = 'Unit conversion is already being used. Therefore, cannot modify the unit conversion details.';


//Tax Types Screen
/* New Additions */
$lang['tax_name'] = 'Tax Name';
$lang['tax_percentage'] = 'Tax Percentage';
$lang['field should be a decimal number'] = 'field should be a decimal number';
$lang['Tax Type'] = 'Tax Type';
$lang['tax type'] = 'tax type';
$lang['Tax Type already selected'] = 'Tax Type already selected';


//Tax Chains Screen
/* New Additions */
$lang['Tax Chain'] = 'Tax Chain';
$lang['tax chain'] = 'tax chain';
$lang['At least one tax type is required for the tax chain'] = 'At least one tax type is required for the tax chain';


//Warehouse Screen
/* New Additions */
$lang['Warehouse'] = 'Warehouse';
$lang['warehouse_code'] = 'Warehouse Code';
$lang['warehouse_name'] = 'Warehouse Name';
$lang['warehouse details'] = 'warehouse details';


//System Configurations Screen
/* New Additions */
$lang['grn_reference_no_code_required'] = 'Good Receive Note Reference No Code is required';
$lang['grn_reference_no_start_number_required'] = 'Good Receive Note Reference No Starting Number is required';
$lang['grn_reference_no_start_number_should_be_a_number'] = 'Good Receive Note Reference No Starting Number should be numeric';
$lang['gdn_reference_no_code_required'] = 'Good Dispatch Note Reference No Code is required';
$lang['gdn_reference_no_start_number_required'] = 'Good Dispatch Note Reference No Starting Number is required';
$lang['gdn_reference_no_start_number_should_be_a_number'] = 'Good Dispatch Note Reference No Starting Number should be numeric';
$lang['gin_reference_no_code_required'] = 'Invoice No Code is required';
$lang['gin_reference_no_start_number_required'] = 'Invoice No Starting Number is required';
$lang['gin_reference_no_start_number_should_be_a_number'] = 'Invoice No Starting Number should be numeric';
$lang['grtn_reference_no_code_required'] = 'Good Return Note Reference No Code is required';
$lang['grtn_reference_no_start_number_required'] = 'Good Return Note Reference No Starting Number is required';
$lang['grtn_reference_no_start_number_should_be_a_number'] = 'Good Return Note Reference No Starting Number should be numeric';
$lang['Agent Category already added'] = 'Agent Category already added';
$lang['Customer Category already added'] = 'Customer Category already added';
$lang['Category already selected'] = 'Category already selected';
$lang['Agent category is already in use and cannot be deleted'] = 'Agent category is already in use and cannot be deleted';
$lang['Customer category is already in use and cannot be deleted'] = 'Customer category is already in use and cannot be deleted';
$lang['Symbol "-" is not allowed'] = 'Symbol "-" is not allowed';
$lang['si_reference_no_code_required'] = 'Sales Invoice No Code is required';
$lang['si_reference_no_start_number_required'] = 'Sales Invoice No Starting Number is required';
$lang['si_reference_no_start_number_should_be_a_number'] = 'Sales Invoice No Starting Number should be numeric';
$lang['sr_reference_no_code_required'] = 'Sales Return No Code is required';
$lang['sr_reference_no_start_number_required'] = 'Sales Return No Starting Number is required';
$lang['sr_reference_no_start_number_should_be_a_number'] = 'Sales Return No Starting Number should be numeric';


//Sub Category Screen
/* New Additions */
$lang['sub_category_name'] = 'Sub Category Name';


//Products Screen
/* New Additions */
$lang['product_code'] = 'Product Code';
$lang['product_name'] = 'Product Name';
$lang['product_cost'] = 'Product Cost';
$lang['display_unit'] = 'Display Unit';
$lang['customer_selling_price'] = 'Customer Selling Price';
$lang['Customer Selling Price should be greater than Product Cost'] = 'Customer Selling Price should be greater than Product Cost';
$lang['Min Selling Price should be less than Customer Selling Price'] = 'Min Selling Price should be less than Customer Selling Price';
$lang['Max Selling Price should be greater than Customer Selling Price'] = 'Max Selling Price should be greater than Customer Selling Price';
$lang['product'] = 'Product';
$lang['select_minimum_unit'] = 'Minimum unit of measure is selected to store product quantity amount. It is important to use minimum unit to avoid calculation issues.';
$lang['invalid_unit'] = 'Unit selected is not in unit conversion selected for the product. Minimum unit of measure is selected from selected unit conversion.';
$lang['should_select_minimum_unit'] = 'Unit selected is not the minimum unit from unit conversion selected. This may result for calculation errors.';
$lang['agent_selling_price'] = 'Agent Selling Price';
$lang['selling_price_min'] = 'Minimum Selling price';
$lang['selling_price_max'] = 'Maximum Selling price';
$lang['selling_price'] = 'Selling Price';
$lang['Not a valid percentage'] = 'Not a valid percentage';
$lang['Last product code saved is '] = 'Last product code saved is ';
$lang['Display Unit should be same as Unit since there is no Unit Conversion.'] = 'Display Unit should be same as Unit since there is no Unit Conversion.';
$lang['Re-order Level Unit should be same as Unit since there is no Unit Conversion.'] = 'Re-order Level Unit should be same as Unit since there is no Unit Conversion.';


//PO Screen
/* New Additions */
$lang['product in PO'] = 'product in PO';
$lang['product issue in PO'] = 'product issue in PO';
$lang['product_already_added_in_PO'] = 'Product is already added to the purchase order. Please select and edit to make changes.';
$lang['po_closed_successfully'] = 'Purchase Order closed successfully';
$lang['Are you sure to close the purchase order'] = 'Are you sure to close the purchase order';


//Open Stock Screen
/* New Additions */
$lang['stock_date'] = 'Date';
$lang['quantity'] = 'Quantity';
$lang['Product Already added ! Are you sure you want to Update this'] = 'Product Already added ! Are you sure you want to Update this';
$lang['opening stock'] = 'opening stock';
$lang['product in stock'] = 'product in stock';
$lang['You have changed the warehouse. '
                        . 'Product quantities in this opening stock will transfer to the new warehouse selected. '
                        . 'Are you sure you want to continue?'] = 'You have changed the warehouse. '
                        . 'Product quantities in this opening stock will transfer to the new warehouse selected. '
                        . 'Are you sure you want to continue?';
$lang['field should have only numeric data'] = 'field should have only numeric data';
$lang['opening_stock_already_added'] = 'Opening stock is already added for the selected product';
$lang['serial_number'] = 'Serial Number';
$lang['serial_number_already_exists'] = 'Serial number already added in the system';
$lang['all_serial_numbers_added'] = 'All serial numbers are added for product quantity';
$lang['serial_no_count_not_match_with_qty'] = 'Please note that serial number count does not match with the product quantity entered.';
$lang['product_batch_quantity_already_equal_to_warehouse_opening_stock_quantity'] = 'Batch quantity exceeding opening stock quantity total';
$lang['Please update batch details since the product quantity has been changed.'] = 'Please update batch details since the product quantity has been changed.';


//GRN Screen
/* New Additions */
$lang['reference_no'] = 'Reference No';
$lang['grn_date'] = 'GRN Date';
$lang['GRN'] = 'GRN';
$lang['Good receive note'] = 'Good receive note';
$lang['product in GRN'] = 'product in GRN';
$lang['product_not_defined'] = 'Specified product cannot be found in the system.';
$lang['product_already_added_in_GRN'] = 'Product is already added to the GRN. Please select and edit to make changes.';
$lang['You have changed the warehouse. '
                        . 'Product quantities in this GRN will transfer to the new warehouse selected. '
                        . 'Are you sure you want to continue?'] = 'You have changed the warehouse. '
                        . 'Product quantities in this GRN will transfer to the new warehouse selected. '
                        . 'Are you sure you want to continue?';
$lang['Batch Quantity cannot be zero'] = 'Batch Quantity cannot be zero';
$lang['product_batch_quantity_already_equal_to_grn_quantity'] = 'Batch quantity exceeding GRN quantity total';
$lang['Product Batch'] = 'Product Batch';
$lang['raw_material_batch_quantity_already_equal_to_grn_quantity'] = 'Batch quantity exceeding GRN quantity total';
$lang['Raw Material Batch'] = 'Raw Material Batch';
$lang['incorrect_prime_entry_book_selected_for_grn_transaction'] = 'Prime entry book which has selected has an incorrect chart of account mapping. '
                                                                 . 'Please make sure that there are only one debit account and one credit account selected.';
$lang['products_already_issued_so_cannot_delete_batch'] = 'Products are already issued from this batch. Therefore, the batch cannot be deleted.';
$lang['product_over_purchasing_authorizer_invalid'] = 'Invalid Authorizer Password!';


//GDN Screen
/* New Additions */
$lang['gdn_date'] = 'GDN Date';
$lang['GDN'] = 'GDN';
$lang['Good dispatch note'] = 'Good dispatch note';
$lang['product in GDN'] = 'product in GDN';
$lang['warehouse_stock_balance_insufficient'] = 'Warehouse stock balance is not sufficient to complete the requested dispatch.';
$lang['warehouse_stock_balance_for_batch_insufficient'] = 'Warehouse stock balance for batch is not sufficient to complete the requested dispatch.';
$lang['no_changes_to_save'] = 'There are no changes to save';
$lang['You have changed the warehouse. '
                        . 'Product quantities in this GDN will transfer to the new warehouse selected. '
                        . 'Are you sure you want to continue?'] = 'You have changed the warehouse. '
                        . 'Product quantities in this GDN will transfer to the new warehouse selected. '
                        . 'Are you sure you want to continue?';
$lang['product_already_added_in_GDN'] = 'Product is already added to the GDN. Please select and edit to make changes.';
$lang['Selecting a vehicle is mandatory for the transaction.'] = 'Selecting a vehicle is mandatory for the transaction.';
$lang['is_vehicle_not_required'] = 'You have not selected a vehicle for the transaction. If you need to update the stock balance'
        . ' of the delivery vehicle, you should select a vehicle. Are you sure to proceed without selecting a vehicle?';
$lang['Are you sure you want to remove this '] = 'Are you sure you want to remove this ';
$lang['incorrect_prime_entry_book_selected_for_gdn_transaction'] = 'Prime entry book which has selected has an incorrect chart of account mapping. '
                                                                 . 'Please make sure that there are only one debit account and one credit account selected.';


//GIN Screen
/* New Additions */
$lang['gin_date'] = 'GIN Date';
$lang['GIN'] = 'GIN';
$lang['Good issue note'] = 'Good issue note';
$lang['product in GIN'] = 'product in GIN';
$lang['warehouse_stock_balance_insufficient'] = 'Warehouse stock balance is not sufficient to complete the requested transaction.';
$lang['lorry_stock_balance_insufficient'] = 'Lorry stock balance is not sufficient to complete the requested transaction.';
$lang['product_not_in_stock'] = 'Specified product is not currently available in stock. You may need to add an opening balance.';
$lang['Issued To'] = 'Issued To';
$lang['Issued To Person'] = 'Issued To Person';
$lang['You have changed the warehouse. '
                        . 'Product quantities in this GIN will transfer to the new warehouse selected. '
                        . 'Are you sure you want to continue?'] = 'You have changed the warehouse. '
                        . 'Product quantities in this invoice will transfer to the new warehouse selected. '
                        . 'Are you sure you want to continue?';
$lang['custom_rate'] = 'Cunstom Rate';
$lang['product_already_added_in_GIN'] = 'Product is already added to the invoice. Please select and edit to make changes.';
$lang['Issued to person'] = 'Issued to person';
$lang['product_already_added_in_same_unit'] = 'Product is already added to the transaction in same unit. Please select and edit to make changes.';
$lang['product_already_added_in_same_unit_and_for_same_batch'] = 'Product is already added to the transaction in same unit and for same batch. Please select and edit to make changes.';
$lang['incorrect_prime_entry_book_selected_for_gin_transaction'] = 'Prime entry book which has selected has an incorrect chart of account mapping. '
                                                                 . 'Please make sure that there are only one debit account and one credit account selected.';


//GRTN Screen
/* New Additions */
$lang['reference_no'] = 'Reference No';
$lang['grtn_date'] = 'GRTN Date';
$lang['GRTN'] = 'GRTN';
$lang['Good return note'] = 'Good return note';
$lang['product in GRTN'] = 'product in GRTN';
$lang['Returned By'] = 'Returned By';
$lang['Returned By Person'] = 'Returned By Person';
$lang['product_already_added_in_GRTN'] = 'Product is already added to the GRTN. Please select and edit to make changes.';
$lang['saved_with_zero_openeing_balance_for_lorry'] = 'Selected vehicle has no stock for the product. Zero opening stock will be added for the vehicle '
        . 'for selected product';
$lang['incorrect_prime_entry_book_selected_for_grtn_transaction'] = 'Prime entry book which has selected has an incorrect chart of account mapping. '
                                                                 . 'Please make sure that there are only one debit account and one credit account selected.';


//Supplier Return
/* New Additions */
$lang['warehouse_stock_balance_for_batch_insufficient_for_the_return'] = 'Warehouse stock balance for batch is not sufficient to complete the requested return.';
$lang['product in Supplier Return'] = 'product in Supplier Return';
$lang['You have changed the warehouse. '
                        . 'Product quantities in this supplier return will transfer to the new warehouse selected. '
                        . 'Are you sure you want to continue?'] = 'You have changed the warehouse. '
                        . 'Product quantities in this supplier return will transfer to the new warehouse selected. '
                        . 'Are you sure you want to continue?';


//Product DIsposal
/* New Additions */
//$lang['warehouse_stock_balance_for_batch_insufficient_for_the_return'] = 'Warehouse stock balance for batch is not sufficient to complete the requested return.';
$lang['product in Product Disposal'] = 'product in Product Disposal';
$lang['You have changed the warehouse. '
                        . 'Product quantities in this product disposal will transfer to the new warehouse selected. '
                        . 'Are you sure you want to continue?'] = 'You have changed the warehouse. '
                        . 'Product quantities in this product disposal will transfer to the new warehouse selected. '
                        . 'Are you sure you want to continue?';


//Stock Update Screen
$lang['product_not_in_new_warehouse'] = 'Product is not in the stock of selected warehouse';
$lang['product stock update record'] = 'product stock update record';
$lang['stock update record'] = 'stock update record';
$lang['You have changed the warehouse. '
                        . 'Product quantities in this stock update will transfer to the new warehouse selected. '
                        . 'Are you sure you want to continue?'] = 'You have changed the warehouse. '
                        . 'Product quantities in this stock update will transfer to the new warehouse selected. '
                        . 'Are you sure you want to continue?';


//Inventory Reports screen
/* New Additions */
$lang['no_data_found'] = 'Data not found for search criterias to generate a chart. Select search filters and click on "Search" button to generate a chart.';
$lang['Field is required'] ='Field is required';
$lang['chart_view_required'] ='Chart View';
$lang['transaction_type_required'] ='Transaction Type';
$lang['chart_type_required'] ='Chart Type';
$lang['product_batch_inactivated'] ='Product batch inactivated successfully. Please reload the report to see latest records.';
$lang['Are you sure you want to inactivate this product batch'] = 'Are you sure you want to inactivate this product batch';
$lang['product_stock_movement_analytical_settings_are_not_set'] = 'Stock movement analytical settings are not set in configurations. Please specify analytical settings before process the report.';
$lang['Do you really need to print the order sheet?'] = 'Do you really need to print the order sheet?';
$lang['product_order_sheet_saved_successfully'] = 'Purchased order saved successfully.';


//License Check Screen
/* New Additions */
$lang['LiLicence file of e Stock Manager is not found or not valid to run the application. <br>"
                          . "please check with your system administrator to fix the issue.'] = 'Licence file of e Stock Manager is not found or not valid to run the application. <br>"
                          . "please check with your system administrator to fix the issue.';
$lang['Licence of eStock Manager is not valid for this domain. Please contact Artifectx Solutions (pvt) Ltd via "
                . "<br><strong>info@artifects.com</strong> to get a valid licence to run the application.'] = 'Licence of eStock Manager is not valid for this domain. Please contact Artifectx Solutions (pvt) Ltd via "
                . "<br><strong>info@artifects.com</strong> to get a valid licence to run the application.';
$lang['Licence of eStock Manager has expired. Please contact Artifectx Solutions (pvt) Ltd via "
                . "<br><strong>info@artifects.com</strong> to get a valid licence to run the application.'] = 'Licence of eStock Manager has expired. Please contact Artifectx Solutions (pvt) Ltd via "
                . "<br><strong>info@artifects.com</strong> to get a valid licence to run the application.';
$lang['EXPIRE_REACH:This is an evaluation licence and will expire in " . $noOfDaysToExpire . " days. "
                            . "Please contact Artifectx Solutions (pvt) Ltd via <br><strong>info@artifects.com</strong> for more information.'] = 
        'EXPIRE_REACH:This is an evaluation licence and will expire in " . $noOfDaysToExpire . " days. "
                            . "Please contact Artifectx Solutions (pvt) Ltd via <br><strong>info@artifects.com</strong> for more information.';
$lang['EXPIRE_REACH:Please note that licence of eStock Manager will expire in " . $noOfDaysToExpire . " days. "
                            . "Please contact Artifectx Solutions (pvt) Ltd via <br><strong>info@artifects.com</strong> to get a valid licence "
                            . "to run the application without any interruption.'] = 'EXPIRE_REACH:Please note that licence of eStock Manager will expire in " . $noOfDaysToExpire . " days. "
                            . "Please contact Artifectx Solutions (pvt) Ltd via <br><strong>info@artifects.com</strong> to get a valid licence "
                            . "to run the application without any interruption.';







//Raw Material Screen
/* New Additions */
$lang['raw_material_code'] = 'Raw Material Code';
$lang['raw_material_name'] = 'Raw Material Name';
$lang['raw_material_cost'] = 'Raw Material Cost';
$lang['raw_material'] = 'Raw Material';
$lang['Last raw material code saved is '] = 'Last raw material code saved is ';


//Open Stock Screen
/* New Additions */
$lang['Raw material already added! Are you sure you want to Update this'] = 'Raw material already added! Are you sure you want to Update this';
$lang['raw material in stock'] = 'raw material in stock';
$lang['raw_material_not_defined'] = 'Specified raw material cannot be found in the system.';
$lang['raw_material_batch_quantity_already_equal_to_warehouse_opening_stock_quantity'] = 'Batch quantity exceeding opening stock quantity total';
$lang['Please update batch details since the raw material quantity has been changed.'] = 'Please update batch details since the raw material quantity has been changed.';


//GRN Screen
/* New Additions */
$lang['raw material in GRN'] = 'raw material in GRN';
$lang['raw_material_not_defined'] = 'Specified raw material cannot be found in the system.';
$lang['raw_material_already_added_in_GRN'] = 'Raw Material is already added to the GRN. Please select and edit to make changes.';
$lang['You have changed the warehouse. '
                        . 'Raw Material quantities in this GRN will transfer to the new warehouse selected. '
                        . 'Are you sure you want to continue?'] = 'You have changed the warehouse. '
                        . 'Raw Material quantities in this GRN will transfer to the new warehouse selected. '
                        . 'Are you sure you want to continue?';
$lang['The purchase order selected is already used in another GRN. '
    . 'Are you sure to use it again in this GRN as well'] = 'The purchase order selected is already used in another GRN. '
        . 'Are you sure to use it again in this GRN as well';
$lang['raw_materials_already_issued_so_cannot_delete_batch'] = 'Raw Materials are already issued from this batch. Therefore, the batch cannot be deleted.';


//GDN Screen
/* New Additions */
$lang['raw material in GDN'] = 'raw material in GDN';
$lang['You have changed the warehouse. '
                        . 'Raw Material quantities in this GDN will transfer to the new warehouse selected. '
                        . 'Are you sure you want to continue?'] = 'You have changed the warehouse. '
                        . 'Raw Material quantities in this GDN will transfer to the new warehouse selected. '
                        . 'Are you sure you want to continue?';
$lang['raw_material_already_added_in_GDN'] = 'Raw Material is already added to the GDN. Please select and edit to make changes.';
$lang['raw_material_already_added_in_same_unit_and_for_same_batch'] = 'Raw Material is already added to the transaction in same unit and for same batch. Please select and edit to make changes.';


//GIN Screen
/* New Additions */
$lang['raw material in GIN'] = 'raw material in GIN';
$lang['raw_material_not_in_stock'] = 'Specified raw material is not currently available in stock. You may need to add an opening balance.';
$lang['You have changed the warehouse. '
                        . 'Raw Material quantities in this GIN will transfer to the new warehouse selected. '
                        . 'Are you sure you want to continue?'] = 'You have changed the warehouse. '
                        . 'Raw Material quantities in this invoice will transfer to the new warehouse selected. '
                        . 'Are you sure you want to continue?';
$lang['raw_material_already_added_in_GIN'] = 'Raw Material is already added to the invoice. Please select and edit to make changes.';
$lang['raw_material_already_added_in_same_unit'] = 'Raw Material is already added to the transaction in same unit. Please select and edit to make changes.';


//GRTN Screen
/* New Additions */
$lang['raw material in GRTN'] = 'raw material in GRTN';
$lang['raw_material_already_added_in_GRTN'] = 'Raw Material is already added to the GRTN. Please select and edit to make changes.';

//Supplier Return Screen
/*New Additions*/
$lang['raw material in Supplier Return'] = 'raw material in Supplier Return';

//Raw Material Disposal
/*New Additions*/
$lang['raw material in Raw Material Disposal'] = 'raw material in Raw Material Disposal';

//PO Screen
/* New Additions */
$lang['raw material in PO'] = 'raw material in PO';
$lang['raw material issue in PO'] = 'raw material issue in PO';
$lang['PO'] = 'PO';
$lang['raw_material_already_added_in_PO'] = 'Raw Material is already added to the purchase order. Please select and edit to make changes.';


//Stock Update Screen
$lang['raw_material_not_in_new_warehouse'] = 'Raw Material is not in the stock of selected warehouse';
$lang['raw material stock update record'] = 'raw material stock update record';
$lang['stock update record'] = 'stock update record';
$lang['You have changed the warehouse. '
                        . 'Raw Material quantities in this stock update will transfer to the new warehouse selected. '
                        . 'Are you sure you want to continue?'] = 'You have changed the warehouse. '
                        . 'Raw Material quantities in this stock update will transfer to the new warehouse selected. '
                        . 'Are you sure you want to continue?';


////////////////////////////////////////  Sales Module /////////////////////////////////////////////////////////////////////////////////////

//Sales Invoice Screen
/* New Additions */
$lang['Selecting either warehouse or vehicle is mandatory'] = 'Selecting either warehouse or vehicle is mandatory';
$lang['Selecting warehouse is mandatory'] = 'Selecting warehouse is mandatory';
$lang['You have changed the warehouse. '
                        . 'Item quantities in this Sales Invoice will be updated according to new data selected. '
                        . 'Are you sure you want to continue?'] = 'You have changed the warehouse. '
                        . 'Item quantities in this Sales Invoice will be updated according to new data selected. '
                        . 'Are you sure you want to continue?';
$lang['item_already_added_in_sales_invoice_with_same_unit'] = "Selected item is already added in sales invoice for same sales unit.";
$lang['item_already_added_in_sales_invoice_with_same_unit_and_for_same_batch'] = "Selected item is already added in sales invoice with same sales unit and for same batch.";
$lang['vehicles_stock_not_monitoring_warehouse_select_required'] = 'The item stock of selected lorry is not monitoring. Selecting a warehouse is required.' ;
$lang['warehouse_stock_balance_insufficient_but_data_is_saved_successfully'] = 'Data saved successfully. However, please note that '
        . 'warehouse stock balance was not sufficient. Please correct the quantity if there is an error.';
$lang['item in Sales Invoice'] = 'item in Sales Invoice';
$lang['Are you sure you want to close this Sales Invoice? Further modifications are not possible after close.'] = 
        'Are you sure you want to close this Sales Invoice? Further modifications are not possible after close.';
$lang['sales_invoice_successfully_closed'] = 'Sales invoice closed successfully';
$lang['cheque_number'] = 'Cheque Number';
$lang['Cheque'] = 'Cheque';
$lang['customer_already_added'] = 'Customer name already added. Please enter a different name.';
$lang['reference_no_not_added'] = '"Sales Invoice No" not specified. Please specify a "Sales Invoice No" before close the sales invoice.';
$lang['income_cheque_total_greater_than_manual_cheque_total'] = 'Collected cheque total is greater than the cheque payment you entered manually';
$lang['vehicle_stock_is_not_monitoring_cannot_add_the_sales_invoice'] = 'Stock of the selected vehicle is not monitoring. Therefore, the sales invoice cannot be saved';
$lang['warehouse_stock_balance_for_batch_not_sufficient'] = 'Warehouse batch stock balance is not sufficient to complete the requested transaction.';
$lang['incorrect_prime_entry_book_selected_for_sales_invoice_transaction'] = 'Prime entry book which has selected has an incorrect chart of account mapping. '
                                                                 . 'Please make sure that there are only one debit account and one credit account selected.';
$lang['selecting_a_batch_is_required'] = 'Please select a batch to complete the transaction';
$lang['warehouse_not_accessible_or_login_details_invalid'] = 'Selected warehouse is not accessible or login details invalid!';
$lang['pos_sales_invoice_saved_successfully'] = 'Sales invoice saved successfully';
$lang['pos_item_already_selected'] = 'Item is already selected in the list!';
$lang['Payment details not specified. Are you sure to post the sales invoice?'] = 'Payment details not specified. Are you sure to post the sales invoice?';
$lang['There are on hold invoices to post. Are you sure to close the POS screen? Upon closing you will loose the on hold invoices!'] = 'There are on hold invoices to post. Are you sure to close the POS screen? Upon closing you will loose the on hold invoices!';
$lang['Item quantity details specified is incomplete. Please make required corrections.'] = 'Item quantity details specified is incomplete. Please make required corrections.';
$lang['Payment details not specified!'] = 'Payment details not specified!';
$lang['Payment already collected. Therefore cannot change payment details.'] = 'Payment already collected. Therefore cannot change payment details.';
$lang['pos_sales_invoice_payment_details_saved_successfully'] = 'Sales invoice payment details saved successfully';
$lang['pos_warehouse_stock_insufficient'] = 'Stock balance is not sufficient';


//Sales Return Screen
/* New Additions */
$lang['item_not_defined'] = 'Specified item cannot be found in the system.';
$lang['item_already_added_in_GRN'] = 'Item is already added to the sales return. Please select and edit to make changes.';
$lang['item in Sales Return'] = 'item in Sales Return';
$lang['You have changed the warehouse. '
                        . 'Item quantities in this Sales Return will be updated according to new data selected. '
                        . 'Are you sure you want to continue?'] = 'You have changed the warehouse. '
                        . 'Item quantities in this Sales Return will be updated according to new data selected. '
                        . 'Are you sure you want to continue?';
$lang['item_already_added_in_same_unit'] = 'Item is already added to the transaction in same unit. Please select and edit to make changes.';
$lang['item_already_added_in_same_unit_and_for_same_batch'] = 'Item is already added to the transaction in same unit and for same batch. Please select and edit to make changes.';
$lang['incorrect_prime_entry_book_selected_for_sales_return_transaction'] = 'Prime entry book which has selected has an incorrect chart of account mapping. '
                                                                 . 'Please make sure that there are only one debit account and one credit account selected.';


////////////////////////////////////////  General Ledger Module ////////////////////////////////////////////////////////////////////////////////

//Prime Entry Book Screen
/* New Additions */
$lang['prime entry book'] = 'prime entry book';
$lang['prime_entry_book_name'] = 'Prime entry book name';
$lang['debit_chart_of_account_required'] = 'Debit chart of account is required';
$lang['credit_chart_of_account_required'] = 'Credit chart of account is required';
$lang['Debit chart of account and credit chart of account cannot be same'] = 'Debit chart of account and credit chart of account cannot be same';
$lang['should_select_last_chart_of_account_in_hierarchy'] = 'You can only select the last chart of account in the hierarchy';


//Journal Entries Screen
/* New Additions */
$lang['transaction_value'] = 'Transaction Value';
$lang['prime_entry_book_required'] = 'Selecting a prime entry book is required';
$lang['Debit and credit amounts not added'] = 'Debit and credit amounts not added';
$lang['journal entry'] = 'journal entry';


//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////  Accounts Manager Module ////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

$lang['Location is already used in journal entries. Therefore, the configuration option is disabled.'] = 'ස්ථානය දැනටමත් ජර්නල් සටහන් තුළ භාවිතා වේ. එබැවින් වෙනස්කම් සිදුකිරීම අක්‍රීය කර ඇත.';
$lang['Chart of Account already selected'] = 'Chart of Account already selected';
$lang['Chart of Account selected is a child account of already selected chart of account'] = 'Chart of Account selected is a child account of already selected chart of account';
$lang['Chart of Account Sucessfully Saved'] = 'Chart of Account Sucessfully Saved';
$lang['Chart of Account Sucessfully Deleted'] = 'Chart of Account Sucessfully Deleted';
$lang['Mother Chart of Account Cannot Be Deleted!'] = 'Mother Chart of Account Cannot Be Deleted!';
$lang['Chart of Account Sucessfully Moved'] = 'Chart of Account Sucessfully Moved';


//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////  HR Manager  /////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

////////////////////////////////////////  Administration Section Messages /////////////////////////////////////////////////

//Job Title Screen
/* New Additions */
$lang['job_title'] = 'Job Title';


//Job Category Screen
/* New Additions */
$lang['job_category'] = 'Job Category';


//Employement Status Screen
/* New Additions */
$lang['employment_status'] = 'Employement Status';
$lang['description'] = 'Description';


//Department Screen
/* New Additions */
$lang['department'] = 'Department';
$lang['department_code'] = 'Department Code';
$lang['Department code is already in use'] = 'Department code is already in use';


//Data Import Screen
/* New Additions */
$lang['Data_import_workbook_successfully_uploaded'] = 'Data import workbook successfully uploaded';
$lang['Data_import_workbook_errors'] = 'Data import workbook has errors. Please click on "Download Data Import Workbook Error Log File" button to see errors and take required actions before re-upload.';
$lang['Data_imported_successfully'] = 'Data imported successfully';
$lang['Data_import_identified_errors'] = 'There are errors with data import. Please click on "Download Data Import Error Log File" button to see errors and take required actions before import again.';
$lang['You did not select a file to upload.'] = 'You did not select a file to upload.';
$lang['The file type you are attempting to upload is not allowed.'] = 'The file type you are attempting to upload is not allowed.';
$lang['The upload destination folder does not appear to be writable.'] = 'The upload destination folder does not appear to be writable.';
$lang['Select only one import option'] = 'Select only one import option';
$lang['Select a data import option to proceed'] = 'Select a data import option to proceed';
$lang['There are no workbook errors'] = 'There are no errors with the data import workbook.';
$lang['There are no data import errors'] = 'There are no errors during the data import.';


////////////////////////////////////////  PIM Section //////////////////////////////////////////////////////////////////////

//Personal Details Screen
/* New Additions */
$lang['first_name'] = 'First Name';
$lang['Are you sure you want to delete this employee'] = 'Are you sure you want to delete this employee';
$lang['Employee Photo Successfuly Uploaded'] = 'Employee Photo Successfuly Uploaded';
$lang['file_to_upload'] = 'Employee Photo';


//Job Details Screen
/* New Additions */
$lang['Employee code is already in use'] = 'Employee code is already in use';


////////////////////////////////////////  Time & Attendance Section //////////////////////////////////////////////////

//Working Shifts Screen
/* New Additions */
$lang['Are you sure you want to delete this working shift?'] = 'Are you sure you want to delete this working shift?';
$lang['Shift code is already in use'] = 'Shift code is already in use';
$lang['time_field_required'] = 'Time field is required';
$lang['start_time_should_greater_than_end_time'] = 'Start time should be greater than previous shift hours end time';
$lang['start_time_should_not_equal_to_end_time'] = 'Start time should not equal to previous shift hours end time';
$lang['end_time_should_not_equal_to_start_time'] = 'End time should not equal to start time';
$lang['end_time_should_greater_than_start_time'] = 'End time should be greater than start time';
$lang['shift_hourly_pay_rate_not_valid'] = 'Shift time hourly pay rate is not valid';
$lang['break_hourly_pay_rate_not_valid'] = 'Break time hourly pay rate is not valid';
$lang['default_shift_already_exists'] = 'Default shift already exists';


//Employee Working Rosters Screen
/* New Additions */
$lang['select_more_than_one_employee_to_configure_bulk_roster'] = 'Please select more than one employee to configure bulk roster.';


//Employee Attendance Screen
/* New Additions */
$lang['time_is_not_valid'] = 'Time is not valid';
$lang['Punch time already exists'] = 'Punch time already exists';
$lang['Are you sure you want to delete attendance record'] = 'Are you sure you want to delete attendance record';
$lang['attendance_cycle_closed'] = 'Attendance cycle is already closed for the selected attendance record. Record cannot be deleted';
$lang['Punch time already exists and is marked as deleted. Click on "Reuse Existing Attendance Record" button to reuse the deleted attendance record'] = 'Punch time already exists and is marked as deleted. Click on "Reuse Existing Attendance Record" button to reuse the deleted attendance record';


////////////////////////////////////////  Analytics Section ///////////////////////////////////////////////////////////////

//Reports Screen
/* New Additions */
$lang['Report folder successfully created.'] = 'Report folder successfully created.';
$lang['Report details successfully saved.'] = 'Report details successfully saved.';
$lang['Report fields successfully saved.'] = 'Report fields successfully saved.';
$lang['Report conditions successfully saved.'] = 'Report conditions successfully saved.';
$lang['Report is not selected/created to add fields. Please select or create a report in "Step 1" first.'] = 'Report is not selected/created to add fields. Please select or create a report in "Step 1" first.';
$lang['Are you sure you want to delete this report?'] = 'Are you sure you want to delete this report?';
$lang['report_folder_has_reports'] = 'Selected report folder contains reports. Therefore, the folder cannot be deleted. If you need to delete the folder, either delete reports inside the folder or move reports to another folder.';
$lang['report_folder_deleted_successfully'] = "Report folder successfully deleted.";


//Add New Report Folder - Modal popup filed validation
/* New Additions */
$lang['folder_name'] = 'Folder Name';


//Save Report Details - Modal popup filed validation
/* New Additions */
$lang['report_name'] = 'Report Name';
$lang['folder_for_report'] = 'Folder Name';
$lang['report_fields_list'] = 'Select Report Fields is required';
$lang['condition_field_required'] = 'Condition field is required';
$lang['condition_criteria_required'] = 'Condition criteria is required';
$lang['condition_value_required'] = 'Condition value is required';


////////////////////////////////////////  Service Manager Module //////////////////////////////////////////////////////////////////

////////////////////////////////////////  Reservation Manager Module //////////////////////////////////////////////////////////////////

//Add New Buildings Screen
/* New Additions */
$lang['building_name'] = 'Building Name';
$lang['building details'] = 'building details';


////////////////////////////////////////  Donation Manager Module //////////////////////////////////////////////////////////////////

//Programs Screen
/* New Additions */
$lang['program_name'] = 'Program Name';
$lang['program details'] = 'program details';

//Collect Donations Screen
/* New Additions */
$lang['donation details'] = 'donation details';
$lang['Please select a program'] = 'Please select a program';
$lang['Program already selected'] = 'Program already selected';
$lang['Please select a prime entry book'] = 'Please select a prime entry book';

//Program Progress Screen
/* New Additions */
$lang['activity_name'] = 'Activity Name';
$lang['start_date'] = 'Start Date';
$lang['finish_date'] = 'Finish Date';
$lang['activity_owner_id'] = 'Activity Owner';
$lang['activity_budget'] = 'Activity Budget';
$lang['Program Activity'] = 'Program Activity';
$lang['program activity details'] = 'program activity details';
$lang['issue_date'] = 'Issue Date';
$lang['budget_issue_amount'] = 'Budget Issue Amount';
$lang['budget issue details'] = 'budget issue details';
$lang['return_date'] = 'Return Date';
$lang['budget_return_amount'] = 'Budget Return Amount';
$lang['budget return details'] = 'budget return details';