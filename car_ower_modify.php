<?php
    /*
     * car_ower_modify.php ---- 车主修改个人信息界面
     *
     */
		//设置编码问题
    header('Content-Type: text/html;charset=utf-8');
		//定义一个常量，来获取调用includes中文件的权限
		define("IN_TG", true);
		//定义一个常量，来指定本页内容
		define('SCRIPT','car_ower_modify');
		//转换成硬路径，速度更快
		require dirname(__FILE__).'/includes/common.inc.php';
    //开启session
		session_start();
    //修改资料
		if (@$_GET['action'] == 'modify') {
      //检查验证码是否正确，防止恶意修改
			_check_code($_POST['code'], $_SESSION['code']);
      //引入功能文件
			require ROOT_PATH.'includes/register.func.php';
      //创建一个数组用来接收信息
			$_clean = array();
      //接收要修改的密码，并检查密码格式以及两次输入是否一致
			$_clean['password'] = _check_modify_password($_POST['password'],$_POST['notpassword'],6);
      //接收性别信息
			$_clean['sex'] = _check_sex($_POST['sex']);
      //接收手机号
			$_clean['phone'] = _check_phone($_POST['phone']);
      //接收车牌号
			$_clean['platenumber'] = _check_platenumber($_POST['platenumber']);
      
      //这里分两种情况 
      //一种是修改一把般信息时也修改了密码（或者只修改了密码），另一种是只修改了一般信息
      //但未修改密码
			if (empty($_clean['password'])) {//如果有密码修改
				//对数据库进行修改
        _query("UPDATE ps_user SET
															psu_sex ='{$_clean['sex']}',
															psu_phone ='{$_clean['phone']}',
															psu_platenumber ='{$_clean['platenumber']}'
												WHERE
															psu_username ='{$_COOKIE['username']}'"
							);
			}else {//未对密码进行修改
        //对数据库进行修改
				_query("UPDATE ps_user SET
															psu_password ='{$_clean['password']}',
															psu_sex ='{$_clean['sex']}',
															psu_phone ='{$_clean['phone']}',
															psu_platenumber ='{$_clean['platenumber']}'
												WHERE
															psu_username ='{$_COOKIE['username']}'"
							);
			}
			//判断是否修改成功
			if (_affected_rows() == 1){
			//关闭
			_close();
			//销毁session
			_session_destroy();
			//跳转
			_location('恭喜你！修改成功！', 'car_ower.php');
			}else {
				//关闭
				_close();
				//销毁session
				_session_destroy();
				//跳转
				_location('很遗憾！由于未知原因修改失败！', 'car_ower_modify.php');
			}
		}
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
        //乳沟获取成功
        if($_rows){
          //创建一个数组用来接收数据库里的信息
          $_html = array();
          $_html['username'] = $_rows['psu_username'];
          $_html['sex'] = $_rows['psu_sex'];
          $_html['phone'] = $_rows['psu_phone'];
          $_html['platenumber'] = $_rows['psu_platenumber'];
          $_html['reg_time'] = $_rows['psu_reg_time'];
          $_html['money'] = $_rows['psu_money'];
          //判断权限 0代表普通会员 1代表管理员
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
          //进行html标签过滤
          $_html = _html($_html);
          //性别选择
					if ($_html['sex'] == '男') {
						$_html['sex_html'] = '<input type="radio" name="sex" value="男" checked="checked"/> 男 <input type="radio" name="sex" value="女" /> 女 ';
					}elseif ($_html['sex'] == '女') {
						$_html['sex_html'] = '<input type="radio" name="sex" value="男" /> 男 <input type="radio" name="sex" value="女" checked="checked"/> 女 ';
					}
        }else {
          _alert_back("此用户因为未知原因不存在！！！");
        }
    } else {
      //消除cookie
      _unsetcookies();
      //跳转
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
<script type="text/javascript" src="js/car_ower_modify.js"></script>
</head>
<body>
  <?php
      //引入车主个人中心头部导航文件
  		require ROOT_PATH.'includes/header.inc.php';
  ?>
  <div id="member">
      <?php
          //引入车主个人中心中心导航界面
          require ROOT_PATH.'includes/car_ower.inc.php';
       ?>
      <div id="member_main">
          <h2>车主个人中心</h2>
          <form action="?action=modify" method="post" >
          <dl>
            <dd>用 户 名：<?php echo $_html['username']; ?></dd>
            <dd>密 &nbsp; 码：<input type="password" name="password" class="text"/> (密码为空则不对密码修改)</dd>
            <dd>密码确认：<input type="password" name="notpassword" class="text"/>
            <dd>性 &nbsp; 别：<?php echo $_html['sex_html']; ?></dd></dd>
            <dd>手 机 号：<input type="text" name="phone" class="text" value='<?php echo $_html['phone']; ?>'/></dd>
            <dd>车 牌 号：<input type="text" name="platenumber" class="text" value='<?php echo $_html['platenumber']; ?>'/></dd>
            <dd>验 证 码：<input  type="text" name="code" class="text yzm"/> <img src="code.php" alt="验证码" id="code" onclick="javascript:"/></dd>
            <dd><input type="submit" value="修改资料" class="submit"/></dd>
          </dl>
        </form>
      </div>
  </div>

</body>
</html>
