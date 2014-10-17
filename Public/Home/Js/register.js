var InterValObj; //timer变量，控制时间
var count = 60; //间隔函数，1秒执行
var curCount;//当前剩余秒数
function sendMessage() {
    var codeurl = $('#getsmscode').val();
    var codedata = "mobile=" + $("#mobile").val() + '&' + "verify=" + $('#verify').val();
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
                        alert("验证码已成功发送，请耐心等待！");
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
var code ; //在全局定义验证码
function createCode(){ 
    code = "";
    var codeLength = 5;//验证码的长度
    var checkCode = document.getElementById("checkCode");
    checkCode.value = "";

    var selectChar = new Array(0,1,2,3,4,5,6,7,8,9,'A','B','C','D','E','F','G','H','J','K','L','M','N','P','Q','R','S','T','U','V','W','X','Y','Z');

    for(var i=0;i<codeLength;i++) {
       var charIndex = Math.floor(Math.random()*34);
       code +=selectChar[charIndex];
    }
    if(code.length != codeLength){
       createCode();
    }
    checkCode.value = code;
}

function validate () {//验证验证码正确与否
    
    var inputCode = document.getElementById("verifycode").value.toUpperCase();

    if(inputCode.length <=0) {
       alert("请输入验证码！");
       return false;
    }
    else if(inputCode != code ){
       alert("验证码输入错误！");
       createCode();
       return false;
    }
}
$(function(){
 $("#mobilecode").click(function(){
    sendMessage();
 })
});

$(function(){
var verifyimg = $(".verifyimg").attr("src");
    $(".reloadverify").click(function(){
        if( verifyimg.indexOf('?')>0){
            $(".verifyimg").attr("src", verifyimg+'&random='+Math.random());
        }else{
            $(".verifyimg").attr("src", verifyimg.replace(/\?.*$/,'')+'?'+Math.random());
        }
    });
});

$(function(){
    var currentheight = $(document).height();
    var afterheight = (currentheight - 82) + 'px';
    var registerheight = $('#register-content');
    registerheight.css('height',afterheight)

})