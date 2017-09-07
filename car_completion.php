<?php
    
    /**
     * car_completion.php ---- 车主补全车辆信息界面
     */
		//设置编码问题
    header('Content-Type: text/html;charset=utf-8');
		//定义一个常量，来获取调用includes中文件的权限
		define("IN_TG", true);
		//定义一个常量，来指定本页内容
		define('SCRIPT','car_completion');
		//转换成硬路径，速度更快
		require dirname(__FILE__).'/includes/common.inc.php';
    //开启session
		session_start();
    //修改资料
    if (@$_GET['action'] == 'completion') {
      //引入功能函数库文件
      require ROOT_PATH.'includes/register.func.php';
      $_clean = array();
      $_clean['car_type'] = _check_car_type($_POST['car_type']);
      $_clean['car_color'] = _check_car_color($_POST['car_color']);
      $_clean['platenumber'] = $_POST['platenumber'];
      $_clean['submit'] = $_POST['submit'];
      if ($_clean['submit'] == '补全资料') {
        _query("INSERT INTO ps_car(
        					  psc_username,
                              psc_platenumber,
                              psc_type ,
                              psc_color
                            )
                        VALUES(
        						'{$_COOKIE['username']}',
                              '{$_clean['platenumber']}',
                              '{$_clean['car_type']}',
                              '{$_clean['car_color']}'
                        
                        )"
              );
       
      }elseif ($_clean['submit'] == '修改资料') {
        _query("UPDATE ps_car SET
															psc_type ='{$_clean['car_type']}',
															psc_color ='{$_clean['car_color']}'
												WHERE
															psc_platenumber ='{$_clean['platenumber']}'"
							);
      }
      //判断是否修改成功
      if (_affected_rows() == 1){
      //关闭
      _close();
      //销毁session
      _session_destroy();
      //跳转
      _location('恭喜你！补全或修改成功！', 'car.php');
      }else {
        //关闭
        _close();
        //销毁session
        _session_destroy();
        //跳转
        _location('很遗憾！由于未知原因补全或修改失败！', 'car_completion.php');
      }
    }
    if (isset($_COOKIE['username'])) {
      //获取该登录用户信息
      $_rows1 = _fetch_array("SELECT psu_username,
                                                               psu_platenumber
                               FROM ps_user WHERE psu_username='{$_COOKIE['username']}'");
      $_rows2 = _fetch_array("SELECT psc_type,
                                                               psc_color
                               FROM ps_car WHERE psc_platenumber='{$_rows1['psu_platenumber']}'");
      //如果获取成功
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
          <form action="?action=completion" method="post">
          <dl>
            <dd>用 户 名：<?php echo $_html['username']; ?></dd>
            <input type="hidden" name="platenumber" value='<?php echo $_html['platenumber']?>'/>
            <dd>车 牌 号：<?php echo $_html['platenumber']; ?></dd>
            <dd>车辆型号：<input type="text" name="car_type" value='<?php
            if(empty($_html['car_type'])){
                echo "请补全车辆信息";
            }else {
                echo $_html['car_type'];
              }?>'/>
            <dd>车辆颜色：<input type="text" name="car_color" value='<?php
            if(empty($_html['car_color'])){
                echo "请补全车辆信息";
            }else {
                echo $_html['car_color'];
              }?>'/></dd>
              <dd><input type='submit' name="submit" value='<?php if(empty($_html['car_type']) && empty($_html['car_color']) ){echo '补全资料';}else{echo '修改资料';}?>' class="submit"/></dd>
        </from>
      </div>
  </div>

</body>
</html>
