<?php
/**
 * Created by PhpStorm.
 * User: MR.L
 * Date: 2017/1/26
 * Time: 1:26
 */

namespace TP;

/*
 * 创建基类
 * */
class TPBase
{
    //单例
    protected static $app = null;
    //自动加载的类文件
    public static    $map = [];
    public function __construct(){

        self::setincludpath();

    }
    /*
     * 负责实例化App类
     * */
    public static function app(){

        if( self::$app ===  null || !( self::$app instanceof \TP\Base\App )){
           self::setincludpath();
            self::$app = new \TP\Base\App();
        }

        return self::$app;
    }
    /*
     * 自动加载函数
     *
     * */
    public static function setincludpath(){

        set_include_path( get_include_path().PATH_SEPARATOR."./Tool");

    }
    /*
     *
     * 自动加载
     * */
    public static function loadclass($class){

        $classFile = isset( self::$map[$class] ) ? self::$map[$class] : '';
        if( is_file( $classFile ) ){

            require( $classFile );

        }else if( stripos( $class,'Model' ) !== false ){

            $classFile         = APP_PATH.'/Model/'.$class.'.php';

            self::$map[$class] = $classFile;

            require( $classFile );
        }else if( stripos( $class,'Tool' ) !== false ){

            $classFile         = APP_PATH.'/Tool/'.$class.'.php';

            self::$map[$class] = $classFile;

            require( $classFile );
        }

    }

}

