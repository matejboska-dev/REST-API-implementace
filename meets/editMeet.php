<?php
if(isset($_POST["firm_id"])){
    include_once("../conn.php");

    
    //$json = $_POST["firms_in_event"];
    //$temp = json_decode($json);
    //$firms = $temp->{'array'};
    $id = $_POST["id"];
    $date_time = str_replace("T"," ",$_POST["date_time"]).":00";
    $notes = $_POST["notes"];
    $firm_id = intval($_POST["firm_id"]);
    
    
    $insert = $conn->prepare("UPDATE meets set firm_id=?,date_time=?,notes=? where id=? limit 1");
    $insert->bind_param("issi", $firm_id,$date_time,$notes,$id);
    if($insert->execute()){
        echo $last_id = $conn->insert_id;
        
      
    }else{
        echo $conn->error;
       
    }

}
?>