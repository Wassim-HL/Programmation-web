<!DOCTYPE html>
<html>

<head>
    <title>R$</title>
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
        print("<tr>");
        print("<th>" . "name" . "</th>");
        print("<th>" . "namefr" . "</th>"); // th c pour titre, ca met en gras, cellule mere  
        print("<th>" . "author" . "</th>"); //td les valeur des cellules filles
        print("<th>" . "without" . "</th>"); //tr va faire en gros la ligne 
        print("<th>" . "Quantite" . "</th>");
        print("<th>" . "Ingredients" . "</th>");
        print("<th>" . "Type" . "</th>");
        print("</tr>");



        foreach ($datafiltrer  as $recette) {

            $ingredients = isset($recette['ingredients']) && is_array($recette['ingredients']) ? $recette['ingredients'] : [];
            $exclusions = isset($recette['Without']) ? implode(", ", $recette['Without']) : "N/A";

            if (!empty($ingredients)) {
                foreach ($ingredients as $ingredient) {
                    print("<tr>");

                    print("<td>{$recette['name']}</td>");
                    print("<td>" . (isset($recette['nameFR']) ? $recette['nameFR'] : "-1") . "</td>");
                    print("<td>" . (isset($recette['Author']) ? $recette['Author'] : "-1") . "</td>");
                    print("<td>$exclusions</td>");
                    print("<td>{$ingredient['quantity']}</td>");
                    print("<td>{$ingredient['name']}</td>");
                    print("<td>{$ingredient['type']}</td>");
                    print "</tr>";
                }
            } else {
                print("<tr>");
                print("<td>{$recette['name']}</td>");
                print("<td>{$recette['nameFR']}</td>");
                print("<td>{$recette['Author']}</td>");
                print("<td>$exclusions</td>");
                print("<td colspan='3'>Aucun ingrédient</td>");
                print("</tr>");
            }
        }
        ?>
    </table>


</body>