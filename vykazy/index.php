<html>
  <head>
  <meta http-equiv="content-type" content="text/html; charset=utf-8">
  <title></title>
  <style>
  
   table td {min-height:20px;}
  
  </style>
  </head>
  <body>
  <?php
  if (isset($_GET["mesic"])) 
    $mesic=$_GET["mesic"];   
else
    $mesic=date("m");
    
    function check($mes)
    {
    global $mesic;
    
    if ($mes==$mesic) {
    
    return "checked";
    }
    
    }
    
    ?>
<FORM>
<?php
$j=9;
for($i=0;$i<11;$i++){


?>
<input type="radio" name="mesic" value="<?=$j;?>" <?=check($j)?>> <?=$j?>
<?php
$j++;
}
?>

<input type="checkbox" name="zapis" value="1">Zápis?

<input type="submit" name="submit" value="odeslat">

</form>
<?php
include "seznamsvatku.php";
include "fondprace.php";
include "gen.php";

/*****////
/*září	2024	0,300	51
říjen	2024	0,300	53
listopad	2024	0,300	51
prosinec	2024	0,300	46
leden	2025	0,300	53
únor	2025	0,300	48
březen	2025	0,300	51
duben	2025	0,300	48
květen	2025	0,300	2
červen	2025	0,300	0
*/

$hodiny[9]=51;
$hodiny[10]=53;
$hodiny[11]=51;
$hodiny[12]=46;
$hodiny[1]=53;
$hodiny[2]=48;
$hodiny[3]=51;
$hodiny[4]=48;
$hodiny[5]=2;
$hodiny[6]=0;




$koor=new gen($mesic,true,51,0,0.5,"koor");

echo $koor->genPracDny();
echo $koor->gentable();

if (isset($_GET["zapis"])) $koor->execUpdateQ();
//else print_r($koor->getUpdateQ());


echo "<br><br>";



$moodle=new gen($mesic,true,20,0,2.5,"moodle");
//echo $moodle->jeToPracDen("2024-09-02");//prac. den
//echo $moodle->jeToPracDen("2024-10-28");//svatek
//echo "praz".$moodle->jeToPracDen("2024-12-23");//prazdniny

echo $moodle->genPracDny();
echo $moodle->gentable();
if (isset($_GET["zapis"])) $moodle->execUpdateQ();
//else print_r($moodle->getUpdateQ());




//print_r($moodle->getData());
//Schůzky - update dodělat
//Dodělat ukládání upadte
//u POSLEDNÍ ŘÁdku nesedí doplěný počet hodint s rozdílem časů
//$koor->kontrola($moodle->getData(),$koor->getData());

//Udělat porovnání polí - zažátků a i mezi hodnot
//TODO: vyřešit vzájemný posun hodin prokldání dnů
//Kde jedne končím, druý naváže.

?>