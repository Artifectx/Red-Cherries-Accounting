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
								<span><?php echo $this->lang->line('Chart of Accounts') ?></span>
							</h1>
							<div class='pull-right'></div>
						</div>
					</div>
				</div>
				<div class='msg_data'></div>
				<div class='validation'></div>
				<div id="html1">

				</div>
				<div id="helpMessage" class="helpText" style="padding-top: 20px"><?php echo $this->lang->line('Right click on a chart of account name to perform actions') ?></div>

				<div class='modal fade' id='modal-chart_of_accounts' tabindex='-1'>
					<div class='modal-dialog'>
						<div class='modal-content'>
							<div class='modal-header'>
								<button aria-hidden='true' class='close' data-dismiss='modal' type='button'>x</button>
								<h4 class='modal-title' id='myModalLabel' <?php echo $menuFormatting; ?>><?php echo $this->lang->line('Chart of Accounts') ?></h4>
							</div>
							<div class='modal-body'>
								<?php echo form_open('accountsManagerModule/adminSection/chart_of_accounts_controller/edit', array('class'=>'form form-horizontal validate-form',"id"=>"chart_of_accounts_form","method"=>"post",'style'=>'margin-bottom: 0;'))?>
									<div class="form-group">
										<input type="hidden" name="hdnId" id="hdnId">
										<input type="hidden" name="hdnParentId" id="hdnParentId">
										<input type="hidden" name="hdnLevelId" id="hdnLevelId">
										<label class="col-md-4 control-label" for="inputText1"><?php echo $this->lang->line('Account Type') ?> *</label>
										<div class="col-md-8">
											<select class="form-control" id="account_type" name="account_type">
												<option value="0"><?php echo $this->lang->line('-- Select --') ?></option>
												<option value="2"><?php echo $this->lang->line('Asset') ?></option>
												<option value="3"><?php echo $this->lang->line('Equity') ?></option>
												<option value="4"><?php echo $this->lang->line('Income') ?></option>
												<option value="5"><?php echo $this->lang->line('Expense') ?></option>
												<option value="6"><?php echo $this->lang->line('Liability') ?></option>
											</select>
											<div id="account_typeError" class="red"></div>
										</div>
									</div>
									<div class="form-group">
										<label class="col-md-4 control-label" for="inputText1"><?php echo $this->lang->line('Chart of Account Code') ?></label>
										<div class="col-md-8">
											<input id="chart_of_account_code" name="chart_of_account_code" class="form-control" type="text" placeholder="<?php echo $this->lang->line('Chart of Account Code') ?>">
										</div>
									</div>
									<div class="form-group">
										<label class="col-md-4 control-label" for="inputText1"><?php echo $this->lang->line('Chart of Account Name') ?></label>
										<div class="col-md-8">
											<input id="chart_of_account_name" name="chart_of_account_name" class="form-control" type="text" placeholder="<?php echo $this->lang->line('Chart of Account Name') ?>">
										</div>
									</div>
								</form>
							</div>
							<div class='modal-footer'>
								<?php
								if (isset($ACM_Admin_Add_Chart_Of_Accounts_Permissions) || isset($ACM_Admin_Edit_Chart_Of_Accounts_Permissions)) {
									?>
									<button class='btn btn-primary' id="btnSave"
											type='button' <?php echo $menuFormatting; ?>><?php echo $this->lang->line('Save Changes') ?></button>
									<?php
								}
								?>
								<button class='btn btn-warning cancel' id="btnClose" data-dismiss='modal' type='button' <?php echo $menuFormatting; ?>><?php echo $this->lang->line('Close') ?></button>
							</div>
						</div>
					</div>
				</div>

<script src="<?php echo base_url();?>ajax/jquery.js"></script>
<script src="<?php echo base_url(); ?>ajax/validate.js"></script>

<script>

	var selectedID = null;

	$(document).ready(function(){ 
		//fill data to tree  with AJAX call
		$('#html1').jstree({
			'core' : {
				'data' : {
					"url" : "<?php echo base_url(); ?>accountsManagerModule/adminSection/chart_of_accounts_controller/getAllToShow",
					"dataType" : "json" // needed only if you do not supply JSON headers
				},
				"check_callback" : true
			},
			'contextmenu': {
				items: customMenu
			},
			'plugins': ['contextmenu','dnd'],
		}).bind("loaded.jstree", function (event, data) {
			$(this).jstree("open_all");
		}).bind("refresh.jstree", function (event, data) {
			$(this).jstree("open_all");
		}).bind("select_node.jstree", function (event, data) {  
			//alert(CurrentNode.toSource()) //Keep this to see the tree node details.
		}).bind('move_node.jstree', function (e, data) {
			var nodeId = data['node']['original'].chart_of_account_id;
			var parentId = data.parent;
			treeInst = $('#html1').jstree(true);
			var parentNode = treeInst.get_node( parentId );
			var parentNodeId = parentNode['original'].chart_of_account_id;
			var level = parseInt(parentNode['original'].level) + 1;
			dragAndDropNode(nodeId, parentNodeId, level);
		});
	});

	function customMenu(node) {
		var items = {
			"add": {
				"label": "<?php if(isset($ACM_Admin_Add_Chart_Of_Accounts_Permissions))echo $this->lang->line('Add') ?>",
				"action": function(){
					<?php if (isset($ACM_Admin_Delete_Chart_Of_Accounts_Permissions)){?>
					var CurrentNode = $("#html1").jstree().get_selected(true)[0]['original'];
					$('#hdnId').val('');
					$('#hdnParentId').val(CurrentNode['chart_of_account_id']);
					$('#hdnLevelId').val(parseInt(CurrentNode['level']) + 1);
					$('#chart_of_account_code').val('');
					$('#chart_of_account_name').val('');
					openDialog();
					<?php
					}
					?>
				}
			},
			"edit": {
				"label": "<?php if (isset($ACM_Admin_Edit_Chart_Of_Accounts_Permissions))echo $this->lang->line('Edit') ?>",
				"action": function(){
					<?php if (isset($ACM_Admin_Delete_Chart_Of_Accounts_Permissions)){?>
					var CurrentNode = $("#html1").jstree().get_selected(true)[0]['original'];
					$("#account_type").val(CurrentNode['account_type']);
					$('#hdnId').val(CurrentNode['chart_of_account_id']);
					$('#hdnParentId').val(CurrentNode['parent_id']);
					$('#chart_of_account_code').val(CurrentNode['chart_of_account_code']);

					var accountName = CurrentNode['text'].replace(CurrentNode['chart_of_account_code'] + " - ",'');

					$('#chart_of_account_name').val(accountName);
					openDialog();
					<?php
					}
					?>
				}
			},
			"delete": {
				"label": "<?php if (isset($ACM_Admin_Delete_Chart_Of_Accounts_Permissions))echo $this->lang->line('Delete') ?>",
				"action": function(){
					<?php if (isset($ACM_Admin_Delete_Chart_Of_Accounts_Permissions)){?>
					deleteNode();
					<?php
					}
					?>
				}
			}
		};

		return items;
	}

	$("#btnSave").click(function (){ 

		var msg='<div class="alert alert-success alert-dismissable">'+
				'<a class="close" href="#" data-dismiss="alert">× </a>'+
				'<h4><i class="icon-ok-sign"></i>'+
				'<?php echo $this->lang->line('Success') ?></h4>'+
				'<?php echo $this->lang->line('Chart of Account Sucessfully Saved') ?>'+
				'</div>';

		var CurrentNode = $("#html1").jstree().get_selected(true)[0]
		var nodeId = CurrentNode.id;
		var hiddenNodeId = $('#hdnId').val();
		var nodeCode = $("#chart_of_account_code").val();
		var nodeValue = $("#chart_of_account_name").val();

		if (validateChartOfAccount_save()) {
			if (hiddenNodeId === '') {
				//Save a new node
				$.ajax({
					"async": false,
					"url": "<?php echo base_url(); ?>accountsManagerModule/adminSection/chart_of_accounts_controller/add",
					"type": 'post',
					data: {
						'account_type' : $("#account_type").val(),
						'chart_of_account_id':$("#hdnId").val(),
						'chart_of_account_code':$("#chart_of_account_code").val(),
						'chart_of_account_name':$("#chart_of_account_name").val(),
						'parent_id':$("#hdnParentId").val(),
						'level':$("#hdnLevelId").val(),
						<?php echo $this->security->get_csrf_token_name(); ?>: '<?php echo $this->security->get_csrf_hash(); ?>'
					},
					dataType: 'html',
					success: function (response) {
						if (response === "ok") {
							$(".validation").hide();
							$(".msg_data").show();
							$(".msg_data").html(msg);
							$('#html1').jstree("refresh");
						}
						closeDialog();
					}
				});
			} else {
				//Save an existing node
				$.ajax({
					"async": false,
					"url": "<?php echo base_url(); ?>accountsManagerModule/adminSection/chart_of_accounts_controller/edit",
					"type": 'post',
					data: {
						'account_type' : $("#account_type").val(),
						'chart_of_account_id':$("#hdnId").val(),
						'chart_of_account_code':$("#chart_of_account_code").val(),
						'chart_of_account_name':$("#chart_of_account_name").val(),
						'parent_id':$("#hdnParentId").val(),
						<?php echo $this->security->get_csrf_token_name(); ?>: '<?php echo $this->security->get_csrf_hash(); ?>'
					},
					dataType: 'html',
					success: function (response) {
						if (response === "ok") {
							$(".validation").hide();
							$(".msg_data").show();
							$(".msg_data").html(msg);
							$("#html1").jstree('set_text', nodeId, nodeValue);
							$('#html1').jstree("refresh");
						}
						closeDialog();
					}
				});
			}
		}
	});

	function openDialog() {
		$(".validation").hide();
		$(".msg_data").hide();
		$("#modal-chart_of_accounts").modal('show');
	}

	function closeDialog() {
		$("#modal-chart_of_accounts").modal('hide');
	}

	function deleteNode() {

		var msg='<div class="alert alert-success alert-dismissable">'+
				'<a class="close" href="#" data-dismiss="alert">x </a>'+
				'<h4><i class="icon-ok-sign"></i>'+
				'<?php echo $this->lang->line('Success') ?></h4>'+
				'<?php echo $this->lang->line('Chart of Account Sucessfully Deleted') ?>'+
				'</div>';

		var CurrentNode = $("#html1").jstree().get_selected(true)[0]['original'];
		var currentNodeId = CurrentNode['chart_of_account_id'];

		if (currentNodeId != 1) {
			var CurrentNode = $("#html1").jstree().get_selected(true)[0]
			var nodeId = CurrentNode.id;

			$.ajax({
				"async": false,
				"url": "<?php echo base_url(); ?>accountsManagerModule/adminSection/chart_of_accounts_controller/delete",
				"type": 'post',
				data: {
					'chart_of_account_id':currentNodeId,
					<?php echo $this->security->get_csrf_token_name(); ?>: '<?php echo $this->security->get_csrf_hash(); ?>'
				},
				dataType: 'html',
				success: function (response) {
					if (response === "ok") {
						$(".validation").hide();
						$(".msg_data").show();
						$(".msg_data").html(msg);
						//$.jstree.reference("#html1").delete_node(nodeId);
						$('#html1').jstree("refresh");
					}else{
						$(".msg_data").hide();
						$(".validation").show();
						$(".validation").html(response);
					}
				}
			});
		} else {
			alert("<?php echo $this->lang->line('Mother Chart of Account Cannot Be Deleted!') ?>");
		}
	}

	function dragAndDropNode(nodeId, parentId, level) {

		var msg='<div class="alert alert-success alert-dismissable">'+
				'<a class="close" href="#" data-dismiss="alert">× </a>'+
				'<h4><i class="icon-ok-sign"></i>'+
				'<?php echo $this->lang->line('Success') ?></h4>'+
				'<?php echo $this->lang->line('Chart of Account Sucessfully Moved') ?>'+
				'</div>';

		$.ajax({
			"async": false,
			"url": "<?php echo base_url(); ?>accountsManagerModule/adminSection/chart_of_accounts_controller/move",
			"type": 'post',
			data: {
				'chart_of_account_id': nodeId,
				'parent_id': parentId,
				'level' : level,
				<?php echo $this->security->get_csrf_token_name(); ?>: '<?php echo $this->security->get_csrf_hash(); ?>'
			},
			dataType: 'html',
			success: function (response) {
				if (response === "ok") {
					$(".validation").hide();
					$(".msg_data").show();
					$(".msg_data").html(msg);
					$('#html1').jstree("reload");
				}
			}
		});
	}
	
	function validateChartOfAccount_save() {
		return isSelected("account_type", "<?php echo $this->lang->line('Account Type').' '.$this->lang->line('field is required')?>");
	}
</script>
