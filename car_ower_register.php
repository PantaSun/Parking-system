<?php
		
		/**
		 * car_ower_register.php ---- 车主注册界面
		 */
		//防止恶意调用
		define("IN_TG", true);
		//设置编码问题
		header('Content-Type: text/html;charset=utf-8');
		//转换成硬路径，速度更快
		require dirname(__FILE__).'/includes/common.inc.php';
		//定义一个常量，来指定本页内容
		define('SCRIPT','car_ower_register');
		session_start();
		if (@$_GET['action'] == 'register'){
			//防止恶意注册和伪造表单跨站攻击
			_check_code($_POST['code'], $_SESSION['code']);
			//引入函数文件
			include ROOT_PATH.'includes/register.func.php';
			//创建一个空数组来接收合法数据
			$_clean = array();
			//可以通过唯一标识符来防止恶意注册，伪装表单跨站攻击等等
			//这个存放如数据库的唯一标识符还可以用来，登录cookies验证
			$_clean['uniqid'] = _check_uniqid($_SESSION['uniqid'], $_POST['uniqid']);
 			$_clean['username']=_check_username( $_POST['username'],2,20);
 			$_clean['password']= _check_password($_POST['password'] , $_POST['notpassword'], 6);
			$_clean['sex'] = _check_sex($_POST['sex']);
			$_clean['phone'] = _check_phone($_POST['phone']);
			echo strlen($_POST['platenumber']);
			$_clean['platenumber'] = _check_platenumber($_POST['platenumber']);
			//在新增之前，判断用户名是否被注册
			$_sql="SELECT psu_username FROM ps_user WHERE psu_username='{$_clean['username']}' LIMIT 1";
			_is_repeat($_sql, '对不起，此用户名已被注册！');

			//新增用户
			_query(
					"INSERT INTO ps_user(
																psu_uniqid,
																psu_username,
																psu_password,
																psu_sex,
																psu_phone,
																psu_platenumber,
																psu_reg_time
																)
												VALUES(
																'{$_clean['uniqid']}',
																'{$_clean['username']}',
																'{$_clean['password']}',
																'{$_clean['sex']}',
																'{$_clean['phone']}',
																'{$_clean['platenumber']}',
																NOW()
				 												)"
							);
			if (_affected_rows() == 1){
			//关闭
			_close();
			//跳转
			_location('恭喜你！注册成功！请登录！', 'car_ower_login.php');
			}else {
				//关闭
				_close();
				//跳转
				_location('很遗憾！由于未知原因注册失败！', 'car_ower_register.php');
			}
		}else {
			$_SESSION['uniqid'] = $_uniqid = _sha1_uniqid();
		}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html xlmns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charst=utf-8" />
<script type="text/javascript" src="js/register.js"></script>
<link rel="stylesheet" type="text/css" href="css/register.css"/>
<link rel="stylesheet" type="text/css" href="css/header.css"/>
<link rel="stylesheet" type="text/css" href="css/basic.css"/>
<title>车主注册</title>
</head>
<body>
<div id="header">
			<ul>
				<li><a href="index.php">首页</a></li>
				<li><a href="car_ower_register.php">新用户注册</a></li>
				<li><a href="admin_login.php">管理员登录</a></li>
			</ul>
		</div >
<div id="register">
	<h2>车主注册</h2>
	<form action="car_ower_register.php?action=register"  name="register"  method="post">
			<input type="hidden" name="uniqid" value="<?php echo $_uniqid?>"/>
			<dl>
					<dt>请认真填写如下信息！(*为必填)</dt>
					<pre>
					<dd>用 户 名：<input  type="text" name="username" class="text"/> *</dd>
					<dd>密    码：<input  type="password" name="password" class="text"/> *</dd>
					<dd>确认密码：<input  type="password" name="notpassword" class="text"/> *</dd>
					<dd>性     别： <input  type="radio" name="sex" value="男" checked="checked"/> 男  <input  type="radio" name="sex" value="女" />女  *</dd>
					<dd>手 机 号： <input  type="text" name="phone" class="text"/> *</dd>
					<dd>车 牌 号： <input  type="text" name="platenumber" class="text"/> *(例如：辽F11sd1)</dd>
					<dd>验 证 码： <input  type="text" name="code" class="text code"/> *<img src="code.php" alt="验证码" id="code" onclick="javascript:"/></dd>
					<dd>            <input type="submit" value="注册" class="submit"/></dd>
					</pre>
			</dl>
	</form>
</div>
</body>
</html>
