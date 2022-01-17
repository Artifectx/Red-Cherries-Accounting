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
								<span><?php echo $this->lang->line('Journal Entry Bulk Upload') ?></span>
							</h1>

							<div class='pull-right'></div>
						</div>
					</div>
				</div>

				<!--Showing messages-->
				<div class='msg_data'></div>
                <div class='msg_instant' align="center"></div>
                <?php
                if (isset ($message)) echo $message;
                echo validation_errors('<div class="alert alert-danger alert-dismissable">
                                  <a class="close" data-dismiss="alert" href="#">&times;</a><h4>
                                    <i class="icon-remove-sign"></i>
                                    Error
                                  </h4>', '</div>');
                ?>
                
				<div class='form'>
					<div class='row'>
						<div class='col-sm-12'>
							<div class='box'>
								<div class='box-header <?php echo BOXHEADER; ?>-background'>
									<div class='title' <?php echo $menuFormatting; ?>><?php echo $this->lang->line('Journal Entry Bulk Upload') ?></div>
									<div class='actions'>
										<a class="btn box-collapse btn-xs btn-link" href="#"><i></i>
										</a>
									</div>
								</div>
								<div class='box-content'>
                                    <?php echo form_open('accountsManagerModule/bookkeepingSection/journal_entry_bulk_upload_controller/handleDataImport', array('class' => 'form form-horizontal validate-form','id' => 'dataImportForm', 'style' => 'margin-bottom: 0;', 'enctype' => 'multipart/form-data')) ?>
									<!--<form enctype="multipart/form-data" accept-charset="utf-8" name="formname" id="formname"  method="post" action="">-->
                                        <div class='modal-body' style="height:60px;width:1000px">
                                            <div class='form-group'>
                                                <div class='col-sm-12 controls'>
                                                    <div class='col-sm-4 controls'>
                                                        <button class='btn btn-success save' onclick='importJournalEntries();' type='button'>
                                                            <i class='icon-plus'></i>
                                                            <?php echo $this->lang->line('Import Journal Entries') ?>
                                                        </button>
                                                    </div>
                                                    <div class='col-sm-4'>
                                                        <button class='btn btn-success' type='submit' id="download" name='data_import' value='download_journal_entry_import_template' <?php echo $menuFormatting; ?>>
                                                            <i class='icon-save'></i>
                                                            <?php echo $this->lang->line('Download') ?>
                                                        </button>
                                                    </div>
                                                    <div class='col-sm-4'>
                                                        <button class='btn btn-success' type='submit' id="download_data_validation_error_file" name='data_import' value='download_data_validation_error_file' <?php echo $menuFormatting; ?>>
                                                            <i class='icon-save'></i>
                                                            <?php echo $this->lang->line('Download Data Import Workbook Error Log File') ?>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class='form-actions' style='margin-bottom:0'>
                                            <div class='row'>
                                                <div class='col-sm-9 col-sm-offset-11'>
                                                    <button class='btn btn-warning cancel' id="btnClose" type='button' 
                                                        onclick='closeJournalEntryUploadForm();' <?php echo $menuFormatting; ?>>
                                                        <?php echo $this->lang->line('Close') ?>
                                                    </button>
                                                </div>
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
							<div class='box bordered-box <?php echo BOXHEADER; ?>-border' style='margin-bottom:0;'>
                                
								<?php
								if (isset($ACM_Bookkeeping_Add_Journal_Entry_Bulk_Upload_Permissions)) { ?>
									<button class='btn btn-success btn-sm new'
											type='button' <?php echo $menuFormatting; ?>>
										<?php echo $this->lang->line('New Journal Entry Bulk Upload') ?>
									</button>
								<?php
								}
								?>
								<p>&nbsp;

								<div class='loader' align="center"><img src="<?php echo base_url();?>assets/images/ajax-loader.gif"/> Loading data...</div>

								<div id='month_selector' class='col-sm-12' align="center">
									<input class='form-control' id='current_month' name='current_month' type='hidden'>
									<input class='form-control' id='current_year' name='current_year' type='hidden'>
									<i><img src="<?php echo base_url(); ?>assets/images/icons/previous_arrow.png" alt="" title="Previuos Month" onclick="loadPreviousMonthTransactionDetails();" style="cursor:pointer"/></i>
									&nbsp;<label id="month_name" style="text-align:center"></label>&nbsp;
									<i><img src="<?php echo base_url(); ?>assets/images/icons/next_arrow.png" alt=""  title="Next Month" onclick="loadNextMonthTransactionDetails();" style="cursor:pointer"/></i>
									<br><br>
								</div>
								
								<!--showing tabale-->
								<div id="dataTable">
								</div>
								<!--end table -->

							</div>
						</div>
					</div>
				</div>
			</div>
            
            <div class='modal fade' id='modal-import_journal_entries' tabindex='-1'>
				<div class='modal-dialog'>
					<div class='modal-content'>
						<div class='modal-header'>
							<button aria-hidden='true' class='close' data-dismiss='modal' type='button'>x</button>
							<h4 class='modal-title' id='myModalLabel' <?php echo $menuFormatting; ?>><?php echo $this->lang->line('Journal Entry Bulk Upload') ?></h4>
						</div>
						<form enctype="multipart/form-data" accept-charset="utf-8" name="formname" id="formname"  method="post" action="">
							<div class='modal-body' style="height:60px;width:1000px">
                                <div class='msg_modal_instant' style="margin-left:230px;"></div>
								<div class='form-group'>
									<div class='col-sm-12 controls'>
										<label class="control-label col-sm-3" for="inputText1"><?php echo $this->lang->line('Select Journal Entries File To Import Data') ?></label>
										<div class="col-sm-9 controls">
											<input type="file" name="file_to_upload" id="file_to_upload">
										</div>
									</div>
								</div>
							</div>
                            <p style="margin-top:10px">&nbsp;</p>
							<div class='modal-footer'>
								<button class='btn btn-primary' id="btnLoadData"  type='button' <?php echo $menuFormatting; ?>><?php echo $this->lang->line('Load Data') ?></button>
								<button class='btn btn-warning cancel' id="btnClose" data-dismiss='modal' type='button' <?php echo $menuFormatting; ?>><?php echo $this->lang->line('Close') ?></button>
							</div>
						</form>
					</div>
				</div>
			</div>
            
            <div class='modal fade modal-journal_entry_bulk_upload_preview' id='modal-bookkeeping_journal_entry_bulk_upload_preview'>
				<div class='modal-dialog' style="height:500px;width:1350px;">
					<div class='modal-content'>
						<div class='modal-header'>
							<button aria-hidden='true' class='close' data-dismiss='modal' type='button'>x</button>
							<h4 class='modal-title' id='myModalLabel' <?php echo $menuFormatting; ?>><?php echo $this->lang->line('Journal Entry Bulk Upload Preview') ?></h4>
						</div>
						<div class='modal-body'>
                            <div class='msg_modal_instant' style="margin-left:230px;"></div>
                            <div id='table'>
                                <div class='row'>
                                    <div class='col-sm-12'>
                                        <div class='box bordered-box <?php echo BOXHEADER; ?>-border' style='margin-bottom:0;'>
                                            <!--showing table-->
                                            <div id="journal_entry_bulk_upload_preview_content">
                                            </div>
                                            <!--end table -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <p style="margin-top:10px">&nbsp;</p>
                        <div class='modal-footer'>
                            <button class='btn btn-warning cancel' id="btnClose" data-dismiss='modal' type='button' <?php echo $menuFormatting; ?>><?php echo $this->lang->line('Close') ?></button>
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
        
		var date = new Date();
		var month = date.getMonth() + 1;
		var year = date.getFullYear();
		
		var monthName = moment.months(month - 1);
		$("#month_name").text(monthName + "  " + year);
		$("#current_month").val(month);
		$("#current_year").val(year);
		
		getTableData(year, month);
		JournalEntryBulkUpload.init();
	});

	$(".new").click(function () {
		$(".msg_data").hide();
		$(".msg_delete").hide();
		$(".validation").hide();
		$(".form").show();
		clearForm();
	});

	function cancelData() {
		$(".msg_data").hide();
		$(".msg_delete").hide();
		$(".validation").hide();
		
		clearForm();
		window.scrollTo(0,0);
	}
    
    function importJournalEntries() {
        openImportJournalEntriesDialog();
    }
    
    $("#btnLoadData").click(function (e){ 

		var msg='<div class="alert alert-success alert-dismissable">'+
				'<a class="close" href="#" data-dismiss="alert">× </a>'+
				'<h4><i class="icon-ok-sign"></i>'+
				'<?php echo $this->lang->line('Success') ?></h4>'+
				'<?php echo $this->lang->line('Data successfully loaded to import journal entries. Reveiw the entries and complete journal entry post.') ?>'+
				'</div>';
        
        var msgError='<div class="alert alert-danger alert-dismissable">'+
				'<a class="close" href="#" data-dismiss="alert">× </a>'+
				'<h4><i class="icon-remove-sign"></i>'+
				'<?php echo $this->lang->line('error') ?></h4>'+
				'<?php echo $this->lang->line('Data_import_workbook_errors') ?>'+
				'</div>';
		
        var fileName = $("#file_to_upload").val();
        if (fileName.substring(3,11) == 'fakepath') {
            fileName = fileName.substring(12);
        }

		// send the formData
		var formData = new FormData( $("#formname")[0] );
		formData.append('file_name', fileName);
		formData.append('<?php echo $this->security->get_csrf_token_name(); ?>','<?php echo $this->security->get_csrf_hash(); ?>');

        $(".msg_modal_instant").show();
        $(".msg_modal_instant").html('<img src="<?php echo base_url();?>assets/images/ajax-loader.gif"/>Loading...');
                
		$.ajax({
			url :"<?php echo base_url(); ?>accountsManagerModule/bookkeepingSection/journal_entry_bulk_upload_controller/add",
			type : 'POST',
			data : formData,
			processData: false,
			contentType: false,
			dataType: 'html',
            beforeSend: function () {
                $("#btnLoadData").attr('disabled', true);
            },
			success	: function (response){
                
                $(".msg_modal_instant").hide();
                
				if (response === "success") {
					$(".validation").hide();
					$(".msg_data").show();
					$(".msg_data").html(msg);
                    
                    var date = new Date();
                    var month = date.getMonth() + 1;
                    var year = date.getFullYear();

                    var monthName = moment.months(month - 1);
                    $("#month_name").text(monthName + "  " + year);
                    $("#current_month").val(month);
                    $("#current_year").val(year);

                    getTableData(year, month);
				} else {
                    $(".validation").hide();
					$(".msg_data").show();
					$(".msg_data").html(msgError);
                }
        
                $("#btnLoadData").attr('disabled', false);
                closeImportJournalEntriesDialog();
			}
		});
	});
    
    function previewJournalEntryBulkUpload(bulkUploadId) {
        JournalEntryBulkUpload.previewJournalEntryBulkUpload(bulkUploadId);
        $("#modal-bookkeeping_journal_entry_bulk_upload_preview").modal('show');
    }
    
    function prePostJournalEntryBulkUpload(bulkUploadId) {
        JournalEntryBulkUpload.prePostJournalEntryBulkUpload(bulkUploadId);
    }
    
    function rollbackJournalEntryBulkUpload(bulkUploadId) {
        JournalEntryBulkUpload.rollbackJournalEntryBulkUpload(bulkUploadId);
    }
    
    function postJournalEntryBulkUpload(bulkUploadId) {
        JournalEntryBulkUpload.postJournalEntryBulkUpload(bulkUploadId);
    }
    
    function deleteJournalEntryBulkUpload(bulkUploadId) {
        JournalEntryBulkUpload.deleteJournalEntryBulkUpload(bulkUploadId);
    }
    
    function closeJournalEntryUploadForm() {
        $(".form").hide();
    }

	var JournalEntryBulkUpload = {
		
        previewJournalEntryBulkUpload: function (bulkUploadId) {
        
            $(".msg_modal_instant").show();
            $(".msg_modal_instant").html('<img src="<?php echo base_url();?>assets/images/ajax-loader.gif"/>Loading...');

            $.ajax({
                type: "POST",
                url: "<?php echo base_url(); ?>accountsManagerModule/bookkeepingSection/journal_entry_bulk_upload_controller/previewJournalEntryBulkUpload",
                data: {
                    'bulk_upload_id': bulkUploadId,
                    '<?php echo $this->security->get_csrf_token_name(); ?>':
                    '<?php echo $this->security->get_csrf_hash(); ?>'
                },
                dataType: 'html',
                success: function (response) {
                    $("#journal_entry_bulk_upload_preview_content").empty();
                    $("#journal_entry_bulk_upload_preview_content").html(response);
                    $(".JournalEntryBulkEntryListTable").dataTable();
                    $(".msg_modal_instant").hide();
                }
            });
		},
        
        prePostJournalEntryBulkUpload: function (bulkUploadId) {
        
            var msg='<div class="alert alert-success alert-dismissable">'+
				'<a class="close" href="#" data-dismiss="alert">× </a>'+
				'<h4><i class="icon-ok-sign"></i>'+
				'<?php echo $this->lang->line('Success') ?></h4>'+
				'<?php echo $this->lang->line('Journal entry pre-post is successfully done. Please review reports and post if everything is ok. Othervise rollback the action and re-check the journal entry bulk upload.') ?>'+
				'</div>';
        
            var msgError = '<div class="alert alert-warning alert-dismissable">' +
				'<a class="close" href="#" data-dismiss="alert">x </a>' +
				'<h4><i class="icon-info-sign"></i>' +
				'<?php echo $this->lang->line('warning')?></h4>' +
				'<?php echo $this->lang->line('Journal entry bulk upload already pre-posted.')?>' +
				'</div>';
        
            $(".msg_instant").show();
            $(".msg_instant").html('<img src="<?php echo base_url();?>assets/images/ajax-loader.gif"/>Processing...');

            $.ajax({
                type: "POST",
                url: "<?php echo base_url(); ?>accountsManagerModule/bookkeepingSection/journal_entry_bulk_upload_controller/prePostJournalEntryBulkUpload",
                data: {
                    'bulk_upload_id': bulkUploadId,
                    '<?php echo $this->security->get_csrf_token_name(); ?>':
                    '<?php echo $this->security->get_csrf_hash(); ?>'
                },
                dataType: 'html',
                success: function (response) {
                    if (response == 'ok') {
                        
                        var year = $("#current_year").val();
                        var month = $("#current_month").val();
                        getTableData(year, month);
                        
                        $(".validation").hide();
                        $(".msg_data").show();
                        $(".msg_data").html(msg);
                        $(".msg_instant").hide();
                    } else if (response == 'already_pre_posted') {
                        $(".validation").hide();
                        $(".msg_data").show();
                        $(".msg_data").html(msgError);
                        $(".msg_instant").hide();
                    }
                }
            });
		},
        
        rollbackJournalEntryBulkUpload: function (bulkUploadId) {
        
            var msg='<div class="alert alert-success alert-dismissable">'+
				'<a class="close" href="#" data-dismiss="alert">× </a>'+
				'<h4><i class="icon-ok-sign"></i>'+
				'<?php echo $this->lang->line('Success') ?></h4>'+
				'<?php echo $this->lang->line('Journal entry pre-post rollback is successful.') ?>'+
				'</div>';
        
            $(".msg_instant").show();
            $(".msg_instant").html('<img src="<?php echo base_url();?>assets/images/ajax-loader.gif"/>Processing...');

            $.ajax({
                type: "POST",
                url: "<?php echo base_url(); ?>accountsManagerModule/bookkeepingSection/journal_entry_bulk_upload_controller/rollbackJournalEntryBulkUpload",
                data: {
                    'bulk_upload_id': bulkUploadId,
                    '<?php echo $this->security->get_csrf_token_name(); ?>':
                    '<?php echo $this->security->get_csrf_hash(); ?>'
                },
                dataType: 'html',
                success: function (response) {
                    if (response == 'ok') {
                        
                        var year = $("#current_year").val();
                        var month = $("#current_month").val();
                        getTableData(year, month);
                            
                        $(".validation").hide();
                        $(".msg_data").show();
                        $(".msg_data").html(msg);
                        $(".msg_instant").hide();
                    }
                }
            });
		},
        
        postJournalEntryBulkUpload: function (bulkUploadId) {
        
            var msg='<div class="alert alert-success alert-dismissable">'+
				'<a class="close" href="#" data-dismiss="alert">× </a>'+
				'<h4><i class="icon-ok-sign"></i>'+
				'<?php echo $this->lang->line('Success') ?></h4>'+
				'<?php echo $this->lang->line('Journal entry bulk upload successfully posted.') ?>'+
				'</div>';
        
            var bConfirm = confirm("<?php echo $this->lang->line('Are you sure you want to complete journal entry bulk post? Please note that after posting you cannot rollback.') ?>");
			if (bConfirm) {
                
                $(".msg_instant").show();
                $(".msg_instant").html('<img src="<?php echo base_url();?>assets/images/ajax-loader.gif"/>Processing...');

                $.ajax({
                    type: "POST",
                    url: "<?php echo base_url(); ?>accountsManagerModule/bookkeepingSection/journal_entry_bulk_upload_controller/postJournalEntryBulkUpload",
                    data: {
                        'bulk_upload_id': bulkUploadId,
                        '<?php echo $this->security->get_csrf_token_name(); ?>':
                        '<?php echo $this->security->get_csrf_hash(); ?>'
                    },
                    dataType: 'html',
                    success: function (response) {
                        if (response == 'ok') {

                            var year = $("#current_year").val();
                            var month = $("#current_month").val();
                            getTableData(year, month);

                            $(".validation").hide();
                            $(".msg_data").show();
                            $(".msg_data").html(msg);
                            $(".msg_instant").hide();
                        }
                    }
                });
            }
		},

		deleteJournalEntryBulkUpload: function (bulkUploadId) {
        
            var msgError = '<div class="alert alert-warning alert-dismissable">' +
				'<a class="close" href="#" data-dismiss="alert">x </a>' +
				'<h4><i class="icon-info-sign"></i>' +
				'<?php echo $this->lang->line('warning')?></h4>' +
				'<?php echo $this->lang->line('Journal entry bulk upload already pre-posted. Please rollback before try to delete.')?>' +
				'</div>';
        
			var bConfirm = confirm("<?php echo $this->lang->line('Are you sure you want to delete this').$this->lang->line('journal entry bulk upload') ?>?");
			if (bConfirm) {
                
                $(".msg_instant").show();
                $(".msg_instant").html('<img src="<?php echo base_url();?>assets/images/ajax-loader.gif"/>Deleting...');
                
				$.ajax({
					type: "POST",
					url: "<?php echo base_url(); ?>accountsManagerModule/bookkeepingSection/journal_entry_bulk_upload_controller/deleteJournalEntryBulkUpload",
					data: {
						'bulk_upload_id': bulkUploadId,
						'<?php echo $this->security->get_csrf_token_name(); ?>':
						'<?php echo $this->security->get_csrf_hash(); ?>'
					},
					dataType: 'json',
					success: function (response) {
                        
                        if (response.result == 'ok') {
                            clearForm();
                            $(".form").hide();

                            var year = $("#current_year").val();
                            var month = $("#current_month").val();
                            getTableData(year, month);

                            $(".msg_instant").hide();
                            $(".msg_delete").show();
                            $(".msg_delete").html(response.html);
                        } else {
                            $(".msg_instant").hide();
                            $(".msg_data").show();
                            $(".msg_data").html(msgError);
                        }
					}
				});
			}
		},

		init : function () {
			$("#table").show();
			$(".form").hide();
			$(".msg_data").hide();
			$(".msg_delete").hide();
			$(".validation").hide();
		}
	};
    
    function openImportJournalEntriesDialog() {
		$(".validation").hide();
		$(".msg_data").hide();
		$("#file_to_upload").val("");
		$("#modal-import_journal_entries").modal('show');
	}

	function closeImportJournalEntriesDialog() {
		$("#modal-import_journal_entries").modal('hide');
	}

	//get all data
	function getTableData(year, month) {
		$(".loader").show();
        
		$.ajax({
			type: "POST",
			url: "<?php echo base_url(); ?>accountsManagerModule/bookkeepingSection/journal_entry_bulk_upload_controller/getTableData",
			data: {
				'year' : year,
				'month' : month,
				'<?php echo $this->security->get_csrf_token_name(); ?>':'<?php echo $this->security->get_csrf_hash(); ?>'
			},
			dataType: 'html',
			success:
			function (response) {
				$("#dataTable").html(response);
				$(".loader").hide();
                
				var monthName = moment.months(month - 1);
				$("#month_name").text(monthName + "  " + year);
				
				$('.journalEntryBulkUploadTable').dataTable({
					"aaSorting": [[ 0, "desc" ]],
					"iDisplayLength":<?php echo $default_row_count_for_table; ?>
				});
			}
		});
	}

	function clearForm() {
		
	}

	</script>

	<style>

	.light_color_background {
		background: #eafaea;
	}

	hr.light {
		width:97%; 
		margin-left: 15px !important; 
		border:0px none white; 
		border-top:1px solid lightgrey; 
	}
</style>
