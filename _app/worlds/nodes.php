<?php
/**
 * 接入节点_管理全球国家及州/省信息
 * @作者 phpok.com <admin@phpok.com>
 * @版权 深圳市锟铻科技有限公司
 * @主页 http://www.phpok.com
 * @版本 5.x
 * @许可 http://www.phpok.com/lgpl.html PHPOK开源授权协议：GNU Lesser General Public License
 * @时间 2019年05月27日 19时51分
**/
namespace phpok\app\worlds;
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

	//解决不同国家不同价格
	public function PHPOK_arclist()
	{
		$rslist = $this->data('rslist');
		$pid = $this->data('pid');
		if(!$rslist || !is_array($rslist) || !$pid || !is_numeric($pid)){
			return false;
		}
		$ids = array_keys($rslist);
		$region = $this->session->val('region');
		if(!$region){
			return false;
		}
		$pricelist = $this->model('worlds')->price_all($ids);
		if(!$pricelist){
			return false;
		}
		foreach($rslist as $key=>$value){
			if(!$value['apps']){
				$value['apps'] = array();
			}
			if(isset($pricelist[$value['id']])){
				$value['apps']['worlds'] = $pricelist[$value['id']];
				if(isset($pricelist[$value['id']]['price']) && isset($pricelist[$value['id']]['price'][$region['id']])){
					$prices = $pricelist[$value['id']]['price'][$region['id']];
					if($prices && isset($prices['price']) && $prices['price']){
						$value['price'] = $prices['price'];
					}
					if($prices && isset($prices['currency_id']) && $prices['currency_id']){
						$value['currency_id'] = $prices['currency_id'];
					}
				}
			}
			$rslist[$key] = $value;
		}
		$this->data('rslist',$rslist);
		return true;
	}

	public function PHPOK_arc()
	{
		$arc = $this->data('arc');
		if(!$arc){
			return false;
		}
		if(!$arc['price']){
			return false;
		}
		$region = $this->session->val('region');
		if(!$region){
			return false;
		}
		$pricelist = $this->model('worlds')->price_all($arc['id']);
		if(!$pricelist || !$pricelist[$arc['id']]){
			return false;
		}
		if(!$arc['apps']){
			$arc['apps'] = array();
		}
		$arc['apps']['worlds'] = $pricelist[$arc['id']];
		if(isset($pricelist[$arc['id']]['price']) && $pricelist[$arc['id']]['price']){
			if(isset($pricelist[$arc['id']]['price'][$region['id']]) && $pricelist[$arc['id']]['price'][$region['id']]){
				$price = $pricelist[$arc['id']]['price'][$region['id']];
				if($price && $price['price']){
					$arc['price'] = $price['price'];
				}
				if($price && $price['currency_id']){
					$arc['currency_id'] = $price['currency_id'];
				}
			}
		}
		$this->data('arc',$arc);
		return true;
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

	public function api_cart_index_after($data)
	{
		if(!is_array($data)){
			return false;
		}
		$rslist = $data['rslist'];
		$freeship = 0;
		foreach($rslist as $key=>$value){
			if(!$value['tid']){
				continue;
			}
			$arc = phpok('_arc','title_id='.$value['tid']);
		}
		$data['price'] = '1000';
		$this->success($data);
	}

	//系统自动生成的节点
	public function www_cart_checkout_after()
	{
		$country_id = 7;
		if($this->session->val('region')){
			$country_id = $this->session->val('region.id');
		}
		$pricelist = $this->tpl->val('pricelist');
		if(!$pricelist){
			return false;
		}
		$rslist = $this->tpl->val('rslist');
		if(!$rslist){
			return false;
		}
		//检测运费，消费税，关税
		$shipping = $excise = $tariff = 0;
		foreach($rslist as $key=>$value){
			if(!$value['tid']){
				continue;
			}
			$arc = phpok('_arc','title_id='.$value['tid']);
			if(!$arc['apps'] || !$arc['apps']['worlds']){
				continue;
			}
			$obj = $arc['apps']['worlds'];
			//检测运费
			if($obj['freight'] && isset($obj['freight'][$country_id])){
				$tmp = $obj['freight'][$country_id];
				if(!$tmp['currency_id']){
					$tmp['currency_id'] = $this->site['currency_id'];
				}
				$shipping += price_format_val($tmp['price'],$tmp['currency_id'],$this->site['currency_id']);
			}
			//检测消费税
			if($obj['excise'] && isset($obj['excise'][$country_id])){
				$tmp = $obj['excise'][$country_id];
				if(!$tmp['currency_id']){
					$tmp['currency_id'] = $this->site['currency_id'];
				}
				$excise += price_format_val($tmp['price'],$tmp['currency_id'],$this->site['currency_id']);
			}
			//检测关税
			if($obj['tariff'] && isset($obj['tariff'][$country_id])){
				$tmp = $obj['tariff'][$country_id];
				if(!$tmp['currency_id']){
					$tmp['currency_id'] = $this->site['currency_id'];
				}
				$tariff += price_format_val($tmp['price'],$tmp['currency_id'],$this->site['currency_id']);
			}
		}
		
		
		$total_price = 0;
		foreach($pricelist as $key=>$value){
			if($value['identifier'] == 'shipping'){
				$value['price'] = price_format($shipping,$this->site['currency_id']);
				$value['price_val'] = price_format_val($shipping,$this->site['currency_id']);
			}
			if($value['identifier'] == 'excise'){
				$value['price'] = price_format($excise,$this->site['currency_id']);
				$value['price_val'] = price_format_val($excise,$this->site['currency_id']);
			}
			if($value['identifier'] == 'tariff'){
				$value['price'] = price_format($tariff,$this->site['currency_id']);
				$value['price_val'] = price_format_val($tariff,$this->site['currency_id']);
			}
			$pricelist[$key] = $value;
			$total_price += $value['price_val'];
		}
		$this->assign('pricelist',$pricelist);
		$price = price_format($total_price,$this->site['currency_id']);
		$this->assign('price',$price);
		$this->assign('price_val',$total_price);
	}


	//后台删除文章主题触发事件
	public function system_admin_title_delete($id)
	{
		$this->model('worlds')->price_delete($id);
		return true;
	}

	public function system_admin_title_success($id,$project)
	{
		if(!$project['is_biz']){
			return false;
		}
		$price = $this->get('_price');
		$freight = $this->get('_freight');
		$excise = $this->get("_excise");
		$tariff = $this->get("_tariff");
		if($price && is_array($price)){
			$this->model('worlds')->price_save($id,$price,'price');
		}else{
			$this->model('worlds')->price_delete($id,'price');
		}
		if($freight && is_array($freight)){
			$this->model('worlds')->price_save($id,$freight,'freight');
		}else{
			$this->model('worlds')->price_delete($id,'freight');
		}
		if($excise && is_array($excise)){
			$this->model('worlds')->price_save($id,$excise,'excise');
		}else{
			$this->model('worlds')->price_delete($id,'excise');
		}
		if($tariff && is_array($tariff)){
			$this->model('worlds')->price_save($id,$tariff,'tariff');
		}else{
			$this->model('worlds')->price_delete($id,'tariff');
		}
		return true;
	}

	/**
	 * 系统加载站点信息
	**/
	public function system_init_site()
	{
		$site_rs = $this->data("site_rs");
		$region = $this->session->val('region');
		if(!$region){
			return false;
		}
		if($region['site_id'] && $region['site_id'] != $site_rs['id']){
			$site_rs = $this->model('site')->site_info($region['site_id']);
		}
		//检测
		if($region['currency_id']){
			$site_rs['currency_id'] = $region['currency_id'];
		}
		if($region['tpl_id']){
			$site_rs['tpl_id'] = $region['tpl_id'];
		}
		if($region['lang_code']){
			$site_rs['lang'] = $region['lang_code'];
		}
		if($region['freight_id']){
			$site_rs['biz_freight'] = $region['freight_id'];
		}
		//消费税比例
		if($region['excise_rate']){
			$site_rs['excise_rate'] = $region['excise_rate'];
		}
		//关税比例
		if($region['tariff_rate']){
			$site_rs['tariff_rate'] = $region['tariff_rate'];
		}
		$this->data("site_rs",$site_rs);
		return true;
	}
}
