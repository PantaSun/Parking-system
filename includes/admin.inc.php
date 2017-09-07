<?php
    /*
    * admin.inc.php -- 管理员中心导航界面
    *
    */
    //防止恶意调用
    if (!defined('IN_TG')){
      exit("Access Defined!");
    }

 ?>
 <div id="member_sidebar">
     <h2>中心导航</h2>
     <dl>
       <dt>车主信息管理</dt>
       <dd><a href="admin.php">车主信息列表</a></dd>
       <dd><a href="query_one_ower.php">查询单个车主信息</a></dd>
       <dd><a href="recharge.php">账户充值</a></dd>
     </dl>
     <dl>
       <dt>车辆信息管理</dt>
       <dd><a href="all_car_state.php">查看所有车辆状态</a></dd>
       <!--<dd><a href="one_car_state.php">查询某一车辆状态</a></dd>-->
     </dl>
     <dl>
       <dt>停车场状态</dt>
       <dd><a href="position_state.php">查看停车场状态</a></dd>
       <dd><a href="query_one_position.php" >查询某一车位状态</a></dd>
     </dl>
 </div>
