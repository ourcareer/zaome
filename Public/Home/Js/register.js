var InterValObj; //timer变量，控制时间
var count = 60; //间隔函数，1秒执行
var curCount;//当前剩余秒数
function sendMessage() {
    var codeurl = $('#getsmscode').val();
    var codedata = "mobile=" + $("#mobile").val() + '&' + "verify=" + $('#verifycode').val();
            curCount = count;
            
            //设置button效果，开始计时
                $('#mobilecode').attr("disabled", true);
                $('#mobilecode').val("" + curCount + "秒后再次获取");
                InterValObj = window.setInterval(SetRemainTime, 1000); //启动计时器，1秒执行一次
//向后台发送处理数据
                $.ajax({
                type: "POST",
                url: codeurl,
                data: codedata,
                success: function(d){
                    if (d.code == '200191905'){
                        alert("验证码发送成功");
                    }
                }
            });
            }
        //timer处理函数
function SetRemainTime() {
            if (curCount == 0) {                
                window.clearInterval(InterValObj);//停止计时器
                $('#mobilecode').removeAttr("disabled");
                $('#mobilecode').val("免费获取短信验证码");
            }
            else {
                curCount--;
                console.log('test');
                $('#mobilecode').val("" + curCount + "秒后再次获取");
            }
        }

$(function(){
 $("#mobilecode").click(function(){
    sendMessage();
 })
});