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
                                <span><?php echo $this->lang->line('System Module Section Details') ?></span>
                            </h1>

                            <div class='pull-right'></div>
                        </div>
                    </div>
                </div>

                <div id='table'>
                    <div class="msg_delete"></div>
                    <div class='row'>
                        <div class='col-sm-12'>
                            <div class='box bordered-box <?php echo BOXHEADER; ?>-border' style='margin-bottom:0;'>
                                
                                <div class='loader' align="center"><img src="<?php echo base_url();?>assets/images/ajax-loader.gif"/> Loading data...</div>

                                <!--showing tabale-->
                                <div id="dataTable">
                                </div>
                                <!--end table -->

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
                getTableData();
                Modules.init();
            });

            $(".new").click(function () {
                $(".msg_data").hide();
                $(".msg_delete").hide();
                $(".validation").hide();
                $(".form").show();
                $(".edit_form").hide();

            });

            function cancelData() {
                Modules.cancelData();
            }

            function saveData() {
                if($("#module_section_name").val() == '')validateForm_save();
                else {
                    Modules.saveData();
                }
            }

            function editData() {
                if($("#module_section_name_edit").val() == '')validateForm_edit();
                else {
                    Modules.editData();
                }
            }

            function get(id){
                $(".loader").show();
                $(".msg_data").hide();
                $(".msg_delete").hide();
                $(".validation").hide();
                Modules.getData(id);
            }

            function del(id){
                $(".msg_data").hide();
                $(".msg_delete").hide();
                $(".validation").hide();
                Modules.deleteData(id);
            }

            function changeStatus(moduleSectionId, moduleSectionStatus){
                /*alert(moduleId);
                alert(moduleStatus);*/
                Modules.changeStatus(moduleSectionId, moduleSectionStatus);
            }

            var Modules = {

                cancelData: function () {
                    $(".form").hide();
                },

                saveData: function () {
                    var msg = '<div class="alert alert-success alert-dismissable">' +
                        '<a class="close" href="#" data-dismiss="alert">x </a>' +
                        '<h4><i class="icon-ok-sign"></i>' +
                        '<?php echo $this->lang->line('success')?></h4>' +
                        '<?php echo $this->lang->line('success_saved')?>' +
                        '</div>';//alert('Test 2');
                    $.ajax({
                        type: "POST",
                        url: "<?php echo base_url(); ?>userRoleManagerModule/productInformationSection/system_module_sections_controller/add",
                        data: {
                            'module_section_name': $("#module_section_name").val(),
                    <?php echo $this->security->get_csrf_token_name(); ?>:'<?php echo $this->security->get_csrf_hash(); ?>'
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

                        $(".form").hide();
                        $(".edit_form").hide();

                        clearForm();
                        getTableData();
                    }
                    else {
                        $(".msg_data").hide();
                        $(".validation").show();
                        $(".validation").html(responce);
                        $(".save:input").attr('disabled', false);
                    }
                }
            })
            },

            editData: function () {
                var msg = '<div class="alert alert-success alert-dismissable">' +
                    '<a class="close" href="#" data-dismiss="alert">x </a>' +
                    '<h4><i class="icon-ok-sign"></i>' +
                    '<?php echo $this->lang->line('success')?></h4>' +
                    '<?php echo $this->lang->line('success_updated')?>' +
                    '</div>';
                $.ajax({
                    type: "POST",
                    url: "<?php echo base_url(); ?>userRoleManagerModule/productInformationSection/system_module_sections_controller/edit",
                    data: {
                        'id': $("#id").val(),
                        'module_section_name': $("#module_section_name_edit").val(),
                <?php echo $this->security->get_csrf_token_name(); ?>:'<?php echo $this->security->get_csrf_hash(); ?>'
            },
            dataType: 'html',
                beforeSend:function () {
                $(".save:input").attr('disabled', true);
            },
            success: function (responce) {
                if (responce == 'ok') {
                    $(".validation").hide();
                    $(".msg_data").show();
                    $(".msg_data").html(msg);
                    $(".save:input").attr('disabled', false);

                    $(".form").hide();
                    $(".edit_form").hide();
                    getTableData();
                }
                else {
                    $(".msg_data").hide();
                    $(".validation").show();
                    $(".validation").html(responce);
                    $(".save:input").attr('disabled', false);
                }
            }
            })
            },

            deleteData: function (id) {
                var bConfirm = confirm("<?php echo $this->lang->line('Are you sure you want to delete this').' '.$this->lang->line('Main Module') ?>?");
                if (bConfirm) {
                    $.ajax({
                        type: "POST",
                        url: "<?php echo base_url(); ?>userRoleManagerModule/productInformationSection/system_module_sections_controller/delete",
                        data: {'id': id,
                    <?php echo $this->security->get_csrf_token_name(); ?>:'<?php echo $this->security->get_csrf_hash(); ?>'
                },
                dataType: 'html',
                    success:function (responce) {
                    $(".msg_delete").show();
                    $(".msg_delete").html(responce);

                    $(".form").hide();
                    $(".edit_form").hide();
                    getTableData();
                }
            }
            )}
            },

            changeStatus: function (moduleSectionId, moduleSectionStatus) {
                var bConfirm = confirm("<?php echo $this->lang->line('Are you sure you want to change this').' '.$this->lang->line('Status') ?>?");
                if (bConfirm) {
                    $.ajax({
                        type: "POST",
                        url: "<?php echo base_url(); ?>userRoleManagerModule/productInformationSection/system_module_sections_controller/changeStatus",
                        data: {
                            'module_section_id': moduleSectionId,
                            'module_section_status': moduleSectionStatus,
                            <?php echo $this->security->get_csrf_token_name(); ?>:'<?php echo $this->security->get_csrf_hash(); ?>'
                        },
                        dataType: 'html',
                            success:function (responce) {
                            $(".msg_delete").show();
                            $(".msg_delete").html(responce);

                            $(".form").hide();
                            $(".edit_form").hide();
                            getTableData();
                        }
                    }
                )}
            },

            getData: function (id) {
                $.ajax({
                    type: "POST",
                    url: "<?php echo base_url(); ?>userRoleManagerModule/productInformationSection/system_module_sections_controller/get",
                    data: {
                        'id': id,
                <?php echo $this->security->get_csrf_token_name(); ?>:'<?php echo $this->security->get_csrf_hash(); ?>'
            },
            dataType: 'html',
                success:function (responce) {
                $(".form").show();
                $(".save_form").hide();
                $(".edit_form").show();
                $(".edit_form").html(responce);
                $(".loader").hide();
            }
            })
            },

            init : function () {
                $("#table").show();
                $(".form").hide();
                $(".edit_form").hide();
                $(".msg_data").hide();
                $(".msg_delete").hide();
                $(".validation").hide();
            }
            }

            //form validation save
            function validateForm_save() {
                return (isNotEmpty("module_section_name", "<?php echo $this->lang->line('module_section_name').' '.$this->lang->line('field is required')?>")
                );
            }

            //form validation edit
            function validateForm_edit() {
                return (isNotEmpty("module_section_name_edit", "<?php echo $this->lang->line('module_section_name').' '.$this->lang->line('field is required')?>")
                );
            }

            //get all data
            function getTableData(){
                $(".loader").show();
                $.ajax({
                    type: "POST",
                    url: "<?php echo base_url(); ?>userRoleManagerModule/productInformationSection/system_module_sections_controller/getTableData",
                    data: {
                    <?php echo $this->security->get_csrf_token_name(); ?>:'<?php echo $this->security->get_csrf_hash(); ?>'
                    },
                    dataType: 'html',
                        success:
                    function (responce) {
                        $("#dataTable").html(responce);
                        $(".loader").hide();
                        //$('.table').dataTable();
                        var oTable =$('#example').dataTable();
                        oTable.fnSort( [ [0,'desc'] ] );
                        //oTable.search();
                    }
                })
            }

            function clearForm(){
                $("#module_section_name").val('');
            }
        </script>
