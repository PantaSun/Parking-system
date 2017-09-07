<?php
header('Content:Type: text/html;charset=utf-8');
	/**
	 * 运行时
	 */
	function  _runtime(){
		$_mtime = explode(" ", microtime());
		return  $_mtime[1] + $_mtime[0];
	}
	/**
	 * 对字符串进行html过滤显示 本函数既能处理单独的字符串也能处理字符数组
	 */
	function _html($_string){
		if (is_array($_string)) {
			foreach ($_string as $_key => $_value) {
				$_string[$_key] = _html($_value);//递归函数
			}
		}else {
			  $_string = htmlspecialchars($_string);
		}
		return $_string;
	}
	/**
	 * 分页参数设置
	 * @param $_pagesize 每页显示的条数
	 * @param $sql 获取总条数的查询语句 例如：SELECT gu_id FROM gu_user
	 */
	function _page($_sql, $_size){
		global $_page, $_pagesize, $_pageabsolute, $_pagenum, $_num;
		if (isset($_GET['page'])) {
			$_page = $_GET['page']; //页码
			if (empty($_GET['page']) || $_GET['page'] < 1 || !is_numeric($_GET['page'])) {
				$_page = 1;
			}else {
				$_page = intval($_GET['page']);
			}
		}else {
			$_page = 1;
		}
		$_pagesize = $_size;
		//首先获取所有数据的总和
		$_num = _num_rows(_query($_sql));
		//获取页码
		if ($_num == 0) {
			$_pageabsolute = 1;
		}else {
			$_pageabsolute = ceil($_num/$_pagesize);
		}
		if ($_page > $_pageabsolute) {
			$_page = $_pageabsolute;
		}
		$_pagenum = ($_page - 1) * $_pagesize; //每一页起始
	}
	
	/**
	 * 分页函数
	 * @param $_type string 1:数字分页；2:文字分页；
	 */
	function _paging($_type){
		global $_page, $_pageabsolute, $_num;
		if ($_type == 1) {
			echo '<div id="page_num">';
			echo '<ul>';
			for ($i=0; $i < $_pageabsolute ; $i++) {
				if ($_page == ($i + 1)) {
					echo '<li><a href="'.SCRIPT.'.php?page='.($i+1).'" class="selected">'.($i+1).'</a></li>';
				}else {
					echo '<li><a href="'.SCRIPT.'.php?page='.($i+1).'">'.($i+1).'</a></li>';
				}
			}
			echo '</ul>';
			echo '</div>';
		}elseif ($_type == 2) {
			echo '<div id="page_text">';
			echo '<ul>';
			echo '<li>'.$_page.'/'.$_pageabsolute.'页 | </li>';
			echo '<li>共有<strong>'.$_num.'</strong>条信息 | </li>';
			if ($_page == 1) {
				echo '<li>首页 | </li>';
				echo '<li>上一页 | </li>';
			}else {
				echo '<li><a href="'.SCRIPT.'.php">首页</a> | </li>';
				echo '<li><a href="'.SCRIPT.'.php?page='.($_page - 1).'">上一页</a> | </li>';
			}
			if ($_page == $_pageabsolute) {
				echo '<li>尾页 | </li>';
				echo '<li>下一页 | </li>';
			}else {
				echo '<li><a href="'.SCRIPT.'.php?page='.$_pageabsolute.'">尾页</a> | </li>';
				echo '<li><a href="'.SCRIPT.'.php?page='.($_page + 1).'">下一页</a> | </li>';
			}
			echo '</ul>';
			echo '</div>';
		}
	}

	/**
	 *销毁cookies
	 */
	function _unsetcookies($_url){
		setcookie('username','',time()-1);
		setcookie('uniqid','',time()-1);
		setcookie('platenumber',time()-1);
		setcookie('money',time()-1);
		setcookie('auth',time()-1);
		setcookie('recharge',time()-1);
		_session_destroy();
		_location(null, $_url);
	}

	/**
	 * 登录状态的判断,未登录则无法进入个人管理中心
	 */
	function _login_state($_string){
		if (!isset($_COOKIE['username'])){
			_alert_back($_string);
		}
	}

	/**
	 *
	 * 弹窗并返回
	 */
	function _alert_back($_info){
		echo "<script type='text/javascript'>alert('$_info');history.back();</script>";
		exit();
	}
	/**
	 *
	 * @param unknown $_info
	 * @param unknown $_url
	 */
	function _location($_info,$_url){
		if (!empty($_info)){
			echo "<script type='text/javascript'>alert('$_info');location.href='$_url';</script>";
			exit();
		}else {
			header('Location:'.$_url);
		}
	}

	/**
	 * 销毁session
	 */
	function _session_destroy(){
		session_destroy();
	}

	/**
	 *
	 * @param unknown $_first_code
	 * @param unknown $_end_code
	 */
	function _check_code($_first_code, $_end_code){
		if ( $_first_code != $_end_code){
				_alert_back("验证码不正确！");
		}
	}

	/**
	 * 生成唯一标识符
	 * @return unknown|string
	 */
	function _sha1_uniqid(){
		return  _mysql_string(sha1(uniqid(rand(),true)));
	}

	/**
	 *
	 * @param unknown $_string
	 * @return unknown|string
	 */
	function _mysql_string($_string){
		if (GPC){
			return $_string;
		}else {
			return mysql_real_escape_string($_string);
		}
	}
	/**
	 * _code()函数是验证码函数
	 * @access public
	 * @param int $_width 表示验证码的长度
	 * @param int $_height 表示验证码的宽度
	 * @param int $_rnd_code 表示是验证码的位数
	 * @param boolean $_flag 表示是否要黑框
	 * @return void 这个函数运行后产生验证码
	 */
	function  _code($_width = 75, $_height = 25, $_rnd_code = 4, $_flag = false){

		//创建随机码
		for ($i =0 ;$i< $_rnd_code; $i++){
			@$_nmsg .=dechex(mt_rand(1,15));
		}
		//echo $_nmsg;
		//保存在session中
		$_SESSION['code'] = $_nmsg;


		//创建一张图像
		$_img = imagecreatetruecolor($_width, $_height);

		//白色
		$_white = imagecolorallocate($_img, 255, 255, 255);

		// 填充
		imagefill($_img, 0, 0, $_white);
		if ($_flag){
			//黑色边框
			$_black = imagecolorallocate($_img, 0, 0, 0);
			imagerectangle($_img, 0, 0, $_width-1, $_height-1, $_black);
		}
		//随机生成6条线
		for ($i = 0;$i < 6;$i ++){
			$_rnd_color1 = imagecolorallocate($_img, mt_rand(0,255), mt_rand(0,255), mt_rand(0,255));
			imageline($_img, mt_rand(0,$_width),mt_rand(0,$_height) , mt_rand(0,$_width),mt_rand(0,$_height)  ,$_rnd_color1);
		}
		//随机生成雪花
		for ($i = 0; $i < 100 ;$i ++){
			$_rnd_color2 = imagecolorallocate($_img, mt_rand(200,255), mt_rand(200,255), mt_rand(200,255));
			imagestring($_img, 1, mt_rand(1,$_width),mt_rand(1,$_height) , "*", $_rnd_color2);
		}

		//输出随机验证码
		for ($i = 0 ;$i <strlen($_SESSION['code']);$i ++){
			$_rnd_color3 = imagecolorallocate($_img, mt_rand(0,175), mt_rand(0,155), mt_rand(0,200));
			@imagestring($_img, 5, $i*$_width/$_rnd_code+mt_rand(1,10), mt_rand(1,$_height/2), $_SESSION['code'][$i], $_rnd_color3);
		}
		//输出图像
		header('Content-Type:image/png');
		imagepng($_img);

		//销毁图像
		imagedestroy($_img);

	}
?>
