<section id='content'>
	<div class='container'>
		<div class='row' id='content-wrapper'>
			<div class='col-xs-12'>
				<div class='row'>
					<div class='col-sm-12'>
						<div class='page-header'>
							<h1 class='pull-left'>
								<i class='icon-table'></i>
								<span><?php echo $this->lang->line('Donation Help') ?></span>
							</h1>
							<div class='pull-right'></div>
						</div>
					</div>
				</div>

				<div class='row'>
					<div class='col-sm-12'>
						<div class='box'>
							<div class='box-header <?php echo BOXHEADER; ?>-background'>
								<div class='title'><?php echo $this->lang->line('Donation Help') ?></div>
								<div class='actions'>
									<a class="btn box-collapse btn-xs btn-link" href="#"><i></i>
									</a>
								</div>
							</div>
							<div class='box-content'>
								<div class='msg_data'></div>
								<?php echo form_open('serviceManagerModule/donationManagerModule/donationSection/donation_help_controller/handleHelpActions', array('class' => 'form form-horizontal validate-form','id' => 'helpForm', 'style' => 'margin-bottom: 0;', 'enctype' => 'multipart/form-data')) ?>
								<!--<form class='form form-horizontal validate-form save_form' action='data_import_controller/handleDataImport'>-->

								<div class='form-group'>
									<div class='col-sm-3 col-sm-offset-1'>
										<button class='btn btn-success' type='submit' id="download" name='download' value='download_user_guide'>
											<i class='icon-save'></i>
											<?php echo $this->lang->line('Download Donation Help User Guide') ?>
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