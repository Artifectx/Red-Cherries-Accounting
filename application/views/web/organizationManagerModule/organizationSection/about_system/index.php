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
?>

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
                                                <?php echo $this->lang->line('Best online accounting management solution from Artifectx Solutions.') ?>
                                            </strong>
                                        </p>-->
                                        <div class='form-group'>
                                            <label class='control-label col-sm-12' style='text-align: center; font-size: 20px; color: #598af3;'>
                                                <?php echo $this->lang->line('Best online accounting management solution from Artifectx Solutions.') ?>
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
                                                        <?php echo $this->lang->line('Allows to manage company locations, people, company basic information and company structure. The information adding under this module is common to the other modules of Red Cherries Accounting.');?>
                                                    </li>

                                                    <br>
                                                    <h5><?php echo $this->lang->line('Service Manager') ?></h5>
                                                    <li  class="list-group-item" style='margin-top:20px;'>
                                                        <?php echo $this->lang->line('Allows to manage services information of an organization. Donation management service is available and more services related requirements can be implemented as sub modules.') ?>
                                                    </li>
                                                    
                                                    <br>
                                                    <h5><?php echo $this->lang->line('Accounts Manager') ?></h5>
                                                    <li  class="list-group-item" style='margin-top:20px;'>
                                                        <?php echo $this->lang->line('Allows to create chart of account structure and create prime entry books. Journal entries can be added for a financial year and if required based on locations. Supplier purchasing and customer sales information and their respective return information can be added. Payments can be added as cash, cheques and credit cards. Cheques can be handled in the system very easily. Trial balance, balance sheet and profit and loss accounts can be generated as reports with different search options.') ?>
                                                    </li>
                                                    
                                                    <br>
                                                    <h5><?php echo $this->lang->line('User Role Manager') ?></h5>
                                                    <li  class="list-group-item" style='margin-top:20px;'>
                                                        <?php echo $this->lang->line('Admin and a normal user role available with default user role permissions. New users can be created for type of admin or normal user. When required additional user roles can be created with custom permissions and can be assigned to users. Complete language pack is available so that language translations can be added easily.');?>
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
                                                    <h5><?php echo $this->lang->line('For more info contact : ') ?></h5>
                                                    <li  class="list-group-item">
                                                        Sam : +94-77-9738068 <br>
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
