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
                                <span><?php echo $this->lang->line('Bank Details') ?></span>
                            </h1>

                            <div class='pull-right'></div>
                        </div>
                    </div>
                </div>

                <!--Showing messages-->
                <div class='msg_data'></div>
                <div class='msg_instant' align="center"></div>
                <div class='form page_load' id='page_load'>
                    <div class='row'>
                        <div class='col-sm-12'>
                            <div class='box'>
                                <div class='box-header <?php echo BOXHEADER; ?>-background'>
                                    <div class='title'><?php echo $this->lang->line('Bank Details') ?></div>
                                    <div class='actions'>
                                        <a class="btn box-collapse btn-xs btn-link" href="#"><i></i>
                                        </a>
                                    </div>
                                </div>
                                <div class='box-content'>
                                    <div class='msg_data'></div>
                                    <div class='validation'></div>
                                    <form class='form form-horizontal validate-form save_form' method="post">
										<div class='form-group'>
                                            <label class='control-label col-sm-3'><?php echo $this->lang->line('Bank Code') ?></label>

                                            <div class='col-sm-4 controls'>
                                                <input class='form-control'  id='bank_code' name='bank_code'
                                                       placeholder='<?php echo $this->lang->line('Bank Code') ?>' type='text' value="<?php echo set_value('bank_code'); ?>">
                                                <div id="bank_codeError" class="red"></div>
                                            </div>
                                        </div>
                                        <div class='form-group'>
                                            <label class='control-label col-sm-3'><?php echo $this->lang->line('Bank Name') ?> *</label>

                                            <div class='col-sm-4 controls'>
                                                <input class='form-control'  id='bank_name' name='bank_name'
                                                       placeholder='<?php echo $this->lang->line('Bank Name') ?>' type='text' value="<?php echo set_value('bank_name'); ?>">
                                                <div id="bank_nameError" class="red"></div>
                                            </div>
                                        </div>
										<div class='form-group'>
                                            <label class='control-label col-sm-3'><?php echo $this->lang->line('Branch Name') ?></label>

                                            <div class='col-sm-4 controls'>
                                                <input class='form-control'  id='branch_name' name='branch_name'
                                                       placeholder='<?php echo $this->lang->line('Branch Name') ?>' type='text' value="<?php echo set_value('branch_name'); ?>">
                                                <div id="branch_nameError" class="red"></div>
                                            </div>
											<div class='col-sm-2 controls'>
												<button class='btn btn-success' type='button' id="add_branch" onclick="handleBranchSelect(this.id, '/Add/');">
													<i class='icon-save'></i>
													<?php echo $this->lang->line('Add') ?>
												</button>
											</div>
                                        </div>
										
										<div id="branch_data_group">
															
										</div>
                                        
                                        <div class='form-actions' style='margin-bottom:0'>
                                            <div class='row'>
                                                <div class='col-sm-9 col-sm-offset-3'>
                                                    <?php
													if (isset($ACM_Admin_Add_Bank_Permissions)){
													?>
                                                        <button class='btn btn-success save'
															onclick='saveData();' type='button'>
                                                            <i class='icon-save'></i>
                                                            <?php echo $this->lang->line('Save') ?>
                                                        </button>
                                                        <?php
													}
													?>

                                                    <button class='btn btn-primary' type='reset'>
                                                        <i class='icon-undo'></i>
                                                        <?php echo $this->lang->line('Refresh') ?>
                                                    </button>
                                                    <button class='btn btn-warning cancel' onclick='cancelData();'
														 type='button'>
                                                        <i class='icon-ban-circle'></i>
                                                        <?php echo $this->lang->line('Close') ?>
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

                <div id='table'>
                    <div class="msg_delete"></div>
                    <div class='row'>
                        <div class='col-sm-12'>
                            <div class='box bordered-box <?php echo BOXHEADER; ?>-border' style='margin-bottom:0;'>

                                <?php
									if (isset($ACM_Admin_Add_Bank_Permissions)){
										echo "<a class='btn btn-success btn-sm new'>{$this->lang->line('Add New Bank') }</a>";
									}
									?>
                                <p>&nbsp;

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
        $(".msg_instant").hide();
		getTableData();
		Bank.init();
	});

	$(".new").click(function () {
		$("#page_load").removeClass("page_load");
		$("#page_load").addClass("page_load_show");
		$(".msg_data").hide();
		$(".msg_delete").hide();
		$(".validation").hide();
		$(".form").show();
		$(".edit_form").hide();

	});

	function cancelData() {
		Bank.cancelData();
	}

	function saveData() {
		if (validateForm_save()) {
            $(".msg_instant").show();
            $(".msg_instant").html('<img src="<?php echo base_url();?>assets/images/ajax-loader.gif"/>Saving data...');
			Bank.saveData();
            window.scrollTo(0,0);
		}
	}

	function editData() {
		if (validateForm_edit()){
            $(".msg_instant").show();
            $(".msg_instant").html('<img src="<?php echo base_url();?>assets/images/ajax-loader.gif"/>Updating data...');
			Bank.editData();
            window.scrollTo(0,0);
		}
	}

	function get(id){
		$("#page_load").removeClass("page_load");
		$("#page_load").addClass("page_load_show");
		$(".loader").show();
		$(".msg_data").hide();
		$(".msg_delete").hide();
		$(".validation").hide();
		Bank.getData(id);
	}

	function del(id){
		$(".msg_data").hide();
		$(".msg_delete").hide();
		$(".validation").hide();
		Bank.deleteData(id);
	}
	
	function handleBranchSelect(id, type) {

		var cloneCount = 1;
		var BranchAlreadyAdded = false;

		var NewBranch = '';

		if (type == "/Add/") {
			NewBranch = $("#branch_name").val();
		} else if (type == "/Edit/") {
			NewBranch = $("#branch_name_edit").val();
		}

		if (NewBranch != '') {
			var NewBranchName = '';

			if (type == "/Add/") {
				NewBranchName = $("#branch_name").val();

				var element = $("#branch_data_group").find("#branch_1");

				while (element.length == 1) {
					if ($("#branch_data_" + cloneCount).val() == NewBranch) {
						BranchAlreadyAdded = true;
					}
					cloneCount++;
					element = $("#branch_data_group").find("#branch_" + cloneCount);
				}

				if (NewBranch != '' && BranchAlreadyAdded == false) {
					var NewBranchHTML = ' <div class="form-group" id="branch_'+cloneCount+'">'+
												'<input class="form-control" id="branch_data_'+cloneCount+'" type="hidden" value="'+NewBranch+'">'+
												'<div class="col-sm-12 controls">'+
													'<div class="col-sm-3 controls">'+
													'</div>'+
													'<label class="control-label col-sm-2 branch_data">'+NewBranchName+'</label>'+
													'<div class="col-sm-2 controls">'+
														'<button class="btn btn-success" type="button" id="delete_branch_'+cloneCount+'"'+
															'onclick="removeBranch(this.id, /Add/)">'+
															'<i class="icon-save"></i>'+
															'<?php echo $this->lang->line('Delete') ?>'+
														'</button>'+
													'</div>'+
												'</div>'+
											'</div>';

					$("#branch_name").val('');
					$("#branch_data_group").append(NewBranchHTML);
				} else {
					if (NewBranch != '') {
						alert("<?php echo $this->lang->line('Branch already added') ?>");
						$("#branch_name").val('');
					}
				}
			} else if (type == "/Edit/") {
				NewBranchName = $("#branch_name_edit").val();

				var element = $("#branch_data_group_edit").find("#branch_edit_1");

				while (element.length == 1) {
					if ($("#branch_data_edit_" + cloneCount).val() == NewBranch) {
						BranchAlreadyAdded = true;
					}
					cloneCount++;
					element = $("#branch_data_group_edit").find("#branch_edit_" + cloneCount);
				}

				if (NewBranch != '' && BranchAlreadyAdded == false) {
					var NewBranchHTML = ' <div class="form-group" id="branch_edit_'+cloneCount+'">'+
												'<input class="form-control" id="branch_data_edit_'+cloneCount+'" type="hidden" value="'+NewBranch+'">'+
												'<div class="col-sm-12 controls">'+
													'<div class="col-sm-3 controls">'+
													'</div>'+
													'<label class="control-label col-sm-2 branch_data">'+NewBranchName+'</label>'+
													'<div class="col-sm-2 controls">'+
														'<button class="btn btn-success" type="button" id="delete_branch_edit_'+cloneCount+'"'+
															'onclick="removeBranch(this.id, /Edit/)">'+
															'<i class="icon-save"></i>'+
															'<?php echo $this->lang->line('Delete') ?>'+
														'</button>'+
													'</div>'+
												'</div>'+
											'</div>';

					$("#branch_name_edit").val('');
					$("#branch_data_group_edit").append(NewBranchHTML);
				} else {
					if (NewBranch != '') {
						alert("<?php echo $this->lang->line('Branch already added') ?>");
						$("#branch_name_edit").val('');
					}
				}
			}
		}
	}

	function removeBranch(id, type) {

		var value = '';

		if (type == "/Add/") {
			value = id.substring(14,16);

			$("#branch_"+value).remove();

			var cloneCount = '';
			var element = '';

			cloneCount = parseInt(value) + 1;
			element = $("#branch_data_group").find("#branch_data_"+cloneCount);

			while (element.length == 1) {
				$("#branch_"+cloneCount).prop({ id: "branch_" + (cloneCount - 1)});
				$("#branch_data_"+cloneCount).prop({ id: "branch_data_" + (cloneCount - 1)});
				$("#delete_branch_"+cloneCount).prop({ id: "delete_branch_" + (cloneCount - 1)});
				cloneCount++;
				element = $("#branch_data_group").find("#branch_data_" + cloneCount);
			}
		} else if (type == "/Edit/") {
			value = id.substring(19,21);

			$("#branch_edit_"+value).remove();

			var cloneCount = '';
			var element = '';

			cloneCount = parseInt(value) + 1;
			element = $("#branch_data_group_edit").find("#branch_data_edit_"+cloneCount);

			while (element.length == 1) {
				$("#branch_edit_"+cloneCount).prop({ id: "branch_edit_" + (cloneCount - 1)});
				$("#branch_data_edit_"+cloneCount).prop({ id: "branch_data_edit_" + (cloneCount - 1)});
				$("#delete_branch_edit_"+cloneCount).prop({ id: "delete_branch_edit_" + (cloneCount - 1)});
				cloneCount++;
				element = $("#branch_data_group_edit").find("#branch_data_edit_" + cloneCount);
			}
		}
	}

	var Bank = {
		cancelData: function () {
			$(".form").hide();
		},

		saveData: function () {
			var msg = '<div class="alert alert-success alert-dismissable">' +
				'<a class="close" href="#" data-dismiss="alert">× </a>' +
				'<h4><i class="icon-ok-sign"></i>' +
				'<?php echo $this->lang->line('success')?></h4>' +
				'<?php echo $this->lang->line('success_saved')?>' +
				'</div>';
		
			var branchList = new Array();
			
			var cloneCount = 1;
			var element = $("#branch_data_group").find("#branch_data_1");

			while (element.length == 1) {
				branchList.push($("#branch_data_"+cloneCount).val());
				cloneCount++;
				element = $("#branch_data_group").find("#branch_data_" + cloneCount);
			}
				
			$.ajax({
				type: "POST",
				url: "<?php echo base_url(); ?>accountsManagerModule/adminSection/bank_controller/add",
				data: {
					'bank_code': $("#bank_code").val(),
					'bank_name': $("#bank_name").val(),
					'branch_name': $("#branch_name").val(),
					'branch_list' : branchList,
					'<?php echo $this->security->get_csrf_token_name(); ?>':
					'<?php echo $this->security->get_csrf_hash(); ?>'
				},
				dataType: 'html',
				beforeSend: function () {
					$(".save:input").attr('disabled', true);
				},
				success: function (response) {
                    
                    $(".msg_instant").hide();
                    
					if (response == 'ok') {
						$(".validation").hide();
						$(".msg_data").show();
						$(".msg_data").html(msg);
						$(".save:input").attr('disabled', false);

						$(".form").hide();
						$(".edit_form").hide()

						clearForm();
						getTableData();
					}
					else {
						$(".msg_data").hide();
						$(".validation").show();
						$(".validation").html(response);
						$(".save:input").attr('disabled', false);
					}
				}
			})
		},

		editData: function () {
			var msg = '<div class="alert alert-success alert-dismissable">' +
				'<a class="close" href="#" data-dismiss="alert">× </a>' +
				'<h4><i class="icon-ok-sign"></i>' +
				'<?php echo $this->lang->line('success')?></h4>' +
				'<?php echo $this->lang->line('success_updated')?>' +
				'</div>';
		
			var branchList = new Array();

			var cloneCount = 1;
			var element = $("#branch_data_group_edit").find("#branch_data_edit_1");

			while (element.length == 1) {
				branchList.push($("#branch_data_edit_"+cloneCount).val());
				cloneCount++;
				element = $("#branch_data_group_edit").find("#branch_data_edit_" + cloneCount);
			}
				
			$.ajax({
				type: "POST",
				url: "<?php echo base_url(); ?>accountsManagerModule/adminSection/bank_controller/edit",
				data: {
					'id': $("#id").val(),
					'bank_code' : $("#bank_code_edit").val(),
					'bank_name' : $("#bank_name_edit").val(),
					'branch_name': $("#branch_name_edit").val(),
					'branch_list' : branchList,
					'<?php echo $this->security->get_csrf_token_name(); ?>':
					'<?php echo $this->security->get_csrf_hash(); ?>'
				},
				dataType: 'html',
					beforeSend
				:
				function () {
					$(".save:input").attr('disabled', true);
				},
				success: function (response) {
                    
                    $(".msg_instant").hide();
                    
					if (response == 'ok') {
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
						$(".validation").html(response);
						$(".save:input").attr('disabled', false);
					}
				}
			})
		},

		deleteData: function (id) {
			var bConfirm = confirm("<?php echo $this->lang->line('Are you sure you want to delete this').$this->lang->line('bank') ?>?");
			if (bConfirm) {
                
                $(".msg_instant").show();
                $(".msg_instant").html('<img src="<?php echo base_url();?>assets/images/ajax-loader.gif"/>Deleting...');
                
				$.ajax({
					type: "POST",
					url: "<?php echo base_url(); ?>accountsManagerModule/adminSection/bank_controller/delete",
					data: {
						'id': id,
						'<?php echo $this->security->get_csrf_token_name(); ?>':
						'<?php echo $this->security->get_csrf_hash(); ?>'
					},
					dataType: 'html',
						success:
					function (response) {
                        $(".msg_instant").hide();
						$(".msg_delete").show();
						$(".msg_delete").html(response);

						$(".form").hide();
						$(".edit_form").hide();
						getTableData();
					}
				})
			}
		},

		getData: function (id) {
			$.ajax({
				type: "POST",
				url: "<?php echo base_url(); ?>accountsManagerModule/adminSection/bank_controller/get",
				data: {
					'id': id,
					'<?php echo $this->security->get_csrf_token_name(); ?>':
					'<?php echo $this->security->get_csrf_hash(); ?>'
				},
				dataType: 'html',
					success:
				function (response) {
					$(".form").show();
					$(".save_form").hide();
					$(".edit_form").show();
					$(".edit_form").html(response);
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
		return (isNotEmpty("bank_name", "<?php echo $this->lang->line('Bank Name').' '.$this->lang->line('field is required')?>"));
	}

	//form validation edit
	function validateForm_edit() {
		return (isNotEmpty("bank_name_edit", "<?php echo $this->lang->line('Bank Name').' '.$this->lang->line('field is required')?>"));
	}

	//get all data
	function getTableData(){
		$(".loader").show();
		$.ajax({
			type: "POST",
			url: "<?php echo base_url(); ?>accountsManagerModule/adminSection/bank_controller/getTableData",
			data: {
				'<?php echo $this->security->get_csrf_token_name(); ?>':'<?php echo $this->security->get_csrf_hash(); ?>'
			},
			dataType: 'html',
				success:
			function (response) {
				$("#dataTable").html(response);
				$(".loader").hide();
				$('.table').dataTable({
					"aaSorting": [[ 1, "asc" ]]
				});
			}
		})
	}

	function clearForm(){
		$("#bank_code").val('');
		$("#bank_name").val('');
		$("#branch_name").val('');
		$("#branch_data_group").empty();
	}
</script>
