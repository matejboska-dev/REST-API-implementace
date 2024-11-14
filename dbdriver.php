<?php
require_once "conn.php";
class dbdriver{
private $cn;



function __construct ($conn) {

if ($conn==null) die; 

    $this->cn=$conn;
    

}

public function getConn () {
return  $this->cn;
}

function query ($sql) {


$result = $this->cn -> query($sql);

// Associative array
$row = $result -> fetch_assoc();


return $row;
}



function selectWhere ($tab,$colm,$where) {
$List="*";
$res=array();

if (is_array($colm)) 
    $List = implode(', ', $colm);
    else $List=$colm; 
        
$sql="select $List from $tab $where";

$result =$this->cn->query($sql);


$i=1;
if ($result = $this->cn -> query($sql)) {
  while ($row = $result -> fetch_assoc()) {
     
     $res[$i]=$row;
     $i++;
  }
}

return $res[1];

}

function select ($tab,$colm) {
return $this->selectWhere ($tab,$colm,"");
}


   
public  function selectQ ($sql) {
  $res=array();
    
  $i=0;
    if ($result = $this->cn -> query($sql)) {
      while ($row = $result -> fetch_row()) {
         
         $res[$i]=$row;
         $i++;
      }
    }
  
  return $res;
  
  }


}//class






?>