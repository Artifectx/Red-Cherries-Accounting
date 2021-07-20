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
                                <span><?php echo $this->lang->line('Financial Year Ends') ?></span>
                            </h1>

                            <div class='pull-right'></div>
                        </div>
                    </div>
                </div>

                <div id='table'>
                    <div class="msg_data"></div>
                    <div class='msg_instant' align="center"></div>
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

	function processYearEndData(financialYearEndId) {
        FinancialYearEnd.processYearEndData(financialYearEndId);
	}

	var FinancialYearEnd = {
		
		processYearEndData : function (financialYearEndId) {
			var msg = '<div class="alert alert-success alert-dismissable">' +
				'<a class="close" href="#" data-dismiss="alert">× </a>' +
				'<h4><i class="icon-ok-sign"></i>' +
				'<?php echo $this->lang->line('success')?></h4>' +
				'<?php echo $this->lang->line('year_end_successfuly_processed')?>' +
				'</div>';
        
            var msgError = '<div class="alert alert-warning alert-dismissable">' +
				'<a class="close" href="#" data-dismiss="alert">x </a>' +
				'<h4><i class="icon-info-sign"></i>' +
				'<?php echo $this->lang->line('warning')?></h4>' +
				'<?php echo $this->lang->line('Financial year end processing chart of accounts are not configured')?>' +
				'</div>';
        
            var bConfirm = confirm("<?php echo $this->lang->line('Are you sure you want to process the year end now')?>?");
			if (bConfirm) {
                
                $(".msg_instant").show();
                $(".msg_instant").html('<img src="<?php echo base_url();?>assets/images/ajax-loader.gif"/>Processing the year end, please wait...');

                $.ajax({
                    type: "POST",
                    url: "<?php echo base_url(); ?>accountsManagerModule/adminSection/financial_year_ends_controller/processYearEndData",
                    data: {
                        'financial_year_id': financialYearEndId,
                        '<?php echo $this->security->get_csrf_token_name(); ?>':
                        '<?php echo $this->security->get_csrf_hash(); ?>'
                    },
                    dataType: 'html',
                    beforeSend : function () {
                        $("#process_year_end_" + financialYearEndId).attr('disabled', true);
                    },
                    success: function (response) {

                        $(".msg_instant").hide();

                        if (response == 'ok') {
                            $(".msg_data").show();
                            $(".msg_data").html(msg);
                            $("#process_year_end_" + financialYearEndId).attr('disabled', false);
                            getTableData();
                        } else if (response == 'chart_of_accounts_not_configured') {
                            $(".msg_data").show();
                            $(".msg_data").html(msgError);
                            $("#process_year_end_" + financialYearEndId).attr('disabled', false);
                        }
                    }
                });
            }
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
