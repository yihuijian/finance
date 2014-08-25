<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
	<title>个人理财系统——用户登录</title>
	<meta charset="utf-8"/>
	<link rel="stylesheet" type="text/css" href="__PUBLIC__/bootstrap/css/bootstrap.min.css" />
	<link rel="stylesheet" type="text/css" href="__PUBLIC__/Css/login.css" />
</head>
<body>
<div>
	<img src="__PUBLIC__/Images/login_bg.jpg" id="bg"/>

	<form id="loginForm" action="checkLogin" method="post">
		<div id="login">
			<div class="titleInfo">用户登录</div>
			<div class="result">&nbsp;</div>
			<div class="control">
				<label for="name" class="icon name-icon clearfix"></label>
				<input type="text" id="name" name="name" placeholder="用户名">
			</div>
			<div class="control">
				<label for="pwd" class="icon pwd-icon clearfix"></label>
				<input type="password" id="pwd" name="pwd" placeholder="密   码">
			</div>
			<div class="control">
				<label class="checkbox clearfix" style="margin-left: 50px;" title="为了确保您的信息安全，请不要在网吧或者公共机房勾选此项！">
					<input type="checkbox" name="autoLogin" id="autoLogin">下次自动登录
				</label>
				<label class="clearfix" style="float: right; margin-right: 25px;"><a href="#">忘记密码？</a></label>
			</div>
			<div class="control">
				<input type="button" class="btn btn-primary" id="btnLogin" value="登录">
			</div>
			<div class="line"></div>
			<div class="control">
				<input type="button" class="btn btn-success" id="btnRegister" value="注册">
			</div>
		</div>
	</form>
</div>

<script type="text/javascript" src="__PUBLIC__/Js/Jquery/jquery.min.js"></script>
<script type="text/javascript" src="__PUBLIC__/Js/Jquery/jquery.form.js"></script>
<script type="text/javascript" src="__PUBLIC__/Js/login.js"></script>

<script>
	// 解决IE浏览器不显示placeholder问题
	var funPlaceholder = function (element) {
		var placeholder = '';
		if (element && !("placeholder" in document.createElement("input")) && (placeholder = element.getAttribute("placeholder"))) {
			element.onfocus = function () {
				if (this.value === placeholder) {
					this.value = "";
				}
				this.style.color = '';
			};
			element.onblur = function () {
				if (this.value === "") {
					this.value = placeholder;
					this.style.color = 'gray';
				}
			};
			//样式初始化
			if (element.value === "") {
				element.value = placeholder;
				element.style.color = 'gray';
			}
		}
	};
	funPlaceholder(document.getElementById("name"));
	funPlaceholder(document.getElementById("pwd"));
</script>
</body>
</html>