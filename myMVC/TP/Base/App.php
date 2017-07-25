<?php
/**
 * Created by PhpStorm.
 * User: MR.L
 * Date: 2017/1/26
 * Time: 0:03
 */
namespace TP\Base;
/**
 * 功能能
 * 1.完成一个项目的初始化，
 * 2.控制器实例化
 * 3.错误接管，及控制器调用
 * 4.路由分析
 * */
class App{
    public function __construct(){

        if( defined('APP_DEBUG') ){//是否开启debug模式

            $this->initSystemHandlers();

        }else{

            error_reporting(0);

        }

    }
    /*
     *
     * 错误接管
     * */
    public function initSystemHandlers(){

        set_error_handler([$this,'handlerError']);

        set_exception_handler([$this,'handlerException']);

    }
    /*
     * 错误句柄函数(接管系统的错误)
     *
     * @param   int   $errno   错误级别
     *
     * @param   string  $errstr  错误的信息
     *
     * @param   string  $errfile  错误的文件
     *
     * @param   int     $errline   错误的行数
     *
     * @throw   obj     $exception   错误对象
     *
     * */
    public function handlerError( $errno,$errstr,$errfile,$errline ){
        //将错误把错误打包成一个异常
        $exception = new \ErrorException( $errstr,$errno,1,$errfile,$errline );
        //$this->handlerException( $exception );
        throw $exception;

    }
    /*
     * 异常句柄函数(接管系统的异常)
     *
     * @param obj[错误对象]
     *
     * */
    public function handlerException( $exception ){
        //调用异常
        $this->handler($exception);

    }
    public function handler( $exception ){
        //echo '出错';
        //异常信息
        $msg = $exception->getMessage();
        //异常的行
        $line = $exception->getLine();
        //异常的文件
        $file = $exception->getFile();
        //出错的代码
        $traces=$exception->getTrace();
        //在屏幕上输出
        echo '错误文件:'.$file.'<br/>line:'.$line.'; 错误信息:'.$msg.';<br/><pre>';
        //调用栈
        if($traces instanceof \ErrorException){//判断是不是系统ErrorException打包的异常，如果是把栈中多余的第一项删除
            array_shift($traces);
        }
        print_r($traces);
    }
    /*
     * 路由器，分析URL，计算要调用的控制器和方法名
     * @return array() 内含控制器和方法
     * */
    public function resolve(){

        static $ca=null;

        if( $ca!==null ){

            return $ca;

        }
        //获取域名后面的参数/controller/method
        $path=isset( $_SERVER['PATH_INFO']) ? $_SERVER['PATH_INFO'] : '';
        //去两端斜线
        $path=trim( $path,'/' );

        if( $path=='' ){

            $path=[];


        }else{

            $path=explode('/',trim($path,'/'));

        }

        $ca=$path+['Home','Index','index'];//如果键名为数组，数组相加会将最先出现的值作为结果，后面键名相同的会被抛弃
        //分析地址栏参数

        $params = array_slice( $path,3 );//切割掉前两个(控制器和方法)

        for( $i = 0, $len = count( $params ); $i<$len - 1; $i +=2 ){

            $_GET[$params[$i]] = $params[$i+1];

        }
       // print_r($params);exit;
        return $ca;
    }
    /*
     *
     * 创建控制器
     * @return Controller的实例
     * */
    public function createController( $module,$controller ){

        //list($controller,$action)=$this->resolve();

        $className  =  $controller;
        $mod=$module;
        $classFile  =  APP_PATH.'/'.$mod.'/Controller/'.$className.'.php';

        //不同的模块下的控制器

        $class = $mod.'\\'.$className;

        //判断文件是否存在(只判断文件)

        if( !class_exists( $class ,false ) && is_file( $classFile ) ){

            //修正自动加载的路径
            \TP::$map[$class] = $classFile;

        }

        return new $class();

    }
    /*
     *
     * 调用控制器的方法
     * */
    public function runController(){
        //把地址栏的参数分析出来


        list($module,$controller,$action) = $this->resolve();

        define('C',$controller);

        define('A',$action);
        $c=$this->createController($module,$controller);

        //var_dump(strtolower(C) == strtolower(A));

        //屏蔽php旧版本的特性，即和类同名的方法是本类的构造函数的问题,在这里我用了命名空间解决

            $c->$action();



    }
    /*
     * 创建url
     * */
    public function createUrl(){

        $params=[C,A];

        foreach( $_GET as $k=>$v ){

            $params[]=$k;

            $params[]=$v;

        }
        return implode( '/', $params );
    }

}


?>