<?php
namespace Home\Controller;
use Think\Controller;
header('content-type:text');
class IndexController extends Controller {
    public function index(){
        //1.获得参数
        $nonce = $_GET['nonce'];
        $token = 'jxf';
        $timestamp = $_GET['timestamp'];
        $echostr = $_GET['echostr'];
        $signature = $_GET['signature'];
        //形成数组，按子典排序
        $array = array();
        $array = array($nonce,$timestamp,$token);
        sort($array);
        //拼接成字符串，然后与signature进行校验
        $str = sha1(implode($array));
        if($str == $signature && $echostr){
        	echo $echostr;
        	exit;
        }else{
        	$this->responseMsg();
        }
    }
    public function demo(){
    	echo 'xixi';
    }
}