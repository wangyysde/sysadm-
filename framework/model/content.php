<?php
/**
 * 读取主题内容
 * @作者 qinggan <admin@phpok.com>
 * @版权 深圳市锟铻科技有限公司
 * @主页 http://www.phpok.com
 * @版本 4.x
 * @授权 http://www.phpok.com/lgpl.html PHPOK开源授权协议：GNU Lesser General Public License
 * @时间 2017年08月23日
**/

if(!defined("SYSADM_SET")){exit("<h1>Access Denied</h1>");}
class content_model_base extends phpok_model
{
	/**
	 * 构造函数
	**/
	public function __construct()
	{
		parent::model();
	}


	/**
	 * 取得单个主题信息
	 * @参数 $id 主题ID或标识
	 * @参数 $status 是否已审核
	**/
	public function get_one($id,$status=true,$site_id=0)
	{
		if(!$site_id){
			$site_id = $this->site_id;
		}
		$sql  = "SELECT * FROM ".$this->db->prefix."list WHERE site_id='".$site_id."' AND ";
		$sql .= is_numeric($id) ? " id='".$id."' " : " identifier='".$id."' ";
		if($status){
			$sql.= " AND status=1 ";
		}
		$rs = $this->db->get_one($sql);
		if(!$rs){
			return false;
		}
		$sql = "SELECT * FROM ".$this->db->prefix."list_biz WHERE id='".$rs['id']."'";
		$biz_rs = $this->db->get_one($sql);
		if($biz_rs){
			foreach($biz_rs as $key=>$value){
				$rs[$key] = $value;
			}
			unset($biz_rs);
		}
		if($rs['module_id']){
			$sql = "SELECT * FROM ".$this->db->prefix."list_".$rs['module_id']." WHERE id='".$rs['id']."'";
			$ext_rs = $this->db->get_one($sql);
			if($ext_rs){
				$rs = array_merge($ext_rs,$rs);
			}
		}
		//读取属性
		$sql  = " SELECT la.*,a.title group_title,av.title,av.pic,av.val FROM ".$this->db->prefix."list_attr la ";
		$sql .= " LEFT JOIN ".$this->db->prefix."attr a ON(la.aid=a.id) ";
		$sql .= " LEFT JOIN ".$this->db->prefix."attr_values av ON(la.vid=av.id) ";
		$sql .= " WHERE la.tid='".$rs['id']."' ORDER BY a.taxis ASC,la.taxis ASC,la.id DESC";
		$attrlist = $this->db->get_all($sql);
		if($attrlist){
			$attrs = array();
			foreach($attrlist as $key=>$value){
				if(!$attrs[$value['aid']]){
					$attrs[$value['aid']] = array();
					$attrs[$value['aid']]['title'] = $value['group_title'];
					$attrs[$value['aid']]['id'] = $value['aid'];
					$attrs[$value['aid']]['rslist'] = array();
				}
				$attrs[$value['aid']]['rslist'][] = $value;
			}
			$rs['attrlist'] = $attrs;
		}
		
		$ext = $this->model('ext')->get_all('list-'.$rs['id'],false);
		if($ext){
			$rs = array_merge($rs,$ext);
		}		
		return $rs;
	}

	/**
	 * 通过主题ID获取对应的模块ID
	 * @参数 $id 主题ID
	**/
	public function get_mid($id)
	{
		$sql = "SELECT module_id FROM ".$this->db->prefix."list WHERE id='".$id."' AND status=1";
		$rs = $this->db->get_one($sql);
		if(!$rs){
			return false;
		}
		return $rs["module_id"];
	}

	/**
	 * 获取扩展字段并格式化内容
	 * @参数 $mid 模块ID
	 * @参数 $ids 主题，多个主题用英文逗号隔开
	 * @参数 
	**/
	public function ext_list($mid,$ids)
	{
		if(!$mid || !$ids){
			return false;
		}
		$flist = $this->model("module")->fields_all($mid);
		if(!$flist){
			return false;
		}
		$sql = "SELECT * FROM ".$this->db->prefix."list_".$mid." WHERE id IN(".$ids.")";
		$rslist = $this->db->get_all($sql,"id");
		if(!$rslist){
			return false;
		}
		foreach($rslist as $key=>$value){
			foreach($flist as $k=>$v){
				if($value[$v["identifier"]]){
					$v["content"] = $value[$v["identifier"]];
					$value[$v["identifier"]] = $this->lib('ext')->content_format($v);
				}
			}
			$rslist[$key] = $value;
		}
		return $rslist;
	}
}