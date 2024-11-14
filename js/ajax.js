function getFirm(url,id) {  

$.getJSON( url+"procedure.php?cmd=getFirm&id="+id, function( data ) {
  
  var html="";
  $.each( data, function( key, val ) {
    if (val!==null)
        $("input[name="+key).val(val);
        if (key=="note") $("textarea[name="+key).val(val);

  });
    

});  
}
  
function tabClear(tabs) {

$("input[name^=contatct_id").val("");
        $("input[name^=surname").val("");
        $("input[name^=email").val("");
        $("label[for^=email] a").attr("href","https://outlook.office.com/mail/deeplink/search?query=from:");
        $("input[name^=phone").val("");
        $("input[name^=active_c").val("");
        $("input[name^=main").val("");
        
        $("input[name^=active_c").prop( "checked", false );

    var li = tabs.find("li");
    var div = tabs.find("li");
    for (i=1;i<li.length;i++) {
    
        li[i].remove();
        div[i].remove();
    }
}  
  
  
function getFirmContacts(url,id) {  

$.getJSON( url+"procedure.php?cmd=getFirmContacts&id="+id, function( data ) {
  
  var html="";
  var tabs="";
  var x=0;
  
  tabClear($( "#kontakty-tabs" ));
  
  var tabs=$( "#kontakty-tabs" ).tabs({
      active: 1
    });
  $.each( data, function( key, val ) {
     
     
    x++;
     
     if (key==0) {
     
     
        $("input[name^=contatct_id").val(val["contatct_id"]);
        $("input[name^=surname").val(val["surname"]);
        $("input[name^=email").val(val["email"]);
        $("label[for^=email] a").attr("href",$("label[for^=email] a").attr("href")+val["email"]);
        $("input[name^=phone").val(val["phone"]);
        $("input[name^=active_c").val(val["contatct_id"]);
        $("input[name^=main").val(val["contatct_id"]);
        
        if (val["active_c"]==1) $("input[name^=active_c").prop( "checked", true );
        
     
     
     } else
     {
     
     
     addTab(tabs,key+1,val["surname"],createTabKontakt(key,val["surname"],val["email"],val["phone"],val["contatct_id"],val["contatct_id"])) ;      
     
     /*
     html=$("#invalid_contacts").val();
     if (val["active"]=="1") 
        html+="platný: ";
     else    
        html+="neplatný: ";
     html+=val["surname"]+" "+val["email"]+" "+val["phone"];
     
     //$("#invalid_contacts").val(html+"\n");
     console.log(html);
     */
     
     
     }
     
     if (val["main"]==1 ) { $("input[value='"+val["contatct_id"]+"'").prop('checked',true);
     
    // console.log("input[value='"+val["contatct_id"]+"'");
     }
        
  });
    
    
    addTab(tabs,x+1,"+",createTabKontakt(x,"","","","",""));
          
});  
}
function createTabKontakt(i, surname,email,phone,active,contatct_id) {
if (active==1) d="checked"; else d=""; 
return '<p class="field half">'+
      '<input type="hidden" name="contatct_id['+i+']" value="'+contatct_id+'">'+
    '<input class="checkbox" name="active_c['+i+']" type="checkbox" value="'+active+'" '+d+'> Aktivní</p><p class="field half"><input class="radio" name="main" type="radio" value="'+contatct_id+'" id="radio-main'+i+'" > <label for="radio-main'+i+'">Hlavní</label></p>'+

  '<p class="field">'+
    '<label class="label" for="surname">Jméno</label>'+
    '<input class="text-input" name="surname['+i+']" type="text" value="'+surname+'"></p>'+
  '<p class="field">'+
'    <label class="label" for="email">E-mail <a href="https://outlook.office.com/mail/deeplink/search?query=from:'+email+'" target="_blank">&#x1F4E7;</a></label>'+
 '   <input class="text-input" name="email['+i+']" type="email" value="'+email+'">'+
  '</p>'+
  '<p class="field">'+
'    <label class="label" for="phone">Telefon</label>'+
 '   <input class="text-input" name="phone['+i+']" type="tel" value="'+phone+'">'+
'  </p>';
}

function addTab(tabs,i, t,content) {
  var li = $("<li><a href='#kontakt-"+i+"'>"+t+"</a></li>");
  tabs.find( "ul li:last-child").after( li ); //changed this line
  tabs.append( "<div id='kontakt-"+i+"'>"+content+"</div>" );
  tabs.tabs( "refresh" );
}




function getMeet(url,id) {
  $.getJSON( url+"procedure.php?cmd=getMeet&id="+id, function( data ) {
    
    var html="";
    console.log(data);
      // $.each( data, function( key, val ) a vytvoření oakdazů, seředit dle dtaa sestupně 
     
     
     $("input[name=id]").val(data["id"]);
     $("input[name=date_time]").val(data["date_time"]);
     $("input[name=firm_id]").val(data["firm_id"]);
     $("textarea[name=notes]").val(data["notes"]);
    
  
  });  
}

function getMeets(url,id) {
  $.getJSON( url+"procedure.php?cmd=getMeets&id="+id, function( data ) {
    
    var html="<a href='/meets/editMeetForm.php?id=0&firm_id="+id+"' target='_blank'>Přidat schůzku</a><br>";
    //console.log(data);
    
    $.each( data, function( key, val ) {
     console.log(val);
     html+="<a href='/meets/editMeetForm.php?id="+val[0]+"&firm_id="+val[1]+"' target='_blank'>"+
     val[2]+": "+val[3].slice(0,16)+"...</a><br>";
    //$(".meets").append(html);
     
     });
     $(".meets").html("");      
    $(".meets").append(html);
  
  });  
}



function getFirmRow(url,id) {  
  
$.getJSON( url+"?cmd=getFirm&id="+id, function( data ) {
  
  $.each( data, function( key, val ) {
    /*console.log(val);
    console.log(".rownum"+id+" td[class*="+key+"]");
   */
    $(".rownum"+id+" td[class*="+key+"]").html(val);

  });
    

});  
}

function getFirmHidenColmn(url,id) {  
  
$.getJSON( url+"procedure.php?cmd=getFirmHidenColmn&id="+id, function( data ) {
  
  var html="";
  $(".extra").each(function() {
    $(this).remove();
  });
  
  let array_columns=data["array_columns"];
  let array_columns_names = data["array_columns_names"];
  let array_columns_types = data["array_columns_types"];
  let sql_res = data["sql_res"];
  let archon="";
    
  
  for(i=0;i<array_columns.length;i++) {
  
  console.log(array_columns_names[i],sql_res[array_columns_names[i]]);
  
    if (sql_res[array_columns_names[i]]==="") sql_res[array_columns_names[i]]="";
    if (sql_res[array_columns_names[i]]=="null") sql_res[array_columns_names[i]]=" ";
    if (sql_res[array_columns[i]]=="null") sql_res[array_columns[i]]=" ";
    if (sql_res[array_columns[i]]==null) sql_res[array_columns[i]]=" ";
    
    
    var r = /^(ftp|http|https):\/\/[^ "]+$/;
    if (r.test(sql_res[array_columns[i]])) archon="<a href='"+sql_res[array_columns[i]]+"' target='_blank'><img src='/css/link.png' style='height:1.125em;width:AUTO'></a>";else archon="";
    
    html+='<div class="field half"><label class="label">'+archon+' '+array_columns_names[i]+'</label>'+
      '<input class="text-input" name="'+array_columns[i]+'" type="'+array_columns_types[i]+'" value="'+sql_res[array_columns[i]]+'"></div>';
  }
  //console.log(html);
 $(".extra_colmns").append(html);      

}); 
  
}

function getFirmHidenColmn2(url) {//jen vykreslí pole  
  
$.getJSON( url+"procedure.php?cmd=getFirmHidenColmn&id=1", function( data ) {
  
  var html="";
  $(".extra").each(function() {
    $(this).remove();
  });
  
  let array_columns=data["array_columns"];
  let array_columns_names = data["array_columns_names"];
  let array_columns_types = data["array_columns_types"];
  
  let archon="";
    
  
  for(i=0;i<array_columns.length;i++) {
    
    html+='<div class="field half extra"><label class="label">'+archon+' '+array_columns_names[i]+'</label>'+
      '<input class="text-input" name="'+array_columns[i]+'" type="'+array_columns_types[i]+'" value=""></div>';
  }
  //console.log(html);
 $(".extra_colmns").append(html);      

}); 
  
}

// post-submit callback

function processJson(data) {
    //console.log(data.msg);
   
    if (data.msg==-1) $("#output1").html("Error");
    else {$("#output1").html("OK"); $("form").hide();} 
}
