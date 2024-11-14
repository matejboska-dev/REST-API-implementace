<?php
if(isset($_POST["firm_id"])){
    include_once("../conn.php");

    
    //$json = $_POST["firms_in_event"];
    //$temp = json_decode($json);
    //$firms = $temp->{'array'};
    $date_time = str_replace("T"," ",$_POST["date_time"]).":00";
    $notes = $_POST["notes"];
    $firm_id = intval($_POST["firm_id"]);
    
    
    $insert = $conn->prepare("INSERT INTO meets (firm_id,date_time,notes) VALUES (?,?,?)");
    $insert->bind_param("iss", $firm_id,$date_time,$notes);
    if($insert->execute()){
        echo $last_id = $conn->insert_id;
        
      
    }else{
        echo $conn->error;
       
    }

}
?>