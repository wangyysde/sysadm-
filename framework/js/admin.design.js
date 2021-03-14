/**
 * 可视化设计器
 * @作者 苏相锟 <admin@phpok.com>
 * @主页 https://www.phpok.com
 * @版本 5.x
 * @授权 GNU Lesser General Public License  https://www.phpok.com/lgpl.html
 * @时间 2021年1月5日
**/

;(function($){
	$.admin_design = {
		padding:function(obj)
		{
			var top = obj.css("padding-top");
			var bottom = obj.css("padding-bottom");
			var right = obj.css("padding-right");
			var left = obj.css("padding-left");
			if(top == bottom && left == right && top == right){
				if(top == '0' || top == '0px' || top == '0%'){
					return false;
				}
				return top;
			}
			if(top == bottom && left == right && top != right){
				return top+' '+right;
			}
			return top+' '+right+' '+bottom+' '+left;
		},
		margin:function(obj)
		{
			var top = obj.css("margin-top");
			var bottom = obj.css("margin-bottom");
			var right = obj.css("margin-right");
			var left = obj.css("margin-left");
			if(top == bottom && left == right && top == right){
				if(top == '0' || top == '0px' || top == '0%'){
					return false;
				}
				return top;
			}
			if(top == bottom && left == right && top != right){
				return top+' '+right;
			}
			return top+' '+right+' '+bottom+' '+left;
		},
		bg_position:function(obj)
		{
			var str = obj.css("background-position");
			console.log(str);
			if(!str){
				return false;
			}
			var list = str.split(" ");
			var bg_left = bg_right = '';
			if(list[0] == '0%'){
				bg_left = 'left';
			}
			if(list[0] == '50%'){
				bg_left = 'center';
			}
			if(list[0] == '100%'){
				bg_left = 'right';
			}
			if(list[1] == '0%'){
				bg_right = 'top';
			}
			if(list[1] == '50%'){
				bg_right = 'center';
			}
			if(list[1] == '100%'){
				bg_right = 'bottom';
			}
			return bg_left+' '+bg_right;
		}
	}
})(jQuery);