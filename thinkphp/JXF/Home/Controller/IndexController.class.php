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
	 		// switch ( trim($postObj->Content) ) {
	 		// 	case '电话':
	 		// 		$Content = '18578665217';
	 		// 		break;
	 		// 	case 'QQ':
	 		// 		$Content = '736602265';
	 		// 		break;				
	 		// 	case '哈哈':
	 		// 		$Content = "<a href='http://nba.hupu.com/'>虎扑</a>";
	 		// 		break;
	 		// 	default:
	 		// 		$Content = '这位朋友你在讲啥子？';
	 		// 		break;
	 		// }
	 			$ch = curl_init();
    			$url = 'http://apis.baidu.com/apistore/weatherservice/citylist?cityname=%E6%9C%9D%E9%98%B3';
    			$header = array(
    			    'apikey: 8b6865fc4d7d39062b46dc74858d8537',
    			);
    			// 添加apikey到header
    			curl_setopt($ch, CURLOPT_HTTPHEADER  , $header);
    			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    			// 执行HTTP请求
    			curl_setopt($ch , CURLOPT_URL , $url);
    			$res = curl_exec($ch);

    			$arr = json_decode($res,true);
    			$Content = $arr['retData']['area_id'];
    			// JSON返回示例 :
							// {
							//     errNum: 0,
							//     errMsg: "success",
							//     retData: [
							//         {
							//             province_cn: "北京",  //省
							//             district_cn: "北京",  //市
							//             name_cn: "朝阳",    //区、县 
							//             name_en: "chaoyang",  //城市拼音
							//             area_id: "101010300"  //城市代码
							//         },
							//         {
							//             province_cn: "辽宁",
							//             district_cn: "朝阳",
							//             name_cn: "朝阳",
							//             name_en: "chaoyang",
							//             area_id: "101071201"
							//         },
							//         {
							//             province_cn: "辽宁",
							//             district_cn: "朝阳",
							//             name_cn: "凌源",
							//             name_en: "lingyuan",
							//             area_id: "101071203"
							//         },
							//         {
							//             province_cn: "辽宁",
							//             district_cn: "朝阳",
							//             name_cn: "喀左",
							//             name_en: "kazuo",
							//             area_id: "101071204"
							//         },
							//         {
							//             province_cn: "辽宁",
							//             district_cn: "朝阳",
							//             name_cn: "北票",
							//             name_en: "beipiao",
							//             area_id: "101071205"
							//         },
							//         {
							//             province_cn: "辽宁",
							//             district_cn: "朝阳",
							//             name_cn: "建平县",
							//             name_en: "jianpingxian",
							//             area_id: "101071207"
							//         }
							//     ]
							// }

	 			$indexModel  = new IndexModel();
	 			$indexModel -> responseText($postObj,$Content);
	 	}		
	 }
}