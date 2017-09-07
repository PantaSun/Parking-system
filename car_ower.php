<?php
    
    /**
     * car_ower.php --- 车主主界面
     */
		//设置编码问题
    header('Content-Type: text/html;charset=utf-8');
		//定义一个常量，来获取调用includes中文件的权限
		define("IN_TG", true);
		//定义一个常量，来指定本页内容
		define('SCRIPT','car_ower');
		//转换成硬路径，速度更快
		require dirname(__FILE__).'/includes/common.inc.php';
    //开启session
		session_start();
    if (isset($_COOKIE['username']) ) {
      if ($_COOKIE['auth'] == '0') {
        # code...

        //获取该登录用户信息
        $_rows = _fetch_array("SELECT psu_username,
                                      psu_sex, psu_phone,
                                      psu_platenumber,
                                      psu_reg_time,
                                      psu_auth,
                                      psu_money
                                 FROM ps_user WHERE psu_username='{$_COOKIE['username']}'");
        if($_rows){
          $_html = array();
          $_html['username'] =($_rows['psu_username']);
          $_html['sex'] = $_rows['psu_sex'];
          $_html['phone'] = $_rows['psu_phone'];
          $_html['platenumber'] = $_rows['psu_platenumber'];
          $_html['reg_time'] = $_rows['psu_reg_time'];
          $_html['money'] = $_rows['psu_money'];
          switch ($_rows['psu_auth']) {
            case 0:
              //普通会员
              $_html['auth'] = '普通会员';
              break;
            case 1:
              //管理员
              $_html['auth'] = '管理员';
              break;
          }
          $_html = _html($_html);
        }else {
          _alert_back("此用户因为未知原因不存在！！！");
        }
    } else {
      _unsetcookies();
      _location(null,'car_ower_login.php');
    }
  }else {
      _alert_back('非法操作！请登录！');
    }


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html xlmns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charst=utf-8" />
<title>个人中心</title>
<link rel="stylesheet" type="text/css" href="css/car_ower.css"/>
<link rel="stylesheet" type="text/css" href="css/basic.css"/>
</head>
<body>
  <?php
  		require ROOT_PATH.'includes/header.inc.php';
  ?>
  <div id="member">
      <?php
          require ROOT_PATH.'includes/car_ower.inc.php';
       ?>
      <div id="member_main">
          <h2>车主个人中心</h2>
          <dl>
            <dd>用 户 名：<?php echo $_html['username']; ?></dd>
            <dd>性 &nbsp; 别：<?php echo $_html['sex']; ?></dd>
            <dd>手 机 号：<?php echo $_html['phone']; ?></dd>
            <dd>车 牌 号：<?php echo $_html['platenumber']; ?></dd>
            <dd>账户余额：<strong><?php echo $_html['money']; ?>.00 </strong> (若余额不足请及时充值)</dd>
            <dd>注册时间：<?php echo $_html['reg_time']; ?></dd>
            <dd>身 &nbsp; 份：<?php echo $_html['auth']; ?></dd>
          </dl>
      </div>
  </div>

</body>
</html>
