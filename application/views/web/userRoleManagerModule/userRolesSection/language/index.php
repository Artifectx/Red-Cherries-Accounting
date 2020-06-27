<section id='content'>
	<div class='container'>
		<div class='row' id='content-wrapper'>
			<div class='col-xs-12'>
				<div class='row'>
					<div class='col-sm-12'>
						<div class='page-header'>
							<h1 class='pull-left'>
								<i class='icon-table'></i>
								<span><?php echo $this->lang->line('Change Language') ?></span>
							</h1>

							<div class='pull-right'></div>
						</div>
					</div>
				</div>

					<div class='row'>
						<div class='col-sm-12'>
							<div class='box'>
								<div class='box-header <?php echo BOXHEADER; ?>-background'>
									<div class='title' <?php echo $menuFormatting; ?>><?php echo $this->lang->line('Change Language') ?></div>
									<div class='actions'>
										<a class="btn box-collapse btn-xs btn-link" href="#"><i></i>
										</a>
									</div>
								</div>
								<div class='box-content'>
									<?php
									if($this->session->flashdata('flashSuccess')){
										echo '<div class="alert alert-success fade in"><a class="close" title="close" aria-label="close" data-dismiss="alert" href="#">×</a>';
										echo $this->session->flashdata('flashSuccess');
										echo '<br></div>';
									}
									if ($this->session->flashdata('flashError')) {
										echo '<div class="alert alert-danger fade in"><a class="close" title="close" aria-label="close" data-dismiss="alert" href="#">×</a>';
										echo $this->session->flashdata('flashError');
										echo '<br></div>';
									}
									?>
									<?php echo form_open('userRoleManagerModule/userRolesSection/profile_controller/changeLanguage', array('class' => 'form form-horizontal validate-form','id' => 'languageForm', 'style' => 'margin-bottom: 0;')) ?>
										<div class='form-group'>
											<label class='control-label col-sm-3 col-sm-3'><?php echo $this->lang->line('Language') ?> *</label>

											<div class='col-sm-4 controls'>
												<select class="form-control" id="new_language" name="new_language">
													<option value="0"><?php echo $this->lang->line('-- Select --') ?></option>
													<option value="english" <?php if ($userLanguage == 'english'){ echo 'Selected';} ?>><?php echo $this->lang->line('English') ?></option>
													<option value="sinhala" <?php if ($userLanguage == 'sinhala'){ echo 'Selected';} ?>><?php echo $this->lang->line('Sinhala') ?></option>
												</select>
												<div id="new_languageError" class="red"><?php echo form_error('new_language'); ?></div>
											</div>
										</div>
										<div class='form-actions' style='margin-bottom:0'>
											<div class='row'>
												<div class='col-sm-9 col-sm-offset-3'>
													<button class='btn btn-success save' type='submit' id="save_submit" <?php echo $menuFormatting; ?>>
														<i class='icon-save'></i>
														<?php echo $this->lang->line('Save') ?>
													</button>
												</div>
											</div>
										</div>
									</form>
									<!--edit form-->
									<div class='edit_form'></div>
								</div>
							</div>
						</div>
					</div>
			</div>
		</div>

<script src="<?php echo base_url(); ?>ajax/jquery.js"></script>
<script src="<?php echo base_url(); ?>ajax/validate.js"></script>

<script>
	$("#save_submit").click(function () {
		if ($("#new_language").val() == '0'){
			validateForm();
			return false;
		} else {
			return true;
		}
	});

	//form validation
	function validateForm() {
		return (isSelected("new_language", "<?php echo $this->lang->line('new_language')?>"));
	}
</script>
