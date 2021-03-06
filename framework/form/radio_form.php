<?php
/*****************************************************************************************
	文件： {phpok}/form/radio_form.php
	备注： 单选框处理操作
	版本： 4.x
	网站： www.phpok.com
	作者： qinggan <qinggan@188.com>
	时间： 2015年02月27日 20时18分
*****************************************************************************************/
if(!defined("SYSADM_SET")){exit("<h1>Access Denied</h1>");}
class radio_form extends _init_auto
{
	public function __construct()
	{
		parent::__construct();
	}

	public function phpok_config()
	{
		$opt_list = $this->model('opt')->group_all();
		$this->assign('opt_list',$opt_list);
		$rslist = $this->model('project')->get_all_project($this->session->val('admin_site_id'));
		if($rslist){
			$p_list = $m_list = array();
			foreach($rslist as $key=>$value){
				if(!$value["parent_id"]){
					$p_list[] = $value;
				}
				if($value["module"]){
					$m_list[] = $value;
				}
			}
			if($p_list && count($p_list)>0){
				$this->assign("project_list",$p_list);
			}
			if($m_list && count($m_list)>0){
				$this->assign("title_list",$m_list);
			}
		}
		$catelist = $this->model('cate')->root_catelist($_SESSION['admin_site_id']);
		$this->assign("catelist",$catelist);
		//读取另一个站点
		$sitelist = $this->model('site')->get_all_site('id');
		if($sitelist && count($sitelist)>1){
			unset($sitelist[$this->session->val('admin_site_id')]);
			//读取其他站点的项目及模块
			foreach($sitelist as $key=>$value){
				$rslist = $this->model("project")->get_all_project($value['id']);
				if($rslist){
					$m_list = array();
					foreach($rslist as $k=>$v){
						if(!$v["parent_id"]){
							$p_list[] = $v;
						}
						if($v['module']){
							$m_list[] = $v;
						}
					}
					if($m_list && count($m_list)>0){
						$sitelist[$key]['mlist'] = $m_list;
					}
					if($p_list && count($p_list)>0){
						$sitelist[$key]['plist'] = $p_list;
					}
				}
				$catelist = $this->model("cate")->root_catelist($value['id']);
				if($catelist){
					$sitelist[$key]['clist'] = $catelist;
				}
			}
			$this->assign('ext_sitelist',$sitelist);
		}
		$html = $this->dir_phpok."form/html/radio_admin.html";
		$this->view($html,"abs-file",false);
	}

	public function phpok_format($rs,$appid='admin')
	{
		if($rs['ext'] && is_string($rs['ext'])){
			$tmp = unserialize($rs['ext']);
			$rs = array_merge($tmp,$rs);
		}
		if(!$rs["option_list"]){
			$rs['option_list'] = 'default:0';
		}
		$opt_list = explode(":",$rs["option_list"]);
		$rslist = $this->opt_rslist($opt_list[0],$opt_list[1],$rs['ext_select']);
		if(!$rslist){
			return false;
		}
		if($rs["content"] && is_array($rs['content']))
		{
			$rs['content'] = $rs['content']['val'];
		}
		$this->assign('_rs',$rs);
		$this->assign('_rslist',$rslist);
		if($appid == 'admin'){
			return $this->fetch($this->dir_phpok.'form/html/radio_admin_tpl.html','abs-file');
		}else{
			return $this->fetch($this->dir_phpok.'form/html/radio_www_tpl.html','abs-file');
		}
	}

	public function phpok_get($rs,$appid="admin")
	{
		$ext = array();
		if($rs['ext']){
			if(is_string($rs['ext'])){
				$ext = unserialize($rs['ext']);
			}else{
				$ext = $rs['ext'];
			}
		}
		$info = $this->get($rs['identifier'],$rs['format']);
		if(!$info){
			return false;
		}
		if($ext['is_add'] && $info == '_'){
			$info = $this->get($rs['identifier'].'_extadd',$rs['format']);
		}
		return $info;
	}

	//输出内容
	public function phpok_show($rs,$appid='admin')
	{
		$ext = array();
		if($rs['ext']){
			if(is_string($rs['ext'])){
				$ext = unserialize($rs['ext']);
			}else{
				$ext = $rs['ext'];
			}
		}
		if(!$ext["option_list"]){
			$ext['option_list'] = 'default:0';
		}
		$opt = explode(":",$ext["option_list"]);
		if($appid == 'admin'){
			$info = $this->opt_rs($rs['content'],$opt[0],$opt[1]);
			if($info && $info['title']){
				return $info['title'];
			}
			return false;
		}else{
			if($opt[0] == 'project'){
				return $this->call->phpok('_project',array('pid'=>$rs['content']));
			}
			if($opt[0] == 'cate'){
				return $this->call->phpok('_cate',array('cateid'=>$rs['content']));
			}
			if($opt[0] == 'title'){
				$project = $this->model('project')->get_one($opt[1],false);
				if(!$project || !$project['module']){
					return false;
				}
				$module = $this->model('module')->get_one($project['module']);
				$ext = array('title_id'=>$rs['content']);
				if($module['mtype']){
					$ext['pid'] = $project['id'];
					$ext['is_single'] = 1;
				}
				return $this->call->phpok('_arc',$ext);
			}
			return $rs['content'];
		}
	}

	private function opt_rs($val,$type='default',$group_id='')
	{
		$rs = array('val'=>$val,'title'=>$val);
		if($type == 'opt'){
			$tmp = $this->model('opt')->opt_val($group_id,$val);
			if(!$tmp){
				return false;
			}
			$rs['title'] = $tmp['title'];
		}
		if($type == 'project'){
			$tmp = $this->model('project')->get_one($val,false);
			if(!$tmp || !$tmp['status']){
				return false;
			}
			$rs['title'] = $tmp['title'];
		}
		if($type == 'title'){
			$project = $this->model('project')->get_one($group_id,false);
			if(!$project || !$project['module']){
				$rs['title'] = '未知';
			}else{
				$module = $this->model('module')->get_one($project['module']);
				if($module['mtype']){
					$tmp = $this->model('list')->single_one($val,$project['module']);
				}else{
					$tmp = $this->model('list')->call_one($val);
				}
				if(!$tmp){
					$rs['title'] = '无';
				}else{
					$rs['title'] = $tmp['title'] ? $tmp['title'] : $tmp;
				}
			}
		}
		if($type == 'cate'){
			$tmp = $this->model('cate')->cate_info($val,false);
			if(!$tmp || !$tmp['status']){
				return false;
			}
			$rs['title'] = $tmp['title'];
		}
		if($type == 'user'){
			if($group_id == 'grouplist'){
				$tmp = $this->model('usergroup')->get_one($val);
				if($tmp){
					$rs['title'] = $tmp['title'];
				}
			}
		}
		$rs['type'] = $type;
		return $rs;
	}
	//
	private function opt_rslist($type='default',$group_id=0,$info='')
	{
		//当类型为默认时
		if($type == 'default' && $info){
			$list = explode("\n",$info);
			$rslist = array();
			foreach($list as $key=>$value){
				if(!$value || !trim($value)){
					continue;
				}
				if(strpos($value,'|') !== false){
					$tmp2 = explode("|",$value);
					if(!$tmp2[1]){
						$tmp2[1] = $tmp2[0];
					}
					$rslist[] = array('val'=>$tmp2[0],'title'=>$tmp2[1]);
				}elseif(strpos($value,':') !== false){
					$tmp2 = explode(":",$value);
					if(!$tmp2[1]){
						$tmp2[1] = $tmp2[0];
					}
					$rslist[] = array('val'=>$tmp2[0],'title'=>$tmp2[1]);
				}else{
					$rslist[] = array('val'=>trim($value),'title'=>trim($value));
				}
			}
			return $rslist;
		}

		//表单选项
		if($type == "opt"){
			return $this->model('opt')->opt_all("group_id=".$group_id);
		}
		
		//读子项目信息
		if($type == 'project'){
			$tmplist = $this->model('project')->project_sonlist($group_id);
			if(!$tmplist) return false;
			$rslist = array();
			foreach($tmplist as $key=>$value){
				$tmp = array("val"=>$value['id'],"title"=>$value['title']);
				$rslist[] = $tmp;
			}
			return $rslist;
		}
		//读主题列表信息
		if($type == 'title'){
			$project = $this->model('project')->get_one($group_id,false);
			if(!$project || !$project['module']){
				return false;
			}
			$module = $this->model('module')->get_one($project['module']);
			if(!$module){
				return false;
			}
			if($module['mtype']){
				$tmplist = $this->model('list')->single_list($project['module'],'',0,999);
			}else{
				$tmplist = $this->model("list")->title_list($group_id);
			}
			if(!$tmplist){
				return false;
			}
			$rslist = array();
			foreach($tmplist as $key=>$value){
				$tmp = array("val"=>$value['id'],"title"=>$value['title']);
				$rslist[] = $tmp;
			}
			return $rslist;
		}
		//读子分类信息
		if($type == 'cate'){
			$tmplist = $this->model('cate')->catelist_sonlist($group_id,false,0);
			if(!$tmplist) return false;
			$rslist = array();
			foreach($tmplist as $key=>$value){
				$tmp = array("val"=>$value['id'],"title"=>$value['title']);
				$rslist[] = $tmp;
			}
			return $rslist;
		}
		if($type == 'user'){
			if($group_id == 'grouplist'){
				$tmplist = $this->model('usergroup')->get_all('status=1');
				if(!$tmplist){
					return false;
				}
				$rslist = array();
				foreach($tmplist as $key=>$value){
					$tmp = array("val"=>$value['id'],"title"=>$value['title']);
					$rslist[] = $tmp;
				}
				return $rslist;
			}
		}
		return false;
	}
}