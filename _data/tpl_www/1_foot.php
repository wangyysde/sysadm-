<?php if(!defined("SYSADM_SET")){exit("<h1>Access Denied</h1>");} ?><?php echo phpok_head_css();?>
<?php echo phpok_head_js();?>
<script type="text/javascript" src="static/bootstrap/js/bootstrap.bundle.min.js" charset="utf-8"></script>
<script type="text/javascript" src="static/wow/wow.min.js" charset="utf-8"></script>
<script type="text/javascript" src="js/highlighter/shcore.js" charset="utf-8"></script>
<script type="text/javascript" src="static/bootstrap/www/common.js" charset="utf-8"></script>
<script type="text/javascript" src="tpl/www/js/global.js" charset="utf-8" charset="utf-8"></script>
<?php if($js){ ?>
<?php $jslist = explode(",",$js);?>
<?php $tmpid["num"] = 0;$jslist=is_array($jslist) ? $jslist : array();$tmpid = array();$tmpid["total"] = count($jslist);$tmpid["index"] = -1;foreach($jslist as $key=>$value){ $tmpid["num"]++;$tmpid["index"]++; ?>
<script type="text/javascript" src="<?php echo $value;?>" charset="utf-8"></script>
<?php } ?>
<?php } ?>
<script type="text/javascript">
$(document).ready(function(){
	SyntaxHighlighter.config['space'] = "&nbsp;";
	SyntaxHighlighter.config['quick-code'] = false
	SyntaxHighlighter.all();
	$("input[type=text],input[type=password],input[type=email],input[type=tel],select").addClass("form-control");
	$("input[type=checkbox],input[type=radio]").addClass("form-check-input");
});
</script>
<?php if($config['code'] && $config['code']['statjs']){ ?>
<div style="display:none"><?php echo $config['code']['statjs'];?></div>
<?php } ?>
<!-- <?php echo debug_time();?> -->
<?php echo $app->_node_html("after");$app->plugin_html_ap("phpokbody");?></body>
</html>