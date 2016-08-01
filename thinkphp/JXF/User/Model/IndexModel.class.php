<?php
namespace User\Model;
use Think\Model;
class IndexModel extends Model{
		public function responseMsg($postObj){
			 $toUser = $postObj->FromUserName;
			 $FromUser = $postObj->ToUserName;
			 $time = time();			
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
		    $template =  "<xml>
			 			  <ToUserName><![CDATA[%s]]></ToUserName>
			 			  <FromUserName><![CDATA[%s]]></FromUserName>
			 			  <CreateTime>%s</CreateTime>
			 			  <MsgType><![CDATA[%s]]></MsgType>
			 			  <ArticleCount>".count($arr)."</ArticleCount>
			 			  <Articles>";
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
		public function responseText($postObj,$Content){
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
				echo "";

		}
		public function responseSubscribe($postObj,$Content){
							//回复用户消息
				// $toUser = $postObj->FromUserName;
				// $FromUser = $postObj->ToUserName;
				// $time = time();
				// $MsgType = 'text';
				// $Content = '我的姐姐胖小音';
				// $template = '<xml>
				// 			<ToUserName><![CDATA[%s]]></ToUserName>
				// 			<FromUserName><![CDATA[%s]]></FromUserName>
				// 			<CreateTime>%s</CreateTime>
				// 			<MsgType><![CDATA[%s]]></MsgType>
				// 			<Content><![CDATA[%s]]></Content>
				// 			</xml>';
				// $info = sprintf($template,$toUser,$FromUser,$time,$MsgType,$Content);
				// echo $info;
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
				 $this->responseMsg($postObj);

		}
	}
