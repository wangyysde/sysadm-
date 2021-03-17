<?php if(!defined("SYSADM_SET")){exit("<h1>Access Denied</h1>");} ?><!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta http-equiv="Expires" content="wed, 26 feb 1997 08:21:57 gmt" />
	<meta http-equiv="Pragma" content="no-cache" />
	<meta http-equiv="Cache-Control" content="no-cache" />
	<title><?php echo P_Lang("管理员登录");?></title>
	<meta name="author" content="phpok.com" />
	<?php if($config['favicon']){ ?>
	<link rel="shortcut icon" href="<?php echo $config['favicon'];?>" />
	<?php } ?>
	<link rel="stylesheet" type="text/css" href="css/artdialog.css" />
	<link rel="stylesheet" type="text/css" href="css/login.css" />
	<script type="text/javascript" src="<?php echo phpok_url(array('ctrl'=>'js','func'=>'mini','ext'=>'jquery.phpok,jquery.form.min,jquery.artdialog,admin.login,jquery.qrcode.min'));?>&_v=<?php echo VERSION;?>"></script>
	<?php if($phpok_cdn_link != 'static/cdn/'){ ?>
	<link href="<?php echo $phpok_cdn_link;?>slick/slick-theme.css" rel="stylesheet"/>
	<link href="<?php echo $phpok_cdn_link;?>slick/slick.css" rel="stylesheet"/>
	<script src="<?php echo $phpok_cdn_link;?>slick/slick.js" type="text/javascript"></script>
	<script type="text/javascript" src="<?php echo $phpok_cdn_link;?>background/load.js?host=<?php echo rawurlencode($phpok_cdn_link);?>"></script>
	<?php } ?>
<?php echo $app->_node_html("before");$app->plugin_html_ap("phpokhead");?></head>
<body>
<?php if($multiple_language && $langlist){ ?>
<div id="c-language" data-lang="<?php echo $session['admin_lang_id'];?>">
	<div class="c-select clear">
		<p class="c-text fl"><?php echo $langlist[$session['admin_lang_id']];?></p>
		<i class="c-triangle fr"></i>
	</div>
	<ul class="c-option">
		<?php $tmpid["num"] = 0;$langlist=is_array($langlist) ? $langlist : array();$tmpid = array();$tmpid["total"] = count($langlist);$tmpid["index"] = -1;foreach($langlist as $key=>$value){ $tmpid["num"]++;$tmpid["index"]++; ?>
		<li data-lang="<?php echo $key;?>"><a href="javascript:update_lang('<?php echo $key;?>');void(0)"><?php echo $value;?></a></li>
		<?php } ?>
	</ul>
</div>
<?php } ?>
<div id="c-content">
	<div class="c-wrap clear">
		<form class="c-form fr" id="adminlogin" onsubmit="return admlogin()">
			<div class="qrcode-img" title="<?php echo P_Lang("扫码登录");?>"><img src="images/qr-code.png" /></div>
			<p class="c-title">Welcome</p>
			<div class="c-user">
				<span></span>
				<input type="text" name="user" tabindex="1" placeholder="<?php echo P_Lang("输入管理员账号");?>">
			</div>
			<!-- 密码 -->
			<div class="c-password">
				<span></span>
				<input type="password" name="pass" tabindex="2" placeholder="<?php echo P_Lang("输入管理员密码");?>">
			</div>
			<?php if($vcode){ ?>
			<div class="c-code">
				<span></span>
				<input type="text" name="_code" tabindex="3" placeholder="<?php echo P_Lang("验证码");?>" style="ime-mode:disabled">
				<div class="c-img">
					<img src="images/blank.gif" style="cursor:pointer;" id="src_code">
				</div>
			</div>
			<?php } ?>
			<div class="c-btn">
				<button type="submit"><?php echo P_Lang("管理员登录");?></button>
			</div>
		</form>
		<form class="c-form fr hide" id="admin-qrcode">
			<div class="qrcode-img2" title="<?php echo P_Lang("账号密码登录");?>"><img src="images/pc.png" /></div>
			<p class="c-title">Welcome</p>
			<div align="center">
				<div id="qrcode" style="width:300px;height:300px;"></div>
			</div>
			<div align="center" style="padding-top:10px;">打开手机进行扫码登录</div>
			<input type="hidden" id="qrcode-fid" value="" />
			<input type="hidden" id="qrcode-content" value="" />
		</form>
	</div>
</div>
<?php if($logo){ ?>
<div style="margin:35px;">
	<div class="logo"><img src="<?php echo $logo;?>" border="0" alt="<?php echo $config['title'];?>" style="width:300px;" /></div>
</div>
<?php } ?>
<?php if($vcode){ ?>
<script type="text/javascript">
$(document).ready(function(){
	window.setTimeout(function(){
		login_code('admin');
	}, 500);
	$("#src_code").click(function(){
		login_code('admin');
	})
});
</script>
<?php } ?>
<?php echo $app->_node_html("after");$app->plugin_html_ap("phpokbody");?></body>
</html>
