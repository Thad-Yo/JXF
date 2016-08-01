<?php 
	class IndexModel{
		public function responseMsg($postObj){
			 $toUser = $postObj->FromUserName;
			 $FromUser = $postObj->ToUserName;
			 $time = time();			
			 $arr = array(
					 array(
					'title'=>'“慕思家具，健康睡眠资源整合者',
					'Description'=>'慕思家具',
					'PicUrl'=>'http://image2.cnpp.cn/upload/images/20160616/18062743074_390x250.jpg',
					'Url'=>'http://www.maigoo.com/webshop/262224.html',
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
	}