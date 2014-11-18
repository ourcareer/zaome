$(function(){
	var q10 = 950/1230;
	var q11 = 550/720;
	var q20 = 1065/1230;
	var q21 = 600/720;
	var q30 = 1065/1230;
	var q2 = 696/1065;
	var q31 = 600/720;
    var currentheight = $(window).height();
    var currentwidth = $(window).width();
    var q = currentheight / currentwidth;
    var guide_1 = $('.guide_1');
    var guide_2 = $('.guide_2');
    var guide_3 = $('.guide_3');
    var guide_1_height = q11 * currentheight + 'px';
    var guide_1_width = 1/q * guide_1_height + 'px';
    var guide_2_height = q21 * currentheight  + 'px';
    var guide_2_width = 1/q * guide_2_height  + 'px';
    var guide_3_height = q31 * currentheight + 'px';
    var guide_3_width = 1/q * guide_3_height  + 'px';
    guide_1.css('height',guide_1_height);
    guide_1.css('width',guide_1_width);
    guide_2.css('height',guide_2_height);
    guide_2.css('width',guide_2_width);
    guide_3.css('height',guide_3_height);
    guide_3.css('width',guide_3_width);
})
// $(function(){
// 	var page = $('.page');
// 	var layer_bg = $('.layer_bg');
// 	var pageheight = page.height();
// 	alert(pageheight);
// 	var windowheight =$(window).height();
// 	alert(windowheight);
// 	layer_bg_height = layer_bg.height();
// 	alert(layer_bg_height);
// 	var margintop = pageheight - layer_bg_height;
// 	alert(margintop);
// 	if (margintop > 0){
// 		pageheight -= margintop;
// 		alert(pageheight);
// 		pageheight.height(layer_bg_height);
// 		layer_bg.css('top', -margintop);
// 		page.css('top', -margintop);
// 	}else{
// 		pageheight += margintop;
// 		alert(pageheight);
// 		pageheight.height(windowheight);
// 		layer_bg.css('top', margintop);
// 	}
// })