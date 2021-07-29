<?php

/**
 *  Red Cherries Accounting is a web based accounting software solution 
 *  for Small and Medium Enterprices (SME) to manage financial information. 
 *  Copyright (C) 2020  Artifectx Solutions (Pvt) Ltd
 *
 *  This program is free software: you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation, either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  This program is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  You should have received a copy of the GNU General Public License
 *  along with this program.  If not, see <https://www.gnu.org/licenses/>.
 */

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
		
        $this->load->library('phpmailer_lib');
        
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
			$msg .= $message;
			$msg .= "<br><br>";
			$msg .='<table style="font-family: ambleregular, sans-serif; color:#fff" cellspacing=4 cellpadding=4 width="100%">
						<tr>
							<td bgcolor="#ff9999" colspan="3" style="text-align:center;">
								<h3 align="center" style="font-family: ambleregular, sans-serif;">
									<strong>Artifectx Red Cherries Accounting - Free and Open Source Online Accounts Management Software</strong>
								</h3>
							</td>
						</tr>
						<tr>
							<td bgcolor="#eafaea" colspan="3" style="text-align:center; color:#00acec;">
								<h4 align="center" style="font-family: ambleregular, sans-serif;">
									Simple yet powerful accounts management solution from Artifectx. Manage your 
									accounting information effectively and more support available to configure the system to fulfil your actual requirements. 
								</h4>
							</td>
						</tr>
						<tr>
							<td bgcolor="#ff9999" style="font-weight: bold; text-align:center; font-size:14px;" width="30%">
								Module
							</td>
							<td bgcolor="#ff9999" style="font-weight: bold; text-align:center; font-size:14px" width="40%">
								Details
							</td>
						</tr>
						<tr>
							<td style="font-family: ambleregular, sans-serif; color:#000; background-color:#eafaea; font-size:12px">
								Organization
							</td>
							<td style="font-family: ambleregular; color:#000; background-color:#eafaea;font-size:12px">
								Allows to manage company locations, people, company basic information and company structure. 
                                The information adding under this module is common to the other modules of Red Cherries Accounting.
							</td>
						</tr>
						<tr>
							<td style="font-family: ambleregular; color:#000; background-color:#eafaea;font-size:12px">
								Service Manager
							</td>
							<td style="font-family: ambleregular; color:#000; background-color:#eafaea;font-size:12px">
								Allows to manage services information of an organization. Donation management service is available and more 
                                services related requirements can be implemented as sub modules.
							</td>
						</tr>
						<tr>
							<td style="font-family: ambleregular; color:#000; background-color:#eafaea;font-size:12px">
								Accounts Manager
							</td>
							<td style="font-family: ambleregular; color:#000; background-color:#eafaea;font-size:12px">
								Allows to create chart of account structure and create prime entry books. Journal entries can be added for a financial 
                                year and if required based on locations. Supplier purchasing and customer sales information and their respective return 
                                information can be added. Payments can be added as cash, cheques and credit cards. Cheques can be handled in the system 
                                very easily. Trial balance, balance sheet and profit and loss accounts can be generated as reports with different search options.
							</td>
						</tr>
						<tr>
							<td style="font-family: ambleregular; color:#000; background-color:#eafaea;font-size:12px">
								User Role Manager
							</td>
							<td style="font-family: ambleregular; color:#000; background-color:#eafaea;font-size:12px">
								Admin and a normal user role available with default user role permissions. New users can be created for type of admin or 
                                normal user. When required additional user roles can be created with custom permissions and can be assigned to users. 
                                Complete language pack is available so that language translations can be added easily.
							</td>
						</tr>

						<tr>
							<td colspan="3"><hr style="border-top: 2px solid #ff9999;"></td>
						</tr>

						<tr>
							<td colspan="3">
								<h2 align="center" style="font-family: ambleregular, sans-serif; color:#00acec; font-size:18px">
									<strong>Support & Updates</strong>
								</h2>
							</td>
						</tr>
						<tr>
							<td colspan="3">
								<h4 align="center" style="font-family: ambleregular, sans-serif; color:#00acec; font-size:12px">
									<strong>
										We offer training and cloud hosting services for our valuable customers. Please contact us for more information.<br><br>
									</strong>
								</h4>
							</td>
						</tr>
						<tr>
							<td colspan="3"><hr style="border-top: 2px solid #ff9999;"></td>
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
							<td colspan="3"><hr style="border-top: 2px solid #ff9999;"></td>
						</tr>
						<tr>
							<td bgcolor="#ff9999" colspan="3">
								<h4 align="center" style="font-family: ambleregular, sans-serif;">
									<strong>
										Artifectx Solutions : The best place to get a quality software solution for your business requirements...
									</strong>
								</h4>
							</td>
						</tr>
					</table>';

            //Please add your from email account
			$from = "";
			$name = "Artifectx Red Cherries Accounting";
			$subject = "Red Cherries Accounting By Artifectx - Free and Open Source Online Accounts Management Software";
            
            $mail = $this->phpmailer_lib->load();

            try {
                //Server settings
                $mail->isSMTP();                                            // Send using SMTP
                //Please add your SMTP server
                $mail->Host       = '';                                     // Set the SMTP server to send through
                $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
                //Please add your SMTP username
                $mail->Username   = '';                                     // SMTP username
                //Please add your SMTP password
                $mail->Password   = '';                                     // SMTP password
                $mail->SMTPSecure = 'ssl';                                  // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
                $mail->Port       = 465;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

                //Recipients
                $mail->setFrom($from, $name);
                $mail->addAddress($this->db->escape_str($this->input->post('email')));     // Add a recipient
                //$mail->addAddress('ellen@example.com');                   // Name is optional
                //$mail->addReplyTo('info@example.com', 'Information');
                //$mail->addCC('cc@example.com');
                //$mail->addBCC('bcc@example.com');

                // Attachments
                //$mail->addAttachment('/var/tmp/file.tar.gz');             // Add attachments
                //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');        // Optional name

                // Content
                $mail->isHTML(true);                                        // Set email format to HTML
                $mail->Subject = $subject;
                $mail->Body    = $msg;
                //$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

                $mail->send();
                
                echo 'ok';
            } catch (Exception $e) {
                echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
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
