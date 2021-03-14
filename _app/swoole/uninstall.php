<?php
/**
 * 卸载文件_启动相应的守护进程
 * @作者 phpok.com <admin@phpok.com>
 * @版权 深圳市锟铻科技有限公司
 * @主页 http://www.phpok.com
 * @版本 5.x
 * @许可 http://www.phpok.com/lgpl.html PHPOK开源授权协议：GNU Lesser General Public License
 * @时间 2020年06月02日 15时44分
**/
/**
 * 安全限制，防止直接访问
**/
if(!defined("SYSADM_SET")){
	exit("<h1>Access Denied</h1>");
}
//phpok_loadsql($this->db,$this->dir_app.'swoole/uninstall.sql',true);
$sql = "SELECT * FROM ".$this->db->prefix."sysmenu WHERE appfile='swoole'";
$rs = $this->db->get_one($sql);
if($rs){
	$sql = "DELETE FROM ".$this->db->prefix."popedom WHERE gid='".$rs['id']."'";
	$this->db->query($sql);
	$sql = "DELETE FROM ".$this->db->prefix."sysmenu WHERE id='".$rs['id']."'";
	$this->db->query($sql);
}
