<?php
/**
 * Created by PhpStorm.
 * User: MR.L
 * Date: 2017/1/26
 * Time: 15:25
 */
namespace Admin;
use \TP\Tool\Page;
use CartTool;
class Index extends \TP\Base\Controller{
    public function index(){
       $tool=new CartTool();
        $tool->alt();

    }
    public function show(){
        echo 'a2222';
    }
}



?>