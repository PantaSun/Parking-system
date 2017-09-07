<?php
    
    /**
     * car.php --- 车主车辆界面
     */
		//设置编码问题
    header('Content-Type: text/html;charset=utf-8');
		//定义一个常量，来获取调用includes中文件的权限
		define("IN_TG", true);
		//定义一个常量，来指定本页内容
		define('SCRIPT','car');
		//转换成硬路径，速度更快
		require dirname(__FILE__).'/includes/common.inc.php';
    //开启session
		session_start();
    if (isset($_COOKIE['username'])) {
        //获取该登录用户信息
        $_rows1 = _fetch_array("SELECT psu_username,
                                      psu_platenumber
                                 FROM ps_user WHERE psu_username='{$_COOKIE['username']}'");
        $_rows2 = _fetch_array("SELECT psc_type,
                                       psc_color
                                 FROM ps_car WHERE psc_platenumber='{$_rows1['psu_platenumber']}'");
        if($_rows1){
          $_html = array();
          $_html['username'] =($_rows1['psu_username']);
          $_html['platenumber'] = $_rows1['psu_platenumber'];
          if ($_rows2) {
            $_html['car_type'] = $_rows2['psc_type'];
            $_html['car_color'] = $_rows2['psc_color'];
          }else {
            $_html['car_type'] = '';
            $_html['car_color'] = '';
          }

          $_html = _html($_html);
        }else {
          _alert_back("此用户因为未知原因不存在！！！");
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
          require ROOT_PATH.'includes/car.inc.php';
       ?>
      <div id="member_main">
          <h2>车主个人中心</h2>
          <dl>
            <dd>用 户 名：<?php echo $_html['username']; ?></dd>
            <dd>车 牌 号：<?php echo $_html['platenumber']; ?></dd>
            <dd>车辆型号：<?php
            if(empty($_html['car_type'])){
                echo "请补全车辆信息";
            }else {
                echo $_html['car_type'];
              }?>
            <dd>车辆颜色：<?php
            if(empty($_html['car_color'])){
                echo "请补全车辆信息";
            }else {
                echo $_html['car_color'];
              }?></dd>

          </dl>
      </div>
  </div>

</body>
</html>
