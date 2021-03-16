<?php if(!defined("SYSADM_SET")){exit("<h1>Access Denied</h1>");} ?><?php $this->assign("nopadding","true"); ?><?php $this->assign("overflowy","true"); ?><?php $this->output("head_lay","file",true,false); ?>
<form method="post" id="post_save" onsubmit="return false">
<div class="layui-card">
	<div class="layui-card-body">
		<div class="layui-form-item">
			<label class="layui-form-label">
				<?php echo P_Lang("管理员账号");?>
			</label>
			<div class="layui-input-block gray" style="line-height:38px;">账号修改后需要重新登录</div>
			<div class="layui-input-block">
				<input type="text" id="name" name="name" class="layui-input" value="<?php echo $rs['account'];?>" />
			</div>
		</div>
		<div class="layui-form-item">
			<label class="layui-form-label">
				<?php echo P_Lang("管理员姓名");?>
			</label>
			<div class="layui-input-block">
				<input type="text" id="fullname" name="fullname" class="layui-input" value="<?php echo $rs['fullname'];?>" />
			</div>
		</div>
		<div class="layui-form-item">
			<label class="layui-form-label">
				<?php echo P_Lang("邮箱");?>
			</label>
			<div class="layui-input-block">
				<input type="text" id="email" name="email" class="layui-input" value="<?php echo $rs['email'];?>" />
			</div>
		</div>
	</div>
</div>
</form>
<?php $this->assign("is_open","true"); ?><?php $this->output("foot_lay","file",true,false); ?>