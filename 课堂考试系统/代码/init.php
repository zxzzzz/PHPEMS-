<?php
//初始化菜单样式和数据库
include "menu.class.php";
include "databaseOperate.class.php";
$initMenu=new Menu();
$inintDB=new DBManager();
$initMenu->createMenu();
$initDB->init();


?>