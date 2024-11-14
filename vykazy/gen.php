<?php

class gen {
  // 0 = neděle
  private $odstup=0.5;//kolik hodin po ukončení může být první práce
  private $prac;
  
  private $koor;    
  private $pracFond=20;
  private $praceOPraz=false;
  private $svatky =array();
  private $prazdniny=array();
  private $mesic=1;
  private $pocetPrac=0;
  private $minPracHodin=1;
  private $korekce=0;//počet práce s hodinovou dotací 2 - jednání
  private $tab=array();
  private $soubor="";
  
  function __construct($mesic,$praceOPraz=false,$pracFond=20,$korekce=0, $odstup=0.5,$koor="koor") {
  
    $this->pracFond=$pracFond;
    $this->odstup=$odstup;
    $this->praceOPraz=$praceOPraz;
    $this->nactiSvatky();
    $this->mesic=$mesic;
    $this->korekce=$korekce;  
    $this->pocetPrac();
    if ($koor=="koor"){
        $this->koor= new koor();
        $this->soubor="Měsíční pracovní koor ".$mesic."_".date("Y");
        } 
    else {
        $this->koor= new moodle();
        $this->soubor="Měsíční pracovní výkaz ".$mesic."_".date("Y");
        }
    
    $this->prac[0]=null;
  //pondělí
  $this->prac[1]["od"]="9:20";
  $this->prac[1]["do"]="14:00";
  
  $this->prac[2]["od"]="9:20";
  $this->prac[2]["do"]="15:45";
  
  $this->prac[3]["od"]="8:25";
  $this->prac[3]["do"]="15:45";
  
  $this->prac[4]["od"]="9:20";
  $this->prac[4]["do"]="12:00";
  
  $this->prac[5]["od"]="9:20";
  $this->prac[5]["do"]="14:00";
  
  }
  
  function nactiSvatky() {
  $this->svatky=dejSvatky();
  $this->prazdniny=dejPrazdniny();
  
  
  }
  
  function prevodData($datum) {
  
  $tmp = explode("-", $datum);
  
  return $tmp[2].".".$tmp[1].".".$tmp[0];
  
  }
  
  function jeToSvatek($datum) {
  
  return array_key_exists($datum,$this->svatky);
  
  }
  
   function jeToPrazdniny($datum) {
  
  return array_key_exists($datum,$this->prazdniny);
  
  }
    
  function jeToPracDen($datum) {
  
  if ($this->jeToSvatek($this->prevodData($datum))) return false;
  if ($this->jeToPrazdniny($this->prevodData($datum))) 
    {
        if ($this->praceOPraz) 
            return true; //pracuji o prázd 
        else 
            return false;
    }
  
  $den = date('w', strtotime($datum));
  if ($den>=1 && $den<=5) return true;
  if ($den==0 || $den==6) return false;
  
  
 return true;
  }

function genKrok()
{
    
    

    //echo "$this->pracFond/$this->pocetPrac <br>";
    $prumerDen = round($this->pracFond/$this->pocetPrac);
    
    //20 - >2
    if ($this->pracFond<25) return $this->minPracHodin;
     
    else {
    //51/21=2 + 9
    
    //if ($this->pocetPrac()<=21) return 4;
    
    if ($prumerDen<3) return 3;
    else 
        return $prumerDen;
    }
        
    
    
    //return $prumerDen;
}

  function casOdDo($den,$prac) {
  $oddo=array();
  $oddo["od"] = strftime('%H:%M',strtotime($this->prac[$den]["do"])+($this->odstup)*3600);
  $oddo["do"] = strftime('%H:%M',strtotime($this->prac[$den]["do"])+($this->odstup+$prac)*3600); 
     
    return $oddo; 
  
  }

function pocetPrac() {

    $dny = cal_days_in_month(CAL_GREGORIAN, $this->mesic,date("Y") );
    $this->pocetPrac=0;
    
    for($i=1;$i<=$dny;$i++) {
    
    $tmpDatum=date("Y")."-".$this->mesic."-".$i;
    
    if ($this->jeToPracDen($tmpDatum)) 
        $this->pocetPrac++;
    } 
    
    
    
}


function genPracDny(){

   $dny = cal_days_in_month(CAL_GREGORIAN, $this->mesic,date("Y") );
    $pracFond= $this->pracFond;
    $pracHodin = $this->genKrok();
    $tmp=0;
    $tmpArr=array();
    $y=0;
    $pk=0;
    
    //echo $pracHodin."<br>";
    
    for($x=0;$x<$dny;$x++) {
    //echo $x." ";
    
      //$i=$x+1;
      $tmpDatum=date("Y")."-".$this->mesic."-".($x+1);
      if ($this->jeToPracDen($tmpDatum)) 
      {
      
        $tmp+=$pracHodin;
        
       // echo $tmpDatum.": $pracHodin $tmp práce".  "<br>";
        
        $tmpArr[$y]["datum"]=$tmpDatum;
        
        //$tmpArr[$y]["hodin"]=$pracHodin;
        
        
        $pk++;
        $tmpArr[$y]["prace"]=$this->koor->dejUkon();
        $tmpArr[$y]["hodin"]=$this->koor->dejUkon_cas();
        //$this->koor->dejUkonInc();
        $pracHodin=$tmpArr[$y]["hodin"];
        $odod= $this->casOdDo(date('w', strtotime($tmpDatum)),$pracHodin);
        $tmpArr[$y]["cas"]=$odod["od"];
        $tmpArr[$y]["cas2"]=$odod["do"];
        
        $pracHodin=$tmpArr[$y]["hodin"];
        
       /*
        if ($pk<$this->korekce && $y%3==0) {
        $pracHodin=2;
        $pk++;
        $tmpArr[$y]["prace"]=$this->koor->dejSchuzku();
        $tmpArr[$y]["hodin"]=$this->koor->dejUkon_cas();
        
            }else {
        
        $pracHodin = $this->genKrok();//min. délka dle typu
        $tmpArr[$y]["prace"]=$this->koor->dejUkon();
        //$tmpArr[$y]["hodin"]=$this->koor->dejUkon_cas();
       }
            */
        $pracFond-=$pracHodin;
        
        if ($pracFond<=$pracHodin) break;
       $y++;//inc pole index 
      }
        
    }
    
    $tmpArr[$y]["hodin"]+=$pracFond;

   
   // shuffle($tmpArr);//zamícháme
    $this->tab=$tmpArr;
} 

function genTable() {

$tmpArr= $this->tab;
//https://github.com/phpexcel/PHPExcel


echo $this->soubor;
$i=0;
echo '<table border=1>';
echo '<tr><th> </th><th> </th><th></th></tr>';
foreach ($tmpArr as $tmp) {
    echo '<tr>';
    echo '<td>' .($i+1). '</td>';
    echo '<td>' . $this->prevodData($tmp['datum']) . '</td>';
    echo '<td>' . $tmp['cas'] . '</td>';
    echo '<td>' . $tmp['cas2'] . '</td>';
    echo '<td>' . $tmp['hodin'] . '</td>';
    echo '<td>' . $tmp['prace'] . '</td>';
    echo '</tr>';
$i++;
}
echo '</table>';

}
function getData() {return $this->tab;}
function getUpdateQ() {return
"UPDATE ukony
SET active=0,
WHERE id IN (".implode(",", $this->koor->dejUkonIDs()).");";
}

function execUpdateQ() {
$sql =getUpdateQ(); 
     $this->mysqli = new mysqli("localhost","root","","vykazy");//???
    
return $this->mysqli -> query($sql);
}


function kontrola ($a,$b) {

for ($i=0;$i<31;$i++)
{
//print_r($a[$i]);
if (!isset($a[$i]['datum'])) break;
if ($a[$i]['datum']==$b[$i]['datum']) {
//echo explode("-",$a[$i]['cas'])[0];
//echo explode("-",$b[$i]['cas'])[0];
if (strcmp(explode("-",$a[$i]['cas'])[0],explode("-",$b[$i]['cas'])[0])==0) 
    echo "<b style='color:red'>".$a[$i]['datum']."<br>";

}
}


}

}//gen
