<?php
/**
 * 后台管理_启动相应的守护进程
 * @作者 phpok.com <admin@phpok.com>
 * @版权 深圳市锟铻科技有限公司
 * @主页 http://www.phpok.com
 * @版本 5.x
 * @许可 http://www.phpok.com/lgpl.html PHPOK开源授权协议：GNU Lesser General Public License
 * @时间 2020年06月02日 15时44分
**/
namespace phpok\app\control\swoole;
/**
 * 安全限制，防止直接访问
**/
if(!defined("SYSADM_SET")){
	exit("<h1>Access Denied</h1>");
}
class admin_control extends \phpok_control
{
	private $popedom;
	public function __construct()
	{
		parent::control();
		$this->popedom = appfile_popedom('swoole');
		$this->assign("popedom",$this->popedom);
	}

	public function index_f()
	{
		$swoole_start = $this->_swoole() ? true : false;
		$this->assign('swoole_start',$swoole_start);
		$config = $this->model('swoole')->config_get();
		$this->assign('rs',$config);
		$this->display('admin_index');
	}

	public function save_f()
	{
		$data = array();
		$data['phpexec'] = $this->get('phpexec');
		if(!$data['phpexec']){
			$data['phpexec'] = 'php';
		}
		$data['wstype'] = $this->get('wstype');
		$data['publickey'] = $this->get('publickey');
		$data['privatekey'] = $this->get('privatekey');
		if($data['wstype'] == 'wss'){
			if(!$data['publickey']){
				$this->error(P_Lang('公钥证书不能为空'));
			}
			if(!$data['privatekey']){
				$this->error(P_Lang('私钥证书不能为空'));
			}
		}
		$data['port'] = $this->get('port');
		$data['work_num'] = $this->get('work_num');
		$data['max_request'] = $this->get('max_request');
		$data['task_worker_num'] = $this->get('task_worker_num');
		$data['task_worker_link'] = $this->get('task_worker_link');
		$data['task_worker_time'] = $this->get('task_worker_time','int');
		$data['task_worker_ip'] = $this->get('task_worker_ip');
		$this->model('swoole')->config_save($data);
		$this->success();
	}

	public function start_f()
	{
		if(!$this->session->val('admin_rs.if_system')){
			$this->error('仅限系统管理员才有此权限');
		}
		$list = $this->_swoole();
		if($list){
			$this->error(P_Lang('Swoole 已启动'));
		}
		$config = $this->model('swoole')->config_get();
		$string = $config['phpexec'].' '.$this->dir_root.'api.php c=swoole';
		phpok_log($string);
		exec($string);
		$tlist = $this->_swoole();
		if(!$tlist){
			$this->error(P_Lang('Swoole 启动未成功，请稍候检测'));
		}
		$this->success();
	}

	public function status_f()
	{
		$list = $this->_swoole();
		if($list){
			$this->success(P_Lang('Swoole 已启动'));
		}
		$this->success(P_Lang('Swoole 未启动'));
	}

	public function stop_f()
	{
		if(!$this->session->val('admin_rs.if_system')){
			$this->error('仅限系统管理员才有此权限');
		}
		$list = $this->_swoole();
		if(!$list){
			$this->error(P_Lang('Swoole 尚未启动'));
		}
		$ids = array();
		foreach($list as $key=>$value){
			$tmp = explode(" ",$value);
			$string = "kill -9 ".$tmp[1];
			exec($string);
		}
		$this->success();
	}

	private function _swoole()
	{
		$list = array();
		exec("ps aux|grep swoole",$list);
		if(!$list){
			return false;
		}
		foreach($list as $key=>$value){
			if(!$value || !trim($value)){
				unset($list[$key]);
				continue;
			}
			$value = trim($value);
			$value = preg_replace("/(\x20{2,})/"," ",$value);
			if(strpos($value,'api.php') === false && strpos($value,'c=swoole') === false){
				unset($list[$key]);
				continue;
			}
			$list[$key] = $value;
		}
		if($list){
			return $list;
		}
		return false;
	}
}
