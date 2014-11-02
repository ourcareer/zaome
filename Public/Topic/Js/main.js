/*$(function(){
	var q10 = 950/1230;
	var q11 = 474/720;
	var q20 = 1065/1230;
	var q21 = 696/720;
	var q30 = 1066/1230;
	var q31 = 546/720;
    var currentheight = $(window).height();
    var currentwidth = $(window).width();
    var guide_1 = $('.guide_1');
    var guide_2 = $('.guide_2');
    var guide_3 = $('.guide_3');
    var guide_1_height = q10 * currentheight + 'px';
    var guide_1_width = q11 * currentwidth + 'px';
    var guide_2_height = q20 * currentheight  + 'px';
    var guide_2_width = q21 * currentwidth  + 'px';
    var guide_3_height = q30 * currentheight + 'px';
    var guide_3_width = q31 * currentwidth  + 'px';
    guide_1.css('height',guide_1_height);
    guide_1.css('width',guide_1_width);
    guide_2.css('height',guide_2_height);
    guide_2.css('width',guide_2_width);
    guide_3.css('height',guide_3_height);
    guide_3.css('width',guide_3_width);

})*/
$(function(){
	var bgheight = $('.page');
	// alert(bgheight);
	var layer_bg = $('.layer_bg');
	// var windowheight =$(window).height();
	// alert(windowheight);
	layer_bg_height = layer_bg.height();
	// alert(layer_bg_height);
	bgheight.css('height', layer_bg_height);
	// pageheight = windowheight - (windowheight - layer_bg_height);
	// alert(bgheight);
	// alert(pageheight);
})