<?php
/**
 * Created by PhpStorm.
 * User: MR.L
 * Date: 2017/1/26
 * Time: 14:20
 */
namespace TP\Base;

class Controller{


    protected $data = [];
    /*
     * 把参数传到模板上
     *
     *
     * */
    public function assign($k,$v){

        $this->data[$k]=$v;
        
    }
    /*
     * 显示模板
     * */
    public function display($template){

        extract($this->data);//解压数组，即['name'=>'李四'，'age'=>30]; $name=李四;$age=30;

        include(APP_PATH.'/View/'.$template.'.html');
    }


}



?>