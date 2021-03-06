<?php
/**
 * Created by PhpStorm.
 * User: MR.L
 * Date: 2017/1/30
 * Time: 15:52
 */

namespace TP\Tool;


class Vcode
{
    public   $width  =  '80';//画布初始化宽度
    public   $height =  '30';
    public   $sx     =   20;//英文验证码左上角x坐标
    public   $sy     =   5;//英文验证码左上角y坐标
    public   $cx     =   5;//中文验证码左下角x坐标
    public   $cy     =   20;//中文验证码左下角y坐标
    protected $im    =   null;//临时存储画布
    protected $img   =   null;//输出画布
    public $fontSize =   12;//中文验证码的字体大小
    public   $msi    =   TPPATH.'Tool/msyhbd.ttc';//字体文件的存储路径
    public  $offset  = 2;//定义扭曲度
    public  $week   = 3;//定义偏移度

    protected $posy;
    //存储汉字
    protected $arr=array('无','题','李','商','隐','相','见','时','难','别','亦','难','东','风','无','力','百','花',
        '残' ,'春' ,'蚕', '到' ,'死' ,'丝', '方', '尽' ,'蜡', '炬', '成', '灰','泪' ,'始', '干');
    /*
     * 调用base
     * */
    public function __construct(){
        //session_destroy();
        //开始session
        session_start();

        $this->base();

        $this->fill();

        $this->line();

    }

    /*
     *
     * 造画布
     * */
    protected function base(){
        $this->im=imagecreatetruecolor( $this->width,$this->height );
        $this->img=imagecreatetruecolor( $this->width,$this->height );
    }


    /*
     * 生成简单验证码
     * */
    public function scode( $len=4 ){

        $str='abcdefghijkmnpqrstuvwyz3456789ABCDEFGHJKLMNOPQRSTUVWXYZ';

        $code=substr( str_shuffle($str),0,$len );
        //设置验证码到session
        $_SESSION['vcode']=strtolower( $code );

        $color=imagecolorallocate( $this->im,mt_rand(0,150),mt_rand(0,100),mt_rand(0,100) );

        imagestring( $this->im,5,$this->sx,$this->sy,$code,$color );

         $this->setposy();//设置执行便偏移度，并复制图片到$this->img

         $this->showImg();//输出验证码
    }

//输出验证码
    public function showImg(){

        header( 'content-type: image/png' );

        imagepng( $this->img );

        imagedestroy( $this->im );

        imagedestroy( $this->img );
    }

    /*
     *
     * 生成中文验证码
     * */
    public function ccode( $len=4 ){

        shuffle($this->arr);

        $text=implode("", array_slice($this->arr,0,$len));

        //造随机字体颜色
        $_SESSION['vcode']=$text;

        $color = imagecolorallocate($this->im, mt_rand(0, 125), mt_rand(0, 125), mt_rand(0, 125)) ;

        //在画布上写字

        imagettftext( $this->im,$this->fontSize,0,$this->cx,$this->cy,$color,$this->msi,$text);


        $this->setposy();//设置执行便偏移度，并复制图片到img


        $this->showImg();//输出验证码
    }

    /*

    设置posy并复制图片到img

    */
    public function setposy(){
        for( $i=0;$i<=$this->width;$i++ ){

             $this->posy=round( sin(2*$this->week*$i*M_PI/100)*$this->offset );

             imagecopy($this->img,$this->im,$i,$this->posy,$i,0,1,$this->height);

        }
       
    }

    /*
     *
     * 判断验证码是否正确
     * */
    public static function check($value){

        //session_start();

        $bool=$_SESSION['vcode']  ===  $value;

        session_destroy();

        return $bool;
    }
    /*
     *
     * 填充底色
     * */
    public function fill(){

        $bg=imagecolorallocate( $this->im,mt_rand(150,250),mt_rand(150,250),mt_rand(150,250) );

        imagefill( $this->im,0,0,$bg );

        imagefill( $this->img,0,0,$bg );
    }
    /*
     *
     * 生成干扰线
     * */
    public function line(){

            //imageline($image, mt_rand(0, 50), mt_rand(0, 25), mt_rand(0, 50), mt_rand(0, 25), $color1) ;

        $color=imagecolorallocate( $this->im,mt_rand(0,150),mt_rand(0,100),mt_rand(0,100) );

        imageline( $this->im,0,mt_rand(0,$this->height),$this->width,mt_rand(0,$this->height),$color );

        imageline( $this->im,0,mt_rand(0,$this->height),$this->width,0,$color );

        imageline( $this->im,mt_rand(0,$this->height-10),mt_rand(0,$this->height),$this->width,mt_rand(0,$this->height),$color );

        imageline( $this->im,0,mt_rand(0,$this->height-10),$this->width,0,$color );

        imageline( $this->im,0,0,mt_rand($this->height,$this->width),$this->height,$color );
   }


    

}