<?php
		/*
  	 * all_car_state.php ---- 查看所有车辆的状态信息
  	 *
  	 */
		//设置编码问题
        header('Content-Type: text/html;charset=utf-8');
		//定义一个常量，来获取调用includes中文件的权限
		define("IN_TG", true);
		//定义一个常量，来指定本页内容
		define('SCRIPT','all_car_state');
		//转换成硬路径，速度更快
		require dirname(__FILE__).'/includes/common.inc.php';
		//非法操作检测
		if (SCRIPT == 'all_car_state'){
			//判断登录状态
			_login_state("非法操作");
		}
		//判断权限 auth = 1 代表管理员
		if ($_COOKIE['auth'] != 1){
			_alert_back("您不是管理员，非法操作！！！");
		}
		//开启session
		session_start();
		//设置分页模块的参数
		_page("SELECT psc_id FROM ps_car", 15);
		//读取数据库的信息返回结果集
		$_result = _query("SELECT psc_username, psc_platenumber, psc_color, psc_type, psc_state FROM ps_car  LIMIT $_pagenum,$_pagesize");
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
	
	<?php
		//引入管理员界面头部导航文件
  		require ROOT_PATH.'includes/adminofheader.inc.php';
  ?>
	<div id="member">
      <?php
      	  //引入管理员界面中心导航文件
          require ROOT_PATH.'includes/admin.inc.php';
       ?>
       <div class="content-box-content" id="member_main">
       	 <h2>管理中心----车辆信息列表</h2>
        <div class="table" id="tab1">
          <!-- This is the target div. id must match the href of this div's tab -->
          <table>
            <thead>
              <tr>
                <th>用 户 名</th>
                <th>车 牌 号</th>
                <th>车 型 号</th>
                <th>车 颜 色</th>
                <th>车 状 态</th>
              </tr>
              <?php while (!!$_rows = _fetch_array_list($_result)) {
						$_html = array();
						$_html['username'] = $_rows['psc_username'];
						$_html['platenumber'] = $_rows['psc_platenumber'];
						$_html['type'] = $_rows['psc_type'];
						$_html['color'] = $_rows['psc_color'];
						$_html['state'] = $_rows['psc_state'];
						$_html = _html($_html);
		?>
              <tr>
                <td><?php echo $_html['username'];?></td>
                <td><?php echo $_html['platenumber'];?></td>
                <td><?php echo $_html['type'];?></td>
                <td><?php echo $_html['color'];?></td>
                <td><?php if( $_html['state'] == 0){echo "未停车";}else{echo "已停车";};?></td>
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
