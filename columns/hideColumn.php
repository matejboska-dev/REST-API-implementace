<?php
include_once("../conn.php");

if(isset($_POST["name"])){
    $name = $_POST["name"];
    $hide = $_POST["hide"];

    if($hide == "1"){
        $sql = "INSERT INTO hidden_columns (name) VALUES ('$name')";

        if ($conn->query($sql) === TRUE) {
        }

    }else {
        $sql = "DELETE FROM hidden_columns where name = '$name'";

        if ($conn->query($sql) === TRUE) {
        }
    }
}
header ("Location: columnForm.php");
?>