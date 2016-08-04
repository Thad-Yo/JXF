<?php
namespace Home\Controller;
use Think\Controller;
use Home\Model\IndexModel;
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
	 			//回复用户消息内容
	 	 		 $Content = '我的姐姐胖小音';
	 	 		 $indexModel = new IndexModel();
	 	 		 $indexModel -> responseSubscribe($postObj,$Content);

	 		}
	 	}
	 	//用户发送tuwen1关键字的时候，回复一个单图文
	 	if(strtolower($postObj->MsgType)=='text' && trim($postObj->Content) =='hupu'|| trim($postObj->Content) =='虎扑'){	
	 		 $arr = array(
	 	 			 array(
	 	 			'title'=>'“慕思家具，健康睡眠资源整合者',
	 	 			'Description'=>'慕思家具',
	 	 			'PicUrl'=>'http://image2.cnpp.cn/upload/images/20160616/18062743074_390x250.jpg',
	 	 			'Url'=>'http://www.baidu.com',
	 	 			 ),
	 	 		// 	array(
	 	 		// 	'title'=>'百度',
	 	 		// 	'Description'=>'baidu',
	 	 		// 	'PicUrl'=>'http://i1.hoopchina.com.cn/blogfile/201607/18/BbsImg146880770318550_1200x900.jpg',
	 	 		// 	'Url'=>'http://www.baidu.com/',
	 	 		// 	),
	 	 		// 	array(
	 	 		// 	'title'=>'新浪',
	 	 		// 	'Description'=>'sina',
	 	 		// 	'PicUrl'=>'http://i1.hoopchina.com.cn/blogfile/201607/18/BbsImg146880770318550_1200x900.jpg',
	 	 		// 	'Url'=>'http://www.sina.com/',
	 	 		// 	),
	 	 		 );		
	 			$indexModel = new IndexModel();
	 			$indexModel -> responseNews($postObj,$arr);
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
	 			$indexModel  = new IndexModel();
	 			$indexModel -> responseText($postObj,$Content);
	 	}		
	 }
	 public function demo(){
	 	$demo = new IndexModel();
	 	$obj = 'fuck';
	 	$demo -> demo($obj);

	 }
}