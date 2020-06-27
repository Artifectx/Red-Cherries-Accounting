<section id='content'>
    <div class='container'>
        <div class='row' id='content-wrapper'>
            <div class='col-xs-12'>
                <div class='row'>
                    <div class='col-sm-12'>
                        <div class='page-header'>
                            <h1 class='pull-left'>
                                <i class='icon-table'></i>
                                <span><?php echo $this->lang->line('System Language Pack') ?></span>
                            </h1>

                            <div class='pull-right'></div>
                        </div>
                    </div>
                </div>
				
				<!--Showing messages-->
				<div class='msg_data'></div>

                <div id='table'>
                    <div class='row'>
                        <div class='col-sm-12'>
                            <div class='box bordered-box <?php echo BOXHEADER; ?>-border' style='margin-bottom:0;'>
								<div id="translation_generation_status_div">
									<label class='control-label col-sm-12' id="translation_generation_status" style="color:red; font-size:14pt; text-align:center;"></label>
								</div>
								<div class='box'>
									<div class='box-header'>
										<div class='title'><?php echo $this->lang->line('Search Strings') ?></div>
									</div>
									<div class='box-content'>
										<div class='form-group'>
											<div class='col-sm-14 controls'>
												<label class='control-label col-sm-2' ><?php echo $this->lang->line('Language') ?></label>
												<label class='control-label col-sm-3' ><?php echo $this->lang->line('System Module') ?></label>
												<label class='control-label col-sm-3' ><?php echo $this->lang->line('Screen') ?></label>
												<label class='control-label col-sm-3' ><?php echo $this->lang->line('String Type') ?></label>
												<label class='control-label col-sm-1' ></label>
											</div>
										</div>

										<div class='form-group'>
											<div class='col-sm-14 controls'>
												<div class='col-sm-2 controls'>
													<select class='select form-control' id='language_name' name='language_name' onchange='onChangeLanguage(this.id);'>
														<?php echo $language_list; ?>
													</select>
													<div id='language_nameError' class='red'></div>
												</div>
												<div class='col-sm-3 controls'>
													<select class='select form-control' id='system_module' name='system_module' onchange='onChangeSystemModule(this.id);'>
														<?php echo $system_module_list; ?>
													</select>
													<div id='system_moduleError' class='red'></div>
												</div>
												<div class='col-sm-3 controls'>
													<select class='select form-control' id='screen_list'>
														<option value='' selected="selected"><?php echo $this->lang->line('None') ?></option>
													</select>
												</div>
												<div class='col-sm-3 controls'>
													<select class='select form-control' id='string_type' name='string_type' onchange='onChangeStringType(this.id);'>
														<option value='' selected="selected"><?php echo $this->lang->line('All') ?></option>
														<option value='display_string'><?php echo $this->lang->line('Display Strings') ?></option>
														<option value='message'><?php echo $this->lang->line('Messages') ?></option>
														<option value='product_name'><?php echo $this->lang->line('Product Names') ?></option>
													</select>
													<div id='string_typeError' class='red'></div>
												</div>
												<div class='col-sm-1 controls'>
													<button class='btn btn-success' id="btnSearch" type='button' onclick="getTranslations();"><?php echo $this->lang->line('Search') ?></button>
												</div>
											</div>
											<p style="margin-bottom:-10px">&nbsp;</p>
										</div>
										
										<div class='col-sm-12 col-sm-offset-5 controls' id="translation_generation_div">
											<button class='btn btn-info' id="btnSearch" type='button' onclick="generateTranslations();"><?php echo $this->lang->line('Generate Translations') ?></button>
										</div>
									</div>
								</div>
								
                                <div class='loader' align="center"><img src="<?php echo base_url();?>assets/images/ajax-loader.gif"/> Loading data...</div>

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
		LanguagePack.init();
	});

	function getTranslations(){
		$(".loader").show();
		var moduleId = $("#system_module").val();
		var stringType = $("#string_type").val();
		var screen = $("#screen_list").val();
		var language = $("#language_name").val();
		LanguagePack.getTranslations(moduleId, stringType, screen, language);
	}
	
	function editTranslation(id) {
		var rowCount = id.substring(17,30);
		var languageTranslationId = $("#language_translation_id_" + rowCount).val();
		var languageStringId = $("#language_string_id_" + rowCount).val();
		var languageName = $("#language_name").val();
		var translatedString = $("#translation_edit_" + rowCount).val();
		LanguagePack.editTranslation(languageTranslationId, languageStringId, languageName, translatedString, rowCount);
	}
	
	function onChangeLanguage() {
		LanguagePack.getTranslationGenerationStatus();
	}
	
	function onChangeSystemModule(id) {
		var selectedModule = $("#" + id).val();
		LanguagePack.getScreenListOfSelectedModule(selectedModule);
	}
	
	function generateTranslations() {
		LanguagePack.generateTranslations();
	}

	var LanguagePack = {

		editTranslation: function (languageTranslationId, languageStringId, languageName, translatedString, rowCount) {
			var msg = '<div class="alert alert-success alert-dismissable">' +
				'<a class="close" href="#" data-dismiss="alert">x </a>' +
				'<h4><i class="icon-ok-sign"></i>' +
				'<?php echo $this->lang->line('success')?></h4>' +
				'<?php echo $this->lang->line('success_updated')?>' +
				'</div>';
			$.ajax({
				type: "POST",
				url: "<?php echo base_url(); ?>userRoleManagerModule/productInformationSection/system_language_pack_controller/editTranslation",
				data: {
					'language_translation_id' : languageTranslationId,
					'language_string_id': languageStringId,
					'language_name': languageName,
					'translated_string': translatedString,
					<?php echo $this->security->get_csrf_token_name(); ?>:'<?php echo $this->security->get_csrf_hash(); ?>'
				},
				dataType: 'html',
				success: function (response) {
					$("#language_translation_id_" + rowCount).val(response);
					$("#translation_generation_status").text("Translation Generation is Pending");
					$("#translation_generation_status_div").show();
					$("#translation_generation_div").show();
				}
			});
		},

		getTranslations: function (moduleId, stringType, screen, language) {
			$.ajax({
				type: "POST",
				url: "<?php echo base_url(); ?>userRoleManagerModule/productInformationSection/system_language_pack_controller/getTranslations",
				data: {
					'module_id' : moduleId,
					'string_type' : stringType,
					'screen' : screen,
					'language' : language,
					<?php echo $this->security->get_csrf_token_name(); ?>:'<?php echo $this->security->get_csrf_hash(); ?>'
				},
				dataType: 'html',
				success:function (response) {
					$("#dataTable").html(response);
					$("#languageTranslationDataTable").dataTable();
					$(".loader").hide();
					$("#dataTable").show();
				}
			});
		},
		
		getScreenListOfSelectedModule: function (selectedModule) {
			$.ajax({
				type: "POST",
				url: "<?php echo base_url(); ?>userRoleManagerModule/productInformationSection/system_language_pack_controller/getScreenListOfSelectedModule",
				data: {
					'module_id' : selectedModule,
					<?php echo $this->security->get_csrf_token_name(); ?>:'<?php echo $this->security->get_csrf_hash(); ?>'
				},
				dataType: 'html',
				success:function (response) {
					$("#screen_list").empty();
					$("#screen_list").html(response);
				}
			});
		},
		
		getTranslationGenerationStatus: function () {
			$.ajax({
				type: "POST",
				url: "<?php echo base_url(); ?>userRoleManagerModule/productInformationSection/system_language_pack_controller/getTranslationGenerationStatus",
				data: {
					'language' : $("#language_name").val(),
					<?php echo $this->security->get_csrf_token_name(); ?>:'<?php echo $this->security->get_csrf_hash(); ?>'
				},
				dataType: 'html',
				success:function (response) {
					if (response == "Pending") {
						$("#translation_generation_status").text("Translation Generation is Pending");
						$("#translation_generation_status_div").show();
						$("#translation_generation_div").show();
					} else {
						$("#translation_generation_status_div").hide();
						$("#translation_generation_div").hide();
					}
				}
			});
		},
		
		generateTranslations : function() {
			
			var msg='<div class="alert alert-success alert-dismissable">'+
				'<a class="close" href="#" data-dismiss="alert">× </a>'+
				'<h4><i class="icon-ok-sign"></i>'+
				'<?php echo $this->lang->line('Success') ?></h4>'+
				'<?php echo $this->lang->line('Language file generated successfully') ?>'+
				'</div>';
		
			$.ajax({
				type: "POST",
				url: "<?php echo base_url(); ?>userRoleManagerModule/productInformationSection/system_language_pack_controller/generateTranslations",
				data: {
					'language' : $("#language_name").val(),
					<?php echo $this->security->get_csrf_token_name(); ?>:'<?php echo $this->security->get_csrf_hash(); ?>'
				},
				dataType: 'html',
				success:function (response) {
					if (response == "ok") {
						$(".msg_data").show();
						$(".msg_data").html(msg);
						$("#translation_generation_status_div").hide();
						$("#translation_generation_div").hide();
					}
				}
			});
		},

		init : function () {
			$(".loader").hide();
			$(".msg_data").hide();
			$("#dataTable").hide();
			$("#translation_generation_status_div").hide();
			$("#translation_generation_div").hide();
			LanguagePack.getTranslationGenerationStatus();
		}
	};
</script>
