<?php
/**
 * 接入节点_启动相应的守护进程
 * @作者 phpok.com <admin@phpok.com>
 * @版权 深圳市锟铻科技有限公司
 * @主页 http://www.phpok.com
 * @版本 5.x
 * @许可 http://www.phpok.com/lgpl.html PHPOK开源授权协议：GNU Lesser General Public License
 * @时间 2020年06月02日 15时44分
**/
namespace phpok\app\swoole;
/**
 * 安全限制，防止直接访问
**/
if(!defined("SYSADM_SET")){
	exit("<h1>Access Denied</h1>");
}
class nodes_phpok extends \_init_auto
{
	public function __construct()
	{
		parent::__construct();
	}

	public function PHPOK_arclist()
	{
		//这里开始编写PHP代码
	}

	public function PHPOK_arc()
	{
		$config = $this->model('swoole')->config_get();
		if(!$config){
			$config = array();
		}
		if(!$config['wstype']){
			$config['wstype'] = 'ws';
		}
		if(!$config['port']){
			$config['port'] = '9502';
		}
		$this->assign('swoole_config',$config);
	}

	public function PHPOK_project()
	{
		//这里开始编写PHP代码
	}

	public function PHPOK_catelist()
	{
		//这里开始编写PHP代码
	}

	public function PHPOK_cate()
	{
		//这里开始编写PHP代码
	}

}
