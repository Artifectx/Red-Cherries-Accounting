<section id='content'>
    <div class='container'>
        <div class='row' id='content-wrapper'>
            <div class='col-xs-12'>
                <div class='row'>
                    <div class='col-sm-12'>
                        <div class='page-header'>
                            <h1 class='pull-left'>
                                <i class='icon-table'></i>
                                <span><?php echo $this->lang->line('Financial Year Ends') ?></span>
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
	});

	function editData() {
        Bank.editData();
	}

	var Bank = {
		
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
			});
		}
	};

	//get all data
	function getTableData(){
		$(".loader").show();
		$.ajax({
			type: "POST",
			url: "<?php echo base_url(); ?>accountsManagerModule/adminSection/financial_year_ends_controller/getTableData",
			data: {
				'<?php echo $this->security->get_csrf_token_name(); ?>':'<?php echo $this->security->get_csrf_hash(); ?>'
			},
			dataType: 'html',
				success:
			function (response) {
				$("#dataTable").html(response);
				$(".loader").hide();
				$('.table').dataTable();
			}
		});
	}
</script>
