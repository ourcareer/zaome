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

var InterValObj; //timer变量，控制时间
var count = 90; //间隔函数，1秒执行
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
$(function(){
 $("#mobilecode").click(function(){
    sendMessage();
 })
});
$(function(){
    var currentheight = $(document).height();
    var afterheight = (currentheight - 82) + 'px';
    var registerheight = $('#register-content');
    registerheight.css('height',afterheight)
})
function checkSubmitMobil() {
    var regmobile = $('#reg-mobile');
    var mobileerror = $('#mobile-error');
    var mobileaddon = $('.mobileaddon');
    var glyphicon = $('#glyphicon');
    var mobile = $("#mobile").val();
    if (mobile == "") {
        regmobile.removeClass('has-success');
        regmobile.addClass('has-error');
        mobileerror.text('手机号码不能为空！')
        mobileerror.css('display', 'block');
        mobileerror.focus(); 
        return false;
    }
    if (!(mobile.match(/^13\d{9}$/) || mobile.match(/^15[0-35-9]\d{8}$/) || mobile.match(/^18\d{9}$/))){ 
        regmobile.removeClass('has-success');
        regmobile.addClass('has-error');
        mobileerror.css('display', 'none');
        mobileerror.text('手机号码格式不正确!')
        mobileerror.css('display', 'block');
        $("#mobile").focus(); 
        return false;
    }
    else{
        mobileerror.css('display', 'none');
        glyphicon.removeClass('glyphicon-earphone');
        glyphicon.addClass('glyphicon-ok');
        regmobile.removeClass('has-error');
        regmobile.addClass('has-success');
        return true;
    }
}