<?php
/**
 * 清空缓存
 * @作者 qinggan <admin@phpok.com>
 * @版权 深圳市锟铻科技有限公司
 * @主页 http://www.phpok.com
 * @版本 5.x
 * @授权 http://www.phpok.com/lgpl.html 开源授权协议：GNU Lesser General Public License
 * @时间 2019年12月6日
**/

if(!defined("SYSADM_SET")){exit("<h1>Access Denied</h1>");}
$this->cache->clear();
return true;