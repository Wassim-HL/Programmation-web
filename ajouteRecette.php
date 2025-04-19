<!doctype html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <title>Titre de la page</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        function setNom(prenom) {
            $.ajax({
                method: "GET",
                url: "getNomForPrenom.php",
                data: {
                    "prenom": prenom
                }
            }).done(function(e) {
                $("#prenom").css("background", "lightgreen");
                $("#nom").val(e);
            }).fail(function(e) {
                console.log(e);
                $("#message").html("<span class='ko'> Error: network problem </span>");
            });

            $(".truc").css("background", "yellow");
            $("#mabellediv").css("color", "red");
            $("div input").addClass("encadre");
        }
    </script>
</head>

<body>
    Bonjour le monde
    <div>
        Entrez votre prénom :
        <input type="text" id="prenom" onchange="setNom(this.value)">
        <input type="text" id="nom"><br>
    </div>
    <div id="message">...</div>
</body>

</html>
<?php
$prenom = $_GET["prenom"];
if ($prenom == "frederic") print("VERNIER");
else if ($prenom == "nicolas") print("SABOURET");
else if ($prenom == "sandrine") print("DELAHAYE");
else print("INCONNU")
?>