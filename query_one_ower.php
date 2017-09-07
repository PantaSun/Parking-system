<?php
    
    /**
     * query_one_ower.php  ---- 管理员查询某一车主信息界面
     */
		//设置编码问题
    	header('Content-Type: text/html;charset=utf-8');
		//定义一个常量，来获取调用includes中文件的权限
		define("IN_TG", true);
		//定义一个常量，来指定本页内容
		define('SCRIPT','query_one_ower');
		//转换成硬路径，速度更快
		require dirname(__FILE__).'/includes/common.inc.php';
  	   //开启session
		session_start();
		//检查非法操作
		if (SCRIPT == 'query_one_ower'){
			//判断登录状态
			_login_state("非法操作");
		}
		if ($_COOKIE['auth'] != 1){
			_alert_back("您不是管理员，非法操作！！！");
		}
    //修改资料
    if (@$_GET['action'] == 'findbyname') {
      require ROOT_PATH.'includes/login.func.php';
      if (empty($_POST['username'])){
      	_location("用户名不得为空！！！", "query_one_ower.php");
      }
      $_clean = array();
      $_clean['username'] = _check_username($_POST['username'],2,20);
       if(!!$_rows = _fetch_array("SELECT * FROM ps_user WHERE psu_username='{$_clean['username']}'")){
       		$_html = array();
       		$_html['username'] = $_rows['psu_username'];
       		$_html['sex'] = $_rows['psu_sex'];
       		$_html['platenumber'] = $_rows['psu_platenumber'];
       		$_html['phone'] = $_rows['psu_phone'];
       		$_html['reg_time'] = $_rows['psu_reg_time'];
       		$_html['money'] = $_rows['psu_money'];
       		$_html = _html($_html);
       }else {
       	_location("该用户不存在！！！", "query_one_ower.php");
       }
    } else if (@$_GET['action'] == 'findbyplatenum') {
    	require ROOT_PATH.'includes/register.func.php';
    	if (empty($_POST['platenumber'])){
    		_location("车牌号不得为空！！！", "query_one_ower.php");
    	}
    	$_clean = array();
    	$_clean['platenumber'] = _check_platenumber($_POST['platenumber']);
    	if(!!$_rows = _fetch_array("SELECT * FROM ps_user WHERE psu_platenumber='{$_clean['platenumber']}'")){
    		$_html = array();
    		$_html['username'] = $_rows['psu_username'];
    		$_html['sex'] = $_rows['psu_sex'];
    		$_html['platenumber'] = $_rows['psu_platenumber'];
    		$_html['phone'] = $_rows['psu_phone'];
    		$_html['reg_time'] = $_rows['psu_reg_time'];
    		$_html['money'] = $_rows['psu_money'];
    		$_html = _html($_html);
    	}else {
       	_location("该用户不存在！！！", "query_one_ower.php");
       }
    }
   

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html xlmns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charst=utf-8" />
<title>管理中心</title>
<link rel="stylesheet" type="text/css" href="css/basic.css"/>
<link rel="stylesheet" type="text/css" href="css/admin.css"/>
<link rel="stylesheet" type="text/css" href="css/header.css"/>
</head>
<body>
  <?php
  		require ROOT_PATH.'includes/adminofheader.inc.php';
  ?>
  <div id="member">
      <?php
          require ROOT_PATH.'includes/admin.inc.php';
       ?>
      <div id="member_main">
          <h2>查询某一用户信息</h2>
          <form action="?action=findbyname" method="post">
          <dl>
            <dd>通过用户名查找：<input type="text" name="username" />    <input type='submit' name="submit" value="一键查询"/></dd>
          </dl>
          </form>
          <form action="?action=findbyplatenum" method="post">
          	<dl>
          		<dd>通过车牌号查找：<input type="text" name="platenumber"/>   <input type='submit' name="submit" value="一键查询"/></dd>
          	</dl>
          	</form>
          	<?php 
          		if (!empty($_html)){
          			echo '<dl>';
          			echo '<dd>用 户 名：'.$_html['username'].'</dd>';
          			echo '<dd>性 &nbsp; 别：'.$_html['sex'].'</dd>';
          			echo '<dd>车 牌 号：'.$_html['platenumber'].'</dd>';
          			echo '<dd>手 机 号：'.$_html['phone'].'</dd>';
          			echo '<dd>注册时间：'.$_html['reg_time'].'</dd>';
          			echo '<dd>用户余额：'.$_html['money'].'</dd>';
          			echo '</dl>';
          		}
          	?>
        
      </div>
  </div>

</body>
</html>