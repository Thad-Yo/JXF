<?php
namespace Home\Model; 
class IndexModel {
	public function responseNews($postObj,$arr){
			 $toUser = $postObj->FromUserName;
	 	 	 $FromUser = $postObj->ToUserName;
	 	 	 $time = time();			
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
	 	 		echo $info;
	}
}

 ?>