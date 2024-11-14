<?php
include_once("../session.php");
?>
<html lang="en" class="">

<head>

  <meta charset="UTF-8">
  <title>Uprava slupce u vybranych firem</title>

  <meta name="robots" content="noindex">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Titillium+Web:400,700">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">
  <link rel="stylesheet" href="/min/forms-style.min.css">

  <script src="https://cpwebassets.codepen.io/assets/editor/iframe/iframeConsoleRunner-7549a40147ccd0ba0a6b5373d87e770e49bb4689f1c2dc30cccc7463f207f997.js"></script>
  <script src="https://cpwebassets.codepen.io/assets/editor/iframe/iframeRefreshCSS-4793b73c6332f7f14a9b6bba5d5e62748e9d1bd0b5c52d7af6376f3d1c625d7e.js"></script>
  <script src="https://cpwebassets.codepen.io/assets/editor/iframe/iframeRuntimeErrors-4f205f2c14e769b448bcf477de2938c681660d5038bc464e3700256713ebe261.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <style>
    .mM {
      display: block;
      border-radius: 50%;
      box-shadow: 0 1px 3px rgba(0, 0, 0, 0.12), 0 1px 2px rgba(0, 0, 0, 0.24);
      position: fixed;
      bottom: 1em;
      right: 1em;
      -webkit-transform-origin: 50% 50%;
      transform-origin: 50% 50%;
      -webkit-transition: all 240ms ease-in-out;
      transition: all 240ms ease-in-out;
      z-index: 9999;
      opacity: 0.75
    }

    .mM svg {
      display: block
    }

    .mM:hover {
      opacity: 1;
      -webkit-transform: scale(1.125);
      transform: scale(1.125)
    }
  </style>

  <script>
    $(document).ready(function() {
      $("#send").click(function() {
        var ids_str = sessionStorage.getItem('ids');
        var ids_array = ids_str.split(";");
        var attr = $('#attr-value').find(":selected").val();
        var value = $("#value").val();
        ids_array.pop();
        console.log(ids_array);
        $.ajax({
          url: "./editRows.php",
          method: "POST",
          data: {
            "ids": ids_array,
            "attr": attr,
            "value": value
          },
          success: function(response) {
            console.log(response);
            window.location = "..";
          },
          error: function() {
            alert("error");
          }
        });
      });

      $("form").submit(function(event){
          event.preventDefault();
      });
   
     $( "#attr-value" ).on( "change", function() {
             
       $("#value").attr("type","date");
       //$('#value').get(0).type = 'date';
       
       $( "#attr-value option:selected").each(function() {
       console.log(parseInt($( this ).attr("data-type")));
       
            switch (parseInt($( this ).attr("data-type"))) {
            case 1: $("#value").attr("type","text");break;
            case 2: $("#value").attr("type","date");break;
            case 3: $("#value").attr("type","number");break;
            default: $("#value").attr("type","text");
            
            }
            
       });//change
       
              
       });//click
     
    
       });//ready
       
      
    
  </script>

</head>

<body>
  <form action="" method="POST" id="form" class="form">
    <p class="field">
    <h2 class="label" style="font-size:30px">Uprava slupce u vybranych firem</h2>
    </p>
    <p class="field required">
      <label class="label required" for="name">Hodnota</label>
      <input class="text-input" id="value" name="name" required="" type="text" value="">
    </p>
    <div class="field">
      <label class="label">Předmět</label>
      <select class="select" id="attr-value" name="subject_id-">
        <option data-type="1" value="name">Jmeno</option>
        <option data-type="1" value="surname">Příjmeni</option>
        <option data-type="1" value="email">Email</option>
        <option data-type="1" value="phone">Telefon</option>
        <option data-type="1" value="source">Zdroj</option>
        <option data-type="1" value="result">Výsledek</option>
        <option data-type="1" value="workshop">Workshop</option>
        <option data-type="1" value="brigade">Brigáda</option>
        <option data-type="1" value="practice">Praxe</option>
        <option data-type="1" value="cv">CV</option>
        <option data-type="1" value="note">Poznámka</option>
        <?php
        include_once("../conn.php");

        $sql = "SELECT id, name, type FROM columns -- where type = 1";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
          while ($row = $result->fetch_assoc()) {
        ?>
            <option value="c<?php echo $row["id"]; ?>" data-type="<?php echo $row["type"]; ?>"><?php echo $row["name"]; ?></option>
        <?php
          }
        }
        ?>
      </select>
    </div>

    <p class="field half">

    </p>
    <p class="field half">
      <input class="button" id="send" type="submit" value="Vytvořit">
    </p>
  </form>


  <script src="https://cpwebassets.codepen.io/assets/common/stopExecutionOnTimeout-1b93190375e9ccc259df3a57c1abc0e64599724ae30d7ea4c6877eb615f89387.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.customSelect/0.5.1/jquery.customSelect.min.js"></script>
  <script src="https://cdpn.io/cpe/boomboom/pen.js?key=pen.js-b03f86d6-2f3e-cc9b-ec5e-0c681121e029" crossorigin=""></script>


</body>

</html>