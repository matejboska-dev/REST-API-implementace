<?php


if(isset($_POST["id"])){
    include_once("../conn.php");
    $id = $_POST["id"];
    
    //print_R($_POST);
    if (!$id) {
        $sql = "INSERT firm SET name='".trim($_POST["name"])."'";
 //       echo "$sql\n";
        $conn->query($sql);
        $id=$conn->insert_id;
        }
    
    foreach ($_POST as $key => $value) {
        if ($key=="phone") {
        $value= str_replace("+420","",$value);
        $value= str_replace("+","",$value);
        $value= str_replace(" ","",$value);
      }
    
    
     if (!( $key=="contatct_id" || $key=="active_c"  || $key=="surname"   || $key=="email" || $key=="phone" || $key=="main"  )) {
    
            if ($id)
            
                $sql = "UPDATE firm SET $key='".trim($value)."' WHERE id=$id";
            else 
                $sql = "INSERT firm SET $key='".trim($value)."' WHERE id=$id";

           echo "$sql\n";
            $conn->query($sql);
        }
    
    
    
    
    }
    
    $firm_contacts_count = count($_POST["surname"]);
    $firm_contacts=array(); 
    
    
    for ($i=0;$i<$firm_contacts_count;$i++) {
    
   
        $_POST["phone"][$i]= str_replace("+420","",$_POST["phone"][$i]);
        $_POST["phone"][$i]= str_replace("+","",$_POST["phone"][$i]);
        $_POST["phone"][$i]= str_replace(" ","",$_POST["phone"][$i]);
    
    
        if ($_POST["contatct_id"][$i])
          $sql = "UPDATE firm_contacts SET ";
        else
          $sql = "INSERT firm_contacts SET ";
        
          
      $sql.="surname='".$_POST["surname"][$i]."',";
      $sql.="email='".$_POST["email"][$i]."',";
      
      if ($_POST["contatct_id"][$i]==@$_POST["main"])
          $sql.="main=1,";
      else    
      $sql.="main=0,";
      
      if ($_POST["active_c"][$i])
          $sql.="active_c=1,";
      else    
        $sql.="active_c=0,";
          
      $sql.="phone='".$_POST["phone"][$i]."'";
      if ($_POST["contatct_id"][$i]) {
      $sql.=" WHERE firm_id=$id ";
      
          $sql.=" AND id=".$_POST["contatct_id"][$i];
      }else {
        $sql.=" ,firm_id=$id ";
      }
      
      echo $sql;echo "\n";
      $conn->query($sql);
      } 
    
      
     }//post
    
    








?>

