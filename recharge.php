<?php
  /*
   * recharge.php ---- 管理员给用户充值界面
   *
   */
	//设置编码问题
    header('Content-Type: text/html;charset=utf-8');
	//定义一个常量，来获取调用includes中文件的权限
	define("IN_TG", true);
	//定义一个常量，来指定本页内容
	define('SCRIPT','recharge');
	//转换成硬路径，速度更快
	require dirname(__FILE__).'/includes/common.inc.php';
    //开启session
	session_start();
	//非法操作检测
	if (SCRIPT == 'recharge'){
		//判断登录状态
		_login_state("非法操作");
	}
	if ($_COOKIE['auth'] != 1){
		_alert_back("您不是管理员，非法操作！！！");
	}
  	//充值
    if (@$_GET['action'] == 'namenot') {
      require ROOT_PATH.'includes/login.func.php';
      if (empty($_POST['username'])){
      	_location("用户名不得为空！！！", "recharge.php");
      }
      $_clean = array();
      $_clean['username'] = _check_username($_POST['username'],2,20);
      setcookie("recharge",$_clean['username']);
      $_rows = _fetch_array("SELECT psu_id FROM ps_user WHERE psu_username='{$_clean['username']}'");
       if($_rows){
 		$_infor = "存在该用户！！！可以进行充值！！！";
 		echo "<script type='text/javascript'>alert('$_infor');history.back();</script>";
       }else {
       	_location("该用户不存在！！！", "recharge.php");
       }
    } else if (@$_GET['action'] == 'recharge') {
    	//防止恶意注册和伪造表单跨站攻击
    	_check_code($_POST['code'], $_SESSION['code']);
    	//引入文件
    	require ROOT_PATH.'includes/login.func.php';
    	if (!isset($_COOKIE['recharge'])){
    		$_infor2 = "请先检查用户名是否存在再进行充值！！！";
    		echo "<script type='text/javascript'>alert('$_infor2');history.back();</script>";
    	}
    	$_clean = array();
    	$_clean['money'] = $_POST['money'];
    	_query("UPDATE ps_user SET
															psu_money=psu_money+'{$_clean['money']}'
												WHERE
															psu_username='{$_COOKIE['recharge']}'"
							);
    	//判断是否充值成功
		if (_affected_rows() == 1){
				//关闭
				_close();
				//销毁session
				_session_destroy();
				//销毁cookie
				setcookie('recharge',time()-1);
				//跳转
				_location('充值成功！', 'admin.php');
		}else {
				//关闭
				_close();
				//销毁session
				_session_destroy();
				//跳转
				_location('很遗憾！由于未知原因充值失败！', 'recharge.php');
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
<script type="text/javascript" src="js/recharge.js"></script>
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
          <h2>账户充值</h2>
          <form action="?action=namenot" method="post">
          <dl>
            <dd>充值用户名：<input type="text" name="username" />    <input type='submit' name="submit" value="检测是否存在该用户"/></dd>
          </dl>
          </form>
          <form action="?action=recharge" method="post">
          	<dl>
          		<dd>充 值 金 额：<select name="money">
          		<option value="10">10元</option><option value="20">20元</option>
          		<option value="50">50元</option><option value="100">100元</option>
          		<option value="200">200元</option><option value="500">500元</option>
          		<option value="1000">1000元</option><option value="5000">5000元</option>
          		</select>
          		验证码：<input type='text' name="code" /> <img src="code.php" alt="验证码" id="code" onclick="javascript:"/></dd>
          		<dd><input type="submit" name="submit"  value="确认充值"/></dd>
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