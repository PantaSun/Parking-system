<?php
		/**
		 *admin.php  ---- 管理员主界面
		 */
		//设置编码问题
        header('Content-Type: text/html;charset=utf-8');
		//定义一个常量，来获取调用includes中文件的权限
		define("IN_TG", true);
		//定义一个常量，来指定本页内容
		define('SCRIPT','admin');
		//转换成硬路径，速度更快
		require dirname(__FILE__).'/includes/common.inc.php';
		if (SCRIPT == 'admin'){
			//判断登录状态
			_login_state("非法操作");
		}
		if ($_COOKIE['auth'] != 1){
			_alert_back("您不是管理员，非法操作！！！");
		}
		//开启session
		session_start();
		//设置分页模块的参数
		_page("SELECT psu_id FROM ps_user WHERE psu_auth=0", 15);
		//读取数据库的信息返回结果集
		$_result = _query("SELECT psu_username, psu_sex, psu_platenumber, psu_money FROM ps_user WHERE psu_auth=0 ORDER BY psu_reg_time DESC LIMIT $_pagenum,$_pagesize");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html xlmns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charst=utf-8" />
<title>管理中心</title>
<link rel="stylesheet" type="text/css" href="css/header.css"/>
<link rel="stylesheet" type="text/css" href="css/basic.css"/>
<link rel="stylesheet" type="text/css" href="css/admin.css"/>
</head>
<body>
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
	<div id="member">
      <?php
          require ROOT_PATH.'includes/admin.inc.php';
       ?>
       <div class="content-box-content" id="member_main">
       	 <h2>管理中心----车主信息列表</h2>
        <div class="table" id="tab1">
          <!-- This is the target div. id must match the href of this div's tab -->
          <table>
            <thead>
              <tr>
                <th>用 户 名</th>
                <th>性 &nbsp; 别</th>
                <th>车 牌 号</th>
                <th>余 &nbsp; 额</th>
                <th>身 &nbsp; 份</th>
              </tr>
              <?php while (!!$_rows = _fetch_array_list($_result)) {
						$_html = array();
						$_html['username'] = $_rows['psu_username'];
						$_html['platenumber'] = $_rows['psu_platenumber'];
						$_html['sex'] = $_rows['psu_sex'];
						$_html['money'] = $_rows['psu_money'];
						$_html = _html($_html);
		?>
              <tr>
                <td><?php echo $_html['username'];?></td>
                <td><?php echo $_html['sex'];?></td>
                <td><?php echo $_html['platenumber'];?></td>
                <td><?php echo $_html['money'];?></td>
                <td>普通会员</td>
              </tr>
              <?php } ?>
            </thead>
          </table>
        </div>
        <?php  
    _free_result($_result);
    _paging(2);
              ?>
      </div>
      <!-- End .content-box-content -->
    </div>
    
  </body>
</html>
