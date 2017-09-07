//等待网页加载完毕再执行
window.onload = function(){//定义一个匿名函数
	var faceimg = document.getElementById('faceimg');
	var code = document.getElementById('code');
	code.onclick = function(){
		this.src='code.php?tm='+Math.random();
	};
	//表单验证
	var form = document.getElementsByTagName('form')[0];
	form.onsubmit = function(){
		//能用客户端验证尽量用客户端
		
		//用户名验证
		if(form.username.length < 2 || form.username.length > 20){
			alert('用户名不得小于2位或者大于20位！');
			//清空
			form.username.value = '';
			//将光标移至表单字段
			form.username.focus();
			return false;
		}
		//敏感字符验证
		if(/[<>\'\"\ \	]/.test(form.username.value)){
			alert('用户名不得包含非法字符！');
			//清空
			form.username.value = '';
			//将光标移至表单字段
			form.username.focus();
			return false;
		}
		//密码验证
			if(form.password.length < 6){
			alert('密码不得小于6位！');
			//清空
			form.password.value = '';
			//将光标移至表单字段
			form.password.focus();
			return false;
		}
		//密码与密码确认的验证
			if(form.password.value != form.notpassword.value){
			alert('两次输入密码不一致！');
			//清空
			form.password.value = '';
			form.notpassword.value='';
			//将光标移至表单字段
			form.password.focus();
			return false;
		}

		//手机号验证
		if(form.phone.value !=''){
			if(!/^[1-9]{1}[0-9]{4,11}$/.test(form.phone.value)){
				alert('手机号码不正确！');
				//清空
				form.qq.value = '';
				//将光标移至表单字段
				form.qq.focus();
				return false;
			}
		}
		
		//验证码长度验证
		if(form.code.value.length != 4){
			alert('验证码错误');
			form.code.value = '';
			form.code.focus();
			return false;
		}
		return true;
	};
};
