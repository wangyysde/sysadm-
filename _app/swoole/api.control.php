<?php
/**
 * 接口应用_启动相应的守护进程
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
class api_control extends \phpok_control
{
	private $server;
	private $host = "0.0.0.0";
	private $port = 9502;
	public function __construct()
	{
		parent::control();
	}

	public function index_f()
	{
		if(!$this->is_cmd()){
			exit('Command execution only');
		}
		$config = $this->model('swoole')->config_get();
		if(!$config){
			$config = array();
		}
		if(!$config['port']){
			$config['port'] = '9502';
		}
		$this->port = $config['port'];
		if($config['wstype'] == 'wss'){
			$this->server = new \swoole_websocket_server($this->host, $this->port,SWOOLE_PROCESS, SWOOLE_SOCK_TCP | SWOOLE_SSL);
		}else{
			$this->server = new \swoole_websocket_server($this->host, $this->port);
		}
		//socket链接的回调函数
		$this->server->on('open', function (\swoole_websocket_server $server, \swoole_http_request $request) {
			//
		});
		//socket发送信息回调函数
		$this->server->on('message', function (\swoole_websocket_server $server, \swoole_websocket_frame $frame) {
			$this->onMessage($server, $frame);
		});
		
		//socket关闭回调函数
		$this->server->on('close', function (\swoole_websocket_server $server, $fd) {
			$this->onClose($server, $fd);
		});
		
		//request方法回调函数
		$this->server->on('request', function (\swoole_http_request $request, \swoole_http_response $response) {
			$this->onRequest($this->server,$request,$response);
		});
		
		//异步任务指派回调方法
		$this->server->on('Task', function (\swoole_server $server, $task_id, $from_id,  $data) {
			$this->onTask($server,$task_id,$data);
		});
		
		//异步任务处理完成回调方法
		$this->server->on('Finish', function (\swoole_server $server, $task_id, $data) {
			$this->onFinish($server, $task_id, $data);
		});

		$this->server->on('workerStart', function(\swoole_server $serv, $worker_id) {
			global $argv;
			if($worker_id >= $this->server->setting['worker_num']) {
				swoole_set_process_name("php {$argv[0]}: task_worker");
			} else {
				swoole_set_process_name("php {$argv[0]}: worker");
			}
		});
		$data = array('daemonize'=>1);
		$data['worker_num'] = $config['worker_num'] ? $config['worker_num'] : 1;
		$data['max_request'] = $config['max_request'] ? $config['max_request'] : 50;
		if($config['task_worker_num']){
			$data['task_worker_num'] = $config['task_worker_num'];
		}
		
		if($config['wstype'] == 'wss'){
			$data['ssl_cert_file'] = $this->dir_root.$config['publickey'];
			$data['ssl_key_file'] = $this->dir_root.$config['privatekey'];
		}
		$this->server->set($data);
		//执行计划任务
		if($config['task_worker_num'] && $config['task_worker_link']){
			$process = new \swoole_process(function($process) use($config){
				//定时请求链接
				$time = $config['task_worker_time'];
				if(!$time){
					$time = 3;
				}
				$mytime = $time * 1000;
				swoole_timer_tick ($mytime, function () use ($config){
					$curl = curl_init();
					$headers = array();
					$headers[] = 'Expect:';
					curl_setopt($curl, CURLOPT_FORBID_REUSE, true);
					curl_setopt($curl, CURLOPT_HEADER,true);
					curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
					curl_setopt($curl, CURLOPT_HTTPGET,true);
					curl_setopt($curl, CURLOPT_CONNECTTIMEOUT,10);//等待时间，超时退出
					curl_setopt($curl, CURLOPT_TIMEOUT,10);
					$url = $config['task_worker_link'];
					$info = parse_url($url);
					if($config['task_worker_ip']){
						$string = $info['scheme'].'://'.$info['host'];
						$url = $info['scheme'].'://127.0.0.1'.substr($url,strlen($string));
					}
					$port = $info['port'] ? $info['port'] : ($info['scheme'] == 'https' ? '443' : '80');
					$headers[] = 'Host: '.$info['host'].':'.$port;
					curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
					curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
					curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
					curl_setopt($curl, CURLOPT_URL, $url);
					curl_exec($curl);
					curl_close($curl);
					echo 'ok';
					echo "\n";
				});  
			});
			$this->server->addProcess($process);
		}
		$this->server->start();
	}

	public function stop_f(){
		if(!$this->is_cmd()){
			exit('Command execution only');
		}
		$this->server->shutdown();
	}

	public function restart_f(){
		if(!$this->is_cmd()){
			exit('Command execution only');
		}
		$this->server->restart();
	}

	private function message($server,$frame,$info='')
	{
		$data = array('status'=>true,'type'=>'message','info'=>$info['msg']);
		$server->push($frame->fd,$this->lib('json')->encode($data));
	}

	/**
	 * 信息回调方法
	 * @param \swoole_websocket_server $server
	 * @param \swoole_websocket_frame $frame
	 */
	protected function onMessage(\swoole_websocket_server $server, \swoole_websocket_frame $frame){
		//格式化数据
		if (!empty($frame) && $frame->opcode == 1 && $frame->finish == 1) {
			$info = $this->lib('json')->decode($frame->data);
			if(!$info){
				return false;
			}
			$app_id = $info['app_id'] ? $info['app_id'] : 'api';
			$ctrl_id = $info['ctrl'] ? $info['ctrl'] : 'swoole';
			$func = $info['func'] ? $info['func'] : 'message';
			$this->control($ctrl_id,$app_id)->$func($server,$frame,$info);
			return true;
        }
        return false;
	}

	/**
	 * request 回调方
	 * @param \swoole_websocket_server $server
	 * @param \swoole_http_request $request
	 * @param \swoole_http_response $response
	 */
	protected function onRequest(\swoole_websocket_server $server, \swoole_http_request $request,\swoole_http_response $response){
		/*$request_uri=trim($request->server['request_uri'],"/");
        $par=explode("/",$request_uri);
        $tag=$par[0];
        if($tag=='manager'){
            $controller=$par[0]; //接口控制器
            $action=$par[1]; //接口方法
            if(!$controller || !$action){
                $response->end(json_encode(array('errmsg'=>"url  not find ",'errno'=>500)));
            }
        }elseif($tag=='api'){
            $version=$par[1]; //版本
            $controller=str_replace(".html","",$par[2]); //接口控制器

            if(!$controller || !$version){
                $response->end(json_encode(array('errmsg'=>"url  not find ",'errno'=>501)));
            }
            $action=$controller.'_'.$version;
        }

        $A= $this->loadclass($controller);
        if(!method_exists($A,$action)){
            $response->end(json_encode(array('errmsg'=>"url  not find ",'errno'=>503)));return ;
        }
        $A->$action($server,$request,$response);*/
	}
	
	/**
	 * socket关闭回调方
	 */
	protected function onClose(\swoole_websocket_server $server, $fd){
		phpok_log("client {$fd} closed {$server}");
	}

	/**
	 * 异步任务回调
	 * @param \swoole_websocket_server $server
	 * @param \swoole_websocket_frame $frame
	 */
	protected function onTask(\swoole_websocket_server $server,$task_id,$data){
		phpok_log("Tasker进程接收到数据#{$server->worker_id}\tonTask: [PID={$server->worker_pid}]: task_id=$task_id, data_len=".strlen($data).".".PHP_EOL);
		$data=json_decode($data,true);
		phpok_log($data);
	}

	protected function onFinish(\swoole_websocket_server $server,$task_id,$data){
		phpok_log("结束进程接收到数据#{$server->worker_id}\tonTask: [PID={$server->worker_pid}]: task_id=$task_id, data_len=".strlen($data).".".PHP_EOL);
		$data=json_decode($data,true);
		phpok_log($data);
	}
}
