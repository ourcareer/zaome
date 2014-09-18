// 需要使用这个函数之后弹出框才能出现
$(document).ready(function (){
	$("#option1").click(function(){
		$(".arrow")[0].style.left="134px";
	});
	$("#option2").click(function(){
		$(".arrow")[0].style.left="213px";
	});
	$("#option3").click(function(){
		$(".arrow")[0].style.left="290px";
	});
	$("#option4").click(function(){
		$(".arrow")[0].style.left="368px";
	});
});