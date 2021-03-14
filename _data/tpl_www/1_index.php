<?php if(!defined("SYSADM_SET")){exit("<h1>Access Denied</h1>");} ?><?php $this->output("header","file",true,false); ?>

<!-- 图片轮播 -->
<?php $slider = phpok('picplayer');?>
<?php if($slider && $slider['rslist']){ ?>
<div id="slider_<?php echo $slider['project']['id'];?>" class="carousel slide" data-ride="carousel">
	<ol class="carousel-indicators">
		<?php $tmpid["num"] = 0;$slider['rslist']=is_array($slider['rslist']) ? $slider['rslist'] : array();$tmpid = array();$tmpid["total"] = count($slider['rslist']);$tmpid["index"] = -1;foreach($slider['rslist'] as $key=>$value){ $tmpid["num"]++;$tmpid["index"]++; ?>
		<li data-target="#slider_<?php echo $slider['project']['id'];?>" data-slide-to="<?php echo $tmpid['index'];?>"<?php if(!$tmpid['index']){ ?> class="active"<?php } ?>></li>
		<?php } ?>
	</ol>
	<div class="carousel-inner">
		<?php $tmpid["num"] = 0;$slider['rslist']=is_array($slider['rslist']) ? $slider['rslist'] : array();$tmpid = array();$tmpid["total"] = count($slider['rslist']);$tmpid["index"] = -1;foreach($slider['rslist'] as $key=>$value){ $tmpid["num"]++;$tmpid["index"]++; ?>
		<div class="carousel-item<?php if(!$tmpid['index']){ ?> active<?php } ?>">
			<a href="<?php echo $value['linkurl'] ? $value['linkurl'] : 'javascript:void(0);';?>" title="<?php echo $value['title'];?>" <?php if($value['linkurl']){ ?> target="<?php echo $value['target'];?>"<?php } ?>><img src="<?php echo $value['banner']['filename'];?>" class="d-block w-100" alt="<?php echo $value['title'];?>" /></a>
		</div>
		<?php } ?>
	</div>
	<a class="carousel-control-prev" href="#slider_<?php echo $slider['project']['id'];?>" role="button" data-slide="prev">
		<span class="carousel-control-prev-icon" aria-hidden="true"></span>
		<span class="sr-only">下一张</span>
	</a>
	<a class="carousel-control-next" href="#slider_<?php echo $slider['project']['id'];?>" role="button" data-slide="next">
		<span class="carousel-control-next-icon" aria-hidden="true"></span>
		<span class="sr-only">下一张</span>
	</a>
</div>
<?php } ?>

<!-- 产品展示 -->
<?php $products = phpok('new_products');?>
<?php if($products){ ?>
<section class="container">
	<div class="p-4">
		<div class="row">
			<div class="col-md-4 mt-4">
				<hr class="border-primary border-dotted" />
			</div>
			<div class="col">
				<h2 class="h1 text-center"<?php if($products['project']['style']){ ?> style="<?php echo $products['project']['style'];?>"<?php } ?>>
					<?php echo $products['project']['title'];?>
					<?php if($products['project']['entitle']){ ?><small class="d-block mt-2"><?php echo $products['project']['entitle'];?></small><?php } ?>
				</h2>
			</div>
			<div class="col-md-4 mt-4">
				<hr class="border-primary border-dotted" />
			</div>
		</div>
		<div class="row row-cols-1 row-cols-sm-2 row-cols-md-4">
			<?php $tmpid["num"] = 0;$products['rslist']=is_array($products['rslist']) ? $products['rslist'] : array();$tmpid = array();$tmpid["total"] = count($products['rslist']);$tmpid["index"] = -1;foreach($products['rslist'] as $key=>$value){ $tmpid["num"]++;$tmpid["index"]++; ?>
			<div class="col p-2">
				<div class="card">
					<a href="<?php echo $value['url'];?>" title="<?php echo $value['title'];?>"><img class=" card-img-top" src="<?php echo $value['thumb']['gd']['thumb'];?>" alt="<?php echo $value['title'];?>" /></a>
					<div class="card-body p-2" style="height:100px">
						<a href="<?php echo $value['url'];?>" title="<?php echo $value['title'];?>"><h5 class="crop-text-2"><?php echo $value['title'];?></h5></a>
						<?php if($products['project']['is_biz']){ ?>
						<p class="card-text text-danger"><?php echo price_format($value['price'],$value['currency_id'],$config['currency_id']);?></p>
						<?php } ?>
					</div>
				</div>
			</div>
			<?php } ?>
		</div>
	</div>
</section>
<?php } ?>

<!-- 公司简介 -->
<?php $about = phpok('aboutus');?>
<?php if($about){ ?>
<section class="jumbotron">
	<div class="container">
		<div class="row">
			<div class="col-md-6">
				<h2><?php echo $about['title'];?><?php if($about['entitle']){ ?><small><?php echo $about['entitle'];?></small><?php } ?></h2>
				<hr class="my-4" />
				<?php echo $about['note'];?>
			</div>
			<?php if($about['pic']){ ?>
			<div class="col-md-6">
				<img src="<?php echo $about['pic'];?>" style="width:100%" />
			</div>
			<?php } ?>
		</div>
		<div class="text-center mt-4">
			<a class="btn btn-primary btn-lg" href="<?php echo $about['url'];?>" role="button">查看详细信息</a>
		</div>
	</div>
</section>
<?php } ?>

<!-- 新闻资讯，涉及到图片及文字，所以左边的新闻右边就不重复调用，直接引用PHP文件 -->
<?php include($this->dir_php."arc-index.php");?>
<?php if($arclist || $piclist){ ?>
<section class="container">
	<div class="row p-4 mb-4">
		<div class="col-dm-4 mt-4">
			<hr class="border-primary border-dotted" />
		</div>
		<div class="col">
			<h2 class="h1 text-center"<?php if($arclist['project']['style']){ ?> style="<?php echo $arclist['project']['style'];?>"<?php } ?>>
				<?php echo $arclist['project']['title'];?>
				<?php if($arclist['project']['entitle']){ ?><small class="d-block mt-2"><?php echo $arclist['project']['entitle'];?></small><?php } ?>
			</h2>
		</div>
		<div class="col-dm-4 mt-4">
			<hr class="border-primary border-dotted" />
		</div>
	</div>
	<div class="row pb-4 mb-4">
		<div class="col-md-6 col-lg-5 mb-4">
			<div id="slider_<?php echo $piclist['project']['id'];?>" class="carousel slide" data-ride="carousel">
				<ol class="carousel-indicators">
					<?php $tmpid["num"] = 0;$piclist['rslist']=is_array($piclist['rslist']) ? $piclist['rslist'] : array();$tmpid = array();$tmpid["total"] = count($piclist['rslist']);$tmpid["index"] = -1;foreach($piclist['rslist'] as $key=>$value){ $tmpid["num"]++;$tmpid["index"]++; ?>
					<li data-target="#slider_<?php echo $piclist['project']['id'];?>" data-slide-to="<?php echo $tmpid['index'];?>"<?php if(!$tmpid['index']){ ?> class="active"<?php } ?>></li>
					<?php } ?>
				</ol>
				<div class="carousel-inner">
					<?php $tmpid["num"] = 0;$piclist['rslist']=is_array($piclist['rslist']) ? $piclist['rslist'] : array();$tmpid = array();$tmpid["total"] = count($piclist['rslist']);$tmpid["index"] = -1;foreach($piclist['rslist'] as $key=>$value){ $tmpid["num"]++;$tmpid["index"]++; ?>
					<div class="carousel-item<?php if(!$tmpid['index']){ ?> active<?php } ?>">
						<a href="<?php echo $value['url'];?>" title="<?php echo $value['title'];?>"><img src="<?php echo $value['thumb']['gd']['thumb'];?>" class="d-block w-100" alt="<?php echo $value['title'];?>" /></a>
						<div class="carousel-caption d-none d-md-block">
					        <h5><?php echo $value['title'];?></h5>
					      </div>
					</div>
					<?php } ?>
				</div>
				<a class="carousel-control-prev" href="#slider_<?php echo $piclist['project']['id'];?>" role="button" data-slide="prev">
					<span class="carousel-control-prev-icon" aria-hidden="true"></span>
					<span class="sr-only">下一张</span>
				</a>
				<a class="carousel-control-next" href="#slider_<?php echo $piclist['project']['id'];?>" role="button" data-slide="next">
					<span class="carousel-control-next-icon" aria-hidden="true"></span>
					<span class="sr-only">下一张</span>
				</a>
			</div>
		</div>
		<div class="col-md-6 col-lg-7">
			<?php $tmpid["num"] = 0;$arclist['rslist']=is_array($arclist['rslist']) ? $arclist['rslist'] : array();$tmpid = array();$tmpid["total"] = count($arclist['rslist']);$tmpid["index"] = -1;foreach($arclist['rslist'] as $key=>$value){ $tmpid["num"]++;$tmpid["index"]++; ?>
			<div class="media<?php if($tmpid['num'] != $tmpid['total']){ ?> border-bottom<?php } ?> mb-3">
				<?php if($value['thumb']){ ?>
				<a href="<?php echo $value['url'];?>" title="<?php echo $value['title'];?>"><img src="<?php echo $value['thumb']['gd']['thumb'];?>" class="align-self-start mr-3" alt="<?php echo $value['title'];?>" /></a>
				<?php } ?>
				<div class="media-body">
					<a href="<?php echo $value['url'];?>" title="<?php echo $value['title'];?>"><h5><?php echo $value['title'];?></h5></a>
					<p class="crop-text-2"><?php if($value['note']){ ?><?php echo phpok_cut($value['note'],'100','…');?><?php } else { ?><?php echo phpok_cut($value['content'],'100','…');?><?php } ?></p>
				</div>
			</div>
			<?php } ?>
		</div>
	</div>
</section>
<?php } ?>

<!-- 联系方式 -->
<?php $contactus = phpok('contactus');?>
<?php if($contactus){ ?>
<section class="jumbotron contactus">
	<div class="container">
		<div class="row">
			<div class="col-sm-12 col-md-4 mb-4">
				<h2>
					<?php echo $contactus['title'];?>
					<?php if($contactus['entitle']){ ?><small><?php echo $contactus['entitle'];?></small><?php } ?>
					<a href="<?php echo $contactus['url'];?>" class="more mt-3">更多 <i class="fa fa-angle-right"></i></a>
				</h2>
				<ul class="list-group list-group-flush mt-4">
					<?php if($contactus['company']){ ?><li class="list-group-item"><i class="fa fa-building"></i> <?php echo $contactus['company'];?></li><?php } ?>
					<?php if($contactus['address']){ ?><li class="list-group-item"><i class="fa fa-map-marker"></i> <?php echo $contactus['address'];?></li><?php } ?>
					<?php if($contactus['email']){ ?><li class="list-group-item"><i class="fa fa-envelope-o"></i> <?php echo $contactus['email'];?></li><?php } ?>
					<?php if($contactus['zipcode']){ ?><li class="list-group-item"><i class="fa fa-check-circle-o"></i> <?php echo $contactus['zipcode'];?></li><?php } ?>
					<?php if($contactus['tel']){ ?><li class="list-group-item"><i class="fa fa-phone"></i> <?php echo $contactus['tel'];?></li><?php } ?>
					<?php if($contactus['fullname']){ ?><li class="list-group-item"><i class="fa fa-user"></i> <?php echo $contactus['fullname'];?></li><?php } ?>
				</ul>
			</div>
			<?php if($contactus['map']){ ?>
			<div class="col-sm-12 col-md-8">
				<img src="<?php echo $contactus['map']['filename'];?>" style="width:100%" />
			</div>
			<?php } ?>
		</div>
	</div>
</section>
<?php } ?>
<?php $link = phpok('link');?>
<?php if($link && $link['rslist']){ ?>
<section class="container">
	<div class="row p-4 mb-4">
		<div class="col-md-4 mt-4 d-sm-none">
			<hr class="border-primary border-dotted" />
		</div>
		<div class="col">
			<h2 class="h1 text-center"<?php if($link['project']['style']){ ?> style="<?php echo $link['project']['style'];?>"<?php } ?>>
				<?php echo $link['project']['title'];?>
				<?php if($link['project']['entitle']){ ?><small class="d-block mt-2"><?php echo $link['project']['entitle'];?></small><?php } ?>
			</h2>
		</div>
		<div class="col-md-4 mt-4 d-sm-none">
			<hr class="border-primary border-dotted" />
		</div>
	</div>
	<div class="row mb-4">
		<?php $link_rslist_id["num"] = 0;$link['rslist']=is_array($link['rslist']) ? $link['rslist'] : array();$link_rslist_id = array();$link_rslist_id["total"] = count($link['rslist']);$link_rslist_id["index"] = -1;foreach($link['rslist'] as $key=>$value){ $link_rslist_id["num"]++;$link_rslist_id["index"]++; ?>
		<div class="col-sm-3 col-md-2 border m-1 p-1 text-center float-center">
			<a href="<?php echo $value['linkurl'];?>" target="<?php echo $value['target'];?>" title="<?php echo $value['sitename'];?>"><?php echo $value['sitename'];?></a>
		</div>
		<?php } ?>
	</div>
</section>
<?php } ?>
<?php $this->output("footer","file",true,false); ?>