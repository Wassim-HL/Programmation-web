<?php
$jsonString = file_get_contents("recipes.json");
$data = json_decode($jsonString, true);

$recipeName = isset($_GET['name']) ? urldecode($_GET['name']) : null;

$selectedRecipe = null;
foreach ($data as $recipe) {
    if ($recipe['name'] === $recipeName) {
        $selectedRecipe = $recipe;
        break;
    }
}

if (!$selectedRecipe) {
    die("Recette non trouvée.");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $message = $_POST["message"];
    ajouterCommentaire($message);
}

function ajouterCommentaire($message)
{
    $jsonString = file_get_contents("CommentRecips.json");
    $Comments = json_decode($jsonString, true);

    if (!is_array($Comments)) {
        $Comments = [];
    }

    $nouveauCommentaire = [
        "IciLeNom" => $message,
    ];

    $Comments[] = $nouveauCommentaire;

    $newJsonString = json_encode($Comments, JSON_PRETTY_PRINT);

    file_put_contents("CommentRecips.json", $newJsonString);
}
?>

<!DOCTYPE html>
<html>

<head>
    <title><?= $selectedRecipe['name'] ?></title>
    <link rel="stylesheet" href="recipe.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>

<body>
    <div class="tout">
        <div class="header">
            <h1>MyCuisine</h1>
            <ul>
                <li><a href="site.php">Retour à la liste des recettes</a></li>
            </ul>
        </div>

        <div class="row">
            <div class="column middle">
                <h2><?= $selectedRecipe['name'] ?></h2>
                <img src="<?= $selectedRecipe['imageURL'] ?>" alt="<?= $selectedRecipe['name'] ?>" style="width:100%;max-width:500px;">
                <h3>Ingrédients</h3>
                <ul>
                    <?php foreach ($selectedRecipe['ingredients'] as $ingredient): ?>
                        <li><?= $ingredient['quantity'] ?> <?= $ingredient['name'] ?></li>
                    <?php endforeach; ?>
                </ul>
                <h3>Étapes</h3>
                <ol>
                    <?php foreach ($selectedRecipe['steps'] as $step): ?>
                        <li><?= $step ?></li>
                    <?php endforeach; ?>
                </ol>
            </div>
        </div>

        <h4>Commentaires</h4>

        <form action="recipe.php?name=<?= urlencode($recipeName) ?>" method="post" class="forme">
            <div class="Com">
                <label for="Commentaires"> </label>
                <input type="text" name="message" id="Commentaires" required />
            </div>
            <div class="Envoie">
                <button type="button" onclick="submit()">Envoyer</button>
                <p id="creation"> </p>
            </div>
        </form>

        <div id="commentaires-list">
            <?php
            $jsonComments = file_get_contents("CommentRecips.json");
            $existingComments = json_decode($jsonComments, true);
            if (is_array($existingComments)) {
                foreach ($existingComments as $comment) {
                    echo '<p class="commentaire">' . htmlspecialchars($comment['IciLeNom']) . '</p>';
                }
            }
            ?>
        </div>
    </div>

    <script>
        function submit() {
            let commentaire = $("#Commentaires").val();
            console.log(commentaire); //  verifier dans la console
            $.ajax({
                method: "POST",
                url: "recipe.php",
                data: {
                    message: commentaire
                },
            }).done(function(response) {
                if (response.success) {
                    $("#commentaires-list").append('<p class="commentaire">' + commentaire + '</p>');
                    $("#Commentaires").val("");
                }
            }).fail(function() {
                $("#creation").html("<span class='ko'>Erreur lors de l'ajout.</span>");
            });
        }
    </script>
</body>

</html>