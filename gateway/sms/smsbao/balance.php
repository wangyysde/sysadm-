<?php
/**
 * 莫名短信，获取剩余短信数
 * @package phpok\gateway\sms\duanxincm
 * @作者 qinggan <admin@phpok.com>
 * @版权 2015-2016 深圳市锟铻科技有限公司
 * @主页 http://www.phpok.com
 * @版本 4.x
 * @授权 http://www.phpok.com/lgpl.html PHPOK开源授权协议：GNU Lesser General Public License
 * @时间 2016年11月17日
**/
if(!defined("SYSADM_SET")){exit("<h1>Access Denied</h1>");}
$url = $rs['ext']['query'] ? $rs['ext']['query'] : "http://api.smsbao.com/query";
$data = array(
	'u'=>$rs['ext']['account'],
	'p'=>md5($rs['ext']['password'])
);
$url .= "?";
foreach($data as $key=>$value){
	$url .= $key.'='.rawurlencode($value).'&';
}
$info = $this->lib('html')->get_content($url);
if(!$info){
	return false;
}
$list = explode("\n",$info);
if($list[0] == '0'){
	$tmp = explode(",",$list[1]);
	$count = $tmp[1];
	if($count<1){
		return '请充值，当前账户没有剩余短信数量';
	}
	if($count<30){
		return '您当前可用短信数量仅余<span style="color:red">'.$count.'</span>条，请及时充值';
	}
	return '您当前还可以使用<span style="color:red">'.$count.'</span>条短信';
}
$this->error('验证失败');
return false;