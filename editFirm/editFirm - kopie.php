<?php
if(isset($_POST["id"])){
    include_once("../conn.php");
    $id = $_POST["id"];
    $contatct_id = $_POST["contatct_id"];
    print_R($_POST);
    
    foreach ($_POST as $key => $value) {
        if ($key=="phone") {
    $value= str_replace("+420","",$value);
    $value= str_replace("+","",$value);
    $value= str_replace(" ","",$value);
    
    }
    if ($key=="active_c" || $key=="main"   || $key=="name"   || $key=="surname"   || $key=="email" || $key=="phone"  || $key=="contatct_id")
        saveContact($key,$value,$id,$contatct_id,$conn);
        else
        
        if($key != "id"){
            $sql = "UPDATE firm SET $key='".trim($value)."' WHERE id=$id";
            $conn->query($sql) ;                                            
/*
            if ($conn->query($sql) === TRUE) {
                echo "Record updated successfully $key ";
            } else {
                echo "Error updating record: " . $conn->error;
            }*/
        }
    }
}

function saveContact($name,$arr,$id,$contatct_id,$conn) {
if (is_array($arr)) {
    foreach ($arr as $key => $value) {
      echo $sql = "UPDATE firm_contacts SET $name='".trim($value)."' WHERE firm_id=$id AND id=".$contatct_id[$key];
      $conn->query($sql);
      }
      
      }else {
      
      //echo $sql = "UPDATE firm_contacts SET $name='".trim($arr)."' WHERE firm_id=$id AND id=$contatct_id";
      //$conn->query($sql);
      }
}
?>