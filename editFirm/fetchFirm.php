<?php
if(isset($_GET["id"])){


include_once("../conn.php");
$sql = "SELECT firm.id,firm.name,firm.surname,firm.email,firm.phone,firm.source,firm.active,firm.date_of_contact,firm.date_of_2_contact,firm.date_of_meeting,firm.result,firm.workshop,firm.brigade,firm.practice,firm.cv,firm.note,subject.name as subject, subject.id as subject_id";

$array_columns = array();
$array_columns_names = array();
$array_columns_types = array();
$columns = "SELECT columns.id,columns.name, type_of_column.type FROM columns inner join type_of_column on columns.type = type_of_column.id";
$result = $conn->query($columns);

if ($result->num_rows > 0) {
while($row = $result->fetch_assoc()) {
    $sql .= ",c". $row["id"];
    array_push($array_columns,"c".$row["id"]);
    array_push($array_columns_names,$row["name"]);
    array_push($array_columns_types,$row["type"]);
 }
} else {
    
}
$sql .= " FROM firm inner join subject on firm.subject_id = subject.id where firm.id = ".$_GET["id"]." limit 1";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
  $row = $result->fetch_assoc();
  echo json_encode($row);
} else {
  exit;
}
}?>