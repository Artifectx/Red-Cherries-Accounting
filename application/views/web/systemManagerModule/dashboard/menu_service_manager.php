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