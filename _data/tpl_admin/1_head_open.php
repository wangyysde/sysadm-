<?php if(!defined("SYSADM_SET")){exit("<h1>Access Denied</h1>");} ?><!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" />
	<meta name="author" content="phpok.com" />
	<meta http-equiv="expires" content="wed, 26 feb 1997 08:21:57 gmt"> 
	<title><?php echo $config['title'];?></title>
	<?php if($config['favicon']){ ?>
	<link rel="shortcut icon" href="<?php echo $config['favicon'];?>" />
	<?php } ?>
	<link rel="stylesheet" type="text/css" href="css/css.php?type=open&version=<?php echo VERSION;?>" />
	<?php echo phpok_head_css();?>
	<?php $js_ext = 'admin.'.$sys['ctrl'].'.js';?>
	<script type="text/javascript" src="js/laydate/laydate.js"></script>
	<script type="text/javascript" src="<?php echo phpok_url(array('ctrl'=>'js','ext'=>$js_ext));?>"></script>
	<?php echo phpok_head_js();?>
	<?php echo $app->plugin_html_ap("head");?>
<?php echo $app->_node_html("before");$app->plugin_html_ap("phpokhead");?></head>
<body ondragstart="return false;">