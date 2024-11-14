<?php
include_once("../conn.php");

if(isset($_POST["name"])){
    $attrs = "";
    $values = "";
    $values_array = [];
    $types = "";
    foreach ($_POST as $key => $value) {
    if ($key=="phone") {
    $value= str_replace("+420","",$value);
    $value= str_replace("+","",$value);
    $value= str_replace(" ","",$value);
    
    }
        
        if(strlen($value) != 0){           
            $values .= "?,";
            if(substr($key,-1) == "-"){
                $attrs .= substr($key,0,-1) . ",";
                $types .= "i";
            }
            else{
                $attrs .= $key . ",";
                $types .= "s";                
            }
            array_push($values_array,$value);
        }  
    }
    $attrs = substr($attrs,0,-1);
    $values = substr($values,0,-1);

    $sql = "INSERT INTO firm ($attrs) values($values)";
    $insert = $conn->prepare($sql);
    $insert->bind_param($types, ...$values_array);
    if($insert->execute()){
    
    echo mysqli_insert_id($conn);
       //header("Location: /firms/insertFirmForm.php");
    }else{
        echo $conn->error;
    }
  
    $insert->close();
    $conn->close();
}

?>