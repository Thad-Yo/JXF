<<?php 
	/**
	* 
	*/
	class indexModel extends Model
	{
		
		public function responseMsg($postObj,$arr)
		{
			 $toUser = $postObj->FromUserName;
			 $FromUser = $postObj->ToUserName;
			 $time = time();			

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
			 	echo $info;# code...
		}
	}
 ?>