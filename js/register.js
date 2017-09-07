//等待网页加载完毕再执行
window.onload = function(){//定义一个匿名函数
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
