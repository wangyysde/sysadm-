<?php if(!defined("SYSADM_SET")){exit("<h1>Access Denied</h1>");} ?><?php $this->output("head_lay","file",true,false); ?>
<style type="text/css">
.layui-card-body{
	min-height:80px;
}
</style>
<div class="layui-row layui-col-space10">
	<div class="layui-col-xs12 layui-col-sm6 layui-col-md4 layui-col-lg3">
    	<div class="layui-card">
    		<div class="layui-card-header">
    			参数配置
    			<div class="fr">
	    			<input type="button" value="配置" onclick="$.win('微信参数配置','<?php echo phpok_url(array('ctrl'=>'weixin','func'=>'config'));?>')" class="layui-btn layui-btn-xs" />
    			</div>
    		</div>
    		<div class="layui-card-body clearfix">
    			配置微信公众号，小程序及开放平台的各类参数及密钥信息，包括证书文件
    		</div>
    	</div>
	</div>
	<div class="layui-col-xs12 layui-col-sm6 layui-col-md4 layui-col-lg3">
		<div class="layui-card">
    		<div class="layui-card-header">
    			微信会员
    			<div class="fr">
	    			<input type="button" value="查看" onclick="$.win('微信会员','<?php echo phpok_url(array('ctrl'=>'weixin','func'=>'userlist'));?>')" class="layui-btn layui-btn-xs" />
    			</div>
    		</div>
    		<div class="layui-card-body clearfix">
    			查看所有通过微信接口登录的会员（包括公众号，小程序及开放平台等）
    		</div>
    	</div>
	</div>
	<div class="layui-col-xs12 layui-col-sm6 layui-col-md4 layui-col-lg3">
		<div class="layui-card">
    		<div class="layui-card-header">
    			关注/取关事件
    			<div class="fr">
	    			<input type="button" value="查看" onclick="$.win('关注与取关','<?php echo phpok_url(array('ctrl'=>'weixin','func'=>'subscribe'));?>')" class="layui-btn layui-btn-xs" />
    			</div>
    		</div>
    		<div class="layui-card-body clearfix">
    			设置公众号关注通知和取消关注执行配置
    		</div>
    	</div>
	</div>
	<div class="layui-col-xs12 layui-col-sm6 layui-col-md4 layui-col-lg3">
		<div class="layui-card">
    		<div class="layui-card-header">
    			自动回复设置
    			<div class="fr">
	    			<input type="button" value="查看" onclick="$.win('自动回复设置','<?php echo phpok_url(array('ctrl'=>'weixin','func'=>'reply'));?>')" class="layui-btn layui-btn-xs" />
    			</div>
    		</div>
    		<div class="layui-card-body clearfix">
    			当用户发送消息给公众号时，开发者可以在响应包中自动对该消息进行回复（回复的信息会在消息管理中体现）
    		</div>
    	</div>
	</div>
	<div class="layui-col-xs12 layui-col-sm6 layui-col-md4 layui-col-lg3">
		<div class="layui-card">
    		<div class="layui-card-header">
    			群发消息
    			<div class="fr">
	    			<input type="button" value="查看" onclick="$.win('群发消息','<?php echo phpok_url(array('ctrl'=>'weixin','func'=>'mass_message'));?>')" class="layui-btn layui-btn-xs" />
    			</div>
    		</div>
    		<div class="layui-card-body clearfix">
    			在公众平台网站上，为订阅号提供了每天一条的群发权限，为服务号提供每月（自然月）4条的群发权限
    		</div>
    	</div>
	</div>
	<div class="layui-col-xs12 layui-col-sm6 layui-col-md4 layui-col-lg3">
		<div class="layui-card">
    		<div class="layui-card-header">
    			一次性订阅消息
    			<div class="fr">
	    			<input type="button" value="查看" onclick="$.win('一次性订阅消息','<?php echo phpok_url(array('ctrl'=>'weixin','func'=>'one_subscribe'));?>')" class="layui-btn layui-btn-xs" />
    			</div>
    		</div>
    		<div class="layui-card-body clearfix">
    			授权让微信用户授权第三方移动应用或公众号，获得发送一次订阅消息给到授权微信用户的机会。
    		</div>
    	</div>
	</div>
	<div class="layui-col-xs12 layui-col-sm6 layui-col-md4 layui-col-lg3">
		<div class="layui-card">
    		<div class="layui-card-header">
    			模板消息
    			<div class="fr">
	    			<input type="button" value="查看" onclick="$.win('模板消息','<?php echo phpok_url(array('ctrl'=>'weixin','func'=>'tpl_message'));?>')" class="layui-btn layui-btn-xs" />
    			</div>
    		</div>
    		<div class="layui-card-body clearfix">
    			用于公众号向用户发送重要的服务通知，只能用于符合其要求的服务场景中，如信用卡刷卡通知，商品购买成功通知等
    		</div>
    	</div>
	</div>
	<div class="layui-col-xs12 layui-col-sm6 layui-col-md4 layui-col-lg3">
		<div class="layui-card">
    		<div class="layui-card-header">
    			消息管理
    			<div class="fr">
	    			<input type="button" value="查看" onclick="$.win('微信消息','<?php echo phpok_url(array('ctrl'=>'weixin','func'=>'message'));?>')" class="layui-btn layui-btn-xs" />
    			</div>
    		</div>
    		<div class="layui-card-body clearfix">
    			查看微信好友发过来的所有消息及主动沟通发出去的消息
    		</div>
    	</div>
	</div>
	<div class="layui-col-xs12 layui-col-sm6 layui-col-md4 layui-col-lg3">
		<div class="layui-card">
    		<div class="layui-card-header">
    			临时素材管理
    			<div class="fr">
	    			<input type="button" value="查看" onclick="$.win('临时素材管理','<?php echo phpok_url(array('ctrl'=>'weixin','func'=>'media'));?>')" class="layui-btn layui-btn-xs" />
    			</div>
    		</div>
    		<div class="layui-card-body clearfix">
    			管理用于临时使用的素材，临时素材有效期只有三天，超过后将无效
    		</div>
    	</div>
	</div>
	<div class="layui-col-xs12 layui-col-sm6 layui-col-md4 layui-col-lg3">
		<div class="layui-card">
    		<div class="layui-card-header">
    			永久素材管理
    			<div class="fr">
	    			<input type="button" value="查看" onclick="$.win('永久素材管理','<?php echo phpok_url(array('ctrl'=>'weixin','func'=>'material'));?>')" class="layui-btn layui-btn-xs" />
    			</div>
    		</div>
    		<div class="layui-card-body clearfix">
    			管理用于临时使用的素材，临时素材有效期只有三天，超过后将无效
    		</div>
    	</div>
	</div>
</div>
<?php $this->assign("is_open","true"); ?><?php $this->output("foot_lay","file",true,false); ?>