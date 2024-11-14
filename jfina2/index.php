<?php
session_start();
//print_r($_SESSION);
//print_r($_POST);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
  <head>
  <meta http-equiv="content-type" content="text/html; charset=utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=0.8" />
    <script>
        window.addEventListener("DOMContentLoaded", (event) => {
           
        let btn = document.querySelectorAll('.flex img');
        console.log(btn);
        for (var i=0;i<btn.length;i++){
           
            
             btn[i].addEventListener('click', (e) => {
            console.log(e.target.getAttribute("data-odpoved"));
            
             document.querySelector('#odpoved').value=e.target.getAttribute("data-odpoved");
             
                          
          document.querySelector('form').submit();


            

        });
        }
                   
        let imgs = document.querySelectorAll('.square');
         for (var i=0;i<imgs.length;i++){
            imgs[i].addEventListener('click', (e) => {
            console.log(e.target.style.transform="rotate(0deg)");
            
            
            let imgs = document.querySelectorAll('.square');
            let hotovo=0;
            
            for (var i=0;i<imgs.length;i++){ 
                if (imgs[i].style.transform=="rotate(0deg)") {hotovo+=1;}
            }
            
            console.log(hotovo);
            if(hotovo==3)
            {
            document.querySelector('#odpoved').value=1;
            
            document.querySelector('form').submit();
            }
            
             });
            }
           

       
       
       

        
    }); //DOMContentLoaded       
    </script>
  <title>Hádej</title>
  </head>
  <style>
  body {text-align:center}
  h2 {background:url(bg.jpg) no-repeat;display:block;height:2rem;text-align:left}
  label,input {height:30px}
   p,label {font-size:200%}
   a,a:visited {color:red}
   .mapa {display:block;height:3rem;border:1px inset red;text-decoration:none;text-align:center;font-size:1.6rem}
    .hlaska {background:beige}
   .neuspech {color:red;}
   .uspech {color:lime}
   
    img {height:200px}
    input[type=radio] {display:none}
    .flex{display:flex;gap: 12px;justify-content: center;}
   .container {
    position: relative;
    width: 400px;
    height: 466px;
    margin:0 auto; 
  }
  .square {
    position: absolute;
    width: 200px;
    height: 233px;
    border: 2px solid black;
    background:url(bing2.jpg);
  }
  
    
    .square:nth-child(1){}
    .square:nth-child(2){ transform: rotate(90deg);background-position: top right}
    .square:nth-child(3){ transform: rotate(90deg);background-position:  bottom left}
    .square:nth-child(4){ transform: rotate(90deg);background-position:  bottom right}
    
    
  
  img.balon {width:100%;height:auto}
  </style>  
  <body>

<?php  

if(!isset($_SESSION["postup"]))  $postup = 0;else  $postup =  $_SESSION["postup"] ;
//psát vždy malými písmeiny
$pocet=5;
$odpovedi[1]="pj1";
$odpovedi[2]="sofie1";
$odpovedi[3]="pj2";
$odpovedi[4]="peppa1";
$odpovedi[5]="1";

if(isset($_POST["akt_krok"])) {
        $akt_krok=trim(mb_strtolower($_POST["akt_krok"]));
        $odpoved=trim(mb_strtolower($_POST["odpoved"]));
        
        if ($akt_krok==$pocet) {
        //konec
        echo "<br><h1>Výborně - jsi u konce</h1>
        
        <p>Výtečně, jsi u konce tvého putování. Dárek najdeš kolárně.</p><img src='balloon-27.gif' class='balon'>
        
        ";
        
        exit;
        }
        
        
        $odpoved.trim(mb_strtolower($odpovedi[$akt_krok]));
        if ($odpoved==trim(mb_strtolower($odpovedi[$akt_krok]))) {
        
        echo "<p class='hlaska uspech'>Výborně, správná odpověd!</p>>";
          
        $postup =  $_SESSION["postup"] = $akt_krok+1;
        
        }
        else 
        
        {
        
        echo "<img src='IMG_20230217_122704-2.jpg'><p class='hlaska neuspech'>Hups, to je špatně Kájuško! Ale nefňukej, můžeš to zkusit znovu! ;)</p>";
        }
}

else {
$postup = $_SESSION["postup"] = 1;

?>  
<a href="https://mapy.cz/s/gusahocara" class="mapa" target="_blank">Otevři si mapičku a začni.</a>
<p>Nápověda: Na každé <strong>zastávce</strong> najdeš úkol či hádanku. Až ji uhádneš získáš klíč, který zadáš na níže uvedené webovce.;). Hledej vždy skleničku od jogurtu s papírem s číslem.
</p>
<?}



?>

  
  <form method="post">
  
  <input type="hidden" name="akt_krok" value="<?=$postup?>">
  
  <h2>Hádanka č. <?=$postup?></h2>
<?php switch ($postup){ 

 case 1: ?>
 <div class="flex">
  <img data-odpoved="sofie1" src="sofie1.jpg">
  <img data-odpoved="pj1" src="pj1.jpg">
 <img data-odpoved="peppa1" src="peppa1.jpg">
 </div>
 <?php break;?>
<?php case 2: ?> 
    <audio controls>
  <source src="sofie_znelka.mp3" type="audio/mp3">
 
</audio><br><br>
 <div class="flex">
 <img data-odpoved="sofie1" src="sofie1.jpg">
  <img data-odpoved="pj1" src="pj1.jpg">
 <img data-odpoved="peppa1" src="tlap4.jpg">
 </div>

 <?php break;?>
 
 <?php case 3: ?> 
    <audio controls>
  <source src="sofie_znelka.mp3" type="audio/mp3">
 
</audio><br><br>
 <div class="flex">
 <img data-odpoved="pj1" src="pj1.jpg">
  <img data-odpoved="pj2" src="pj2.jpg">
 <img data-odpoved="pj3" src="pj3.jpg">
 </div>

 <?php break;?>
  <?php case 4: ?> 
    <audio controls>
  <source src="sofie_znelka.mp3" type="audio/mp3">
 
</audio><br><br>
 <div class="flex">
 <img data-odpoved="peppa1" src="peppa1.jpg">
  <img data-odpoved="peppa2" src="peppa2.jpg">
 <img data-odpoved="pj3" src="pj3.jpg">
 </div>
 <?php break;?>
 
 <?php case 5: ?>
  <div class="container">
  <div class="square" style="top: 0; left: 0;"></div>
  <div class="square" style="top: 0; right: 0;"></div>
  <div class="square" style="bottom: 0; left: 0;"></div>
  <div class="square" style="bottom: 0; right: 0;"></div>
  
</div>
 <?php break;?> 
  <?php }?>
 <input type="hidden" name="odpoved" id="odpoved" value="">
  
    </form>

    
    
    
  </body>
</html>
