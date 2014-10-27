$(function(){
	var main = $('#main-con');
    var login = $('.login');
    var register = $('.register');
    var mask = $('#mask');
 $(".loginbtn").click(function(){
    main.css('display', 'none');
    mask.css('display','block');
    login.css('display','block');
 })
 $("#login-close").click(function(){
    login.css('display', 'none');
    mask.css('display','none');
    main.css('display','block');
 })
 $(".regbtn").click(function(){
    main.css('display', 'none');
    mask.css('display','block');
    register.css('display','block');
 })
 $(".reg-close").click(function(){
    register.css('display', 'none');
    mask.css('display','none');
    main.css('display','block');
 })
});
$(document).ready(function(){ 
    var Top=-426;//定义一个向上移动的距离，这个数值和你图片或DIV的高度相等 
    var Time=500;//定义一个速度 
    function move(){ 
        $(".box").animate({"margin-top":Top},Time);//animate方法，只能对数值型的值进行渐变 
        Top+=-426;//运行一次增加一个图片的高度 
        if(Top==-1704)//判断是不是最后一个向上移动的图片 
        { 
            clearInterval(up);//停止动画 
        }
    } 
        var up = setInterval(move,3000);//3秒执行一次move() 
}) 