<?php
//namespace Home\Controller;
use Think\Controller;
header('content-type:text');
class IndexController extends Controller {
    public function index(){
        //1.获得参数
		//获得参数 signature nonce token timestamp echostr
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
	 	//用户发送tuwen1关键字的时候，回复一个单图文
	 	if(strtolower($postObj->MsgType)=='text' && trim($postObj->Content) =='hupu'|| trim($postObj->Content) =='虎扑'){			
	 			$indexModel = new IndexModel();
	 			$indexModel -> responseNews($postObj);
	 	}
	 		else{
	 		switch ( trim($postObj->Content) ) {
	 			case '电话':
	 				$Content = '18578665217';
	 				break;
	 			case 'QQ':
	 				$Content = '736602265';
	 				break;				
	 			case '哈哈':
	 				$Content = "<a href='http://nba.hupu.com/'>虎扑</a>";
	 				break;
	 			default:
	 				$Content = '这位朋友你在讲啥子？';
	 				break;
	 		}
	 	       $template = '<xml>
	 	 					<ToUserName><![CDATA[%s]]></ToUserName>
	 	 					<FromUserName><![CDATA[%s]]></FromUserName>
	 	 					<CreateTime>%s</CreateTime>
	 	 					<MsgType><![CDATA[%s]]></MsgType>
	 	 					<Content><![CDATA[%s]]></Content>
	 	 					</xml>';
	 	 		$FromUser = $postObj->ToUserName;
	 	 		$toUser = $postObj->FromUserName;
	 	 		$time = time();
	 	 		// $Content = '18578665217';
	 	 		$MsgType = 'text';
	 	 		$info = sprintf($template,$toUser,$FromUser,$time,$MsgType,$Content);
	 	 		echo $info;
	 	}		
	 }
	 public function demo(){
	 	$demo = new IndexModel();
	 	$obj = 'xixi';
	 	$demo -> demo($obj);

	 }
}