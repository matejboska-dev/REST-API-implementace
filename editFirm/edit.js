$(document).ready(function(){
    

    
    var id = $(".form").attr('id');

    $("#send-button").click(function(e){
        e.preventDefault();
        var id = $(".form").attr('id');
        checkChange(id);
        
       
    }); 

    $("#delete").click(function(event){
        event.preventDefault();
        $("#complexConfirm").confirm();
        
    });

    $(".close").click(function(){
        parent.closeIFrame2();
        clearEditFirmForm();
    });
 

 $('input[name^=surname').on('change', function() {
                const input = $(this).val();
                const regex = /(.*) <(.*)>/;
                const matches = input.match(regex);
                
                if (matches) {
                    $(this).val(matches[1]);
                    $('input[name^=email').val(matches[2]);
                } 
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
             
             if (element.attr("name")=="main") {
             console.log(element,element.prop( "checked"));
             
                if (element.prop( "checked"))
                    json += '"main":"'+element.val()+'"';
                    else json += '"nic":"0"'; 
             
             }
             
             else
             
             if (element.attr("class")=="checkbox") {
             //console.log(element);
                if (element.prop( "checked"))
                    json += '"'+element.attr("name")+'":"1"';
                    else json += '"'+element.attr("name")+'":"0"'; 
             }
             
             else
             {
    			 if (element.attr("class")=="select") {
                    json += '"'+element.attr("name")+'":"'+element.find(":selected").val()+'"';
                     
                 }
                 else
                    {
                    json += '"'+element.attr("name")+'":"'+element.val().replace(/\n/g, '\\n')+'"';
                    }
                }               
                
                if(x != elements.length-1){
                    json += ",";
                }
        }
        json += "}";
    console.log (json);
    return json;
}

function checkChange(id){
    $(".editFirmSuccess").hide();
    //console.log(id);
    
     var elements = [".form input",".form textarea",".form select"];
      
    var changedElementsIndex = [];

    
    //pøidání firmy
    if (id==0 || id==undefined) {
      a_url="/firms/insertFirm.php";
      a_url="/editFirm/editFirm.php";
      id=0;
      var json =  makeJSON(id,elements);
      console.log(json);
    
      $.when($.ajax({
              url:a_url,
              method:"POST",
              data: JSON.parse(json),
              success:function(response) {
                  
                  console.log("ok");
                  //var json =  makeJSON(response,element);
                  var json_des = JSON.parse(json);
                  json_des["id"] = response;
                  
                  updateRow(json_des,false,response);  
                     
              },
              error:function(){
                  alert("error64");
              }
  
           }));
           return 1;
         }
    else{//editace
    
    var json =  makeJSON(id,elements);
    
        a_url="/editFirm/editFirm.php";
    
        $.when($.ajax({
            url:a_url,
            method:"POST",
            data: JSON.parse(json),
            success:function(response) {
                console.log("ok edit");
                   
            },
            error:function(){
                alert("error64");
            }

         })).done(function(){
            updateRow(JSON.parse(json),true,id);  
            return 1;
        });

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


