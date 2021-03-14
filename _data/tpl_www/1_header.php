<?php if(!defined("SYSADM_SET")){exit("<h1>Access Denied</h1>");} ?><?php $this->assign("title",$title); ?><?php $this->output("head","file",true,false); ?>
<header>
	<div class="container">
		<div class="row p-1">
			<div class="col-sm-4 m-2">
				<a href="<?php echo $sys['url'];?>" title="<?php echo $config['title'];?>" class="align-middle"><img src="<?php echo $config['logo'];?>" alt="<?php echo $config['title'];?>" class="logo" /></a>
			</div>
			<div class="col-sm-7 mt-3">
				<ul class="nav float-sm-right">
					<?php if($session['user_id']){ ?>
					<li class="nav-item"><a class="nav-link" href="<?php echo phpok_url(array('ctrl'=>'usercp'));?>">个人中心</a></li>
					<li class="nav-item" onclick="$.user.logout('<?php echo $session['user_name'];?>')"><a class="nav-link" href="javascript:void(0);">退出</a></li>
					<?php } else { ?>
						<?php if($config['login_status']){ ?>
						<li class="nav-item"><a class="nav-link" href="<?php echo phpok_url(array('ctrl'=>'login'));?>">登录</a></li>
						<?php } ?>
						<?php if($config['register_status']){ ?>
						<li class="nav-item"><a class="nav-link" href="<?php echo phpok_url(array('ctrl'=>'register'));?>">注册</a></li>
						<?php } ?>
					<?php } ?>
					<?php $sitelist = phpok_sitelist(true);?>
					<?php if($sitelist){ ?>
					<li class="nav-item dropdown">
						<a class="nav-link dropdown-toggle" data-toggle="dropdown" href="javascript:void(0);" role="button" aria-haspopup="true" aria-expanded="false"><?php echo $config['title'];?></a>
						<div class="dropdown-menu">
							<?php $tmpid["num"] = 0;$sitelist=is_array($sitelist) ? $sitelist : array();$tmpid = array();$tmpid["total"] = count($sitelist);$tmpid["index"] = -1;foreach($sitelist as $key=>$value){ $tmpid["num"]++;$tmpid["index"]++; ?>
							<a class="dropdown-item" href="<?php echo $sys['url'];?>?siteId=<?php echo $value['id'];?>"><?php echo $value['title'];?></a>
							<?php } ?>
						</div>
					</li>
					<?php } ?>
					<?php if($config['biz_status']){ ?>
					<li class="nav-item">
						<a class="nav-link" href="<?php echo phpok_url(array('ctrl'=>'cart'));?>" title="购物车">
							<i class="fa fa-shopping-cart"></i>
							<span id="head_cart_num" class="d-none">0</span>
						</a>
					</li>
					<?php } ?>
					<?php include($this->dir_php."language.php");?>
					
					<?php if($countrylist){ ?>
					<li class="nav-item dropdown">
						<a class="nav-link dropdown-toggle" data-toggle="dropdown" href="javascript:void(0);" role="button" aria-haspopup="true" aria-expanded="false"><?php echo $session['region'] ? $session['region']['name'] : '中国';?></a>
						<div class="dropdown-menu">
							<?php $tmpid["num"] = 0;$countrylist=is_array($countrylist) ? $countrylist : array();$tmpid = array();$tmpid["total"] = count($countrylist);$tmpid["index"] = -1;foreach($countrylist as $key=>$value){ $tmpid["num"]++;$tmpid["index"]++; ?>
							<a class="dropdown-item" href="javascript:country_change('<?php echo $value['id'];?>');void(0)"><?php echo $value['name'];?></a>
							<?php } ?>
						</div>
					</li>
					<?php } ?>
				</ul>
				<div class="m-1 float-sm-right">
					<form class="form-inline" method="post" action="<?php echo phpok_url(array('ctrl'=>'search'));?>" onsubmit="return top_search(this)">
						<input class="form-control mr-sm-2" type="search" name="keywords" placeholder="搜索" aria-label="搜索" />
						<button class="btn btn-primary btn-sm" type="submit">搜索</button>
					</form>
				</div>
			</div>
		</div>
	</div>
	<div class="bg-nav text-white">
		<div class="container">
		<ul class="nav justify-content-center">
			<?php $list = menu("top");?>
			<?php $tmpid["num"] = 0;$list=is_array($list) ? $list : array();$tmpid = array();$tmpid["total"] = count($list);$tmpid["index"] = -1;foreach($list as $key=>$value){ $tmpid["num"]++;$tmpid["index"]++; ?>
			<?php if($value['sublist']){ ?>
			<li class="nav-item dropdown">
				<a class="nav-link text-light dropdown-toggle" href="javascript:void(0)" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?php echo $value['title'];?></a>
				<div class="dropdown-menu">
					<?php $idxx["num"] = 0;$value['sublist']=is_array($value['sublist']) ? $value['sublist'] : array();$idxx = array();$idxx["total"] = count($value['sublist']);$idxx["index"] = -1;foreach($value['sublist'] as $k=>$v){ $idxx["num"]++;$idxx["index"]++; ?>
					<a class="dropdown-item" href="<?php echo $v['url'];?>" target="<?php echo $v['target'];?>"><?php echo $v['title'];?></a>
					<?php } ?>
				</div>
			</li>
			<?php } else { ?>
			<li class="nav-item<?php if($value['lighlight']){ ?> active<?php } ?>">
				<a class="nav-link text-light" href="<?php echo $value['url'];?>"><?php echo $value['title'];?></a>
			</li>
			<?php } ?>
			<?php } ?>
		</ul>
		</div>
	</div>
</header>
