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
								<span><?php echo $this->lang->line('Bookkeeping Help') ?></span>
							</h1>
							<div class='pull-right'></div>
						</div>
					</div>
				</div>

				<div class='row'>
					<div class='col-sm-12'>
						<div class='box'>
							<div class='box-header <?php echo BOXHEADER; ?>-background'>
								<div class='title' <?php echo $menuFormatting; ?>><?php echo $this->lang->line('Bookkeeping Help') ?></div>
								<div class='actions'>
									<a class="btn box-collapse btn-xs btn-link" href="#"><i></i>
									</a>
								</div>
							</div>
							<div class='box-content'>
								<div class='msg_data'></div>
								<?php echo form_open('accountsManagerModule/bookkeepingSection/bookkeeping_help_controller/handleHelpActions', array('class' => 'form form-horizontal validate-form','id' => 'helpForm', 'style' => 'margin-bottom: 0;', 'enctype' => 'multipart/form-data')) ?>
								<!--<form class='form form-horizontal validate-form save_form' action='data_import_controller/handleDataImport'>-->

								<div class='form-group'>
									<div class='col-sm-3 col-sm-offset-1'>
										<button class='btn btn-success' type='submit' id="download" name='download' value='download_user_guide' <?php echo $menuFormatting; ?>>
											<i class='icon-save'></i>
											<?php echo $this->lang->line('Download Bookkeeping Help User Guide') ?>
										</button>
									</div>
								</div>  
								<!--</form>-->
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
		$(".loader").hide();
		var submitButton;

		$('button[type="submit"]').click(function(e){
			submitButton = $(this).val();
		 });
	});

</script>