/**
 * 样式设计中涉及到的JS操作
 * @作者 苏相锟 <admin@phpok.com>
 * @主页 https://www.phpok.com
 * @版本 5.x
 * @授权 GNU Lesser General Public License  https://www.phpok.com/lgpl.html
 * @时间 2021年1月5日
**/

function save()
{
	var opener = $.dialog.opener;
	var id = $("#id").val();
	var style = {};
	var obj = opener.$("div[pre-id="+id+"]").find("div[pre-type=content]");
	var align = $("input[name=text-align]:checked").val();
	if(align && align != 'undefined'){
		obj.css("text-align",align);
	}else{
		obj.css("text-align",'');
	}
	var chk = /[1-9][0-9pxremvhinautot\%\s]*[pxremvhinautot\%]$/; //判断输入的内容是否符合 vm vh rem em vmin vmax px auto inherit % 及空格
	var padding = $("#padding").val();
	if(padding && padding != 'undefined'){
		if(!chk.test(padding)){
			$.dialog.alert('内边距内容不符合要求');
			return false;
		}
		obj.css("padding",padding);
	}else{
		obj.css("padding",'');
	}
	var margin = $("#margin").val();
	if(margin && margin != 'undefined'){
		if(!chk.test(margin)){
			$.dialog.alert('外边距内容不符合要求');
			return false;
		}
		obj.css("margin",margin);
	}else{
		obj.css("margin",'');
	}
	var bgcolor = $("#bgcolor").val();
	if(bgcolor && bgcolor != 'undefined'){
		obj.css("background-color",bgcolor);
	}else{
		obj.css("background-color",'');
	}
	var bgimg = $("#background-image").val();
	if(bgimg && bgimg != 'undefined'){
		obj.css("background-image","url("+bgimg+")");
		obj.css("background-size","cover");
	}else{
		obj.css("background-image",'');
	}
	var bg_position = $("input[name=bg_position]:checked").val();
	if(bg_position && bg_position != 'undefined'){
		obj.css("background-position",bg_position);
	}else{
		obj.css("background-position",'');
	}
	obj.attr("data-wow-duration",$("#data-wow-duration").val());
	obj.attr("data-wow-delay",$("#data-wow-delay").val());
	obj.attr("data-wow-offset",$("#data-wow-offset").val());
	obj.attr("data-wow-iteration",$("#data-wow-iteration").val());
	var style_in = $("#style_in").val();
	if(style_in && style_in != '0' && style_in != 'undefined'){
		obj.attr("wow-in",style_in);
		obj.attr('wow-action','true');
	}else{
		obj.attr("wow-in",'');
	}
	var style_out = $("#style_out").val();
	if(style_out && style_out != '0' && style_out != 'undefined'){
		obj.attr("wow-out",style_out);
		obj.attr('wow-action','true');
	}else{
		obj.attr("wow-out",'');
	}
	$.dialog.close();
	return false;
}

function design_update_col_style()
{
	var opener = $.dialog.opener;
	var id = $("#id").val();
	var obj = opener.$("div[pre-id="+id+"]").find("div[pre-type=content]");
	var align = obj.css("text-align");
	if(align && align != "undefined"){
		$("input[name=text-align][value="+align+"]").click();
	}
	var padding = $.admin_design.padding(obj);
	if(padding && padding != 'undefined'){
		$("#padding").val(padding);
	}
	var margin = $.admin_design.margin(obj);
	if(margin && margin != 'undefined'){
		$("#margin").val(margin);
	}
	var wow_in = obj.attr("wow-in");
	if(wow_in){
		$("#style_in").val(wow_in);
	}
	var wow_out = obj.attr("wow-out");
	if(wow_out){
		$("#style_out").val(wow_out);
	}
	$("#data-wow-duration").val(obj.attr("data-wow-duration"));
	$("#data-wow-delay").val(obj.attr("data-wow-delay"));
	$("#data-wow-offset").val(obj.attr("data-wow-offset"));
	$("#data-wow-iteration").val(obj.attr("data-wow-iteration"));
	
	var bgcolor = obj.css("background-color");
	if(bgcolor && bgcolor != 'undefined' && bgcolor != 'rgba(0, 0, 0, 0)'){
		$("#bgcolor").val(bgcolor);
	}
	var position = $.admin_design.bg_position(obj);
	var chk = /[a-zA-Z\s]$/;
	if(position && position != 'undefined' && chk.test(position)){
		$("input[name=bg_position][value='"+position+"']").click();
	}
	var bgimg = obj.css("background-image");
	if(bgimg && bgimg != 'undefined'){
		bgimg = bgimg.replace(/url\((.+)\)/g,"$1");
		bgimg = bgimg.replace(/\"/g,'');
		bgimg = bgimg.replace(/\'/g,'');
		bgimg = bgimg.replace(webroot,'');
		if(bgimg != 'none'){
			$("#background-image").val(bgimg);
		}
	}
}

$(document).ready(function(){
	design_update_col_style();
});