function layout(a) {
	 $("#basic_wrapper").css("width",$( window ).innerWidth()*a - 20);
     $("#basic_wrapper").css("max-width",$( window ).innerWidth()*a - 20);
       
	
}

function isEmail(email) {
  var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
  return regex.test(email);
}


function showFirmEdit() {

    getFirm(url,event.target.parentElement.id);
   
       
		layout(0.60);
        
		$(".overlay").show();
}

function hideFirmEdit() {

        layout(1);
		$(".overlay").hide();
        
}


function editClick(id,button) {
    
         
    
        $('.myframe2').show();
        $("#invalid_contacts").val("");
         if (id>0) {
         
         getFirm(url,id);
         getFirmHidenColmn(url,id);//skryté sloupce
         getFirmContacts(url,id);
         getMeets(url,id);
         //console.log(url,id);         
         $('.myframe2 form').attr("id",id);
         //pro nahrávač obrázků
         
            $('.uploader_container #firm_id').val(id);
           $('.uploader_container #firm_id').show();
         
            loadFirmPhotos(id);
         
         
         }else { getFirmHidenColmn2(url);}
        /*var iframe = document.getElementById("frame2");
        iframe.onclose = function () {
            $('.myframe2').hide();
        };*/
    
}


function addClick() {

	layout(1);
    var tr = $(".name");
	
    tr.each(function() {
    
    $(this).click(function(event){
    
        editClick(event.target.parentElement.id,event.which);
    });        
    
     $(this).mousedown(function(event) {
         if (event.which==3) {
         
        
        navigator.clipboard.writeText($(this).parent().children(".email").attr("title"));
        }
     
     });
    
    });
        
}



$(document).ready(function(event){
	addClick();

  $("input[name=email").on("change, keyup",function(event){
  
    $(this).removeClass("success");
    $(this).removeClass("error");
          
          
  if (isEmail($(this).val())) {
       $(this).toggleClass("success");
  
  }else {
  
       $(this).toggleClass("error");
  }

});



     var eb =$("#edit-btn");
        eb.click(function(){
        var id = $(".check:checked").attr("id");
        $(".form").attr("id",id);
        //console.log(id);
        
        if (id!=undefined) {
        
        editClick(id);  
        
          //  showFirmEdit() - starý form
       
        }
        
    });
    var eb2 =$("#link");
        eb2.click(function(){
        editClick(0);
       
    });

 //kontrola exitence přidávané firmy  
      $("#name").keyup(function(event){
      
        $("#name").removeClass("success");
        $("#name").removeClass("error");
        
        var name = $("#name").val();
        if (name.length<2) return;
        
        
        
        $.get("firms/checkIfFirmExist.php?firm-name="+ name, function(data, status){
            if(data == 1){
              $("#name").toggleClass("error");
                          
        }
        else {
              $("#name").toggleClass("success");
              
        }
        
      });
    });


$(".paginate_button").each (function(event){

    $(this).click(function(event){
     addClick();
     });
 
      });
     $(".overlay button").click(function(event){
     hideFirmEdit();
     });
     
     
     
 $(".h2_extra_colmns").click(function(){
  $(".extra_colmns").toggle();
});    
     

});


function loadFirmPhotos(id) {

 $.get("/procedure.php?cmd=getFirmPhotos&id="+ id, function(data, status){
 //console.log(data,data.length,data[1]);
 //console.log();
 anne="";       
        for (i=0;i<data.length;i++) {
        
        
        anne+="<img src='"+data[i]+"' class='thumbnail'>";
        
        }
        $("#firm_photos").html(anne);
        
        
      });


}