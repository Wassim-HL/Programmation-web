<!DOCTYPE html>
<html>

<head>
    <title>fichier1</title>
    <link rel="stylesheet" href="ground.css">
</head>

<body>
    <?php
    echo $_POST['lname'] . "  ";
    echo $_POST['fname'] . " ";

    // Affichage direct des résultats
    echo "Nom : " . htmlspecialchars($lname) . "<br>";
    echo "Prénom : " . htmlspecialchars($fname) . "<br>";



    function transformJSON($nomJSON)
    {
        $jsonString = file_get_contents($nomJSON . ".json");
        $data = json_decode($jsonString, true);
        $data["prenom"] = $_POST['fname'];
        $data["nom"] = $_POST['lname'];
        $newJsonString = json_encode($data);
        file_put_contents($nomJSON . ".json", $newJsonString);
    }
    transformJSON("message")
    ?>
</body>