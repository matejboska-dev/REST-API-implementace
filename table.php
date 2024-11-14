<?php

use function PHPSTORM_META\sql_injection_subst;

include_once("session.php");
if (isset($_GET["search"])) {
    $search_val = $_GET["search"];
    setcookie("search", $search_val, time() + (86400 * 0.5));
}
include "helper.php";
?>
<!DOCTYPE html>
<html lang="cs">
<head>
    <meta http-equiv="Cache-Control" content="no-store" />
    <meta http-equiv='cache-control' content='no-cache'>
    <meta http-equiv='expires' content='0'>
    <meta http-equiv='pragma' content='no-cache'>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <link rel="icon" type="image/x-icon" href="./css/favicon.ico">
    <!--<link rel="stylesheet" href="minify_css.css">-->

    
    <link rel="stylesheet" href="./css/forms-style.css?v=<?php echo filemtime("./css/forms-style.css") ?>">
    <link rel="stylesheet" href="./css/style.css?v=<?php echo filemtime("./css/style.css") ?>">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Titillium+Web:400,700">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">
    

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
 
    
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css">

    <script src="./editFirm/edit.js?v=<?php echo filemtime("./editFirm/edit.js") ?>"></script>
    <script src="./js/ajax.js?v=<?php echo filemtime("./js/ajax.js") ?>"></script>
    <script src="./js/table.js?v=<?php echo filemtime("./js/table.js") ?>"></script>
    <script src="./js/clickRow.js?v=<?php echo filemtime("js/clickRow.js") ?>"></script>
    <script src="./js/select.js?v=<?php echo filemtime("./js/select.js") ?>"></script>


    <title>CRM</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <style>
        <?php
        include_once("conn.php");

        $sql = "SELECT name FROM hidden_columns";
        $result = $conn->query($sql);
        $style_string = "";
        $count = mysqli_num_rows($result);
        $i = 0;
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
               // $style_string .= ".form *[name=" .$row["name"]."],";
                $style_string .= "." . $row["name"];
                if ($i != $count - 1) {
                    $style_string .= ",";
                }
                $i++;
            }
        }
        if ($count != 0) {
        ?><?php echo $style_string; ?> {
            display: none !important;
        }

        <?php
        }
        ?>
      .extra_colmns {display:none}
    </style>
    <script>
function myFunction() {
  var x = document.getElementById("myLinks");
  if (x.style.display === "inline-flex") {
    x.style.display = "none";
  } else {
    x.style.display = "inline-flex";
  }
}




</script>
    <script>
        url = "<?php echo "http://" . $_SERVER['HTTP_HOST']; ?>/";
    </script>
    

<link href="./vendor/dragdrop/style.css" rel="stylesheet" type="text/css">
<script src="./vendor/dragdrop/script.js?v=<?php echo filemtime("./vendor/dragdrop/script.js") ?>"></script>


<link href="./vendor/jquery-ui.min.css" rel="stylesheet" type="text/css">
<script src="./vendor/jquery-ui.min.js?v=<?php echo filemtime("./vendor/jquery.min.js") ?>"></script>


</head>

<body>

   
 <div id="exportForm"></div>


    <table id="basic" class="display">
        <thead id="table-head">

            <tr>
                <th><input type="checkbox" id="main-select"></th>
                <th class="name">
                    Název
                </th>

                <th class="surname">

                    Kontaktní osoba

                </th>
                <th class="email">

                    Email

                </th>
                <th class="active">

                    Aktivní

                </th>
                <th class="phone">

                    Telefon

                </th>
                <th class="subject_id">

                    Obor

                </th>
                <th class="source">

                    Zdroj

                </th>

                <th class="hidec date_of_contact">

                    Datum 1. kontaktu

                </th>

                <th class="hidec date_of_2_contact">
                    Datum 2. kontaktu

                </th>
                <th class="hidec date_of_meeting">


                    Datum posl. schůzky

                </th>
                <th class="hidec result">

                    Výsledek

                </th>
                <th class="brigade">

                    Brigáda 2019

                </th>
                <th class="workshop">

                    WorkShop 2019

                </th>
                <th class="practice">

                    Praxe 2019

                </th>
                <th class="cv">

                    CV 2019

                </th>
                <th class="note">

                    Poznamka

                </th>
                <?php
                                $sql = "SELECT  firm.id,firm.name,firm.active,firm.source,firm.date_of_contact,firm.date_of_2_contact,firm.date_of_meeting,firm.result,firm.workshop,firm.brigade,firm.practice,firm.cv,firm.note,subject.name as subject, firm_contacts.surname as surname, firm_contacts.email as email, firm_contacts.phone as phone ";   
                $array_columns = array();
                $columns = "SELECT id,name,type FROM columns";
                $result = $conn->query($columns);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $sql .= ",c" . $row["id"];
                        array_push($array_columns, "c" . $row["id"]);
                ?>
                        <th class="<?php echo "c" . $row["id"]; ?>  ">
                            <?php echo $row["name"]; ?>
                        </th>
                <?php
                    }
                } else {
                    echo "0 results";
                }

                $sql .= " FROM firm inner join subject on firm.subject_id = subject.id  inner join firm_contacts on firm.id = firm_contacts.firm_id WHERE main=1 group by firm.id  order by active desc, firm.name";

                ?>
            </tr>
        </thead>
        <tbody>
            <?php
            
            
            $result = $conn->query($sql);
            $count = mysqli_num_rows($result);

            while ($row = $result->fetch_assoc()) {
            $row = htmlCleanRow($row);
            ?>

                <tr id="<?php echo $row['id']; ?>" class="rownum<?php echo $row['id']; ?>">
                    <td><input type="checkbox" class="check" id="<?php echo $row['id']; ?>"></td>
                    <td class="name click" title="<?php echo $row["name"]; ?>"><?php echo $row["name"]; ?></td>
                    <td class="surname click" title="<?php echo $row["surname"]; ?>"><?php echo $row["surname"]; ?></td>
                    <td class="email click" title="<?php echo $row["email"]; ?>"><?php echo $row["email"]; ?></td>
                    <td class="active click" title="<?php echo $row["active"]; ?>"><?php echo $row["active"]; ?></td>
                    <td class="phone click" title="<?php echo $row["phone"]; ?>"><?php echo $row["phone"]; ?></td>
                    <td class="subject_id click" title="<?php echo $row["subject"]; ?>"><?php echo $row["subject"]; ?></td>
                    <td class="source click" title="<?php echo $row["source"]; ?>"><?php echo $row["source"]; ?></td>
                    <td class="date_of_contact hidec lick" title="<?php echo $row["date_of_contact"]; ?>"><?php echo $row["date_of_contact"]; ?></td>
                    <td class="date_of_meeting hidec click" title="<?php echo $row["date_of_meeting"]; ?>"><?php echo $row["date_of_meeting"]; ?></td>
                    <td class="date_of_2_contact hidec click" title="<?php echo $row["date_of_2_contact"]; ?>"><?php echo $row["date_of_2_contact"]; ?></td>
                    <td class="result  hidec click" title="<?php echo $row["result"]; ?>"><?php echo $row["result"]; ?></td>
                    <td class="brigade click" title="<?php echo $row["brigade"]; ?>"><?php echo $row["brigade"]; ?></td>
                    <td class="workshop click" title="<?php echo $row["workshop"]; ?>"><?php echo $row["workshop"]; ?></td>
                    <td class="practice click" title="<?php echo $row["practice"]; ?>"><?php echo $row["practice"]; ?></td>
                    <td class="cv click" title="<?php echo $row["cv"]; ?>"><?php echo $row["cv"]; ?></td>
                    <td class="note click" title="<?php echo $row["note"]; ?>"><?php echo $row["note"]; ?></td>
                    <?php
                    foreach ($array_columns as $column_name) {
                    ?>
                        <td class="<?php echo $column_name; ?> click"><?php echo $row[$column_name]; ?></td>
                    <?php
                    }
                    ?>
                </tr>

            <?php
            }
            ?>
        </tbody>
        <tfoot></tfoot>
    </table>

    </div>

    
<div class="myframe2">
        <?php include "editFirm/editFirmForm.php"; ?>
    </div>

 
    

</body>

</html>