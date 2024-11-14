<?php
require __DIR__ . '/../vendor/autoload.php';

$vocative = new Granam\CzechVocative\CzechName(); 
// Základní nastavení NameCase které používám já, více v dokumentaci
Tamtamchik\NameCase\Formatter::setOptions([ 'Czech' => false, 'lazy' => false ]);



if(isset($_POST["ids"])){
    include_once("../conn.php");
    $json = $_POST["ids"];
    $ids = json_decode($json);

    
  $columns_name = array();
  $sql = "SELECT id,name from columns;";
  $result = $conn->query($sql);
  if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
      $columns_name["c".$row["id"]] = $row["name"];
    }
  }

  $subject_names = array();
  $sql = "SELECT id,name from subject;";
  $result = $conn->query($sql);
  if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
      $subject_names[$row["id"]] = $row["name"];
    }
  }

    $sql = "SELECT * from firm where firm.id in (";
    for($x = 0;$x < count($ids->{'ids'});$x++){
      $sql .= $ids->{'ids'}[$x];
      if($x != count($ids->{'ids'})-1){
          $sql .= ",";
      }
  }
  $sql.= ");";


$result = $conn->query($sql);
$csv_first_line = false;
$csv_first = "";
$csv = "";

//print_r($_POST);echo "<br><br><br>";

if ($result->num_rows > 0) {
  while($row = $result->fetch_assoc()) {
    $x = 0;
    foreach ($row as $key => $value) {
     /*
    echo "$key:".array_key_exists($key,$_POST).", "
    //.$_POST[$key]
    ." $key => $value<br>";
    
    if($key == "subject_id"){
          if (!isset($_POST[$value])) continue;
          
        }else
            if (!isset($_POST[$key])) continue;
    */
    
     if ($key=="surname")
               {
               if (strlen($value)>3)
               {
                $name=explode(" ",$vocative->vocative($value));
               
                if (isset($name[1])) $surname=$name[1];else $surname=$name[0];
                
                if ($vocative->isMale($surname)) $salut="Vážený pane ";else $salut="Vážená paní ";
                
                    $csv .= $salut.$surname . ";";
                }else {
                
                    $csv .=  "Dobrý den ;";
                
                }
               }
          
    
    
    if (array_key_exists($key,$_POST)) 
    {
      $value = preg_replace("/\n|\r/", " ", $value);
      $value = str_replace(";", " ", $value);
          if(!$csv_first_line){
            if($x < 17){
              if ($key=="surname") $csv_first .= "Vokativ;";
              $csv_first .= $key . ";";
              
            } else{
              $csv_first .= $columns_name[$key] . ";";
              
              
            }
            
          }
          $x += 1;
          
         
          
          if($key == "subject_id"){
            $csv .= $subject_names[$value] . ";";
            continue;
          }
         
          
          $csv .= $value . ";";

   // echo " $key => $value<br>";

    }
    }//foreach
    $csv .= "\n";
    $csv_first_line = true;
  }
  // echo "<br>";
  // echo $csv;
}
$conn->close();

$csv = $csv_first . "\n" . $csv;

//exit;

$file = "export.csv";
$txt = fopen($file, "w") or die("Unable to open file!");
fwrite($txt, iconv("UTF-8", "Windows-1250//TRANSLIT", $csv));
fclose($txt);
header("Content-Type: text/plain; charset=Windows-1250");
header('Content-Description: File Transfer');
header('Content-Disposition: attachment; filename='.basename($file));
header('Expires: 0');
header('Cache-Control: must-revalidate');
header('Pragma: public');
header('Content-Length: ' . filesize($file));
readfile($file);

}



?>