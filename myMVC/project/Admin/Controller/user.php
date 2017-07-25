<?php
/**
 * Created by PhpStorm.
 * User: MR.L
 * Date: 2017/1/26
 * Time: 14:24
 */
use \TP\Base\Controller;
class user extends Controller{

    public function reg(){
        $title='今天天气不错';
        $content='按时打卡刷卡单男单卡死了的那是夸你打算考两年多来哪里开始那么大拉手的拉升了';
        $this->assign('title',$title);
        $this->assign('content',$content);
        $this->display('reg');
        $a=new userModel();
        //var_dump ($a->add(['username'=>'张三','email'=>1121212]));
        //echo $a->save(['user_id'=>2,'username'=>'李四','email'=>1121212]),'<br/>';
        //$a->username='二百五';
       /// $a->email='1111111111';
        //echo $a->add();
        $a->find(2);
        $a->username="255";
        $arr=$a->field('user_id,username,email')->where('user_id>3')->group('user_id')->order('user_id','desc')->limit(3)->select();
        print_r($arr);
    }
    public function login(){
        echo '登录';
    }
    public function show(){
        print_r($_GET);
        echo 'aaa';
    }
    public function up(){
        if(empty($_POST)&& empty($_FILE)){
            $this->display('up');
        }else{
            $upload=new \X\Tool\Upload();
           //print_r($upload->up('file'));
            var_dump(\X\Tool\Vcode::check(trim($_POST['vcode'])));
        }
    }
    public function test(){
        $page=new \X\Tool\Page(3450);
        $page->cnt=10;

        $curr=$page->curr;
        $arr= $page->show();

       // print_r($arr);
        $this->assign('arr',$arr);
        $this->assign('curr',$curr);
        $this->display('test');
    }
    public function vcode(){
        $vcode=new \X\Tool\Vcode();
        $vcode->ccode();
    }
}

?>