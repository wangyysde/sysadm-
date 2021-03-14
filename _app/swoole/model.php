<?php
/**
 * 模型内容信息_启动相应的守护进程
 * @作者 phpok.com <admin@phpok.com>
 * @版权 深圳市锟铻科技有限公司
 * @主页 http://www.phpok.com
 * @版本 5.x
 * @许可 http://www.phpok.com/lgpl.html PHPOK开源授权协议：GNU Lesser General Public License
 * @时间 2020年06月02日 15时44分
**/
namespace phpok\app\model\swoole;
/**
 * 安全限制，防止直接访问
**/
if(!defined("SYSADM_SET")){
	exit("<h1>Access Denied</h1>");
}
class model extends \phpok_model
{
	public function __construct()
	{
		parent::model();
	}

	public function config_save($data)
	{
		$this->lib('file')->vi($data,$this->dir_data.'swoole_config.php','config');
		return true;
	}

	public function config_get()
	{
		if(file_exists($this->dir_data.'swoole_config.php')){
			include($this->dir_data.'swoole_config.php');
			return $config;
		}
		return array('phpexec'=>'php');
	}
}
