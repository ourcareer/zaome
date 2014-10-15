$(document).ready(function() {
	$(window).scroll(function(){
		var top = $(document).scrollTop();
		var menu = $("#menu");
		var items = $("#content").find(".item");
		items.each(function(){
			var m = $(this);
			var itemTop = m.offset().top;
			// console.log(itemTop);
			if (top > itemTop - 150){
				currentId = "#" + m.attr("id")
			}else{
				return false;
			}
		})
		//给相应楼层的a设置current，取消其它楼层a的current
		var currentLink = menu.find(".current");
		if(currentId && currentLink != currentId){
			currentLink.removeClass('current');
			menu.find("[href=" + currentId + "]").addClass('current');
		}
	})
});