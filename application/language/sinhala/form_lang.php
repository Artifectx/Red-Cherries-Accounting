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

//Labels, Text Fields & Buttons In Screens

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////  Common Fields //////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

$lang['Description'] = 'විස්තර';
$lang['-- Select --'] = '-- තෝරන්න --';
$lang['-- Select Country --'] = '-- රට තෝරන්න --';
$lang['-- Select Role --'] = '-- කාර්යභාරය තෝරන්න --';
$lang['Success'] = 'සාර්ථකයි';
$lang['Select All'] = 'Select All';
$lang['None'] = 'None';
$lang['Print'] = 'Print';
$lang['All'] = 'All';
$lang['Active'] = 'Active';
$lang['Inactive'] = 'Inactive';
$lang['Inactivate'] = 'Inactivate';
$lang['warning'] = 'warning';
$lang['Help'] = 'උදව්';
$lang['Action User']='Action User';
$lang['Action Date']='Action Date';
$lang['Last Action Status']='Last Action Status';
$lang['Previous Action Status']='Previous Action Status';
$lang['Next Data Changes']='Next Data Changes';
$lang['Default Module']='පෙරනිමි මොඩියුලය';
$lang['System Dashboard'] = 'පද්ධති ඩෑෂ්බෝඩ්';
$lang['Enabled'] = 'Enabled';
$lang['Disabled'] = 'Disabled';
$lang['Module section is not purchased'] = 'Module section is not purchased';
$lang['Module is not purchased'] = 'Module is not purchased';
$lang['Select'] = 'Select';
$lang['Product is deleted'] = 'Product is deleted';
$lang['GIN is deleted'] = 'GIN is deleted';
$lang['Username'] = 'Username';
$lang['Welcome To e-ER Planner'] = 'e-ER Planner වෙත සාදරයෙන් පිළිගනිමු';
$lang['Organization'] = 'ආයතන පරිපාලනය';
$lang['Stock Manager'] = 'ගබඩා කළමණාකරු';
$lang['Production Manager'] = 'නිෂ්පාදන කළමණාකරු';
$lang['HR Manager'] = 'මානව සම්පත් කළමණාකරු';
$lang['Payroll Manager'] = 'වැටුප් කළමණාකරු';
$lang['Accounts Manager'] = 'ගිණුම් කළමණාකරු';
$lang['Service Manager'] = 'සේවා කළමණාකරු';
$lang['User Role Manager'] = 'පරිශීලක කාර්යභාර කළමණාකරු';
$lang['Donation Manager'] = 'පරිත්‍යාග කළමණාකරු';


//Menus
$lang['Change contrast color'] = 'Change contrast color';
$lang['Profile'] = 'Profile';
$lang['Change Password'] = 'මුරපදය වෙනස් කරන්න';
$lang['My Language'] = 'මගේ භාෂාව';
$lang['Dashboard'] = 'ඩෑෂ්බෝඩ්';
$lang['System Modules']='පද්ධති මොඩියුලයන්';
$lang['Open System Modules']='පද්ධතියේ මොඩියුලයන් විවෘත කරන්න';
$lang['Retract System Modules']='පද්ධති මොඩියුල ප්‍රතිස්ථාපනය කිරීම';
$lang['Toggle Left Menu'] = 'වම් පස මෙනුව හැකිලීම හා දිගහැරීම';
$lang['Change Language'] = 'භාෂාව වෙනස් කරන්න';
$lang['Language'] = 'භාෂාව';
$lang['English'] = 'English';
$lang['Sinhala'] = 'Sinhala';


//Buttons In Screens
$lang['Save'] = 'සුරකින්න';
$lang['Refresh'] = 'නැවුම් කරන්න';
$lang['Close'] = 'වසන්න';
$lang['Add New'] = 'Add New';
$lang['Back'] = 'Back';
$lang['Search'] = 'සෙවීම';
$lang['Add'] = 'එකතු කරන්න';
$lang['Save Changes'] = 'වෙනස්කම් සුරකින්න';
$lang['Send']='Send';

//Buttons In Tables
$lang['Edit'] = 'සංස්කරණය කරන්න';
$lang['Delete'] = 'ඉවත් කරන්න';
$lang['Actions'] = 'කටයුතු';
$lang['Generate'] = 'Generate';
$lang['View'] = 'View';


/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////  Organization  /////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

$lang['Organization Dashboard'] = 'ආයතන පරිපාලන ඩෑෂ්බෝඩ්';
$lang['Dashboard - Organization'] = 'ඩෑෂ්බෝඩ් - ආයතන පරිපාලනය';


////////////////////////////////////////  Administration Section /////////////////////////////////////////////////////////////


//Data Import Screen
$lang['Download Organization Master Data Import Excel Workbook'] = 'ආයතන දත්ත ඇසිරීමේ Excel වැඩපොත බාගත කරන්න';
$lang['Upload Organization Master Data Import Excel Workbook'] = 'ආයතන දත්ත ඇසිරීමේ Excel වැඩපොත අප්ලොඩ් කරන්න';
$lang['Import Supplier Information'] = 'සැපයුම්කරුවන්ගේ තොරතුරු අසුරන්න';
$lang['Import Agent Information'] = 'නියෝජිතයන්ගේ තොරතුරු අසුරන්න';
$lang['Import Customer Information'] = 'පාරිභෝගිකයන්ගේ තොරතුරු අසුරන්න';
$lang['Import Sales Rep Information'] = 'අලෙවි නියෝජිතයන්ගේ තොරතුරු අසුරන්න';
$lang['Import Driver Information'] = 'රියදුරන්ගේ තොරතුරු අසුරන්න';
$lang['Import Employee Information'] = 'සේවකයන්ගේ තොරතුරු අසුරන්න';


////////////////////////////////////////  Organization Section /////////////////////////////////////////////////////////////


//Menus
$lang['Company Information'] = 'සමාගමේ තොරතුරු';
$lang['Company Structure'] = 'සමාගම් ව්‍යුහය';


//Company Information Screen
$lang['Company Name'] = 'සමාගම් නාමය';
$lang['E-mail'] = 'විද්යුත් තැපෑල';
$lang['Web'] = 'වෙබ් ලිපිනය';
$lang['Primary Phone Number'] = 'ප්‍රථමික දුරකථන අංකය';
$lang['Secendory Phone Number'] = 'ද්විතීක දුරකථන අංකය';
$lang['Fax'] = 'ෆැක්ස්';


//Help Screen
$lang['Organization Help'] = 'ආයතන සහය';
$lang['Download Organization Help User Guide'] = 'ආයතන සහයක පරිශීලක උපදෙස් පොත බාගත කරන්න';


/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////  Stock Manager  /////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


$lang['Stock Manager Dashboard'] = 'Stock Manager Dashboard';
$lang['Dashboard - Stock Manager'] = 'Dashboard - Stock Manager';
$lang['Statistics'] = 'විශ්ලේෂණය';
$lang['Quick Links'] = 'ඉක්මන් සබැඳි';
$lang['Finish Good Sales'] = 'Finish Good Sales';
$lang['Raw Material Sales'] = 'Raw Material Sales';
$lang['Data not available'] = 'Data not available';
$lang['Current Month Weekly Sales'] = 'Current Month Weekly Sales';
$lang['Last Month Weekly Sales'] = 'Last Month Weekly Sales';
$lang['Last Two Months Weekly Sales'] = 'Last Two Months Weekly Sales';
$lang['Last Three Months Monthly Sales'] = 'Last Three Months Monthly Sales';
$lang['Last Six Months Monthly Sales'] = 'Last Six Months Monthly Sales';
$lang['This Year Monthly Sales'] = 'This Year Monthly Sales';
$lang['Last Year Monthly Sales'] = 'Last Year Monthly Sales';
$lang['Finish Good GRNs'] = 'Finish Good GRNs';
$lang['Raw Material GRNs'] = 'Raw Material GRNs';
$lang['Current Month Weekly GRNs'] = 'Current Month Weekly GRNs';
$lang['Last Month Weekly GRNs'] = 'Last Month Weekly GRNs';
$lang['Last Two Months Weekly GRNs'] = 'Last Two Months Weekly GRNs';
$lang['Last Three Months Monthly GRNs'] = 'Last Three Months Monthly GRNs';
$lang['Last Six Months Monthly GRNs'] = 'Last Six Months Monthly GRNs';
$lang['This Year Monthly GRNs'] = 'This Year Monthly GRNs';
$lang['Last Year Monthly GRNs'] = 'Last Year Monthly GRNs';
$lang['Finish Good Proforma Invoices'] = 'Finish Good Proforma Invoices';
$lang['Raw Material Proforma Invoices'] = 'Raw Material Proforma Invoices';
$lang['Current Month Weekly Proforma Invoices'] = 'Current Month Weekly Proforma Invoices';
$lang['Last Month Weekly Proforma Invoices'] = 'Last Month Weekly Proforma Invoices';
$lang['Last Two Months Weekly Proforma Invoices'] = 'Last Two Months Weekly Proforma Invoices';
$lang['Last Three Months Monthly Proforma Invoices'] = 'Last Three Months Monthly Proforma Invoices';
$lang['Last Six Months Monthly Proforma Invoices'] = 'Last Six Months Monthly Proforma Invoices';
$lang['This Year Monthly Proforma Invoices'] = 'This Year Monthly Proforma Invoices';
$lang['Last Year Monthly Proforma Invoices'] = 'Last Year Monthly Proforma Invoices';
$lang['Finish Good Sales Vs GRNs'] = 'Finish Good Sales Vs GRNs';
$lang['Raw Material Sales Vs GRNs'] = 'Raw Material Sales Vs GRNs';
$lang['Current Month Weekly Sales Vs GRNs'] = 'Current Month Weekly Sales Vs GRNs';
$lang['Last Month Weekly Sales Vs GRNs'] = 'Last Month Weekly Sales Vs GRNs';
$lang['Last Two Months Weekly Sales Vs GRNs'] = 'Last Two Months Weekly Sales Vs GRNs';
$lang['Last Three Months Monthly Sales Vs GRNs'] = 'Last Three Months Monthly Sales Vs GRNs';
$lang['Last Six Months Monthly Sales Vs GRNs'] = 'Last Six Months Monthly Sales Vs GRNs';
$lang['This Year Monthly Sales Vs GRNs'] = 'This Year Monthly Sales Vs GRNs';
$lang['Last Year Monthly Sales Vs GRNs'] = 'Last Year Monthly Sales Vs GRNs';


////////////////////////////////////////  Administration Section /////////////////////////////////////////////////////////////


//Menus
$lang['Administration'] = 'පරිපාලනය';
$lang['Locations'] = 'ස්ථාන';
$lang['Location'] = 'ස්ථානය';
$lang['Units'] = 'Units';
$lang['Unit Conversions'] = 'Unit Conversions';
$lang['Tax Types'] = 'Tax Types';
$lang['Tax Chains'] = 'Tax Chains';
$lang['People'] = 'People';
$lang['Vehicle'] = 'Vehicle';
$lang['Delivery Routes'] = 'Delivery Routes';
$lang['Sales Terminals'] = 'Sales Terminals';
$lang['User Actions'] = 'User Actions';
$lang['Google Analytics Settings'] = 'Google Analytics සැකසුම්';


//Location  Screen
$lang['Locations Details'] = 'ස්ථාන විස්තර';
$lang['Add New Location'] = 'නව ස්ථානයක් එක් කරන්න';
$lang['Location Code'] = 'ස්ථාන කේතය';
$lang['Location Name'] = 'ස්ථානයේ නම';
$lang['Company'] = 'සමාගම';
$lang['Country'] = 'රට';
$lang['City'] = 'නගරය';
$lang['State'] = 'පළාත';
$lang['Phone No'] = 'දුරකථන අංකය';
$lang['Primary Phone No'] = 'ප්‍රථමික දුරකථන අංකය';
$lang['Secondary Phone No'] = 'ද්විතියික දුරකථන අංකය';
$lang['Address'] = 'ලිපිනය';
$lang['Time Zone'] = 'වේලා කලාපය';


//Warehouse Screen
$lang['Warehouse Details'] = 'Warehouse Details';
$lang['Warehouse Code'] = 'Warehouse Code';
$lang['Warehouse Name'] = 'Warehouse Name';
$lang['Add New Warehouse'] = 'Add New Warehouse';


//People Screen
$lang['People'] = 'පාර්ශවකරුවන්';
$lang['People Details'] = 'පාර්ශවකරුවන්ගේ තොරතුරු';
$lang['People Code'] = 'පාර්ශවකරුගේ කේතය';
$lang['People Name'] = 'පාර්ශවකරුගේ නම';
$lang['Add New People'] = 'නව පාර්ශවකරුවෙකු එකතු කරන්න';
$lang['People Type'] = 'පාර්ශවකරු වර්ගය';
$lang['Details of']= 'Details of';
$lang['NIC']='ජාතික හැඳුනුම්පත් අංකය';
$lang['Birthday']='උපන්දිනය';
$lang['Is User Login']='Is User Login';
$lang['List']= 'List';
$lang['Agent Category'] = 'නියෝජිත කාණ්ඩය';
$lang['Customer Category'] = 'පාරිභෝගික කාණ්ඩය';
$lang['Sales Rep'] = 'අලෙවි නියෝජිතයා';
$lang['Current Delivery Vehicle'] = 'වත්මන් ප්‍රවාහන වාහනය';
$lang['Agent in Delivery Route'] = 'නියෝජිතයාගේ ප්‍රවාහන මාර්ගය';
$lang['Customer in Delivery Route'] = 'පාරිභෝගිකයාගේ ප්‍රවාහන මාර්ගය';
$lang['Tax Number'] = 'බදු අංකය';
$lang['Is Also a Sales Rep'] = 'විකුණුම් නියෝජිතයෙක්';
$lang['Upload A Document'] = 'ලේඛනයක් අප්ලෝඩ් කරන්න';
$lang['Document Upload'] = 'ලේඛනයක් අප්ලෝඩ් කිරීම';
$lang['Select Document To Upload'] = 'අප්ලෝඩ් කිරීමට ලේඛනය තෝරන්න';
$lang['Upload Document'] = 'අප්ලෝඩ් කරන්න';


//Vehicle Screen
$lang['Vehicle Details'] = 'Vehicle Details';
$lang['Vehicle Code'] = 'Vehicle Code';
$lang['Vehicle Number'] = 'Vehicle Number';
$lang['Owner Type'] = 'Owner Type';
$lang['Owner'] = 'Owner';
$lang['Revenue License Expire On'] = 'Revenue License Expire On';
$lang['Engine Number'] = 'Engine Number';
$lang['Chassis Number']= 'Chassis Number';
$lang['Last Serviced Date'] = 'Last Serviced Date';
$lang['Last Service Mileage'] = 'Last Service Mileage';
$lang['Add New Vehicle']= 'Add New Vehicle';
$lang['Revenue License Expiry Date'] = 'Revenue License Expiry Date';
$lang['Last Service Date'] = 'Last Service Date';
$lang['Monitor Stock Balance'] = 'Monitor Stock Balance';
$lang['Current Warehouse'] = 'Current Warehouse';


//System Configurations Screen
$lang['System Configurations'] = 'පද්ධති සැකසුම්';
$lang['Purchase Order Configurations'] = 'Purchase Order Configurations';
$lang['Good Receive Note Configurations'] = 'Good Receive Note Configurations';
$lang['Good Dispatch Note Configurations'] = 'Good Dispatch Note Configurations';
$lang['Good Issue Note Configurations'] = 'Proforma Invoice Configurations';
$lang['Good Return Note Configurations'] = 'Good Return Note Configurations';
$lang['Supplier Return Configurations'] = 'Supplier Return Configurations';
$lang['Product Disposal Configurations'] = 'Product Disposal Configurations';
$lang['Auto Increment Good Receive Note Reference Number'] = 'Auto Increment Good Receive Note Reference Number';
$lang['Auto Increment Purchase Order Reference Number'] = 'Auto Increment Purchase Order Reference Number';
$lang['Auto Increment Good Dispatch Note Reference Number'] = 'Auto Increment Good Dispatch Note Reference Number';
$lang['Auto Increment Good Issue Note Reference Number'] = 'Auto Increment Proforma Invoice Reference Number';
$lang['Auto Increment Good Return Note Reference Number'] = 'Auto Increment Good Return Note Reference Number';
$lang['Auto Increment Supplier Return Reference Number'] = 'Auto Increment Supplier Return Reference Number';
$lang['Auto Increment Product Disposal Reference Number'] = 'Auto Increment Product Disposal Reference Number';
$lang['Reference No Code'] = 'Reference No Code';
$lang['Reference No Start Number'] = 'Reference No Start Number';
$lang['Separator'] = 'Separator';
$lang['Purchase Order already in use. Therefore, the configuration option is disabled.'] = 
        'Purchase Order already in use. Therefore, the configuration option is disabled.';
$lang['Good receive note already in use. Therefore, the configuration option is disabled.'] = 
        'Good receive note already in use. Therefore, the configuration option is disabled.';
$lang['Good dispatch note already in use. Therefore, the configuration option is disabled.'] = 
        'Good dispatch note already in use. Therefore, the configuration option is disabled.';
$lang['Good issue note already in use. Therefore, the configuration option is disabled.'] = 
        'Proforma Invoice already in use. Therefore, the configuration option is disabled.';
$lang['Good return note already in use. Therefore, the configuration option is disabled.'] = 
        'Good return note already in use. Therefore, the configuration option is disabled.';
$lang['Supplier return already in use. Therefore, the configuration option is disabled.'] = 
        'Supplier return already in use. Therefore, the configuration option is disabled.';
$lang['Product disposal already in use. Therefore, the configuration option is disabled.'] = 
        'Product disposal already in use. Therefore, the configuration option is disabled.';
$lang['Raw material disposal already in use. Therefore, the configuration option is disabled.'] = 
        'Raw material disposal already in use. Therefore, the configuration option is disabled.';
$lang['Common'] = 'Common';
$lang['Select agent and customer categories for custom prices'] = 'Select agent and customer categories for custom prices';
$lang['Agent And Customer Category'] = 'Agent And Customer Category';
$lang['Enable Agent Category Wise Selling Prices'] = 'Enable Agent Category Wise Selling Prices';
$lang['Enable Customer Category Wise Selling Prices'] = 'Enable Customer Category Wise Selling Prices';
$lang['Get Location Address for Proforma Invoice of Agent'] = 'Get Location Address for Proforma Invoice of Agent';
$lang['Print Payment Detail Section on Proforma Invoice'] = 'Print Payment Detail Section on Proforma Invoice';
$lang['Print Printed Date and Time on Proforma Invoice'] = 'Print Printed Date and Time on Proforma Invoice';
$lang['Show Proforma Invoice Unit Quantity Details of Products on Gate Pass'] = 'Show Proforma Invoice Unit Quantity Details of Products on Gate Pass';
$lang['Show Good Dispatch Note Unit Quantity Details of Products on Gate Pass'] = 'Show Good Dispatch Note Unit Quantity Details of Products on Gate Pass';
$lang['Show Proforma Invoice Unit Quantity Details of Raw Materials on Gate Pass'] = 'Show Proforma Invoice Unit Quantity Details of Raw Materials on Gate Pass';
$lang['Show Good Dispatch Note Unit Quantity Details of Raw Materials on Gate Pass'] = 'Show Good Dispatch Note Unit Quantity Details of Raw Materials on Gate Pass';
$lang['Auto Increment Sales Invoice Reference Number'] = 'Auto Increment Sales Invoice Reference Number';
$lang['Sales invoice already in use. Therefore, the configuration option is disabled.'] = 'Sales invoice already in use. '
                                                                                        . 'Therefore, the configuration option is disabled.';
$lang['Sales return already in use. Therefore, the configuration option is disabled.'] = 'Sales return already in use. '
                                                                                        . 'Therefore, the configuration option is disabled.';
$lang['Select agent and customer categories to get proforma invoice as the sales invoice'] = 'Select agent and customer categories to get proforma invoice as the sales invoice';
$lang['Get Location Address for Sales Invoice of Agent'] = 'Get Location Address for Sales Invoice of Agent';
$lang['Print Payment Detail Section on Sales Invoice'] = 'Print Payment Detail Section on Sales Invoice';
$lang['Print Printed Date and Time on Sales Invoice'] = 'Print Printed Date and Time on Sales Invoice';
$lang['General'] = 'පොදු';
$lang['Enable Stock Balance Monitoring Feature For Lorries'] = 'Enable Stock Balance Monitoring Feature For Lorries';
$lang['Force To Select Vehicle For Transactions'] = 'Force To Select Vehicle For Transactions';
$lang['Get Previous Date on Sales Invoice By Default'] = 'Get Previous Date on Sales Invoice By Default';
$lang['Enable Serial Products in Stock'] = 'Enable Serial Products in Stock';
$lang['Show Only Customer List With Categories'] = 'Show Only Customer List With Categories';
$lang['Show Only Customer List Without Categories'] = 'Show Only Customer List Without Categories';
$lang['Hide Sales Rep'] = 'Hide Sales Rep';
$lang['Default Customer Category To Add A New Customer'] = 'Default Customer Category To Add A New Customer';
$lang['Allow To Add Cheque Payment Total Without Adding Cheque Details'] = 'Allow To Add Cheque Payment Total Without Adding Cheque Details';
$lang['Get Sales Invoice Balance Payment As Credit Payment'] = 'Get Sales Invoice Balance Payment As Credit Payment';
$lang['Default Sales Invoice Type'] = 'Default Sales Invoice Type';
$lang['Default Sales Return Type'] = 'Default Sales Return Type';
$lang['Hide Purchase Order No'] = 'Hide Purchase Order No';
$lang['Hide Warehouse'] = 'Hide Warehouse';
$lang['Hide Sales Invoice Type'] = 'Hide Sales Invoice Type';
$lang['Show Proforma Invoice Unit Quantity In Major Unit On Print Out'] = 'Show Proforma Invoice Unit Quantity In Major Unit On Print Out';
$lang['Auto Increment Sales Return Reference Number'] = 'Auto Increment Sales Return Reference Number';
$lang['Finish Good Return'] = 'Finish Good Return';
$lang['Raw Material Return'] = 'Raw Material Return';
$lang['Hide Sales Return Type'] = 'Hide Sales Return Type';
$lang['Show Sales Return No In Third Row'] = 'Show Sales Return No In Third Row';
$lang['Get Difference of Selling Price and Product Cost as a Percentage to Calculate Selling Price When Product Cost is Changing'] = 'Get Difference of Selling Price and Product Cost as a Percentage to Calculate Selling Price When Product Cost is Changing';
$lang['Enable Profit Margin for Products'] = 'Enable Profit Margin for Products';
$lang['Get Difference of Selling Price and Raw Material Cost as a Percentage to Calculate Selling Price When Raw Material Cost is Changing'] = 'Get Difference of Selling Price and Raw Material Cost as a Percentage to Calculate Selling Price When Raw Material Cost is Changing';
$lang['Enable Profit Margin for Raw Materials'] = 'Enable Profit Margin for Raw Materials';
$lang['Enable Product Batch Transactions With Batch Quantities'] = 'Enable Product Batch Transactions With Batch Quantities';
$lang['Enable Product Batch Transactions Without Batch Quantities'] = 'Enable Product Batch Transactions Without Batch Quantities';
$lang['Enable Raw Material Batch Transactions With Batch Quantities'] = 'Enable Raw Material Batch Transactions With Batch Quantities';
$lang['Enable Raw Material Batch Transactions Without Batch Quantities'] = 'Enable Raw Material Batch Transactions Without Batch Quantities';
$lang['Allow Free Issues'] = 'Allow Free Issues';
$lang['Allow Sample Issues'] = 'Allow Sample Issues';
$lang['Enable Preferred Supplier'] = 'Enable Preferred Supplier';
$lang['Allow Multiple Preferred Suppliers'] = 'Allow Multiple Preferred Suppliers';
$lang['Select prime entry book/s for account transactions'] = 'Select prime entry book/s for account transactions';
$lang['Accounts Prime Entry Book'] = 'Accounts Prime Entry Book';
$lang['Prime entry book already selected'] = 'Prime entry book already selected';
$lang['Select prime entry book/s for account transactions (Proforma invoice payment)'] = 'Select prime entry book/s for account transactions (Proforma invoice payment)';
$lang['Select prime entry book/s for account transactions (Proforma invoice free issues)'] = 'Select prime entry book/s for account transactions (Proforma invoice free issues)';
$lang['Select prime entry book/s for account transactions (Proforma invoice sample issues)'] = 'Select prime entry book/s for account transactions (Proforma invoice sample issues)';
$lang['Select prime entry book/s for account transactions (Proforma invoice tax payment)'] = 'Select prime entry book/s for account transactions (Proforma invoice tax payment)';
$lang['Hide Vehicle'] = 'Hide Vehicle';
$lang['Hide Delivery Route'] = 'Hide Delivery Route';
$lang['Default Warehouse'] = 'Default Warehouse';
$lang['Select sales invoice prime entry book/s for account transactions for finish good'] = 'Select sales invoice prime entry book/s for account transactions for finish good';
$lang['Sales invoice total payment for an invoice issued from a wharehouse for finish good - Sales Entry'] = 'Sales invoice total payment for an invoice issued from a wharehouse for finish good - Sales Entry';
$lang['Sales invoice total payment for an invoice issued from a wharehouse for finish good - Cost Entry'] = 'Sales invoice total payment for an invoice issued from a wharehouse for finish good - Cost Entry';
$lang['Sales invoice total payment for an invoice issued from a lorry for finish good - Sales Entry'] = 'Sales invoice total payment for an invoice issued from a lorry for finish good - Sales Entry';
$lang['Sales invoice total payment for an invoice issued from a lorry for finish good - Cost Entry'] = 'Sales invoice total payment for an invoice issued from a lorry for finish good - Cost Entry';
$lang['Sales invoice discount for finish good'] = 'Sales invoice discount for finish good';
$lang['Sales invoice cash payment for finish good'] = 'Sales invoice cash payment for finish good';
$lang['Sales invoice cheque payment for finish good'] = 'Sales invoice cheque payment for finish good';
$lang['Sales invoice return amount for finish good for a warehouse'] = 'Sales invoice return amount for finish good for a warehouse';
$lang['Sales invoice return amount for finish good for a lorry'] = 'Sales invoice return amount for finish good for a lorry';
$lang['Sales invoice tax payment for finish good'] = 'Sales invoice tax payment for finish good';
$lang['Select sales invoice prime entry book/s for account transactions for raw material'] = 'Select sales invoice prime entry book/s for account transactions for raw material';
$lang['Sales invoice total payment for an invoice issued from a wharehouse for raw material - Sales Entry'] = 'Sales invoice total payment for an invoice issued from a wharehouse for raw material - Sales Entry';
$lang['Sales invoice total payment for an invoice issued from a wharehouse for raw material - Cost Entry'] = 'Sales invoice total payment for an invoice issued from a wharehouse for raw material - Cost Entry';
$lang['Sales invoice total payment for an invoice issued from a lorry for raw material - Sales Entry'] = 'Sales invoice total payment for an invoice issued from a lorry for raw material - Sales Entry';
$lang['Sales invoice total payment for an invoice issued from a lorry for raw material - Cost Entry'] = 'Sales invoice total payment for an invoice issued from a lorry for raw material - Cost Entry';
$lang['Sales invoice discount for raw material'] = 'Sales invoice discount for raw material';
$lang['Sales invoice cash payment for raw material'] = 'Sales invoice cash payment for raw material';
$lang['Sales invoice cheque payment for raw material'] = 'Sales invoice cheque payment for raw material';
$lang['Sales invoice return amount for raw material for a warehouse'] = 'Sales invoice return amount for raw material for a warehouse';
$lang['Sales invoice return amount for raw material for a lorry'] = 'Sales invoice return amount for raw material for a lorry';
$lang['Sales invoice tax payment for raw material'] = 'Sales invoice tax payment for raw material';
$lang['Select sales return prime entry book/s for account transactions for finish good'] = 'Select sales return prime entry book/s for account transactions for finish good';
$lang['Sales return amount for finish good for a warehouse'] = 'Sales return amount for finish good for a warehouse';
$lang['Sales return amount for finish good for a lorry'] = 'Sales return amount for finish good for a lorry';
$lang['Sales return amount for raw material for a warehouse'] = 'Sales return amount for raw material for a warehouse';
$lang['Sales return amount for raw material for a lorry'] = 'Sales return amount for raw material for a lorry';
$lang['Select sales return prime entry book/s for account transactions for raw material'] = 'Select sales return prime entry book/s for account transactions for raw material';
$lang['Stock Movement Analytical Settings'] = 'Stock Movement Analytical Settings';
$lang['Evaluation Period'] = 'Evaluation Period';
$lang['Sold Quantity'] = 'Sold Quantity';
$lang['Analytical Period'] = 'විශ්ලේෂණ කාලය';
$lang['Fast Moving Products'] = 'Fast Moving Products';
$lang['Medium Fast Moving Products'] = 'Medium Fast Moving Products';
$lang['Slow Moving Products'] = 'Slow Moving Products';
$lang['Non-Moving Products'] = 'Non-Moving Products';
$lang['One Week'] = 'One Week';
$lang['Two Weeks'] = 'Two Weeks';
$lang['One Month'] = 'One Month';
$lang['Two Months'] = 'Two Months';
$lang['Three Months'] = 'Three Months';
$lang['Six Months'] = 'Six Months';
$lang['Eight Months'] = 'Eight Months';
$lang['One Year'] = 'One Year';
$lang['Current Week'] = 'Current Week';
$lang['Last Week'] = 'Last Week';
$lang['Current Month'] = 'Current Month';
$lang['Last Month'] = 'Last Month';
$lang['Last Two Months'] = 'Last Two Months';
$lang['Last Three Months'] = 'Last Three Months';
$lang['Last Six Months'] = 'Last Six Months';
$lang['Last Eight Months'] = 'Last Eight Months';
$lang['Last Ten Months'] = 'Last Ten Months';
$lang['Last Twelve Months'] = 'Last Twelve Months';
$lang['Last Sixteen Months'] = 'Last Sixteen Months';
$lang['Last Twenty Four Months'] = 'Last Twenty Four Months';
$lang['Last Thirty Six Months'] = 'Last Thirty Six Months';
$lang['Show Cursor Inside Sales Quantity Field After Selecting Item'] = 'Show Cursor Inside Sales Quantity Field After Selecting Item';
$lang['Sales invoice free issue for finish good for a warehouse'] = 'Sales invoice free issue for finish good for a warehouse';
$lang['Sales invoice free issue for finish good for a lorry'] = 'Sales invoice free issue for finish good for a lorry';
$lang['Sales invoice sample issue for finish good for a warehouse'] = 'Sales invoice sample issue for finish good for a warehouse';
$lang['Sales invoice sample issue for finish good for a lorry'] = 'Sales invoice sample issue for finish good for a lorry';
$lang['Sales invoice free issue for raw material for a warehouse'] = 'Sales invoice free issue for raw material for a warehouse';
$lang['Sales invoice free issue for raw material for a lorry'] = 'Sales invoice free issue for raw material for a lorry';
$lang['Sales invoice sample issue for raw material for a warehouse'] = 'Sales invoice sample issue for raw material for a warehouse';
$lang['Sales invoice sample issue for raw material for a lorry'] = 'Sales invoice sample issue for raw material for a lorry';
$lang['Fast Moving Raw Materials'] = 'Fast Moving Raw Materials';
$lang['Medium Fast Moving Raw Materials'] = 'Medium Fast Moving Raw Materials';
$lang['Slow Moving Raw Materials'] = 'Slow Moving Raw Materials';
$lang['Non-Moving Raw Materials'] = 'Non-Moving Raw Materials';
$lang['Auto Increment Raw Material Disposal Reference Number'] = 'Auto Increment Raw Material Disposal Reference Number';
$lang['Search sales invoice item with item name'] = 'Search sales invoice item with item name';
$lang['Search sales invoice item with item code'] = 'Search sales invoice item with item code';
$lang['Default Sales Invoice Issue Category'] = 'Default Sales Invoice Issue Category';
$lang['Default Sales Invoice Issue Agent'] = 'Default Sales Invoice Issue Agent';
$lang['Default Sales Invoice Issue Customer'] = 'Default Sales Invoice Issue Customer';
$lang['Purchasing quantities over ordered quantity needs authorizer approval'] = 'Purchasing quantities over ordered quantity needs authorizer approval';
$lang['Purchasing Authorizer'] = 'Purchasing Authorizer';
$lang['Enable Point of Sales'] = 'Enable Point of Sales';
$lang['POS Screen'] = 'POS Screen';
$lang['Stock'] = 'Stock';
$lang['e-ER Planner POS Sign In'] = 'e-ER Planner POS Sign In';
$lang['Sign In'] = 'Sign In';
$lang['Screen'] = 'Screen';
$lang['Sales List'] = 'Sales List';
$lang['Save Sales Invoice Short Bill as a File'] = 'Save Sales Invoice Short Bill as a File';
$lang['Send Sales Invoice Short Bill to Standard Output'] = 'Send Sales Invoice Short Bill to Standard Output';
$lang['Maximum Discount Rate Allowed (%)'] = 'Maximum Discount Rate Allowed (%)';
$lang['Discounts over maximum rate needs authorizer approval'] = 'Discounts over maximum rate needs authorizer approval';
$lang['Over Discount Authorizer'] = 'Over Discount Authorizer';
$lang['Additional Fields'] = 'Additional Fields';
$lang['Enable Generic Name Field'] = 'Enable Generic Name Field';
$lang['Users Can See All Warehouses Stock Balance Details'] = 'Users Can See All Warehouses Stock Balance Details';


//Data Import
$lang['Master Data Import'] = 'Master Data Import';
$lang['Transaction Data Import'] = 'Transaction Data Import';
$lang['Master and Transaction Data For Inventory Control'] = 'Master and Transaction Data For Inventory Control';
$lang['Master Data For Plarmacies And Grocery Shops'] = 'Master Data For Plarmacies And Grocery Shops';
$lang['Master data available for pharmacies and grocery shops : Product caterories and sub categories, Units and unit conversions, Pharmaceutical (1,353) and grocery (140) items'] = 'Master data available for pharmacies and grocery shops : Product caterories and sub categories, Units and unit conversions, Pharmaceutical (1,353) and grocery (140) items';
$lang['Populate'] = 'Populate';
$lang['Download Stock Master Data Import Excel Workbook'] = 'Download Stock Master Data Import Excel Workbook';
$lang['Upload Stock Master Data Import Excel Workbook'] = 'Upload Stock Master Data Import Excel Workbook';
$lang['Import Finish Good Inventory Unit Data'] = 'Import Finish Good Inventory Unit Data';
$lang['Import Finish Good Inventory Category Data'] = 'Import Finish Good Inventory Category Data';
$lang['Import Finish Good Inventory Sub Category Data'] = 'Import Finish Good Inventory Sub Category Data';
$lang['Import Finish Good Inventory Product Data'] = 'Import Finish Good Inventory Product Data';
$lang['Import Finish Good Product Preferred Supplier Data'] = 'Import Finish Good Product Preferred Supplier Data';
$lang['Download Stock Transaction Data Import Excel Workbook'] = 'Download Stock Transaction Data Import Excel Workbook';
$lang['Upload Stock Transaction Data Import Excel Workbook'] = 'Upload Stock Transaction Data Import Excel Workbook';
$lang['Import Finish Good Inventory Warehouse Stock Balances'] = 'Import Finish Good Inventory Warehouse Stock Balances';


//Admin Help Screen
$lang['Admin Help'] = 'පරිපාලන සහාය';
$lang['Download Admin Help User Guide'] = 'පරිපාලන සහායක පරිශීලක උපදෙස් පොත බාගත කරන්න';


//Delivery Route Screen
$lang['Delivery Route Details'] = 'Delivery Route Details';
$lang['Delivery Route Name'] = 'Delivery Route Name';
$lang['Add New Delivery Route'] = 'Add New Delivery Route';

//Sales Terminal Screen
$lang['Sales Terminal Details'] = 'Sales Terminal Details';
$lang['Sales Terminal Code'] = 'Sales Terminal Code';
$lang['Sales Terminal Name'] = 'Sales Terminal Name';
$lang['Add New Sales Terminal'] = 'Add New Sales Terminal';

//User Actions Screen
$lang['View History Action Details'] = 'View History Action Details';
$lang['History User Actions'] = 'History User Actions';
$lang['View Product Action Details'] = 'View Product Action Details';
$lang['View Product History Action Details'] = 'View Product History Action Details';
$lang['Added Date'] = 'Added Date';
$lang['Product User Actions'] = 'Product User Actions';
$lang['Product History User Actions'] = 'Product History User Actions';


//Google Analytics Screen
$lang['Google Analytics Code'] = 'Google Analytics කේතය';
$lang['Enable in Login'] = 'Enable in Login';
$lang['Enable in Dashboard'] = 'Enable in Dashboard';

////////////////////////////////////////  Finish Good Inventory Section /////////////////////////////////////////////////////////////////

//Menu
$lang['Finish Good Inventory'] = 'Finish Good Inventory';
$lang['Categories'] = 'Categories';
$lang['Sub Categories'] = 'Sub Categories';
$lang['Warehouses'] = 'Warehouses';
$lang['Products'] = 'Products';
$lang['Warehouse Opening Stock'] = 'Warehouse Opening Stock';
$lang['Good Receive Note'] = 'Good Receive Note';
$lang['Good Dispatch Note'] = 'අයිතමය යැවීමේ සටහන';
$lang['Good Issue Note'] = 'Proforma Invoice';
$lang['Good Return Note'] = 'Good Return Note';
$lang['Supplier Return'] = 'Supplier Return';
$lang['Product Disposal'] = 'Product Disposal';
$lang['Warehouse Stock Balance'] = 'Warehouse Stock Balance';
$lang['Lorry Stock Balance'] = 'Lorry Stock Balance';
$lang['Lorry Product Loading'] = 'Lorry Product Loading';


//Category Screen
$lang['Category Details'] = 'Category Details';
$lang['Category Name'] = 'Category Name';
$lang['Category'] = 'Category';
$lang['category'] = 'category';
$lang['Add New Category'] = 'Add New Category';

//Unit Screen
$lang['Unit Details'] = 'Unit Details';
$lang['Unit Name'] = 'Unit Name';
$lang['Unit'] = 'Unit';
$lang['unit'] = 'unit';
$lang['Unit Symbol'] = 'Unit Symbol';
$lang['Add New Unit'] = 'Add New Unit';


//Unit Conversion Screen
$lang['Unit Conversions'] = 'Unit Conversions';
$lang['Add New Unit Conversion'] = 'Add New Unit Conversion';
$lang['From Amount'] = 'From Amount';
$lang['To Amount'] = 'To Amount';
$lang['From Unit'] = 'From Unit';
$lang['To Unit'] = 'To Unit';
$lang['Equal To'] = 'Equal To';
$lang['Add Another Convrsion'] = 'Add Another Convrsion';
$lang['Unit Conversion Name'] = 'Unit Conversion Name';


//Tax Types Screen
$lang['Tax Type Details'] = 'Tax Type Details';
$lang['Tax Name'] = 'Tax Name';
$lang['Percentage (%)'] = 'Percentage (%)';
$lang['Percentage Value'] = 'Percentage Value';
$lang['Add New Tax Type'] = 'Add New Tax Type';
$lang['Calculate After Adding'] = 'Calculate After Adding';
$lang['This tax type is already used as a prerequisite tax type or in a tax chain. '
    . 'Are you sure you want to delete this tax type'] = 'This tax type is already used as a prerequisite tax type or in a tax chain. '
    . 'Are you sure you want to delete this tax type';


//Tax Chains Screen
$lang['Tax Chain Details'] = 'Tax Chain Details';
$lang['Tax Chain Name'] = 'Tax Chain Name';
$lang['Add New Tax Chain'] = 'Add New Tax Chain';


//Sub Category Module
$lang['Sub Category Details'] = 'Sub Category Details';
$lang['Sub Category'] = 'Sub Category';
$lang['Add New Sub Category'] = 'Add New Sub Category';
/* New Additions */


//Products Screen
$lang['Product Details'] = 'Product Details';
$lang['Add New Product'] = 'Add New Product';
$lang['Product Code'] = 'Product Code';
$lang['Product Name'] = 'Product Name';
$lang['Product Cost'] = 'Product Cost';
$lang['Min Selling Price'] = 'Min Selling Price';
$lang['Max Selling Price'] = 'Max Selling Price';
$lang['Agent Selling Price'] = 'Agent Selling Price';
$lang['Customer Selling Price'] = 'Customer Selling Price';
$lang['Agent Profit Margin'] = 'Agent Profit Margin';
$lang['Customer Profit Margin'] = 'Customer Profit Margin';
$lang['Product Image'] = 'Product Image';
$lang['Product'] = 'Product';
$lang['Unit Conversion'] = 'Unit Conversion';
$lang['Display Unit'] = 'Display Unit';
$lang['Product of'] = 'Product of';
$lang['Prices For Agent Categories'] = 'Prices For Agent Categories';
$lang['Prices For Customer Categories'] = 'Prices For Customer Categories';
$lang['Profit Margins For Agent Categories'] = 'Profit Margins For Agent Categories';
$lang['Profit Margins For Customer Categories'] = 'Profit Margins For Customer Categories';
$lang['Selling Price'] = 'Selling Price';
$lang['Profit Margin'] = 'Profit Margin';
$lang['Re-order Level'] = 'Re-order Level';
$lang['Re-order Quantity'] = 'Re-order Quantity';
$lang['Serial Product'] = 'Serial Product';
$lang['Re-order Level Unit'] = 'Re-order Level Unit';
$lang['Preferred Supplier'] = 'Preferred Supplier';
$lang['Generic Name'] = 'Generic Name';


//Product Warehouse Screen
$lang['Warehouse Opening Stock Details'] = 'Warehouse Opening Stock Details';
$lang['Add Warehouse Opening Stock'] = 'Add Warehouse Openening Stock';
$lang['Reference No'] = 'යොමු අංකය';
$lang['Warehouse'] = 'Warehouse';
$lang['Memo'] = 'Memo';
$lang['Date'] = 'දිනය';
$lang['Status'] = 'Status';
$lang['Search Products'] = 'Search Products';
$lang['Quantity'] = 'Quantity';
$lang['Serial Numbers'] = 'Serial Numbers';
$lang['Product Serial Numbers'] = 'Product Serial Numbers';
$lang['Product Serial Number'] = 'Product Serial Number';
$lang['Add New Serial Number'] = 'Add New Serial Number';
$lang['Serial Number'] = 'Serial Number';
$lang['Opening Stock Quantity'] = 'Opening Stock Quantity';
$lang['Stock Quantity'] = 'Stock Quantity';
$lang['Journal entry for finish good warehouse opening stock number : '] = 'Journal entry for finish good warehouse opening stock number : ';
$lang['Print Sales Invoice Quantity Tracking Sheet'] = 'Print Sales Invoice Quantity Tracking Sheet';
$lang['Invoice Quantities'] = 'Invoice Quantities';
$lang['Invoice Quantity Total'] = 'Invoice Quantity Total';
$lang['Sales Invoice Quantity Tracking Sheet'] = 'Sales Invoice Quantity Tracking Sheet';


//PO Screen
$lang['Purchase Order Product Issue Details'] = 'Purchase Order Product Issue Details';
$lang['Purchase Order Product Details'] = 'Purchase Order Product Details';


//GRN Screen
$lang['Supplier'] = 'සැපයුම්කරු';
$lang['Add New Good Receive Note'] = 'Add New Good Receive Note';
$lang['Remark'] = 'Remark';
$lang['Add Good Receive Note'] = 'Add Good Receive Note';
$lang['Edit Good Receive Note'] = 'Edit Good Receive Note';
$lang['Add Vehicle & Driver Info'] = 'Add Vehicle & Driver Info';
$lang['Driver'] = 'රියදුරා';
$lang[' Remove Vehicle And Driver'] = ' Remove Vehicle And Driver';
$lang['Last Reference Number : '] = 'Last Reference Number : ';
$lang['View Product Details'] = 'View Product Details';
$lang['Current Stock Quantity'] = 'Current Stock Quantity';
$lang['Add Additional Products'] = 'Add Additional Products';
$lang['Good Receive Note Product Details'] = 'Good Receive Note Product Details';
$lang['Edit Good Receive Note Product Details'] = 'Edit Good Receive Note Product Details';
$lang['Product Details [ From Purchase Order ]'] = 'Product Details [ From Purchase Order ]';
$lang['Product Batch Details'] = 'Product Batch Details';
$lang['Product Batch Information'] = 'Product Batch Information';
$lang['Batch Number'] = 'Batch Number';
$lang['Batch Quantity'] = 'Batch Quantity';
$lang['Add New Product Batch'] = 'Add New Product Batch';
$lang['Date of Manufacture'] = 'Date of Manufacture';
$lang['Date of Expire'] = 'Date of Expire';
$lang['Raw Material Batch Details'] = 'Raw Material Batch Details';
$lang['Raw Material Batch Information'] = 'Raw Material Batch Information';
$lang['Add New Raw Material Batch'] = 'Add New Raw Material Batch';
$lang['Batch Quantity Unit'] = 'Batch Quantity Unit';
$lang['Product Cost Unit'] = 'Product Cost Unit';
$lang['Journal entry for finish good GRN number : '] = 'Journal entry for finish good GRN number : ';
$lang['Journal entry for raw material GRN number : '] = 'Journal entry for raw material GRN number : ';
$lang['Product Over Purchasing Authorization'] = 'Product Over Purchasing Authorization';
$lang['Purchasing Authorizer'] = 'Purchasing Authorizer';
$lang['Authorizer'] = 'Authorizer';
$lang['Ok'] = 'Ok';


//GDN Screen
$lang['Add New Good Dispatch Note'] = 'Add New Good Dispatch Note';
$lang['Add Good Dispatch Note'] = 'Add Good Dispatch Note';
$lang['Edit Good Dispatch Note'] = 'Edit Good Dispatch Note';
$lang['Good Dispatch Note Product Details']='Good Dispatch Note Product Details';
$lang['Available Stock Quantity'] = 'Available Stock Quantity';
$lang['Print Good Dispatch Note'] = 'Print Good Dispatch Note';
$lang['Good Dispatch Note Product Details'] = 'Good Dispatch Note Product Details';
$lang['Edit Good Dispatch Note Product Details'] = 'Edit Good Dispatch Note Product Details';
$lang['Good Dispatch Note Unit'] = 'Good Dispatch Note Unit';
$lang['Good Dispatch Note Quantity'] = 'Good Dispatch Note Quantity';
$lang['Issue Quantity'] = 'Issue Quantity';
$lang['Select New Serial Number'] = 'Select New Serial Number';
$lang['Remove From Good Dispatch Note'] = 'Remove From Good Dispatch Note';
$lang['Search Product Batch'] = 'Search Product Batch';
$lang['Search Product Batch'] = 'Search Product Batch';
$lang['Product Batch Details Search'] = 'Product Batch Details Search';
$lang['Manufacture From Date'] = 'Manufacture From Date';
$lang['Manufacture To Date'] = 'Manufacture To Date';
$lang['Expire From Date'] = 'Expire From Date';
$lang['Expire To Date'] = 'Expire To Date';
$lang['Product Cost From'] = 'Product Cost From';
$lang['Product Cost To'] = 'Product Cost To';
$lang['Journal entry for finish good GDN number : '] = 'Journal entry for finish good GDN number : ';
$lang['Journal entry for raw material GDN number : '] = 'Journal entry for raw material GDN number : ';


//GIN Screen
$lang['Add New Good Issue Note'] = 'Add New Proforma Invoice';
$lang['Add Good Issue Note'] = 'Add Proforma Invoice';
$lang['Edit Good Issue Note'] = 'Edit Proforma Invoice';
$lang['Good Issue Note No'] = 'Proforma Invoice No';
$lang['Issued To'] = 'Issued To';
$lang['Proforma Good Issue Note'] = 'Proforma Invoice';
$lang['Tax Good Issue Note'] = 'Tax Proforma Invoice';
$lang['Tax Type'] = 'Tax Type';
$lang['Agent'] = 'නියෝජිතයා';
$lang['Customer'] = 'පාරිභෝගිකයා';
$lang['Good Issue Note Product Details']='Proforma Invoice Product Details';
$lang['Rate'] = 'Rate';
$lang['Amount'] = 'ප්‍රමාණය';
$lang['Total Amount'] = 'Total Amount';
$lang['Payment Details'] = 'Payment Details';
$lang['Own Cheque'] = 'Own Cheque';
$lang['Third Party Cheque'] = 'Third Party Cheque';
$lang['Total'] = 'Total';
$lang['Good Issue Note Grand Total'] = 'Proforma Invoice Grand Total';
$lang['Printed Date and Time'] = 'Printed Date and Time';
$lang['Cash'] = 'මුදල්';
$lang['Printed By'] = 'Printed By';
$lang['Prepared By'] = 'Prepared By';
$lang['Checked By'] = 'Checked By';
$lang['Authorised By'] = 'Authorised By';
$lang['Received By'] = 'Received By';
$lang['Total Payable'] = 'Total Payable';
$lang['Current Rate'] = 'Current Rate';
$lang['Custom Rate'] = 'Custom Rate';
$lang['Print Good Issue Note'] = 'Print Proforma Invoice';
$lang['Print Gate Pass'] = 'Print Gate Pass';
$lang['Gate Pass'] = 'Gate Pass';
$lang['Security Officer'] = 'Security Officer';
$lang['Store Keeper'] = 'Store Keeper';
$lang['Delivery Location'] = 'Delivery Location';
$lang['Release Date and Time'] = 'Release Date and Time';
$lang['Exit Date and Time'] = 'Exit Date and Time';
$lang['Good Issue Note Product Details'] = 'Proforma Invoice Product Details';
$lang['Edit Good Issue Note Product Details'] = 'Edit Proforma Invoice Product Details';
$lang['Good Issue Note Unit'] = 'Proforma Invoice Unit';
$lang['Good Issue Note Quantity'] = 'Proforma Invoice Quantity';
$lang['Purchase Order No'] = 'Purchase Order No';
$lang['Free Issue'] = 'Free Issue';
$lang['Sample Issue'] = 'Sample Issue';
$lang['Free Issue Good Issue Note'] = 'Free Issue';
$lang['Sample Issue Good Issue Note'] = 'Sample Issue';
$lang['Total Value'] = 'Total Value';
$lang['Free Issue / Sample Issue'] = 'Free Issue / Sample Issue';
$lang['is changed from'] = 'is changed from';
$lang['person'] = 'person';
$lang['to'] = 'to';
$lang['Journal entry for finish good GIN number : '] = 'Journal entry for finish good GIN number : ';
$lang['Journal entry for raw material GIN number : '] = 'Journal entry for raw material GIN number : ';
$lang[' for proforma invoice tax payment'] = ' for proforma invoice tax payment';
$lang[' for proforma invoice payment'] = ' for proforma invoice payment';
$lang[' for proforma invoice sample issues'] = ' for proforma invoice sample issues';
$lang[' for proforma invoice free issues'] = ' for proforma invoice free issues';
$lang[' for proforma invoice tax payment'] = ' for proforma invoice tax payment';


//GRTN Screen
$lang['Add New Good Return Note'] = 'Add New Good Return Note';
$lang['Add Good Return Note'] = 'Add Good Return Note';
$lang['Edit Good Return Note'] = 'Edit Good Return Note';
$lang['Returned By'] = 'Returned By';
$lang['Good Return Note Product Details']='Good Return Note Product Details';
$lang['Good Return Note Product Details'] = 'Good Return Note Product Details';
$lang['Edit Good Return Note Product Details'] = 'Edit Good Return Note Product Details';
$lang['Journal entry for finish good GRTN number : '] = 'Journal entry for finish good GRTN number : ';
$lang['Journal entry for raw material GRTN number : '] = 'Journal entry for raw material GRTN number : ';

//Supplier Return  Screen
$lang['Add New Supplier Return'] = 'Add New Supplier Return';
$lang['Add Supplier Return'] = 'Add Supplier Return';
$lang['Edit Supplier Return'] = 'Edit Supplier Return';
$lang['Returned By'] = 'Returned By';
$lang['Supplier Return Product Details']='Supplier Return Product Details';
$lang['Supplier Return Product Details'] = 'Supplier Return Product Details';
$lang['Edit Supplier Return Product Details'] = 'Edit Supplier Return Product Details';
$lang['Journal entry for finish good supplier return number : '] = 'Journal entry for finish good supplier return number : ';
$lang['Journal entry for raw material supplier return number : '] = 'Journal entry for raw material supplier return number : ';

//Product Disposal  Screen
$lang['Add New Product Disposal'] = 'Add New Product Disposal';
$lang['Add Product Disposal'] = 'Add Product Disposal';
$lang['Edit Product Disposal'] = 'Edit Product Disposal';
$lang['Product Disposal Product Details']='Product Disposal Product Details';
$lang['Product Disposal Product Details'] = 'Product Disposal Product Details';
$lang['Edit Product Disposal Product Details'] = 'Edit Product Disposal Product Details';
$lang['Journal entry for finish good product disposal number : '] = 'Journal entry for finish good product disposal number : ';
$lang['Journal entry for raw material product disposal number : '] = 'Journal entry for raw material product disposal number : ';


//Warehouse Stock Update
$lang['Warehouse Stock Update Details'] = 'Warehouse Stock Update Details';
$lang['Add Warehouse Stock Update'] = 'Add Warehouse Stock Update';
$lang['Warehouse Stock Update'] = 'Warehouse Stock Update';
$lang['Current Quantity'] = 'Current Quantity';
$lang['Physical Quantity'] = 'Physical Quantity';
$lang['System Quantity'] = 'System Quantity';
$lang['Stock Varience'] = 'Stock Varience';


//Warehouse Stock Balance Screen
$lang['Warehouse Stock Balance Details'] = 'Warehouse Stock Balance Details';
$lang['Search Stock'] = 'Search Stock';
$lang['Product of Company'] = 'Product of Company';
$lang['Product Batch Quantities'] = 'Product Batch Quantities';


//Lorry Stock Balance Screen
$lang['Lorry Stock Balance Details'] = 'Lorry Stock Balance Details';
$lang['View Loading Details'] = 'View Loading Details';
$lang['Product Loading Details'] = 'Product Loading Details';
$lang['Product Loading Details Search'] = 'Product Loading Details Search';
$lang['Loading Total'] = 'Loading Total';
$lang['Unloading Total'] = 'Unloading Total';
$lang['Sales Total'] = 'Sales Total';
$lang['Warehouse Return Total'] = 'Warehouse Return Total';
$lang['Sales Return Total'] = 'Sales Return Total';
$lang['Free Issue Total'] = 'Free Issue Total';
$lang['Sample Issue Total'] = 'Sample Issue Total';
$lang['Current Stock'] = 'Current Stock';
$lang['Physical Stock Count'] = 'Physical Stock Count';
$lang['Stock Variation'] = 'Stock Variation';
$lang['Show Loading Break Down'] = 'Show Loading Break Down';
$lang['Show Unloading Break Down'] = 'Show Unloading Break Down';
$lang['Show Sales Break Down'] = 'Show Sales Break Down';
$lang['Show Warehouse Return Break Down'] = 'Show Warehouse Return Break Down';
$lang['Show Sales Return Break Down'] = 'Show Sales Return Break Down';
$lang['Show Free Issue Break Down'] = 'Show Free Issue Break Down';
$lang['Show Sample Issue Break Down'] = 'Show Sample Issue Break Down';
$lang['Loading Break Down'] = 'Loading Break Down';
$lang['Unloading Break Down'] = 'Unloading Break Down';
$lang['Sales Break Down'] = 'Sales Break Down';
$lang['Warehouse Return Break Down'] = 'Warehouse Return Break Down';
$lang['Sales Return Break Down'] = 'Sales Return Break Down';
$lang['Free Issue Break Down'] = 'Free Issue Break Down';
$lang['Sample Issue Break Down'] = 'Sample Issue Break Down';
$lang['Test 1'] = 'Test 1';
$lang['Test 2'] = 'Test 2';
$lang['Test 3'] = 'Test 3';

//Finish Good Inventory Help Screen
$lang['Finish Good Inventory Help'] = 'Finish Good Inventory Help';
$lang['Download Finish Good Inventory Help User Guide'] = 'Download Finish Good Inventory Help User Guide';


//Raw Material Inventory Help Screen
$lang['Raw Material Inventory Help'] = 'Raw Material Inventory Help';
$lang['Download Raw Material Inventory Help User Guide'] = 'Download Raw Material Inventory Help User Guide';


//Sales Help Screen
$lang['Sales Help'] = 'Sales Help';
$lang['Download Sales Help User Guide'] = 'Download Sales Help User Guide';

////////////////////////////////////////  Reports Section /////////////////////////////////////////////////////////////

//Menus
$lang['Reports'] = 'වාර්තා';
$lang['Finish Good Inventory Reports'] = 'Finish Good Inventory Reports';
$lang['Raw Material Inventory Reports'] = 'Raw Material Inventory Reports';
$lang['Finish Good Inventory'] = 'Finish Good Inventory';
$lang['Raw Material Inventory'] = 'Raw Material Inventory';
$lang['Sales Reports'] = 'Sales Reports';
$lang['Sales'] = 'Sales';


//Inventory Reports screen
$lang['Search Inventory'] = 'Search Inventory';
$lang['Inventory Transactions'] = 'Inventory Transactions';
$lang['From Date'] = 'දින සිට';
$lang['To Date'] = 'දින දක්වා';
$lang['Reference Number'] = 'Reference Number';
$lang['Transaction Type'] = 'Transaction Type';
$lang['Inventory Transactions Details'] = 'Inventory Transactions Details';
$lang['Inventory Transactions Summary'] = 'Inventory Transactions Summary';
$lang['As Of '] = ' As Of ';
$lang[' As Of '] = ' As Of ';
$lang[' For '] = ' For ';
$lang['For '] = 'For ';
$lang['And For '] = 'And For ';
$lang[' And For '] = ' And For ';
$lang[' And Product Of '] = ' And Product Of ';
$lang['And Product Of '] = 'And Product Of ';
$lang['Product Of '] = 'Product Of ';
$lang[' Of '] = ' Of ';
$lang['Of '] = 'Of ';
$lang[' To '] = ' To ';
$lang[' For Date Range From '] = ' For Date Range From ';
$lang['For Date Range From '] = 'For Date Range From ';
$lang[' And For Date Range From '] = ' And For Date Range From ';
$lang['For Manufacture Date Range From '] = 'For Manufacture Date Range From ';
$lang[' And For Manufacture Date Range From '] = ' And For Manufacture Date Range From ';
$lang['For Expiry Date Range From '] = 'For Expiry Date Range From ';
$lang[' And For Expiry Date Range From '] = ' And For Expiry Date Range From ';
$lang['Show Product Code'] = 'Show Product Code';
$lang['Show Product Cost'] = 'Show Product Cost';
$lang['Show Agent Selling Price'] = 'Show Agent Selling Price';
$lang['Show Customer Selling Price'] = 'Show Customer Selling Price';
$lang['Show Min Selling Price'] = 'Show Min Selling Price';
$lang['Show Max Selling Price'] = 'Show Max Selling Price';
$lang['Show Stock Value Based On Product Cost'] = 'Show Stock Value Based On Product Cost';
$lang['Show Stock Value Based On Agent Selling Price'] = 'Show Stock Value Based On Agent Selling Price';
$lang['Show Stock Value Based On Customer Selling Price'] = 'Show Stock Value Based On Customer Selling Price';
$lang['Stock Value Based On Product Cost'] = 'Stock Value Based On Product Cost';
$lang['Stock Value Based On Agent Selling Price'] = 'Stock Value Based On Agent Selling Price';
$lang['Stock Value Based On Customer Selling Price'] = 'Stock Value Based On Customer Selling Price';
$lang['Inventory Data Comparison'] = 'Inventory Data Comparison';
$lang['Transactions Comparison'] = 'Transactions Comparison';
$lang['Inventory Transactions Comparison'] = 'Inventory Transactions Comparison';
$lang['Year'] = 'අවුරුද්ද';
$lang['Month'] = 'මාසය';
$lang['Week'] = 'සතිය';
$lang['Generate As'] = 'ලෙස උත්පාදනය කරන්න';
$lang['Monthly'] = 'monthly';
$lang['Weekly'] = 'Weekly';
$lang['Daily'] = 'Daily';
$lang['Transaction Type'] = 'Transaction Type';
$lang['Field'] = 'Field';
$lang['Chart Type'] = 'Chart Type';
$lang['Bar Chart'] = 'Bar Chart';
$lang['Bar And Line Chart'] = 'Bar And Line Chart';
$lang['3D Bar Chart'] = '3D Bar Chart';
$lang['Stacked Bar Chart'] = 'Stacked Bar Chart';
$lang['3D Stacked Bar Chart'] = '3D Stacked Bar Chart';
$lang['Grouped Bar Chart'] = 'Grouped Bar Chart';
$lang['3D Grouped Bar Chart'] = '3D Grouped Bar Chart';
$lang['Histogram Chart'] = 'Histogram Chart';
$lang['Line Chart'] = 'Line Chart';
$lang['Pie Chart'] = 'Pie Chart';
$lang['3D Pie Chart'] = '3D Pie Chart';
$lang['Donut Chart'] = 'Donut Chart';
$lang['Polar Area Chart'] = 'Polar Area Chart';
$lang['Exploded Pie Chart'] = 'Exploded Pie Chart';
$lang[' Transaction Comparison Summary For '] = ' Transaction Comparison Summary For ';
$lang[' Transaction Comparison Detail For '] = ' Transaction Comparison Detail For ';
$lang['Chart View'] = 'Chart View';
$lang['Summary View'] = 'Summary View';
$lang['Detail View'] = 'Detail View';
$lang['Select Warehouse'] = 'Select Warehouse';
$lang['Select Product'] = 'Select Product';
$lang['Select Raw Material'] = 'Select Raw Material';
$lang['Show Raw Material Code'] = 'Show Raw Material Code';
$lang['Show Raw Material Cost'] = 'Show Raw Material Cost';
$lang['Show Stock Value Based On Raw Material Cost'] = 'Show Stock Value Based On Raw Material Cost';
$lang['Stock Value Based On Raw Material Cost'] = 'Stock Value Based On Raw Material Cost';
$lang['Warehouse Stock Balance'] = 'Warehouse Stock Balance';
$lang['Lorry'] = 'Lorry';
$lang['Re-order Product List'] = 'Re-order Product List';
$lang['Re-order Raw Material List'] = 'Re-order Raw Material List';
$lang['Product Re-order Details'] = 'Product Re-order Details';
$lang['Raw Material Re-order Details'] = 'Raw Material Re-order Details';
$lang['Current Stock Quantity'] = 'Current Stock Quantity';
$lang['Product SN Discrepancy'] = 'Product SN Discrepancy';
$lang['Product SN Discrepancy Details'] = 'Product SN Discrepancy Details';
$lang['Quantity In Minor Unit'] = 'Quantity In Minor Unit';
$lang['Serial Number Count'] = 'Serial Number Count';
$lang['Product Serial Number Discrepancy Details'] = 'Product Serial Number Discrepancy Details';
$lang['Product Bin Cards'] = 'Product Bin Cards';
$lang['Raw Material Bin Cards'] = 'Raw Material Bin Cards';
$lang['Bin Card Details'] = 'Bin Card Details';
$lang['Before Stock'] = 'Before Stock';
$lang['After Stock'] = 'After Stock';
$lang['More Detail'] = 'More Detail';
$lang['Physical Stock Update'] = 'Physical Stock Update';
$lang['Opening Stock'] = 'Opening Stock';
$lang['Product Category'] = 'Product Category';
$lang['Product Sub Category'] = 'Product Sub Category';
$lang['Raw Material Category'] = 'Raw Material Category';
$lang['Raw Material Sub Category'] = 'Raw Material Sub Category';
$lang['Summary Report'] = 'Summary Report';
$lang['Lorry Product Loading Details'] = 'Lorry Product Loading Details';
$lang['Issued To / Returned By'] = 'Issued To / Returned By';
$lang['Opening Balance'] = 'Opening Balance';
$lang['Closing Balance'] = 'Closing Balance';
$lang['Signature'] = 'Signature';
$lang['Free & Sample Issues'] = 'Free & Sample Issues';
$lang['Issue Type'] = 'Issue Type';
$lang['Free Issues'] = 'Free Issues';
$lang['Sample Issues'] = 'Sample Issues';
$lang['Free And Sample Issues Details'] = 'Free And Sample Issues Details';
$lang['Free And Sample Issues Summary'] = 'Free And Sample Issues Summary';
$lang['Warehouse Stock Balance Summary Details'] = 'Warehouse Stock Balance Summary Details';
$lang['Total Stock Value Based on Product Cost'] = 'Total Stock Value Based on Product Cost';
$lang['Total Stock Value Based on Agent Selling Price'] = 'Total Stock Value Based on Agent Selling Price';
$lang['Total Stock Value Based on Customer Selling Price'] = 'Total Stock Value Based on Customer Selling Price';
$lang['Projected Gross Profit By Selling to Agents'] = 'Projected Gross Profit By Selling to Agents';
$lang['Projected Gross Profit By Selling to Customers'] = 'Projected Gross Profit By Selling to Customers';
$lang['Gross Profit Details'] = 'Gross Profit Details';
$lang['Product Expiry Reach'] = 'Product Expiry Reach';
$lang['Manufacture From Date'] = 'Manufacture From Date';
$lang['Manufacture To Date'] = 'Manufacture To Date';
$lang['Expiry From Date'] = 'Expiry From Date';
$lang['Expiry To Date'] = 'Expiry To Date';
$lang['Manufacture Date'] = 'Manufacture Date';
$lang['Expiry Date'] = 'Expiry Date';
$lang['Product Expiry Reach Details'] = 'Product Expiry Reach Details';
$lang['Print Supplier Order Sheet'] = 'Print Supplier Order Sheet';
$lang['Item Order List'] = 'Item Order List';
$lang['Inactivate Product Batch'] = 'Inactivate Product Batch';
$lang['Returned To Supplier'] = 'Returned To Supplier';
$lang['Order Select'] = 'Order Select';
$lang['PO Details'] = 'PO Details';
$lang['Active Purchase Order Details'] = 'Active Purchase Order Details';
$lang['Custom Re-order Quantity'] = 'Custom Re-order Quantity';
$lang['Order and Print'] = 'Order and Print';
$lang['PO Reference No'] = 'PO Reference No';
$lang['Product Purchase Order Details'] = 'Product Purchase Order Details';


//Reports Help Screen
$lang['Reports Help'] = 'වාර්තා සහාය';
$lang['Download Reports Help User Guide'] = 'වාර්තා සහායක පරිශීලක උපදෙස් පොත බාගත කරන්න';


//Sales Reports Screen
$lang['Sales Invoice Summary'] = 'Sales Invoice Summary';
$lang['Sales Payment Summary'] = 'Sales Payment Summary';
$lang['Sales Payment Cash Detail']= 'Sales Payment Cash Detail';
$lang['Sales Payment Cheque Detail']= 'Sales Payment Cheque Detail';
$lang['Sales Invoice Comparison'] = 'Sales Invoice Comparison';
$lang['Sales Invoice Transactions Comparison'] = 'Sales Invoice Transactions Comparison';
$lang['Sales Invoice Summary Details'] = 'Sales Invoice Summary Details';
$lang['Sales Invoice Details'] = 'Sales Invoice Details';
$lang['Grand Total'] = 'Grand Total';
$lang['Invoice Total Amount'] = 'Invoice Total Amount';
$lang['Search Sales'] = 'Search Sales';
$lang[' Payments '] = ' Payments ';
$lang['Tax Total'] = 'Tax Total';
$lang['Sales Invoice Payment Summary Details'] = 'Sales Invoice Payment Summary Details';
$lang['Sales Invoice Payment Cash Details'] = 'Sales Invoice Payment Cash Details';
$lang['Sales Invoice Payment Cheque Details'] = 'Sales Invoice Payment Cheque Details';
$lang['Cheque Date'] = 'Cheque Date';
$lang[' Cheque Payments '] = ' Cheque Payments ';
$lang['Sales Invoice Total'] = 'Sales Invoice Total';
$lang['Hide Driver'] = 'Hide Driver';
$lang['Show Sales Invoice No In Third Row'] = 'Show Sales Invoice No In Third Row';
$lang['Sales Summary Details'] = 'Sales Summary Details';
$lang['Total Discount'] = 'Total Discount';
$lang['Total Cash Payment'] = 'Total Cash Payment';
$lang['Total Cheque Payment'] = 'Total Cheque Payment';
$lang['Total Credit Payment'] = 'Total Credit Payment';
$lang['Total Balance Payment'] = 'Total Balance Payment';
$lang['Sales Invoice Cash Payment Total'] = 'Sales Invoice Cash Payment Total';
$lang['Sales Invoice Cheque Payment Total'] = 'Sales Invoice Cheque Payment Total';
$lang['Total Return Payment'] = 'Total Return Payment';
$lang['Return Payment'] = 'Return Payment';
$lang['Show Product Price Details'] = 'Show Product Price Details';
$lang['Show Raw Material Price Details'] = 'Show Raw Material Price Details';
$lang['Sales Invoice Item Amount'] = 'Sales Invoice Item Amount';
$lang['Show Sales Invoice Date'] = 'Show Sales Invoice Date';
$lang['Show Sales Rep'] = 'Show Sales Rep';
$lang['Show Issued To'] = 'Show Issued To';
$lang['Show Invoice Total Amount'] = 'Show Invoice Total Amount';
$lang['Show Discount'] = 'Show Discount';
$lang['Show Tax Total'] = 'Show Tax Total';
$lang['Show Cash Payment'] = 'Show Cash Payment';
$lang['Show Cheque Payment'] = 'Show Cheque Payment';
$lang['Show Credit Payment'] = 'Show Credit Payment';
$lang['Show Return Payment'] = 'Show Return Payment';
$lang['Show Balance Payment'] = 'Show Balance Payment';
$lang['Item Movement Details'] = 'Item Movement Details';
$lang[' Item Movement Details '] = ' Item Movement Details ';
$lang['Item Movement Details'] = 'Item Movement Details';
$lang['Current Movement Status'] = 'Current Movement Status';
$lang['Movement Statistics'] = 'Movement Statistics';
$lang['Analytical Date'] = 'Analytical Date';
$lang['Processing Period'] = 'Processing Period';
$lang['Show Only Latest Item Movement Results'] = 'Show Only Latest Item Movement Results';
$lang['[Current Week] and [Last Week] options are not valid for [Two Week] evaluation period.'] = '[Current Week] and [Last Week] options are not valid for [Two Week] evaluation period.';
$lang['[Current Week] and [Last Week] options are not valid for [One Month] evaluation period.'] = '[Current Week] and [Last Week] options are not valid for [One Month] evaluation period.';
$lang['[Current Week], [Last Week], [Current Month], [Last Month] and [Last Three Months] options are not valid for [Two Months] evaluation period.'] = '[Current Week], [Last Week], [Current Month], [Last Month] and [Last Three Months] options are not valid for [Two Months] evaluation period.';
$lang['[Last Three Months], [Last Six Months], [Last Twelve Months], [Last Twenty Four Months] and [Last Thirty Six Months] are the valid options for [Three Months] evaluation period.'] = '[Last Three Months], [Last Six Months], [Last Twelve Months], [Last Twenty Four Months] and [Last Thirty Six Months] are the valid options for [Three Months] evaluation period.';
$lang['[Last Six Months], [Last Twelve Months], [Last Twenty Four Months] and [Last Thirty Six Months] are the valid options for [Six Months] evaluation period.'] = '[Last Six Months], [Last Twelve Months], [Last Twenty Four Months] and [Last Thirty Six Months] are the valid options for [Six Months] evaluation period.';
$lang['[Last Eight Months], [Last Sixteen Months] and [Last Twenty Four Months] are the valid options for [Eight Months] evaluation period.'] = '[Last Eight Months], [Last Sixteen Months] and [Last Twenty Four Months] are the valid options for [Eight Months] evaluation period.';
$lang['[Last Twelve Months], [Last Twenty Four Months] and [Last Thirty Six Months] are the valid options for [One Year] evaluation period.'] = '[Last Twelve Months], [Last Twenty Four Months] and [Last Thirty Six Months] are the valid options for [One Year] evaluation period.';
$lang['Movement Type'] = 'Movement Type';
$lang['Fast Moving Item'] = 'Fast Moving Item';
$lang['Medium Fast Moving Item'] = 'Medium Fast Moving Item';
$lang['Slow Moving Item'] = 'Slow Moving Item';
$lang['Non Moving Item'] = 'Non Moving Item';
$lang['Product Movement Statistics'] = 'Product Movement Statistics';
$lang['Item Movement Statistics'] = 'Item Movement Statistics';
$lang['View Product Batch Details'] = 'View Product Batch Details';
$lang['Sales Data Comparison'] = 'Sales Data Comparison';
$lang['Finish Good '] = 'Finish Good ';
$lang['Raw Material '] = 'Raw Material ';


////////////////////////////////////////  Raw Material Inventory Section /////////////////////////////////////////////////////////////////

//Menus
$lang['Raw Material Inventory'] = 'Raw Material Inventory';
$lang['Raw Materials'] = 'Raw Materials';
$lang['Raw Material Disposal'] = 'Raw Material Disposal';


//Raw Materials Screen
$lang['Raw Material Details'] = 'Raw Material Details';
$lang['Add New Raw Material'] = 'Add New Raw Material';
$lang['Raw Material Code'] = 'Raw Material Code';
$lang['Raw Material'] = 'Raw Material';
$lang['Raw Material Name'] = 'Raw Material Name';
$lang['Raw Material Cost'] = 'Raw Material Cost';
$lang['Min Selling Price'] = 'Min Selling Price';
$lang['Max Selling Price'] = 'Max Selling Price';
$lang['Agent Selling Price'] = 'Agent Selling Price';
$lang['Customer Selling Price'] = 'Customer Selling Price';
$lang['Raw Material Image'] = 'Raw Material Image';
$lang['Raw Materials'] = 'Raw Materials';
$lang['Unit Conversion'] = 'Unit Conversion';
$lang['Display Unit'] = 'Display Unit';


//GRN Screen
$lang['Add Additional Raw Materials'] = 'Add Additional Raw Materials';
$lang['View Raw Material Details'] = 'View Raw Material Details';
$lang['GRN Quantity'] = 'GRN Quantity';
$lang['Edit Good Receive Note Raw Material Details'] = 'Edit Good Receive Note Raw Material Details';
$lang['Good Receive Note Raw Material Details'] = 'Good Receive Note Raw Material Details';
$lang['Raw Material Details [ From Purchase Order ]'] = 'Raw Material Details [ From Purchase Order ]';
$lang['Raw Material Cost Unit'] = 'Raw Material Cost Unit';


//PO Screen
$lang['Purchase Order'] = 'Purchase Order';
$lang['Add New Purchase Order'] = 'Add New Purchase Order';
$lang['Add Purchase Order'] = 'Add Purchase Order';
$lang['Edit Purchase Order'] = 'Edit Purchase Order';
$lang['Purchase Order Raw Material Details']='Purchase Order Raw Material Details';
$lang['Issue Raw Materials'] = 'Issue Raw Materials';
$lang['Print Purchase Order'] = 'Print Purchase Order';
$lang['Purchase Order Items'] = 'Purchase Order Items';
$lang['Purchase Order Item Issues'] = 'Purchase Order Item Issues';
$lang['Raw Material PO Details'] = 'Raw Material PO Details';
$lang['Issue Raw Materials'] = 'Issue Raw Materials';
$lang['Purchase Order Raw Material Issue Details'] = 'Purchase Order Raw Material Issue Details';
$lang['Add Raw Materials'] = 'Add Raw Materials';
$lang['Purchase Order Raw Material Details'] = 'Purchase Order Raw Material Details';
$lang['Edit Purchase Order Raw Material Data'] = 'Edit Purchase Order Raw Material Data';
$lang['Edit Purchase Order Raw Material Issue Data'] = 'Edit Purchase Order Raw Material Issue Data';
$lang['You have changed the warehouse. '
                        . 'Raw Material quantities in this PO will transfer to the new warehouse selected. '
                        . 'Are you sure you want to continue?'] = 'You have changed the warehouse. '
                        . 'Raw Material quantities in this PO will transfer to the new warehouse selected. '
                        . 'Are you sure you want to continue?';
$lang['Add Products'] = 'Add Products';
$lang['Issue Products'] = 'Issue Products';


//GDN Screen
$lang['Good Dispatch Note Raw Material Details'] = 'Good Dispatch Note Raw Material Details';
$lang['Edit Good Dispatch Note Raw Material Details'] = 'Edit Good Dispatch Note Raw Material Details';
$lang['Search Raw Material Batch'] = 'Search Raw Material Batch';
$lang['Search Raw Material Batch'] = 'Search Raw Material Batch';
$lang['Raw Material Batch Details Search'] = 'Raw Material Batch Details Search';
$lang['Raw Material Cost From'] = 'Raw Material Cost From';
$lang['Raw Material Cost To'] = 'Raw Material Cost To';


//GIN Screen
$lang['Good Issue Note Raw Material Details'] = 'Proforma Invoice Raw Material Details';
$lang['Edit Good Issue Note Raw Material Details'] = 'Edit Proforma Invoice Raw Material Details';


//GRTN Screen
$lang['Good Return Note Raw Material Details'] = 'Good Return Note Raw Material Details';
$lang['Edit Good Return Note Raw Material Details'] = 'Edit Good Return Note Raw Material Details';


//Supplier Return  Screen
$lang['Supplier Return Raw Material Details'] = 'Supplier Return Raw Material Details';


//Raw Material Disposal  Screen
$lang['Add New Raw Material Disposal'] = 'Add New Raw Material Disposal';
$lang['Add Raw Material Disposal'] = 'Add Raw Material Disposal';
$lang['Edit Raw Material Disposal'] = 'Edit Raw Material Disposal';
$lang['Raw Material Disposal Raw Material Details']='Raw Material Disposal Raw Material Details';
$lang['Raw Material Disposal Raw Material Details'] = 'Raw Material Disposal Raw Material Details';
$lang['Edit Raw Material Disposal Raw Material Details'] = 'Edit Raw Material Disposal Raw Material Details';
$lang['Journal entry for raw material disposal number : '] = 'Journal entry for raw material disposal number : ';
$lang['Journal entry for raw material disposal number : '] = 'Journal entry for raw material disposal number : ';


//Warehouse Stock Balance Screen
$lang['Raw Material Batch Quantities'] = 'Raw Material Batch Quantities';


//About System Screen
$lang['About System']='පද්ධතිය ගැන විස්තර';
$lang['About e-ER Planner']='About e-ER Planner';
$lang['e-ER Planner Overview']='e-ER Planner Overview';
$lang['Tell about e-ER Planner to a friend']='Tell about e-ER Planner to a friend';
$lang["E-mail address of your friend"] = "E-mail address of your friend";
$lang['System Modules : ']='System Modules : ';
$lang['Best online ERP solution from Artifectx Solutions.'] = 'Best online ERP solution from Artifectx Solutions.';
$lang['People (Suppliers/Agents/Customers/Drivers/Employees) Management'] = 'People (Suppliers/Agents/Customers/Drivers/Employees) Management';
$lang['Vehicle Management'] = 'Vehicle Management';
$lang['Inventory Module (Finish Good & Raw Material Inventory)'] = 'Inventory Module (Finish Good & Raw Material Inventory)';
$lang['Sales Module'] = 'Sales Module';
$lang['Expense and Profit Information'] = 'Expense and Profit Information';
$lang['Tracking Payaments'] = 'Tracking Payaments';
$lang['User Role Permissions'] = 'User Role Permissions';
$lang['User Management'] = 'User Management';
$lang['Support & Updates'] = 'Support & Updates';
$lang['World Class Support'] = 'World Class Support';
$lang['Live Chat, Phone, Email'] = 'Live Chat, Phone, Email';
$lang['For more info contact : '] = 'For more info contact : ';
$lang['Current Version : '] = 'Current Version : ';
$lang['Comprehensive User Guides'] = 'Comprehensive User Guides';
$lang['Message'] = 'Message';
$lang['Latest Updates'] = 'Latest Updates';
$lang['Allows to manage company locations, people, company basic information and company '
    . 'structure. The information adding under this module is common to the other modules of e-ER Planner. Module is '
    . 'completely implemented and available in version '] = 'Allows to manage company locations, people, company basic information and company '
                                                          . 'structure. The information adding under this module is common to the other modules of e-ER Planner. Module is '
                                                          . 'completely implemented and available in version ';
$lang['This module consists of five sections called "Administration", "Finish Good Inventory", "Raw Material Inventory", '
    . '"Sales" and "Reports". The "Administration" section allows to manage warehouses, unit and unit conversions, tax details, '
    . 'vehicles, delivery routes and system configurations. System configurations allows to configure the system for '
    . 'different behaviors. "Finish Good Inventory" and "Raw Material Inventory" allows to manage finish good and raw material '
    . 'stock respectively. System allows to manage warehouse and lorry stock with different transactions. "Sales" section allows '
    . 'to manage sales invoices and sales returns. "Reports" section allows to generate different types of reports for '
    . 'stock balances, transactions, sales and sales returns. Module is completely implemented and available in version '] = 'This module consists of five sections called "Administration", "Finish Good Inventory", "Raw Material Inventory", '
                                                                                   . '"Sales" and "Reports". The "Administration" section allows to manage warehouses, unit and unit conversions, tax details, '
                                                                                   . 'vehicles, delivery routes and system configurations. System configurations allows to configure the system for '
                                                                                   . 'different behaviors. "Finish Good Inventory" and "Raw Material Inventory" allows to manage finish good and raw material '
                                                                                   . 'stock respectively. System allows to manage warehouse and lorry stock with different transactions. "Sales" section allows '
                                                                                   . 'to manage sales invoices and sales returns. "Reports" section allows to generate different types of reports for '
                                                                                   . 'stock balances, transactions, sales and sales returns. Module is completely implemented and available in version ';
$lang['Allows to manage the process of producing finish goods in a production line. Careful monitoring of raw materials issued to production line '
    . 'and exact usage and calculate final product cost considering other costing parameters is handled in this module. Module provides variation '
    . 'reports to evaluate the efficiency of production line thereby adjusting parameters to fine tune the efficiency and minimize loses. '
    . 'Module implementation will be completed in version 5.0'] = 'Allows to manage the process of producing finish goods in a production line. Careful monitoring of raw materials issued to production line '
                                                      . 'and exact usage and calculate final product cost considering other costing parameters is handled in this module. Module provides variation '
                                                      . 'reports to evaluate the efficiency of production line thereby adjusting parameters to fine tune the efficiency and minimize loses. '
                                                      . 'Module implementation will be completed in version 5.0';
$lang["All employees' personal details and job details can be maintained in the system. Module has features to track employee attendance "
    . "details and employee leave application details. Further it allows to evaluate employee performance and employee on boarding and "
    . "off bording details. Module implementation will be completed in version 6.0"] = "All employees' personal details and job details can be maintained in the system. Module has features to track employee attendance "
                                                                                     . "details and employee leave application details. Further it allows to evaluate employee performance and employee on boarding and "
                                                                                     . "off bording details. Module implementation will be completed in version 6.0";
$lang['Allows to reserve services(Including reserving rooms/halls etc., trainings and other types of services. Reservations can be seen on a calendar. '
    . 'Further module has features to collect advance payments and collect final payments. Module implementation will be completed in version 6.0'] = 'Allows to reserve services(Including reserving rooms/halls etc., trainings and other types of services. Reservations can be seen on a calendar. '
                                                                                   . 'Further module has features to collect advance payments and collect final payments. Module implementation will be completed in version 6.0';
$lang['Allows to create a chart of account structure and create prime entry books. Journal entries can be added for a financial year and if required '
    . 'based on locations. Trial balance, balance sheet and profit and lose accounts can be generated as reports with different search options. '
    . 'Module implementation will be completed in version 4.0'] = 'Allows to create a chart of account structure and create prime entry books. Journal entries can be added for a financial year and if required '
                                                                . 'based on locations. Trial balance, balance sheet and profit and lose accounts can be generated as reports with different search options. '
                                                                . 'Module implementation will be completed in version 4.0';
$lang['Admin and a normal user roles available with default user role permissions. New users can be created for type of admin or normal user. When required '
    . 'additional user roles can be created with custom permissions and can be assigned to users. Module is completely implemented and available '
    . 'in version '] = 'Admin and a normal user roles available with default user role permissions. New users can be created for type of admin or normal user. When required '
                     . 'additional user roles can be created with custom permissions and can be assigned to users. Module is completely implemented and available '
                     . 'in version ';
$lang['Employee salary details can be maintained in this module. Different types of earnings and deductions can be added and payroll process '
    . 'can be done by generating a salary payment detail script for banks. Module implementation will be completed in version 7.0'] = 'Employee salary details can be maintained in this module. Different types of earnings and deductions can be added and payroll process '
                                                                                                                                    . 'can be done by generating a salary payment detail script for banks. Module implementation will be completed in version 7.0';


////////////////////////////////////////  Sales Section /////////////////////////////////////////////////////////////////////////////////////

//Menus
$lang['Sales'] = 'Sales';
$lang['Sales Invoice'] = 'Sales Invoice';
$lang['Sales Return'] = 'Sales Return';


//Sales Invoice Screen
$lang['Add New Sales Invoice'] = 'Add New Sales Invoice';
$lang['Add Sales Invoice'] = 'Add Sales Invoice';
$lang['Edit Sales Invoice'] = 'Edit Sales Invoice';
$lang['Sales Invoice No'] = 'Sales Invoice No';
$lang['Sales Invoice Date'] = 'Sales Invoice Date';
$lang['Sales Invoice Type'] = 'Sales Invoice Type';
$lang['Print Sales Invoice'] = 'Print Sales Invoice';
$lang['Tax Sales Invoice'] = 'Tax Sales Invoice';
$lang['Finish Good Sale'] = 'Finish Good Sale';
$lang['Raw Material Sale'] = 'Raw Material Sale';
$lang['Sales Invoice Items'] = 'Sales Invoice Items';
$lang['Item'] = 'Item';
$lang['Item Code'] = 'Item Code';
$lang['Last Sales Invoice No : '] = 'Last Sales Invoice No : ';
$lang['Update Warehouse Stock Balance'] = 'Update Warehouse Stock Balance';
$lang['(Since lorry stock is not monitoring)'] = '(Since lorry stock is not monitoring)';
$lang['Mark Sales Invoice As Closed'] = 'Mark Sales Invoice As Closed';
$lang['sales_invoice_has_no_items'] = 'This sales invoice does not have any items. If this sales insvoice no longer required, please delete it.';
$lang['Sales Invoice Grand Total'] = 'Sales Invoice Grand Total';
$lang['Discount'] = 'Discount';
$lang['Sales Invoice Total Amount'] = 'Sales Invoice Total Amount';
$lang['Free/Sample Issue'] = 'Free/Sample Issue';
$lang['Total Tax'] = 'Total Tax';
$lang['Cash Payment'] = 'Cash Payment';
$lang['Credit Payment'] = 'Credit Payment';
$lang['Cheque Payment'] = 'Cheque Payment';
$lang['Balance Payment'] = 'Balance Payment';
$lang['Cheque Details'] = 'Cheque Details';
$lang['Payment Cheques'] = 'Payment Cheques';
$lang['Cash Details'] = 'Cash Details';
$lang['Add New Cheque'] = 'Add New Cheque';
$lang['Cheque Number'] = 'Cheque Number';
$lang['Open'] = 'Open';
$lang['Cashed'] = 'Cashed';
$lang['Deposited To Bank Account'] = 'Deposited To Bank Account';
$lang['Bank'] = 'Bank';
$lang['Add Another Sales Invoice For Same Sales Rep'] = 'Add Another Sales Invoice For Same Sales Rep';
$lang['Proforma Invoice No'] = 'Proforma Invoice No';
$lang['Add New Customer'] = 'Add New Customer';
$lang['Customer Name'] = 'Customer Name';
$lang['Issued to Person'] = 'Issued to Person';
$lang['Customer Telephone No'] = 'Customer Telephone No';
$lang['Customer Tax No'] = 'Customer Tax No';
$lang['Disable Sales Invoice Item Auto Save Feature'] = 'Disable Sales Invoice Item Auto Save Feature';
$lang['Free Issue Quantity'] = 'Free Issue Quantity';
$lang['Sample Issue Quantity'] = 'Sample Issue Quantity';
$lang['Free/Sample Issue Unit'] = 'Free/Sample Issue Unit';
$lang['Sales Unit'] = 'Sales Unit';
$lang['Sales Quantity'] = 'Sales Quantity';
$lang['Return Total'] = 'Return Total';
$lang['Returned Items'] = 'Returned Items';
$lang['Sales Returns'] = 'Sales Returns';
$lang['Add New Sales Return Item'] = 'Add New Sales Return Item';
$lang['Remove From Sales Invoice'] = 'Remove From Sales Invoice';
$lang['Search Item Batch'] = 'Search Item Batch';
$lang['Item Batch Details Search'] = 'Item Batch Details Search';
$lang['Item Cost From'] = 'Item Cost From';
$lang['Item Cost To'] = 'Item Cost To';
$lang['Item Cost Unit'] = 'Item Cost Unit';
$lang['Item Cost'] = 'Item Cost';
$lang['Cash Payments'] = 'Cash Payments';
$lang['Add New Cash Payment'] = 'Add New Cash Payment';
$lang['Print Short Bill'] = 'Print Short Bill';
$lang['Qty'] = 'Qty';
$lang['Price'] = 'Price';
$lang['Printed On'] = 'Printed On';
$lang['Printed By'] = 'Printed By';
$lang['Bill No'] = 'Bill No';
$lang['Running Quantity'] = 'Running Quantity';
$lang['Journal entry for finish good sales invoice number : '] = 'Journal entry for finish good sales invoice number : ';
$lang['Journal entry for raw material sales invoice number : '] = 'Journal entry for raw material sales invoice number : ';
$lang[' for sales invoice credit payment sales entry'] = ' for sales invoice credit payment sales entry';
$lang[' for sales invoice credit payment cost entry'] = ' for sales invoice credit payment cost entry';
$lang[' for sales invoice discount'] = ' for sales invoice discount';
$lang[' for sales invoice cash payment'] = ' for sales invoice cash payment';
$lang[' for sales invoice cheque payment'] = ' for sales invoice cheque payment';
$lang['Only '] = 'Only ';
$lang[' items can be added without a batch number. Remaining quantity should be added from a batch.'] = ' items can be added without a batch number. Remaining quantity should be added from a batch.';
$lang['Item Count'] = 'Item Count';
$lang[' for sales invoice free issue'] = ' for sales invoice free issue';
$lang[' for sales invoice sample issue'] = ' for sales invoice sample issue';
$lang['Open Point of Sales Screen'] = 'Open Point of Sales Screen';
$lang['e-ER Planner POS Sales Invoice'] = 'e-ER Planner POS Sales Invoice';
$lang['Previuos Invoice'] = 'Previuos Invoice';
$lang['Next Invoice'] = 'Next Invoice';
$lang['Invoice No'] = 'Invoice No';
$lang['Doctor'] = 'Doctor';
$lang['Patient'] = 'Patient';
$lang['Terminal'] = 'Terminal';
$lang['Invoice Total'] = 'Invoice Total';
$lang['Due Payment'] = 'Due Payment';
$lang['Del - Select Item and Press to Delete'] = 'Del - Select Item and Press to Delete';
$lang['F1 - Post Invoice'] = 'F1 - Post Invoice';
$lang['F2 - Hold Current Invoice'] = 'F2 - Hold Current Invoice';
$lang['F4 - New Invoice'] = 'F4 - New Invoice';
$lang['Discount(%)'] = 'Discount(%)';
$lang['Items'] = 'Items';
$lang['Piece'] = 'Piece';
$lang['Pieces'] = 'Pieces';
$lang['Open Invoice'] = 'Open Invoice';
$lang['Closed Invoice'] = 'Closed Invoice';
$lang['Sales Invoice Over Discount Authorization'] = 'Sales Invoice Over Discount Authorization';
$lang['Over Discount Authorizer'] = 'Over Discount Authorizer';
$lang['e-ER Planner POS Sales Invoice List'] = 'e-ER Planner POS Sales Invoice List';
$lang['Sales Invoice Item List'] = 'Sales Invoice Item List';
$lang['Down Arrow - Select Invoices Downwards'] = 'Down Arrow - Select Invoices Downwards';
$lang['Up Arrow - Select Invoices Upwards'] = 'Up Arrow - Select Invoices Upwards';
$lang['F1 - Update Payment Detail Changes'] = 'F1 - Update Payment Detail Changes';
$lang['F2 - Payment Collected'] = 'F2 - Payment Collected';
$lang['Payment Pending'] = 'Payment Pending';
$lang['Payment Collected'] = 'Payment Collected';


//Sales Return Screen
$lang['Add Sales Return'] = 'Add Sales Return';
$lang['Edit Sales Return'] = 'Edit Sales Return';
$lang['Sales Return Product Details'] = 'Sales Return Product Details';
$lang['Add New Sales Return'] = 'Add New Sales Return';
$lang['Sales Return No'] = 'Sales Return No';
$lang['Sales Return Type'] = 'Sales Return Type';
$lang['Item Details'] = 'Item Details';
$lang['Sales Return Item Details'] = 'Sales Return Item Details';
$lang['Search Items'] = 'Search Items';
$lang['Item Code'] = 'Item Code';
$lang['Item Name'] = 'Item Name';
$lang['Print Sales Return'] = 'Print Sales Return';
$lang['View Item Details'] = 'View Item Details';
$lang['Sold Quantity'] = 'Sold Quantity';
$lang['Return Quantity'] = 'Return Quantity';
$lang['Return Unit'] = 'Return Unit';
$lang['Current Lorry Stock Quantity'] = 'Current Lorry Stock Quantity';
$lang['Current Warehouse Stock Quantity'] = 'Current Warehouse Stock Quantity';
$lang['Add Additional Items'] = 'Add Additional Items';
$lang['Item Serial Numbers'] = 'Item Serial Numbers';
$lang['Item Serial Number'] = 'Item Serial Number';
$lang['Remove From Sales Return'] = 'Remove From Sales Return';
$lang['Returnd By'] = 'Returnd By';
$lang['Sales Return Grand Total'] = 'Sales Return Grand Total';
$lang[' for sales return payment'] = ' for sales return payment';



/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////  User Role Manager /////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

$lang['User Roles Manager Dashboard'] = 'පරිශීලක කාර්යභාර කළමණාකරු ඩෑෂ්බෝඩ්';
$lang['Dashboard - User Role Manager'] = 'ඩෑෂ්බෝඩ් - පරිශීලක කාර්යභාර කළමණාකරු ';

//Menu
$lang['Product Information'] = 'පද්ධතියේ තොරතුරු';
$lang['User Roles'] = 'පරිශීලක භූමිකාවන්';
$lang['Default User Roles'] = 'ප්‍රකෘති පරිශීලක භූමිකාවන්';
$lang['Derive User Roles'] = 'නවමු පරිශීලක භූමිකාවන්';
$lang['System Module Sections'] = 'පද්ධති මොඩියුල අංශ';
$lang['System Module Section Features'] = 'පද්ධති මොඩියුල කොටස් විශේෂාංග';
$lang['Permissions'] = 'අවසරයන්';
$lang['Note : Default user roles are not modifiable.'] = 'සටහන: ප්‍රකෘති පරිශීලක භූමිකාව වෙනස් කළ නොහැක.';
$lang['Default User Role Permissions'] = 'ප්‍රකෘති පරිශීලක භූමිකා අවසරයන්';
$lang['Derive User Role Permissions'] = 'නවමු පරිශීලක භූමිකා අවසරයන්';


//Login Screen
$lang['User Name']='පරිශීලක නාමය';
$lang['Password'] = 'මුරපදය';
$lang['Login'] = 'Login';
$lang['Forgot your password?']='Forgot your password?';
$lang['Enter the Email Address associated with your account and click "Submit" to receive a password.']='Enter the Email Address associated with your account and click "Submit" to receive a password.';


//Logout
$lang['Logout'] = 'පද්ධතියෙන් ඉවත්වීම';


//Sign Up
$lang['eStock Manager Request Quote & Free Account Sign Up'] ='eStock Manager Request Quote & Free Account Sign Up';
$lang['New to eStock Manager'] ='New to eStock Manager';
$lang['Sign up'] = 'Sign up';
$lang['Submit'] = 'Submit';
$lang['First Name'] = 'First Name';
$lang['Last Name'] = 'Last Name';
$lang['Comapany Name'] = 'Comapany Name';
$lang['Job Title'] = 'Job Title';
$lang['Contact Email'] = 'Contact Email';
$lang['Contact Phone'] = 'Contact Phone';
$lang['No of Employees'] = 'No of Employees';


//Change Password Screen
$lang['Current Password'] = 'වත්මන් මුරපදය';
$lang['New Password'] = 'නව මුරපදය';
$lang['New Password2'] = ' (must be at least 6 characters in length)';
$lang['Confirm Password'] = 'මුරපදය තහවුරු කරන්න';


//User Roles
$lang['Role ID'] = 'කාර්යභාරය අංකය';
$lang['Role'] = 'කාර්යභාරය';


//Derive User Roles
$lang['Derive User Role'] = 'නවමු පරිශීලක භූමිකාව';
$lang['Add New Derive User Role'] = 'නවමු පරිශීලක කාර්යක් එක් කරන්න';


//System Module Section Screen
$lang['System Module'] = 'පද්ධති මොඩියුලය';
$lang['Sub Module'] = 'උප මොඩියුලය';
$lang['Module Section'] = 'මොඩියුල අංශය';
$lang['System Module Section Details'] = 'පද්ධති මොඩියුල අංශයන්ගේ විස්තර';
$lang['Add New Main Module'] = 'Add New Main Module';
$lang['Status'] = 'තත්ත්වය';


//System Module Section Features Screen
$lang['Modules Details'] = 'Modules Details';
$lang['Module'] = 'Module';
$lang['Add New Module'] = 'Add New Module';
$lang['System Module Section Feature Details'] = 'පද්ධති මොඩියුල අංශයන්ගේ විශේෂාංග විස්තර';
$lang['Module Section Features'] = 'මොඩියුල අංශයන්ගේ විශේෂාංග';


//Permissions
$lang['Permission Details'] = 'අවසරයන්ගේ විස්තර';
$lang['Permission'] = 'Permission';


//Roles Permissions
$lang['Default User Role Permissions Details'] = 'Default User Role Permissions Details';
$lang['Add Permission'] = 'එකතු කිරීමේ අවසරය';
$lang['Edit Permission'] = 'වෙනස් කිරීමේ අවසරය';
$lang['Delete Permission'] = 'ඉවත් කිරීමේ අවසරය';
$lang['View Permission'] = 'බැලීමේ අවසරය';
$lang['Advanced'] = 'සංකීර්ණ අවසරයන්';
$lang['Advanced Permissions'] = 'සංකීර්ණ අවසරයන්';


//Derive Roles Permissions
$lang['Derive User Role Permissions Details'] = 'Derive User Role Permissions Details';
$lang['Sorry, You have no permission']='Sorry, You have no permission';


//Users
$lang['Users'] = 'පරිශීලකයන්';
$lang['Name'] = 'නම';
$lang['Derive Role'] = 'නවමු කාර්යභාරය';
$lang['Add New User'] = 'නව පරිශීලකයකු එකතු කරන්න';
$lang['User Details'] = 'පරිශීලක විස්තර';
$lang['Employee'] = 'සේවකයා';
$lang['Accessible Warehouses'] = 'අවසර ඇති ගබඩා';


//User Roles Help Screen
$lang['User Roles Help'] = 'පරිශීලක සහය';
$lang['Download User Roles Help User Guide'] = 'පරිශීලකයන්ගේ සහයක පරිශීලක උපදෙස් පොත බාගත කරන්න';


//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////  Accounts Manager Module ////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

$lang['Accounts Manager Dashboard'] = 'ගිණුම් කළමණාකරු ඩෑෂ්බෝඩ්';
$lang['Dashboard - Accounts Manager'] = 'ඩෑෂ්බෝඩ් - ගිණුම් කළමණාකරු';
$lang['Income Vs Expense'] = 'ආදායම් හා වියදම්';
$lang['This Financial Year'] = 'මෙම මූල්‍ය වර්ෂය';
$lang['Last Financial Year'] = 'අවසාන මූල්‍ය වර්ෂය';
$lang['Compare With Last Financial Year'] = 'අවසාන මූල්‍ය වර්ෂය සමඟ සසඳා බලන්න';
$lang['Current Month Weekly Status'] = 'මෙම මාසයේ සතිපතා තත්වය';
$lang['Last Month Weekly Status'] = 'පසුගිය මාසයේ සතිපතා තත්වය';
$lang['First Quarter of This Financial Year'] = 'මෙම මූල්‍ය වර්ෂයේ පළමු කාර්තුව';
$lang['Second Quarter of This Financial Year'] = 'මෙම මූල්‍ය වර්ෂයේ දෙවන කාර්තුව';
$lang['Third Quarter of This Financial Year'] = 'මෙම මූල්‍ය වර්ෂයේ තුන්වන කාර්තුව';
$lang['Fourth Quarter of This Financial Year'] = 'මෙම මූල්‍ය වර්ෂයේ හතරවන කාර්තුව';
$lang['Summary of Assets'] = 'වත්කම් සාරාංශය';
$lang['Graph Type'] = 'ප්‍රස්ථාර වර්ගය';
$lang['Assets Percentage Summary'] = 'වත්කම් ප්‍රතිශත සාරාංශය';
$lang['Assets Value Summary'] = 'වත්කම් සාරාංශය';
$lang['Summary of Liabilities'] = 'වගකීම් සාරාංශය';
$lang['Liabilities Percentage Summary'] = 'වගකීම් ප්‍රතිශත සාරාංශය';
$lang['Liabilities Value Summary'] = 'වගකීම් අගයන් සාරාංශය';
$lang['Top Ten Expense Accounts'] = 'ඉහළම වියදම් ගිණුම් දහය';
$lang['Top Ten Expense Accounts Percentage Summary'] = 'ඉහළම වියදම් ගිණුම් දහයේ ප්‍රතිශත සාරාංශය';
$lang['Top Ten Expense Accounts Value Summary'] = 'ඉහළම වියදම් ගිණුම් දහයේ අගයන් සාරාංශය';
$lang['Debtor List'] = 'ණයගැති ලැයිස්තුව';
$lang['Creditor List'] = 'ණයහිමි ලැයිස්තුව';
$lang['Debtor'] = 'ණයගැතියා';
$lang['Balance Amount'] = 'ශේෂ මුදල';
$lang['Creditor'] = 'ණයහිමියා';
$lang['Assets'] = 'වත්කම්';
$lang['Liabilities'] = 'වගකීම්';
$lang['Expense Account Value Summary'] = 'වියදම් ගිණුම අගයන් සාරාංශය';
$lang['Expense'] = 'වියදම්';
$lang['Expense Account Percentage Summary'] = 'වියදම් ගිණුම් ප්‍රතිශත සාරාංශය';
$lang['Income & Expense'] = 'ආදායම් හා වියදම්';


//Menus
$lang['Bookkeeping'] = 'පොත් තැබීම';
$lang['Chart of Accounts'] = 'ගිණුම් සටහන';
$lang['Prime Entry Books'] = 'මූලික ඇතුළත් කිරීමේ පොත්';
$lang['Journal Entries'] = 'ජර්නල් සටහන්';
$lang['General Ledger'] = 'ජෙනරල් ලෙජර්';
$lang['Trial Balance'] = 'ශේෂ පිරික්සුම';


//Chart of Account Screen
$lang['Chart of Account Code'] = 'ගිණුම් කේතය';
$lang['Chart of Account Name'] = 'ගිණුමේ නම';


//Prime Entry Books Screen
$lang['Prime Entry Book Name'] = 'මූලික ඇතුළත් කිරීමේ පොතේ නම';
$lang['Add New Prime Entry Book'] = 'නව මූලික සටහන් පොත එක් කරන්න';
$lang['Add Another Debit Ledger Account'] = 'තවත් හර කිරීමේ ගිණුමක් එකතු කරන්න';
$lang['Add Another Credit Ledger Account'] = 'තවත් බැර කිරීමේ ගිණුමක් එකතු කරන්න';
$lang['Debit Chart of Account'] = 'හර ගිණුම්';
$lang['Credit Chart of Account'] = 'බැර ගිණුම';
$lang['Prime Entry Book Ledger Accounts'] = 'මූලික ඇතුළත් කිරීමේ පොත් ලෙජර ගිණුම්';
$lang['Has reference transaction journal entry'] = 'ජර්නල ඇතුළත් කිරීමේ යොමුව ඇත';
$lang['Reference Transaction Type'] = 'යොමු ගනුදෙනු වර්ගය';
$lang['Finish Good Good Receive Note'] = 'Finish Good Good Receive Note';
$lang['Finish Good Supplier Return'] = 'Finish Good Supplier Return';
$lang['Raw Material Good Receive Note'] = 'Raw Material Good Receive Note';
$lang['Raw Material Supplier Return'] = 'Raw Material Supplier Return';
$lang['Other'] = 'Other';
$lang['Reference Transaction'] = 'යොමු ගණුදෙනුව';
$lang['Reference Journal Entry'] = 'යොමු ජර්නල් සටහන';
$lang['Applicable Module'] = 'අදාළ මොඩියුලය';


//Journal Entries Screen
$lang['Prime Entry Book'] = 'මූලික ඇතුළත් කිරීමේ පොත';
$lang['Journal Entry Values'] = 'ජර්නල් ඇතුළත් කිරීමේ අගයන්';
$lang['Value'] = 'මුදල';
$lang['Account Code'] = 'ගිණුම් කේතය';
$lang['Add New Journal Entry'] = 'නව ජර්නල් සටහනක් එක් කරන්න';
$lang['Debit Amount'] = 'හර මුදල';
$lang['Credit Amount'] = 'බැර මුදල';
$lang['Debit Amount Total'] = 'මූළු හර මුදල';
$lang['Credit Amount Total'] = 'මූළු බැර මුදල';
$lang['Debit Total'] = 'මූළු හර';
$lang['Credit Total'] = 'මූළු බැර';
$lang['Add as a Prime Entry Book'] = 'මූලික ඇතුළත් කිරීමේ පොතක් ලෙස එක් කරන්න';
$lang['Payee/Payer Type'] = 'ලබන්නා/ගෙවන්නා';
$lang['Payee/payer Name'] = 'ලබන්නාගේ/ගෙවන්නාගේ නම';
$lang['Due Date'] = 'ගෙවිය යුතු දිනය';


//General Ledger Screen
$lang['Chart of Account'] = 'ගිණුම';
$lang['Narration'] = 'Narration';
$lang['Transaction Reference'] = 'Transaction Reference';
$lang['Search General Ledger'] = 'ජෙනරල් ලෙජරයෙන් සොයන්න';
$lang['Journal Entry Reference No'] = 'ජර්නල් සටහන් යොමු අංකය';


//Accounts Manager Bookkeeping Help Screen
$lang['Bookkeeping Help'] = 'පොත් තැබීමේ සහාය';
$lang['Download Bookkeeping Help User Guide'] = 'පොත් තැබීමේ සහායක පරිශීලක උපදෙස් පොත බාගත කරන්න';


//System Configurations Help Screen
$lang['Day'] = 'දවස';
$lang['Financial Year Start'] = 'මූල්ය වර්ෂය ආරම්භය';
$lang['Financial Year End'] = 'මූල්ය වර්ෂය අවසානය';
$lang['Enable Accounts Management For Locations'] = 'ස්ථාන සඳහා ගිණුම් කළමනාකරණය සක්‍රීය කරන්න';
$lang['Select first level chart of account categories in order to display on trial balance'] = 'ශේෂ පත්‍රයේ පෙන්වීම සඳහා ගිණුම් වර්ගවල පළමු මට්ටමේ ගිණුම තෝරන්න';
$lang['Statement of Financial Position'] = 'Statement of Financial Position';
$lang['Non-current Assets Chart of Account Entries'] = 'ජංගම නොවන වත්කම් ගිණුම්';
$lang['Current Assets Chart of Account Entries'] = 'ජංගම වත්කම් ගිණුම්';
$lang['Equity Chart of Account Entries'] = 'හිමිකම් ගිණුම්';
$lang['Non-current Liabilities Chart of Account Entries'] = 'ජංගම නොවන වගකීම් ගිණුම්';
$lang['Current Liabilities Chart of Account Entries'] = 'ජංගම වගකීම් ගිණුම්';
$lang['Revenue Calculating Chart of Account Entries'] = 'ආදායම් ගණනය කිරීමේ ගිණුම්';
$lang['Gross Profit Calculating Chart of Account Entries'] = 'දළ ලාභය ගණනය කිරීමේ ගිණුම්';
$lang['Operating Activities Calculating Chart of Account Entries'] = 'මෙහෙයුම් ක්‍රියාකාරකම් ගණනය කිරීමේ ගිණුම්';
$lang['Profit Calculating Chart of Account Entries'] = 'ලාභය ගණනය කිරීමේ ගිණුම්';
$lang['Net Profit Calculating Chart of Account Entries'] = 'ශුද්ධ ලාභය ගණනය කිරීමේ ගිණුම්';
$lang['Select cash related chart of accounts for report generation under cash accounting method'] = 'මුදල් ගිණුම්කරණ ක්‍රමය යටතේ වාර්තා උත්පාදනය කිරීම සඳහා මුදල් සම්බන්ධිත ගිණුම් තෝරන්න';


//Reports
$lang['Bookkeeping Reports'] = 'පොත් තැබීම් වාර්තා';
$lang['Balance Sheet'] = 'ශේෂ පත්‍රය';
$lang['Statement of Financial Position'] = 'Statement of Financial Position';
$lang['Profit & Loss'] = 'ලාභය සහ අලාභය';
$lang['Accounting Method'] = 'ගිණුම්කරණ ක්‍රමය';
$lang['Income Statement'] = 'Income Statement';
$lang[' And For Year '] = ' And For Year ';
$lang['For Year '] = 'For Year ';
$lang['Non-current Assets'] = 'Non-current Assets';
$lang['Non-current Assets Total'] = 'Non-current Assets Total';
$lang['Current Assets'] = 'Current Assets';
$lang['Current Assets Total'] = 'Current Assets Total';
$lang['ASSETS'] = 'ASSETS';
$lang['Assets Total'] = 'Assets Total';
$lang['EQUITY AND LIABILITIES'] = 'EQUITY AND LIABILITIES';
$lang['Equity'] = 'Equity';
$lang['Equity Total'] = 'Equity Total';
$lang['Non-current Liabilities'] = 'Non-current Liabilities';
$lang['Non-current Liabilities Total'] = 'Non-current Liabilities Total';
$lang['Current Liabilities'] = 'Current Liabilities';
$lang['Current Liabilities Total'] = 'Current Liabilities Total';
$lang['Equity and Liabilities Total'] = 'Equity and Liabilities Total';
$lang['Continuing Operations'] = 'Continuing Operations';
$lang['Revenue'] = 'Revenue';
$lang['Gross Profit'] = 'Gross Profit';
$lang['Results from Operating Activities'] = 'Results from Operating Activities';
$lang['Profit Before Tax'] = 'Profit Before Tax';
$lang['Net Profit'] = 'Net Profit';
$lang['Income Statement'] = 'Income Statement';
$lang['Figures in brackets indicates deductions or negative values'] = 'Figures in brackets indicates deductions or negative values';
$lang['Accrual'] = 'උපචිත';
$lang['Debtors'] = 'ණයගැතියන්';
$lang['Creditors'] = 'ණයහිමියන්';
$lang['Person'] = 'පුද්ගලයා';
$lang['Total Debt Amount'] = 'සම්පූර්ණ ණය මුදල';
$lang['Total Amount Paid'] = 'ගෙවා ඇති මුළු මුදල ';
$lang['Total Balance Amount'] = 'සමස්ථ ශේෂ මුදල';
$lang['Total Credit Amount'] = 'ගෙවිය යුතු මුළු ණය මුදල';


/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////  HR Manager  ////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

$lang['HR Manager Dashboard'] = 'HR Manager Dashboard';
$lang['Dashboard - HR Manager'] = 'Dashboard - HR Manager';

////////////////////////////////////////  Admiistration Section /////////////////////////////////////////////////////////////


//Menus
$lang['Departments'] = 'Departments';
$lang['Job Titles'] = 'Job Titles';
$lang['Employment Statuses'] = 'Employment Statuses';
$lang['Job Categories'] = 'Job Categories';
$lang['Career Paths'] = 'Career Paths';
$lang['Screen Field Visibility'] = 'Screen Field Visibility';
$lang['Data Import'] = 'දත්ත ඇසිරීම';


//Departments Screen
$lang['Add New Department'] = 'Add New Department';
$lang['Department Code'] = 'Department Code';
$lang['Department'] = 'Department';
$lang['Are you sure you want to delete this Department?'] = 'Are you sure you want to delete this Department?';


//Job Title Screen
$lang['Add New Job Title'] = 'Add New Job Title';
$lang['Job Title Details'] = 'Job Title Details';
$lang['Job Title'] = 'Job Title';


//Employment Status Screen
$lang['Add New Employment Status'] = 'Add New Employment Status';
$lang['Employment Status Details'] = 'Employment Status Details';
$lang['Employment Status'] = 'Employment Status';


//Job Categories Screen
$lang['Add New Job Category'] = 'Add New Job Category';
$lang['Job Category Details'] = 'Job Category Details';
$lang['Job Category'] = 'Job Category';


//Screen Field Visibility Screen
$lang['Personal Details Screen'] = 'Personal Details Screen';
$lang['Job Details Screen'] = 'Job Details Screen';


//Data Import Screen
$lang['Download Data Import Excel Workbook'] = 'Download Data Import Excel Workbook';
$lang['Upload Data Import Excel Workbook'] = 'Upload Data Import Excel Workbook';
$lang['Import Data'] = 'දත්ත අසුරන්න';
$lang['Download'] = 'බාගත කරන්න';
$lang['Download Data Import Workbook User Guide'] = 'දත්ත ඇසිරීමේ සහයක පරිශීලක උපදෙස් පොත බාගත කරන්න';
$lang['Import All Data'] = 'Import All Data';
$lang['Import Only Company Information'] = 'Import Only Company Information';
$lang['Import Only Company Structure'] = 'Import Only Company Structure';
$lang['Import Only Departments'] = 'Import Only Departments';
$lang['Import Only Locations'] = 'Import Only Locations';
$lang['Import Only Job Titles'] = 'Import Only Job Titles';
$lang['Import Only Employment Statuses'] = 'Import Only Employment Statuses';
$lang['Import Only Job Categories'] = 'Import Only Job Categories';
$lang['Import Only Personal Details'] = 'Import Only Personal Details';
$lang['Import Only Job Details'] = 'Import Only Job Details';
$lang['Import'] = 'අසුරන්න';
$lang['Upload'] = 'අප්ලොඩ්';
$lang['Download Data Import Error Log File'] = 'දත්ත ඇසිරීමේ දෝෂ ලොග් සටහන බාගත කරන්න';
$lang['Download Data Import Workbook Error Log File'] = 'දත්ත ඇසිරීමේ වැඩපොතේ දෝෂ ලොග් සටහන බාගත කරන්න';


////////////////////////////////////////  Personal Details Section ////////////////////////////////////////////////////////////////////////

//Menus
$lang['Personal Details Module'] = 'Personal Details Module';
$lang['Employee List'] = 'Employee List';


//Personal Details Screen
$lang['Add New Employee'] = 'Add New Employee';
$lang['Personal Details'] = 'Personal Details';
$lang['First Name'] = 'First Name';
$lang['Middle Name'] = 'Middle Name';
$lang['Last Name'] = 'Last Name';
$lang['Gender'] = 'Gender';
$lang['Marital Status'] = 'Marital Status';
$lang['Nationality'] = 'Nationality';
$lang['Date of Birth'] = 'Date of Birth';
$lang['NIC Number'] = 'NIC Number';
$lang['Nick Name'] = 'Nick Name';
$lang['Other Names'] = 'Other Names';
$lang['Drinker'] = 'Drinker';
$lang['Smoker'] = 'Smoker';
$lang['Blood Group'] = 'Blood Group';
$lang['View More Details'] = 'View More Details';
$lang['View Profile Summary'] = 'View Profile Summary';
$lang['Add Employee Photo'] = 'Add Employee Photo';
$lang['Employee Photo'] = 'Employee Photo';
$lang['Upload Photo'] = 'Upload Photo';
$lang['Select Employee Photo'] = 'Select Employee Photo';
$lang['Create user login account'] = 'Create user login account';


//Job Details Screen
$lang['Job Details'] = 'Job Details';
$lang['Employee Code'] = 'Employee Code';
$lang['Date of Join'] = 'Date of Join';
$lang['Date of Permanency'] = 'Date of Permanency';
$lang['Contract Start Date'] = 'Contract Start Date';
$lang['Contract End Date'] = 'Contract End Date';
$lang['Employee Name'] = 'Employee Name';
$lang['Career Path'] = 'Career Path';
$lang['Working Country'] = 'Working Country';
$lang['Effective Date'] = 'Effective Date';
$lang['Company Change Effective Date'] = 'Company Change Effective Date';
$lang['Department Change Effective Date'] = 'Department Change Effective Date';
$lang['Location Change Effective Date'] = 'Location Change Effective Date';
$lang['Job Title Change Effective Date'] = 'Job Title Change Effective Date';
$lang['Employment Status Change Effective Date'] = 'Employment Status Change Effective Date';
$lang['Job Category Change Effective Date'] = 'Job Category Change Effective Date';
$lang['Career Path Change Effective Date'] = 'Career Path Change Effective Date';
$lang['Working Country Change Effective Date'] = 'Working Country Change Effective Date';
$lang['Back To Employee List'] = 'Back To Employee List';
$lang['Back To Personal Details'] = 'Back To Personal Details';


//Salary Details Screen
$lang['Salary Details'] = 'Salary Details';


//Contact Details Screen
$lang['Contact Details'] = 'Contact Details';


//Emergency Contact Details Screen
$lang['Emergency Contact Details'] = 'Emergency Contact Details';


//PIM Help Screen
$lang['Personal Details Help'] = 'Personal Details Help';
$lang['Download Personal Details Help User Guide'] = 'Download Personal Details Help User Guide';


////////////////////////////////////////  Time & Attendance Section //////////////////////////////////////////////////////////

//Menus
$lang['Time & Attendance'] = 'Time & Attendance';
$lang['Working Shifts'] = 'Working Shifts';
$lang['Employee Working Rosters'] = 'Employee Working Rosters';
$lang['Employee Attendance'] = 'Employee Attendance';
$lang['Employee Time Sheets'] = 'Employee Time Sheets';


//Working Shifts Screen
$lang['Shift Code'] = 'Shift Code';
$lang['Shift Name'] = 'Shift Name';
$lang['Add New Working Shift'] = 'Add New Working Shift';
$lang['Configure Working Shift'] = 'Configure Working Shift';
$lang['Shift Start Time'] = 'Shift Start Time';
$lang['Shift End Time'] = 'Shift End Time';
$lang['HPR'] = 'HPR';
$lang['Before Shift HPR'] = 'Before Shift HPR';
$lang['During Shift HPR'] = 'During Shift HPR';
$lang['After Shift HPR'] = 'After Shift HPR';
$lang['Break Time HPR'] = 'Break Time HPR';
$lang['Mid Night Crossover'] = 'Mid Night Crossover';
$lang['Remove Shift Time'] = 'Remove Shift Time';
$lang['Shift Session Time Details'] = 'Shift Session Time Details';
$lang['Add Shift Time'] = 'Add Shift Time';
$lang['Shift Break Details'] = 'Shift Break Details';
$lang['Mark as Default Shift'] = 'Mark as Default Shift';
$lang['Shift Break Start Time'] = 'Shift Break Start Time';
$lang['Shift Break End Time'] = 'Shift Break End Time';
$lang['Break Start Time'] = 'Break Start Time';
$lang['Break End Time'] = 'Break End Time';
$lang['Max In Time Detect Buffer'] = 'Max In Time Detect Buffer';
$lang['Max Out Time Detect Buffer'] = 'Max Out Time Detect Buffer';
$lang['Annotations : HPR - Hourly Pay Rate'] = 'Annotations : HPR - Hourly Pay Rate';


//Employee Working Rosters Screen
$lang['Employee Working Rosters'] = 'Employee Working Rosters';
$lang['Bulk Roster'] = 'Bulk Roster';
$lang['Configure Working Roster'] = 'Configure Working Roster';
$lang['Configure Roster'] = 'Configure Roster';
$lang['Draggable Shifts'] = 'Draggable Shifts';
$lang['Roster Schedule'] = 'Roster Schedule';
$lang['Applicable Employees'] = 'Applicable Employees';
$lang['Roster Garbage'] = 'Roster Garbage';
$lang['Drag and drop the shift to the calendar to prepare the roster'] = 'Drag and drop the shift to the calendar to prepare the roster';
$lang['Drag and drop shifts from the calendar to the garbage bin to delete the shift from roster'] = 'Drag and drop shifts from the calendar to the garbage bin to delete the shift from roster';
$lang['Select employee to exclude in roster preparation'] = 'Select employee to exclude in roster preparation';
$lang['Search Employees'] = 'Search Employees';
$lang['Default Shift'] = 'Default Shift';


//Employee Attendance Screen
$lang['View Punch Times'] = 'View Punch Times';
$lang['View Processed Attendance'] = 'View Processed Attendance';
$lang['Employee Time Punch Records'] = 'Employee Time Punch Records';
$lang['Attendance Date'] = 'Attendance Date';
$lang['Attendance Time'] = 'Attendance Time';
$lang['Punch Type'] = 'Punch Type';
$lang['Processed'] = 'Processed';
$lang['Search Records'] = 'Search Records';
$lang['View Punch Times in Bulk'] = 'View Punch Times in Bulk';
$lang['Add Punch Times in Bulk'] = 'Add Punch Times in Bulk';
$lang['Add Punch Times'] = 'Add Punch Times';
$lang['punch_type'] = 'Punch Type';
$lang['Attendance Cycle Status'] = 'Attendance Cycle Status';
$lang['Processed Attendance of Employee'] = 'Processed Attendance of Employee';
$lang['Attendance Results'] = 'Attendance Results';
$lang['Processig attendance data...'] = 'Processig attendance data...';
$lang['Attendance Results Graph Legends'] = 'Attendance Results Graph Legends';
$lang['Shift Time Color'] = 'Shift Time Color';
$lang['Break Time Color'] = 'Break Time Color';
$lang['Work Time Color'] = 'Work Time Color';
$lang['Accepted Movement Color'] = 'Accepted Movement Color';
$lang['Rejected Movement Color'] = 'Rejected Movement Color';
$lang['Employee Attendance Results'] = 'Employee Attendance Results';
$lang['Employee Bulk Time Punch Records'] = 'Employee Bulk Time Punch Records';
$lang['Add Time Punch Records'] = 'Add Time Punch Records';
$lang['Add Bulk Time Punch Records'] = 'Add Bulk Time Punch Records';
$lang['Missing Record'] = 'Missing Record';
$lang['Message'] = 'Message';
$lang['Reuse Existing Attendance Record'] = 'Reuse Existing Attendance Record';
$lang['View Attendance Results Summary for Selected Date Range'] = 'View Attendance Results Summary for Selected Date Range';
$lang['Attendance Details'] = 'Attendance Details';
$lang['Attendance Summary'] = 'Attendance Summary';
$lang['Shift Details'] = 'Shift Details';
$lang['Roster Date'] = 'Roster Date';
$lang['Session Details'] = 'Session Details';
$lang['Session '] = 'Session ';
$lang['Session Start Time'] = 'Session Start Time';
$lang['Session End Time'] = 'Session End Time';
$lang['Break Details'] = 'Break Details';
$lang['Break '] = 'Break ';
$lang['Break Start Time'] = 'Break Start Time';
$lang['Break End Time'] = 'Break End Time';
$lang['Hide Details'] = 'Hide Details';
$lang['Shift & Attendance Details'] = 'Shift & Attendance Details';
$lang['Missing Attendance Records'] = 'Missing Attendance Records';
$lang['Shift attendance Summary'] = 'Shift attendance Summary';
$lang['Session Attendance Details'] = 'Session Attendance Details';
$lang['Session In Time'] = 'Session In Time';
$lang['Session Out Time'] = 'Session Out Time';
$lang['Early In Time'] = 'Early In Time';
$lang['Late In Time'] = 'Late In Time';
$lang['Early Out Time'] = 'Early Out Time';
$lang['Late Out Time'] = 'Late Out Time';
$lang['Movement Details'] = 'Movement Details';
$lang['Select For Calculations'] = 'Select For Calculations';
$lang['Out Time'] = 'Out Time';
$lang['In Time'] = 'In Time';
$lang['Duration'] = 'Duration';
$lang['Movement'] = 'Movement';
$lang['Before shift work hours'] = 'Before shift work hours';
$lang['During shift work hours'] = 'During shift work hours';
$lang['During shift break hours'] = 'During shift break hours';
$lang['After shift work hours'] = 'After shift work hours';
$lang['Shift Session'] = 'Shift Session';
$lang['Calculated Attendance Results'] = 'Calculated Attendance Results';
$lang['Work Time During Shift'] = 'Work Time During Shift';
$lang['Work Time During Break'] = 'Work Time During Break';
$lang['Hour'] = 'Hour';
$lang['Hours'] = 'Hours';
$lang['Minute'] = 'Minute';
$lang['Minutes'] = 'Minutes';
$lang['Attendance Time Summary'] = 'Attendance Time Summary';
$lang['Attendance Time Daily Summary'] = 'Attendance Time Daily Summary';
$lang['Attendance Payment Summary'] = 'Attendance Payment Summary';
$lang['Totals'] = 'Totals';
$lang['View Processed Attendance Results in Bulk'] = 'View Processed Attendance Results in Bulk';
$lang['Bulk Employee Attendance Results'] = 'Bulk Employee Attendance Results';
$lang['Search Details'] = 'Search Details';
$lang['Search Summary'] = 'Search Summary';
$lang['Compare With Attendance Records'] = 'Compare With Attendance Records';
$lang['Attendance Records'] = 'Attendance Records';

//Time Attendance Help Screen
$lang['Time Attendance Help'] = 'Time Attendance Help';
$lang['Download Time Attendance Help User Guide'] = 'Download Time Attendance Help User Guide';


////////////////////////////////////////  Analytics Section ///////////////////////////////////////////////////////////////////

//Menus
$lang['Analytics'] = 'Analytics';
$lang['Dynamic Reports'] = 'Dynamic Reports';

//Reports Screen
$lang['List of Reports'] = 'List of Reports';
$lang['Add Report'] = 'Add Report';
$lang['Add Folder'] = 'Add Folder';
$lang['Add New Report Folder'] = 'Add New Report Folder';
$lang['Folder Name'] = 'Folder Name';
$lang['Report Folders'] = 'Report Folders';
$lang['Configure Report'] = 'Configure Report';
$lang['Next'] = 'Next';
$lang['Previous'] = 'Previous';
$lang['Report Name'] = 'Report Name';
$lang['Report Folder'] = 'Report Folder';
$lang['Save Report Details'] = 'Save Report Details';
$lang['Add Report Details'] = 'Add Report Details';
$lang['Add Report Fields for'] = 'Add Report Fields for';
$lang['Select Report Fields'] = 'Select Report Fields';
$lang['Add Report Conditions for'] = 'Add Report Conditions for';
$lang['Save Report Fields'] = 'Save Report Fields';
$lang['Save Report Conditions'] = 'Save Report Conditions';
$lang['Step 1 - Report Details'] = 'Step 1 - Report Details';
$lang['Step 2 - Report Fields'] = 'Step 2 - Report Fields';
$lang['Step 3 - Report Conditions'] = 'Step 3 - Report Conditions';
$lang['Note : Select a report folder to view reports.'] = 'Note : Select a report folder to view reports.';
$lang['Report Results'] = 'Report Results';
$lang['Delete Selected Report Folder'] = 'Delete Selected Report Folder';
$lang['Report'] = 'Report';
$lang['None'] = 'None';
$lang['Add Condition'] = 'Add Condition';
$lang['All conditions should be satisfied (AND)'] = 'All conditions should be satisfied (AND)';
$lang['At least one condition should be satisfied (OR)'] = 'At least one condition should be satisfied (OR)';
$lang['Generate as a History Report of'] = 'Generate as a History Report of';
$lang['Present Information'] = 'Present Information';
$lang['History Information'] = 'History Information';
$lang['Personal Details & Job Details'] = 'Personal Details & Job Details';
$lang['Department Name'] = 'Department Name';


//Analytics Help Screen
$lang['Analytics Help'] = 'Analytics Help';
$lang['Download Analytics Help User Guide'] = 'Download Analytics Help User Guide';


/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////  Payroll Manager  ///////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

$lang['Payroll Manager Dashboard'] = 'Payroll Manager Dashboard';
$lang['Dashboard - Payroll Manager'] = 'Dashboard - Payroll Manager';



/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////  Service Manager  ///////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

$lang['Service Manager Dashboard'] = 'Service Manager Dashboard';


////////////////////////////////////////  Reservation Manager Section ///////////////////////////////////////////////////////

$lang['Dashboard - Reservation Manager'] = 'Dashboard - Reservation Manager';
$lang['Reservation Manager Dashboard'] = 'Reservation Manager Dashboard';


////////////////////////////////////////  Admiistration Section /////////////////////////////////////////////////////////////

//Menus
$lang['Buildings'] = 'Buildings';
$lang['Halls'] = 'Halls';
$lang['Rooms'] = 'Rooms';
$lang['Reservation Details'] = 'Reservation Details';


//Buildings  Screen
$lang['Building Details'] = 'Building Details';
$lang['Building Name'] = 'Building Name';
$lang['Add New Building'] = 'Add New Building';
$lang['Building'] = 'Building';


////////////////////////////////////////  Donation Manager Section ///////////////////////////////////////////////////////

$lang['Dashboard - Donation Manager'] = 'Dashboard - Donation Manager';
$lang['Donation Manager Dashboard'] = 'Donation Manager Dashboard';


////////////////////////////////////////  Administration Section /////////////////////////////////////////////////////////////

//Menus
$lang['Programs'] = 'Programs';
$lang['Donation Details'] = 'Donation Details';


//Programs  Screen
$lang['Program Details'] = 'Program Details';
$lang['Program Name'] = 'Program Name';
$lang['Coordinator Name'] = 'Coordinator Name';
$lang['Add New Program'] = 'Add New Program';
$lang['Program Coordinator'] = 'Program Coordinator';
$lang['Member'] = 'සාමාජිකයා';


//System Configurations Screen
$lang['Enable Program Wise Chart of Account Information Monitoring'] = 'Enable Program Wise Chart of Account Information Monitoring';
$lang['Select prime entry book/s for account transactions for each program'] = 'Select prime entry book/s for account transactions for each program';
$lang['Select prime entry book/s for account transactions for each program for budget issue'] = 'Select prime entry book/s for account transactions for each program for budget issue';
$lang['Select prime entry book/s for account transactions for program budget issue'] = 'Select prime entry book/s for account transactions for program budget issue';
$lang['Select prime entry book/s for account transactions for each program for budget return'] = 'Select prime entry book/s for account transactions for each program for budget return';
$lang['Select prime entry book/s for account transactions for program budget return'] = 'Select prime entry book/s for account transactions for program budget return';


////////////////////////////////////////  Donation Details Section /////////////////////////////////////////////////////////////

//Collect Donations  Screen
$lang['Collect Donations'] = 'Collect Donations';
$lang['Donor'] = 'Donor';
$lang['Add New Donation'] = 'Add New Donation';
$lang['Donation Details'] = 'Donation Details';
$lang['Journal entry for donation collection with reference number : '] = 'Journal entry for donation collection with reference number : ';


//Program Progress  Screen
$lang['Program Progress'] = 'Program Progress';
$lang['Program'] = 'Program';
$lang['Thid program still does not have any activities scheduked. Click here to add activities to the program.'] = 'Thid program still does not have any activities scheduked. Click here to add activities to the program.';
$lang['Thid program still does not have any activities scheduled. Click '] = 'Thid program still does not have any activities scheduled. Click ';
$lang[' to add activities to the program.'] = ' to add activities to the program.';
$lang['Program Activity Details'] = 'Program Activity Details';
$lang['Add Program Activity'] = 'Add Program Activity';
$lang['Activity Name'] = 'Activity Name';
$lang['Start Date'] = 'Start Date';
$lang['Finish Date'] = 'Finish Date';
$lang['Activity Owner'] = 'Activity Owner';
$lang['Activity Budget'] = 'Activity Budget';
$lang['Activity Completion'] = 'Activity Completion';
$lang['Actual Start Date'] = 'Actual Start Date';
$lang['Actual Finished Date'] = 'Actual Finished Date';
$lang['Activity Cost'] = 'Activity Cost';
$lang['Budget Varience'] = 'Budget Varience';
$lang['Program Progress Details'] = 'Program Progress Details';
$lang['Add New Activity'] = 'Add New Activity';
$lang['Budget Estimated'] = 'Budget Estimated';
$lang['Activity Cost Total'] = 'Activity Cost Total';
$lang['Overall Budget Varience'] = 'Overall Budget Varience';
$lang['Progress in Terms of Budget'] = 'Progress in Terms of Budget';
$lang['Progress in Terms of Activity Completion'] = 'Progress in Terms of Activity Completion';
$lang['Program Progress Status'] = 'Program Progress Status';
$lang['Program Start Date'] = 'Program Start Date';
$lang['Program Finish Date'] = 'Program Finish Date';
$lang['Actual Program Start Date'] = 'Actual Program Start Date';
$lang['Actual Program Finished Date'] = 'Actual Program Finished Date';
$lang['Program Activity Budget Issue Information'] = 'Program Activity Budget Issue Information';
$lang['Program Activity Budget Issue'] = 'Program Activity Budget Issue';
$lang['Budget Issue Amount'] = 'Budget Issue Amount';
$lang['Add New Budget Issue'] = 'Add New Budget Issue';
$lang['Issue Date'] = 'Issue Date';
$lang['Program Activity Progress'] = 'Program Activity Progress';
$lang['completed'] = 'completed';
$lang['Fund Available'] = 'Fund Available';
$lang['Budget Deficiency'] = 'Budget Deficiency';
$lang['Close Program'] = 'Close Program';
$lang['Collect Budget Return'] = 'Collect Budget Return';
$lang['Program Activity Budget Return Information'] = 'Program Activity Budget Return Information';
$lang['Program Activity Budget Return'] = 'Program Activity Budget Return';
$lang['Return Date'] = 'Return Date';
$lang['Budget Return Amount'] = 'Budget Return Amount';
$lang['Add New Budget Return'] = 'Add New Budget Return';
$lang['Journal entry for budget issue for program : '] = 'Journal entry for budget issue for program : ';
$lang['Journal entry for budget return for program : '] = 'Journal entry for budget return for program : ';


//Donation Help Screen
$lang['Donation Help'] = 'Donation Help';
$lang['Download Donation Help User Guide'] = 'Download Donation Help User Guide';

////////////////////////////////////////  Reports Section /////////////////////////////////////////////////////////////

//Menus
$lang['Donation Reports'] = 'Donation Reports';

//Reports Screen
$lang['Donation Total'] = 'Donation Total';
$lang['Donation Summary Details'] = 'Donation Summary Details';
$lang['Donation Grand Total'] = 'Donation Grand Total';
$lang['Program Summary Details'] = 'Program Summary Details';
$lang['Total Fund Available'] = 'Total Fund Available';
$lang['Total Budget Estimated'] = 'Total Budget Estimated';
$lang['Budget Deficiency Total'] = 'Budget Deficiency Total';
$lang['Budget Varience Total'] = 'Budget Varience Total';
$lang['All Programs of All Locations '] = 'All Programs of All Locations ';
$lang['Program Progress in Terms of Budget'] = 'Program Progress in Terms of Budget';
$lang['Program Progress in Terms of Activity Completion'] = 'Program Progress in Terms of Activity Completion';
$lang['Donation Reports Help'] = 'Donation Reports Help';
$lang['Download Donation Reports Help User Guide'] = 'Download Donation Reports Help User Guide';


/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////  Production Manager  ////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
