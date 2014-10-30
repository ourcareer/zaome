/*$(document).ready(function(){ 
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
*/
$(document).ready(function(){ 
    var Top=-426;//定义一个向上移动的距离，这个数值和你图片或DIV的高度相等 
    var Time=5000;//定义一个速度 
    function move(){ 
        $(".box").animate({"margin-top":Top},Time);//animate方法，只能对数值型的值进行渐变 
            Top+=-426;//运行一次增加一个图片的高度 
            if(Top == -1704)//判断当总高度大于你DIV或者图片总高度 
            { 
                Top=0;//把距离设置回0 
                Time=200;//加快移动速度
            } 
            else 
            { 
                Time=5000;//否则减慢速度 
            }
    }
    setInterval(move,1000);//1秒执行一次move()
})
/*$(function(){
    $('.right-top').click(function(){
        window.open('http://www.baidu.com');
    })
})*/