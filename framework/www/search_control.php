<?php
/**
 * 搜索，支持自定义扩展字段
 * @作者 qinggan <admin@phpok.com>
 * @版权 深圳市锟铻科技有限公司
 * @主页 http://www.phpok.com
 * @版本 5.x
 * @授权 http://www.phpok.com/lgpl.html 开源授权协议：GNU Lesser General Public License
 * @时间 2020年7月4日
**/

if(!defined("SYSADM_SET")){exit("<h1>Access Denied</h1>");}
class search_control extends phpok_control
{
	public function __construct()
	{
		parent::control();
	}

	public function index_f()
	{
		//查询
		$keywords = $this->get('keywords');
		$id = $this->get('id');
		$cateid = $this->get('cateid','int');
		$cate = $this->get('cate');
		$ext = $this->get('ext');
		if($keywords){
			$keywords = str_replace(array("　","，",",","｜","|","、","/","\\","／","＼","+","＋")," ",$keywords);
			$keywords = trim($keywords);
		}
		$project = array();
		if($id){
			$project = $this->model('project')->get_one($id,false);
		}
		$cate_rs = array();
		if($cate){
			$cate_rs = $this->model('cate')->get_one($cate,'identifier',false);
		}
		if($cateid){
			$cate_rs = $this->model('cate')->get_one($cateid,'id',false);
		}
		if($keywords || $project || $cate_rs || $ext){
			$this->load_search($keywords,$project,$cate_rs,$ext);
		}
		$tplfile = $this->model('site')->tpl_file($this->ctrl,$this->func);
		if(!$tplfile){
			$tplfile = 'search_index';
		}
		$this->plugin('ap-load-search');
		$this->view($tplfile);
	}

	private function load_search($keywords='',$project='',$cate_rs='',$ext='')
	{
		$pageurl = $this->url('search');
		if(strpos($pageurl,'?') === false){
			$pageurl .= "?";
		}else{
			$pageurl .= "&";
		}
		$kc = array();
		$kc_ext = array();
		$my_mids = array();
		if($project && is_array($project)){
			$condition .= "l.project_id='".$project['id']."' AND l.module_id='".$project['module']."'";
			$pageurl .= "id=".$project['identifier']."&";
			$this->assign('page_rs',$project);
			if($cate_rs){
				$cate_ids = array($cate_rs['id']);
				$this->model('cate')->get_sonlist_id($cate_ids,$cate_rs['id'],1);
				$condition .= " AND l.cate_id IN(".implode(",",$cate_ids).") ";
				$pageurl .= "cateid=".$cate_rs['id']."&";
				$this->assign('cateid',$cateid);
				$this->assign('cate_rs',$cate_rs);
				if($cate_rs['parent_id'] && $cate_rs['parent_id'] != $project['cate']){
					$cate_parent_rs = $this->call->phpok('_cate',array('pid'=>$project['id'],'cateid'=>$cate_rs['parent_id']));
					if(!$cate_parent_rs || !$cate_parent_rs['status']){
						$this->error(P_Lang('父级分类已停用，请联系管理员'));
					}
					$this->assign('cate_parent_rs',$cate_parent_rs);
				}
			}
			if($ext){
				$sql = "SELECT id FROM ".$this->db->prefix."list_".$project['module']." WHERE project_id='".$project['id']."' ";
				foreach($ext as $key=>$value){
					$sql.= " AND ".$key."='".$value."' ";
					$pageurl .= "ext[".$key."]=".rawurlencode($value)."&";
				}
				$condition .= " AND l.id IN(".$sql.") ";
				$this->assign('ext',$ext);
			}
		}else{
			//取得符合搜索的项目
			$condition = "status=1 AND hidden=0 AND is_search !=0 AND module>0";
			$list = $this->model('project')->project_all($this->site['id'],'id',$condition);
			if(!$list){
				$this->error(P_Lang('您的网站没有允许可以搜索的信息'),$this->url,10);
			}
			$pids = $mids = $projects = array();
			foreach($list as $key=>$value){
				$pids[] = $value["id"];
				$mids[] = $value['module'];
				$projects[$value['id']] = $value['identifier'];
			}
			$mids = array_unique($mids);
			$condition = "l.project_id IN(".implode(",",$pids).") AND l.module_id IN(".implode(",",$mids).") ";
			if($keywords){
				foreach($mids as $key=>$value){
					$module = $this->model('module')->get_one($value);
					if($module && !$module['mtype'] && $module['tbl'] == 'list'){
						$my_mids[] = $module['id'];
						$flist = $this->model('fields')->flist($module['id']);
						if($flist){
							foreach($flist as $k=>$v){
								if($v['search'] == 1){
									$kc_ext[$value][] = " ext.".$v['identifier']."='".$keywords."' ";
								}elseif($v['search'] == 2){
									$kc_ext[$value][] = " ext.".$v['identifier']." LIKE '%".str_replace(' ','%',$keywords)."%' ";
								}
							}
						}
					}
				}
			}
		}
		$this->assign('searchurl',substr($pageurl,0,-1));
		if($keywords){
			$klist = explode(" ",$keywords);
			$kwlist = array();
			foreach($klist as $key=>$value){
				$kwlist[] = '<i>'.$value.'</i>';
				if($my_mids && is_array($my_mids)){
					foreach($my_mids as $k=>$v){
						$kc_ext[$v][] = " l.seo_title LIKE '%".$value."%'";
						$kc_ext[$v][] = " l.seo_keywords LIKE '%".$value."%'";
						$kc_ext[$v][] = " l.seo_desc LIKE '%".$value."%'";
						$kc_ext[$v][] = " l.title LIKE '%".$value."%'";
						$kc_ext[$v][] = " l.tag LIKE '%".$value."%'";
					}
				}else{
					$kc[] = " l.seo_title LIKE '%".$value."%'";
					$kc[] = " l.seo_keywords LIKE '%".$value."%'";
					$kc[] = " l.seo_desc LIKE '%".$value."%'";
					$kc[] = " l.title LIKE '%".$value."%'";
					$kc[] = " l.tag LIKE '%".$value."%'";
				}
			}
			if($kc && is_array($kc)){
				$condition.= " AND (".implode(" OR ",$kc).") ";
			}
			$pageurl .= "keywords=".rawurlencode($keywords)."&";
		}
		$this->plugin("system_search_condition");
		$dt_ext = $this->tpl->val('dt');
		if($dt_ext && $dt_ext['sqlext']){
			$condition .= " AND ".$dt_ext['sqlext'];
		}
		$total = $this->model('search')->get_total($condition,$my_mids,$kc_ext);
		if(!$total){
			$this->error(P_Lang('没有搜索到您需要的内容'),$this->url('search'));
		}
		$pageid = $this->get($this->config['pageid'],'int');
		if(!$pageid){
			$pageid = 1;
		}
		$psize = $this->config['psize'] ? $this->config['psize'] : 30;
		$offset = ($pageid-1) * $psize;
		//修正页码超过最多页时的友好提示
		$total_page = intval($total/$psize);
		if($total%$psize){
			$total_page++;
		}
		if($total_page && $total_page<$pageid){
			$this->error_404(P_Lang('内容信息不存在'));
		}
		$idlist = $this->model('search')->id_list($condition,$offset,$psize,$my_mids,$kc_ext);
		if($idlist){
			$rslist = array();
			foreach($idlist as $key=>$value){
				$info = $this->call->phpok('_arc',array('title_id'=>$value['id'],'site'=>$this->site['id']));
				if($info){
					$info['_title'] = str_replace($klist,$kwlist,$info['title']);
					$rslist[] = $info;
				}
			}
			$this->assign("rslist",$rslist);
		}
		$this->assign("pageurl",substr($pageurl,0,-1));
		$this->assign("total",$total);
		$this->assign("pageid",$pageid);
		$this->assign("psize",$psize);
		$this->assign("keywords",$keywords);
		$tplfile = $this->model('site')->tpl_file($this->ctrl,'list');
		if(!$tplfile){
			$tplfile = 'search_list';
		}
		//保留搜索的关键字
		if(!$pageid || $pageid<2){
			$this->model('search')->save($keywords);
		}
		$this->plugin('ap-load-search');
		$this->view($tplfile);
		exit;
	}
}