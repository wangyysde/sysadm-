<?php if(!defined("SYSADM_SET")){exit("<h1>Access Denied</h1>");} ?><?php $this->output("head_lay","file",true,false); ?>
<div class="layui-card">
	<div class="layui-card-header" style="height:auto;padding:10px 15px;">
		<div class="fr" style="margin-top:-4px;">
			<input type="button" value="添加" onclick="$.admin_search.add()" class="layui-btn layui-btn-sm" />
		</div>
		<form method="post" class="layui-form" id="post_save" action="<?php echo phpok_url(array('ctrl'=>'search'));?>" onsubmit="return $.admin_search.topcheck()">
		<ul class="layout">
			<li style="width:80px">
				<select name="psize">
					<option value=""><?php echo P_Lang("默认页码");?></option>
					<option value="50"<?php if($psize == 50){ ?> selected<?php } ?>>50</option>
					<option value="70"<?php if($psize == 70){ ?> selected<?php } ?>>70</option>
					<option value="90"<?php if($psize == 90){ ?> selected<?php } ?>>90</option>
					<option value="100"<?php if($psize == 100){ ?> selected<?php } ?>>100</option>
					<option value="150"<?php if($psize == 150){ ?> selected<?php } ?>>150</option>
					<option value="200"<?php if($psize == 200){ ?> selected<?php } ?>>200</option>
				</select>
			</li>
			<li>
				<select name="type">
					<option value=""><?php echo P_Lang("默认排序，最新排前");?></option>
					<option value="hot"<?php if($type == 'hot'){ ?> selected<?php } ?>>搜索次数多的排前</option>
					<option value="cold"<?php if($type == 'cold'){ ?> selected<?php } ?>>搜索次数少的排前</option>
					<option value="old"<?php if($type == 'old'){ ?> selected<?php } ?>>旧数据的排前</option>
				</select>
			</li>
			<li style="width:170px">
				<select name="sign">
				<option value=""><?php echo P_Lang("标记，默认全部");?></option>
				<option value="1"<?php if($sign == 1){ ?> selected<?php } ?>><?php echo P_Lang("已标记");?></option>
				<option value="2"<?php if($sign == 2){ ?> selected<?php } ?>><?php echo P_Lang("未标记");?></option>
				</select>
			</li>
			<li><input type="text" name="keywords" value="<?php echo $keywords;?>" placeholder="<?php echo P_Lang("输入要搜索的关键字");?>" class="layui-input" /></li>
			<li><div style="padding-top:3px;"><input type="submit" value="<?php echo P_Lang("搜索");?>" class="layui-btn layui-btn-sm" /></div></li>
			<?php if($keywords || $sign || $type){ ?>
			<li><div style="padding-top:3px;"><input type="button" value="<?php echo P_Lang("取消搜索");?>" onclick="$.phpok.go('<?php echo phpok_url(array('ctrl'=>'search'));?>')" class="layui-btn layui-btn-sm layui-btn-danger" /></div></li>
			<?php } ?>
		</ul>
		</form>
	</div>
	<div class="layui-card-body">
		<table class="layui-table">
		<thead>
		<tr>
			<th></th>
			<th><?php echo P_Lang("关键字");?></th>
			<th><?php echo P_Lang("搜索时间");?></th>
			<th><?php echo P_Lang("搜索次数");?></th>
			<th><?php echo P_Lang("是否标记");?></th>
			<th><?php echo P_Lang("操作");?></th>
		</tr>
		</thead>
		<?php $tmpid["num"] = 0;$rslist=is_array($rslist) ? $rslist : array();$tmpid = array();$tmpid["total"] = count($rslist);$tmpid["index"] = -1;foreach($rslist as $key=>$value){ $tmpid["num"]++;$tmpid["index"]++; ?>
		<tr>
			<td><input type="checkbox" name="ids[]" id="ids_<?php echo $value['id'];?>" value="<?php echo $value['id'];?>" /> <?php echo $value['id'];?></td>
			<td><?php echo $value['title'];?></td>
			<td><?php echo date('Y-m-d H:i:s',$value['dateline']);?></td>
			<td><?php echo $value['hits'];?></td>
			<td><?php if($value['sign']){ ?><?php echo P_Lang("已标记");?><?php } else { ?><span class="gray i">无</span><?php } ?></td>
			<td>
				<div class="layui-btn-group">
					<input type="button" value="<?php echo P_Lang("编辑");?>" onclick="$.admin_search.edit('<?php echo $value['id'];?>')" class="layui-btn layui-btn-sm" />
					<input type="button" value="<?php echo P_Lang("删除");?>" onclick="$.admin_search.del('<?php echo $value['id'];?>')" class="layui-btn layui-btn-sm layui-btn-danger" />
				</div>
			</td>
		</tr>
		<?php } ?>
		</table>
		<ul class="layout">
			<li>
				<div class="layui-btn-group">
					<input type="button" value="<?php echo P_Lang("全选");?>" onclick="$.checkbox.all()" class="layui-btn layui-btn-sm" />
					<input type="button" value="<?php echo P_Lang("全不选");?>" onclick="$.checkbox.none()" class="layui-btn layui-btn-sm" />
					<input type="button" value="<?php echo P_Lang("反选");?>" onclick="$.checkbox.anti()" class="layui-btn layui-btn-sm" />
				</div>
			</li>
			<li><input type="button" value="<?php echo P_Lang("删除");?>" onclick="$.admin_search.del()" class="layui-btn layui-btn-sm layui-btn-danger" /></li>
		</ul>
		<div align="center"><?php $this->output("pagelist","file",true,false); ?></div>
	</div>
</div>

<?php $this->output("foot_lay","file",true,false); ?>