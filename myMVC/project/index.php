<?php
/**
 * Created by PhpStorm.
 * User: MR.L
 * Date: 2017/1/26
 * Time: 14:37
 */

define('APP_PATH',__DIR__);
define('APP_DEBUG',true);//是否开启开发模式
require('../TP/TP.php');

TP::app()->runController();

//print_r(TP::app()->resolve());

?>