<?php
/**
 * Created by PhpStorm.
 * User: MR.L
 * Date: 2017/4/16
 * Time: 19:10
 */

namespace TP\Base;


class Log
{
    const LOGFILE='curr.log';//日志的名称
    /*
     * @param string
     * */
    public static function write( $cont ){
        $cont.="\r\n";
        //判断文件大小是否备份
        $log=self::isBak();//计算文件的地址

        $fp=fopen($log,'a');

        fwrite($fp,"------------------------------------------------------------------------------\r\n");

        fwrite($fp,$cont);

        fwrite($fp,"------------------------------------------------------------------------------\r\n");
        fclose($fp);
    }
    //备份
    public static function bak(){
        //备份就是把文件改名，
        //改成年-月-日.bak形式
        $log=APP_PATH.'data/log/'.self::LOGFILE;

        $bak=APP_PATH.'data/log/'.date('ymd').mt_rand(10000,99999).'.bak';

        return rename($log,$bak);
    }
    //读取并判断日志的大小
    public static function isBak(){

        $log=APP_PATH.'data/log/'.self::LOGFILE;

        if(!file_exists($log)){//如果文件不存在则创建该文件

            touch($log);
            return $log;
        }
        //清除缓存
        //clearstatcache(true,$log);

        $size=filesize( $log );

        if( $size<=1024*1024 ){//判断大小

            return $log;

        }
        if( !self::bak() ){//大于1m；

            return $log;

        }else{

            touch($log);

            return $log;
        }

    }




}