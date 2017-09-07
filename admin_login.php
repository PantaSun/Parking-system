<?php
		
		/**
		 * admin_login.php ---- 管理员登录界面
		 */
		//设置编码问题
		header('Content-Type: text/html;charset=utf-8');
		//定义一个常量，来获取调用includes中文件的权限
		define("IN_TG", true);
		//定义一个常量，来指定本页内容
		define('SCRIPT','admin_login');
		//转换成硬路径，速度更快
		require dirname(__FILE__).'/includes/common.inc.php';
		//开启session
		session_start();
		if (isset($_COOKIE['username']) && $_COOKIE['auth'] == '1'){
			_location(null, "admin.php");
		}else {
			if (@$_GET['action'] == 'login'){
				//防止恶意注册和伪造表单跨站攻击
				_check_code($_POST['code'], $_SESSION['code']);
				//引入验证文件
				include ROOT_PATH.'includes/login.func.php';
				//接收数据
				$_clean =  array();
				$_clean['username'] = _check_username($_POST['username'], 2, 20);
				$_clean['password'] = _check_password($_POST['password'], 6);
				if (!!$_rows = _fetch_array("SELECT psu_username, psu_auth FROM ps_user WHERE psu_username='{$_clean['username']}' AND psu_password='{$_clean['password']}' LIMIT 1")){
					if ($_rows['psu_auth'] != '1'){
						_alert_back("您不是管理员，无权在此登录,可以尝试车主登录！");
					}else {
						_close();
						_session_destroy();
						_setcookies($_rows['psu_username'], $_rows['psu_auth']);
						_location(null, 'admin.php');
							}
				}else {
					_close();
					_session_destroy();
					_location('密码错误或者用户不存在！', 'admin_login.php');
				}
			}
		}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html xlmns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charst=utf-8" />

<title>管理员登录</title>
<link rel="stylesheet" type="text/css" href="css/login.css"/>
<link rel="stylesheet" type="text/css" href="css/header.css"/>
<link rel="stylesheet" type="text/css" href="css/basic.css"/>
<script type="text/javascript" src="js/login.js"></script>
</head>
<body>
		<div id="header">
		<ul>
			<li><a href="index.php">首页</a></li>
			<li><a href="car_ower_register.php">车主注册</a></li>
			<li><a href="car_ower_login.php">车主登录</a></li>
		</ul>
	</div >
		<div id="login">
		<h2>管理员登录</h2>
		<form  action="admin_login.php?action=login"  name="login"  method="post">
			<dl>
				<dd>用户名：<input type="text" name="username" class="text" /></dd>
				<dd>密&nbsp;码：<input type="password"  name="password" class="text"/></dd>
				<dd>验证码：<input type="text" name="code" class="text code"/> <img src="code.php" alt="验证码" id="code" onclick="javascript:"/></dd>
				<dd><input type="submit" value="登录" class="submit"/></dd>
			</dl>
		</form>
		</div>

</body>
</html>
