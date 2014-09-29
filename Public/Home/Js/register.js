var timeleft = 10;
function timedown( t ){
	if( timeleft == 0 ){
		t.removeAttribute("disabled");
		t.innerHTML="免费获取短信验证码";
		timeleft = 10;
	}
	else {
		t.setAttribute("disabled", true);
		t.innerHTML=""+timeleft+"秒后再次获取";
		timeleft--;
	setTimeout(function() {
		timedown(t)
		},1000);
	}
}

$(function(){
 $("#mobilecode").click(function(){
 	timedown(this);
 })
});