<?php
    
    /**
     * my_car_state.php ---- 车主查询自己车辆状态界面
     */
		//设置编码问题
    header('Content-Type: text/html;charset=utf-8');
		//定义一个常量，来获取调用includes中文件的权限
		define("IN_TG", true);
		//定义一个常量，来指定本页内容
		define('SCRIPT','my_car_state');
		//转换成硬路径，速度更快
		require dirname(__FILE__).'/includes/common.inc.php';
    //开启session
		session_start();
    //定义一个数组
    $_html = array();
    if(@$_GET['action'] == 'handle'){
        if($_POST['handle_car'] == '一键停车'){
          $_rows1 = _fetch_array("SELECT psp_id FROM ps_position WHERE psp_state IS NULL ");
          $_row = _fetch_array("SELECT psc_platenumber FROM ps_car WHERE psc_platenumber='{$_COOKIE['platenumber']}'");
          if (!$_row){
          	_location('请先完善车辆信息，才能停车！', "car_completion.php");
          }
          if (!$_rows1) {
            _alert_back('对不起！停车场已经没有空余车位了');
          }else {
                  if ($_COOKIE['money'] > 10) {
                      _query("INSERT INTO ps_inout (
                                            psi_platenumber,
                                            psi_position,
                                            psi_intime
                                ) VALUES(
                                            '{$_COOKIE['platenumber']}',
                                            '{$_rows1['psp_id']}',
                                            NOW()
                                        )");
                      _query("UPDATE ps_user SET psu_money =psu_money-10
                                							WHERE psu_username ='{$_COOKIE['username']}'"
                                						);
                      _query("UPDATE ps_position SET psp_state ='1',
                                                     psp_platenumber = '{$_COOKIE['platenumber']}'
                                              WHERE  psp_id ='{$_rows1['psp_id']}'"
                                            );
                      _query("UPDATE ps_car SET psc_state ='1' WHERE  psc_platenumber ='{$_COOKIE['platenumber']}'" );
                  }
                  else {
                      _alert_back('账户余额不足，请及时充值！');
                       }
                  //判断停车是否成功
                  echo _affected_rows();
                  if (_affected_rows() == 1){
                 			//关闭
                 			_close();
                 			//销毁session
                 			_session_destroy();
                 			//跳转
                 			_location('停车成功！您的车辆停在'.$_rows1['psp_id'].'号位！', 'my_car_state.php');
                 	}else {
                 				//关闭
                 				_close();
                 				//销毁session
                 				_session_destroy();
                 				//跳转
                 				_location('很遗憾！由于未知原因停车失败！', 'my_car_state.php');
                 			}
              }
        }elseif ($_POST['handle_car'] == '一键取车') {

              if (!!$_rows2 = _fetch_array("SELECT psi_intime, psi_position,psi_outtime FROM ps_inout WHERE psi_platenumber='{$_COOKIE['platenumber']}'
              ORDER BY psi_intime DESC LIMIT 1")) {

                $_html['position'] = $_rows2['psi_position'];
                $_html['intime'] = $_rows2['psi_intime'];
                _query("UPDATE ps_position SET psp_state =null,
                                               psp_platenumber = null
                                        WHERE  psp_id ='{$_rows2['psi_position']}'"
                                      );
                _query("UPDATE ps_inout SET    psi_outtime = NOW()
                                        WHERE  psi_position ='{$_rows2['psi_position']}'"
                                      );
                _query("UPDATE ps_car SET    psc_state = null
                		WHERE  psc_platenumber ='{$_COOKIE['platenumber']}'"
                );
                  _location('取车成功！'.$_rows2['psi_position'].'号车位空闲！','my_car_state.php');
              }else {
                _location('取车失败!','my_car_state.php');
              }
        }

    }

    if (isset($_COOKIE['username']) ) {
      if ($_COOKIE['auth'] == '0') {
        //获取该登录用户信息
        $_rows = _fetch_array("SELECT psu_username,
                                      psu_platenumber,
                                      psu_auth,
                                      psu_money
                                 FROM ps_user WHERE psu_username='{$_COOKIE['username']}'");


        if($_rows){
          $_html['username'] =($_rows['psu_username']);
          $_html['platenumber'] = $_rows['psu_platenumber'];
          $_html['money'] = $_rows['psu_money'];
          setcookie('money',$_html['money']);
          setcookie('platenumber',$_html['platenumber']);
          $_rows3 = _fetch_array("SELECT
                                         psi_position,
                                         psi_intime,
                                         psi_outtime
                                     FROM ps_inout WHERE psi_platenumber='{$_html['platenumber']}'");
        
          $_rows4 = _fetch_array("SELECT psp_platenumber,
                                         psp_id
                                  FROM ps_position WHERE psp_platenumber='{$_html['platenumber']}'");

          if($_rows3 && $_rows4){
            $_html['position'] = $_rows4['psp_id'];
            $_html['intime'] = $_rows3['psi_intime'];
          }else {
            $_html['position'] = '还未停车';
            $_html['intime'] = '还未停车';
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
          <h2>车辆状态</h2>
          <dl>
            <dd>用 户 名：<?php echo $_html['username']; ?></dd>
            <dd>车 牌 号：<?php echo $_html['platenumber']; ?></dd>
            <dd>所在车位号码：<?php echo $_html['position']; ?></dd>
            <dd>停车开始时间：<?php echo $_html['intime']; ?></dd>
          </dl>
          <h2>车辆操作</h2>
          <form action="?action=handle" method="post">
            <dl>
              <dd><input type="submit" name="handle_car" value="<?php if($_html['position'] == '还未停车'){echo '一键停车';} else{ echo '一键取车';}?>" class="submit" /></dd>
            </dl>
          </form>
      </div>
  </div>

</body>
</html>
