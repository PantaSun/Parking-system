<?php
	/*
  	* adminofheader.inc.php -- 管理员界面的头部导航界面
  	*
  	*/
	//防止恶意调用
		if (!defined('IN_TG')){
			exit("Access Defined!");
		}
?>
<div id="header">
		<ul>
			<li><a href="index.php">首页</a></li>
			<?php
				if (isset($_COOKIE['username'])){
					echo '<li><a href="admin.php">'.$_COOKIE['username'].'·管理中心</a></li>';
					echo "\n";
				}else {
					echo '<li><a href="register.php">注册</a></li>';
					echo "\n";
					echo  '<li><a href="login.php">登录</a></li>';
					echo "\n";
				}
			?>
			<?php
				if (isset($_COOKIE['username'])){
					echo '<li><a href="logout.php">退出</a></li>';
				}
			?>
		</ul>
	</div >