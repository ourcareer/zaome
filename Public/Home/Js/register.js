var timeleft = 10;

function timedown( t ){

var codeurl = $('#getsmscode').val();
var codedata = "mobile=" + $("#mobile").val() + '&' + "verify=" + $('#verifycode').val();

	if( timeleft == 0 ){
		t.removeAttribute("disabled");
		t.innerHTML="免费获取短信验证码";
		timeleft = 10;
	}
	else {
		$.ajax({
				type: "POST",
				dataType: "json",
				url: codeurl,
				data: codedata,
				// console.log("aa");
				// success: function (d) {
				// 	// if (d.result == "1") {
				// 		alert("验证码发送成功");
				// 		// GetNumber();
				// 		// return true;
				// 	// }
				// }

				error: function(){

        // $(this).addClass("done");
        alert('aaadsd');
        // alert(data);

      }

      // success: function(){

      //   alert('data');

      // }
				// 	else {
				// 		alert("验证码发送失败");
				// 		return false;
				// 		}
				// 	}
				});
		// alert('aa');
		t.setAttribute("disabled", true);
		console.log("1");
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