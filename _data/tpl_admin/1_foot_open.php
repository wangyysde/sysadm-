<?php if(!defined("SYSADM_SET")){exit("<h1>Access Denied</h1>");} ?><?php echo $app->plugin_html_ap("body");?>
<?php echo $app->plugin_html_ap("foot");?>
<script type="text/javascript">
$(document).ready(function(){
	var r_menu = [[{
		'text':'<?php echo P_Lang("刷新");?>',
		'func':function(){
			$.phpok.reload();
		}
	},{
		'text': "<?php echo P_Lang("新窗口打开");?>",
    	'func': function() {
	    	var url = window.location.href;
			//去除随机数
			url = url.replace(/\_noCache=[0-9\.]+/g,'');
			if(url.substr(-1) == '&' || url.substr(-1) == '?'){
				url = url.substr(0,url.length-1);
			}
			window.open(url);
	    }
	},{
		'text':'<?php echo P_Lang("帮助说明");?>',
		'func':function(){
			var url = window.location.href;
			//去除随机数
			url = url.replace(/\_noCache=[0-9\.]+/g,'');
			if(url.substr(-1) == '&' || url.substr(-1) == '?'){
				url = url.substr(0,url.length-1);
			}
			var tip = '<?php echo P_Lang("网址：");?>'+url+'<br /><div style="text-indent:36px"><a href="'+url+'" target="_blank" class="red"><?php echo P_Lang("新窗口打开");?></a></div>';
			tip += '<div style="text-indent:36px"><?php echo P_Lang("复制请按快捷键：CTRL+C，粘贴请使用：CTRL+V");?></div>';
			top.$.dialog({
				'title':'<?php echo P_Lang("帮助说明");?>',
				'content':tip,
				'lock':true,
				'drag':false,
				'fixed':true
			});
		}
	}]];
	$(window).smartMenu(r_menu,{
		'name':'smart',
		'textLimit':8
	});
});
</script>
<?php echo $app->_node_html("after");$app->plugin_html_ap("phpokbody");?></body>
</html>