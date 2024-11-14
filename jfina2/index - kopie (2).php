<?php
session_start();
//print_r($_SESSION);
//print_r($_POST);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
  <head>
  <meta http-equiv="content-type" content="text/html; charset=utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Hádej</title>
  </head>
  <style>
  h2 {background:url(bg.jpg) no-repeat;display:block;height:2rem}
  label,input {height:30px}
   p,label {font-size:200%}
   a,a:visited {color:red}
   .mapa {display:block;height:2rem;border:1px inset red;text-decoration:none;text-align:center;font-size:1.6rem}
    .hlaska {background:beige}
   .neuspech {color:red;}
   .uspech {color:lime}
   
   img {width:100%;max-width:400px}
   
  </style>  
  <body>
1)Přehraj si znělku a zvol hlavního hrdinu<br>
<audio controls>
  <source src="Tlapkova_patrola_znelka.mp3" type="audio/mp3">
</audio><br>
<img src="2-tlapkova-patrola-masky.jpg">


<br>2)Která z PJ Masek je sovička <br>
 <img src="pjmasky.webp">
<br>Která postava z prasátka Peppa nosí brýle <br>
<input type="text"> 
    
 <br>3) Poznej znělku a ukaž na hlavni hrdinku (Sophie)<br>

 <audio controls>
  <source src="sofie_znelka.mp3" type="audio/mp3">
</audio><br>
    
4) Vyber další do party 



<img src="pj1.jpg">
<img src="tlap1.jpg">
<img src="peppa1.jpg">
<img src="sofie1.jpg">

    
  </body>
</html>
