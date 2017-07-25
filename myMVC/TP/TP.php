<?php
/**
 * Created by PhpStorm.
 * User: MR.L
 * Date: 2017/1/26
 * Time: 2:21
 */
define('TPPATH',__DIR__);

require(__DIR__ . '/TPBase.php');

class TP extends \TP\TPBase{

}
TP::$map=[
    'TP'                =>      TPPATH.'/TP.php',
    'TP\Base\App'       =>      TPPATH.'/Base/App.php',
    'TP\Base\Log'       =>      TPPATH.'/Base/Log.php',
    'TP\Base\Controller'=>      TPPATH.'/Base/Controller.php',
    'TP\Base\Model'     =>      TPPATH.'/Base/Model.php',
    'TP\Base\DB'        =>      TPPATH.'/Base/DB.php',
    'TP\Tool\Upload'    =>      TPPATH.'/Tool/Upload.php',
    'TP\Tool\Page'      =>      TPPATH.'/Tool/Page.php',
    'TP\Tool\Vcode'     =>      TPPATH.'/Tool/Vcode.php',
    'TP\Tool\imgTool'   =>      TPPATH.'/Tool/imgTool.php',
    'TP\Tool\CurlUtils'   =>    TPPATH.'/Tool/CurlUtils.php'
];
spl_autoload_register(['TP','loadclass']);



