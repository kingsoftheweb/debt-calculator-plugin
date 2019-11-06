<style type="text/css">
	/*body {
		background: rgba(255,255,255,1) !important;
		background: -moz-radial-gradient(center, ellipse cover, rgba(255,255,255,1) 0%, rgba(246,246,246,1) 47%, rgba(237,237,237,1) 100%) !important;
		background: -webkit-gradient(radial, center center, 0px, center center, 100%, color-stop(0%, rgba(255,255,255,1)), color-stop(47%, rgba(246,246,246,1)), color-stop(100%, rgba(237,237,237,1))) !important;
		background: -webkit-radial-gradient(center, ellipse cover, rgba(255,255,255,1) 0%, rgba(246,246,246,1) 47%, rgba(237,237,237,1) 100%) !important;
		background: -o-radial-gradient(center, ellipse cover, rgba(255,255,255,1) 0%, rgba(246,246,246,1) 47%, rgba(237,237,237,1) 100%) !important;
		background: -ms-radial-gradient(center, ellipse cover, rgba(255,255,255,1) 0%, rgba(246,246,246,1) 47%, rgba(237,237,237,1) 100%) !important;
		background: radial-gradient(ellipse at center, rgba(255,255,255,1) 0%, rgba(246,246,246,1) 47%, rgba(237,237,237,1) 100%) !important;
		filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#ffffff', endColorstr='#ededed', GradientType=1 ) !important;
	}*/
	body {
		background: #2c3338 !important;
	}
	#login {
		width: 50% !important;
	}
	#login h1 a, .login h1 a {
		background-image: url('<?php echo $this->plugin_url . "/admin/partials/login-page/kingsoftheweb-logo.png"; ?>');
		height:65px;
		width:320px;
		background-size: auto;
		background-repeat: no-repeat;
		padding-bottom: 30px;
	}
	.login form {
		background: transparent !important;
		box-shadow: none !important;
	}
	.login form p {
		color: #ffffff !important;
		text-align: center !important;
	}
	.login form p input {
		background: #3b4148 !important;
		border: 1px solid #3b4148 !important;
		border-radius: 10px !important;
		color: #eeeeee !important;
	}
	#login form p.submit {
		margin: 0;
		padding: 0;
		width: 100% !important;
		display: flex;
		justify-content: center;
		margin-top: 37px !important;
	}
	#login form p.submit input#wp-submit {
		display: flex;
		justify-content: center;
		width: 100%;
		background-color: #ea4c88 !important;
		color: #eee;
		font-weight: 700;
		text-transform: uppercase;
		height: 45px;
	}
</style>