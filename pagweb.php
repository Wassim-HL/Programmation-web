<!DOCTYPE html>
<html>

<head>
    <title>Binome</title>
    <link rel="stylesheet" href="ground.css">
</head>

<body>
    <h1>Listes des etudiants</h1>
    <table border="1">
        <?php
        $jsonString = file_get_contents("listeEtudiants" . ".json");
        $data = json_decode($jsonString, true);
        $datafiltrer = [];

        foreach ($data as $i => $v) {
            if ($v['groupes'] != null) {
                $datafiltrer = json_decode($jsonString, true);
            }
        }
        print("<th>" . "numero" . "</th>");
        print("<th>" . "prenom" . "</th>"); // th c pour titre, ca met en gras, cellule mere  
        print("<th>" . "nomdefamille" . "</th>"); //td les valeur des cellules filles
        print("<th>" . "adressemail" . "</th>"); //tr va faire en gros la ligne 
        print("<th>" . "groupe" . "</th>");

        $cpt = 1;
        foreach ($datafiltrer as $i => $v) {
            print("<tr>");
            print("<td>" . $cpt . "</td>");
            print("<td>" . $v['prnom'] . "</td>");
            print("<td>" . $v['nomdefamille'] . "</td>");
            print("<td>" . $v['adressedecourriel'] . "</td>");
            print("<td>" . $v['groupes'] . "</td>");
            print("</tr>" . "\n");
            $cpt++;
        }


        /*foreach ($data as $i => $v) {
        echo  "prénom  : " . $v["prnom"] . " " . " /  " . "nomdefamille" . " : " . $v["nomdefamille"] . "/ " . "adrs" . " : " . $v["adressedecourriel"] . "/" . "grp" . " : " . $v["groupes"] . "<br>";
    }*/
        ?>


</body>