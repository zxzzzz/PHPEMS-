<?php
header("Content-type: text/html; charset=utf-8");
//数据库管理类

class DBManager{

//插入openid
	public function insertInitFlag($openid,$userid,$flag){
		$link=$this->connectDataBase();
		mysql_query('set names utf8',$link);
		mysql_select_db('Student',$link);
		
		$queryId="select * from IsBind where OpenId='$openid'";
	//如果openid不存在  将openid与flag=0插入绑定表中
		if(mysql_query($queryId)){
			$result=mysql_query($queryId);
			$id=mysql_fetch_array($result);
			//如果openid不存在 返回1
			print_r($id);
		if((count($id)<2))
		{
			//将还未绑定的openid与对应的学号信息写入
                    $insertOpenId="insert into IsBind values('$openid','$userid','$flag')";
					if(mysql_query($insertOpenId)){
						echo "success to insert openid";
					}else                                       {
						echo "fail to insert openid".mysql_error();
						mysql_close();
						return false;
					}
			}else{
				echo 'field is exists';
			}
		}else{
			echo '查询失败'.mysql_error();
			mysql_close();
			return false;
		}
		mysql_close();
		return true;
	}
	
	//学生注册时
	//更新openid是否绑定字段为1
	public function updateOpenidFlag($id){
		$con=$this->connectDataBase();
		//更新操作
		mysql_query('set names utf8',$con);
		mysql_select_db('Student',$con);
		$update="update  IsBind set Flag='1' where UserId='$id'";
		if(mysql_query($update)){
			echo "success to update flag to 1 <br>";
		}else{
			echo 'update error '.mysql_error();
			mysql_close();
			return false;
		}
		mysql_close();
		return true;
	}
	
	
	//更换下一批学生时，将这一批学生信息删除
	public function deleteAllInfo(){
		
	}
	
	 function connectDataBase(){
		//连接数据库
		$con = mysql_connect('localhost','root','novolion2016');
		if (!$con)
		{
			
			die('Could not connect: ' . mysql_error());
		}
		else{
			// mysql_select_db('Student',$con);
			// mysql_query("set names 'utf8'");
			 echo" success connect to database!<br>";
		}
		
		return $con;
		
	}
	//查询学生是否注册
	public function isBind($id){
		$link=$this->connectDataBase();
		mysql_select_db('Student',$link);
		$selectIsBind="select Flag from IsBind where UserId='$id'";
		$flag=mysql_query($selectIsBind);
		$result=mysql_fetch_array($flag);
		echo 'flgs:'.$result['Flag'];
		if($flag=='0')
			return false;
		else
			return true;
	}
	
/*插入学生信息
姓名 学号 班级 手机号
*/
	public function insertUserInfo($id,$name,$class,$phone){
		$link=$this->connectDataBase();
		mysql_query('set names utf8',$link);
		mysql_select_db('Student',$link);
		$queryId="select * from StuInfo where id='$id'";
	//如果openid不存在  将openid与flag=0插入绑定表中
		if(mysql_query($queryId)){
			$result=mysql_query($queryId);
			$i=mysql_fetch_array($result);
			//如果openid不存在 返回1
			//echo 'count'.count($i);
			print_r($i);
		if((count($i)<2))
		{
			//将还未绑定的id与对应的学号信息写入
                    $insertId="insert into StuInfo values('$id','$name','$class','$phone')";
					if(mysql_query($insertId)){
						echo "success to insert id";
					}else                                       {
						echo "fail to insert id".mysql_error();
						mysql_close();
						return false;
					}
			}else{
				echo "field is exists <br>";
				return 1;
			}
		}else{
			echo '查询失败'.mysql_error();
			return false;
		}
		mysql_close();
		return true;
		
	}

	
	//初始化数据库
	public function  init(){
		$con=$this->connectDataBase();
		mysql_query('set names utf8',$con);
		//查看数据库是否已存在
		$db=mysql_select_db('Student',$con);
		
		if(!$db){
			echo("student database is not exist!");
			//创建 "Student"数据库
			
		if (mysql_query("CREATE DATABASE Student",$con))
		{
			echo "Database created";
		}
		else
		{
			echo "Error creating database: " . mysql_error();
			mysql_close();
			return false;
		}
		}
		else{
		echo "student database is exist!";
		}
//创建学生个人信息表
		mysql_select_db("Student",$con);		
		$sqlcontent="create table  if not exists StuInfo (id varchar(8),name varchar(10),class varchar(20),phone varchar(11),PRIMARY KEY (id))";
			if(mysql_query($sqlcontent,$con)){
				echo"stuinfo is created!";
			}else{
				echo"stuinfo is failed to create".mysql_error();
				return false;
			}
//创建是否绑定帐号表
//Create table in my_db database
//定义学号为外键的话如何插入？
		$sql = "create table if not exists IsBind (OpenId varchar(40),UserId varchar(8), Flag varchar(1),PRIMARY KEY (OpenId))";
		if(mysql_query($sql,$con)){
			echo "isbind is created!";
		}else{
			echo "isbind is failed to create!".mysql_error();
			mysql_close();
			return false;
		}
		mysql_close($con);  
		return true;
	
	}
}

// $name="李白";
// $id='9948734';
// $class='计算机10-3';
// $phone='12345678965';
// $openid='11hgjkjmankdsjnwalk';
// init();
// insertInitFlag($openid,$id,'0');
// insertUserInfo($id,$name,$class,$phone);
// $f=connectDataBase();
// if(mysql_query('drop database Student',$f)){
	// echo 'success';
// }
// updateOpenidFlag($id);
// $sele="select * from IsBind where UserId='$id'";
// $in=mysql_query($sele);
// $r=mysql_fetch_array($in);
// print_r($r);
// $db=new DBManager();
// $l=$db->connectDataBase();
// mysql_query("Student",$l);
// $temp1=mysql_query("select * from StuInfo ",$l);
// $temp2=mysql_fetch_array($temp1);
// echo $temp2['name'];
// $userid='08143373';
// $db->isBind($userid);

?>