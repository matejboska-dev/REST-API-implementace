$(document).ready(function(){

    var id = $(".form").attr('id');


    var inputsNames = [];
    var inputsValues = []; 
    
    var inputs = $("input");

    for(var x = 0;x < inputs.length;x++){
        inputsNames.push($(inputs[x]).attr("name"));
        inputsValues.push($(inputs[x]).val());
    }

    var selectValues = [];
    var selectNames = []; 
    var selectChanged = false;
    var selects = $("select");
    for(var x = 0;x < selects.length;x++){
        selectValues.push($(selects[x]).val());
        selectNames.push($(selects[x]).attr("name"));
    }

    

    var changedInputsIndex = [];

//    var submit = $("#send-button");

    var bt2 = $("#bt2");//Zpìt

    bt2.click(function(event){
        event.preventDefault();      
        location = "tableEvents.php";
    });
    
    
    $('.form').submit(function(event) {

        event.preventDefault(); //this will prevent the default submit

        var select = $(".firms-in-event");
            select.children().each(function() {
               // if ($( this ).attr("value")==0) continue;
                $( this ).prop("selected", true);
            });
        
           $(this).unbind('submit').submit(); // continue the submit unbind preventDefault
        });
    
    
/*
    submit.click(function(event){
    //$(".form").submit(function(event){
        //event.preventDefault();
        
        inputs = $("input");

        for(var x = 0;x < inputs.length;x++){
            if($(inputs[x]).val() != inputsValues[x]){
                changedInputsIndex.push(x);
            }
        }
        var json2 = '{"id":"'+id+'",';

        var selects = $("select");
        for(var x = 0;x <selects.length;x++){
            if($(selects[x]).val() != selectValues[x]){
                selectChanged = true;             
            }
        }
        if(selectChanged){
        for(var x = 0;x <selects.length;x++){
            var input = $(selects[x]);
            json2 += '"'+input.attr("name")+'":"'+input.val()+'"';
            if(x != selects.length-1){
                json2 += ",";
            }
        }
        json2 += "}";
        }


        if(changedInputsIndex.length != 0){

            
            var json = '{"id":"'+id+'",';
            for(var x = 0;x < changedInputsIndex.length;x++){
                var input = $(inputs[changedInputsIndex[x]]);
                json += '"'+input.attr("name")+'":"'+input.val()+'"';
                if(x != changedInputsIndex.length-1){
                    json += ",";
                }
            }    
            json += "}";
            console.log(json);
            console.log("83");
            $.ajax({
                url:"editEvent.php",
                method:"POST",
                data: JSON.parse(json),
                success:function(response) {
                    console.log("OK");
                    console.log(response);
                    json = "";
                    location.href = location.href + "&data=1";
                },
                error:function(){
                    alert("error");
                }
    
             });       
        }
        if(selectChanged){
            $.ajax({
                url:"editEvent.php",
                method:"POST",
                data: JSON.parse(json2),
                success:function(response) {
                    console.log("OK");
                    console.log(response);
                    json = "";
                   //location.href = location.href + "&data=1";
                },
                error:function(){
                    alert("error");
                }
    
             });   
        }
    });*/
});