<?php
ob_start();
defined('BASEPATH') OR exit('No direct script access allowed');

class About_system_controller extends CI_Controller {

	public function  __construct() {
		parent::__construct();
		$this->load->library('user_library/User_management');

		$this->userManagement = new User_management();

		//check user login
		$this->userManagement->checkUserLogin();

		//get user id
		$this->user_id = $this->userManagement->getUserId();

		//current date time
		$this->date = date("Y-m-d H:i");

		//load language
		$language = $this->userManagement->getUserLanguage($this->user_id);

		$this->lang->load('form_lang', $language);
		$this->lang->load('message', $language);

		//get user theme
		$this->data['theme'] = $this->userManagement->getUserTheme($this->user_id);

		//get user permission
		$this->data = $this->userManagement->getUserPermissions($this->data);

		//Load version number
		$this->data['version_no'] = $this->userManagement->getSystemVersionNumber();

		$this->data['show_footer'] = true;

		//load models
		$this->load->model('userRoleManagerModule/user_model', '', TRUE);
		$this->load->model('systemManagerModule/system_configurations_model', '', TRUE);
		$this->load->model('systemManagerModule/common_model', '', TRUE);
		$this->load->model('organizationManagerModule/adminSection/google_analytics_model', '', TRUE);
		
		$menuFormatting = '';
		if ($language == "sinhala") {
			$menuFormatting = 'style="font-weight: bold;"';
		}
		
		$this->data['menuFormatting'] = $menuFormatting;
	}

	public function index() {
		$this->setSystemModulesHeaderTitle();
		//Get system module header
		$this->data['dataSystemModules'] = $this->common_model->getSystemModulesHeaderTitle();
		$this->data['defaultSystemModule'] = $this->userManagement->getUserDefaultSystemModule($this->user_id);
		
		$data_cls['systemConfigData'] = $this->getSystemConfigData();

		$this->load->view('web/systemManagerModule/header/header', $this->data);
		$this->load->view('web/systemManagerModule/dashboard/menu_organization_manager', $data_cls);
		$this->load->view('web/organizationManagerModule/organizationSection/about_system/index');
		$this->load->view('web/systemManagerModule/footer/footer', $this->data);

	}

	public function setSystemModulesHeaderTitle() {

		$dataSystemModule = $this->common_model->getSystemModulesHeaderTitle();

		if($dataSystemModule != null) {
			$systemModules = array(
				'system_module' =>  "Organization",
				'dashboard_url' => "systemManagerModule/dashboard_controller/organizationManager"
			);

			$this->common_model->setSystemModulesHeaderTitle($this->user_id, $systemModules);
		} else {
			$systemModules = array(
				'system_module' => "Organization",
				'dashboard_url' => "systemManagerModule/dashboard_controller/organizationManager",
				'user_id' => $this->user_id
			);

			$this->common_model->addSystemModulesHeaderTitle($systemModules);
		}
	}

	public function send(){
		if($this->form_validation->run() == FALSE){
			echo validation_errors('<div class="alert alert-danger alert-dismissable">
										<a class="close" data-dismiss="alert" href="#">&times;</a>
										<h4><i class="icon-remove-sign"></i>Error</h4>',
				'</div>');
		} else {

			$baseURL = base_url();
			$message = $this->db->escape_str($this->input->post('message'));
			$message = preg_replace('~\\\n~',"<br>", $message);

			$msg='';
			$html='';
			$html.='';
			$from = "sendartifectxmail.gmail.com";
			$name = "Artifectx Red Cherries Accounting";
			$sub = "Red Cherries Accounting By Artifectx - Online Enterprise Resource Management Software";
			$msg .= $message;
			$msg .= "<br><br>";
			$msg .='<table style="font-family: ambleregular, sans-serif; color:#fff" cellspacing=4 cellpadding=4 width="100%">
						<tr>
							<td bgcolor="#00cc30" colspan="3" style="text-align:center;">
								<h3 align="center" style="font-family: ambleregular, sans-serif;">
									<strong>Artifectx Red Cherries Accounting - Online Enterprise Resource Management Software</strong>
								</h3>
							</td>
						</tr>
						<tr>
							<td bgcolor="#eafaea" colspan="3" style="text-align:center; color:#00acec;">
								<h4 align="center" style="font-family: ambleregular, sans-serif;">
									Simple yet powerful ERP solution from Artifectx. Manage your 
									enterprice information effectively and more support available to configure the system to fulfil your actual requirements. 
									Checkout our live demo for system features and visit our 
									Red Cherries Accounting web site https://www.e-erplanner.com for more information.
								</h4>
							</td>
						</tr>
						<tr>
							<td bgcolor="#eafaea" colspan="3" style="text-align:center; color:#00acec;">
								<strong>Online Demo : </strong>https://demo.e-erplanner.com
							</td>
						</tr>
						<tr>
							<td bgcolor="#eafaea" colspan="3" style="text-align:center; color:#00acec;">
								<strong>Username : </strong>admin / Password : demo@eerplan
							</td>
						</tr>
						<tr>
							<td bgcolor="#eafaea" colspan="3" style="text-align:center;">
								<strong style="color:#ff33cc;">
									Select the modules you need and pay only for selected modules.
								</strong>
							</td>
						</tr>
						<tr>
							<td bgcolor="#00cc30" style="font-weight: bold; text-align:center; font-size:14px;" width="30%">
								Module
							</td>
							<td bgcolor="#00cc30" style="font-weight: bold; text-align:center; font-size:14px" width="40%">
								Details
							</td>
						</tr>
						<tr>
							<td style="font-family: ambleregular, sans-serif; color:#000; background-color:#eafaea; font-size:12px">
								Organization
							</td>
							<td style="font-family: ambleregular; color:#000; background-color:#eafaea;font-size:12px">
								Allows to manage company locations, people, company basic information and company 
								structure. The information adding under this module is common to the other modules of Red Cherries Accounting. Module is 
								completely implemented and available in version 4.0 Beta 1.
							</td>
						</tr>
						<tr>
							<td style="font-family: ambleregular; color:#000; background-color:#eafaea;font-size:12px">
								Stock Manager
							</td>
							<td style="font-family: ambleregular; color:#000; background-color:#eafaea;font-size:12px">
								This module consists of five sections called "Administration", "Finished Good Inventory", "Raw Material Inventory", 
								"Sales" and "Reports". The "Administration" section allows to manage warehouses, unit and unit conversions, tax details, 
								vehicles, delivery routes and system configurations. System configurations allow to configure the system for 
								different behaviors. "Finished Good Inventory" and "Raw Material Inventory" allows to manage finished good and raw material 
								stock respectively. System allows to manage warehouse and lorry stock with different transactions. "Sales" section allows 
								to manage sales invoices and sales returns. "Reports" section allows to generate different types of reports for 
								stock balances, transactions, sales and sales returns. Module is completely implemented and available in version 4.0 Beta 1.
							</td>
						</tr>
						<tr>
							<td style="font-family: ambleregular; color:#000; background-color:#eafaea;font-size:12px">
								Production Manager
							</td>
							<td style="font-family: ambleregular; color:#000; background-color:#eafaea;font-size:12px">
								Allows to manage the process of producing finished goods in a production line. Careful monitoring of raw materials issued to production line 
								and exact usage and calculate final product cost considering other costing parameters is handled in this module. Module provides variation 
								reports to evaluate the efficiency of production line thereby adjusting parameters to fine tune the efficiency and minimize loses. 
								Initial module implementation is completed and is available in version 6.0. Further development of remaining features will be available in future versions.
							</td>
						</tr>
						<tr>
							<td style="font-family: ambleregular; color:#000; background-color:#eafaea;font-size:12px">
								HR Manager
							</td>
							<td style="font-family: ambleregular; color:#000; background-color:#eafaea;font-size:12px">
								All employees personal details and job details can be maintained in the system. Module has features to track employee attendance 
								details and employee leave application details. Further it allows to evaluate employee performance and employee on boarding and 
								off bording details. Initial module implementation is completed and is available in version 6.0. Further development of remaining features will be available in future versions.
							</td>
						</tr>
						<tr>
							<td style="font-family: ambleregular; color:#000; background-color:#eafaea;font-size:12px">
								Payroll Manager
							</td>
							<td style="font-family: ambleregular; color:#000; background-color:#eafaea;font-size:12px">
								Employee salary details can be maintained in this module. Different types of earnings and deductions can be added and payroll process 
								can be done by generating a salary payment detail script for banks. Module implementation will be completed in version 8.0.
							</td>
						</tr>
						<tr>
							<td style="font-family: ambleregular; color:#000; background-color:#eafaea;font-size:12px">
								Service Manager
							</td>
							<td style="font-family: ambleregular; color:#000; background-color:#eafaea;font-size:12px">
								Allows to manage donations, reserve services(Including reserving rooms/halls etc.), trainings and other types of services. Reservations can be seen on a calendar. 
								Further, module has features to collect advance payments and collect final payments. Initial module implementation is completed and is available in version 6.0. Further development of remaining features will be available in future versions.
							</td>
						</tr>
						<tr>
							<td style="font-family: ambleregular; color:#000; background-color:#eafaea;font-size:12px">
								Accounts Manager
							</td>
							<td style="font-family: ambleregular; color:#000; background-color:#eafaea;font-size:12px">
								Allows to create a chart of account structure and create prime entry books. Journal entries can be added for a financial year and if required 
								based on locations. Trial balance, balance sheet and profit and lose accounts can be generated as reports with different search options. Module is completely integrated with Stock Manager and Production Manager modules.
								Initial module implementation is completed and is available in version 4.0. Further development of remaining features will be available in future versions.
							</td>
						</tr>
						<tr>
							<td style="font-family: ambleregular; color:#000; background-color:#eafaea;font-size:12px">
								User Role Manager
							</td>
							<td style="font-family: ambleregular; color:#000; background-color:#eafaea;font-size:12px">
								Admin and a normal user roles available with default user role permissions. New users can be created for type of admin or normal user. When required 
								additional user roles can be created with custom permissions and can be assigned to users. Module is completely implemented and available 
								in version 4.0 Beta 1.
							</td>
						</tr>

						<tr>
							<td colspan="3"><hr style="border-top: 2px solid #00cc30;"></td>
						</tr>

						<tr>
							<td colspan="3">
								<h2 align="center" style="font-family: ambleregular, sans-serif; color:#00acec; font-size:18px">
									<strong>Price Details</strong>
								</h2>
							</td>
						</tr>
						<tr>
							<td colspan="3">
								<h4 align="center" style="font-family: ambleregular, sans-serif; color:#ff9900; font-size:14px">
									<strong>Software Price</strong>
								</h4>
							</td>
						</tr>
						<tr>
							<td colspan="3">
								<h4 align="center" style="font-family: ambleregular, sans-serif; color:#00acec; font-size:12px">
									Software price is based on module selection.
									Visit Red Cherries Accounting web site https://www.e-erplanner.com and request a quote for your selected modules.
									<strong style="color:#ff33cc;">
										Lifetime license with no yearly subscription fee.
									</strong>
								</h4>
							</td>
						</tr>
						<tr>
							<td colspan="3">
								<h4 align="center" style="font-family: ambleregular, sans-serif; color:#ff9900; font-size:14px">
									<strong>Support Service Package</strong>
								</h4>
							</td>
						</tr>
						<tr>
							<td colspan="3">
								<h4 align="center" style="font-family: ambleregular, sans-serif; color:#00acec; font-size:12px">
									To get more advanced support, we offer you a one year support service package. 
									The package includes three major new feature development requests (A major feature is an estimation
									of 40 engineering hours from development, quality assurance and project management) and one formal 
									training program. Additional new feature requests will be implemented with software cost estimations 
									which will not cover with support service package.
								</h4>
							</td>
						</tr>
						<tr>
							<td colspan="3"><hr style="border-top: 2px solid #00cc30;"></td>
						</tr>

						<tr>
							<td colspan="3">
								<h2 align="center" style="font-family: ambleregular, sans-serif; color:#00acec; font-size:18px">
									<strong>Free Support & Updates</strong>
								</h2>
							</td>
						</tr>
						<tr>
							<td colspan="3">
								<h4 align="center" style="font-family: ambleregular, sans-serif; color:#00acec; font-size:12px">
									<strong>
										We offer trainings (At the time of initial deployment) and user guides for each of system module sections. 
										User guides are included in the system so that users can download.<br><br>You will get unlimited free 
										upgrades for latest releases. We encourage you to keep your system upgraded to the latest version so 
										that you will get new features and bug fixes for already identified issues.<br><br>
									</strong>
								</h4>
							</td>
						</tr>
						<tr>
							<td colspan="3"><hr style="border-top: 2px solid #00cc30;"></td>
						</tr>
						 <tr>
							<td colspan="3">
								<h2 align="center" style="font-family: ambleregular, sans-serif; color:#00acec; font-size:18px">
									<strong>For more info contact</strong>
								</h2>
							</td>
						</tr>
						<tr>
							<td colspan="3" align="center">
								<table border="1">
									<tr>
										<td style="text-align:center; color:#00acec; width:160px;">Sam (Primary Contact)</td>
										<td style="text-align:center; color:#49bf67; width:160px;">+94-77-9738068</td>
									</tr>
									<tr>
										<td style="text-align:center; color:#00acec;">Mike (Secondary Contact)</td>
										<td style="text-align:center; color:#49bf67;">+94-77-9089655</td>
									</tr>
									<tr>
										<td style="text-align:center; color:#00acec;">Web</td>
										<td style="text-align:center; color:#49bf67;">https://www.artifectx.com</td>
									</tr>
									<tr>
										<td style="text-align:center; color:#00acec;">Email</td>
										<td style="text-align:center; color:#49bf67;">sales.artifectx@gmail.com</td>
									</tr>
								</table>
							</td>

						</tr>
						<tr>
							<td colspan="3"><hr style="border-top: 2px solid #00cc30;"></td>
						</tr>
						<tr>
							<td bgcolor="#00cc30" colspan="3">
								<h4 align="center" style="font-family: ambleregular, sans-serif;">
									<strong>
										Artifectx Solutions : The best place to get a quality software solution for your business requirements...
									</strong>
								</h4>
							</td>
						</tr>
					</table>';

			//<td align="center"><img src="'.$baseURL.'assets/images/help.jpeg"/></td>
			//<td align="center"><img src="'.$baseURL.'assets/images/configure.png"/></td>

			$config = array();
			$config['useragent']           = "CodeIgniter";
			//$config['mailpath']            = "C:\xampp\mailtodisk\mailtodisk.exe"; // or "/usr/sbin/sendmail"
			$config['mailpath']            = "/usr/sbin/sendmail";
			$config['protocol']            = "smtp";
			$config['smtp_host']           = "ssl://smtp.gmail.com";
			$config['smtp_user']           = "sendartifectxmail@gmail.com";
			$config['smtp_pass']           = "CakckArtifectx123";
			$config['smtp_port']           = "465";
			$config['mailtype'] = 'html';
			$config['charset']  = 'iso-8859-1';
			$config['wordwrap'] = TRUE;

			/*$config = array();
			$config['useragent']           = "CodeIgniter";
			$config['mailpath']            = "C:\xampp\mailtodisk\mailtodisk.exe"; // or "/usr/sbin/sendmail"
			$config['protocol']            = "smtp";
			$config['smtp_host']           = "mail.artifectx.com";
			$config['smtp_user']           = "info@artifectx.com";
			$config['smtp_pass']           = "Cakck@20562060";
			$config['smtp_port']           = "25";
			$config['mailtype'] = 'html';
			$config['charset']  = 'iso-8859-1';
			$config['wordwrap'] = TRUE;*/


			$this->load->library('email',$config);

			$this->email->initialize($config);

			$this->email->set_newline("\r\n");

			$this->email->from($from, $name);
			$this->email->to($this->db->escape_str($this->input->post('email')));
			$this->email->subject($sub);
			$this->email->message($msg);
			if (!$this->email->send()) {
				echo $this->email->print_debugger();

			} else{
				echo 'ok';
			}
		}
	}
	
	public function getSystemConfigData() {
		$configurations = $this->system_configurations_model->getSystemConfigData();

		$configData = array();
		foreach ($configurations as $configuration) {
			$configData[$configuration->config_filed_name] = $configuration->config_filed_value;
		}
		
		return $configData;
	}
}
