<section id='content'>
	<div class='container'>
		<div class='row' id='content-wrapper'>
			<div class='col-xs-12'>
				<div class='row'>
					<div class='col-sm-12'>
						<div class='page-header'>
							<h1 class='pull-left'>
								<i class='icon-table'></i>
								<span><?php echo $this->lang->line('Program Progress') ?></span>
							</h1>

							<div class='pull-right'></div>
						</div>
					</div>
				</div>

				<div class='form'>
					<div class='row'>
						<div class='col-sm-12'>
							<div class='box'>
								<div class='box-content'>
									<form class='form form-horizontal validate-form save_form'>
									<div class='form-group'>
										<label class='control-label col-sm-4'><?php echo $this->lang->line('Program') ?> *</label>

										<div class='col-sm-4 controls'>
											<select name="program_id" id="program_id" class="form-control" onchange="getProgramProgressDetails(this.id);">
												<option value=''><?php echo $this->lang->line('-- Select --')?></option>
												<?php
												if ($programs != null) {
													foreach($programs as $raw){
														?>
														<option
															value="<?php echo $raw->program_id; ?>"<?php echo set_select('program_id', $raw->program_id, FALSE) ?>><?php echo $raw->program_name; ?></option>
														<?php
													}
												}
												?>
											</select>
											<div id="program_idError" class="red"></div>
										</div>
									</div>
														</form>
								</div>
							</div>
						</div>
					</div>
									
					<div class='msg_data'></div>
									
					<div class='row' id="program_activity_details" style="display:none">
						<div class='col-sm-12'>
							<div class='box'>
								<div class='box-header <?php echo BOXHEADER; ?>-background' id="program_activity_details_header">
									<div class='title'><?php echo $this->lang->line('Program Progress Details') ?></div>
									<div class='actions'>
										<a class="btn box-collapse btn-xs btn-link" href="#"><i></i>
										</a>
									</div>
								</div>
								<div class='box-content'>
									<div class='validation'></div>
									<form class='form form-horizontal validate-form save_form'>
										<div class='form-group' id="empty_activity_list_message">
											
										</div>
														
										<div id="add_new_activity_button">
											<?php
											if (isset($SVM_DSM_Donation_Add_Program_Progress_Permissions)){
											?>
												<a class='btn btn-success btn-sm new' onclick="addNewProgramActivity('0')"><?php echo $this->lang->line('Add New Activity') ?></a>
												<p>&nbsp;
											<?php
											}
											?>
										</div>
										
										<div class='loader' align="center"><img src="<?php echo base_url();?>assets/images/ajax-loader.gif"/> Loading data...</div>

										<!--showing tabale-->
										<div id="dataTable">
										</div>
										<!--end table -->
										
										<p style="margin-bottom:2px">&nbsp;</p>
										<div class='row' id="program_progress_summary_details" style="height:370px;">
											<div  class='col-sm-4 controls'>
												<div  class='col-sm-12 controls'>
													<label class='control-label col-sm-7'><?php echo $this->lang->line('Fund Available') ?></label>
													<div class='col-sm-5 controls'>
														<input class='form-control input-sm' id='budget_available'  type='text' value="" disabled style="color: green">
													</div>
												</div>
												<p style="margin-top:10px">&nbsp;</p>
												<div  class='col-sm-12 controls'>
													<label class='control-label col-sm-7'><?php echo $this->lang->line('Budget Estimated') ?></label>
													<div class='col-sm-5 controls'>
														<input class='form-control input-sm' id='program_budget'  type='text' value="" disabled>
													</div>
												</div>
												<p style="margin-top:10px">&nbsp;</p>
												<div  class='col-sm-12 controls'>
													<label class='control-label col-sm-7'><?php echo $this->lang->line('Budget Deficiency') ?></label>
													<div class='col-sm-5 controls'>
														<input class='form-control input-sm' id='budget_deficiency'  type='text' value="" disabled style="color: red">
													</div>
												</div>
												<p style="margin-top:10px">&nbsp;</p>
												<div  class='col-sm-12 controls'>
													<label class='control-label col-sm-7'><?php echo $this->lang->line('Activity Cost Total') ?></label>
													<div class='col-sm-5 controls'>
														<input class='form-control input-sm' id='activity_cost_total'  type='text' value="" disabled>
													</div>
												</div>
												<p style="margin-top:10px">&nbsp;</p>
												<div  class='col-sm-12 controls'>
													<label class='control-label col-sm-7'><?php echo $this->lang->line('Overall Budget Varience') ?></label>
													<div class='col-sm-5 controls'>
														<input class='form-control input-sm' id='overall_budget_varience'  type='text' value="" disabled style="color: red">
													</div>
												</div>
												<p style="margin-top:10px">&nbsp;</p>
												<div  class='col-sm-12 controls'>
													<label class='control-label col-sm-7'><?php echo $this->lang->line('Program Start Date') ?></label>
													<div class='col-sm-5 controls'>
														<input class='form-control input-sm' id='program_start_date'  type='text' value="" disabled>
													</div>
												</div>
												<p style="margin-top:10px">&nbsp;</p>
												<div  class='col-sm-12 controls'>
													<label class='control-label col-sm-7'><?php echo $this->lang->line('Program Finish Date') ?></label>
													<div class='col-sm-5 controls'>
														<input class='form-control input-sm' id='program_finish_date'  type='text' value="" disabled>
													</div>
												</div>
												<p style="margin-top:10px">&nbsp;</p>
												<div  class='col-sm-12 controls'>
													<label class='control-label col-sm-7'><?php echo $this->lang->line('Actual Program Start Date') ?></label>
													<div class='col-sm-5 controls'>
														<input class='form-control input-sm' id='actual_program_start_date'  type='text' value="" disabled>
													</div>
												</div>
												<p style="margin-top:10px">&nbsp;</p>
												<div  class='col-sm-12 controls'>
													<label class='control-label col-sm-7'><?php echo $this->lang->line('Actual Program Finished Date') ?></label>
													<div class='col-sm-5 controls'>
														<input class='form-control input-sm' id='actual_program_finished_date'  type='text' value="" disabled>
													</div>
												</div>
											</div>
											<div class="box col-sm-8">
												<div class='box-content'  style="height:370px;">
													<div class='col-sm-12 controls'>
														<label class='control-label col-sm-12' style="text-align:center; font-size: 18px"><?php echo $this->lang->line('Program Progress Status') ?></label>		
													</div>
													<p style="margin-top:3px">&nbsp;</p>
													<div class='col-sm-6 controls' id="budget_progress_div">
														<div class='col-sm-12 controls'>
															<label class='control-label col-sm-12' style="text-align:center"><?php echo $this->lang->line('Progress in Terms of Budget') ?></label>
														</div>
													</div>
													<div class='col-sm-6 controls' id="activity_completion_progress_div">
														<div class='col-sm-12 controls'>
															<label class='control-label col-sm-12' style="text-align:center"><?php echo $this->lang->line('Progress in Terms of Activity Completion') ?></label>
														</div>
													</div>
												</div>
											</div>
										</div>
									</form>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
							
			<div class='modal fade' id='modal-program_activity' tabindex='-1'>
				<div class='modal-dialog' style="height:450px;width:680px">
					<div class='modal-content'>
						<div class='modal-header'>
							<button aria-hidden='true' class='close' data-dismiss='modal' type='button'>x</button>
							<h4 class='modal-title' id='modal_title'><?php echo $this->lang->line('Program Activity Details') ?></h4>
						</div>

						<form enctype="text/plain" accept-charset="utf-8" name="formname" id="program_activity_form"  method="post" action="">
							<div class='modal-body'>
								<div class='modal_msg_data'></div>
								<div id='table'>
									<div class='row'>
										<div class='col-sm-12'>
											<div class='box' id="add_edit_program_activity">
												<div class='box-header <?php echo BOXHEADER; ?>-background'>
													<div class='title'><?php echo $this->lang->line('Add Program Activity') ?></div>
													<div class='actions'>
														<a class='btn box-collapse btn-xs btn-link' href='#'><i></i>
														</a>
													</div>
												</div>
												<div class='box-content'>
													<div class='form-group'>
														<input class='form-control' id='program_id' name='program_id' type='hidden'>
														<input class='form-control' id='activity_id' name='activity_id' type='hidden'>

														<label class='control-label col-sm-3'><?php echo $this->lang->line('Activity Name') ?> *</label>
														<div class='col-sm-9 controls'>
															<input class='form-control input-sm' id='activity_name' name='activity_name'
																   placeholder='<?php echo $this->lang->line('Activity Name')?>' type='text'
																   value="<?php echo set_value('activity_name'); ?>">
															<div id="activity_nameError" class="red"></div>
														</div>
													</div>
													<p style="margin-bottom:2px">&nbsp;</p>
													<div class='form-group'>
														<label class='control-label col-sm-3'><?php echo $this->lang->line('Start Date') ?> *</label>
														<div class='col-sm-9 controls'>
															<div class='datepicker-input input-group' id='datepicker_start_date'>
																<input class='form-control' id='start_date' name='start_date'
																	   data-format='YYYY-MM-DD' placeholder='<?php echo $this->lang->line('Start Date') ?>' type='text' value="<?php echo date('Y-m-d') ?>">
																  <span class="input-group-addon">
																		<span class="glyphicon glyphicon-calendar"/>
																  </span>
															</div>
															<div id="start_dateError" class="red"></div>
														</div>
													</div>
													<p style="margin-bottom:2px">&nbsp;</p>
													<div class='form-group'>
														<label class='control-label col-sm-3'><?php echo $this->lang->line('Finish Date') ?> *</label>
														<div class='col-sm-9 controls'>
															<div class='datepicker-input input-group' id='datepicker_finish_date'>
																<input class='form-control' id='finish_date' name='finish_date'
																	   data-format='YYYY-MM-DD' placeholder='<?php echo $this->lang->line('Finish Date') ?>' type='text' value="<?php echo date('Y-m-d') ?>">
																  <span class="input-group-addon">
																		<span class="glyphicon glyphicon-calendar"/>
																  </span>
															</div>
															<div id="finish_dateError" class="red"></div>
														</div>
													</div>
													<p style="margin-bottom:2px">&nbsp;</p>
													<div class='form-group'>
														<label class='control-label col-sm-3'><?php echo $this->lang->line('Activity Owner') ?> *</label>
														<div class='col-sm-9 controls'>
															<div id="activity_owner_dropdown">
															</div>
															<div id="activity_owner_idError" class="red"></div>
														</div>
													</div>
													<p style="margin-bottom:2px">&nbsp;</p>
													<div class='form-group'>
														<label class='control-label col-sm-3'><?php echo $this->lang->line('Activity Budget') ?> *</label>
														<div class='col-sm-9 controls'>
															<input class='form-control input-sm' id='activity_budget' name='activity_budget'
																   placeholder='<?php echo $this->lang->line('Activity Budget')?>' type='text'
																   value="<?php echo set_value('activity_budget'); ?>" onblur="handleActivityBudgetAddition(this.id);">
															<div id="activity_budgetError" class="red"></div>
														</div>
													</div>
													<div id="actual_start_finished_date_edit">
														<p style="margin-bottom:2px">&nbsp;</p>
														<div class='form-group'>
															<label class='control-label col-sm-3'><?php echo $this->lang->line('Actual Start Date') ?></label>
															<div class='col-sm-9 controls'>
																<div class='datepicker-input input-group' id='datepicker_actual_start_date'>
																	<input class='form-control' id='actual_start_date' name='actual_start_date'
																		   data-format='YYYY-MM-DD' placeholder='<?php echo $this->lang->line('Actual Start Date') ?>' type='text' value="<?php echo date('Y-m-d') ?>">
																	  <span class="input-group-addon">
																			<span class="glyphicon glyphicon-calendar"/>
																	  </span>
																</div>
																<div id="actual_start_dateError" class="red"></div>
															</div>
														</div>
														<p style="margin-bottom:2px">&nbsp;</p>
														<div class='form-group'>
															<label class='control-label col-sm-3'><?php echo $this->lang->line('Actual Finished Date') ?></label>
															<div class='col-sm-9 controls'>
																<div class='datepicker-input input-group' id='datepicker_actual_finished_date'>
																	<input class='form-control' id='actual_finished_date' name='actual_finished_date'
																		   data-format='YYYY-MM-DD' placeholder='<?php echo $this->lang->line('Actual Finished Date') ?>' type='text' value="<?php echo date('Y-m-d') ?>">
																	  <span class="input-group-addon">
																			<span class="glyphicon glyphicon-calendar"/>
																	  </span>
																</div>
																<div id="actual_finished_dateError" class="red"></div>
															</div>
														</div>
													</div>
													<p style="margin-bottom:5px">&nbsp;</p>
													<div class='form-actions' style='margin-bottom:0'>
														<div class='row'>
															<div class='col-sm-9 col-sm-offset-3'>
																<?php
																if (isset($SVM_DSM_Donation_Add_Program_Progress_Permissions)) {
																	?>
																	<button class='btn btn-success save'
																			onclick='saveProgramActivityData();' type='button'>
																		<i class='icon-save'></i>
																		<?php echo $this->lang->line('Save') ?>
																	</button>
																	<?php
																}
																?>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
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
							
			<div class='modal fade' id='modal-program_activity_budget_issue' tabindex='-1'>
				<div class='modal-dialog' style="height:550px;width:600px">
					<div class='modal-content'>
						<div class='modal-header'>
							<button aria-hidden='true' class='close' data-dismiss='modal' type='button'>x</button>
							<h4 class='modal-title' id='modal_title_program_activity_budget_issue'><?php echo $this->lang->line('Program Activity Budget Issue Information') ?></h4>
						</div>

						<form enctype="text/plain" accept-charset="utf-8" name="formname" id="program_activity_budget_issue_form"  method="post" action="">
							<div class='modal-body'>
								<div class='modal_msg_data'></div>
								<div id='table'>
									<div class='row'>
										<div class='col-sm-12'>
											<div class='box' id="add_edit_program_activity_budget_issue">
												<div class='box-header <?php echo BOXHEADER; ?>-background'>
													<div class='title'><?php echo $this->lang->line('Program Activity Budget Issue') ?></div>
													<div class='actions'>
														<a class='btn box-collapse btn-xs btn-link' href='#'><i></i>
														</a>
													</div>
												</div>
												<div class='box-content'>
													<div class='form-group'>
														<div class='col-sm-12 controls'>
															<input class='form-control' id='program_id_in_budget_issue_screen' name='program_id_in_budget_issue_screen' type='hidden'>
															<input class='form-control' id='activity_id_in_budget_issue_screen' name='activity_id_in_budget_issue_screen' type='hidden'>
															<input class='form-control' id='budget_issue_id' name='budget_issue_id' type='hidden'>
															<label class='control-label col-sm-5'><?php echo $this->lang->line('Reference Number') ?> *</label>
															<div class='col-sm-7 controls'>
																<input class='form-control' id='budget_issue_reference_no' name='budget_issue_reference_no'
																	   placeholder='<?php echo $this->lang->line('Reference Number') ?>' type='text' 
																	   value="">
																<div id="budget_issue_reference_noError" class="red"></div>
															</div>
														</div>
													</div>
													<p style="margin-bottom:4px">&nbsp;</p>
													<div class='form-group'>
														<div class='col-sm-12 controls'>
															<label class='control-label col-sm-5'><?php echo $this->lang->line('Date') ?> *</label>
															<div class='col-sm-7 controls'>
																<div class='datepicker-input input-group' id='datepicker_issue_date'>
																	<input class='form-control' id='issue_date' name='issue_date'
																		   data-format='YYYY-MM-DD' placeholder='<?php echo $this->lang->line('Issue Date') ?>' type='text' value="<?php echo date('Y-m-d') ?>">
																	  <span class="input-group-addon">
																			<span class="glyphicon glyphicon-calendar"/>
																	  </span>
																</div>
																<div id="issue_dateError" class="red"></div>
															</div>
														</div>
													</div>
													<p style="margin-bottom:4px">&nbsp;</p>
													<div class='form-group'>
														<div class='col-sm-12 controls'>
															<label class='control-label col-sm-5'><?php echo $this->lang->line('Budget Issue Amount') ?> *</label>
															<div class='col-sm-7 controls'>
																<input class='form-control input-sm' id='budget_issue_amount' name='budget_issue_amount'
																	   placeholder='<?php echo $this->lang->line('Budget Issue Amount')?>' type='text'
																	   value="<?php echo set_value('budget_issue_amount'); ?>" onblur="handleBudgetIssueAmountAddition(this.id);">
																<div id="budget_issue_amountError" class="red"></div>
															</div>
														</div>
													</div>
													<p style="margin-bottom:30px">&nbsp;</p>
													<div class='form-actions' style='margin-bottom:0'>
														<div class='row'>
															<div class='col-sm-6 col-sm-offset-2'>
																<?php
																if (isset($SVM_DSM_Donation_Add_Program_Progress_Permissions)) {
																	?>
																	<button class='btn btn-success save'
																			onclick='saveProgramActivityBudgetIssueData();' type='button'>
																		<i class='icon-save'></i>
																		<?php echo $this->lang->line('Save') ?>
																	</button>
																	<?php
																}
																?>

																<button class='btn btn-warning cancel' onclick='cancelProgramActivityBudgetIssueData();'
																		type='button'>
																	<i class='icon-ban-circle'></i>
																	<?php echo $this->lang->line('Close') ?>
																</button>
															</div>
														</div>
													</div>
												</div>
											</div>

											<div id='table'>
												<div class='row'>
													<div class='col-sm-12'>
														<div class='box bordered-box <?php echo BOXHEADER; ?>-border' style='margin-bottom:0;'>
															<a class='btn btn-success btn-sm' type='button' id='add_new_program_activity_budget_issue' onclick="showAddEditProgramActivityBudgetIssueForm(this.id);"><?php echo $this->lang->line('Add New Budget Issue') ?></a>
															<p style="margin-bottom:1px">&nbsp;</p>	
															<p class='text-info' id="activity_name_on_budget_issue"></p>
															<!--showing table-->
															<div id="programActivityBudgetIssueDataTable">
															</div>
															<!--end table -->
														</div>
													</div>
												</div>
											</div>
										</div>
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
							
			<div class='modal fade' id='modal-program_activity_budget_return' tabindex='-1'>
				<div class='modal-dialog' style="height:550px;width:600px">
					<div class='modal-content'>
						<div class='modal-header'>
							<button aria-hidden='true' class='close' data-dismiss='modal' type='button'>x</button>
							<h4 class='modal-title' id='modal_title_program_activity_budget_return'><?php echo $this->lang->line('Program Activity Budget Return Information') ?></h4>
						</div>

						<form enctype="text/plain" accept-charset="utf-8" name="formname" id="program_activity_budget_return_form"  method="post" action="">
							<div class='modal-body'>
								<div class='modal_msg_data'></div>
								<div id='table'>
									<div class='row'>
										<div class='col-sm-12'>
											<div class='box' id="add_edit_program_activity_budget_return">
												<div class='box-header <?php echo BOXHEADER; ?>-background'>
													<div class='title'><?php echo $this->lang->line('Program Activity Budget Return') ?></div>
													<div class='actions'>
														<a class='btn box-collapse btn-xs btn-link' href='#'><i></i>
														</a>
													</div>
												</div>
												<div class='box-content'>
													<div class='form-group'>
														<div class='col-sm-12 controls'>
															<input class='form-control' id='program_id_in_budget_return_screen' name='program_id_in_budget_return_screen' type='hidden'>
															<input class='form-control' id='activity_id_in_budget_return_screen' name='activity_id_in_budget_return_screen' type='hidden'>
															<input class='form-control' id='budget_return_id' name='budget_return_id' type='hidden'>
															
															<label class='control-label col-sm-5'><?php echo $this->lang->line('Reference Number') ?> *</label>
															<div class='col-sm-7 controls'>
																<input class='form-control' id='budget_return_reference_no' name='budget_return_reference_no'
																	   placeholder='<?php echo $this->lang->line('Reference Number') ?>' type='text' 
																	   value="">
																<div id="budget_return_reference_noError" class="red"></div>
															</div>
														</div>
													</div>
													<p style="margin-bottom:4px">&nbsp;</p>
													<div class='form-group'>
														<div class='col-sm-12 controls'>
															<label class='control-label col-sm-5'><?php echo $this->lang->line('Date') ?> *</label>
															<div class='col-sm-7 controls'>
																<div class='datepicker-input input-group' id='datepicker_return_date'>
																	<input class='form-control' id='return_date' name='return_date'
																		   data-format='YYYY-MM-DD' placeholder='<?php echo $this->lang->line('Return Date') ?>' type='text' value="<?php echo date('Y-m-d') ?>">
																	  <span class="input-group-addon">
																			<span class="glyphicon glyphicon-calendar"/>
																	  </span>
																</div>
																<div id="return_dateError" class="red"></div>
															</div>
														</div>
													</div>
													<p style="margin-bottom:4px">&nbsp;</p>
													<div class='form-group'>
														<div class='col-sm-12 controls'>
															<label class='control-label col-sm-5'><?php echo $this->lang->line('Budget Return Amount') ?> *</label>
															<div class='col-sm-7 controls'>
																<input class='form-control input-sm' id='budget_return_amount' name='budget_return_amount'
																	   placeholder='<?php echo $this->lang->line('Budget Return Amount')?>' type='text'
																	   value="<?php echo set_value('budget_return_amount'); ?>" onblur="handleBudgetReturnAmountAddition(this.id);">
																<div id="budget_return_amountError" class="red"></div>
															</div>
														</div>
													</div>
													<p style="margin-bottom:30px">&nbsp;</p>
													<div class='form-actions' style='margin-bottom:0'>
														<div class='row'>
															<div class='col-sm-6 col-sm-offset-2'>
																<?php
																if (isset($SVM_DSM_Donation_Add_Program_Progress_Permissions)) {
																	?>
																	<button class='btn btn-success save'
																			onclick='saveProgramActivityBudgetReturnData();' type='button'>
																		<i class='icon-save'></i>
																		<?php echo $this->lang->line('Save') ?>
																	</button>
																	<?php
																}
																?>

																<button class='btn btn-warning cancel' onclick='cancelProgramActivityBudgetReturnData();'
																		type='button'>
																	<i class='icon-ban-circle'></i>
																	<?php echo $this->lang->line('Close') ?>
																</button>
															</div>
														</div>
													</div>
												</div>
											</div>

											<div id='table'>
												<div class='row'>
													<div class='col-sm-12'>
														<div class='box bordered-box <?php echo BOXHEADER; ?>-border' style='margin-bottom:0;'>
															<a class='btn btn-success btn-sm' type='button' id='add_new_program_activity_budget_return' onclick="showAddEditProgramActivityBudgetReturnForm(this.id);"><?php echo $this->lang->line('Add New Budget Return') ?></a>
															<p style="margin-bottom:1px">&nbsp;</p>	
															<p class='text-info' id="activity_name_on_budget_return"></p>
															<!--showing table-->
															<div id="programActivityBudgetReturnDataTable">
															</div>
															<!--end table -->
														</div>
													</div>
												</div>
											</div>
										</div>
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
							
			<div class='modal fade' id='modal-program_activity_progress' tabindex='-1'>
				<div class='modal-dialog' style="height:350px;width:700px">
					<div class='modal-content'>
						<div class='modal-header'>
							<button aria-hidden='true' class='close' data-dismiss='modal' type='button'>x</button>
							<h4 class='modal-title' id='modal_title_product_batch'><?php echo $this->lang->line('Program Activity Progress') ?></h4>
						</div>

						<form enctype="text/plain" accept-charset="utf-8" name="formname" id="program_activity_progress_form"  method="post" action="">
							<div class='modal-body'>
								<div id='table'>
									<div class='row'>
										<div class='col-sm-12'>
											<div class='box' id="edit_program_activity_progress">
												<div class='box-content'>
													<div class='form-group'>
														<div class="project col-sm-12">
															<input class='form-control' id='program_id_in_activity_progress_screen' name='program_id_in_activity_progress_screen' type='hidden'>
															<input class='form-control' id='activity_id_in_activity_progress_screen' name='activity_id_in_activity_progress_screen' type='hidden'>
															<h1 class="text-center" id="program_activity_name" style="color: #b064cd"></h1>
															<h2 class="text-center">
																<label class="percent" id="percent"/>
															</h2>
															<h3 class="text-center" style="color:  #807f81 "><?php echo $this->lang->line('completed') ?></h3>
															<div class="slider" id="slider"></div>
														 </div>
													</div>
												</div>
											</div>
										</div>
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
		</div>

<script src="<?php echo base_url(); ?>ajax/jquery.js"></script>
<script src="<?php echo base_url(); ?>ajax/validate.js"></script>

<script>
	
	$(document).ready(function () {
		$("#program_activity_details_header").hide();
		$("#actual_start_finished_date_edit").hide();
		$("#add_edit_program_activity_budget_issue").hide();
		$("#add_edit_program_activity_budget_return").hide();
		ProgramProgress.getActivityOwnerList();
		
		$("#datepicker_start_date").datetimepicker({
			format: 'YYYY-MM-DD'
		});
		$("#datepicker_finish_date").datetimepicker({
			format: 'YYYY-MM-DD'
		});
		$("#datepicker_actual_start_date").datetimepicker({
			format: 'YYYY-MM-DD'
		});
		$("#datepicker_actual_finished_date").datetimepicker({
			format: 'YYYY-MM-DD'
		});
		$("#datepicker_issue_date").datetimepicker({
			format: 'YYYY-MM-DD'
		});
		$("#datepicker_return_date").datetimepicker({
			format: 'YYYY-MM-DD'
		});
		
		$("#percent").text("0%");
		$("#percent").css({
			'color': '#FF0000'
		});
	});

	function saveProgramActivityData() {
		if (validateProgramActivityDataForm_save()) {
			ProgramProgress.saveProgramActivityData();
		}
	}

	function getProgramActivityData(id){
		$(".loader").show();
		$(".msg_data").hide();
		$(".msg_delete").hide();
		$(".validation").hide();
		ProgramProgress.getProgramActivityData(id);
	}

	function deleteProgramActivityData(id){
		$(".msg_data").hide();
		$(".msg_delete").hide();
		$(".validation").hide();
		ProgramProgress.deleteProgramActivityData(id);
	}
	
	function getProgramProgressDetails(id) {
		var programId = $("#" + id).val();
		ProgramProgress.getProgramActivityList(programId);
	}
	
	function addNewProgramActivity(programId) {
		if (programId == "0") {
			programId = $("#program_id").val();
		}
		clearForm();
		openProgramActivityDialog(programId);
	}
	
	function handleActivityBudgetAddition(id) {
		var amount = $("#" + id).val();
		if (amount != "") {
			var amountData = amount.split(".");
			var amountDataSize = amountData.length;

			if (amountDataSize == 1) {
				amount = amount + ".00";
				$("#" + id).val(amount);
			} else {
				$("#" + id).val(parseFloat(amount).toFixed(2));
			}
		}
	}
	
	function handleBudgetIssueAmountAddition(id) {
		var amount = $("#" + id).val();
		if (amount != "") {
			var amountData = amount.split(".");
			var amountDataSize = amountData.length;

			if (amountDataSize == 1) {
				amount = amount + ".00";
				$("#" + id).val(amount);
			} else {
				$("#" + id).val(parseFloat(amount).toFixed(2));
			}
		}
	}
	
	function handleBudgetReturnAmountAddition(id) {
		var amount = $("#" + id).val();
		if (amount != "") {
			var amountData = amount.split(".");
			var amountDataSize = amountData.length;

			if (amountDataSize == 1) {
				amount = amount + ".00";
				$("#" + id).val(amount);
			} else {
				$("#" + id).val(parseFloat(amount).toFixed(2));
			}
		}
	}
	
	function issueMoney(programId, programActivityId, programActivityName) {
		var programActivityNameField = String(programActivityName);
		$("#activity_name_on_budget_issue").html('<strong><?php echo $this->lang->line('Activity Name') ?>' + " : </strong>" + programActivityNameField.replace(/\//g,""));
		getBudgetIssueTableData(programActivityId);
		openProgramActivityBudgetIssueDialog(programId, programActivityId);
	}
	
	function collectMoney(programId, programActivityId, programActivityName) {
		var programActivityNameField = String(programActivityName);
		$("#activity_name_on_budget_return").html('<strong><?php echo $this->lang->line('Activity Name') ?>' + " : </strong>" + programActivityNameField.replace(/\//g,""));
		getBudgetReturnTableData(programActivityId);
		openProgramActivityBudgetReturnDialog(programId, programActivityId);
	}
	
	function showAddEditProgramActivityBudgetIssueForm() {
		$("#add_edit_program_activity_budget_issue").show();
	}
	
	function showAddEditProgramActivityBudgetReturnForm() {
		$("#add_edit_program_activity_budget_return").show();
	}
	
	function cancelProgramActivityBudgetIssueData() {
		$(".modal_msg_data").hide();
		$("#budget_issue_amount").val('');
		$("#add_edit_program_activity_budget_issue").hide();
	}
	
	function cancelProgramActivityBudgetReturnData() {
		$(".modal_msg_data").hide();
		$("#budget_return_amount").val('');
		$("#add_edit_program_activity_budget_return").hide();
	}
	
	function saveProgramActivityBudgetIssueData() {
		if (validateProgramBudgetIssueDataForm_save()) {
			ProgramProgress.saveProgramActivityBudgetIssueData();
		}
	}
	
	function saveProgramActivityBudgetReturnData() {
		if (validateProgramBudgetReturnDataForm_save()) {
			ProgramProgress.saveProgramActivityBudgetReturnData();
		}
	}
	
	function getBudgetIssueData(id){
		$(".loader").show();
		$(".msg_data").hide();
		$(".msg_delete").hide();
		$(".validation").hide();
		ProgramProgress.getBudgetIssueData(id);
	}
	
	function getBudgetReturnData(id){
		$(".loader").show();
		$(".msg_data").hide();
		$(".msg_delete").hide();
		$(".validation").hide();
		ProgramProgress.getBudgetReturnData(id);
	}

	function deleteBudgetIssueData(activityId, budgetIssueId){
		$(".msg_data").hide();
		$(".msg_delete").hide();
		$(".validation").hide();
		ProgramProgress.deleteBudgetIssueData(activityId, budgetIssueId);
	}
	
	function deleteBudgetReturnData(activityId, budgetReturnId){
		$(".msg_data").hide();
		$(".msg_delete").hide();
		$(".validation").hide();
		ProgramProgress.deleteBudgetReturnData(activityId, budgetReturnId);
	}
	
	function updateActivityProgress(programId, programActivityId, programActivityName, activityCompletion) {
		var programActivityNameField = String(programActivityName);
		$("#program_activity_name").text( programActivityNameField.replace(/\//g,""));
		$("#percent").text(activityCompletion + "%");
		$("#activity_id_in_activity_progress_screen").val('');
		$("#slider").slider( "value", activityCompletion );
		
		openProgramActivityProgressDialog(programId, programActivityId);
	}
	
	$(function() {
		$('.project').each(function() {
			var $projectBar = $(this).find('.slider');
			var $projectPercent = $(this).find('.percent');
			$projectBar.slider({
				range: "min",
				animate: true,
				value: 1,
				min: 0,
				max: 100,
				step: 1,
				slide: function(event, ui) {
					$projectPercent.text(ui.value + "%");
				},
				change: function(event, ui) {
					var $projectRange = $(this).find('.ui-slider-range');
					var percent = ui.value;
					if (percent <= 20) {
						$projectPercent.css({
							 'color': '#FF0000'
						});
						$projectRange.css({
							'background': '#FF0000'
						});
					} else if (percent > 21 && percent <= 40) {
						$projectPercent.css({
							'color': '#F7FE2E'
						});
						$projectRange.css({
							'background': '#F7FE2E'
						});
					} else if (percent > 41  && percent <= 60) {
						$projectPercent.css({
							'color': '#FE2EF7'
						});
						$projectRange.css({
							'background': '#FE2EF7'
						});
					} else if (percent > 61  && percent <= 80) {
						$projectPercent.css({
							'color': '#5858FA'
						});
						$projectRange.css({
							'background': '#5858FA'
						});
					} else if (percent > 81) {
						$projectPercent.css({
							'color': '#01DF01'
						});
						$projectRange.css({
							'background': '#01DF01'
						});
					}
					
					ProgramProgress.saveProgramActivityProgress(percent);
				}
			});
		})
	});
	
	//start ProgramProgress object
	var ProgramProgress = {
		cancelData: function () {
			$(".form").hide();
		},

		saveProgramActivityData: function () {
			var msg = '<div class="alert alert-success alert-dismissable">' +
				'<a class="close" href="#" data-dismiss="alert">x </a>' +
				'<h4><i class="icon-ok-sign"></i>' +
				'<?php echo $this->lang->line('success')?></h4>' +
				'<?php echo $this->lang->line('success_saved')?>' +
				'</div>';
		
			var msg_no_changes_to_save = '<div class="alert alert-warning alert-dismissable">' +
				'<a class="close" href="#" data-dismiss="alert">x </a>' +
				'<h4><i class="icon-info-sign"></i>' +
				'<?php echo $this->lang->line('warning')?></h4>' +
				'<?php echo $this->lang->line('no_changes_to_save')?>' +
				'</div>';
		
			$.ajax({
				type: "POST",
				url: "<?php echo base_url(); ?>serviceManagerModule/donationManagerModule/donationSection/program_progress_controller/saveProgramActivityData",
				data: {
					'activity_id' : $("#activity_id").val(),
					'program_id' : $("#program_id").val(),
					'activity_name' : $("#activity_name").val(),
					'start_date' : $("#start_date").val(),
					'finish_date' : $("#finish_date").val(),
					'activity_owner_id' : $("#activity_owner_id").val(),
					'activity_budget' : $("#activity_budget").val(),
					'actual_start_date' : $("#actual_start_date").val(),
					'actual_finished_date' : $("#actual_finished_date").val(),
					<?php echo $this->security->get_csrf_token_name(); ?>:'<?php echo $this->security->get_csrf_hash(); ?>'
				},
				dataType: 'html',
				beforeSend: function () {
					$(".save:input").attr('disabled', true);
				},
				success: function (response) {
					if (response == 'ok') {
						$(".validation").hide();
						$(".modal_msg_data").show();
						$(".modal_msg_data").html(msg);
						$(".save:input").attr('disabled', false);

						clearForm();
						
						$("#program_activity_details_header").show();
						$("#add_new_activity_button").show();
						$("#program_progress_summary_details").show();
						$("#empty_activity_list_message").hide();
						$("#actual_start_finished_date_edit").hide();
						ProgramProgress.getProgramActivityList($("#program_id").val());
						getProgramActivityTableData($("#program_id").val());
					} else if (response == 'no_changes_to_save') {
						$(".modal_msg_data").show();
						$(".modal_msg_data").html(msg_no_changes_to_save);
						$(".save:input").attr('disabled', false);
					}
				}
			})
		},

		deleteProgramActivityData: function (id) {
			var bConfirm = confirm("<?php echo $this->lang->line('Are you sure you want to delete').$this->lang->line('program activity details') ?>?");
			if (bConfirm) {
				$.ajax({
					type: "POST",
					url: "<?php echo base_url(); ?>serviceManagerModule/donationManagerModule/donationSection/program_progress_controller/deleteProgramActivity",
					data: {
						'id': id,
						'<?php echo $this->security->get_csrf_token_name(); ?>':
							'<?php echo $this->security->get_csrf_hash(); ?>'
					},
					dataType: 'html',
					success:function (response) {
						$(".msg_delete").show();
						$(".msg_delete").html(response);

						getProgramActivityTableData($("#program_id").val());
					}
				})
			}
		},

		getProgramActivityData: function (id) {
		
			var programId = $("#program_id").val();
		
			$.ajax({
				type: "POST",
				url: "<?php echo base_url(); ?>serviceManagerModule/donationManagerModule/donationSection/program_progress_controller/getProgramActivityData",
				data: {
					'id': id,
					'<?php echo $this->security->get_csrf_token_name(); ?>':'<?php echo $this->security->get_csrf_hash(); ?>'
				},
				dataType: 'json',
				success:function (response) {
					$(".loader").hide();
					
					$("#activity_id").val(id);
					$("#activity_name").val(response.programActivitiesName);
					$("#start_date").val(response.startDate);
					$("#finish_date").val(response.finishDate);
					$("#activity_owner_id").val(response.activityOwnerId);
					$("#activity_budget").val(response.activityBudget);
					$("#actual_start_date").val(response.actualStartDate);
					$("#actual_finished_date").val(response.actualFinishedDate);
					$("#actual_start_finished_date_edit").show();
					openProgramActivityDialog(programId);
					
					$("#datepicker_start_date").datetimepicker({
						format: 'YYYY-MM-DD'
					});
					$("#datepicker_finish_date").datetimepicker({
						format: 'YYYY-MM-DD'
					});
					$("#datepicker_actual_start_date").datetimepicker({
						format: 'YYYY-MM-DD'
					});
					$("#datepicker_actual_finished_date").datetimepicker({
						format: 'YYYY-MM-DD'
					});
				}
			})
		},
		
		getProgramActivityList : function(programId) {
			$.ajax({
				type:"POST",
				url: "<?php echo base_url(); ?>serviceManagerModule/donationManagerModule/donationSection/program_progress_controller/getProgramActivityList",
				data: {
					'program_id' : programId,
					<?php echo $this->security->get_csrf_token_name(); ?>: '<?php echo $this->security->get_csrf_hash(); ?>'
				},
				dataType: 'json',
				success: function(response) {
					if (response.programActivitiesExists == false) {
						$("#program_activity_details").show();
						$("#empty_activity_list_message").show();
						$("#program_activity_details_header").hide();
						$("#add_new_activity_button").hide();
						$("#program_progress_summary_details").hide();
						$(".loader").hide();
						$(".msg_data").hide();
						$(".validation").hide();
						$("#dataTable").hide();
						$("#empty_activity_list_message").html("<label class='control-label col-sm-12' style='text-align:center; color:blue;'><?php echo $this->lang->line('Thid program still does not have any activities scheduled. Click ') ?> <a onclick='addNewProgramActivity(" + programId + ")' href='#' style='color:orange;'>here</a> <?php echo $this->lang->line(' to add activities to the program.') ?></label>");
					} else {
						$(".loader").show();
						$(".msg_data").hide();
						$(".validation").hide();
						$("#program_activity_details").show();
						$("#program_activity_details_header").show();
						$("#add_new_activity_button").show();
						$("#empty_activity_list_message").hide();
						$("#program_progress_summary_details").show();
						$("#budget_available").val(response.budgetAvailableTotal);
						$("#program_budget").val(response.budgetTotal);
						$("#budget_deficiency").val(response.budgetDeficiency);
						$("#activity_cost_total").val(response.activityCostTotal);
						$("#overall_budget_varience").val(response.budgetVarience);
						$("#program_start_date").val(response.programStartDate);
						$("#actual_program_start_date").val(response.actualProgramStartDate);
						$("#program_finish_date").val(response.programFinishDate);
						$("#actual_program_finished_date").val(response.actualProgramFinishedDate);
						
						$("#budget_progress").remove();
						$("#activity_completion_progress").remove();
						
						$("#budget_progress_div").append("<div  class='progress-bar'  id='budget_progress' data-percent=" + response.budgetProgress + " data-color='#ccc,yellow' style='margin-left:52px; margin-top: 20px;'></div>");
						
						$("#activity_completion_progress_div").append("<div  class='progress-bar'  id='activity_completion_progress' data-percent=" + response.activityCompletionProgress + " data-color='#ccc,orange' style='margin-left:52px; margin-top: 20px;'></div>");
						
						$("#budget_progress").loading();
						$("#activity_completion_progress").loading();
						getProgramActivityTableData(programId);
					}
				}
			});
		},

		getActivityOwnerList: function(){
			$.ajax({
				type:"POST",
				url: "<?php echo base_url(); ?>organizationManagerModule/adminSection/peoples_controller/getAllEmployeesAndMembersToDropDown",
				data: {
					<?php echo $this->security->get_csrf_token_name(); ?>: '<?php echo $this->security->get_csrf_hash(); ?>'
				},
				dataType: 'html',
				success: function(response) {
					$("#activity_owner_dropdown").html(response);
					$("#activity_owner_dropdown").find("#people_id").prop({ id: "activity_owner_id"});
				}
			});
		},
		
		saveProgramActivityBudgetIssueData: function () {
			var msg = '<div class="alert alert-success alert-dismissable">' +
				'<a class="close" href="#" data-dismiss="alert">x </a>' +
				'<h4><i class="icon-ok-sign"></i>' +
				'<?php echo $this->lang->line('success')?></h4>' +
				'<?php echo $this->lang->line('success_saved')?>' +
				'</div>';
		
			var msg_no_changes_to_save = '<div class="alert alert-warning alert-dismissable">' +
				'<a class="close" href="#" data-dismiss="alert">x </a>' +
				'<h4><i class="icon-info-sign"></i>' +
				'<?php echo $this->lang->line('warning')?></h4>' +
				'<?php echo $this->lang->line('no_changes_to_save')?>' +
				'</div>';
		
			$.ajax({
				type: "POST",
				url: "<?php echo base_url(); ?>serviceManagerModule/donationManagerModule/donationSection/program_progress_controller/saveProgramActivityBudgetIssue",
				data: {
					'budget_issue_id' : $("#budget_issue_id").val(),
					'activity_id' : $("#activity_id_in_budget_issue_screen").val(),
					'reference_no' : $("#budget_issue_reference_no").val(),
					'issue_date' : $("#issue_date").val(),
					'budget_issue_amount' : $("#budget_issue_amount").val(),
					<?php echo $this->security->get_csrf_token_name(); ?>:'<?php echo $this->security->get_csrf_hash(); ?>'
				},
				dataType: 'html',
				beforeSend: function () {
					$(".save:input").attr('disabled', true);
				},
				success: function (response) {
					if (response == 'ok') {
						$(".validation").hide();
						$(".modal_msg_data").show();
						$(".modal_msg_data").html(msg);
						$(".save:input").attr('disabled', false);
						
						$("#budget_issue_id").val('');
						$("#budget_issue_reference_no").val('');
						$("#issue_date").val(moment().format('YYYY-MM-DD'));
						$("#budget_issue_amount").val('');

						getBudgetIssueTableData($("#activity_id_in_budget_issue_screen").val());
						ProgramProgress.getProgramActivityList($("#program_id_in_budget_issue_screen").val());
					} else if (response == 'no_changes_to_save') {
						$(".modal_msg_data").show();
						$(".modal_msg_data").html(msg_no_changes_to_save);
						$(".save:input").attr('disabled', false);
					}
				}
			})
		},
		
		saveProgramActivityBudgetReturnData: function () {
			var msg = '<div class="alert alert-success alert-dismissable">' +
				'<a class="close" href="#" data-dismiss="alert">x </a>' +
				'<h4><i class="icon-ok-sign"></i>' +
				'<?php echo $this->lang->line('success')?></h4>' +
				'<?php echo $this->lang->line('success_saved')?>' +
				'</div>';
		
			var msg_no_changes_to_save = '<div class="alert alert-warning alert-dismissable">' +
				'<a class="close" href="#" data-dismiss="alert">x </a>' +
				'<h4><i class="icon-info-sign"></i>' +
				'<?php echo $this->lang->line('warning')?></h4>' +
				'<?php echo $this->lang->line('no_changes_to_save')?>' +
				'</div>';
		
			$.ajax({
				type: "POST",
				url: "<?php echo base_url(); ?>serviceManagerModule/donationManagerModule/donationSection/program_progress_controller/saveProgramActivityBudgetReturn",
				data: {
					'budget_return_id' : $("#budget_return_id").val(),
					'activity_id' : $("#activity_id_in_budget_return_screen").val(),
					'reference_no' : $("#budget_return_reference_no").val(),
					'return_date' : $("#return_date").val(),
					'budget_return_amount' : $("#budget_return_amount").val(),
					<?php echo $this->security->get_csrf_token_name(); ?>:'<?php echo $this->security->get_csrf_hash(); ?>'
				},
				dataType: 'html',
				beforeSend: function () {
					$(".save:input").attr('disabled', true);
				},
				success: function (response) {
					if (response == 'ok') {
						$(".validation").hide();
						$(".modal_msg_data").show();
						$(".modal_msg_data").html(msg);
						$(".save:input").attr('disabled', false);
						
						$("#budget_return_id").val('');
						$("#budget_return_reference_no").val('');
						$("#return_date").val(moment().format('YYYY-MM-DD'));
						$("#budget_return_amount").val('');

						getBudgetReturnTableData($("#activity_id_in_budget_return_screen").val());
						ProgramProgress.getProgramActivityList($("#program_id_in_budget_return_screen").val());
					} else if (response == 'no_changes_to_save') {
						$(".modal_msg_data").show();
						$(".modal_msg_data").html(msg_no_changes_to_save);
						$(".save:input").attr('disabled', false);
					}
				}
			})
		},
		
		getBudgetIssueData: function (id) {
		
			var programId = $("#program_id").val();
		
			$.ajax({
				type: "POST",
				url: "<?php echo base_url(); ?>serviceManagerModule/donationManagerModule/donationSection/program_progress_controller/getBudgetIssueData",
				data: {
					'id': id,
					'<?php echo $this->security->get_csrf_token_name(); ?>':'<?php echo $this->security->get_csrf_hash(); ?>'
				},
				dataType: 'json',
				success:function (response) {
					$(".loader").hide();
					$(".modal_msg_data").hide();
					$("#budget_issue_id").val(id);
					$("#budget_issue_reference_no").val(response.referenceNo);
					$("#issue_date").val(response.issueDate);
					$("#budget_issue_amount").val(response.budgetIssueAmount);
					$("#add_edit_program_activity_budget_issue").show();
					
					$("#datepicker_issue_date").datetimepicker({
						format: 'YYYY-MM-DD'
					});
				}
			});
		},
		
		getBudgetReturnData: function (id) {
		
			var programId = $("#program_id").val();
		
			$.ajax({
				type: "POST",
				url: "<?php echo base_url(); ?>serviceManagerModule/donationManagerModule/donationSection/program_progress_controller/getBudgetReturnData",
				data: {
					'id': id,
					'<?php echo $this->security->get_csrf_token_name(); ?>':'<?php echo $this->security->get_csrf_hash(); ?>'
				},
				dataType: 'json',
				success:function (response) {
					$(".loader").hide();
					$(".modal_msg_data").hide();
					$("#budget_return_id").val(id);
					$("#budget_return_reference_no").val(response.referenceNo);
					$("#return_date").val(response.returnDate);
					$("#budget_return_amount").val(response.budgetReturnAmount);
					$("#add_edit_program_activity_budget_return").show();
					
					$("#datepicker_return_date").datetimepicker({
						format: 'YYYY-MM-DD'
					});
				}
			});
		},
		
		deleteBudgetIssueData: function (activityId, budgetIssueId) {
			var bConfirm = confirm("<?php echo $this->lang->line('Are you sure you want to delete').$this->lang->line('budget issue details') ?>?");
			if (bConfirm) {
				$.ajax({
					type: "POST",
					url: "<?php echo base_url(); ?>serviceManagerModule/donationManagerModule/donationSection/program_progress_controller/deleteBudgetIssue",
					data: {
						'activity_id' : activityId,
						'budget_issue_id': budgetIssueId,
						'<?php echo $this->security->get_csrf_token_name(); ?>':
							'<?php echo $this->security->get_csrf_hash(); ?>'
					},
					dataType: 'html',
					success:function (response) {
						$(".msg_delete").show();
						$(".msg_delete").html(response);

						getBudgetIssueTableData($("#activity_id_in_budget_issue_screen").val());
						ProgramProgress.getProgramActivityList($("#program_id_in_budget_issue_screen").val());
					}
				})
			}
		},
		
		deleteBudgetReturnData: function (activityId, budgetReturnId) {
			var bConfirm = confirm("<?php echo $this->lang->line('Are you sure you want to delete').$this->lang->line('budget return details') ?>?");
			if (bConfirm) {
				$.ajax({
					type: "POST",
					url: "<?php echo base_url(); ?>serviceManagerModule/donationManagerModule/donationSection/program_progress_controller/deleteBudgetReturn",
					data: {
						'activity_id' : activityId,
						'budget_return_id': budgetReturnId,
						'<?php echo $this->security->get_csrf_token_name(); ?>':
							'<?php echo $this->security->get_csrf_hash(); ?>'
					},
					dataType: 'html',
					success:function (response) {
						$(".msg_delete").show();
						$(".msg_delete").html(response);

						getBudgetReturnTableData($("#activity_id_in_budget_return_screen").val());
						ProgramProgress.getProgramActivityList($("#program_id_in_budget_return_screen").val());
					}
				})
			}
		},
		
		saveProgramActivityProgress: function (activityProgress) {
			var activityId = $("#activity_id_in_activity_progress_screen").val();
		
			$.ajax({
				type: "POST",
				url: "<?php echo base_url(); ?>serviceManagerModule/donationManagerModule/donationSection/program_progress_controller/saveProgramActivityProgress",
				data: {
					'activity_id' : activityId,
					'activity_progress' : activityProgress,
					'<?php echo $this->security->get_csrf_token_name(); ?>':'<?php echo $this->security->get_csrf_hash(); ?>'
				},
				dataType: 'html',
				success:function (response) {
					ProgramProgress.getProgramActivityList($("#program_id_in_activity_progress_screen").val());
				}
			});
		}
	}

	function validateProgramActivityDataForm_save() {
		return (isNotEmpty("activity_name", "<?php echo $this->lang->line('Activity Name').' '.$this->lang->line('field is required')?>")
			&& isNotEmpty("start_date", "<?php echo $this->lang->line('Start Date').' '.$this->lang->line('field is required')?>")
			&& isNotEmpty("finish_date", "<?php echo $this->lang->line('Finish Date').' '.$this->lang->line('field is required')?>")
			&& isSelected("activity_owner_id", "<?php echo $this->lang->line('Activity Owner').' '.$this->lang->line('field is required')?>")
			&& isFlootPositive("activity_budget", "<?php echo $this->lang->line('Activity Budget').' '.$this->lang->line('is not valid')?>")
		);
	}
	
	function validateProgramBudgetIssueDataForm_save() {
		return (isNotEmpty("budget_issue_reference_no", "<?php echo $this->lang->line('Reference Number').' '.$this->lang->line('field is required')?>")
			&& isNotEmpty("issue_date", "<?php echo $this->lang->line('Issue Date').' '.$this->lang->line('field is required')?>")
			&& isFlootPositive("budget_issue_amount", "<?php echo $this->lang->line('Budget Issue Amount').' '.$this->lang->line('is not valid')?>")
		);
	}
	
	function validateProgramBudgetReturnDataForm_save() {
		return (isNotEmpty("budget_return_reference_no", "<?php echo $this->lang->line('Reference Number').' '.$this->lang->line('field is required')?>")
			&& isNotEmpty("return_date", "<?php echo $this->lang->line('Return Date').' '.$this->lang->line('field is required')?>")
			&& isFlootPositive("budget_return_amount", "<?php echo $this->lang->line('Budget Return Amount').' '.$this->lang->line('is not valid')?>")
		);
	}

	//get all data
	function getProgramActivityTableData(programId) {
		$(".loader").show();
		$.ajax({
			type: "POST",
			url: "<?php echo base_url(); ?>serviceManagerModule/donationManagerModule/donationSection/program_progress_controller/getProgramActivityTableData",
			data: {
				'program_id' : programId,
				<?php echo $this->security->get_csrf_token_name(); ?>:'<?php echo $this->security->get_csrf_hash(); ?>'
			},
			dataType: 'html',
				success:
			function (response) {
				$("#dataTable").show();
				$("#dataTable").html(response);
				$(".loader").hide();
				$('.programActivityTable').dataTable({
					"aaSorting": [[ 10, "asc" ]]
				});
			}
		})
	}
	
	//get all data
	function getBudgetIssueTableData(programActivityId) {
		$(".loader").show();
		$.ajax({
			type: "POST",
			url: "<?php echo base_url(); ?>serviceManagerModule/donationManagerModule/donationSection/program_progress_controller/getBudgetIssueTableData",
			data: {
				'program_activity_id' : programActivityId,
				<?php echo $this->security->get_csrf_token_name(); ?>:'<?php echo $this->security->get_csrf_hash(); ?>'
			},
			dataType: 'html',
				success:
			function (response) {
				$("#programActivityBudgetIssueDataTable").show();
				$("#programActivityBudgetIssueDataTable").html(response);
				$(".loader").hide();
				$('.programActivityBudgetIssueTable').dataTable({
					"aaSorting": [[ 0, "asc" ]]
				});
			}
		})
	}
	
	//get all data
	function getBudgetReturnTableData(programActivityId) {
		$(".loader").show();
		$.ajax({
			type: "POST",
			url: "<?php echo base_url(); ?>serviceManagerModule/donationManagerModule/donationSection/program_progress_controller/getBudgetReturnTableData",
			data: {
				'program_activity_id' : programActivityId,
				<?php echo $this->security->get_csrf_token_name(); ?>:'<?php echo $this->security->get_csrf_hash(); ?>'
			},
			dataType: 'html',
				success:
			function (response) {
				$("#programActivityBudgetReturnDataTable").show();
				$("#programActivityBudgetReturnDataTable").html(response);
				$(".loader").hide();
				$('.programActivityBudgetReturnTable').dataTable({
					"aaSorting": [[ 0, "asc" ]]
				});
			}
		})
	}

	function clearForm(){
		$("#activity_id").val('');
		$("#activity_name").val('');
		$("#start_date").val(moment().format('YYYY-MM-DD'));
		$("#finish_date").val(moment().format('YYYY-MM-DD'));
		$("#activity_owner_id").val('0');
		$("#activity_budget").val('');
		$("#actual_start_date").val('');
		$("#actual_finished_date").val('');
	}

	function openProgramActivityDialog(programId) {
		$(".validation").hide();
		$(".msg_data").hide();
		$(".modal_msg_data").hide();
		$("#program_id").val(programId);
		$("#modal-program_activity").modal('show');
	}

	function closeProgramActivityDialog() {
		$("#modal-program_activity").modal('hide');
	}
	
	function openProgramActivityBudgetIssueDialog(programId, programActivityId) {
		$(".validation").hide();
		$(".msg_data").hide();
		$(".modal_msg_data").hide();
		$("#program_id_in_budget_issue_screen").val(programId);
		$("#activity_id_in_budget_issue_screen").val(programActivityId);
		$("#modal-program_activity_budget_issue").modal('show');
	}

	function closeProgramActivityBudgetIssueDialog() {
		$("#modal-program_activity_budget_issue").modal('hide');
	}
	
	function openProgramActivityBudgetReturnDialog(programId, programActivityId) {
		$(".validation").hide();
		$(".msg_data").hide();
		$(".modal_msg_data").hide();
		$("#program_id_in_budget_return_screen").val(programId);
		$("#activity_id_in_budget_return_screen").val(programActivityId);
		$("#modal-program_activity_budget_return").modal('show');
	}

	function closeProgramActivityBudgetReturnDialog() {
		$("#modal-program_activity_budget_return").modal('hide');
	}
	
	function openProgramActivityProgressDialog(programId, programActivityId) {
		$(".validation").hide();
		$(".msg_data").hide();
		$(".modal_msg_data").hide();
		$("#program_id_in_activity_progress_screen").val(programId);
		$("#activity_id_in_activity_progress_screen").val(programActivityId);
		$("#modal-program_activity_progress").modal('show');
	}

	function closeProgramActivityProgressDialog() {
		$("#modal-program_activity_progress").modal('hide');
	}
</script>

<style>
	h2 {
		margin-bottom:0;
	}
	
	h3 {
		margin:0 0 30px;
	} 
	
	.ui-slider-range {
		background:green;
	}
	
	.percent {
		color:green;
		font-weight:bold;
		text-align:center;
		width:100%;
		border:none;
	}		
</style>