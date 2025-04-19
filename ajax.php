<!DOCTYPE html>
<html>

<head>
    <title>Fichier 2</title>
    <link rel="stylesheet" href="ground.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        function setNom() {
            let prenom = $("#fname").val();
            let nom = $("#lname").val();

            $.ajax({
                method: "GET",
                url: "ajax.php", // Ce fichier PHP n'a plus besoin de renvoyer de données
                data: {
                    "fname": prenom,
                    "lname": nom
                },
                headers: {
                    "X-Requested-With": "XMLHttpRequest"
                }
            }).done(function(response) {
                // Vous pouvez simplement cacher le formulaire et afficher un message, sans renvoyer des valeurs
                $("#message").html("<span class='ok'>Les données ont été envoyées avec succès !</span>");
                $("#monFormulaire").hide(); // Masquer le formulaire après soumission
            }).fail(function() {
                $("#message").html("<span class='ko'>Erreur: problème réseau</span>");
            });
        }
    </script>
</head>

<body>

    <h1>Formulaire</h1>

    <form id="monFormulaire">
        <label for="fname">First name:</label>
        <input type="text" id="fname" name="fname"><br><br>

        <label for="lname">Last name:</label>
        <input type="text" id="lname" name="lname"><br><br>

        <input type="button" value="Submit" onclick="setNom()">
    </form>

    <div id="message">...</div>

</body>

</html>