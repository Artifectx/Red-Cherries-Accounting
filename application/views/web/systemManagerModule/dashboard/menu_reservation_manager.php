<?php

$moduleSections = $this->user_model->getAllSubModuleSectionsBySystemModuleName('Service Manager', 'Reservation Manager', 'module_section_name', 'asc');
$moduleSectionStatus = array();
foreach($moduleSections as $row){
    $moduleSectionStatus[$row->module_section_name] = $row->module_section_status;
}

//Administration Section
if (isset($ul_class_administration_section)) $ul_class_administration = $ul_class_administration_section;
else $ul_class_administration = 'nav nav-stacked';

//Reservation Details Section
if (isset($ul_class_reservation_section)) $ul_class_reservation = $ul_class_reservation_section;
else $ul_class_reservation = 'nav nav-stacked';

?>
<div id='wrapper'>
    <div id='main-nav-bg'></div>
    <nav id='main-nav'>
        <div class='navigation'>
            <ul class='nav nav-stacked'>
                <li class='active'>
                    <a class="menuBox" href='<?php echo base_url(); ?>systemManagerModule/dashboard_controller/dashboardReservationManager'>
                        <i class='icon-dashboard' ></i>
                        <span><?php echo $this->lang->line('Dashboard - Reservation Manager') ?></span>
                    </a>
                </li>
                <?php
                if($moduleSectionStatus['Administration'] == 1 && isset($SVM_RSM_View_Module_Permissions)) {
                    if (isset($SVM_RSM_Admin_View_Buildings_Permissions) || isset($SVM_RSM_Admin_View_Halls_Permissions) ||
                        isset($SVM_RSM_Admin_View_Rooms_Permissions)) {
                        ?>
                        <li class=''>
                            <a class="dropdown-collapse menuBox" href="#"><i class='icon-briefcase'></i>
                                <span><?php echo $this->lang->line('Administration') ?></span>
                                <i class='icon-angle-down angle-down'></i>
                            </a>

                            <ul class='<?php echo $ul_class_administration; ?>'>
                                <?php
                                if(isset($SVM_RSM_Admin_View_Buildings_Permissions)) {
                                    ?>
                                    <li class='<?php if ($li_class_buildings) echo $li_class_buildings; else ''; ?>'>
                                        <a href='<?php echo base_url(); ?>serviceManagerModule/reservationManagerModule/adminSection/buildings_controller'>
                                            <i class='icon-caret-right'></i>
                                            <span><?php echo $this->lang->line('Buildings') ?></span>
                                        </a>
                                    </li>
                                    <?php
                                }
                                if(isset($SVM_RSM_Admin_View_Halls_Permissions)) {
                                    ?>
                                    <li class='<?php if ($li_class_halls) echo $li_class_halls; else ''; ?>'>
                                        <a href='<?php echo base_url(); ?>serviceManagerModule/reservationManagerModule/adminSection/halls_controller'>
                                            <i class='icon-caret-right'></i>
                                            <span><?php echo $this->lang->line('Halls') ?></span>
                                        </a>
                                    </li>
                                    <?php
                                }
                                if(isset($SVM_RSM_Admin_View_Rooms_Permissions)) {
                                    ?>
                                    <li class='<?php if ($li_class_rooms) echo $li_class_rooms; else ''; ?>'>
                                        <a href='<?php echo base_url(); ?>serviceManagerModule/reservationManagerModule/adminSection/rooms_controller'>
                                            <i class='icon-caret-right'></i>
                                            <span><?php echo $this->lang->line('Rooms') ?></span>
                                        </a>
                                    </li>
                                    <?php
                                }
                                ?>
                                <li class='<?php if ($li_class_admin_help) echo $li_class_admin_help; else ''; ?>'>
                                    <a href='<?php echo base_url(); ?>serviceManagerModule/reservationManagerModule/adminSection/admin_help_controller'>
                                        <i class='icon-caret-right'></i>
                                        <span><?php echo $this->lang->line('Help') ?></span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <?php
                    }
                }

                if($moduleSectionStatus['Reservation'] == 1 && isset($SVM_RSM_View_Module_Permissions)) {
                        ?>
                        <li class=''>
                            <a class='dropdown-collapse menuBox' href='#'><i class='icon-user'></i>
                                <span><?php echo $this->lang->line('Reservation Details') ?></span>
                                <i class='icon-angle-down angle-down'></i>
                            </a>
                            <ul class='<?php echo $ul_class_reservation; ?>'>
                                <li class='<?php if ($li_class_reservation_help) echo $li_class_reservation_help; else ''; ?>'>
                                    <a href='<?php echo base_url(); ?>serviceManagerModule/reservationManagerModule/reservationSection/reservation_help_controller'>
                                        <i class='icon-caret-right'></i>
                                        <span><?php echo $this->lang->line('Help') ?></span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <?php
                }
                ?>
            </ul>
        </div>
    </nav>

    <style>
        .menuBox:hover {
            -moz-border-radius-topleft: 10px;
            -moz-border-radius-topright: 10px;
            -moz-border-radius-bottomright: 10px;
            -moz-border-radius-bottomleft: 10px;
            -webkit-border-radius: 10px 10px 10px 10px;
            border-radius: 10px 10px 10px 10px;
        }
    </style>