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
		//用户发送tuwen1关键字的时候，回复一个单图文
		if(strtolower($postObj->MsgType)=='text' && trim($postObj->Content) =='tuwen1'){			
			 $toUser = $postObj->FromUserName;
			 $FromUser = $postObj->ToUserName;
			 $time = time();
			 $template =  '<xml>
			 			  <ToUserName><![CDATA[%s]]></ToUserName>
			 			  <FromUserName><![CDATA[%s]]></FromUserName>
			 			  <CreateTime>%s</CreateTime>
			 			  <MsgType><![CDATA[%s]]></MsgType>
			 			  <ArticleCount>".count($arr)."</ArticleCount>
			 			  <Articles>';
			
			 $arr = array(
					array(
					'title'=>'hupu',
					'Description'=>'hupu is very yellow',
					'PicUrl'=>'http://i1.hoopchina.com.cn/blogfile/201607/18/BbsImg146880770318550_1200x900.jpg',
					'Url'=>'http://www.hupu.com/',
					),
				);
			foreach ($arr as $k => $v) {
			$template .= "<item>
						  <Title><![CDATA[".$v['title']."]]></Title> 
						  <Description><![CDATA[".$v['Description']."]]></Description>
						  <PicUrl><![CDATA[".$v['PicUrl']."]]></PicUrl>
						  <Url><![CDATA[".$v['Url']."]]></Url>
						  </item>";
			}
			$template .= '</Articles>
						  </xml>';
			$info = sprintf($template,$toUser,$FromUser,$time,'news');
			 	echo $info;
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
}