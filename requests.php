<?php
require_once "service.php";
require_once "helper.php";
  

Class requests {
  private $method;
  private $GETdata;
  private $POSTdata;
  private $ser;
  
  
  public function __construct($conn) {
    $this->ser=new Service($conn);
    $this->method;$_SERVER["REQUEST_METHOD"];
    $this->GETdata=$_GET;
    $this->POSTdata=$_POST;
    if (isset($_GET["cmd"]))
        $this->controler($_GET["cmd"]);
    else 
        $this->controler("");
   
  }
  
  function controler($cmd) {
  $cmd=str_replace("cmd/","",$cmd);
  
  switch ($cmd) {
  
  case "getFirm":  $this->output($this->ser->getFirm($_GET["id"])); break;
  case "getFirmPhotos":  $this->output(getFirmPhotos($_GET["id"])); 
    break;
  case "getFirmHidenColmn":  $this->output($this->ser->getFirmHidenColmn($_GET["id"])); break; 
  
  case "getFirmContacts":  $this->output($this->ser->getFirmContacts($_GET["id"])); break;
  
  case "getMeet":  $this->output($this->ser->getMeet($_GET["id"])); break;
  
  case "getMeets":  $this->output($this->ser->getMeets($_GET["id"])); break;
  
        
   default:$this->output ("err"); 
  }
  }
  

private function output ($str) {
    if (!is_array($str))
         echo json_encode(array("msg"=>$str));
    else 
        echo json_encode($str);

}

  
}
?>