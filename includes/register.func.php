<?php
		/**
		 * register.func.php 注册时用到的函数库文件
		 *
		 */

		//防止恶意调用
		if (!defined('IN_TG')){
			exit("Access Defined!");
		}
		//判断函数是否存在
		if (!function_exists('_alert_back')){
			exit('请检查_alert_back函数是否存在！');
		}
		//同上
		if (!function_exists('_mysql_string')){
			exit('请检查_mysql_string函数是否存在！');
		}
		/**
		 * 判断唯一标识符
		 * @param unknown $_string
		 * @return unknown|string
		 */
		function _check_uniqid($_first_uniqid, $_end_uniqid){
			if ((strlen($_first_uniqid)!=40) || ($_first_uniqid != $_end_uniqid)){
				_alert_back('唯一标识符异常！');
			}
			return _mysql_string($_first_uniqid);
		}
		/**
		 * 判断车位号格式
		 * @param string $_string
		 * @return string $_string
		 */
		function _check_position($_string){
			if (!preg_match('/^[0-9]{3}$/', $_string)){
				_alert_back('车位号必须为三位纯数字！');
			}
			return _mysql_string($_string);
		}
		/**
		 * _check_username 检查和过滤用户名
		 * @access public
		 * @param string $string 受污染的用户名
		 * @param int $min_num 最小长度
		 * @param int $max_num 最大长度
		 * @return string 过滤后的用户名
		 */
		function _check_username($_string, $min_num, $max_num){
			//去掉两边空格
			$_string = trim($_string);
			if (mb_strlen($_string,'utf-8')<$min_num|| mb_strlen($_string,'utf-8')>$max_num){
					_alert_back('长度不得小于'.$min_num.'位或大于'.$max_num.'位！');
			}
			//限制敏感字符
			$_char_pattern='/[<>\'\"\ \		]/';
			if (preg_match($_char_pattern, $_string)){
				_alert_back("用户名不得包含特殊字符！");
			}
			//限制敏感用户名
			$_mg[0]='xijinping';
			$_mg[1]='xidada';
			$_mg[2]='习大大';
			//告诉用户哪些用户名无法注册
			foreach ($_mg as $value ){
				@$_mg_string.='['.$value.']'.'\n';
			}
			//采用绝对匹配
			if (in_array($_string, $_mg)){
				_alert_back($_mg_string.'以上敏感用户不得注册');

			}

			return _mysql_string($_string);
		}
		/**
		 * 判断车型号不能为空
		 * @param unknown $_string
		 * @return unknown|string
		 */
		function _check_car_type($_string){
			if (empty($_string)) {
				_alert_back('车型不能为空！');
			}
			return _mysql_string($_string);
		}
		/**
		 * 判断车颜色不能为空
		 * @param unknown $_string
		 * @return unknown|string
		 */
		function _check_car_color($_string){
			if (empty($_string)) {
				_alert_back('车颜色不能为空！');
			}
			return _mysql_string($_string);
		}
		/**
		 * _check_password 验证密码
		 * @access public
		 * @param string $_first_pass
		 * @param string $_end_pass
		 * @param int $_min_num
		 * @return string
		 */
		function  _check_password($_first_pass, $_end_pass, $_min_num){
			//判断密码
			if (strlen($_first_pass) < $_min_num){
				_alert_back('密码不得小于'.$_min_num.'位！');
			}
			//两次密码输入必须一致
			if ($_first_pass != $_end_pass){
				_alert_back('两次输入密码不一致！');
			}
			return _mysql_string(sha1($_first_pass));
		}
		/**
		 * _check_modify_password 验证修改资料时的密码
		 * @access public
		 * @param string $_first_pass
		 * @param string $_end_pass
		 * @param int $_min_num
		 * @return string
		 */
		function _check_modify_password($_first_pass,$_end_pass,$_min_num){
			//判断是否为空，空则不进行验证
			if (!empty($_first_pass)) {
				//判断密码
				if (strlen($_first_pass) < $_min_num){
					_alert_back('密码不得小于'.$_min_num.'位！');
				}
				//两次密码输入必须一致
				if ($_first_pass != $_end_pass){
					_alert_back('两次输入密码不一致！');
				}
			}else {
				return null;
			}
				return sha1($_first_pass);
		}

		/**
		 *   _check_question 检查密码提示问题
		 * @access public
		 * @param string $_string
		 * @param int $_min_num
		 * @param int $_max_num
		 * @return string $_string
		 */
		function  _check_question($_string, $_min_num, $_max_num){
			$_string = trim($_string);
			//长度不得小于4位或者大于20位
			if (mb_strlen($_string,'utf-8')< $_min_num || mb_strlen($_string, 'utf-8')> $_max_num){
				_alert_back('密码提示不得小于'.$_min_num.'位或者大于'.$_max_num.'位！');
			}

			return _mysql_string($_string);
		}
		/**
		 * 检查问题答案是否和问题相同，以及格式是否正确
		 * @param string $_quest
		 * @param string $_answ
		 * @param int $_min_num
		 * @param int $_max_num
		 * @return string $_answ
		 */
		function _check_answer($_quest, $_answ, $_min_num, $_max_num){
			$_answ = trim($_answ);
			//长度不得小于4位或者大于20位
			if (mb_strlen($_answ,'utf-8')< $_min_num || mb_strlen($_answ, 'utf-8')> $_max_num){
				_alert_back('问题回答不得小于'.$_min_num.'位或者大于'.$_max_num.'位！');
			}
			//密码提示与回答不能相同
			if ($_quest == $_answ){
				_alert_back('密码提示与回答不能相同！');
			}
			return _mysql_string(sha1($_answ));
		}
		/**
		 *	过滤性别
		 * @param unknown $_string
		 */
		function _check_sex($_string){
			return _mysql_string($_string);
		}


		/**
		 * 检查邮箱格式
		 * @access public
		 * @param string $_string
		 * @return $_string 正确的邮箱
		 */
		function _check_email($_string){
			//[a-zA-Z0-9] => \w

			if (!preg_match('/^[\w\-\.]+@[\w\-\.]+(\.\w+)+$/', $_string)){
				_alert_back('邮箱格式不正确！');
			}
			return  _mysql_string($_string);
		}

		/**
		 * 检查手机号位数与格式是否正确
		 * @param unknown $_string
		 * @return unknown|string
		 */
		function _check_phone($_string){
			if (strlen($_string) != 11){
				_alert_back('手机号位数不正确！');
			}
			elseif (!preg_match('/^[1-9]{1}[0-9]{4,11}$/', $_string)){
				_alert_back('手机号格式不正确！');
			}
			return _mysql_string($_string);
		}

		/**
		 * 检查车牌号格式与位数
		 * @param unknown $_string
		 * @return unknown|string
		 */
		function _check_platenumber($_string){
			if (!(mb_strlen($_string,'utf-8') == 7)){
				_alert_back('车牌号位数不正确！');
			}
			elseif (!preg_match('/[\x80-\xff]+[A-Z][0-9a-zA-Z]{5}/', $_string)){
					_alert_back('车牌号格式不正确！');
			}
			return _mysql_string($_string);
		}
?>
