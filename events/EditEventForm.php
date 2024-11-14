<?php
include_once("../session.php");
?>
<html lang="en" class=""><head>

    <meta charset="UTF-8">
    <title>Přidání události</title>
  
    <meta name="robots" content="noindex">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Titillium+Web:400,700">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">
      <link rel="stylesheet" href="../css/forms-style.css?v=<?php echo filemtime("../css/forms-style.css") ?>">
    <link rel="stylesheet" href="../css/style.css?v=<?php echo filemtime("../css/style.css") ?>">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="edit.js?v=<?php echo filemtime("./edit.js") ?>""></script>
      <script src="search.js?v=<?php echo filemtime("./search.js") ?>""></script>  
  </head>
  <body>
  <?php if(isset($_GET["err"]) && $_GET["err"]==1){
   ?><p class="field">
      
    <label class="editFirmError">Chyba při uložení</label>
       
    </p>
  <?
  }?>
    <?php
    if(isset($_GET["id"])){
      include_once("../conn.php");
      $sql = "SELECT events.id, events.name,events.description,events.time_start FROM events where events.id = ".$_GET["id"];
      $result = $conn->query($sql);

      if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
    ?>
    <form action="editEvent.php" method="POST" class="form" >
        <input type="hidden" name="id" value="<?php echo $_GET["id"]; ?>">
        
        <label class="label required" for="">Přidání Události</label>
        <p class="field required"></p>
    <p class="field required ">
        
      <label class="label required" for="name">Název</label>
      <input class="text-input" name="name" required="" type="text" value="<?php echo $row["name"]; ?>">
    </p>
    
    <p class="field">
        <label class="label" for="description">Popis</label>
        <textarea class="textarea" cols="50" name="description" rows="4"><?php echo $row["description"]; ?></textarea>
      </p>

      <div class="field half">
        <label class="label">Začátek Události</label>
        <?php
        if($row["time_start"] != null){
        $time_start = $row["time_start"];
        $parts = explode(" ",$time_start);
        $parts2 = explode(":",$parts[1]);
        $final_time = $parts[0]."T".$parts2[0].":".$parts2[1];
      }
      else {
        $final_time = "";
      }
        ?>
        <input class="text-input" name="time_start" type="datetime-local" value="<?php echo $final_time; ?>">
      </div>

      <div class="field half">
        
      </div>


<p class="field half required">
      <label class="label" for="password">Firma</label>
      <input class=" text-input" placeholder="Vyhledávaní" id="search-bt" type="text" value="">
      <select class="select firms firmy-s" multiple>
      <?php
                include_once("../conn.php");
                $sql = "SELECT id,name FROM firm order by name";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    ?>
                    <option value="<?php echo $row["id"] ?>"><?php echo $row["name"] ?></option>
                    <?php
                }
                } else {
                    ?>

                    <option value="0"> Žádne firmy</option>
                    <?php
                }
                ?>
  </select>
  </p>
  <p class="field half">
  <label class="label" for="password">Firmy v události</label>
    <select class="select firms-in-event firmy-s" name="firm_id[]" multiple>
    <?php
      $sql2 = "SELECT firm.name,firm_id FROM firms_in_event inner join firm on firms_in_event.firm_id = firm.id where firms_in_event.event_id = ". (int) $_GET["id"];
      $result2 = $conn->query($sql2);
      
      if ($result2->num_rows > 0) {
        while($row2 = $result2->fetch_assoc()) {
          ?>
          <option value="<?php echo $row2["firm_id"]; ?>" selected><?php echo $row2["name"]; ?></option>
          <?php
        }
      } else {
        echo '<option value="0"> Žádne firmy</option>';
      }
      ?>           
    </select>
  </p>
    <p class="field half">
    <button class="button" id="add-btn">Přidat</button>
  </p>
  <p class="field half">
    <button class="button" id="remove-btn">Odebrat</button>
  </p>

     <p class="field half">
  
    </p>
       <p class="field half">
  
    </p>
  
  
    <p class="field half">
      <input class="button" type="submit" id="send-button" value="uložit">
    </p>
  
  <p class="field half">
    <a  class="button" href="tableEvents.php">Zpět</a>
   
  </p>
  </form>
  
  
  <?php
    }
  }else echo "Id error"
    ?>
  
  
  
  </body></html>
  