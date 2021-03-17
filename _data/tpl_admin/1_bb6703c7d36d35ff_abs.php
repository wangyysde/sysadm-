<?php if(!defined("SYSADM_SET")){exit("<h1>Access Denied</h1>");} ?><?php $this->output("head_lay","file",true,false); ?>
<div class="layui-card">
	<div class="layui-card-header">
		<div class="layui-btn-group fr">
			<button type="button" onclick="$.win('<?php echo P_Lang("创建优惠码");?>','<?php echo phpok_url(array('ctrl'=>'coupon','func'=>'set'));?>')" class="layui-btn layui-btn-sm">
				<?php echo P_Lang("创建优惠码");?>
			</button>
			<button type="button" class="layui-btn layui-btn-sm" onclick="$.win('<?php echo P_Lang("使用记录");?>','<?php echo phpok_url(array('ctrl'=>'coupon','func'=>'used'));?>')">
				<?php echo P_Lang("使用记录");?>
			</button>
			<button type="button" class="layui-btn layui-btn-sm" onclick="$.win('<?php echo P_Lang("会员优惠券");?>','<?php echo phpok_url(array('ctrl'=>'coupon','func'=>'users'));?>')">
				<?php echo P_Lang("会员优惠券");?>
			</button>
		</div>
	</div>
	<div class="layui-card-body">
		<table class="layui-table">
		<thead>
		<tr>
			<th>ID</th>
			<th width="20"></th>
			<th><?php echo P_Lang("类型");?></th>
			<th><?php echo P_Lang("优惠码");?></th>
			<th><?php echo P_Lang("开始/结束日期");?></th>
			<th><?php echo P_Lang("优惠");?></th>
			<th><?php echo P_Lang("使用次数");?></th>
			<th><?php echo P_Lang("排序");?></th>
			<th><?php echo P_Lang("其他");?></th>
			<th></th>
		</tr>
		</thead>
		<?php $tmpid["num"] = 0;$rslist=is_array($rslist) ? $rslist : array();$tmpid = array();$tmpid["total"] = count($rslist);$tmpid["index"] = -1;foreach($rslist as $key=>$value){ $tmpid["num"]++;$tmpid["index"]++; ?>
		<tr>
			<td><?php echo $value['id'];?></td>
			<td><span id="status_<?php echo $value['id'];?>" onclick="$.admin_coupon.status(<?php echo $value['id'];?>)" class="status<?php echo $value['status'];?>" value="<?php echo $value['status'];?>"></span></td>
			<td><?php if($value['types'] == 'user'){ ?><?php echo P_Lang("会员");?><?php } else { ?><?php echo P_Lang("主题");?><?php } ?></td>
			<td><?php echo $value['title'];?><br/><?php echo $value['code'];?></td>
			<td>
				<?php if($value['startdate']){ ?><?php echo date('Y-m-d',$value['startdate']);?><?php } ?>
				<?php if($value['startdate'] && $value['stopdate']){ ?> 至 <?php } ?>
				<?php if($value['stopdate']){ ?><?php echo date('Y-m-d',$value['stopdate']);?><?php } ?>
			</td>
			<td>
				<?php echo $value['discount_val'];?><?php if($value['discount_type']){ ?> <?php echo P_Lang("元");?><?php } else { ?>%<?php } ?>
				<?php if($value['min_price']){ ?><div class="gray"><?php echo P_Lang("最低金额");?><?php echo P_Lang("：");?><?php echo round($value['min_price'],'2');?></div><?php } ?>
			</td>
			<td><?php if($value['times']<0){ ?><?php echo P_Lang("不限");?><?php } else { ?><?php echo $value['times'];?> <?php echo P_Lang("次");?><?php } ?></td>
			<td class="hand" onclick="$.admin_coupon.taxis('<?php echo $value['id'];?>',this)"><?php echo $value['taxis'];?></td>
			<td>
				<?php if($value['types'] == 'list'){ ?>
					<div><?php echo P_Lang("频次");?><?php echo P_Lang("：");?><?php echo $value['freq_title'];?></div>
					<div><?php echo P_Lang("活动时间");?><?php echo P_Lang("：");?>
						<?php if($value['time_start']){ ?><?php echo date('H:i:s',$value['time_start']);?><?php } ?>
						<?php if($value['time_start'] && $value['time_stop']){ ?> - <?php } ?>
						<?php if($value['time_stop']){ ?><?php echo date('H:i:s',$value['time_stop']);?><?php } ?>
					</div>
				<?php } ?>
				<?php if($value['types'] == 'user'){ ?>
				
				<?php } ?>
			</td>
			<td>
				<div class="layui-btn-group">
					<input type="button" value="<?php echo P_Lang("编辑");?>" onclick="$.win('<?php echo P_Lang("编辑优惠码");?>_#<?php echo $value['id'];?>','<?php echo phpok_url(array('ctrl'=>'coupon','func'=>'set','id'=>$value['id']));?>')" class="layui-btn layui-btn-sm" />
					<input type="button" value="<?php echo P_Lang("删除");?>" onclick="$.admin_coupon.del('<?php echo $value['id'];?>','<?php echo $value['code'];?>')" class="layui-btn layui-btn-sm layui-btn-danger" />
				</div>
			</td>
		</tr>
		<?php } ?>
		</table>
	</div>
</div>
<?php $this->output("foot_lay","file",true,false); ?>