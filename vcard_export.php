<?php
	require_once('./vendor/vCard-parser-master/vCard.php');
    require_once('./service.php');
    require_once "conn.php";
    require_once "helper.php";
    $ser=new Service($conn);
    $id= (int)$_GET["id"];
    
    if ($id==0) exit;
    
    $export=$ser->getFirm($id);
    
    
	//$vCard = new vCard;
    
    $vCard = new vCard();
	$vCard -> org($export["name"],'Name');
    $vCard -> n($export["surname"], 'LastName');
	$vCard -> tel($export["phone"],'work');
    $vCard -> email($export["email"]);
    $vCard->charset("UTF-8");
	
	/*$vCard -> adr('', 'POBox');
	$vCard -> adr('', 'ExtendedAddress');
	$vCard -> adr('42 Plantation St.', 'StreetAddress');
	$vCard -> adr('Baytown', 'Locality');
	$vCard -> adr('LA', 'Region');
	$vCard -> adr('30314', 'PostalCode');
	$vCard -> adr('USA', 'Country');
	*/

	
    file_put_contents(__DIR__.'/tmp/'.trim($export["name"]).'.vcf',$vCard);
    Header('Location: ./tmp/'.trim($export["name"]).'.vcf');
	//echo '<pre>'.$vCard;
    //print_r($export);
?>