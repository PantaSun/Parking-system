<?php
	/*
  	 * logout1.php ---- 当点击车主注册时的间跳转界面  *用来清除cookie和登录信息，并跳转到注册界面
  	 */
	session_start();
	//定义一个常量，来获取调用includes中文件的权限
	define("IN_TG", true);
	require dirname(__FILE__).'/includes/common.inc.php';
	_unsetcookies("car_ower_register.php");
?>