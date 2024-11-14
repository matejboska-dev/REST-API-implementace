<?php

 include_once("conn.php");
 
 
include "helper.php";
?>
<!DOCTYPE html>
<html lang="cs">
<head>
    <meta http-equiv="Cache-Control" content="no-store" />
    <meta http-equiv='cache-control' content='no-cache'>
    <meta http-equiv='expires' content='0'>
    <meta http-equiv='pragma' content='no-cache'>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <link rel="icon" type="image/x-icon" href="./css/favicon.ico">
    <!--<link rel="stylesheet" href="minify_css.css">-->

    
    <link rel="stylesheet" href="./css/forms-style.css?v=<?php echo filemtime("./css/forms-style.css") ?>">
    <link rel="stylesheet" href="./css/style.css?v=<?php echo filemtime("./css/style.css") ?>">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Titillium+Web:400,700">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">
    

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
 
    
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css">

    <script src="./editFirm/edit.js?v=<?php echo filemtime("./editFirm/edit.js") ?>"></script>
    <script src="./js/ajax.js?v=<?php echo filemtime("./js/ajax.js") ?>"></script>
    <script src="./js/table.js?v=<?php echo filemtime("./js/table.js") ?>"></script>
    <script src="./js/clickRow.js?v=<?php echo filemtime("js/clickRow.js") ?>"></script>
    <script src="./js/select.js?v=<?php echo filemtime("./js/select.js") ?>"></script>


    <title>CRM</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <style>
        <?php
        include_once("conn.php");

        $sql = "SELECT name FROM hidden_columns";
        $result = $conn->query($sql);
        $style_string = "";
        $count = mysqli_num_rows($result);
        $i = 0;
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
               // $style_string .= ".form *[name=" .$row["name"]."],";
                $style_string .= "." . $row["name"];
                if ($i != $count - 1) {
                    $style_string .= ",";
                }
                $i++;
            }
        }
        if ($count != 0) {
        ?><?php echo $style_string; ?> {
            display: none !important;
        }

        <?php
        }
        ?>
      
    </style>
        <script>
        url = "<?php echo "http://lm/" . $_SERVER['HTTP_HOST']; ?>/";
    </script>
    

<link href="./vendor/dragdrop/style.css" rel="stylesheet" type="text/css">
<script src="./vendor/dragdrop/script.js?v=<?php echo filemtime("./vendor/dragdrop/script.js") ?>"></script>

</head>

<body>
<?php
function clear($str) {

$str=str_replace(" ","",trim($str));
$str=str_replace("neex","",$str);
$str=str_replace("-","",$str);
$str=str_replace("nefunguje","",$str);

return $str;
} 
  $sql = "SELECT  * from firm";

            
            $result = $conn->query($sql);
            $count = mysqli_num_rows($result);

            while ($row = $result->fetch_assoc()) {
            $row = htmlCleanRow($row);
            
            if (strpos($row["note"],"@")) {
                $row["note"]=str_replace("nefunguje","neex",$row["note"]);            
               
                    //echo clear($row["note"])."<br>";    
            
            echo "insert into firm_contacts values(null,"
            .$row['id'].",0,".
            "'0',".
            "'',".
            "'',".
            "'".clear($row["note"])."',''"
            
            
            .");";
            echo "<br>";
            } 
            
            
            if (strpos($row["c19"],"@")) {
            echo "insert into firm_contacts values(null,"
            .$row['id'].",0,".
            "'0',".
            "'',".
            "'',".
            "'".clear($row["c19"])."',''"
            
            
            .");";
            echo "<br>";
            }
            
            echo "insert into firm_contacts values(null,"
            .$row['id'].",1,".
            "'".$row["active"]."',".
            "'".$row["name"]."',".
            "'".$row["surname"]."',".
            "'".$row["email"]."',".
            "'".$row["phone"]."'"
            
            .");";
            ?><hr>

                
                
                <? }?>
