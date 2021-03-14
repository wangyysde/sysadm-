/**
 * 后面页面脚本_启动相应的守护进程
 * @作者 phpok.com <admin@phpok.com>
 * @版权 深圳市锟铻科技有限公司
 * @主页 http://www.phpok.com
 * @版本 5.x
 * @许可 http://www.phpok.com/lgpl.html PHPOK开源授权协议：GNU Lesser General Public License
 * @时间 2020年06月02日 15时44分
**/
;(function($){
	$.admin_swoole = {
		config_save:function()
		{
			$("#post_save").ajaxSubmit({
				'url':get_url('swoole','save'),
				'type':'post',
				'dataType':'json',
				'success':function(rs){
					if(!rs.status){
						$.dialog.alert(rs.info);
						return true;
					}
					$.dialog.tips('参数保存成功').lock();
					return false;
				}
			});
			return false;
		},
		ws_start:function()
		{
			var url = get_url('swoole','start');
			$.phpok.json(url,function(rs){
				if(!rs.status){
					$.dialog.alert(rs.info);
					return false;
				}
				$.dialog.tips('守护进程开启成功',function(){
					$.phpok.reload();
				}).lock();
			});
		},
		ws_status:function()
		{
			var url = get_url('swoole','status');
			$.phpok.json(url,function(rs){
				$.dialog.tips(rs.info).lock();
			});
		},
		ws_stop:function()
		{
			$.dialog.confirm('确定要关闭 Swoole 守护进程吗？关闭后将可能影响直播及即时消息的监听',function(){
				var url = get_url('swoole','stop');
				$.phpok.json(url,function(rs){
					if(!rs.status){
						$.dialog.alert(rs.info);
						return false;
					}
					$.dialog.tips('守护进程关闭成功',function(){
						$.phpok.reload();
					}).lock();
				})
			});
		}
	}
})(jQuery);
