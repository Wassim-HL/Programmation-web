<!DOCTYPE html>
<html>

<head>
    <title>Liste des recettes</title>
    <link rel="stylesheet" href="ground.css">
</head>

<body>
    <h1>Listes recettes </h1>
    <table border="1">
        <?php
        $jsonString = file_get_contents("recipes" . ".json");
        $data = json_decode($jsonString, true);
        $datafiltrer = [];

        foreach ($data as $i => $v) {
            if ($v['name'] != null) {
                $datafiltrer = json_decode($jsonString, true);
            }
        }
        print("<th>");
        print("<th>" . "name" . "</th>");
        print("<th>" . "namefr" . "</th>"); // th c pour titre, ca met en gras, cellule mere  
        print("<th>" . "author" . "</th>"); //td les valeur des cellules filles
        print("<th>" . "without" . "</th>"); //tr va faire en gros la ligne
        print("<th>" . "Quantité" . "</th>");
        print("<th>" . "ingredients" . "</th>");
        print("<th>" . "Type" . "</th>");
        print("<th>");

        foreach ($datafiltrer as $i => $v) { // parcours des Recettes
            $ingredients = isset($v['ingredients']) && is_array($v['ingredients']) ? $v['ingredients'] : [];
            $exclusions = isset($v['Without']) ? implode(", ", $v['Without']) : "N/A";

            if (!empty($ingredients)) {
                foreach ($ingredients as $ingredient) {
                    print("<tr>");
                    print("<td>" . $v['name'] . "</td>");
                    print("<td>" . $v['nameFR']  . "</td>");
                    print("<td>" . $v['Author']  . "</td>");
                    print("<td>" . $exclusions . "</td>");
                    print("<td>" . $ingredient['quantity']  . "</td>");
                    print("<td>" . $ingredient['name']  . "</td>");
                    print("<td>" . $ingredient['type']  . "</td>");
                    print("</tr>");
                }
            } else {
                print("<tr>");
                print("<td>" . $v['name'] . "</td>");
                print("<td>" . $v['nameFR']  . "</td>");
                print("<td>" . $v['Author']  . "</td>");
                print("<td>" . $exclusions . "</td>");
                print("<td colspan = 3>" . "Aucun ingrédient" . "</td>");
                print("</tr>");
            }
        }

        ?>
    </table>

</body>

</html>