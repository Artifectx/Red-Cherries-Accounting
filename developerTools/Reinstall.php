<?php

/* 
* To change this license header, choose License Headers in Project Properties.
* To change this template file, choose Tools | Templates
* and open the template in the editor.
*/

$class_name = 'Reinstall_system';

function __autoload($class_name) {
  require_once($class_name . '.php');

}

$vars = new Reinstall_system();