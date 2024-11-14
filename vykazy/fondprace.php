<?php
/*
    uloženo v dva - sloupec, že bylo vygenrováno
    univerzální úkoly
    schůzky s datem, WS, kulatý stlů, jiný typ... 
    udělat vkládání
*/
class koor {
private $schuzky;
private $schuzkyInt=0;
private $ukonInt=0;
private $rnd=0;
protected $ukonyInt=0;
protected $ukony=array();
protected $ukony_cas=array();
protected $ukony_ids=array();
protected $mysqli=null;
private $pocetSchuzek=3;


  function __construct()
  {
    $this->schuzky=array();
    $this->ukony=array();
    $this->ukony_cas=array();
    $this->vytahniSchuzky(); 
    $this->vytahniUkony();
 //   $this->mysqli = new mysqli("localhost","root","","vykazy");
    
  }
  
  function vytahniSchuzky() {
  
    $sql = "SELECT * FROM schuzky where active=1 order by id";
    $i=0;
     $this->mysqli = new mysqli("localhost","root","","vykazy");//???
    
    if ($result = $this->mysqli -> query($sql)) {
      while ($row = $result -> fetch_row()) {
      $this->schuzky[$i]=$row[2];
        $i++; 
      }
      $result -> free_result();
    }


 
 /*   $this->schuzky[0]="Kulatý stůl s firmou Arbes";
    $this->schuzky[1]="Kulatý stůl s firmou IVC";
    $this->schuzky[2]="Kulatý stůl s firmou LM";
  */
  }
  
    function vytahniUkony() {
  
    $sql = "SELECT * FROM ukony where active=1 AND typ='koor'";
     $i=0;
     $this->mysqli = new mysqli("localhost","root","","vykazy");//???
    
    if ($result = $this->mysqli -> query($sql)) {
      while ($row = $result -> fetch_row()) {
        $this->ukony[$i]=$row[2];
        $this->ukony_cas[$i]=$row[4];
        $this->ukony_ids[$i]=$row[0];
        $i++; 
      }
      $result -> free_result();
    }

       
  
  }
  

  
  function dejSchuzku(){
    
    
    return $this->schuzky[$this->schuzkyInt];
    
    //throw new Exception("Chybí schůzka");
  
  }


  function dejUkon(){
 // echo $this->ukonyInt." ";
    $ukony = array("Komunikace s firmami - e-mail, telefon","Vyhledávání nových firem ke kontaktování");
           
    if ($this->rnd==count($ukony)) $this->rnd=0;   
  
    if ($this->schuzkyInt<$this->pocetSchuzek)
        {return $this->dejSchuzku();} 
  
     
    if ($this->ukonyInt>=count($this->ukony))
    {
        return $ukony[$this->rnd++];
    }
    else
    {
     return $this->ukony[$this->ukonyInt];
     }
    
  
  }

    function dejUkon_cas(){
    //echo $this->ukonyInt."; ";
    
     if ($this->schuzkyInt<$this->pocetSchuzek)
        {$this->schuzkyInt++;return 2;} 
    
    
        if ($this->ukonyInt<count($this->ukony))
            return $this->ukony_cas[$this->ukonyInt++];
        else return 3;
    
  
  }
//function dejUkonInc(){$this->ukonyInt++;}

function dejUkonIDs(){
    
    return $this->ukony_ids;
    
  
  }
    

}//koor

//// class moodle extends koor ///
class moodle extends koor {


  function __construct()
  {
   // $this->schuzky=array();
    $this->ukony=array();
    $this->ukony_cas=array();
 //   $this->vytahniSchuzky(); 
    $this->vytahniUkony();
    $this->ukonyInt=0;
    //$this->mysqli = new mysqli("localhost","root","","vykazy");
    
  }

  function vytahniUkony() {
  
    $sql = "SELECT * FROM ukony where active=1 AND typ='moodle' order by delka DESC";
     $i=0;
     $this->mysqli = new mysqli("localhost","root","","vykazy");//???
    
    if ($result = $this->mysqli -> query($sql)) {
      while ($row = $result -> fetch_row()) {
        $this->ukony[$i]=$row[2];
        $this->ukony_cas[$i]=$row[4];
        $this->ukony_ids[$i]=$row[0];
        $i++; 
      }
      $result -> free_result();
    }

       
  
  }
/*
  function vytahniSchuzky() {
  
    $sql = "SELECT * FROM ukony where active=1 AND typ='moodle' order by delka DESC";
    $i=0;
     $this->mysqli = new mysqli("localhost","root","","vykazy");//???
    
    if ($result = $this->mysqli -> query($sql)) {
      while ($row = $result -> fetch_row()) {
      $this->ukony[$i]=$row[2];
      $this->ukony_cas[$i]=$row[4];
       $this->ukony_ids[$i]=$row[0];
        $i++; 
      }
      $result -> free_result();
    }
//echo "<pre>";
//print_r($this->ukony);
//print_r($this->ukony_cas);

 

  }
  */
  
  function dejUkon(){
    $ukony = array("Kontrola stavu záloha, volného místa","Čiskta a kontrola záloh","Tvroba návodů pro kolegy");
       
    
    if ($this->ukonyInt>=count($this->ukony))
      return $ukony[rand(1,count($ukony))-1];
    else
        return $this->ukony[$this->ukonyInt++];
        
     
    
    //throw new Exception("Chybí schůzka");
  
  }


    function dejUkon_cas(){
    
    return $this->ukony_cas[$this->ukonyInt-1];
    
  
  }

}


?>