<?php
/**
 * 网站前台_管理全球国家及州/省信息
 * @作者 phpok.com <admin@phpok.com>
 * @版权 深圳市锟铻科技有限公司
 * @主页 http://www.phpok.com
 * @版本 5.x
 * @许可 http://www.phpok.com/lgpl.html PHPOK开源授权协议：GNU Lesser General Public License
 * @时间 2019年05月27日 19时51分
**/
namespace phpok\app\control\worlds;
/**
 * 安全限制，防止直接访问
**/
if(!defined("SYSADM_SET")){
	exit("<h1>Access Denied</h1>");
}
class www_control extends \phpok_control
{
	public function __construct()
	{
		parent::control();
	}

	public function index_f()
	{
		$this->display('www_index');
	}
}
