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
								<span><?php echo $this->lang->line('Reports') ?></span>
							</h1>

							<div class='pull-right'></div>
						</div>
					</div>
				</div>

				<!--get report & icons -->
				<div class='box'>
					<div class='row'>
						<div class='col-sm-12'>
							<div class='text-center'>
												
								<?php if (isset($ACM_Reports_View_Management_Trial_Balance_Advanced_Report_Permissions) || 
										isset($ACM_Reports_View_Management_Sales_Payment_Details_Advanced_Report_Permissions) ||
										isset($ACM_Reports_View_Management_Debtors_Advanced_Report_Permissions) ||
										isset($ACM_Reports_View_Management_Creditors_Advanced_Report_Permissions)) { ?>
									<div class='box'>
										<div class='box-content light_color_background' style="overflow:hidden; height:1%; padding-bottom: 30px;">
											<ul class="dash">
												<h3 align="left"><?php echo $this->lang->line('Management Reports') ?></h3>

												<p style="margin-bottom:0px">&nbsp;</p>
												<?php if (isset($ACM_Reports_View_Management_Trial_Balance_Advanced_Report_Permissions)) { ?>
													<li>
														<a class="tip" href="#" title="<?php echo $this->lang->line('Trial Balance') ?>" onclick="selectReport('TrialBalance');">
															<i><img src="<?php echo base_url(); ?>assets/images/icons/trial_balance.png"
																	alt=""/></i>
															<span><span><?php echo $this->lang->line('Trial Balance') ?></span></span>
														</a>
													</li>
												<?php } ?>

												<?php 
												if ($systemConfigData['bookkeeping_sales_note'] == "Yes") {
													if (isset($ACM_Reports_View_Management_Sales_Payment_Details_Advanced_Report_Permissions)) { ?>
														<li>
															<a class="tip" href="#" title="<?php echo $this->lang->line('Sales Payment Details') ?>" onclick="selectReport('SalesPaymentDetails');">
																<i><img src="<?php echo base_url(); ?>assets/images/icons/payment_summary.png"
																		alt=""/></i>
																<span><span><?php echo $this->lang->line('Sales Payment Details') ?></span></span>
															</a>
														</li>
												<?php 
													} 
												}?>

												<?php if (isset($ACM_Reports_View_Management_Debtors_Advanced_Report_Permissions)) { ?>
													<li>
														<a class="tip" href="#" title="<?php echo $this->lang->line('Debtors') ?>" onclick="selectReport('Debtors');">
															<i><img src="<?php echo base_url(); ?>assets/images/icons/debtors.png"
																	alt=""/></i>
															<span><span><?php echo $this->lang->line('Debtors') ?></span></span>
														</a>
													</li>
												<?php } ?>

												<?php if (isset($ACM_Reports_View_Management_Creditors_Advanced_Report_Permissions)) { ?>
													<li>
														<a class="tip" href="#" title="<?php echo $this->lang->line('Creditors') ?>" onclick="selectReport('Creditors');">
															<i><img src="<?php echo base_url(); ?>assets/images/icons/creditors.png"
																	alt=""/></i>
															<span><span><?php echo $this->lang->line('Creditors') ?></span></span>
														</a>
													</li>
												<?php } ?>
                                                    
                                                <?php if (isset($ACM_Reports_View_Management_Cash_And_Cash_Equivalent_Advanced_Report_Permissions)) { ?>
													<li>
														<a class="tip" href="#" title="<?php echo $this->lang->line('Cash & Cash Equivalents') ?>" onclick="selectReport('CashAndCashEquivalents');">
															<i><img src="<?php echo base_url(); ?>assets/images/icons/cash_cash_equivalents.png"
																	alt=""/></i>
															<span><span><?php echo $this->lang->line('Cash & Cash Equivalents') ?></span></span>
														</a>
													</li>
												<?php } ?>
											</ul>
										</div>
									</div>
								<?php } ?>
									
								<?php if (isset($ACM_Reports_View_Financial_Balance_Sheet_Advanced_Report_Permissions) || 
										isset($ACM_Reports_View_Financial_Profit_And_Loss_Advanced_Report_Permissions)) { ?>
									<div class='box'>
										<div class='box-content light_color_background' style="overflow:hidden; height:1%; padding-bottom: 30px;">
											<ul class="dash">
												<h3 align="left"><?php echo $this->lang->line('Financial Reports') ?></h3>

												<p style="margin-bottom:0px">&nbsp;</p>

												<?php if (isset($ACM_Reports_View_Financial_Balance_Sheet_Advanced_Report_Permissions)) { ?>
													<li>
														<a class="tip" href="#" title="<?php echo $this->lang->line('Balance Sheet') ?>" onclick="selectReport('BalanceSheet');">
															<i><img src="<?php echo base_url(); ?>assets/images/icons/balance_sheet.png"
																	alt=""/></i>
															<span><span><?php echo $this->lang->line('Balance Sheet') ?></span></span>
														</a>
													</li>
												<?php } ?>

												<?php if (isset($ACM_Reports_View_Financial_Profit_And_Loss_Advanced_Report_Permissions)) { ?>
													<li>
														<a class="tip" href="#" title="<?php echo $this->lang->line('Profit & Loss') ?>" onclick="selectReport('ProfitAndLoss');">
															<i><img src="<?php echo base_url(); ?>assets/images/icons/profit_loss.png"
																	alt=""/></i>
															<span><span><?php echo $this->lang->line('Profit & Loss') ?></span></span>
														</a>
													</li>
												<?php } ?>
											</ul>
										</div>
									</div>
								<?php } ?>
							</div>
						</div>
					</div>
				</div>

				<!--<form class='form form-horizontal'>-->
				<?php echo form_open('accountsManagerModule/reportsSection/bookkeeping_report_controller/downloadReportResuls', 
									 array('class' => 'form form-horizontal validate-form','id' => 'report_result_form', 
										   'style' => 'margin-bottom: 0;', 'enctype' => 'multipart/form-data')) ?>
					<div class='msg_data'></div>
					<!--search stock form & table -->
					<div class='box accountDetails'>
						<div class='box-header'>
							<div class='title' id="report_title"><?php echo $this->lang->line('Search Bookkeeping') ?></div>
						</div>
						<div class='box-content'>
							<div class='row' id="date_filters">
								<div class='form-group'>
									<div class='col-sm-12 controls'>
										<label style="text-align : left" class='control-label col-sm-4' id="date_lable"><?php echo $this->lang->line('Date') ?></label>
										<label style="text-align : left" class='control-label col-sm-4' id="from_date_lable"><?php echo $this->lang->line('From Date') ?></label>
										<label style="text-align : left" class='control-label col-sm-4' id="to_date_lable"><?php echo $this->lang->line('To Date') ?></label>
									</div>
								</div>
								<div class='form-group'>
									<div class='col-sm-12 controls'>
										<div class='col-sm-4 controls' id="date_picker_div">
											<div class='input-group date' id="date_picker">
												<input class='form-control' id='date' data-format='YYYY-MM-DD' placeholder='<?php echo $this->lang->line('Date') ?>' type='text'>
												<span class='input-group-addon'>
													<span class="glyphicon glyphicon-calendar"></span>
												</span>
											</div>
										</div>
										<div class='col-sm-4 controls' id="from_date_picker_div">
											<div class='input-group date' id="from_date_picker">
												<input class='form-control' id='from_date' data-format='YYYY-MM-DD' placeholder='<?php echo $this->lang->line('From Date') ?>' type='text'>
												<span class='input-group-addon'>
													<span class="glyphicon glyphicon-calendar"></span>
												</span>
											</div>
											<div id="from_dateError" class="red"></div>
										</div>
										<div class='col-sm-4 controls' id="to_date_picker_div">
											<div class='input-group date' id="to_date_picker">
												<input class='form-control' id='to_date' data-format='YYYY-MM-DD' placeholder='<?php echo $this->lang->line('To Date') ?>' type='text'>
												<span class='input-group-addon'>
													<span class="glyphicon glyphicon-calendar"></span>
												</span>
											</div>
											<div id="to_dateError" class="red"></div>
										</div>
									</div>
									<p style="margin-bottom:-10px">&nbsp;</p>
								</div>
							</div>

							<div class='row' id="year_month_filters">
								<div class='form-group'>
									<div class='col-sm-12 controls'>
										<label style="text-align : left" class='control-label col-sm-4' ><?php echo $this->lang->line('Year') ?></label>
										<label style="text-align : left" class='control-label col-sm-4' ><?php echo $this->lang->line('Month') ?></label>
									</div>
								</div>
								<div class='form-group'>
									<div class='col-sm-12 controls'>
										<div class='col-sm-4 controls'>
											<select id="year_init" class="form-control"><option><?php echo $this->lang->line('-- Select --') ?></option></select>
											<div id="year_dropdown"></div>
											<div id="yearError" class="red"></div>
										</div>
										<div class='col-sm-4 controls'>
											<select id="month_init" class="form-control"><option><?php echo $this->lang->line('-- Select --') ?></option></select>
											<div id="month_dropdown"></div>
											<div id="monthError" class="red"></div>
										</div>
									</div>
                                    <div class='col-sm-3 controls' id="summary_report_checkbox">
                                        <input class="summary_report_filter" type="checkbox" name="summary_report" id="summary_report">
                                        <label for="summary_report" id="summary_report_label"><?php echo $this->lang->line('Summary Report') ?></label>
                                    </div>
									<p style="margin-bottom:-10px">&nbsp;</p>
								</div>
							</div>

							<div class='row' id="week_generate_as_filters">
								<div class='form-group'>
									<div class='col-sm-12 controls'>
										<label style="text-align : left" class='control-label col-sm-4' ><?php echo $this->lang->line('Week') ?></label>
										<label style="text-align : left" class='control-label col-sm-4' id="generate_as_label"><?php echo $this->lang->line('Generate As') ?></label>
									</div>
								</div>
								<div class='form-group'>
									<div class='col-sm-12 controls'>
										<div class='col-sm-4 controls'>
											<select id="week_init" class="form-control"><option><?php echo $this->lang->line('-- Select --') ?></option></select>
											<div id="week_dropdown"></div>
											<div id="weekError" class="red"></div>
										</div>
										<div class='col-sm-4 controls' id="generate_as_div">
											<select id="generate_as" class="form-control">
												<option value="0"><?php echo $this->lang->line('-- Select --') ?></option>
												<option value="1"><?php echo $this->lang->line('Monthly') ?></option>
												<option value="2"><?php echo $this->lang->line('Weekly') ?></option>
												<option value="3"><?php echo $this->lang->line('Daily') ?></option>
											</select>
											<div id="generate_asError" class="red"></div>
										</div>
										<div class='col-sm-3 controls' id="cancelled_sales_notes_checkbox">
											<input class="cancelled_sales_notes_filter" type="checkbox" name="cancelled_sales_notes" id="cancelled_sales_notes">
											<label for="cancelled_sales_notes" id="cancelled_sales_notes_label"><?php echo $this->lang->line('Cancelled Sales Notes') ?></label>
										</div>
									</div>
									<p style="margin-bottom:-10px">&nbsp;</p>
								</div>
							</div>

							<div class='row' id="chart_option_filters">
								<div class='form-group'>
									<div class='col-sm-12 controls'>
										<label style="text-align : left" class='control-label col-sm-4' ><?php echo $this->lang->line('Chart Type') ?></label>
										<label style="text-align : left" class='control-label col-sm-4' ><?php echo $this->lang->line('Chart View') ?></label>
									</div>
								</div>
								<div class='form-group'>
									<div class='col-sm-12 controls'>
										<div class='col-sm-4 controls'>
											<select id="chart_type_init" class="form-control"><option><?php echo $this->lang->line('-- Select --') ?></option></select>
											<div id="chart_type_dropdown"></div>
											<div id="chart_typeError" class="red"></div>
										</div>
										<div class='col-sm-4 controls'>
											<select id="chart_view" class="form-control">
												<option value="0"><?php echo $this->lang->line('-- Select --') ?></option>
												<option value="1"><?php echo $this->lang->line('Summary View') ?></option>
												<option value="2"><?php echo $this->lang->line('Detail View') ?></option>
											</select>
											<div id="chart_viewError" class="red"></div>
										</div>
									</div>
									<p style="margin-bottom:-10px">&nbsp;</p>
								</div>
							</div>
                            
							<div class='row' id="location_filter">
								<div class='form-group'>
									<div class='col-sm-12 controls'>
										<label style="text-align : left" class='control-label col-sm-4'><?php echo $this->lang->line('Location') ?></label>
										<label style="text-align : left" class='control-label col-sm-4' id="accounting_method_label"><?php echo $this->lang->line('Accounting Method') ?></label>
										<label style="text-align : left" class='control-label col-sm-4' id="person_label"><?php echo $this->lang->line('Person') ?></label>
										<label style="text-align : left" class='control-label col-sm-4' id="territory_label"><?php echo $this->lang->line('Territory') ?></label>
										<label style="text-align : left" class='control-label col-sm-2' id="detail_report_label"></label>
									</div>
								</div>
								<div class='form-group'>
									<div class='col-sm-12 controls'>
										<div class='col-sm-4 controls'>
											<select id="location_init" class="form-control"><option><?php echo $this->lang->line('-- Select --') ?></option></select>
											<!--Location drop down-->
											<div id="location_dropdown">
											</div>
											<!--End Location drop down-->
											<div id="location_idError" class="red"></div>
										</div>
										<div class='col-sm-4 controls' id="accounting_method_div">
											<div class="radio-inline">
												<label><input type="radio" id="accounting_cash" name="accounting_method" onchange="handleAccountingMethodSelect(this.id);"><?php echo $this->lang->line('Cash') ?></label>
											  </div>
											  <div class="radio-inline">
												<label><input type="radio" id="accounting_accrual" name="accounting_method" onchange="handleAccountingMethodSelect(this.id);"><?php echo $this->lang->line('Accrual') ?></label>
											  </div>		
											<p style="margin-bottom:-10px">&nbsp;</p>
										</div>
										<div class='col-sm-4 controls' id="person_dropdown_div">
											<select id="person_init" class="form-control"><option><?php echo $this->lang->line('-- Select --') ?></option></select>
											<!--Person drop down-->
											<div id="person_dropdown">
											</div>
											<!--End Person drop down-->
											<div id="people_idError" class="red"></div>
										</div>
										<div class='col-sm-4 controls' id="territory_filter">
											<select id="territory_init" class="form-control"><option><?php echo $this->lang->line('-- Select --') ?></option></select>
											<!--Territory drop down-->
											<div id="territory_dropdown">
											</div>
											<!--End Territory drop down-->
											<div id="territory_idError" class="red"></div>
										</div>
										<div class='col-sm-2 controls' id="detail_report_checkbox">
											<input class="summary_report_filter" type="checkbox" name="sales_detail_report" id="sales_detail_report">
											<label for="sales_detail_report" id="summary_report_label"><?php echo $this->lang->line('Detail Report') ?></label>
										</div>
										<div class='col-sm-2 controls' id="search_button">
											<button class='btn btn-success report_option' id="report_option" onclick='getBookkeepingData(this.id, "search");'
													type='button' <?php echo $menuFormatting; ?>>
												<i class='icon-ban-circle'></i>
												<?php echo $this->lang->line('Search') ?>
											</button>
										</div>
									</div>
								</div>
							</div>
						</div>

						<div id="bookkeeping_graph_div">
							<div class='box bookkeepingGraph'>
								<div class='box-header'>
									<div class='title'><?php echo $this->lang->line('Bookkeeping Data Comparison') ?></div>
								</div>
								<div class='box-content' id="graph_result" style="text-align: center;">

								</div>
							</div>
						</div>

						<div class='loader' align="center"><img src="<?php echo base_url();?>assets/images/ajax-loader.gif"/> Loading data...</div>

						<br>
						<div id="pdf_report_details_div">
							<div class='box reportDetails'>
								<div class='box-content' id="report_result" style="height:1500px; text-align: center;">

								</div>
							</div>
						</div>
						
						<div id='report_result_table_div'>
							<div class='row'>
								<div class='col-sm-12'>
									<div class='box bordered-box <?php echo BOXHEADER; ?>-border' style='margin-bottom:0;'>
										<!--<div class='loader' align="center"><img src="<?php echo base_url();?>assets/images/ajax-loader.gif"/> Loading data...</div>-->
										<!--showing tabale-->
										<div id="dataTable">
										</div>
										<!--end table -->
									</div>
								</div>
							</div>
						</div>
					</div>
					
					<div class='box' id="sales_note_payment_summary_details">
						<div class='box-header'>
							<div class='title'><?php echo $this->lang->line('Sales Note Payment Summary Details') ?></div>
						</div>
						<div class='box-content'>
							<div class='row'>
								<div id="sales_note_grand_total_div">
									<div class='form-group' id="sales_note_grand_total_lable">
										<div class='col-sm-12 controls'>
											<label style="text-align : left" class='control-label col-sm-4' ><?php echo $this->lang->line('Sales Note Grand Total') ?></label>
										</div>
									</div>
									<div class='form-group' id="sales_note_grand_total_value">
										<div class='col-sm-12 controls'>
											<div class='col-sm-4 controls'>
												<input class='form-control' id='sn_grand_total' name='sn_grand_total' type='text' readonly>
											</div>
										</div>
										<p style="margin-bottom:-10px">&nbsp;</p>
									</div>
								</div>

								<div class='form-group' id="sales_note_payment_lables">
									<div class='col-sm-12 controls'>
										<label id="total_discount_label" style="text-align : left" class='control-label col-sm-2' ><?php echo $this->lang->line('Total Discount') ?></label>
										<label id="total_free_issue_label" style="text-align : left" class='control-label col-sm-2' ><?php echo $this->lang->line('Free Issue Total') ?></label>
										<label id="total_customer_saleable_return_label" style="text-align : left" class='control-label col-sm-3' ><?php echo $this->lang->line('Customer Saleable Return Total') ?></label>
										<label id="total_customer_market_return_label" style="text-align : left" class='control-label col-sm-3' ><?php echo $this->lang->line('Customer Market Return Total') ?></label>
									</div>
								</div>
								<div class='form-group' id="sales_note_payment_values">
									<div class='col-sm-12 controls'>
										<div id="total_discount_value_div" class='col-sm-2 controls'>
											<input class='form-control' id='sn_total_discount' name='sn_total_discount' type='text' readonly>
										</div>
										<div id="total_tax_value_div" class='col-sm-2 controls'>
											<input class='form-control' id='sn_total_free_issue' name='sn_total_free_issue' type='text' readonly>
										</div>
										<div id="total_cash_payment_value_div" class='col-sm-3 controls'>
											<input class='form-control' id='sn_total_customer_saleable_return' name='sn_total_customer_saleable_return' type='text' readonly>
										</div>
										<div id="total_cheque_payment_value_div" class='col-sm-3 controls'>
											<input class='form-control' id='sn_total_customer_market_return' name='sn_total_customer_market_return' type='text' readonly>
										</div>
									</div>
									<p style="margin-bottom:-10px">&nbsp;</p>
								</div>

								<div class='form-group' id="sales_note_payment_lables">
									<div class='col-sm-12 controls'>
										<label id="total_cash_payment_label" style="text-align : left" class='control-label col-sm-2' ><?php echo $this->lang->line('Total Payable') ?></label>
										<label id="total_cash_payment_label" style="text-align : left" class='control-label col-sm-2' ><?php echo $this->lang->line('Total Cash Payment') ?></label>
										<label id="total_cheque_payment_label" style="text-align : left" class='control-label col-sm-2' ><?php echo $this->lang->line('Total Cheque Payment') ?></label>
                                        <label id="total_cheque_payment_label" style="text-align : left" class='control-label col-sm-2' ><?php echo $this->lang->line('Total Credit Card Payment') ?></label>
                                        <label id="total_cheque_payment_label" style="text-align : left" class='control-label col-sm-2' ><?php echo $this->lang->line('Total Customer Returns Claimed') ?></label>
										<label id="total_credit_payment_label" style="text-align : left" class='control-label col-sm-2' ><?php echo $this->lang->line('Total Credit Payment') ?></label>
									</div>
								</div>
								<div class='form-group' id="sales_note_payment_values">
									<div class='col-sm-12 controls'>
										<div id="total_cash_payment_value_div" class='col-sm-2 controls'>
											<input class='form-control' id='sn_total_payable' name='sn_total_payable' type='text' readonly>
										</div>
										<div id="total_cash_payment_value_div" class='col-sm-2 controls'>
											<input class='form-control' id='sn_total_cash_payment' name='sn_total_cash_payment' type='text' readonly>
										</div>
										<div id="total_cheque_payment_value_div" class='col-sm-2 controls'>
											<input class='form-control' id='sn_total_cheque_payment' name='sn_total_cheque_payment' type='text' readonly>
										</div>
                                        <div id="total_credit_card_payment_value_div" class='col-sm-2 controls'>
											<input class='form-control' id='sn_total_credit_card_payment' name='sn_total_credit_card_payment' type='text' readonly>
										</div>
                                        <div id="total_claimed_customer_returns_value_div" class='col-sm-2 controls'>
											<input class='form-control' id='sn_total_claimed_customer_returns' name='sn_total_claimed_customer_returns' type='text' readonly>
										</div>
										<div id="total_credit_payment_value_div" class='col-sm-2 controls'>
											<input class='form-control' id='sn_total_credit_payment' name='sn_total_credit_payment' type='text' readonly>
										</div>
									</div>
									<p style="margin-bottom:-10px">&nbsp;</p>
								</div>
							</div>
						</div>
					</div>
				</form>
				
				<div id="printButton">
					<?php echo form_open('accountsManagerModule/reportsSection/bookkeeping_report_controller/printReport', array('target'=>'_blank', 'class' => 'form-horizontal')) ?>
					<input type='hidden' name='report' id='report' value=''>
					<input type='hidden' name='fromDate' id='fromDate' value=''>
					<input type='hidden' name='toDate' id='toDate' value=''>
					<input type='hidden' name='yearValue' id='yearValue' value=''>
					<input type='hidden' name='monthValue' id='monthValue' value=''>
					<input type='hidden' name='weekValue' id='weekValue' value=''>
					<input type='hidden' name='generateAs' id='generateAs' value=''>
					<input type='hidden' name='showCancelledSalesNotes' id='showCancelledSalesNotes' value=''>
					<input type='hidden' name='locationId' id='locationId' value=''>
					<input type='hidden' name='territoryId' id='territoryId' value=''>
					<input type='hidden' name='detailReport' id='detailReport' value=''>
                    <input type='hidden' name='summaryReport' id='summaryReport' value=''>
					<button type='submit' name='action' id='save' class='btn btn-warning'>
						<i class='icon-ban-circle'></i>
						<?php echo$this->lang->line('Print')?>
					</button>
					</form>
				</div>
			</div>
		</div>

<script src="<?php echo base_url(); ?>ajax/jquery.js"></script>
<script src="<?php echo base_url(); ?>ajax/validate.js"></script>

<script>

	var AccountingMethod = 'Accrual';
	
	$(document).ready(function () {
		$(".loader").hide();
		$('#printButton').hide();
		$('.sub_category').hide();
		$("#pdf_report_details_div").hide();
		$("#report_result_table_div").hide();
		$("#sales_note_payment_summary_details").hide();
		BookkeepingReport.init();
		BookkeepingReport.getLocationData();
		BookkeepingReport.getTerritoryData();
		BookkeepingReport.getYearDropdownData();
		BookkeepingReport.getMonthDropdownData();
		BookkeepingReport.getChartTypeDropdownData();
		BookkeepingReport.getPeopleData();

		$("#date_picker").datetimepicker({
			format: 'YYYY-MM-DD'
		});
		$("#from_date_picker").datetimepicker({
			format: 'YYYY-MM-DD'
		});
		$("#to_date_picker").datetimepicker({
			format: 'YYYY-MM-DD'
		});

		$('#date_picker').focusout(function(){
			handleDateLostFocus();
		});

		$('#from_date_picker').focusout(function(){
			handleDateRangeLostFocus();
		});

		$('#to_date_picker').focusout(function(){
			handleDateRangeLostFocus();
		});
	});

	function selectReport(reportName) {
		$("#search_button").find(".report_option").prop({ id: "report_option"});
		$("#search_button").find("#report_option").prop({ id: reportName});
		
		$("#date").prop('disabled', false);
		$("#date").val('');
		$("#from_date").prop('disabled', false);
		$("#from_date").val('');
		$("#to_date").prop('disabled', false);
		$("#to_date").val('');
		$("#year").prop('disabled', false);
		$("#year").val('0');
		$("#month").prop('disabled', false);
		$("#month").val('0');
		$("#week").prop('disabled', false);
		$("#week").val('0');
		$("#generate_as").val('0');

		getBookkeepingData(reportName, "default");
	}

	function getBookkeepingData(bookkeepingReportType, callOption){

		if(bookkeepingReportType == 'TrialBalance'){

			$("#report_title").text("<?php echo $this->lang->line('Trial Balance')?>");

			$("#pdf_report_details_div").hide();
			$("#report_result_table_div").hide();
			$('.accountDetails').show();
			$("#date_filters").show();
			$("#date_lable").show();
			$("#from_date_lable").show();
			$("#to_date_lable").show();
			$("#date_picker_div").show();
			$("#from_date_picker_div").show();
			$("#to_date_picker_div").show();
			$("#bookkeeping_graph_div").hide();
			$("#year_month_filters").show();
            $("#summary_report_checkbox").hide();
			$("#week_generate_as_filters").show();
            $("#generate_as_label").hide();
            $("#generate_as_div").hide();
			$("#cancelled_sales_notes_checkbox").hide();
			$("#accounting_method_label").show();
			$("#accounting_method_div").show();
			$("#person_label").hide();
			$("#person_dropdown_div").hide();
			$("#detail_report_checkbox").hide();
			$("#chart_option_filters").hide();
            $("#reference_module_filters").hide();
			$("#location_filter").show();
			$("#territory_label").hide();
			$("#territory_filter").hide();
			
			if (AccountingMethod == 'Accrual') {
				$("#accounting_accrual").prop('checked', true);
			} else if (AccountingMethod = 'Cash') {
				$("#accounting_cash").prop('checked', true);
			}
			
			$("#sales_note_payment_summary_details").hide();
			$("#printButton").hide();
			$(".msg_data").hide();
			
			var date = $("#date").val();
			var fromDate = $("#from_date").val();
			var toDate = $("#to_date").val();
			var year = $("#year").val();
			var month = $("#month").val();
			var week = $("#week option:selected").text();
			var generateAs = $("#generate_as").val();
			var locationId = $("#location").val();
			var accountingMethod = AccountingMethod;

			if (callOption == "search") {
				BookkeepingReport.getTrialBalanceDetails(date, fromDate, toDate, year, month, week, generateAs, locationId, accountingMethod);

				$(".loader").hide();

				setTimeout(function(){
					var html = "<object data='<?php echo base_url(); ?>temporaryFiles/Trial_Balance.pdf' type='application/pdf' width='100%' height='100%'>" +
									"<p>Your web browser doesnt have a PDF plugin. " +
									"Instead you can <a href='<?php echo base_url(); ?>temporaryFiles/Trial_Balance.pdf'>click here to " +
									"download the PDF file.</a></p>" +
								"</object>";
					$("#report_result").append(html);
				}, 3500);
			}
		} else if(bookkeepingReportType == 'SalesPaymentDetails'){

			$("#report_title").text("<?php echo $this->lang->line('Sales Payment Details')?>");

			$("#pdf_report_details_div").hide();
			$("#report_result_table_div").hide();
			$('.accountDetails').show();
			$("#date_filters").show();
			$("#date_lable").hide();
			$("#from_date_lable").show();
			$("#to_date_lable").show();
			$("#date_picker_div").hide();
			$("#from_date_picker_div").show();
			$("#to_date_picker_div").show();
			$("#bookkeeping_graph_div").hide();
			$("#year_month_filters").show();
            $("#summary_report_checkbox").hide();
			$("#week_generate_as_filters").show();
			$("#cancelled_sales_notes_checkbox").show();
			$("#accounting_method_label").hide();
			$("#accounting_method_div").hide();
			$("#person_label").hide();
			$("#person_dropdown_div").hide();
			$("#detail_report_checkbox").show();
			$("#chart_option_filters").hide();
            $("#reference_module_filters").hide();
			$("#location_filter").show();
			$("#territory_label").show();
			$("#territory_filter").show();
			
			if (AccountingMethod == 'Accrual') {
				$("#accounting_accrual").prop('checked', true);
			} else if (AccountingMethod = 'Cash') {
				$("#accounting_cash").prop('checked', true);
			}
			
			$("#sales_note_payment_summary_details").hide();
			$("#printButton").hide();
			$(".msg_data").hide();

			var fromDate = $("#from_date").val();
			var toDate = $("#to_date").val();
			var year = $("#year").val();
			var month = $("#month").val();
			var week = $("#week option:selected").text();
			var generateAs = $("#generate_as").val();
			var locationId = $("#location").val();
			var territoryId = $("#territory").val();
			
			var showCancelledSalesNotes = "No";
			if ($("#cancelled_sales_notes").prop("checked") == true) {
				showCancelledSalesNotes = "Yes";
			}
			
			var detailsReport = "No";
			if ($("#sales_detail_report").prop("checked") == true) {
				detailsReport = "Yes";
			}
			
			$("#report").val('SalesPaymentDetails');
			$("#fromDate").val(fromDate);
			$("#toDate").val(toDate);
			$("#yearValue").val(year);
			$("#monthValue").val(month);
			$("#weekValue").val(week);
			$("#generateAs").val(generateAs);
			$("#locationId").val(locationId);
			$("#territoryId").val(territoryId);
			$("#detailReport").val(detailsReport);
			$("#showCancelledSalesNotes").val(showCancelledSalesNotes);

			if (callOption == "search") {
				BookkeepingReport.getSalesPaymentDetails(fromDate, toDate, year, month, week, generateAs, locationId, territoryId, showCancelledSalesNotes, detailsReport);
			}
		} else if(bookkeepingReportType == 'BalanceSheet'){

			$("#report_title").text("<?php echo $this->lang->line('Balance Sheet')?>");

			$("#pdf_report_details_div").hide();
			$("#report_result_table_div").hide();
			$('.accountDetails').show();
			$("#date_filters").show();
			$("#date_lable").show();
			$("#from_date_lable").show();
			$("#to_date_lable").show();
			$("#date_picker_div").show();
			$("#from_date_picker_div").show();
			$("#to_date_picker_div").show();
			$("#bookkeeping_graph_div").hide();
			$("#year_month_filters").show();
            $("#summary_report_checkbox").hide();
			$("#week_generate_as_filters").show();
            $("#generate_as_label").hide();
            $("#generate_as_div").hide();
			$("#cancelled_sales_notes_checkbox").hide();
			$("#accounting_method_label").show();
			$("#accounting_method_div").show();
			$("#person_label").hide();
			$("#person_dropdown_div").hide();
			$("#detail_report_checkbox").hide();
			$("#chart_option_filters").hide();
            $("#reference_module_filters").hide();
			$("#location_filter").show();
			$("#territory_label").hide();
			$("#territory_filter").hide();
			
			if (AccountingMethod == 'Accrual') {
				$("#accounting_accrual").prop('checked', true);
			} else if (AccountingMethod = 'Cash') {
				$("#accounting_cash").prop('checked', true);
			}
			
			$("#sales_note_payment_summary_details").hide();
			$("#printButton").hide();
			$(".msg_data").hide();

			var date = $("#date").val();
			var fromDate = $("#from_date").val();
			var toDate = $("#to_date").val();
			var year = $("#year").val();
			var month = $("#month").val();
			var week = $("#week option:selected").text();
			var locationId = $("#location").val();
			var accountingMethod = AccountingMethod;

			if (callOption == "search") {
				BookkeepingReport.getBalanceSheetDetails(date, fromDate, toDate, year, month, week, locationId, accountingMethod);

				$(".loader").hide();

				setTimeout(function(){
					var html = "<object data='<?php echo base_url(); ?>temporaryFiles/Balance_Sheet.pdf' type='application/pdf' width='100%' height='100%'>" +
									"<p>Your web browser doesnt have a PDF plugin. " +
									"Instead you can <a href='<?php echo base_url(); ?>temporaryFiles/Balance_Sheet.pdf'>click here to " +
									"download the PDF file.</a></p>" +
								"</object>";
					$("#report_result").append(html);
				}, 5500);
			}
		} else if(bookkeepingReportType == 'ProfitAndLoss'){

			$("#report_title").text("<?php echo $this->lang->line('Profit & Loss')?>");

			$("#pdf_report_details_div").hide();
			$("#report_result_table_div").hide();
			$('.accountDetails').show();
			$("#date_filters").show();
			$("#date_lable").show();
			$("#from_date_lable").show();
			$("#to_date_lable").show();
			$("#date_picker_div").show();
			$("#from_date_picker_div").show();
			$("#to_date_picker_div").show();
			$("#bookkeeping_graph_div").hide();
			$("#year_month_filters").show();
            $("#summary_report_checkbox").hide();
			$("#week_generate_as_filters").show();
            $("#generate_as_label").hide();
            $("#generate_as_div").hide();
			$("#cancelled_sales_notes_checkbox").hide();
			$("#accounting_method_label").show();
			$("#accounting_method_div").show();
			$("#person_label").hide();
			$("#person_dropdown_div").hide();
			$("#detail_report_checkbox").hide();
			$("#chart_option_filters").hide();
            $("#reference_module_filters").hide();
			$("#location_filter").show();
			$("#territory_label").hide();
			$("#territory_filter").hide();
			
			if (AccountingMethod == 'Accrual') {
				$("#accounting_accrual").prop('checked', true);
			} else if (AccountingMethod = 'Cash') {
				$("#accounting_cash").prop('checked', true);
			}
			
			$("#sales_note_payment_summary_details").hide();
			$("#printButton").hide();
			$(".msg_data").hide();

			var date = $("#date").val();
			var fromDate = $("#from_date").val();
			var toDate = $("#to_date").val();
			var year = $("#year").val();
			var month = $("#month").val();
			var week = $("#week option:selected").text();
			var locationId = $("#location").val();
			var accountingMethod = AccountingMethod;

			if (callOption == "search") {
				BookkeepingReport.getProfitAndLossDetails(date, fromDate, toDate, year, month, week, locationId, accountingMethod);

				$(".loader").hide();

				setTimeout(function(){
					var html = "<object data='<?php echo base_url(); ?>temporaryFiles/Profit_And_Loss.pdf' type='application/pdf' width='100%' height='100%'>" +
									"<p>Your web browser doesnt have a PDF plugin. " +
									"Instead you can <a href='<?php echo base_url(); ?>temporaryFiles/Profit_And_Loss.pdf'>click here to " +
									"download the PDF file.</a></p>" +
								"</object>";
					$("#report_result").append(html);
				}, 3500);
			}
		} else if(bookkeepingReportType == 'Debtors'){

			$("#report_title").text("<?php echo $this->lang->line('Debtors')?>");

			$("#pdf_report_details_div").hide();
			$("#report_result_table_div").hide();
			$('.accountDetails').show();
			$("#date_filters").show();
			$("#date_lable").show();
			$("#from_date_lable").show();
			$("#to_date_lable").show();
			$("#date_picker_div").show();
			$("#from_date_picker_div").show();
			$("#to_date_picker_div").show();
			$("#bookkeeping_graph_div").hide();
			$("#year_month_filters").show();
            $("#summary_report_checkbox").show();
			$("#week_generate_as_filters").hide();
			$("#cancelled_sales_notes_checkbox").hide();
			$("#accounting_method_label").hide();
			$("#accounting_method_div").hide();
			$("#person_label").show();
			$("#person_dropdown_div").show();
			$("#detail_report_checkbox").hide();
			$("#chart_option_filters").hide();
            $("#reference_module_filters").show();
			$("#location_filter").show();
			$("#territory_label").hide();
			$("#territory_filter").hide();
			
			$("#person_label").text('<?php echo $this->lang->line("Debtor")?>');
			
			$("#sales_note_payment_summary_details").hide();
			$("#printButton").hide();
			$(".msg_data").hide();

			var date = $("#date").val();
			var fromDate = $("#from_date").val();
			var toDate = $("#to_date").val();
			var year = $("#year").val();
			var month = $("#month").val();
			var locationId = $("#location").val();
			var debtorId = $("#people_id").val();
            
            var salesInvoiceCategory = '0';
            
            <?php if ($systemConfigData['acm_enable_sales_invoice_category_filter_in_debtors_report'] == "Yes") { ?>
                salesInvoiceCategory = $("#wholesale_category_id").val();
            <?php } ?>
            
            var summaryReport = "No";
			if ($("#summary_report").prop("checked") == true) {
				summaryReport = 'Yes';
			}

			if (callOption == "search") {
				BookkeepingReport.getDebtorsDetails(date, fromDate, toDate, year, month, locationId, debtorId, summaryReport, salesInvoiceCategory);

				$(".loader").hide();

//				setTimeout(function(){
//					var html = "<object data='<?php echo base_url(); ?>temporaryFiles/Debtors.pdf' type='application/pdf' width='100%' height='100%'>" +
//									"<p>Your web browser doesnt have a PDF plugin. " +
//									"Instead you can <a href='<?php echo base_url(); ?>temporaryFiles/Debtors.pdf'>click here to " +
//									"download the PDF file.</a></p>" +
//								"</object>";
//					$("#report_result").append(html);
//				}, 8500);
			}
		} else if(bookkeepingReportType == 'Creditors'){

			$("#report_title").text("<?php echo $this->lang->line('Creditors')?>");

			$("#pdf_report_details_div").hide();
			$("#report_result_table_div").hide();
			$('.accountDetails').show();
			$("#date_filters").show();
			$("#date_lable").show();
			$("#from_date_lable").show();
			$("#to_date_lable").show();
			$("#date_picker_div").show();
			$("#from_date_picker_div").show();
			$("#to_date_picker_div").show();
			$("#bookkeeping_graph_div").hide();
			$("#year_month_filters").show();
            $("#summary_report_checkbox").show();
			$("#week_generate_as_filters").hide();
			$("#cancelled_sales_notes_checkbox").hide();
			$("#accounting_method_label").hide();
			$("#accounting_method_div").hide();
			$("#person_label").show();
			$("#person_dropdown_div").show();
			$("#detail_report_checkbox").hide();
			$("#chart_option_filters").hide();
            $("#reference_module_filters").hide();
			$("#location_filter").show();
			$("#territory_label").hide();
			$("#territory_filter").hide();
			
			$("#person_label").text('<?php echo $this->lang->line("Creditor")?>');
			
			$("#sales_note_payment_summary_details").hide();
			$("#printButton").hide();
			$(".msg_data").hide();

			var date = $("#date").val();
			var fromDate = $("#from_date").val();
			var toDate = $("#to_date").val();
			var year = $("#year").val();
			var month = $("#month").val();
			var locationId = $("#location").val();
			var creditorId = $("#people_id").val();
            
            var summaryReport = "No";
			if ($("#summary_report").prop("checked") == true) {
				summaryReport = 'Yes';
			}

			if (callOption == "search") {
				BookkeepingReport.getCreditorsDetails(date, fromDate, toDate, year, month, locationId, creditorId, summaryReport);

				$(".loader").hide();

				setTimeout(function(){
					var html = "<object data='<?php echo base_url(); ?>temporaryFiles/Creditors.pdf' type='application/pdf' width='100%' height='100%'>" +
									"<p>Your web browser doesnt have a PDF plugin. " +
									"Instead you can <a href='<?php echo base_url(); ?>temporaryFiles/Creditors.pdf'>click here to " +
									"download the PDF file.</a></p>" +
								"</object>";
					$("#report_result").append(html);
				}, 8500);
			}
		} else if(bookkeepingReportType == 'CashAndCashEquivalents'){

			$("#report_title").text("<?php echo $this->lang->line('Cash & Cash Equivalents')?>");

			$("#pdf_report_details_div").hide();
			$("#report_result_table_div").hide();
			$('.accountDetails').show();
			$("#date_filters").hide();
			$("#date_lable").hide();
			$("#from_date_lable").hide();
			$("#to_date_lable").hide();
			$("#date_picker_div").hide();
			$("#from_date_picker_div").hide();
			$("#to_date_picker_div").hide();
			$("#bookkeeping_graph_div").hide();
			$("#year_month_filters").hide();
            $("#summary_report_checkbox").hide();
			$("#week_generate_as_filters").hide();
			$("#cancelled_sales_notes_checkbox").hide();
			$("#accounting_method_label").hide();
			$("#accounting_method_div").hide();
			$("#person_label").hide();
			$("#person_dropdown_div").hide();
			$("#detail_report_checkbox").hide();
			$("#chart_option_filters").hide();
            $("#reference_module_filters").hide();
			$("#location_filter").show();
			$("#territory_label").hide();
			$("#territory_filter").hide();
			
			$("#sales_note_payment_summary_details").hide();
			$("#printButton").hide();
			$(".msg_data").hide();

			var locationId = $("#location").val();
            
			if (callOption == "search") {
				BookkeepingReport.getCashAndCashEquivalentDetails(locationId);

				$(".loader").hide();

				setTimeout(function(){
					var html = "<object data='<?php echo base_url(); ?>temporaryFiles/Cash_And_Cash_Equivalents.pdf' type='application/pdf' width='100%' height='100%'>" +
									"<p>Your web browser doesnt have a PDF plugin. " +
									"Instead you can <a href='<?php echo base_url(); ?>temporaryFiles/Cash_And_Cash_Equivalents.pdf'>click here to " +
									"download the PDF file.</a></p>" +
								"</object>";
					$("#report_result").append(html);
				}, 8500);
			}
		}
	}

	function handleYearChange () {
		handleMonthChange();
	}

	function handleMonthChange () {
		var year = $("#year").val();
		var month = $("#month").val();
		BookkeepingReport.getWeeksOfAMonthDropdownData(year, month);
	}

	function handleDateLostFocus() {
		if ($("#date").val() != '') {
			$("#from_date").prop('disabled', true);
			$("#to_date").prop('disabled', true);
			$("#month").val('0');
			$("#month").prop('disabled', true);
			$("#week").prop('disabled', true);
		} else {
			$("#from_date").prop('disabled', false);
			$("#to_date").prop('disabled', false);
			$("#month").prop('disabled', false);
			$("#week").prop('disabled', false);
		}
	}

	function handleDateRangeLostFocus() {
		if ($("#from_date").val() != '' || $("#to_date").val() != '') {
			$("#date").prop('disabled', true);
			$("#year").val('0');
			$("#year").prop('disabled', true);
			$("#month").val('0');
			$("#month").prop('disabled', true);
			$("#week").val('0');
			$("#week").prop('disabled', true);
		} else {
			$("#from_dateError").empty();
			$("#to_dateError").empty();
			$("#date").prop('disabled', false);
			$("#year").prop('disabled', false);
			$("#month").prop('disabled', false);
			$("#week").prop('disabled', false);
		}
	}
	
	function handleAccountingMethodSelect(id) {
		if (id == "accounting_cash") {
			AccountingMethod = "Cash";
		} else if (id == "accounting_accrual") {
			AccountingMethod = "Accrual";
		}
	}
    
    function handleLocationSelect(id) {
        
    }

	var BookkeepingReport = {

		//get locations drop down
		getLocationData: function () {
			$.ajax({
				type: "POST",
				url: "<?php echo base_url(); ?>organizationManagerModule/adminSection/locations_controller/getAllToLocationsDropDownWithoutLabel",
				data: {
					'<?php echo $this->security->get_csrf_token_name(); ?>':
					'<?php echo $this->security->get_csrf_hash(); ?>'
				},
				dataType: 'html',
				success:
					function (response) {
						$('#location_init').hide();
						$("#location_dropdown").html(response);
					}
			})
		},
		
		//get territory drop down
		getTerritoryData: function () {
			$.ajax({
				type: "POST",
				url: "<?php echo base_url(); ?>organizationManagerModule/adminSection/territories_controller/getAllToTerritoriesDropDownWithoutLabel",
				data: {
					'<?php echo $this->security->get_csrf_token_name(); ?>':
					'<?php echo $this->security->get_csrf_hash(); ?>'
				},
				dataType: 'html',
				success:
					function (response) {
						$('#territory_init').hide();
						$("#territory_dropdown").html(response);
					}
			})
		},

		//get year dropdown
		getYearDropdownData: function () {
			$.ajax({
				type: "POST",
				url: "<?php echo base_url(); ?>accountsManagerModule/reportsSection/bookkeeping_report_controller/getYearDropdownData",
				data: {
					<?php echo $this->security->get_csrf_token_name(); ?>:'<?php echo $this->security->get_csrf_hash(); ?>'
				},
				dataType: 'html',
				success:function (response) {
					$('#year_init').hide();
					$("#year_dropdown").html(response);
				}
			})
		},

		//get month dropdown
		getMonthDropdownData: function () {
			$.ajax({
				type: "POST",
				url: "<?php echo base_url(); ?>accountsManagerModule/reportsSection/bookkeeping_report_controller/getMonthDropdownData",
				data: {
					<?php echo $this->security->get_csrf_token_name(); ?>:'<?php echo $this->security->get_csrf_hash(); ?>'
				},
				dataType: 'html',
				success:function (response) {
					$('#month_init').hide();
					$("#month_dropdown").html(response);
				}
			})
		},

		getWeeksOfAMonthDropdownData: function (year, month) {
			$.ajax({
				type: "POST",
				url: "<?php echo base_url(); ?>accountsManagerModule/reportsSection/bookkeeping_report_controller/getWeeksOfAMonthDropdownData",
				data: {
					'year':year,
					'month':month,
					'<?php echo $this->security->get_csrf_token_name(); ?>':'<?php echo $this->security->get_csrf_hash(); ?>'
				},
				dataType: 'html',
				success:function (response) {
					$('#week_init').hide();
					$("#week_dropdown").html(response);
				}
			})
		},

		//get chart type dropdown
		getChartTypeDropdownData: function () {
			$.ajax({
				type: "POST",
				url: "<?php echo base_url(); ?>accountsManagerModule/reportsSection/bookkeeping_report_controller/getChartTypeDropdownData",
				data: {
					<?php echo $this->security->get_csrf_token_name(); ?>:'<?php echo $this->security->get_csrf_hash(); ?>'
				},
				dataType: 'html',
				success:function (response) {
					$('#chart_type_init').hide();
					$("#chart_type_dropdown").html(response);
				}
			})
		},

		//get trial balance details
		getTrialBalanceDetails: function (date, fromDate, toDate, year, month, week, generateAs, locationId, accountingMethod){
			if (validateForm_FromDateAndToDate()) {
				$("#report_result").empty();
				$("#pdf_report_details_div").show();
				$(".loader").show();
				$.ajax({
					type: "POST",
					url: "<?php echo base_url(); ?>accountsManagerModule/reportsSection/bookkeeping_report_controller/getTrialBalanceDetailsReport",
					data: {
						'date' : date,
						'from_date' : fromDate,
						'to_date' : toDate,
						'year' : year,
						'month' : month,
						'week' : week,
						'generate_as' : generateAs,
						'location_id' : locationId,
						'accounting_method' : accountingMethod,
						'<?php echo $this->security->get_csrf_token_name(); ?>':'<?php echo $this->security->get_csrf_hash(); ?>'
					},
					dataType: 'html',
					success:function (response) {
						
					}
				})
			}
		},
		
		//get sales payment details
		getSalesPaymentDetails: function (fromDate, toDate, year, month, week, generateAs, locationId, territoryId, showCancelledSalesNotes, detailsReport){
			if (validateForm_FromDateAndToDate()) {
				$("#report_result_table_div").show();
				$('#printButton').show();
				$(".loader").show();
				$.ajax({
					type: "POST",
					url: "<?php echo base_url(); ?>accountsManagerModule/reportsSection/bookkeeping_report_controller/getSalesPaymentDetailsReport",
					data: {
						'from_date' : fromDate,
						'to_date' : toDate,
						'year' : year,
						'month' : month,
						'week' : week,
						'generate_as' : generateAs,
						'location_id' : locationId,
						'territory_id' : territoryId,
						'show_cancelled_sales_notes' : showCancelledSalesNotes,
						'details_report' : detailsReport,
						'<?php echo $this->security->get_csrf_token_name(); ?>':'<?php echo $this->security->get_csrf_hash(); ?>'
					},
					dataType: 'json',
					success:function (response) {
						$("#sales_note_payment_summary_details").show();
						$("#sn_grand_total").val(response.salesNoteGrandTotal);
						$("#sn_total_discount").val(response.salesNoteDiscountGrandTotal);
						$("#sn_total_free_issue").val(response.salesNoteFreeIssueGrandTotal);
						$("#sn_total_customer_saleable_return").val(response.salesNoteCustomerSaleableReturnGrandTotal);
						$("#sn_total_customer_market_return").val(response.salesNoteCustomerMarketReturnGrandTotal);
						$("#sn_total_payable").val(response.salesNotePayableGrandTotal);
						$("#sn_total_cash_payment").val(response.salesNoteCashPaymentGrandTotal);
						$("#sn_total_cheque_payment").val(response.salesNoteChequePaymentGrandTotal);
                        $("#sn_total_credit_card_payment").val(response.salesNoteCreditCardPaymentGrandTotal);
                        $("#sn_total_claimed_customer_returns").val(response.salesNoteClaimedCustomerReturnsGrandTotal);
						$("#sn_total_credit_payment").val(response.salesNoteCreditPaymentGrandTotal);
						$(".loader").hide();

						$("#dataTable").html(response.html);
						$('.salesPaymentDetailsDataTable').dataTable();
					}
				})
			}
		},
		
		//get balance sheet details
		getBalanceSheetDetails: function (date, fromDate, toDate, year, month, week, locationId, accountingMethod){
			if (validateForm_FromDateAndToDate()) {
				$("#report_result").empty();
				$("#pdf_report_details_div").show();
				$(".loader").show();
				$.ajax({
					type: "POST",
					url: "<?php echo base_url(); ?>accountsManagerModule/reportsSection/bookkeeping_report_controller/getBalanceSheetDetailsReport",
					data: {
						'date' : date,
						'from_date' : fromDate,
						'to_date' : toDate,
						'year' : year,
						'month' : month,
						'week' : week,
						'location_id' : locationId,
						'accounting_method' : accountingMethod,
						'<?php echo $this->security->get_csrf_token_name(); ?>':'<?php echo $this->security->get_csrf_hash(); ?>'
					},
					dataType: 'html',
					success:function (response) {
					}
				})
			}
		},
		
		//get profit and loss details
		getProfitAndLossDetails: function (date, fromDate, toDate, year, month, week, locationId, accountingMethod){
			if (validateForm_FromDateAndToDate()) {
				$("#report_result").empty();
				$("#pdf_report_details_div").show();
				$(".loader").show();
				$.ajax({
					type: "POST",
					url: "<?php echo base_url(); ?>accountsManagerModule/reportsSection/bookkeeping_report_controller/getProfitAndLossDetailsReport",
					data: {
						'date' : date,
						'from_date' : fromDate,
						'to_date' : toDate,
						'year' : year,
						'month' : month,
						'week' : week,
						'location_id' : locationId,
						'accounting_method' : accountingMethod,
						'<?php echo $this->security->get_csrf_token_name(); ?>':'<?php echo $this->security->get_csrf_hash(); ?>'
					},
					dataType: 'html',
					success:function (response) {
					}
				})
			}
		},
		
		//get debtors details
		getDebtorsDetails: function (date, fromDate, toDate, year, month, locationId, debtorId, summaryReport, salesInvoiceCategory){
			if (validateForm_FromDateAndToDate()) {
				$("#report_result").empty();
				$("#pdf_report_details_div").show();
				$(".loader").show();
				$.ajax({
					type: "POST",
					url: "<?php echo base_url(); ?>accountsManagerModule/reportsSection/bookkeeping_report_controller/getDebtorsDetailsReport",
					data: {
						'date' : date,
						'from_date' : fromDate,
						'to_date' : toDate,
						'year' : year,
						'month' : month,
						'location_id' : locationId,
						'debtor_id' : debtorId,
                        'summary_report' : summaryReport,
                        'sales_invoice_category' : salesInvoiceCategory,
						'<?php echo $this->security->get_csrf_token_name(); ?>':'<?php echo $this->security->get_csrf_hash(); ?>'
					},
					dataType: 'html',
					success:function (response) {
                        
					}
				}).done(function() {
                    var html = "<object data='<?php echo base_url(); ?>temporaryFiles/Debtors.pdf' type='application/pdf' width='100%' height='100%'>" +
									"<p>Your web browser doesnt have a PDF plugin. " +
									"Instead you can <a href='<?php echo base_url(); ?>temporaryFiles/Debtors.pdf'>click here to " +
									"download the PDF file.</a></p>" +
								"</object>";
					$("#report_result").append(html);
                });
			}
		},
		
		//get creditors details
		getCreditorsDetails: function (date, fromDate, toDate, year, month, locationId, creditorId, summaryReport){
			if (validateForm_FromDateAndToDate()) {
				$("#report_result").empty();
				$("#pdf_report_details_div").show();
				$(".loader").show();
				$.ajax({
					type: "POST",
					url: "<?php echo base_url(); ?>accountsManagerModule/reportsSection/bookkeeping_report_controller/getCreditorsDetailsReport",
					data: {
						'date' : date,
						'from_date' : fromDate,
						'to_date' : toDate,
						'year' : year,
						'month' : month,
						'location_id' : locationId,
						'creditor_id' : creditorId,
                        'summary_report' : summaryReport,
						'<?php echo $this->security->get_csrf_token_name(); ?>':'<?php echo $this->security->get_csrf_hash(); ?>'
					},
					dataType: 'html',
					success:function (response) {
					}
				})
			}
		},
        
        //get cash and cash equivalents details
		getCashAndCashEquivalentDetails: function (locationId){
			if (validateForm_FromDateAndToDate()) {
				$("#report_result").empty();
				$("#pdf_report_details_div").show();
				$(".loader").show();
				$.ajax({
					type: "POST",
					url: "<?php echo base_url(); ?>accountsManagerModule/reportsSection/bookkeeping_report_controller/getCashAndCashEquivalentDetails",
					data: {
						'location_id' : locationId,
						'<?php echo $this->security->get_csrf_token_name(); ?>':'<?php echo $this->security->get_csrf_hash(); ?>'
					},
					dataType: 'html',
					success:function (response) {
					}
				})
			}
		},
		
		//get people drop down
		getPeopleData: function () {
			$.ajax({
				type: "POST",
				url: "<?php echo base_url(); ?>organizationManagerModule/adminSection/peoples_controller/getAllToPeopleDropDownWithPeopleCode",
				data: {
                    'check_authority' : "Yes",
					'<?php echo $this->security->get_csrf_token_name(); ?>':
					'<?php echo $this->security->get_csrf_hash(); ?>'
				},
				dataType: 'html',
				success:
					function (response) {
						$('#person_init').hide();
						$("#person_dropdown").html(response);
						$("#people_id").select2();
					}
			});
		},
        
		init : function () {
			$(".loader").hide();
			$("#table").hide();
			$(".msg_data").hide();
			$(".validation").hide();
			$('.accountDetails').hide();            
		}
	}

	function validateForm_FromDateAndToDate() {
		if ($("#from_date").val() != '' || $("#to_date").val() != '') {
			return (isNotEmpty("from_date", "<?php echo $this->lang->line('From Date').' '.$this->lang->line('field is required')?>")
				&& isNotEmpty("to_date", "<?php echo $this->lang->line('To Date').' '.$this->lang->line('field is required')?>")
			);
		} else {
			return true;
		}
	}

</script>

<style>
	.product_filter {
		vertical-align: text-bottom;
	}

	.summary_report_filter, cancelled_sales_notes_filter {
		vertical-align: text-bottom;
	}
	
	.cancelled_sales_notes_filter {
		vertical-align: text-bottom;
	}

	.table-scrollable-area {
		width: 100%;
		overflow-x: scroll;
		overflow-y: hidden; 
	}
	
	input[type="radio"] {
		margin-top: -1px;
		vertical-align: middle;
	}

	/* Freez the first coloumn in Lorry Product Loading report */
	.inventoryProductLoadingReportDataTable > tbody > tr > td:first-child {
		position: absolute;
		display: inline-block;
		background-color: greenyellow;
		width: 205px;
		height: 40px;
	}

	.inventoryProductLoadingReportDataTable > thead > tr > th:first-child {
		padding-left: 80px !important;
		padding-right: 80px !important;
	}

	.inventoryProductLoadingReportDataTable > tbody > tr > td:first-child {
		padding-left: 40px !important;
		padding-right: 40px !important;
	}

	.inventoryProductLoadingReportDataTable > thead > tr > th:nth-child(2) {
		padding-left: 60px !important;
	}
	/*                       End                               */
</style>
