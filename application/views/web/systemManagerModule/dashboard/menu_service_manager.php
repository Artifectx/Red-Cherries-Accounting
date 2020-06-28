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

<div id='wrapper'>
    <div id='main-nav-bg'></div>
    <nav id='main-nav'>
        <div class='navigation'>
            <ul class='nav nav-stacked'>
                <li class='active'>
                    <a class="menuBox" href='<?php echo base_url(); ?>common/dashboard_controller/dashboardServiceManager'>
                        <i class='icon-dashboard' ></i>
                        <span><?php echo $this->lang->line('Dashboard - Service Manager') ?></span>
                    </a>
                </li>
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