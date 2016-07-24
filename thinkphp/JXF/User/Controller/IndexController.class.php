<?php
namespace User\Controller;
use Think\Controller;
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
        //拼接成字符串，然后雨signature进行校验
        $str = sha1(implode($array));
        if($str == $signature && $echostr){
        	echo $echostr;
        	exit;
        }else{
        	$this->responseMsg();
        }
    }
    //接受事件推送并回复
    public function responseMsg(){
    	//1.获取到微信推送过来的post数据（XML格式）
    	$postArr = $GLOBALS['HTTP_RAW_POST_DATA'];
    	$temstr = $postArr;
    	//2.处理消息类别，并设置回复类型和内容
  		// <xml>
		// <ToUserName><![CDATA[toUser]]></ToUserName>
		// <FromUserName><![CDATA[FromUser]]></FromUserName>
		// <CreateTime>123456789</CreateTime>
		// <MsgType><![CDATA[event]]></MsgType>
		// <Event><![CDATA[subscribe]]></Event>
		// </xml>
		$postObj = simplexml_load_string($postArr);
		//$postObj->ToUserName = '';
		//$postObj->FromUserName = '';
		//$postObj->CreateTime = '';
		//$postObj->MsgType = '';
		//$postObj->Event = '';
		//判断该数据包是否是订阅的事件推送
		if(strtolower($postObj->MsgType)=='event'){
			//如果是关注subscribe事件
			if(strtolower($postObj->Event) == 'subscribe'){
				//回复用户消息
				$toUser = $postObj->FromUserName;
				$FromUser = $postObj->ToUserName;
				$time = time();
				$MsgType = 'text';
				$Content = '我的姐姐胖小音';
				$template = '<xml>
							<ToUserName><![CDATA[%s]]></ToUserName>
							<FromUserName><![CDATA[%s]]></FromUserName>
							<CreateTime>%s</CreateTime>
							<MsgType><![CDATA[%s]]></MsgType>
							<Content><![CDATA[%s]]></Content>
							</xml>';
				$info = sprintf($template,$toUser,$FromUser,$time,$MsgType,$Content);
				echo $info;
			}
		}
		if(strtolower($postObj->MsgType)=='text'){
			if($postObj->Content=='小音'){
				$template = '<xml>
							<ToUserName><![CDATA[%s]]></ToUserName>
							<FromUserName><![CDATA[%s]]></FromUserName>
							<CreateTime>%s</CreateTime>
							<MsgType><![CDATA[%s]]></MsgType>
							<Content><![CDATA[%s]]></Content>
							</xml>';
				$FromUser = $postObj->$ToUserName;
				$toUser = $postObj->$FromUserName;
				$time = time();
				$Content = '小音是个好姐姐';
				$MsgType = 'text';
				echo sprintf($template,$toUser,$FromUser,$time,$MsgType,$Content);
			}
		}
    }
}