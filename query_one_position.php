<?php
    /**
     * query_one_position.php  ---- 管理员查询某一车位信息界面
     */
		//设置编码问题
    	header('Content-Type: text/html;charset=utf-8');
		//定义一个常量，来获取调用includes中文件的权限
		define("IN_TG", true);
		//定义一个常量，来指定本页内容
		define('SCRIPT','query_one_ower');
		//转换成硬路径，速度更快
		require dirname(__FILE__).'/includes/common.inc.php';
		if (SCRIPT == 'query_one_ower'){
			//判断登录状态
			_login_state("非法操作");
		}
		if ($_COOKIE['auth'] != 1){
			_alert_back("您不是管理员，非法操作！！！");
		}
    //修改资料
    if (@$_GET['action'] == 'findbyid') {
      require ROOT_PATH.'includes/register.func.php';
      $_clean = array();
      $_clean['psp_id'] = _check_position($_POST['id']);
      if (!!$_rows = _fetch_array("SELECT psp_state FROM ps_position WHERE psp_id='{$_clean['psp_id']}'")){
      		if ($_rows['psp_state'] == 1){
      			_alert_back("该车位已经被占用！！！");
      		}else {
      			_alert_back("该车位未被占用！！！");
      		}
      }else {
      	_alert_back("您输入的车位号不存在！！！");
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
          <form action="?action=findbyid" method="post">
          <dl>
            <dd>通过车位号查找：(本停车场车位号为 100--199)</dd>
            <dd><input type="text" name="id" />（请输入三位纯数字）</dd>
            <dd><input type='submit' name="submit" value="一键查询"/></dd>
          </dl>
          </form>
      </div>
  </div>

</body>
</html>