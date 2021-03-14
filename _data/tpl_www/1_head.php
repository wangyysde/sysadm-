<?php if(!defined("SYSADM_SET")){exit("<h1>Access Denied</h1>");} ?><!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=Edge,chrome=1" />
	<meta http-equiv="Cache-control" content="no-cache,no-store,must-revalidate" />
	<meta http-equiv="Pragma" content="no-cache" />
	<meta http-equiv="Expires" content="-1" />
	<meta name="renderer" content="webkit" />
	<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no" />
	<title><?php if($title){ ?><?php echo $title;?>_<?php } ?><?php if($seo['title']){ ?><?php echo $seo['title'];?>_<?php } ?><?php echo $config['title'];?></title>
	<?php if($seo['keywords']){ ?><meta name="keywords" content="<?php echo $seo['keywords'];?>" /><?php } ?>
	<?php if($seo['description']){ ?><meta name="description" content="<?php echo $seo['description'];?>" /><?php } ?>
	<meta name="toTop" content="true" />
	<?php echo $config['meta'];?>
	<base href="<?php echo $sys['url'];?>" />
	<link rel="stylesheet" type="text/css" href="static/bootstrap/css/bootstrap.min.css" />
	<link rel="stylesheet" type="text/css" href="static/fontawesome/css/font-awesome.min.css" />
	<link rel="stylesheet" type="text/css" href="css/artdialog.css" />
	<link rel="stylesheet" type="text/css" href="static/bootstrap/www/common.css" />
	<link rel="stylesheet" type="text/css" href="static/wow/animate.css" />
	<link rel="stylesheet" type="text/css" href="tpl/www/css/common.css" />
	<link rel="stylesheet" type="text/css" href="js/highlighter/shcore.css" />
	<link rel="stylesheet" type="text/css" href="js/highlighter/midnight.css" />
	<?php if($config['favicon']){ ?>
	<link rel="shortcut icon" href="<?php echo $config['favicon'];?>" />
	<?php } ?>
	<?php if($css){ ?>
	<?php $csslist = explode(",",$css);?>
	<?php $tmpid["num"] = 0;$csslist=is_array($csslist) ? $csslist : array();$tmpid = array();$tmpid["total"] = count($csslist);$tmpid["index"] = -1;foreach($csslist as $key=>$value){ $tmpid["num"]++;$tmpid["index"]++; ?>
	<link rel="stylesheet" type="text/css" href="<?php echo $value;?>" />
	<?php } ?>
	<?php } ?>
	<script type="text/javascript" src="<?php echo phpok_url(array('ctrl'=>'js','ext'=>'jquery.artdialog'));?>" charset="utf-8"></script>
	<?php if($js){ ?>
	<?php $jslist = explode(",",$js);?>
	<?php $tmpid["num"] = 0;$jslist=is_array($jslist) ? $jslist : array();$tmpid = array();$tmpid["total"] = count($jslist);$tmpid["index"] = -1;foreach($jslist as $key=>$value){ $tmpid["num"]++;$tmpid["index"]++; ?>
	<script type="text/javascript" src="<?php echo $value;?>" charset="utf-8"></script>
	<?php } ?>
	<?php } ?>
<?php echo $app->_node_html("before");$app->plugin_html_ap("phpokhead");?></head>
<body>
