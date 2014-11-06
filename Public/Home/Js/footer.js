$(function(){ 
		var qrcode = $('#qrcode');
		var footer = $('#footer'); 
        document.onclick=function(e){  
           var e=e?e:window.event;  
           var tar = e.srcElement||e.target;  
           if(tar.id!="qrcode"){  
               $("#qrcode span").hide();
			         // footer.css("padding","15px 0");
           }else{
           		// footer.css("padding","45px 0 0");
           		$('#qrcode span').show();
           }
         }  
 }) 