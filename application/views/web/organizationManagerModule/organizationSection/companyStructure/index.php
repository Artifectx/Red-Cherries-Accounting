<section id='content'>
	<div class='container'>
		<div class='row' id='content-wrapper'>
			<div class='col-xs-12'>
				<div class='row'>
					<div class='col-sm-12'>
						<div class='page-header'>
							<h1 class='pull-left'>
								<i class='icon-table'></i>
								<span><?php echo $this->lang->line('Company Structure') ?></span>
							</h1>
							<div class='pull-right'></div>
						</div>
					</div>
				</div>
				<div class='msg_data'></div>
				<div class='validation'></div>
				<div id="html1">

				</div>
				<div id="helpMessage" class="helpText" style="padding-top: 20px"><?php echo $this->lang->line('Right click on a company name to perform actions') ?></div>

				<div class='modal fade' id='modal-company_structure' tabindex='-1'>
					<div class='modal-dialog'>
						<div class='modal-content'>
							<div class='modal-header'>
								<button aria-hidden='true' class='close' data-dismiss='modal' type='button'>x</button>
								<h4 class='modal-title' id='myModalLabel' <?php echo $menuFormatting; ?>><?php echo $this->lang->line('Company Structure') ?></h4>
							</div>
							<div class='modal-body'>
								<?php echo form_open('organizationManagerModule/organizationSection/company_structure_controller/edit', array('class'=>'form form-horizontal validate-form',"id"=>"company_structure_form","method"=>"post",'style'=>'margin-bottom: 0;'))?>
									<div class="form-group">
										<input type="hidden" name="hdnId" id="hdnId">
										<input type="hidden" name="hdnParentId" id="hdnParentId">
										<input type="hidden" name="hdnLevelId" id="hdnLevelId">
										<label class="col-md-3 control-label" for="inputText1"><?php echo $this->lang->line('Company Name') ?></label>
										<div class="col-md-8">
											<input id="company_name" name="company_name" class="form-control" type="text" placeholder="">
										</div>
									</div>
								</form>
							</div>
							<div class='modal-footer'>
								<?php
								if (isset($OGM_Organization_Add_Company_Structure_Permissions) || isset($OGM_Organization_Edit_Company_Structure_Permissions)) {
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

<script>

	var selectedID = null;

	$(document).ready(function(){ 
		//fill data to tree  with AJAX call
		$('#html1').jstree({
			'core' : {
				'data' : {
					"url" : "<?php echo base_url(); ?>organizationManagerModule/organizationSection/company_structure_controller/getAllToShow",
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
			var nodeId = data['node']['original'].company_id;
			var parentId = data.parent;
			treeInst = $('#html1').jstree(true);
			var parentNode = treeInst.get_node( parentId );
			var parentNodeId = parentNode['original'].company_id;
			var level = parseInt(parentNode['original'].level) + 1;
			dragAndDropNode(nodeId, parentNodeId, level);
		});
	});

	function customMenu(node) {
		var items = {
			"add": {
				"label": "<?php if(isset($OGM_Organization_Add_Company_Structure_Permissions))echo $this->lang->line('Add') ?>",
				"action": function(){
					<?php if (isset($OGM_Organization_Delete_Company_Structure_Permissions)){?>
					var CurrentNode = $("#html1").jstree().get_selected(true)[0]['original'];
					$('#hdnId').val('');
					$('#hdnParentId').val(CurrentNode['company_id']);
					$('#hdnLevelId').val(parseInt(CurrentNode['level']) + 1);
					$('#company_name').val('');
					openDialog();
					<?php
					}
					?>
				}
			},
			"edit": {
				"label": "<?php if (isset($OGM_Organization_Edit_Company_Structure_Permissions))echo $this->lang->line('Edit') ?>",
				"action": function(){
					<?php if (isset($OGM_Organization_Delete_Company_Structure_Permissions)){?>
					var CurrentNode = $("#html1").jstree().get_selected(true)[0]['original'];
					$('#hdnId').val(CurrentNode['company_id']);
					$('#hdnParentId').val(CurrentNode['parent_id']);
					$('#company_name').val(CurrentNode['text']);
					openDialog();
					<?php
					}
					?>
				}
			},
			"delete": {
				"label": "<?php if (isset($OGM_Organization_Delete_Company_Structure_Permissions))echo $this->lang->line('Delete') ?>",
				"action": function(){
					<?php if (isset($OGM_Organization_Delete_Company_Structure_Permissions)){?>
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
				'<?php echo $this->lang->line('Company Structure Sucessfully Saved') ?>'+
				'</div>';

		var CurrentNode = $("#html1").jstree().get_selected(true)[0]
		var nodeId = CurrentNode.id;
		var hiddenNodeId = $('#hdnId').val();
		var nodeValue = $("#company_name").val();

		if (hiddenNodeId === '') {
			//Save a new node
			$.ajax({
				"async": false,
				"url": "<?php echo base_url(); ?>organizationManagerModule/organizationSection/company_structure_controller/add",
				"type": 'post',
				data: {
					'company_id':$("#hdnId").val(),
					'company_name':$("#company_name").val(),
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
				"url": "<?php echo base_url(); ?>organizationManagerModule/organizationSection/company_structure_controller/edit",
				"type": 'post',
				data: {
					'company_id':$("#hdnId").val(),
					'company_name':$("#company_name").val(),
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
	});

	function openDialog() {
		$(".validation").hide();
		$(".msg_data").hide();
		$("#modal-company_structure").modal('show');
	}

	function closeDialog() {
		$("#modal-company_structure").modal('hide');
	}

	function deleteNode() {

		var msg='<div class="alert alert-success alert-dismissable">'+
				'<a class="close" href="#" data-dismiss="alert">x </a>'+
				'<h4><i class="icon-ok-sign"></i>'+
				'<?php echo $this->lang->line('Success') ?></h4>'+
				'<?php echo $this->lang->line('Company Sucessfully Deleted') ?>'+
				'</div>';

		var CurrentNode = $("#html1").jstree().get_selected(true)[0]['original'];
		var currentNodeId = CurrentNode['company_id'];

		if (currentNodeId != 1) {
			var CurrentNode = $("#html1").jstree().get_selected(true)[0]
			var nodeId = CurrentNode.id;

			$.ajax({
				"async": false,
				"url": "<?php echo base_url(); ?>organizationManagerModule/organizationSection/company_structure_controller/delete",
				"type": 'post',
				data: {
					'company_id':currentNodeId,
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
			alert("<?php echo $this->lang->line('Mother Company Cannot Be Deleted!') ?>");
		}
	}

	function dragAndDropNode(nodeId, parentId, level) {

		var msg='<div class="alert alert-success alert-dismissable">'+
				'<a class="close" href="#" data-dismiss="alert">× </a>'+
				'<h4><i class="icon-ok-sign"></i>'+
				'<?php echo $this->lang->line('Success') ?></h4>'+
				'<?php echo $this->lang->line('Company Sucessfully Moved') ?>'+
				'</div>';

		$.ajax({
			"async": false,
			"url": "<?php echo base_url(); ?>organizationManagerModule/organizationSection/company_structure_controller/move",
			"type": 'post',
			data: {
				'company_id': nodeId,
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
</script>
