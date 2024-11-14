$(document).ready(function(){
    

    
    var id = $("input[name=id]").val();

    $("#save_meet").click(function(e){
        e.preventDefault();
      
        checkChange(id);
        
       
    }); 

    
 

});//doument ready


function makeJSON(id,Allelements) {
      var elements = [];
        
     for(var y = 0;y < Allelements.length;y++){
     
        var Allelements2 = $(Allelements[y]);
        
       for(var z = 0;z < Allelements2.length;z++){
       
       
          elements.push(Allelements2[z]);
       
      }
    
    }
    
    var json = '{"id":"'+id+'",';
        for(var x = 0;x < elements.length;x++){
			
            var element = $(elements[x]);
             
			 if (element.attr("class")=="select") {
                json += '"'+element.attr("name")+'":"'+element.find(":selected").val()+'"';
             }
             else
                {
                json += '"'+element.attr("name")+'":"'+element.val().replace(/\n/g, '\\n')+'"';
                }
                console.log (json);
                if(x != elements.length-1){
                    json += ",";
                }
        }
        json += "}";
    
    return json;
}

function checkChange(id){
    $(".editFirmSuccess").hide();
    
    var elements = [".form input[name=date_time]",".form input[name=firm_id]",".form textarea[name=notes]",".form input[name=id]"];
      
    var changedElementsIndex = [];

    
    //pøidání 
    if (id==0 || id==undefined) {
      a_url="/meets/addMeet.php";
      id=0;
      var json =  makeJSON(id,elements);
      console.log(json);
    
      $.when($.ajax({
              url:a_url,
              method:"POST",
              data: JSON.parse(json),
              success:function(response) {
                  
                  console.log("ok");
                  $(".editFirmSuccess").show().fadeOut(2500);
                  
                     
              },
              error:function(){
                  alert("error90");
              }
  
           }));
           return 1;
         }
    else{//aktualizace
    
    var json =  makeJSON(id,elements);
    
        a_url="/meets/editMeet.php";
    
        $.when($.ajax({
            url:a_url,
            method:"POST",
            data: JSON.parse(json),
            success:function(response) {
                console.log("ok edit");
                $(".editFirmSuccess").show().fadeOut("slow");
                   
            },
            error:function(){
                alert("error106");
            }

         }));

    }
        return 0;
    
    
    
}



function updateRow(d, update,id) {
$(".editFirmSuccess").show();
   
    //console.log(d,d["surname"]);
    
    t =$('#basic');
    r= $('#basic tr');
    
    odd=r.length%2;
    if (odd) r_odd="even";else r_odd="odd"; 
    
    row='<tr id="'+d["id"]+'" class="rownum1 '+r_odd+'"><td><input type="checkbox" class="check" id="'+d["id"]+'"></td>';
    
    r1=r[r.length-1].children;
    
    for (i=1;i<r1.length;i++) {
    elm=r1[i];
    //console.log(elm);
    css_class=elm.classList[0];
    
    
    if (update) $("tr.rownum"+id+" ."+css_class).html(d[css_class]);
    
    //console.log("tr.rownum"+id+" ."+css_class,css_class, d[css_class]);
    
    row+='<td class="click '+css_class+'">';
    if (d[css_class]===undefined)
        row+'';
    else
        row+=d[css_class];
    
    '</td>';
    
    
    
        
}
row+='</tr>';


if (!update)

t.prepend(row);

}


