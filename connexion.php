<?php
if (isset($_POST["email"]) && isset($_POST["mdp"])) {
    $emailID = $_POST["email"];
    $mdpID = $_POST["mdp"];

    $connexion = verfieConnexion($emailID, $mdpID);

    if ($connexion) {
        echo "success";
        exit();
    } else {
        echo "Erreur : Email ou mot de passe incorrect.";
        exit();
    }
}

function verfieConnexion($emailID, $mdpID)
{
    $jsonString = file_get_contents('LOGIN.json');
    $data = json_decode($jsonString, true);
    foreach ($data as $id) {
        if ($id['email'] == $emailID && $id['mdp'] == $mdpID) {
            return true;
        }
    }
    return false;
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Connexion</title>
    <link rel="stylesheet" href="connexion.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>

<body>
    <ul>
        <p><a href="welcom.php">home</a>
    </ul>
    <h1>Log in</h1>
    <form class="forme" id="loginForm">
        <div class="forme">
            <label for="email">E-mail: </label>
            <input type="email" name="email" id="email" required />
        </div>
        <div class="forme">
            <label for="mdp">Mot de passe: </label>
            <input type="password" name="mdp" id="mdp" required />
        </div>
        <div class="envoie">
            <button type="button" id="connectButton">Se connecter</button>
            <p id="message"></p>
        </div>
    </form>

    <div id="HomeContent" style="display: none;"></div>

    <script>
        $(document).ready(function() {
            $('#Homebutton').on('click', function() {
                $("h1, form, ul, .forme").hide();
                $('#HomeContent').show();
                $.ajax({
                    method: 'GET',
                    url: 'welcom.php',
                    dataType: 'html',
                    success: function(response) {
                        $('#HomeContent').html(response);
                    }
                });
            });

            $('#connectButton').on('click', function() {
                let email = $("#email").val();
                let mdp = $("#mdp").val();

                if (!email || !mdp) {
                    $("#message").html("<span style='color: red;'>Tous les champs sont obligatoires.</span>");
                    return;
                }

                $.ajax({
                    method: "POST",
                    url: "connexion.php",
                    data: {
                        email: email,
                        mdp: mdp
                    },
                    success: function(response) {
                        if (response == "success") {
                            window.location.href = "site.php";
                        } else {
                            $("#message").html("<span style='color: red;'>" + response + "</span>");
                        }
                    },
                    error: function() {
                        $("#message").html("<span style='color: red;'>Erreur lors de la connexion.</span>");
                    }
                });
            });
        });
    </script>
</body>

<div class="cnx">
    <a href="login.php" type="button " class="retourButton">retour</a>
</div>

</html>