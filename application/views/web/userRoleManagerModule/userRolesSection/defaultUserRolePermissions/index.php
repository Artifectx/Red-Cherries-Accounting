<section id='content'>
    <div class='container'>
        <div class='row' id='content-wrapper'>
            <div class='col-xs-12'>
                <div class='row'>
                    <div class='col-sm-12'>
                        <div class='page-header'>
                            <h1 class='pull-left'>
                                <i class='icon-table'></i>
                                <span><?php echo $this->lang->line('Default User Role Permissions Details') ?></span>
                            </h1>

                            <div class='pull-right'></div>
                        </div>
                    </div>
                </div>

                <!--Showing messages-->
                <div class='msg_data'></div>

                <div class='form'>
                    <div class='row'>
                        <div class='col-sm-12'>
                            <div class='box'>
                                <div class='box-content'>
                                    <div class='msg_data'></div>
                                    <div class='validation'></div>
                                    <form class='form form-horizontal validate-form save_form'>
                                        <div class='form-group'>
                                            <label
                                                class='control-label col-sm-3'><?php echo $this->lang->line('Default User Roles') ?> *</label>

                                            <div class='col-sm-4 controls'>
                                                <select name="role_id" id="role_id" class="form-control" onchange="getUserRolePermission();">
                                                    <option value=''><?php echo $this->lang->line('-- Select --')?></option>
                                                    <?php
                                                    if ($user_roles != null) {
                                                        foreach($user_roles as $raw){
                                                            if($raw->role_id !=1) {
                                                                ?>
                                                                <option
                                                                    value="<?php echo $raw->role_id; ?>"<?php echo set_select('role_id', $raw->role_id, FALSE) ?>><?php echo $raw->user_role_name; ?></option>
                                                                <?php
                                                            }
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                                <div id="role_idError" class="red"></div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div id='table'>
                    <div class="msg_delete"></div>
                    <div class='row'>
                        <div class='col-sm-12'>
                            <div class='box bordered-box <?php //echo BOXHEADER; ?>-border' style='margin-bottom:0;'>
                                <!--<a class='btn btn-success btn-sm new'><?php //echo $this->lang->line('Add New Module') ?></a>-->
                                <p>&nbsp;

                                <!--showing tabale-->
                                <div id="dataTable">
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class='modal fade' id='modal-advanced_permissions' tabindex='-1'>
            <div class='modal-dialog' style="height:550px;width:850px">
                <div class='modal-content'>
                    <div class='modal-header'>
                        <button aria-hidden='true' class='close' data-dismiss='modal' type='button'>x</button>
                        <h4 class='modal-title' id='modal_title'><?php echo $this->lang->line('Advanced Permissions') ?></h4>
                    </div>

                    <form enctype="text/plain" accept-charset="utf-8" name="formname" id="advanced_permissions_form"  method="post" action="">
                        <div class='modal-body'>
                            <div class='modal_msg_data'></div>
                            <div class='col-sm-12'>
                                <input class='form-control' id='user_role_id' name='user_role_id' type='hidden'>
                                <div class='box' id="advanced_permission_list">
                                    
                                </div>
                            </div>
                        </div>
                    </form>
                    <div class='modal-footer'>
                        <button class='btn btn-warning cancel' id="btnClose" data-dismiss='modal' type='button'><?php echo $this->lang->line('Close') ?></button>
                    </div>
                </div>
            </div>
        </div>


<script src="<?php echo base_url(); ?>ajax/jquery.js"></script>
<script src="<?php echo base_url(); ?>ajax/validate.js"></script>

<script>
    $(document).ready(function () {
        $(".form").show();
    });

    function getUserRolePermission(){
        if($('#role_id').val() != ''){
            getTableData($('#role_id').val());
        }
    }
    
    function openAdvancedPermissions(permissionIds, userRoleId) {
        getAdvancedPermissionsList(permissionIds, userRoleId);
        openAdvancedPermissionsDialog(userRoleId);
    }
    
    function openAdvancedPermissionsDialog(userRoleId) {
        $("#user_role_id").val(userRoleId);
        $("#modal-advanced_permissions").modal('show');
    }

    function closeAdvancedPermissionsDialog() {
        $("#modal-advanced_permissions").modal('hide');
    }
    
    //get all data
    function getTableData(id){
        $("#table").show();
        $.ajax({
            type: "POST",
            url: "<?php echo base_url(); ?>userRoleManagerModule/userRolesSection/default_user_roles_permissions_controller/getTableData",
            data: {
                'id':id,
                <?php echo $this->security->get_csrf_token_name(); ?>:'<?php echo $this->security->get_csrf_hash(); ?>'
            },
            dataType: 'html',
                success:
            function (response) {
                $("#dataTable").html(response);
                $(".loader").hide();
                //$('.table').dataTable();
                $('#rolePermissionTable').DataTable( {
                    "iDisplayLength": 5
                } );
            }
        })
    }
    
    function getAdvancedPermissionsList(permissionIds, userRoleId) {
        $("#table").show();
        $.ajax({
            type: "POST",
            url: "<?php echo base_url(); ?>userRoleManagerModule/userRolesSection/default_user_roles_permissions_controller/getAdvancedPermissionList",
            data: {
                'permission_ids' : permissionIds,
                'user_role_id' : userRoleId,
                <?php echo $this->security->get_csrf_token_name(); ?>:'<?php echo $this->security->get_csrf_hash(); ?>'
            },
            dataType: 'html',
                success:
            function (response) {
                $("#advanced_permission_list").html(response);
            }
        })
    }

</script>
