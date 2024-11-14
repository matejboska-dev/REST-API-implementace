function layout(a) {
	 $("#basic_wrapper").css("width",$( window ).innerWidth()*a - 20);
     $("#basic_wrapper").css("max-width",$( window ).innerWidth()*a - 20);
        
	
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




function editClick(id) {
    //console.log(event.target.parentElement.id);
        document.getElementById('frame2').src = 'editFirm/editFirmForm.php?id='+id ;
        //$(".form").attr("id",event.target.parentElement.id);
        $('.myframe2').show();
        $('.myframe').show();
        var iframe = document.getElementById("frame2");
        iframe.onclose = function () {
            $('.myframe2').hide();
            $('.myframe').hide();
            location.reload();
        };
        //showFirmEdit();
}


function addClick() {
$(".overlay").hide();
	layout(1);
    var tr = $(".name");
	//console.log(tr);
    tr.click(function(event){
    editClick(event.target.parentElement.id) 
            
    });
        
}



$(document).ready(function(event){
	addClick();



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


$(".paginate_button").each (function(event){

$(this).click(function(event){
     addClick();
     });
 
      });
     $(".overlay button").click(function(event){
     hideFirmEdit();
     });
     
     

});