<?php
include_once("../session.php");
?>
<html lang="en" class=""><head>

    <meta charset="UTF-8">
    <title>Přidání/úrava schůzky</title>
  
    <meta name="robots" content="noindex">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Titillium+Web:400,700">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">
    <link rel="stylesheet" href="../css/forms-style.css?v=<?php echo filemtime("../css/forms-style.css") ?>">
    <link rel="stylesheet" href="../css/style.css?v=<?php echo filemtime("../css/style.css") ?>">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script>
        url = "<?php echo "http://" . $_SERVER['HTTP_HOST']; ?>/";
    </script>
    
    <script src="../js/ajax.js?v=<?php echo filemtime("../js/ajax.js") ?>""></script>
    <script src="./edit.js?v=<?php echo filemtime("./edit.js") ?>""></script>
    <script>
    
    $(document).ready(function(event){
    
    var id=<? if (!isset($_GET["id"])) echo "0"; else echo $_GET["id"]; ?>;
    
    if (id==0)  {
        const now = new Date();
            const formattedDateTime = now.toISOString().slice(0, 16);
            
        $("input[name=date_time]").val(formattedDateTime);
    
    }else {
    
    
        getMeet(url,id);
    
    }
  
    });
    
    </script>
        
  </head>
  <body>
  
    <form action="" method="POST" class="form" >
     <div class="field"><label class="editFirmSuccess">Uloženo</label></div>
            <input  name="firm_id" type="hidden" value="<? echo intval($_GET["firm_id"]); ?>">
            <input  name="id" type="hidden" value="<? echo intval($_GET["id"]); ?>">
            
      <div class="field">
        <label class="label">Začátek Události</label>
    
        <input class="text-input" name="date_time" type="datetime-local" value="">
      </div>

      
   
    <p class="field">
        <label class="label" for="description">Záznam</label>
        <textarea class="textarea" cols="50" name="notes" rows="10"></textarea>
      </p>

   <p class="field half">
    <a  class="button" href="../table.php">Zpět</a>
   
  </p>
  
    <p class="field half">
      <input class="button" type="submit" id="save_meet" value="uložit">
    </p>
  
  
  </form>
  
  

  
  
  </body></html>
  