<?php
    //防止恶意调用
    if (!defined('IN_TG')){
      exit("Access Defined!");
    }

 ?>
 <div id="member_sidebar">
     <h2>中心导航</h2>
     <dl>
       <dt>账号信息</dt>
       <dd><a href="car_ower.php">个人信息</a></dd>
       <dd><a href="car_ower_modify.php">修改个人信息</a></dd>
       <dd><a href="car.php">车辆信息</a></dd>
       <dd><a href="car_completion.php">补全车辆信息</a></dd>
     </dl>
     <dl>
       <dt>车辆管理</dt>
       <dd><a href="my_car_state.php">查看车辆状态</a></dd>
     </dl>
 </div>
