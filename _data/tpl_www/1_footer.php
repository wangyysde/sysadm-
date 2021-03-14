<?php if(!defined("SYSADM_SET")){exit("<h1>Access Denied</h1>");} ?><footer class="pt-5 mt-2 bg-light">
	<div class="container">
		<?php $about = phpok('aboutus');?>
		<div class="row footer-theme partition-f">
			<div class="col-lg-4 col-md-6">
				<h4><?php echo $config['title'];?></h4>
				<div class="footer-contant">
					<p><?php echo $about['footnote'];?></p>
					<div class="payment-card-bottom">
						<i class="fa fa-cc-visa text-warning" aria-hidden="true"></i>
						<i class="fa fa-cc-mastercard text-warning" aria-hidden="true"></i>
						<i class="fa fa-cc-paypal text-warning" aria-hidden="true"></i>
						<i class="fa fa-cc-discover text-warning" aria-hidden="true"></i>
						<i class="fa fa-cc-amex text-warning" aria-hidden="true"></i>
					</div>
				</div>
			</div>
			<div class="col-lg-3 col-md-6 col-xl-2 offset-xl-1">
				<div class="sub-title">
					<div class="footer-title">
						<h4>相关信息</h4>
						<div class="divider-line"></div>
					</div>
					<div class="footer-contant">
						<ul>
							<?php $list = menu('footnav');?>
							<?php $list_id["num"] = 0;$list=is_array($list) ? $list : array();$list_id = array();$list_id["total"] = count($list);$list_id["index"] = -1;foreach($list as $key=>$value){ $list_id["num"]++;$list_id["index"]++; ?>
							<li><a href="<?php echo $value['url'];?>" title="<?php echo $value['title'];?>" target="<?php echo $value['target'];?>"><?php echo $value['title'];?></a></li>
							<?php } ?>
						</ul>
					</div>
				</div>
			</div>
			<div class="col-lg-2 col-md-6">
				<div class="sub-title">
					<div class="footer-title">
						<h4>快速导航</h4>
						<div class="divider-line"></div>
					</div>
					<div class="footer-contant">
						<ul>
							<?php $list = menu('bottom');?>
							<?php $list_id["num"] = 0;$list=is_array($list) ? $list : array();$list_id = array();$list_id["total"] = count($list);$list_id["index"] = -1;foreach($list as $key=>$value){ $list_id["num"]++;$list_id["index"]++; ?>
							<li><a href="<?php echo $value['url'];?>" title="<?php echo $value['title'];?>" target="<?php echo $value['target'];?>"><?php echo $value['title'];?></a></li>
							<?php } ?>
						</ul>
					</div>
				</div>
			</div>
			<?php $contactus = phpok('contactus');?>
			<div class="col-lg-3 col-md-6">
				<div class="sub-title">
					<div class="footer-title">
						<h4><?php echo $contactus['title'];?></h4>
						<div class="divider-line"></div>
					</div>
					<div class="footer-contant">
						<ul class="contact-list">
							<?php if($contactus['address']){ ?><li><i class="fa fa-map-marker"></i> 地址：<?php echo $contactus['address'];?></li><?php } ?>
							<?php if($contactus['tel']){ ?><li><i class="fa fa-phone"></i> 电话：<?php echo $contactus['tel'];?></li><?php } ?>
							<?php if($contactus['email']){ ?><li><i class="fa fa-envelope-o"></i> 邮箱：<?php echo $contactus['email'];?></li><?php } ?>
							<?php if($contactus['fullname']){ ?><li><i class="fa fa-user"></i> 联系人：<?php echo $contactus['fullname'];?></li><?php } ?>
						</ul>
					</div>
				</div>
			</div>
		</div>
		<div class="row social-space-b">
			<div class="col-md-4">
				<hr class="social-line">
			</div>
			<div class="col-md-4 text-center">
				<div class="footer-social">
					<?php echo $config['code']['share'];?>
				</div>
			</div>
			<div class="col-md-4">
				<hr class="social-line">
			</div>
		</div>
	</div>
	<div class="container">
		<div class="row ">
			<div class="col-md-12">
				<?php echo $config['copyright']['content'];?>
			</div>
		</div>
	</div>
</footer>
<?php $this->output("foot","file",true,false); ?>
