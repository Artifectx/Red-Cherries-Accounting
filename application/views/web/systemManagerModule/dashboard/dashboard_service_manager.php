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

<div class='container'>
	<div class='col-xs-12'>
		<div class='col-xs-3 home-left-margin'></div>
			<div class='col-xs-6 home-for-desktop'>
				<div id="systemModules_home" class="collapse_home">
					<h1 class="welcome-to-rc-accounting">Red Cherries Accounting</h1>
					<h1 class="coming-soon-module-name" align="center"><?php echo $this->lang->line('Service Manager') ?></h1>
					<ul class="dash" style="margin: auto 5% auto 6%;">
					<?php
					$html = "";
					$url =  base_url();
					if ($system_sub_modules != null) {
						foreach ($system_sub_modules as $row) {
							if($row->system_sub_module == 'Donation Manager') {
								$html .= "<li style='margin: 0.5% 0.5% 0.5% 0.5%;'>
											<a class='tip'
											   href='#'
											   title='{$row->system_sub_module}' onclick='setSystemSubModulesHeaderTitle(\"{$row->system_sub_module}\",\"{$row->system_sub_module_dashboard_url}\")'>
												<i><img src='{$url}assets/images/system_modules/{$row->system_sub_module_image_url}'
														alt=''/></i>
												<span><span>{$row->system_sub_module}</span></span>
											</a>
										</li>";
							}
                            
                            /* More services related sub module can be implemented based on requirements.
                            if($row->system_sub_module == 'Reservation Manager') {
								$html .= "<li style='margin: 0.5% 0.5% 0.5% 0.5%;'>
											<a class='tip'
											   href='#'
											   title='{$row->system_sub_module}' onclick='setSystemSubModulesHeaderTitle(\"{$row->system_sub_module}\",\"{$row->system_sub_module_dashboard_url}\")'>
												<i><img src='{$url}assets/images/system_modules/{$row->system_sub_module_image_url}'
														alt=''/></i>
												<span><span>{$row->system_sub_module}</span></span>
											</a>
										</li>";
							} else if($row->system_sub_module == 'School Manager') {
								$html .= "<li style='margin: 0.5% 0.5% 0.5% 0.5%;'>
											<a class='tip'
											   href='#'
											   title='{$row->system_sub_module}' onclick='setSystemSubModulesHeaderTitle(\"{$row->system_sub_module}\",\"{$row->system_sub_module_dashboard_url}\")'>
												<i><img src='{$url}assets/images/system_modules/{$row->system_sub_module_image_url}'
														alt=''/></i>
												<span><span>{$row->system_sub_module}</span></span>
											</a>
										</li>";
							}*/
						}
					}
					echo $html;
					?>
					</ul>
				</div>
			</div>

			<div class='col-xs-12 home-for-mobile'>
				<div id="systemModules_home" class="collapse_home">
					<h1 class="welcome-to-eerplanner">Welcome To Red Cherries Accounting</h1>
					<h1 class="system-modules" align="center"><?php echo $this->lang->line('Service Manager') ?></h1>
					<ul class="dash" style="margin: auto -20% auto -8%;">
						<?php
						$html = "";
						$url =  base_url();
						if ($system_sub_modules != null) {
							foreach ($system_sub_modules as $row) {
								if($row->system_sub_module == 'Donation Manager') {
									$html .= "<li style='margin: 0.5% 0.5% 0.5% 0.5%;'>
											<a class='tip'
											   href='#'
											   title='{$row->system_sub_module}' onclick='setSystemSubModulesHeaderTitle(\"{$row->system_sub_module}\",\"{$row->system_sub_module_dashboard_url}\")'>
												<i><img src='{$url}assets/images/system_modules/{$row->system_sub_module_image_url}'
														alt=''/></i>
												<span><span>{$row->system_sub_module}</span></span>
											</a>
										</li>";
								} 
                                
                                /* More services related sub module can be implemented based on requirements.
                                if($row->system_sub_module == 'Reservation Manager') {
									$html .= "<li style='margin: 0.5% 0.5% 0.5% 0.5%;'>
											<a class='tip'
											   href='#'
											   title='{$row->system_sub_module}' onclick='setSystemSubModulesHeaderTitle(\"{$row->system_sub_module}\",\"{$row->system_sub_module_dashboard_url}\")'>
												<i><img src='{$url}assets/images/system_modules/{$row->system_sub_module_image_url}'
														alt=''/></i>
												<span><span>{$row->system_sub_module}</span></span>
											</a>
										</li>";
								} else if($row->system_sub_module == 'School Manager') {
									$html .= "<li style='margin: 0.5% 0.5% 0.5% 0.5%;'>
											<a class='tip'
											   href='#'
											   title='{$row->system_sub_module}' onclick='setSystemSubModulesHeaderTitle(\"{$row->system_sub_module}\",\"{$row->system_sub_module_dashboard_url}\")'>
												<i><img src='{$url}assets/images/system_modules/{$row->system_sub_module_image_url}'
														alt=''/></i>
												<span><span>{$row->system_sub_module}</span></span>
											</a>
										</li>";
								}*/
							}
						}
						echo $html;
						?>
					</ul>
				</div>
			</div>

		<div class='col-xs-3 home-right-margin'></div>

	</div>
</div>

<script>
	
	$(document).ready(function () {
		$(".btnHeaderMenu").addClass("page_load");
	});

	$(".tip").click(function () {
		$(".btnHeaderMenu").removeClass("page_load");
		$(".btnHeaderMenu").addClass("page_load_show");
	});

	function setSystemSubModulesHeaderTitle(systemModule, systemModuleUrl){
		var systemModule = systemModule;
		var systemModuleUrl = systemModuleUrl;
		$.ajax({
			type: "POST",
			url: "<?php echo base_url(); ?>home/setSystemModulesHeaderTitle",
			data: {
				'systemModule': systemModule,
				'systemModuleUrl': systemModuleUrl,
				<?php echo $this->security->get_csrf_token_name(); ?>:'<?php echo $this->security->get_csrf_hash(); ?>'
			},
			dataType: 'html',
				success:function (response) {
				window.location.href = response;
			}
		});
	}
</script>