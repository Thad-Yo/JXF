<?php 
	/**
	* 
	*/
	class indexModel extends Model
	{
		
		public function responseMsg($postObj)
		{
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
 ?>