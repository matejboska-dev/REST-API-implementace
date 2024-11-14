<?php

require_once "dbdriver.php";

Class Service {
private $OutputArray=array();
private $OutputJSON=array();
private $tab_firm="firm";
private $tab_meet="meets";
private $dbdrv;


public function __construct($conn) {
    
    $this->dbdrv=new dbdriver($conn);
    
}

public function getMeet($id) {   

$id= intval($id);
return $this->dbdrv->selectWhere($this->tab_meet,"*"," where id=$id");   
}

public function getMeets($id) {  /* vybírám dle firmy */ 

    $id= intval($id);
return $this->dbdrv->selectQ("SELECT * FROM ".$this->tab_meet." where firm_id=$id");    
}



public function getFirm($id) {   /*funkce na selectování firem*/ 

$id= intval($id);
return $this->dbdrv->selectWhere($this->tab_firm,"*"," where id=$id");   
}

public function getFirmContacts($id)
{
    $conn=$this->dbdrv->getConn();
    
    $i=0;
    $arr=array();
    
   $sql = "SELECT * FROM firm_contacts where firm_id=$id order by main DESC,active_c DESC";
   $result = $conn->query($sql);
   if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        
    $arr[$i]["contatct_id"]=$row["id"];
    $arr[$i]["main"]=$row["main"];        
    $arr[$i]["active_c"]=$row["active_c"];
    $arr[$i]["surname"]=$row["surname"];
    $arr[$i]["email"]=$row["email"];
    $arr[$i]["phone"]=$row["phone"];
    $arr[$i]["main"]=$row["main"];
    
    $i++;       
     }
    }
   
    return $arr;

}

public function getFirmHidenColmn($id) {


  
    
    $conn=$this->dbdrv->getConn();
    
    $sql = "SELECT firm.id,firm.name,firm.surname,firm.email,firm.phone,firm.source,firm.active,firm.date_of_contact,firm.date_of_2_contact,firm.date_of_meeting,firm.result,firm.workshop,
    firm.brigade,firm.practice,firm.cv,firm.note,subject.name as subject, subject.id as subject_id";
    
    
    
    
    $array_columns = array();
    $array_columns_names = array();
    $array_columns_types = array();
    $array_ret = array();
    
    $columns = "SELECT columns.id,columns.name, type_of_column.type FROM columns inner join type_of_column on columns.type = type_of_column.id";
    $result = $conn->query($columns);

    if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $sql .= ",c". $row["id"];
        array_push($array_columns,"c".$row["id"]);
        array_push($array_columns_names,$row["name"]);
        array_push($array_columns_types,$row["type"]);
        
     }
    }
    
    
    //print_r($array_columns);
    $array_ret["array_columns"]=$array_columns;

    $array_ret["array_columns_names"]=$array_columns_names;
    $array_ret["array_columns_types"]=$array_columns_types;
   // print_r($array_ret);
   
   $sql .= " FROM firm inner join subject on firm.subject_id = subject.id where firm.id = ".$id." limit 1";
   $array_ret["sql_res"]=array("");
    $result = $conn->query($sql);

   if ($result->num_rows > 0) {
    $array_ret["sql_res"] = $result->fetch_assoc();
    }
   
   
   
     return $array_ret;
     


}

public function processRequest($input) {

$data= json_decode($input);

$idUser="";

}
}//class

?>