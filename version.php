<?php
/**
 * SYSADM 企业站系统，使用PHP语言及MySQL数据库编写的企业网站建设系统，基于LGPL协议开源授权
 * @作者 王余应 <net_use@bzhy.com>
 * @版权 斑竹网络 
 * @主页 https://www.sysadm.cn
 * @版本 1.x
 * @授权 GNU Lesser General Public License  https://www.sysadm.cn/lgpl.html
 * @时间 2021年02月25日
**/

/**
 * 安全限制，防止直接访问
**/
if(!defined("SYSADM_SET")){
	exit("<h1>Access Denied</h1>");
}

define("VERSION","1.0");
define("SYSNAME","SYSADM");
define("OFFICEURL","sysadm.cn");
define("COPYSTART","2019");