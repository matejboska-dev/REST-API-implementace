<?php
if(isset($_POST["id"])){
    include_once("../conn.php");
    $id = (int) $_POST["id"];
    $errr=0;
    foreach ($_POST as $key => $value) {
        if($key != "id" && $key != "firm_id"){
            $sql = "UPDATE events SET $key='$value' WHERE id=$id";

            if ($conn->query($sql) === TRUE) {
                //echo "Record updated successfully $key ";
                $errr=0;
            } else {
                //echo "Error updating record: " . $conn->error;
                $errr=1;
            }
        }
    }
    
    if (array_key_exists("firm_id",$_POST))
    {    changeFirmsEventsList($id);
    
    }else {//odebrat poslední od firmy
        delEventRecord($id); 
    }



    if (!$errr)
        header("Location: /events/tableEvents.php?ok=1");
    else 
        header("Location: /events/editEventForm.php?err=".$errr."&id=".$_POST["id"]);
   
    
}

function delEventRecord($eventID) {
    global $conn;
     if ($eventID>0)
        {
        $sql = "delete from firms_in_event WHERE id=$eventID limit 1";
        return $conn->query($sql);
        }
}


function addEventRecord($firm_id,$event_id) {
    global $conn;
     if ($event_id>0)
     {
        $sql = "insert into firms_in_event SET firm_id=$firm_id,event_id=$event_id ";
        return $conn->query($sql);
        }
}

function changeFirmsEventsList($id) {
global $conn;
    $errr=0;
    
    print_r($_POST["firm_id"]);
    $add_firm_id= array();
    
    $sql2 = "SELECT *,firms_in_event.id as fid FROM firms_in_event inner join firm on firms_in_event.firm_id = firm.id where firms_in_event.event_id = ". (int) $id;
      $result2 = $conn->query($sql2);
      
      if ($result2->num_rows > 0) {
        while($row2 = $result2->fetch_assoc()) {
          
         if (!in_array($row2["firm_id"],$_POST["firm_id"])) {//vymažu firmu z události
         
                delEventRecord($row2["fid"]);
         
         }else {// 
          array_push($add_firm_id,$row2["firm_id"]); //id, se kterými nebudu nic dělat
            
         }      
          
    }
        for($i=0;$i<count($_POST["firm_id"]);$i++) {
            if (!in_array($_POST["firm_id"][$i],$add_firm_id))
                {
                    addEventRecord($_POST["firm_id"][$i],$id);    
                
                }
                

            }
    }else {//nemá záznam
    
    
        for($i=0;$i<count($_POST["firm_id"]);$i++) {
            
             addEventRecord($_POST["firm_id"][$i],$id);    
            
            }
    
    }
   
   
    

}
?>