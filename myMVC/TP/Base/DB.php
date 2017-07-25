<?php
/**
 * Created by PhpStorm.
 * User: MR.L
 * Date: 2017/1/29
 * Time: 1:26
 */
namespace TP\Base;
use \TP\Base\Log;
class DB extends \PDO
{

    public function __construct(){

        $cfg=include(APP_PATH.'/config.php');

        $dsn=$cfg['dirve'].':host='.$cfg['host'].';dbname='.$cfg['dbname'];

        parent::__construct($dsn,$cfg['user'],$cfg['password']);

        $this->charset($cfg['charset']);


    }
    /*
     * 选择数据库
     * */
    public  function useDB( $db ){
        $sql='use '.$db ;
        $this->exec( $sql );
        Log::write($sql);

    }
    /*
     *
     * 设置字符集
     * @param string $char 默认是字符串
     * */
    public function charset( $char='utf8' ){
        $sql='set names '.$char;
        $this->exec($sql);
        Log::write($sql);
    }
    /*
     *
     * 查询一行
     * @$sql string 预处理sql
     * @$params  array()  关联数组，或索引树组，
     * */
    public function getRow( $sql,$params=[] ){

       $st=$this->prepare( $sql );

        if($st->execute( $params) ){

            return $st->fetch(\PDO::FETCH_ASSOC);

        }else{

            list(,$errno,$errstr)=$st->errorInfo();

            throw new \Exception($errstr,$errno);

        }
    }

    /*
     * 查询多行
     * @$sql string 预处理sql
     * @$params  array()  关联数组，或索引树组，
     * */
    public function getAll( $sql,$params=[] ){

        $st=$this->prepare( $sql );

        if($st->execute( $params) ){

            return $st->fetchAll(\PDO::FETCH_ASSOC);

        }else{

            list(,$errno,$errstr)=$st->errorInfo();

            throw new \Exception($errstr,$errno);

        }
    }
    /*
     *
     * 删除数据
     * @$sql string 预处理sql
     * @$params  array()  关联数组，或索引树组，
     * */
    public function delete( $sql,$params=[] ){
        $st=$this->prepare( $sql );
        if($st->execute( $params ) ){

            return $st->rowCount();

        }else{
            list(,$errno,$errstr) = $st->errorInfo();

            throw new \Exception( $errstr,$errno );

        }
    }
    /*
     *
     * 增加数据
     * @$sql string 预处理sql
     * @$params  array()  关联数组，或索引树组，
     * */
    public function insert( $sql,$params=[] ){

        $st=$this->prepare( $sql );
        if( $st->execute( $params ) ){

           return $this->lastInsertId();

        }else{
            list(,$errno,$errstr) = $st->errorInfo();

            throw new \Exception($errstr,$errno);

        }
    }
    /*
     *
     * 修改数据
     * @$sql string 预处理sql
     * @$params  array()  关联数组，或索引树组，
     * */
    public function update( $sql,$params=[] ){

        $st=$this->prepare( $sql );

        if($st->execute( $params )){

            return $st->rowCount();

        }else{

            list( ,$errno,$errstr ) = $st->errorInfo();

            throw new \Exception($errstr,$errno);

        }
    }
}


?>