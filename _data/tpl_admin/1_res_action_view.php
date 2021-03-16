<?php if(!defined("SYSADM_SET")){exit("<h1>Access Denied</h1>");} ?><?php $this->output("head_open","file",true,false); ?>
<div style="margin-top:3px;"><img src="<?php echo $rs['filename'];?>" onload="javascript:if(this.width>600)this.width=600;"></div>
<?php $rs_gd_id["num"] = 0;$rs['gd']=is_array($rs['gd']) ? $rs['gd'] : array();$rs_gd_id = array();$rs_gd_id["total"] = count($rs['gd']);$rs_gd_id["index"] = -1;foreach($rs['gd'] as $key=>$value){ $rs_gd_id["num"]++;$rs_gd_id["index"]++; ?>
<div style="margin-top:3px;"><img src="<?php echo $value['filename'];?>" onload="javascript:if(this.width>600)this.width=600;"></div>
<?php } ?>

<?php $this->output("foot_open","file",true,false); ?>