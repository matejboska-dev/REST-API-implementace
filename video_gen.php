<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
  <head>
  <meta http-equiv="content-type" content="text/html; charset=utf-8">

  <title></title>
  <style>
  <!--
   input, textarea {width:600px}
   textarea {height:300px}
  //-->
  </style>
  </head>
  <body>
<?
if (isset($_POST["webm"]) )
{
echo "<textarea>";
?>
<video controls="true" poster="<?=str_replace("&dl=0","",$_POST["poster"])?>&amp;raw=1" width="480" height="280">
<source src="<?=str_replace("&dl=0","",$_POST["webm"])?>&amp;raw=1" type="video/webm">
<source src="<?=str_replace("&dl=0","",$_POST["mp4"])?>&amp;raw=1" type="video/mp4">
</video>
<?


echo "</textarea>";
}

?>

<form method="post" >

<input type="text" name="webm" placeholder="webm"><br>
<input type="text" name="mp4" placeholder="mp4"><br>
<input type="text" name="poster" placeholder="poster"><br>
<input type="submit">


</form>


  </body>
</html>
