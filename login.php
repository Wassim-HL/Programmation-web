<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $prenom = $_POST["prenom"];
  $nom = $_POST["nom"];
  $email = $_POST["email"];
  $mdp = $_POST["mdp"];
  $type = $_POST["type"];

  if (($prenom) == null || ($nom) == null || ($email) == null || ($mdp) == null || ($type) == null) {
    http_response_code(400);
    echo json_encode(["error" => "Tous les champs sont obligatoires."]);
    exit();
  }

  $jsonString = file_get_contents("LOGIN.json");
  $utilisateurs = json_decode($jsonString, true) ?: [];
  foreach ($utilisateurs as $user) {
    if ($user['email'] === $email) {
      http_response_code(400);
      echo json_encode("Email deja utilise!");
      exit();
    }
  }


  ajouterUtilisateur($prenom, $nom, $email, $mdp, $type);

  header('Location: site.php');
  exit();
}

function ajouterUtilisateur($prenom, $nom, $email, $mdp, $type)
{
  $jsonString = file_get_contents("LOGIN.json");
  $utilisateurs = json_decode($jsonString, true);

  if (!is_array($utilisateurs)) {
    $utilisateurs = [];
  }

  $nouvelUtilisateur = [
    "prenom" => $prenom,
    "nom" => $nom,
    "email" => $email,
    "mdp" => $mdp,
    "type" => $type
  ];

  $utilisateurs[] = $nouvelUtilisateur;

  $newJsonString = json_encode($utilisateurs, JSON_PRETTY_PRINT);

  file_put_contents("LOGIN.json", $newJsonString);
}
?>

<!DOCTYPE html>
<html>

<head>
  <title>Log in</title>
  <link rel="stylesheet" href="LOGIN.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>

<body>
  <h1>Create an Account</h1>
  <form action="login.php" method="post" class="forme">
    <div class="forme">
      <label for="nom">Nom: </label>
      <input type="text" name="nom" id="nom" required />
    </div>
    <div class="forme">
      <label for="prenom">Prénom: </label>
      <input type="text" name="prenom" id="prenom" required />
    </div>
    <div class="forme">
      <label for="email">E-mail: </label>
      <input type="email" name="email" id="email" required />
    </div>
    <div class="forme">
      <label for="mdp">Mot de passe: </label>
      <input type="text" name="mdp" id="mdp" required />
    </div>
    <div class="forme">
      <label for="type">Type: </label>
      <select name="type" id="type" required>
        <option value="" selected="selected">Sélectionner un role</option>
        <option value="DemandeTraducteur">Traducteur</option>
        <option value="DemandeChef">Chef</option>
      </select>
    </div>
    <div class="envoie">
      <button type="button" onclick="submit()">Create</button>
      <p id="creation"> </p>
    </div>
  </form>

  <h3>Déjà un compte ?</h3>
  <div class="cnx">
    <a type="button" class="retourButton" href="connexion.php">Connecte toi ici</a>
  </div>
  <div id="ConnecteContent" style="display: none;"></div>
  <script>
    $(document).ready(function() {
      $('#Connectebutton').on('click', function() {
        $("h1, h2, h3, h4, form, ul, .forme, .cnx").hide();

        $('#ConnecteContent').show();
        console.log("L'appel AJAX vers connexion.php commence...");


        $.ajax({
          method: 'GET',
          url: 'connexion.php',
          dataType: 'html',
          success: function(response) {
            $('#ConnecteContent').html(response);
          },
        });
      });
    });
  </script>
  </div>

  <ul style="display: none;">
    <li><button id="Homebutton">Home</button></li>
  </ul>
  <div id="HomeContent" style="display: none;"></div>
  <script>
    $(document).ready(function() {
      $('#Homebutton').on('click', function() {
        $("h1, h2, form, ul, .forme, .Gender, .cnx").hide();

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
    });
  </script>

  <script>
    function submit() {
      let prenom = $("#prenom").val();
      let nom = $("#nom").val();
      let email = $("#email").val();
      let mdp = $("#mdp").val();
      let type = $("#type").val();

      if (!prenom || !nom || !email || !mdp || !type) {
        $("#creation").html("<span class='ko'>Tous les champs sont obligatoires.</span>");
        return;
      }
      console.log(prenom, nom, email, mdp, type);
      $.ajax({
        method: "GET",
        url: "Siexiste.php",
        data: {
          email: email
        }
      }).done(function(e) {
        console.log(e);
        if (e == "true") {
          $("#creation").html("<span class='ko'>Cet email est déjà utilisé.</span>");
        } else {
          $.ajax({
            method: "POST",
            url: "login.php",
            data: {
              prenom: prenom,
              nom: nom,
              email: email,
              mdp: mdp,
              type: type
            }
          }).done(function() {
            window.location.href = "site.php";
          }).fail(function() {
            $("#creation").html("<span class='ko'>Erreur lors de la creation de l'utilisateur.</span>");
          });
        }
      }).fail(function() {
        $("#creation").html("<span class='ko'>Erreur lors de la verification de l'email.</span>");
      });
    }
  </script>

</body>

</html>