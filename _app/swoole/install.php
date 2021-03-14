<?php
/**
 * 安装文件_启动相应的守护进程
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
//phpok_loadsql($this->db,$this->dir_app.'swoole/install.sql',true);
//增加导航菜单
$menu = array('parent_id'=>5,'title'=>'守护进程','status'=>1);
$menu['appfile'] = 'swoole';
$menu['taxis'] = 255;
$menu['site_id'] = 0;
$menu['icon'] = 'newtab';
$insert_id = $this->model('sysmenu')->save($menu);
if($insert_id){
	$tmparray = array('gid'=>$insert_id,'title'=>'查看','identifier'=>'list','taxis'=>10);
	$this->model('popedom')->save($tmparray);
	$tmparray = array('gid'=>$insert_id,'title'=>'配置','identifier'=>'setting','taxis'=>20);
	$this->model('popedom')->save($tmparray);
	$tmparray = array('gid'=>$insert_id,'title'=>'删除','identifier'=>'delete','taxis'=>30);
	$this->model('popedom')->save($tmparray);
}
