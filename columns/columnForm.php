<?php
include_once("../session.php");
?>
<html lang="en" class=""><head>

    <meta charset="UTF-8">
    <title>Editace slupců</title>
  
    <meta name="robots" content="noindex">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Titillium+Web:400,700">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">
  <link rel="stylesheet" href="/min/forms-style.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script src="hideColumns.js"></script>
  
  
    
  <script src="https://cpwebassets.codepen.io/assets/editor/iframe/iframeConsoleRunner-7549a40147ccd0ba0a6b5373d87e770e49bb4689f1c2dc30cccc7463f207f997.js"></script>
  <script src="https://cpwebassets.codepen.io/assets/editor/iframe/iframeRefreshCSS-4793b73c6332f7f14a9b6bba5d5e62748e9d1bd0b5c52d7af6376f3d1c625d7e.js"></script>
  <script src="https://cpwebassets.codepen.io/assets/editor/iframe/iframeRuntimeErrors-4f205f2c14e769b448bcf477de2938c681660d5038bc464e3700256713ebe261.js"></script>
  <style>.mM{display:block;border-radius:50%;box-shadow:0 1px 3px rgba(0, 0, 0, 0.12), 0 1px 2px rgba(0, 0, 0, 0.24);position:fixed;bottom:1em;right:1em;-webkit-transform-origin:50% 50%;transform-origin:50% 50%;-webkit-transition:all 240ms ease-in-out;transition:all 240ms ease-in-out;z-index:9999;opacity:0.75}.mM svg{display:block}.mM:hover{opacity:1;-webkit-transform:scale(1.125);transform:scale(1.125)}</style></head>
  
  <body>
    <form action="addColumn.php" class="form">
    <p class="field  half required">
      <label class="label required" for="name_of_colum">Přidat Sloupec</label>
      <input class="text-input" name="name_of_column" required="" type="text">
    </p>
    <p class="field half required">
      <label class="label" for="type">Typ:</label>
      <select class="select" name="type">
      <?php
                include_once("../conn.php");
                $sql = "SELECT id,alias FROM type_of_column";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    ?>
                    <option value="<?php echo $row["id"] ?>"><?php echo $row["alias"] ?></option>
                    <?php
                }
                } else {
                    ?>
                    <option value="0"> Žádne slupce</option>
                    <?php
                }
                ?>   
      </select>
    </p>    
    <p class="field half">
        <input class="button" type="submit" value="Přidat">
      </p>
    </form> 
    <form action="removeColumn.php" class="form">
    <p class="field half required">
      <label class="label" for="id_of_column">Odebrat Sloupec</label>
      <select class="select" name="id_of_column">
      <?php
                include_once("../conn.php");
                $sql = "SELECT id,name FROM columns";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    ?>
                    <option value="<?php echo $row["id"] ?>"><?php echo $row["name"] ?></option>
                    <?php
                }
                } else {
                    ?>
                    <option value="0"> Žádne slupce</option>
                    <?php
                }
                ?>
      </select>
    </p>
    <p class="field half">
      <input class="button" type="submit" value="Smazat">
    </p>
    </form>
    <form action="" class="form">
    <?php
    $sql = "SELECT name FROM hidden_columns";
    $hidden_array = array();
    $hidden_string = "\"id\"";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        array_push($hidden_array,$row["name"]);
        $hidden_string .= ",\"".$row["name"]."\"";
    }
    }
    ?>
    <p class="field half required">
      <label class="label" for="id_of_column">Viditelné slupce:</label>
      <select class="select" id="columns_visible" multiple>
      <?php
                $sql = "SHOW COLUMNS FROM firm where Field not in ($hidden_string)";              
                $result = $conn->query($sql);
                ?>
                <?php
                if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                  $sql2 = "SELECT name,id from columns where id = '". substr($row["Field"],1). "' limit 1";
                  $result2 = $conn->query($sql2);
                  echo $sql2;
                  if ($result2->num_rows > 0) {
                    while($row2 = $result2->fetch_assoc()) {
                      ?>
                    <option class="visible" value="<?php echo $row["Field"] ?>"><?php echo $row2["name"] ?></option>
                    <?php
                    }
                  } else {
                    ?>
                    <option class="visible" value="<?php echo $row["Field"] ?>"><?php echo $row["Field"] ?></option>
                    <?php
                  }
                    
                }
                } else {
                   
                }
                ?>
      </select>
      <input class="button" type="submit" id="hide-btn" value="Skrýt">
    </p>
    <p class="field half required">
      <label class="label" for="id_of_column">Skryté slupce:</label>
      <select class="select" id="columns_hidden" multiple>
      <?php
                $sql = "select * from hidden_columns";              
                $result = $conn->query($sql);
                ?>
                <?php
                if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                  $sql2 = "SELECT name,id from columns where id = '". substr($row["name"],1). "' limit 1";
                  $result2 = $conn->query($sql2);

                  if ($result2->num_rows > 0) {
                    while($row2 = $result2->fetch_assoc()) {
                      ?>
                    <option class="hide" value="<?php echo $row["name"] ?>"><?php echo $row2["name"] ?></option>
                    <?php
                    }
                  } else {
                    ?>
                    <option class="hide" value="<?php echo $row["name"] ?>"><?php echo $row["name"] ?></option>
                    <?php
                  }
                    
                }
                } else {
                    
                }
                ?>
      </select>
      <input class="button" type="submit" id="visible-btn" value="Zviditelnit">
    </p>
    </form>
  <script src="https://cpwebassets.codepen.io/assets/common/stopExecutionOnTimeout-1b93190375e9ccc259df3a57c1abc0e64599724ae30d7ea4c6877eb615f89387.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.customSelect/0.5.1/jquery.customSelect.min.js"></script>
    <script src="https://cdpn.io/cpe/boomboom/pen.js?key=pen.js-b03f86d6-2f3e-cc9b-ec5e-0c681121e029" crossorigin=""></script><a href="https://codepen.io/mican/" target="_blank" class="mM"><svg width="32" height="32" viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg"><title>codepen-logo</title><path d="M16 32C7.163 32 0 24.837 0 16S7.163 0 16 0s16 7.163 16 16-7.163 16-16 16zM7.139 21.651l1.35-1.35a.387.387 0 0 0 0-.54l-3.49-3.49a.387.387 0 0 0-.54 0l-1.35 1.35a.39.39 0 0 0 0 .54l3.49 3.49a.38.38 0 0 0 .54 0zm6.922.153l2.544-2.543a.722.722 0 0 0 0-1.018l-6.582-6.58a.722.722 0 0 0-1.018 0l-2.543 2.544a.719.719 0 0 0 0 1.018l6.58 6.579c.281.28.737.28 1.019 0zm14.779-5.85l-7.786-7.79a.554.554 0 0 0-.788 0l-5.235 5.23a.558.558 0 0 0 0 .789l7.79 7.789c.216.216.568.216.785 0l5.236-5.236a.566.566 0 0 0 0-.786l-.002.003zm-3.89 2.806a.813.813 0 1 1 0-1.626.813.813 0 0 1 0 1.626z" fill="#FFF" fill-rule="evenodd"></path></svg></a>
  
  
  </body></html>
  