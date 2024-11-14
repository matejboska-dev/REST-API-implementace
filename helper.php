<?php
function htmlClean($str)  {

$str= str_replace("<", "&lt;",$str);

$str= str_replace(">", "&gt;",$str);

return $str= str_replace("<", "&lt;",$str);
}
function htmlCleanRow($row) {//čistka string od <>

if (is_array($row)) {


foreach ($row as $key=>$value) {

$row[$key]=htmlClean($value);
	
}
return $row;
}

else {
return htmlClean($row);

}

}

function setPhotosDir($directory) {

if (is_dir($directory)) return 1;
return mkdir ($directory);
} 


function getFirmPhotos($id) {

  $a = array();  

  $directory = "./photos/$id";
  
  if (is_dir($directory) ) {
  
    $directory = "./photos/$id/";
    $images = glob($directory . "/*.jpg");
    
    foreach($images as $image)
    {
      array_push($a,$directory.$image);
    }

    $images = glob($directory . "/*.png");
    
    foreach($images as $image)
    {
      array_push($a,$image);
    }

    
}

return $a;
}


?>