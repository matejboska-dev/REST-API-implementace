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
   
  </style>  
  <body>

<?php  

if(!isset($_SESSION["postup"]))  $postup = 0;else  $postup =  $_SESSION["postup"] ;
//psát vždy malými písmeiny
$pocet=7;
$odpovedi[1]="44";
$odpovedi[2]="mdž";
$odpovedi[3]="Na Kačabce";
$odpovedi[4]="křesťanské gymnázium";
$odpovedi[5]="15";
$odpovedi[6]="Mattioliho";
$odpovedi[7]="240";

if(isset($_POST["akt_krok"])) {
        $akt_krok=trim(mb_strtolower($_POST["akt_krok"]));
        $odpoved=trim(mb_strtolower($_POST["odpoved"]));
        
        if ($akt_krok==$pocet) {
        //konec
        echo "<br><h1>Výborně - jsi u konce</h1>
        
        <p>Klíč k tvému bicyklu je ukryt v kočárkárně. Najdeš ho tak, že se budeš koukat i když toho moc neuvidíš.</p>
        
        ";
        
        exit;
        }
        
        
        
        if ($odpoved==trim(mb_strtolower($odpovedi[$akt_krok]))) {
        
        echo "<p class='hlaska uspech'>Výborně, správná odpověd!</p>";
          
        $postup =  $_SESSION["postup"] = $akt_krok+1;
        
        }
        else 
        
        {
        
        echo "<img src='IMG_20230217_122704-2.jpg'><p class='hlaska neuspech'>Hups, to je špatně Fiňuliko! Ale nefňukej, můžeš to zkusit znovu! ;)</p>";
        }
}

else {
$postup = $_SESSION["postup"] = 1;

?>  
<a href="https://mapy.cz/s/gusahocara" class="mapa" target="_blank">Otevři si mapičku a začni.</a>
<p>Nápověda: Na každé <strong>zastávce</strong> najdeš úkol či hádanku. Až ji uhádneš získáš klíč, který zadáš na níže uvedené webovce.;). Hledej vždy skleničku od jogurtu s papírem s číslem.
</p>
<?}?>

  
  <form method="post">
  
  <input type="hidden" name="akt_krok" value="<?=$postup?>">
  
  <h2>Hádanka č. <?=$postup?></h2> 
  <label for="odpoved">Tvá odpověď: </label><input type="text" name="odpoved" id="odpoved"><input type="submit" value=" >>> ">
                                    
  
    </form>
<br>-----------------------------<br>

    <audio controls>
  <source src="Tlapkova_patrola_znelka.mp3" type="audio/mp3">

</audio>
    
    
    
    
  </body>
</html>
