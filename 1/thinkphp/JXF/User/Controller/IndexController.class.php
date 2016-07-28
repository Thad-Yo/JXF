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
		if(strtolower($postObj->MsgType)=='text' && trim($postObj->Content) =='hupu'|| trim($postObj->Content) =='慕思'){			
				$indexModel = new indexModel;
				$indexModel->responseMsg($postObj);
		}
			else{
			switch ( trim($postObj->Content) ) {
				case '电话':
					$Content = '18578665217';
					break;
				case 'QQ':
					$Content = '736602265';
					break;				
				case 'hupu':
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
	function http_curl(){
		//获取immc
		//1、初始化curl
		$ch = curl_init();
		$url = 'www.baidu.com';
		//2、设置curl的参数
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		//3、采集
		$output = curl_exec($ch);	
		//4、关闭
		curl_close($ch);
		var_dump($output);
	}
	function getWxAccess(){
		//1、请求地址
		$appid = 'wx293f586c56cb5548';
		$appsecret = '9a2d623f4037c0b68f93ff26f5fb57c7';
		$url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=".$appid."&secret=".$appsecret;
		//2、初始化
		$ch = curl_init();
		//3、设置参数
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		//4、调用借口
		$res = curl_exec($ch);
		//5.关闭
		curl_close($ch);
		if(curl_errno($ch)){
			var_dump(curl_error($ch));
		}
		$arr = json_decode($res,true);
		var_dump($arr);
	}
	function wxServerIp(){
		$accessToken = "NJe7Dn7nU8H-QbddfR70MhQcEc2D1XS-0epCpCQ5Be9S3iA10UCUMUwV0skmH7Q0FtoJDRH0cw-A3UdINm31vJR-oIRblWasUjZ-QafOdqkKAXiABAPFC";
		$url = "https://api.weixin.qq.com/cgi-bin/getcallbackip?access_token=".$accessToken;
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		$res = curl_exec($ch);
		curl_close($ch);
		if(curl_errno($ch)){
			var_dump(curl_error($ch));
		}
		$arr = json_decode($res,true);
		echo "<pre>";
		var_dump($arr);
	}
}