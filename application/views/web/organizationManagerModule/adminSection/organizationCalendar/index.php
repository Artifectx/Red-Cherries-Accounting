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
								<span><?php echo $this->lang->line('Organization Calendar') ?></span>
							</h1>
							<div class='pull-right'></div>
						</div>
					</div>
				</div>

				<div id='table'>
					<div class='row'>
						<div class='col-sm-12'>
							<div class='box bordered-box <?php echo BOXHEADER; ?>-border' style='margin-bottom:0;'>
								<div class='box'>
									<div class='box-header'>
										<div class='title'><?php echo $this->lang->line('Select Organization Calendar') ?></div>
									</div>
									<div class='box-content'>
										<div class='row'>
											<div class='form-group col-sm-12 controls'>
												<label class='control-label col-sm-2'><?php echo $this->lang->line('Country') ?></label>
												<div class='col-sm-4 controls'>
													<select class='select form-control' id='country' name='country' onchange='onChangeCountry();'>
														<?php echo $country_list; ?>
													</select>
												</div>
											</div>
										</div>
										<br>
										<div class='row'>
											<div class='form-group col-sm-12 controls'>
												<label class='control-label col-sm-2'><?php echo $this->lang->line('Company') ?></label>
												<div class='col-sm-4 controls'>
													<select class='select form-control' id='company' name='company' onchange='onChangeCompany();'>
														<?php echo $company_list; ?>
													</select>
												</div>
											</div>
										</div>
									</div>
								</div>
								
								<div class='box'>
									<div class='box-content'>
										<div class='row'>
											<div class='calendar_loader' align="center"><img src="<?php echo base_url();?>assets/images/ajax-loader.gif"/> Updating the calendar. Please wait...</div>
										</div>
										<div class='box'>
											
											<!--Showing messages-->
											<div class='msg_data'></div>
											
											<div class='box-content'>
												<div class='container'>
													<div class='row' id='content-wrapper'>
														<div class='col-xs-12'>
															<div class='row'>
																<div class='col-sm-3' id='events'>
																	<div class='box'>
																		<div class='box-header'>
																			<div class='title'><?php echo $this->lang->line('Draggable Day Types') ?></div>
																		</div>
																		<div class='box-content shift-container' id='external-events'>
																		</div>
																	</div>
																	<div class='box' style="margin-top:270px">
																		<div class='box-header'>
																			<div class='title'><?php echo $this->lang->line('Calendar Days Garbage') ?></div>
																		</div>
																		<div class='box-content garbage-container' id='roster_garbage'>
																			<p>
																				<img title="<?php echo $this->lang->line('Drag and drop calendar days from the calendar to the garbage bin to delete the calendar day from organization calendar') ?>" src="<?php echo base_url();?>assets/images/trashcan.png" id="trash" alt="">
																			</p>
																		</div>
																	</div>
																</div>
																<div class='col-sm-9'>
																	<div class='box'>
																		<div class='box-header'>
																			<div class='title'><?php echo $this->lang->line('Organization Calendar') ?></div>
																		</div>
																		<div class='box-content calendarContainer'>
																			<div id='wrap'>
																					<div id='calendar'></div>
																					<div style='clear:both'></div>
																			</div>
																		</div>
																	</div>
																</div>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

<script src="<?php echo base_url();?>ajax/jquery.js"></script>
<script src="<?php echo base_url(); ?>ajax/validate.js"></script>

<script>

	var CurrentMousePos = '';

	$(document).ready(function() {
		// For fullcalendar /////////////////////////////////
		CurrentMousePos = {
			x: -1,
			y: -1
		};

		jQuery(document).on("mousemove", function (event) {
			CurrentMousePos.x = event.pageX;
			CurrentMousePos.y = event.pageY;//alert(CurrentMousePos.x + ", " + CurrentMousePos.y)
		});
		/////////////////////////////////////////////////////
		
		$(".calendar_loader").hide();
		$("#country").select2();
		
		OrganizationCalendar.initializeCalendar('', '');
	});

	function clickToday() {
		if (!$("tr.fc-week").is(':visible')) {
		  $('.fc-today-button').click();
		}
	}
	
	function onChangeCountry() {
		var countryCode = $("#country").val();
		var companyId = $("#company").val();
		OrganizationCalendar.initializeCalendar(countryCode, companyId);
	}
	
	function onChangeCompany() {
		var countryCode = $("#country").val();
		var companyId = $("#company").val();
		OrganizationCalendar.initializeCalendar(countryCode, companyId);
	}

	var OrganizationCalendar = {

		initializeCalendar: function(countryCode, companyId) {

			$.ajax({
				type:"POST",
				url: "<?php echo base_url(); ?>organizationManagerModule/adminSection/organization_calendar_controller/initializeCalendar",
				data: {
					<?php echo $this->security->get_csrf_token_name(); ?>: '<?php echo $this->security->get_csrf_hash(); ?>'
				},
				dataType: 'json',
				success: function(responseData) {
					$("#external-events").empty();
					$("#external-events").append(responseData.draggableDayTypes);

					$("#calendar").fullCalendar('destroy');
					getFreshEvents(countryCode, companyId);
					initializeFullcalendar();
					initializeExternalEvents();
					window.setTimeout(clickToday, 150);

					$(".calendar_loader").hide();
					$(".msg_data").hide();
					$(".msg_delete").hide();
					$(".msg_data").hide();
					$(".validation").hide();
				}
			});
		}
	}

	// For fullcalendar /////////////////////////////////////////////////////////////////////////////
	function initializeExternalEvents() {
		$('#external-events .fc-event').each(function() {

			// store data so the calendar knows to render an event upon drop
			$(this).data('event', {
					title: $.trim($(this).text()), // use the element's text as the event title
					stick: true, // maintain when user navigates (see docs on the renderEvent method)
					tooltip: 'Test'
			});

			<?php
			if (isset($OGM_Admin_Edit_Calendar_Days_Permissions)){
			?>
				// make the event draggable using jQuery UI
				$(this).draggable({
						zIndex: 999,
						revert: true,      // will cause the event to go back to its
						revertDuration: 0,  //  original position after the drag
						containment: "#external-events",
						scroll: false
				});
			<?php
			}
			?>

		});
	}

	function initializeFullcalendar() {
		var msg = '<div class="alert alert-success alert-dismissable">' +
				'<a class="close" href="#" data-dismiss="alert">× </a>' +
				'<h4><i class="icon-ok-sign"></i>' +
				'<?php echo $this->lang->line('success')?></h4>' +
				'<?php echo $this->lang->line('success_updated')?>' +
				'</div>';
		
		var country = $("#country").val();
		var company = $("#company").val();
		
		<?php
		if (isset($OGM_Admin_Edit_Calendar_Days_Permissions)){
		?>
			$('#calendar').fullCalendar({
				//events: JSON.parse(json_events),
				//events: [{"id":"14","title":"New Event","start":"2016-09-24T16:00:00+04:00","allDay":false}],
				events: [],
				utc: true,
				header: {
						left: 'prev,next today',
						center: 'title',
						right: 'month,agendaWeek,agendaDay'
				},
				editable: true,
				droppable: true, 
				//slotDuration: '00:30:00',

				activate: function(event, ui) {
					$('#calendar').fullCalendar('render');
				},

				eventReceive: function(event){
					$(".msg_data").hide();
					var title = event.title;
					var start = event.start.format("YYYY-MM-DD[T]HH:mm:SS");
					
					$(".calendar_loader").show();
					
					$.ajax({
						//url: 'process.php',
						url: "<?php echo base_url(); ?>organizationManagerModule/adminSection/organization_calendar_controller/updateOrganizationCalendar",
						data: {
							'type' : 'new',
							'country_code' : country,
							'company_id' : company,
							'title' : title,
							'start_date' : start,
							<?php echo $this->security->get_csrf_token_name(); ?> : '<?php echo $this->security->get_csrf_hash(); ?>'
						},
						type: 'POST',
						dataType: 'json',
						success: function(response){
							$(".calendar_loader").hide();
							$('#calendar').fullCalendar('removeEvents');
							getFreshEvents(country, company);
							$(".msg_data").show();
							$(".msg_data").html(msg);
						},
						error: function(e){
							console.log(e.responseText);
						}
					});
					$('#calendar').fullCalendar('updateEvent',event);
					console.log(event);
				},

				eventDrop: function(event, delta, revertFunc) {
					$(".msg_data").hide();
					var title = event.title;
					var start = event.start.format();
					var end = (event.end == null) ? start : event.end.format();
					
					$(".calendar_loader").show();
					
					$.ajax({
						//url: 'process.php',
						url: "<?php echo base_url(); ?>organizationManagerModule/adminSection/organization_calendar_controller/updateOrganizationCalendar",
						type: 'POST',
						data: {
							'type' : 'remove',
							'country_code' : country,
							'company_id' : company,
							'start_date' : start,
							'delta' : (delta/(60*60*24*1000)),
							<?php echo $this->security->get_csrf_token_name(); ?> : '<?php echo $this->security->get_csrf_hash(); ?>'
						},
						dataType: 'json',
						success: function(response){
							console.log(response);
							if(response.status == 'success'){
								$('#calendar').fullCalendar('removeEvents');
								//getFreshEvents(EmployeeIDs[0]);
							}
						},
						error: function(e){	
								alert('Error processing your request: '+e.responseText);
						}
					});

					$.ajax({
						//url: 'process.php',
						url: "<?php echo base_url(); ?>organizationManagerModule/adminSection/organization_calendar_controller/updateOrganizationCalendar",
						data: {
							'type' : 'resetdate',
							'country_code' : country,
							'company_id' : company,
							'title' : title,
							'start_date' : start,
							'end_date' : end,
							<?php echo $this->security->get_csrf_token_name(); ?> : '<?php echo $this->security->get_csrf_hash(); ?>'
						},
						type: 'POST',
						dataType: 'json',
						success: function(response){
							if(response.status != 'success') {		    				
								revertFunc();
							} else {
								$(".calendar_loader").hide();
								$('#calendar').fullCalendar('removeEvents');
								getFreshEvents(country, company);
								$(".msg_data").show();
								$(".msg_data").html(msg);
							}
						},
						error: function(e){		    			
							revertFunc();
							alert('Error processing your request: '+e.responseText);
						}
					});
				},

				eventResize: function(event, delta, revertFunc) {
					$(".msg_data").hide();
					console.log(event);
					var title = event.title;
					var end = event.end.format();
					var start = event.start.format();
					
					$(".calendar_loader").show();
					
					$.ajax({
						//url: 'process.php',
						url: "<?php echo base_url(); ?>organizationManagerModule/adminSection/organization_calendar_controller/updateOrganizationCalendar",
						data: {
							'type' : 'resetdate',
							'country_code' : country,
							'company_id' : company,
							'title' : title,
							'start_date' : start,
							'end_date' : end,
							<?php echo $this->security->get_csrf_token_name(); ?> : '<?php echo $this->security->get_csrf_hash(); ?>'
						},
						type: 'POST',
						dataType: 'json',
						success: function(response){
							if(response.status != 'success') {		    				
								revertFunc();
							} else {
								$(".calendar_loader").hide();
								$('#calendar').fullCalendar('removeEvents');
								getFreshEvents(country, company);
								$(".msg_data").show();
								$(".msg_data").html(msg);
							}
						},
						error: function(e){		    			
							revertFunc();
							alert('Error processing your request: '+e.responseText);
						}
					});
				},

				eventDragStop: function (event, jsEvent, ui, view) {
					$(".msg_data").hide();
					var title = event.title;
					var start = event.start.format();
					var end = (event.end == null) ? start : event.end.format();
					
					if (isElemOverDiv()) {
						var con = confirm('Are you sure to delete this event permanently?');
						if(con == true) {
							$(".calendar_loader").show();
							$.ajax({
								//url: 'process.php',
								url: "<?php echo base_url(); ?>organizationManagerModule/adminSection/organization_calendar_controller/updateOrganizationCalendar",
								type: 'POST',
								data: {
									'type' : 'remove',
									'country_code' : country,
									'company_id' : company,
									'start_date' : start,
									<?php echo $this->security->get_csrf_token_name(); ?> : '<?php echo $this->security->get_csrf_hash(); ?>'
								},
								dataType: 'json',
								success: function(response){
									console.log(response);
									if(response.status == 'success'){
										$(".calendar_loader").hide();
										$('#calendar').fullCalendar('removeEvents');
										getFreshEvents(country, company);
										$(".msg_data").show();
										$(".msg_data").html(msg);
									}
								},
								error: function(e){	
										alert('Error processing your request: '+e.responseText);
								}
							});
						}   
					}
				}
			});
		<?php 
		} else if ($OGM_Admin_View_Calendar_Days_Permissions) {
		?>
			$('#calendar').fullCalendar({
				//events: JSON.parse(json_events),
				//events: [{"id":"14","title":"New Event","start":"2016-09-24T16:00:00+04:00","allDay":false}],
				events: [],
				utc: true,
				header: {
						left: 'prev,next today',
						center: 'title',
						right: 'month,agendaWeek,agendaDay'
				},
				editable: false,
				droppable: false, 
				//slotDuration: '00:30:00',

				activate: function(event, ui) {
					$('#calendar').fullCalendar('render');
				},

				eventReceive: function(event){
					$(".msg_data").hide();
					var title = event.title;
					var start = event.start.format("YYYY-MM-DD[T]HH:mm:SS");
					
					$(".calendar_loader").show();
					
					$.ajax({
						//url: 'process.php',
						url: "<?php echo base_url(); ?>organizationManagerModule/adminSection/organization_calendar_controller/updateOrganizationCalendar",
						data: {
							'type' : 'new',
							'title' : title,
							'start_date' : start,
							<?php echo $this->security->get_csrf_token_name(); ?> : '<?php echo $this->security->get_csrf_hash(); ?>'
						},
						type: 'POST',
						dataType: 'json',
						success: function(response){
							$(".calendar_loader").hide();
							$('#calendar').fullCalendar('removeEvents');
							getFreshEvents(country, company);
							$(".msg_data").show();
							$(".msg_data").html(msg);
						},
						error: function(e){
								console.log(e.responseText);

						}
					});
					$('#calendar').fullCalendar('updateEvent',event);
					console.log(event);
				}
			});
		<?php 
		}
		?>
	}

	function getFreshEvents(countryCode, companyId){
		var FreshEvents = [];
		$.ajax({
			url: "<?php echo base_url(); ?>organizationManagerModule/adminSection/organization_calendar_controller/updateOrganizationCalendar",
			type: 'POST', // Send post data
			dataType: 'json',
			data: {
				'country_code' : countryCode,
				'company_id' : companyId,
				'type' : 'fetch',
				<?php echo $this->security->get_csrf_token_name(); ?> : '<?php echo $this->security->get_csrf_hash(); ?>'
			},
			success: function(response){
				FreshEvents = response;
				$('#calendar').fullCalendar('removeEvents');
				$('#calendar').fullCalendar('addEventSource', FreshEvents);
				$("#calendar").fullCalendar('refetchEvents');
				$('#calendar').fullCalendar('rerenderEvents' );
			}
		});
	}

	function isElemOverDiv() {
		var trashEl = jQuery('#trash');

		var ofs = trashEl.offset();

		var x1 = ofs.left;
		var x2 = ofs.left + trashEl.outerWidth(true);
		var y1 = ofs.top;
		var y2 = ofs.top + trashEl.outerHeight(true);
		//alert("X1 : " + x1 + ", X2 : " + x2 + ", Y1 : " + y1 + ", Y2 : " + y2)
		//alert(CurrentMousePos.x + ", " + CurrentMousePos.y)
		if (CurrentMousePos.x >= x1 && CurrentMousePos.x <= x2 &&
			CurrentMousePos.y >= y1 && CurrentMousePos.y <= y2) {
			CurrentMousePos.x = -1;
			CurrentMousePos.y = -1;
			return true;
		}
		return false;
	}
</script>

<style>

	#trash{
		width:100px;
		height:auto;
		padding-bottom: -10px;
		display: block;
		margin: auto;
	}

	#wrap {
		width: 785px;
		margin: 0 auto;
		display:inline-block;
	}

	#external-events {
		float: left;
		width: 250px;
		padding: 10px 10px;
		border: 1px solid #DDDDDD;
		background: #FFFFFF;
		text-align: left;
	}

	#external-events .fc-event {
		margin: 10px 0;
		cursor: pointer;
		text-align: center;
		font-size : 11px;
	}

	#external-events p {
		margin: 1.5em 0;
		font-size: 11px;
		color: #666;
	}

	#external-events p input {
		margin: 0;
		vertical-align: middle;
	}

	#calendar {
		width: 785px;
	}

	.fc-title {
		white-space : pre-wrap;
		font-size: 12px;
	}

	.fc-day-header {
		background: #018ff8;
		color: #FFFFFF;
	}

	.shift-container {
		height: 250px;
		overflow:auto;
	}
	
	.calendarContainer {
		overflow-x: scroll;
	}
</style>