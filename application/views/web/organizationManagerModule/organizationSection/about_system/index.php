<section id='content'>
    <div class='container'>
        <div class='row' id='content-wrapper'>
            <div class='col-xs-12'>
                <div class='row'>
                    <div class='col-sm-12'>
                        <div class='page-header'>
                            <h1 class='pull-left'>
                                <i class='icon-table'></i>
                                <span><?php echo $this->lang->line('About Red Cherries Accounting') ?></span>
                            </h1>

                            <div class='pull-right'></div>
                        </div>
                    </div>
                </div>
                
                <div class='row'>
                    <div class='col-sm-12'>
                        <div class='box'>
                            <div class='box-header <?php echo BOXHEADER; ?>-background'>
                                <div class='title'><?php echo $this->lang->line('Red Cherries Accounting Overview') ?></div>
                                <div class='actions'>
                                    <a class="btn box-collapse btn-xs btn-link" href="#"><i></i>
                                    </a>
                                </div>
                            </div>
                            <!--Showing messages-->

                            <div class='box-content'>
                                <form class='form form-horizontal validate-form save_form' method="post">
                                    <div class='box-content light_color_background'>
<!--                                        <p class="text-info" align="left" style='font-size:20px; margin-top:20px; margin-left:240px; margin-bottom:20px;'>
                                            <strong>
                                                <?php echo $this->lang->line('Best online ERP solution from Artifectx Solutions.') ?>
                                            </strong>
                                        </p>-->
                                        <div class='form-group'>
                                            <label class='control-label col-sm-12' style='text-align: center; font-size: 20px; color: #598af3;'>
                                                <?php echo $this->lang->line('Best online ERP solution from Artifectx Solutions.') ?>
                                            </label>
                                        </div>
                                        <div class='form-group'>
                                            <label class='control-label col-sm-3' style='margin-top:-8px;'><h5><?php echo $this->lang->line('Current Version : ') ?></h5> </label>
                                            <div class='col-sm-6 controls'>
                                                <ul class="list-group">
                                                    <h5><?php echo $version_no; ?></h5>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class='form-group'>
                                            <label class='control-label col-sm-3' style='margin-top:-8px;'><h5><?php echo $this->lang->line('System Modules : ') ?></h5> </label>

                                            <div class='col-sm-6 controls'>
                                                <ul class="list-group">
                                                    <h5><?php echo $this->lang->line('Organization') ?></h5>
                                                    <li class="list-group-item" style='margin-top:20px;'>
                                                        <?php echo $this->lang->line('Allows to manage company locations, people, company basic information and company '
                                                                . 'structure. The information adding under this module is common to the other modules of Red Cherries Accounting. Module is '
                                                                . 'completely implemented and available in version 5.0 Beta 1');?>
                                                    </li>

                                                    <br>
                                                    <h5><?php echo $this->lang->line('Stock Manager') ?></h5>
                                                    <li  class="list-group-item" style='margin-top:20px;'>
                                                        <?php echo $this->lang->line('This module consists of five sections called "Administration", "Finished Good Inventory", "Raw Material Inventory", '
                                                                                   . '"Sales" and "Reports". The "Administration" section allows to manage warehouses, unit and unit conversions, tax details, '
                                                                                   . 'vehicles, delivery routes and system configurations. System configurations allow to configure the system for '
                                                                                   . 'different behaviors. "Finished Good Inventory" and "Raw Material Inventory" allows to manage finished good and raw material '
                                                                                   . 'stock respectively. System allows to manage warehouse and lorry stock with different transactions. "Sales" section allows '
                                                                                   . 'to manage sales invoices and sales returns. "Reports" section allows to generate different types of reports for '
                                                                                   . 'stock balances, transactions, sales and sales returns. Module is completely implemented and available in version 5.0 Beta 1');?>
                                                    </li>

                                                    <br>
                                                    <h5><?php echo $this->lang->line('Production Manager') ?></h5>
                                                    <li  class="list-group-item" style='margin-top:20px;'>
                                                        <?php echo $this->lang->line('Allows to manage the process of producing finished goods in a production line. Careful monitoring of raw materials issued to production line '
                                                                                   . 'and exact usage and calculate final product cost considering other costing parameters is handled in this module. Module provides variation '
                                                                                   . 'reports to evaluate the efficiency of production line thereby adjusting parameters to fine tune the efficiency and minimize loses. '
                                                                                   . 'Initial module implementation is completed and is available in version 6.0. Further development of remaining features will be available in future versions.');?>
                                                    </li>

                                                    <br>
                                                    <h5><?php echo $this->lang->line('HR Manager') ?></h5>
                                                    <li class="list-group-item" style='margin-top:20px;'>
                                                        <?php echo $this->lang->line("All employees personal details and job details can be maintained in the system. Module has features to track employee attendance "
                                                                                   . "details and employee leave application details. Further it allows to evaluate employee performance and employee on boarding and "
                                                                                   . "off bording details. Initial module implementation is completed and is available in version 6.0. Further development of remaining features will be available in future versions.") ?>
                                                    </li>
                                                    
                                                    <br>
                                                    <h5><?php echo $this->lang->line('Payroll Manager') ?></h5>
                                                    <li class="list-group-item" style='margin-top:20px;'>
                                                        <?php echo $this->lang->line("Employee salary details can be maintained in this module. Different types of earnings and deductions can be added and payroll process "
                                                                                   . "can be done by generating a salary payment detail script for banks. Module implementation will be completed in version 8.0") ?>
                                                    </li>
                                                    
                                                    <br>
                                                    <h5><?php echo $this->lang->line('Service Manager') ?></h5>
                                                    <li  class="list-group-item" style='margin-top:20px;'>
                                                        <?php echo $this->lang->line('Allows to manage donations, reserve services(Including reserving rooms/halls etc.), trainings and other types of services. Reservations can be seen on a calendar. '
                                                                                   . 'Further, module has features to collect advance payments and collect final payments. Initial module implementation is completed and is available in version 6.0. Further development of remaining features will be available in future versions.') ?>
                                                    </li>
                                                    
                                                    <br>
                                                    <h5><?php echo $this->lang->line('Accounts Manager') ?></h5>
                                                    <li  class="list-group-item" style='margin-top:20px;'>
                                                        <?php echo $this->lang->line('Allows to create a chart of account structure and create prime entry books. Journal entries can be added for a financial year and if required '
                                                                                   . 'based on locations. Trial balance, balance sheet and profit and lose accounts can be generated as reports with different search options. Module is completely integrated with Stock Manager and Production Manager modules.'
                                                                                   . ' Initial module implementation is completed and is available in version 5.0 Beta 8. Further development of remaining features will be available in future versions.') ?>
                                                    </li>
                                                    
                                                    <br>
                                                    <h5><?php echo $this->lang->line('User Role Manager') ?></h5>
                                                    <li  class="list-group-item" style='margin-top:20px;'>
                                                        <?php echo $this->lang->line('Admin and a normal user roles available with default user role permissions. New users can be created for type of admin or normal user. When required '
                                                                                   . 'additional user roles can be created with custom permissions and can be assigned to users. Module is completely implemented and available '
                                                                                   . 'in version 5.0 Beta 1');?>
                                                    </li>

                                                    <br>
                                                    <h5><?php echo $this->lang->line('Support & Updates') ?></h5>
                                                    <li  class="list-group-item" style='margin-top:20px;'>
                                                        <?php echo $this->lang->line('World Class Support') ?>
                                                    </li>
                                                    <li  class="list-group-item"'>
                                                        <?php echo $this->lang->line('Comprehensive User Guides') ?>
                                                    </li>
                                                    <li class="list-group-item">
                                                        <?php echo $this->lang->line('Live Chat, Phone, Email') ?>
                                                    </li>
                                                    <br>
                                                    <h5><?php echo $this->lang->line('Latest Updates') ?></h5>
                                                    <li  class="list-group-item">
                                                        For latest feature updates and more information, please refer our web site and live demo. <br><br>
                                                        
                                                        Web Site : <a target = '_blank' href="<?php echo 'https://www.e-erplanner.com/'; ?>">www.e-erplanner.com</a><br><br>
                                                        
                                                        Demo : <a target = '_blank' href="<?php echo 'https://demo.e-erplanner.com/'; ?>">demo.e-erplanner.com</a><br>
                                                        Username/Password : admin/demo@eerplan <br><br>
                                                        Keep your system upto date with latest system features. Contact us to upgrade your system free of charge.
                                                    </li>
                                                    <br>
                                                    <h5><?php echo $this->lang->line('For more info contact : ') ?></h5>
                                                    <li  class="list-group-item">
                                                        Sam : +94-77-9738068 <br>
                                                        Mike : +94-77-9089655 <br>
                                                        web : <a target = '_blank' href="<?php echo 'https://www.artifectx.com'; ?>">www.artifectx.com</a><br>
                                                        Email : contact.artifectx@gmail.com
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                        
                                        <div class='msg_data'></div>
                                        <div class='validation'></div>
                                        
                                        <div class='form-group'>
                                            <label class='control-label col-sm-12' style='text-align: center; font-size: 15px; color: #598af3;'>
                                                <?php echo $this->lang->line('Tell about Red Cherries Accounting to a friend') ?>
                                            </label>
                                        </div>
                                        <div class='form-group'>
                                            <label class='control-label col-sm-3'><?php echo $this->lang->line('Message') ?></label>

                                            <div class='col-sm-6 controls'>
                                                <textarea rows="10" class='form-control' id='message' name='message'
                                                    placeholder='<?php echo $this->lang->line('Message') ?>'><?php echo set_value('message'); ?>
                                                </textarea>
                                            </div>
                                        </div>

                                        <div class='form-group'>
                                            <label class='control-label col-sm-3'><?php echo $this->lang->line('E-mail') ?> *</label>

                                            <div class='col-sm-4 controls'>
                                                <input class='form-control'  id='email'
                                                       name='email' placeholder='<?php echo $this->lang->line("E-mail address of your friend") ?>' type='text' value="<?php echo set_value('email'); ?>">
                                                <div id="emailError" class="red"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class='form-actions' style='margin-bottom:0'>
                                        <div class='row'>
                                            <div class='col-sm-9 col-sm-offset-3'>
                                                <button class='btn btn-success save' type='button' onclick='sendData();'>
                                                    <i class='icon-save'></i>
                                                    <?php echo $this->lang->line('Send') ?>
                                                </button>


                                                <button class='btn btn-primary' type='reset'>
                                                    <i class='icon-undo'></i>
                                                    <?php echo $this->lang->line('Refresh') ?>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    
                                </form>
                                <!--edit form-->
                                <div class='edit_form'></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

<script src="<?php echo base_url(); ?>ajax/jquery.js"></script>
<script src="<?php echo base_url(); ?>ajax/validate.js"></script>
<script>
    
    $(document).ready(function () {
        $("#message").val('');
    });
    
    function sendData(){
        if (validateForm()) {
            var msg = '<div class="alert alert-success alert-dismissable">' +
                '<a class="close" href="#" data-dismiss="alert">x </a>' +
                '<h4><i class="icon-ok-sign"></i>' +
                '<?php echo $this->lang->line('success')?></h4>' +
                '<?php echo $this->lang->line('success_sent')?>' +
                '</div>';
            $.ajax({
                type: "POST",
                url: "<?php echo base_url(); ?>organizationManagerModule/organizationSection/about_system_controller/send",
                data: {
                    'message' : $("#message").val().trim(),
                    'email': $("#email").val(),
                    '<?php echo $this->security->get_csrf_token_name(); ?>':
                        '<?php echo $this->security->get_csrf_hash(); ?>'
                },
                dataType: 'html',
                beforeSend: function () {
                    $(".save:input").attr('disabled', true);
                },
                success: function (responce) {
                    if (responce == 'ok') {
                        $(".validation").hide();
                        $(".msg_data").show();
                        $(".msg_data").html(msg);
                        $(".save:input").attr('disabled', false);
                        $("#email").val('');
                    }
                    else {
                        $(".msg_data").hide();
                        $(".validation").show();
                        $(".validation").html(responce);
                        $(".save:input").attr('disabled', false);
                    }
                }
            })
            $("#message").val('');
        }
    }

    //form validation
    function validateForm() {
        return (isValidEmail("email", "<?php echo $this->lang->line('E-mail').' '.$this->lang->line('field is required')?>")
        );
    }
</script>
