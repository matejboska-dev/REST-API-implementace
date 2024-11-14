
<div id="dialog-confirm" title="Empty the recycle bin?" style="display:none">
  <p><span class="ui-icon ui-icon-alert" style="float:left; margin:12px 12px 20px 0;"></span>These items will be permanently deleted and cannot be recovered. Are you sure?</p>
</div>
<br><br>
  <form action="" class="form" id="<?php //echo $_GET["id"]; ?>">
<button id="closeIframe" class="button">Zavřít</button>    
    <p class="field">
     <!-- <h2 class="label" style="font-size:30px">Zobrazení a editace firmy</h2>//-->
      
    <label class="editFirmSuccess">Uloženo</label>
       
    </p>
  <p class="field required">
    <label class="label required" for="name">Firma</label>
    <input class="text-input" id="name" name="name" required="" type="text" value="<?php //echo $row["name"]; ?>">
  </p>
 
  <p class="field half">
    <label class="label" for="source">Zdroj</label>
    <input class="text-input" name="source" type="text" value="<?php //echo $row["source"]; ?>">
  </p>
  <div class="field half">
    <label class="label">Obor</label>
    <select class="select" name="subject_id" required>
          <?php
      $sql2 = "SELECT id, name FROM subject";
      $result2 = $conn->query($sql2);

      if ($result2->num_rows > 0) {
        while($row2 = $result2->fetch_assoc()) {
          ?>
         <option value="<?php echo $row2["id"]; ?>"><?php echo $row2["name"]; ?></option>
         <?php
          
        }
      }
      ?>
    </select>
  </div>
  <div class="field half">
    <label class="label">Aktivní</label>
    <select class="select" name="active">
 
        <option value="0">NE</option>
        <option value="1" selected>ANO</option>
       
    </select>
  </div>
  
  <p class="field">
  <div id="kontakty-tabs">
  <ul>
    <li><a href="#kontakt-1">Hlavní kontakt</a></li>
   
  </ul>
  <div id="kontakt-1">
  <input type="hidden" name="contatct_id[0]" value="">
     <p class="field">
         <input class="checkbox" name="active_c[0]" type="checkbox" value=""> Aktivní</p>
        <p class="field half"> <input class="radio" name="main" type="radio" value="" id="radio-main"> <label for="radio-main">Hlavní</label></p>
    <label class="label" for="surname">Jméno</label>
    <input class="text-input" name="surname[0]" type="text">
  </p>
  <p class="field">
    <label class="label" for="email">E-mail <a href="https://outlook.office.com/mail/deeplink/search?query=from:" target="_blank">&#x1F4E7;</a></label>
    <input class="text-input" name="email[0]" type="email" >
  </p>
  <p class="field">
    <label class="label" for="phone">Telefon</label>
    <input class="text-input" name="phone[0]" type="tel" >
  </p>
  </div>
  
</div>
   </p>
  
    <p class="field">
    <label class="label" for="about">Ostatní kontakty</label>
    <textarea class="textarea" cols="50" id="invalid_contacts" name="invalid_contacts" rows="4"></textarea>
  </p>
  
  
  
  <div class="field half hidec">
    <label class="label">Datum 1. Kontaktu</label>
    <input class="text-input" name="date_of_contact" type="date" value="<?php //echo $row["date_of_contact"]; ?>">
  </div>

  <div class="field half hidec">
    <label class="label">Datum 2. Kontaktu</label>
    
    <input class="text-input"name="date_of_2_contact" type="date" value="<?php //echo $row["date_of_2_contact"]; ?>">
  </div>

  <div class="field half hidec">
    <label class="label">Datum Schůzky</label>
    <input class="text-input" name="date_of_meeting" type="date" value="<?php //echo $row["date_of_meeting"]; ?>">
  </div>

  <div class="field half hidec">
    <label class="label">Výsledek</label>
    <input class="text-input" name="result" type="text" value="<?php //echo $row["result"]; ?>">
  </div>

  <div class="field half">
    <label class="label">Workshop</label>
    <input class="text-input" name="workshop" type="text" value="<?php //echo $row["workshop"]; ?>">
  </div>

  <div class="field half">
    <label class="label">Brigáda</label>
    <input class="text-input" name="brigade" type="text" value="<?php //echo $row["brigade"]; ?>">
  </div>

  <div class="field half">
    <label class="label">Praxe</label>
    <input class="text-input" name="practice" type="text" value="<?php //echo $row["practice"]; ?>">
  </div>
  <div class="field half">
    <label class="label">CV</label>
    <select class="select" name="cv">
        <option value="1">ANO</option>
        <option value="0">NE</option>
    </select>
  </div>
 
  
  <p class="field">
    <label class="label" for="about">Poznámka</label>
    <textarea class="textarea" cols="50" id="about" name="note" rows="4"><?php //echo $row["note"]; ?></textarea>
  </p>
  
    <h2 class="h2_extra_colmns">-- Další parametry --</h2>
  <span class="extra_colmns field"></span> 
  
    <h2 class="">Schůzky:</h2>
  <div class="meets field">
  
  
  </div> 
  
  
  <p class="field buttons">
    <button class="button" id="send-button" value="Uložit">Uložit</button>
    
  </p>
  
  </form>
  
  <div id="firm_photos"></div>

<?php
 include "./vendor/dragdrop/uploader.php"; 

?>


