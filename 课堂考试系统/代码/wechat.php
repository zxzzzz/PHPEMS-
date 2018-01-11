<html>
<body>
<?php  
/** 
  * wechat php test 
  */  
  
//define your token  
define("TOKEN", "wechat");  
$wechatObj = new wechatCallbackapiTest();  
$wechatObj->responseMsg();  
class wechatCallbackapiTest  
{  
    public function valid()  
    {  
        $echoStr = $_GET["echostr"];  
  
        //valid signature , option  
        if($this->checkSignature()){  
            echo $echoStr;  
            exit;  
        }  
    }  
	/*向微信服务器发送文本信息
	$object: 接收的XML数据
	$发送的内容
	*/
	function sendText($object,$text){
		$fromUserName= $object->FromUserName; //发送方 
		$toUserName= $object->ToUserName;  //接受方
		$time = time();
		$msgType='text';//必须字段
						//要发送的XML文本格式
		$textTpl ="<xml>
						<ToUserName><![CDATA[%s]]></ToUserName>
						<FromUserName><![CDATA[%s]]></FromUserName>
						<CreateTime>%s</CreateTime>
						<MsgType><![CDATA[%s]]></MsgType>
						<Content><![CDATA[%s]]></Content>
					</xml>"; 
		$t=sprintf($textTpl,$fromUserName,$toUserName,$time,$msgType,$text);
		echo $t;
	}
	//处理普通文本信息
	function receiverText($object){
		// $test="hello";
		// $this->sendText($object,$test);
		$content=trim($object->Content);
		$pattern="/^[0-1]{1}[0-9]{7}$/";
			//正则表达式匹配学号
		if(preg_match($pattern,$content))
		{
			include "databaseOperate.class.php";
			$openid=trim($object->FromUserName);
			$db=new DBManager();
			//写入绑定表
			if($db->insertInitFlag($openid,$content)){
				$test='请点击右下方完成账号注册!';
				$this->sendText($object,$test);
			}
		}
			
	}
		
		
	
	
	//如果是绑定事件菜单点击事件
	function receiverEvent($object){
				switch($object->Event){
					case 'subscribe':
						$sendText='欢迎关注,请输入您的学号：';
						$this->sendText($object,$sendText);
						break;
				}
				

	}
		/*
		关注时 弹出消息  提示学生绑定 学生回复学号
		*/
		function responseMsg()  
    {  
        //get post data, May be due to the different environments  
			$postStr = $GLOBALS["HTTP_RAW_POST_DATA"];  
			$postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);  
				if(!empty($postObj)){
				 //判断消息类型
				$type=trim($postObj->MsgType);
				//根据消息类型的不同 采取不同的处理方式
				switch($type){
					case 'event':
					//接受事件推送并处理
						$this->receiverEvent($postObj);
						break;
					case 'text':
					//接收普通文本并处理
						$this->receiverText($postObj);
						break;
					
				}
				
	}
}

    
          
     function checkSignature()  
    {  
        $signature = $_GET["signature"];  
        $timestamp = $_GET["timestamp"];  
        $nonce = $_GET["nonce"];      
                  
        $token = TOKEN;  
        $tmpArr = array($token, $timestamp, $nonce);  
        sort($tmpArr);  
        $tmpStr = implode( $tmpArr );  
        $tmpStr = sha1( $tmpStr );  
          
        if( $tmpStr == $signature ){  
            return true;  
        }else{  
            return false;  
        }  
    }
		/*初始化数据库
		如果没有创建数据库及对应的表，就创建
		*/
		
	
}

	 
?>
</body>
</html>