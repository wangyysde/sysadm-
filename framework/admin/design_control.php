<?php
/**
 * 页面设计器
 * @作者 qinggan <admin@phpok.com>
 * @主页 http://www.phpok.com
 * @版本 5.x
 * @授权 http://www.phpok.com/lgpl.html 开源授权协议：GNU Lesser General Public License
 * @时间 2018年05月30日
**/

class design_control extends phpok_control
{
	public function __construct()
	{
		parent::control();
	}

	/**
	 * 读取可能需要用到的块信息
	**/
	public function index_f()
	{
		$id = $this->get('id');
		if(!$id){
			$this->error('未指定ID');
		}
		$this->assign('id',$id);
		$this->view('design_layer');
	}

	public function code_f()
	{
		$id = $this->get('id');
		if(!$id){
			$this->error('未指定ID');
		}
		$this->assign('id',$id);
		$content_html = form_edit('content','','code_editor','height=500&width=750');
		$this->assign('content_html',$content_html);
		$this->view('design_code');
	}

	public function content_f()
	{
		$id = $this->get('id');
		if(!$id){
			$this->error('未指ID');
		}
		$this->assign('id',$id);
		$type = $this->get('type');
		if(!$type){
			$type = 'editor';
		}
		$this->assign('type',$type);
		if($type == 'editor'){
			$content_html = form_edit('content','','editor','height=320');
			$this->assign('content_html',$content_html);
		}
		if($type == 'code'){
			$content_html = form_edit('content','','code_editor','height=420&width=720');
			$this->assign('content_html',$content_html);
		}
		if($type == 'image'){
			$res_id = $this->get('res_id','int');
			$content_html = form_edit('content',$res_id,'upload','');
			$this->assign('content_html',$content_html);
			$gdlist = $this->model('gd')->get_all();
			$this->assign('gdlist',$gdlist);
		}
		if($type == 'calldata'){
			$rslist = $this->model('call')->get_list('',0,9999);
			if($rslist){
				$typelist = $this->model('call')->types();
				foreach($rslist as $key => $value){
					$value['typename'] = $typelist[$value['type_id']] ? $typelist[$value['type_id']]['title'] : $value['type_id'];
					$rslist[$key] = $value;
				}
				$this->assign('rslist',$rslist);
			}
			$glist = array();
			//读取模板记录
			$syslist = $this->model('design')->tplist($this->dir_data.'design/');
			if($syslist){
				$tmp = array('title'=>'系统','rslist'=>$syslist);
				$glist[] = $tmp;
			}
			if($this->site && $this->site['tpl_id']){
				$tpl_rs = $this->model('tpl')->get_one($this->site['tpl_id']);
				$wwwlist = $this->model('design')->tplist($this->dir_root.'tpl/'.$tpl_rs['folder'].'/design/');
				if($wwwlist){
					$tmp = array('title'=>$tpl_rs['title'],'rslist'=>$wwwlist);
					$glist[] = $tmp;
				}
			}
			$this->assign('tplist',$glist);
		}
		$this->view('design_content');
	}

	public function tpl_f()
	{
		if(!$this->session->val('admin_rs.if_system')){
			$this->error('仅限超级管理员有权限操作');
		}
		$id = $this->get('id');
		$rs = array();
		$glist = array();
		//读取模板记录
		$syslist = $this->model('design')->tplist($this->dir_data.'design/');
		if($syslist){
			if($id && $syslist[$id]){
				$rs = $syslist[$id];
			}
			$tmp = array('title'=>'系统','rslist'=>$syslist);
			$glist[] = $tmp;
		}
		if($this->site && $this->site['tpl_id']){
			$tpl_rs = $this->model('tpl')->get_one($this->site['tpl_id']);
			$wwwlist = $this->model('design')->tplist($this->dir_root.'tpl/'.$tpl_rs['folder'].'/design/');
			if($wwwlist){
				if($id && $wwwlist[$id]){
					$rs = $wwwlist[$id];
				}
				$tmp = array('title'=>$tpl_rs['title'],'rslist'=>$wwwlist);
				$glist[] = $tmp;
			}
			$this->assign('tpl_rs',$tpl_rs);
		}
		if($id && $rs){
			$tplfile = $this->dir_root.$rs['tplfile'].'.html';
			$content = $this->lib('file')->cat($tplfile);
			$content_html = form_edit('content',$content,'code_editor','height=420&width=720');
			
			$this->assign('rs',$rs);
		}else{
			$content_html = form_edit('content','','code_editor','height=420&width=720');
		}
		$this->assign('content_html',$content_html);
		$this->assign('id',$id);
		$this->assign('tplist',$glist);
		$this->view("design_tpl");
	}

	public function tplsave_f()
	{
		if(!$this->session->val('admin_rs.if_system')){
			$this->error('仅限超级管理员有权限操作');
		}
		$id = $this->get('id');
		if(!$id){
			$id = $this->get('tplfile');
		}
		if(!$id){
			$this->error('未指定要创建的文件');
		}
		$id = str_replace("../","",$id);
		if(!$id){
			$this->error('未指定要创建的文件');
		}
		if(!preg_match("/^[a-zA-Z\_][a-z0-9A-Z\_\-\/\.]+$/u",$id)){
			$this->error('创建的文件不符合系统限制，仅支持字母a-z，数字0-9，下划线_及斜杠/');
		}
		$basename = basename($id);
		if($id == 'preview' || $id == 'preview.html'){
			$this->error('预览文件不支持操作');
		}
		$folder = $this->dir_root.$id;
		if(is_dir($folder)){
			$this->error('文件夹不允许操作');
		}
		$ext = substr($id,-5);
		$ext = strtolower($ext);
		if($ext == '.html'){
			$id = substr($id,0,-5);
		}
		$t = explode('/',$id);
		if($t[0] != '_data' && $t[0] != 'tpl'){
			$this->error('数据异常，不能写入');
		}
		$data = array();
		$data['title'] = $this->get('title');
		$data['note'] = $this->get('note');
		$data['img'] = $this->get('img');
		$content = $this->get('content','html_js');
		$file = $this->dir_root.$id.'.html';
		$this->lib('file')->vim($content,$file);
		$phpfile = $this->dir_root.$id.'.php';
		$this->lib('file')->vi($data,$phpfile,'config');
		$this->success();
	}

	public function style_f()
	{
		$id = $this->get('id');
		if(!$id){
			$this->error('未指定层');
		}
		$this->assign('id',$id);
		$this->addjs('js/jscolor/jscolor.js');
		$inlist = $this->_in_style();
		$this->assign("inlist",$inlist);
		$outlist = $this->_out_style();
		$this->assign("outlist",$outlist);
		$this->view("design_style");
	}

	public function tplfile_f()
	{
		$filename = $this->get('filename');
		if(!$filename){
			$this->error('未指定文件');
		}
		$ext = substr($filename,-5);
		$ext = strtolower($ext);
		$tplfile = $filename;
		if($ext != '.html'){
			$tplfile = $filename.'.html';
		}else{
			$tplfile = $filename;
			$filename = substr($filename,0,-5);
		}
		if(!file_exists($this->dir_root.$tplfile)){
			$this->error('模板文件不存在');
		}
		$data = $this->model('design')->tpl_info($filename);
		if(!$data){
			$this->error('文件不存在');
		}
		$this->success($data);
	}

	public function layer_setting_f()
	{
		$id = $this->get('id');
		if(!$id){
			$this->error('未指定ID');
		}
		$this->assign('id',$id);
		$this->addjs('js/jscolor/jscolor.js');
		$this->view('design_attr');
	}

	public function layer2_f()
	{
		$id = $this->get('id');
		if(!$id){
			$this->error('未指定ID');
		}
		$this->assign('id',$id);
		$this->view('design_sub');
	}

	private function _in_style()
	{
		$dlist = array();
		$dlist['0'] = "无动画";
		$dlist['bounce'] = "弹跳";
		$dlist['flash'] = "闪烁";
		$dlist['pulse'] = "放大，缩小";
		$dlist['rubberBand'] = "放大，缩小，弹簧";
		$dlist['shake'] = "左右晃动";
		$dlist['headShake'] = "左右小幅晃动";
		$dlist['swing'] = "左右扇形摇摆";
		$dlist['tada'] = "放大，左右上下晃动，缩小";
		$dlist['wobble'] = "左右小幅扇形摇摆";
		$dlist['jello'] = "左右左右上下晃动";
		$dlist['bounceIn'] = "重复放大缩小";
		$dlist['bounceInDown'] = "从上到下出现，弹簧";
		$dlist['bounceInLeft'] = "从左到右出现，弹簧";
		$dlist['bounceInRight'] = "从右到左出现，弹簧";
		$dlist['bounceInUp'] = "从下到上出现，弹簧";
		$dlist['fadeInDown'] = "渐现，从上到下";
		$dlist['fadeInDownBig'] = "渐现，从上到下，滑动距离较长";
		$dlist['fadeInLeft'] = "渐现，从左到右";
		$dlist['fadeInLeftBig'] = "渐现，从左到右，滑动距离较长";
		$dlist['fadeInRight'] = "渐现，从右到左";
		$dlist['fadeInRightBig'] = "渐现，从右到左，滑动距离较长";
		$dlist['fadeInUp'] = "渐现，从下到上";
		$dlist['fadeInUpBig'] = "渐现，从下到上，滑动距离较长";
		$dlist['flip'] = "中心Y轴旋转，放大，缩小";
		$dlist['flipInX'] = "中心X轴旋转";
		$dlist['flipInY'] = "中心Y轴旋转";
		$dlist['lightSpeedIn'] = "从右到左，平行四边形，左上角进入";
		$dlist['rotateIn'] = "中心顺时针旋转进入";
		$dlist['rotateInDownLeft'] = "左外长半径顺时针旋转进入";
		$dlist['rotateInDownRight'] = "右外长半径逆时针旋转进入";
		$dlist['rotateInUpLeft'] = "左外长半径逆时针旋转进入";
		$dlist['rotateInUpRight'] = "右外长半径顺时针旋转进入";
		$dlist['zoomIn'] = "由小变大进入";
		$dlist['zoomInDown'] = "由小变大，从上方进入";
		$dlist['zoomInLeft'] = "由小变大，从左方进入";
		$dlist['zoomInRight'] = "由小变大，从右方进入";
		$dlist['zoomInUp'] = "由小变大，从下方进入";
		$dlist['slideInDown'] = "从上到下，平滑进入";
		$dlist['slideInLeft'] = "从左到右，平滑进入";
		$dlist['slideInRight'] = "从右到左，平滑进入";
		$dlist['slideInUp'] = "从下到上，平滑进入";
		return $dlist;
	}

	private function _out_style()
	{
		$dlist = array();
		$dlist['0'] = '无动画';
		$dlist['bounceOut'] = "常规到小消失，弹簧";
		$dlist['bounceOutDown'] = "常规到小，下方消失，弹簧";
		$dlist['bounceOutLeft'] = "常规到小，左方消失，弹簧";
		$dlist['bounceOutRight'] = "常规到小，右方消失，弹簧";
		$dlist['bounceOutUp'] = "常规到小，上方消失，弹簧";
		$dlist['fadeOut'] = "渐隐";
		$dlist['fadeOutDown'] = "渐隐，从上到下";
		$dlist['fadeOutDownBig'] = "渐隐，从上到下，滑动距离较长";
		$dlist['fadeOutLeft'] = "渐隐，从左到右";
		$dlist['fadeOutLeftBig'] = "渐隐，从左到右，滑动距离较长";
		$dlist['fadeOutRight'] = "渐隐，从右到左";
		$dlist['fadeOutRightBig'] = "渐隐，从右到左，滑动距离较长";
		$dlist['fadeOutUp'] = "渐隐，从下到上";
		$dlist['fadeOutUpBig'] = "渐隐，从下到上，滑动距离较长";
		$dlist['flipOutX'] = "中心X轴旋转，消失";
		$dlist['flipOutY'] = "中心Y轴旋转，消失";
		$dlist['rotateOut'] = "中心顺时针旋转消失";
		$dlist['rotateOutDownLeft'] = "左外长半径顺时针旋转消失";
		$dlist['rotateOutDownRight'] = "右外长半径逆时针旋转消失";
		$dlist['rotateOutUpLeft'] = "左外长半径逆时针旋转消失";
		$dlist['rotateOutUpRight'] = "右外长半径顺时针旋转消失";
		$dlist['hinge'] = "右上到左下顺时针消失";
		$dlist['zoomOut'] = "由大变小，消失";
		$dlist['zoomOutDown'] = "由大变小，从下方消失";
		$dlist['zoomOutLeft'] = "由大变小，从左方消失";
		$dlist['zoomOutRight'] = "由大变小，从右方消失";
		$dlist['zoomOutUp'] = "由大变小，从上方消失";
		$dlist['slideOutDown'] = "从上到下，平滑消失";
		$dlist['slideOutLeft'] = "从右到左，平滑消失";
		$dlist['slideOutRight'] = "从左到右，平滑消失";
		$dlist['slideOutUp'] = "从下到上，平滑消失";
		return $dlist;
	}
}
