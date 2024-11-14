<?php 
if(isset($_POST["ids"])){
    include_once("../conn.php");
    $ids = $_POST["ids"];
    $attr = $_POST["attr"];
    $value = $_POST["value"];
    if ($attr == "phone"){
        $value = trim($value);
    }
    $sql = "UPDATE firm set $attr = '$value' where id in (";
    for($x = 0;$x < count($ids);$x++){
        $sql .= $ids[$x];
        if($x != count($ids)-1){
            $sql .= ",";
        }
    }
    $sql.= ");";
    echo $sql;
    $insert = $conn->prepare($sql);
    if($insert->execute()){
       echo "OK";
    }else{
        echo $conn->error;
    }
  
    $insert->close();
    $conn->close();

}

?>
