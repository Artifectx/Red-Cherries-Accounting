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
                                <span><?php echo $this->lang->line('System Module Section Feature Details') ?></span>
                            </h1>

                            <div class='pull-right'></div>
                        </div>
                    </div>
                </div>

                <div id='table'>
                    <div class="msg_delete"></div>
                    <div class='row'>
                        <div class='col-sm-12'>
                            <div class='box bordered-box <?php //echo BOXHEADER; ?>-border' style='margin-bottom:0;'>
                                
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
        getTableData();
    });

    //get all data
    function getTableData(){
        $(".loader").show();
        $.ajax({
            type: "POST",
            url: "<?php echo base_url(); ?>userRoleManagerModule/productInformationSection/system_module_section_features_controller/getTableData",
            data: {
                <?php echo $this->security->get_csrf_token_name(); ?>:'<?php echo $this->security->get_csrf_hash(); ?>'
            },
            dataType: 'html',
                success:
            function (responce) {
                $("#dataTable").html(responce);
                $(".loader").hide();
                //$('.table').dataTable();
                $('#moduleTable').DataTable( {
                    "iDisplayLength": 5
                } );
            }
        })
    }
</script>
