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
                                                    <option value="chinesesimplified" <?php if ($userLanguage == 'chinesesimplified'){ echo 'Selected';} ?>>Chinese (Simplified)</option>
                                                    <option value="chinesetraditional" <?php if ($userLanguage == 'chinesetraditional'){ echo 'Selected';} ?>>Chinese (Traditional)</option>
													<option value="english" <?php if ($userLanguage == 'english'){ echo 'Selected';} ?>>English</option>
                                                    <option value="french" <?php if ($userLanguage == 'french'){ echo 'Selected';} ?>>French</option>
                                                    <option value="german" <?php if ($userLanguage == 'german'){ echo 'Selected';} ?>>German</option>
                                                    <option value="hindi" <?php if ($userLanguage == 'hindi'){ echo 'Selected';} ?>>Hindi</option>
                                                    <option value="hungarian" <?php if ($userLanguage == 'hungarian'){ echo 'Selected';} ?>>Hungarian</option>
                                                    <option value="italian" <?php if ($userLanguage == 'italian'){ echo 'Selected';} ?>>Italian</option>
                                                    <option value="indonesian" <?php if ($userLanguage == 'indonesian'){ echo 'Selected';} ?>>Indonesian</option>
                                                    <option value="japanese" <?php if ($userLanguage == 'japanese'){ echo 'Selected';} ?>>Japanese</option>
                                                    <option value="korean" <?php if ($userLanguage == 'korean'){ echo 'Selected';} ?>>Korean</option>
                                                    <option value="nepali" <?php if ($userLanguage == 'nepali'){ echo 'Selected';} ?>>Nepali</option>
                                                    <option value="portuguese" <?php if ($userLanguage == 'portuguese'){ echo 'Selected';} ?>>Portuguese</option>
                                                    <option value="polish" <?php if ($userLanguage == 'polish'){ echo 'Selected';} ?>>Polish</option>
                                                    <option value="russian" <?php if ($userLanguage == 'russian'){ echo 'Selected';} ?>>Russian</option>
                                                    <option value="romanian" <?php if ($userLanguage == 'romanian'){ echo 'Selected';} ?>>Romanian</option>
                                                    <option value="sinhala" <?php if ($userLanguage == 'sinhala'){ echo 'Selected';} ?>>Sinhala</option>
                                                    <option value="spanish" <?php if ($userLanguage == 'spanish'){ echo 'Selected';} ?>>Spanish</option>
                                                    <option value="tamil" <?php if ($userLanguage == 'tamil'){ echo 'Selected';} ?>>Tamil</option>
                                                    <option value="thai" <?php if ($userLanguage == 'thai'){ echo 'Selected';} ?>>Thai</option>
                                                    <option value="turkish" <?php if ($userLanguage == 'turkish'){ echo 'Selected';} ?>>Turkish</option>
                                                    <option value="ukrainian" <?php if ($userLanguage == 'ukrainian'){ echo 'Selected';} ?>>Ukrainian</option>
                                                    <option value="vietnamese" <?php if ($userLanguage == 'vietnamese'){ echo 'Selected';} ?>>Vietnamese</option>
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
