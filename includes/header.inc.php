<?php
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
				echo '<li><a href="car_ower.php">'.$_COOKIE['username'].'·个人中心</a></li>';
				echo "\n";
			}else {
				echo '<li><a href="car_ower_register.php">车主注册</a></li>';
				echo "\n";
				echo  '<li><a href="car_ower_login.php">车主登录</a></li>';
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
