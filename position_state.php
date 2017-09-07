<?php
    /*
     * position_state.php ---- 管理员查看停车场车位状态
     *
     */
		//设置编码问题
    	header('Content-Type: text/html;charset=utf-8');
		//定义一个常量，来获取调用includes中文件的权限
		define("IN_TG", true);
		//定义一个常量，来指定本页内容
		define('SCRIPT','posotion_state');
		//转换成硬路径，速度更快
		require dirname(__FILE__).'/includes/common.inc.php';
    //判断是否是登录状态
		if (isset($_COOKIE['username'])){
      //判断权限是否是管理员  auth = 1 代表管理员
			if ($_COOKIE['auth'] == 1){
        //获取停车场空的车位数量
				$_num = _num_rows(_query("SELECT psp_id FROM ps_position WHERE psp_state IS NULL"));
			}else {
				_alert_back("您不是管理员，无权操作！！！");
			}
		}else {
			_alert_back("非法操作！请登录！");
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
      //引入管理员界面的头部导航栏
  		require ROOT_PATH.'includes/adminofheader.inc.php';
  ?>
  <div id="member">
      <?php
          //引入管理员界面的中心导航界面
          require ROOT_PATH.'includes/admin.inc.php';
       ?>
      <div id="member_main">
          <h2>停车场车位状态信息</h2>
          <form action="?action=findbyid" method="post">
          <dl>
            <dd>目前未用车位数量：</dd>
            <dd>共有 <strong><?php echo $_num;?> </strong>个</dd>
            <dd>目前已用车位数量：</dd>
            <dd>共有 <strong><?php echo 100-$_num;?> </strong>个</dd>
          </dl>
          </form>
      </div>
  </div>

</body>
</html>