<?php


$name= $id=$uclass=$uphone="";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	$name = test_input($_POST["username"]);
	$id = test_input($_POST["userid"]);
	$uclass =test_input($_POST["userclass"]);
	$uphone=test_input($_POST["private_phone"]);
echo $name.$id.$uclass.$uphone."<br>";
}
if(!empty($name)){
	include "databaseOperate.class.php";
	$dbManager=new DBManager();
	//$dbManager->init();
	//ѧ����Ϣ����
	if($dbManager->insertUserInfo($id ,$name,$uclass,$uphone)==1){
		echo "���Ѿ�ע����ˣ�<br>";
	}else{
	//�󶨱����
		if($dbManager->updateOpenidFlag($id)){
			echo "success to insert student info  <br>";
			$bind=$dbManager->isBind($id);
			//ˢ�²˵�
			include "menu.class.php";
			$menu=new Menu();
			$menu->createMenu($bind);
	}	else{
			echo "fail to insert student info  <br>";
	}
	}
	
	
}
function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

?>
