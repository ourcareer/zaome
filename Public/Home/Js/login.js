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
    var loginheight = $('.login');
    loginheight.css('height',afterheight)

})