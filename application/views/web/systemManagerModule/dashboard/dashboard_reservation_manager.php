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

$moduleSections = $this->user_model->getAllSubModuleSectionsBySystemModuleName('Service Manager', 'Reservation Manager', 'module_section_name', 'asc');
$moduleSectionStatus = array();
foreach($moduleSections as $row){
    $moduleSectionStatus[$row->module_section_name] = $row->module_section_status;
}
?>
<section id='content'>
    <div class='container'>
        <div class='row' id='content-wrapper'>
            <div class='col-xs-12'>

                <div class='page-header page-header-with-buttons'>
                    <h1 class='pull-left'>
                        <i class='icon-dashboard'></i>
                        <span><?php echo $this->lang->line('Reservation Manager Dashboard') ?></span>
                    </h1>
                </div>
                <?php
                if($moduleSectionStatus['Administration']==1 && isset($SVM_RSM_View_Module_Permissions)) {
                ?>
                <?php
                if (isset($SVM_RSM_Admin_View_Buildings_Permissions) || isset($SVM_RSM_Admin_View_Halls_Permissions) ||
                    isset($SVM_RSM_Admin_View_Rooms_Permissions)) {
                    ?>
                    <div class='box'>
                        <div class='row'>
                            <div class='col-sm-12'>
                                <div class='text-center'>
                                    <div class='box'>
                                        <div class='box-content light_color_background' style="overflow:hidden; height:1%; padding-bottom: 30px;">
                                            <ul class="dash">
                                                <h3 align="left"><?php echo $this->lang->line('Administration') ?></h3>

                                                <p style="margin-bottom:0px">&nbsp;</p>
                                                <?php
                                                if (isset($SVM_RSM_Admin_View_Buildings_Permissions)) {
                                                    ?>
                                                    <li>
                                                        <a class="tip"
                                                           href="<?php echo base_url(); ?>serviceManagerModule/reservationManagerModule/adminSection/buildings_controller"
                                                           title="<?php echo $this->lang->line('Buildings') ?>">
                                                            <i><img src="<?php echo base_url(); ?>assets/images/icons/buildings.png"
                                                                    alt=""/></i>
                                                            <span><span><?php echo $this->lang->line('Buildings') ?></span></span>
                                                        </a>
                                                    </li>
                                                    <?php
                                                }
                                                if (isset($SVM_RSM_Admin_View_Halls_Permissions)) {
                                                    ?>
                                                    <li>
                                                        <a class="tip"
                                                           href="<?php echo base_url(); ?>serviceManagerModule/reservationManagerModule/adminSection/halls_controller"
                                                           title="<?php echo $this->lang->line('Halls') ?>">
                                                            <i><img src="<?php echo base_url(); ?>assets/images/icons/halls.png"
                                                                    alt=""/></i>
                                                            <span><span><?php echo $this->lang->line('Halls') ?></span></span>
                                                        </a>
                                                    </li>
                                                    <?php
                                                }
                                                if (isset($SVM_RSM_Admin_View_Rooms_Permissions)) {
                                                    ?>
                                                    <li>
                                                        <a class="tip"
                                                           href="<?php echo base_url(); ?>serviceManagerModule/reservationManagerModule/adminSection/rooms_controller"
                                                           title="<?php echo $this->lang->line('Rooms') ?>">
                                                            <i><img src="<?php echo base_url(); ?>assets/images/icons/rooms.png"
                                                                    alt=""/></i>
                                                            <span><span><?php echo $this->lang->line('Rooms') ?></span></span>
                                                        </a>
                                                    </li>
                                                    <?php
                                                }
                                                ?>
                                                <li>
                                                    <a class="tip"
                                                       href="<?php echo base_url(); ?>serviceManagerModule/reservationManagerModule/adminSection/admin_help_controller"
                                                       title="<?php echo $this->lang->line('Help') ?>">
                                                        <i><img src="<?php echo base_url(); ?>assets/images/icons/help.png"
                                                                alt=""/></i>
                                                        <span><span><?php echo $this->lang->line('Help') ?></span></span>
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                }

                if($moduleSectionStatus['Reservation']==1 && isset($SVM_RSM_View_Module_Permissions)) {
                ?>
                <div class='box'>
                    <div class='row'>
                        <div class='col-sm-12'>
                            <div class='text-center'>
                                <div class='box'>
                                    <div class='box-content light_color_background' style="overflow:hidden; height:1%; padding-bottom: 30px;">
                                        <ul class="dash">
                                            <h3 align="left"><?php echo $this->lang->line('Reservation Details') ?></h3>

                                            <p style="margin-bottom:0px">&nbsp;</p>

                                            <li>
                                                <a class="tip"
                                                   href="<?php echo base_url(); ?>serviceManagerModule/reservationManagerModule/reservationSection/reservation_help_controller"
                                                   title="<?php echo $this->lang->line('Help') ?>">
                                                    <i><img src="<?php echo base_url(); ?>assets/images/icons/help.png"
                                                            alt=""/></i>
                                                    <span><span><?php echo $this->lang->line('Help') ?></span></span>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
<?php
}
}
?>