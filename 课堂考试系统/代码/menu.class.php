<html>
<body>
<head>

<meta http-equiv="refresh" content="60*60*2"> 
</head>



<?php

//定时刷新页面重新获取 ACCESS_TOKEN  两个小时失效
header("Content-type: text/html; charset=utf-8");//
//define("ACCESS_TOKEN", "AWw3TTAtQBo9DQQ5Jd5l0bLwOfk6hqf11v8NL-QX0fFeQgKK3Qg8BUYPInkb9CXYqKfQlhHBgs_06N8LU25sTaCLaFSP6bT5ZCNRWILMRERpN2yOF-V0gmKQThoe4NqyOXShAAABKF");
define("APPID","wx2cc4fff37a6ca649");
define("APPSECRET","42eb8651422aad17c3659db9c00f7e6a");
//$access_token="";
//动态获取ACCESS_TOKEN
class Menu{
	//todo......
	///菜单不刷新
	
function getAccessToken(){
	$url="https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=".APPID."&secret=".APPSECRET;

	$ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE); 
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE); 
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $output = curl_exec($ch);
    curl_close($ch);
    $jsoninfo = json_decode($output, true);
    return $jsoninfo["access_token"];
}
//创建菜单
function createMenu($flag==false){
$token=$this->getAccessToken();
echo("access_token:".$token);
$ch = curl_init();
$menuStyle=$this->getMenuStyle($flag);
//global $access_token;
curl_setopt($ch, CURLOPT_URL, "https://api.weixin.qq.com/cgi-bin/menu/create?access_token=".$token);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible; MSIE 5.01; Windows NT 5.0)');
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($ch, CURLOPT_AUTOREFERER, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $menuStyle);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$tmpInfo = curl_exec($ch);
if (curl_errno($ch)) {

  return curl_error($ch);
}

curl_close($ch);
return $tmpInfo;

}

//根据是否注册的情况来获取不同的menu样式

//todo  .....
	function getMenuStyle($flag){
		//为注册菜单
		$data1 = '{
     "button":[
     {	
          "type":"view",
          "name":"课堂测试",
          "url":"http://202.119.206.221/WeChat/bind.html"
      }
	  ]}';
	  //已注册菜单
	  $data2=' '{
     "button":[
     {	
          "type":"view",
          "name":"更新菜单",
          "url":"http://202.119.206.221/WeChat/bind.html"
      }
	  ]}';';

		switch($flag){
			case true:
				return $data1;
			case false:
				return $data2;
			default:
				return $data1;
		}
		
	}

}

//获取菜单
// function getMenu(){
	// global $access_token;
// return file_get_contents("https://api.weixin.qq.com/cgi-bin/menu/get?access_token=".ACCESS_TOKEN);
// }

//删除菜单
// function deleteMenu(){
	// global $access_token;
// return file_get_contents("https://api.weixin.qq.com/cgi-bin/menu/delete?access_token=".ACCESS_TOKEN);
// }





//menu如何查询注册信息更改样式？没有openid



//echo createMenu($data);
?>

</body>
</html>

