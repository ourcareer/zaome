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