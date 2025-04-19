<?php
$likesData = file_exists('likes.json') ? json_decode(file_get_contents('likes.json'), true) : [];
?>

<!DOCTYPE html>
<html>

<head>
    <title>MyCuisine</title>
    <link rel="stylesheet" href="style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
</head>

<body>
    <div class="header">
        <ul>
            <li>
                <h1>MyCuisine</h1>
            </li>

        </ul>
    </div>

    <div class="row">
        <div class="column side">
            <h2>Profile</h2>
            <img src="https://www.pngmart.com/files/23/Profile-PNG-Photo.png" class="profileImg" alt="Profile Picture">
            <p>Nom: <span id="nom"><?= htmlspecialchars($user['nom'] ?? 'Nom') ?></span></p>
            <p>Prénom: <span id="prenom"><?= htmlspecialchars($user['prenom'] ?? 'Prénom') ?></span></p>
            <p>Email: <span id="email"><?= htmlspecialchars($currentUserEmail ?? 'Email') ?></span></p>
            <input type="file">
            <a type="button" class="siteButton" href="index.php">Modifier le profil</a>
            <a type="button" class="siteButton" href="connexion.php">Déconnexion</a>
        </div>

        <div class="column middle">
            <h2>Recettes</h2>
            <div class="imggg">
                <?php
                $jsonString = file_get_contents("recipes.json");
                $data = json_decode($jsonString, true);
                $defaultImage = 'https://mardemzamora.com/wp-content/uploads/2021/02/products-71cmugf0b7l._ac_sl1500__2.jpg';

                foreach ($data as $index => $recette) {
                    if (!isset($recette['name']) || empty($recette['name'])) continue;

                    $imageURL = $defaultImage;
                    if (isset($recette['imageURL']) && !empty($recette['imageURL'])) {
                        $imageURL = filter_var($recette['imageURL'], FILTER_VALIDATE_URL)
                            ? $recette['imageURL']
                            : $defaultImage;
                    }

                    $likeCount = $likesData[$index]['like'] ?? 0;
                    $dislikeCount = $likesData[$index]['dislike'] ?? 0;

                    echo '
                    <div class="recetteCard" data-post-id="' . $index . '">
                        <a href="recipe.php?name=' . urlencode($recette['name']) . '" class="recetteLink">
                            <img src="' . htmlspecialchars($imageURL) . '" 
                                 style="width:256px; height:256px; object-fit: cover; border-radius: 8px;" 
                                 alt="' . htmlspecialchars($recette['name']) . '"
                                 onerror="this.src=\'' . $defaultImage . '\'">
                                     <div class="TitreRecette">' . htmlspecialchars($recette['name']) . '</div>
                        </a>
                        <div class="post-ratings-container">
                            <div class="post-rating">
                                <span class="post-rating-button material-icons">thumb_up</span>
                                <span class="post-rating-count like-count">' . $likeCount . '</span>
                            </div>
                            <div class="post-rating">
                                <span class="post-rating-button material-icons">thumb_down</span>
                                <span class="post-rating-count dislike-count">' . $dislikeCount . '</span>
                            </div>
                        </div>
                    </div>';
                }
                ?>
            </div>
        </div>

        <div class="column side">
            <h2>Recherche</h2>
            <!-- Ajout : Barre de recherche -->
            <form id="search" class="recherche">
                <input type="text" id="searchInput" placeholder="Entrez le nom de la recette" required>
                <button type="submit">Rechercher</button>
            </form>
            <p>Découvrez nos recettes spéciales du jour !</p>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('.post-rating-button').on('click', function(e) { //quand like ou dislike 
                const $button = $(this); // on recupere celui le like 
                const $rating = $button.closest('.post-rating'); //on recupere les info 
                const $card = $button.closest('.recetteCard'); //in recupere la recette 
                const postId = $card.data('post-id'); //on recup l'id de la recette 
                const action = $button.text().trim() === 'thumb_up' ? 'like' : 'dislike'; //like ou dislike 

                if ($rating.hasClass('post-rating-selected')) {
                    return; //si l'uitlisateur a deja clique dessus on fait, je dois changer ca 
                }

                $.post('likes.php', { //on envoie vers le json
                    postId,
                    action
                }, function(data) {
                    $rating.find('.post-rating-count').text(data[action]); //mets a jour le compteur 

                    const $otherRating = $rating.siblings('.post-rating'); //recup l'autre bouton 
                    if ($otherRating.hasClass('post-rating-selected')) { //on fait l'action pour si on fait lautre bouton 
                        const otherAction = action === 'like' ? 'dislike' : 'like';
                        $otherRating.find('.post-rating-count').text(data[otherAction]);
                        $otherRating.removeClass('post-rating-selected');
                    }

                    $rating.addClass('post-rating-selected');
                }, 'json');
            });
            //  Gestion de la recherche
            $('#search').on('submit', function(e) {
                const searchQuery = $('#searchInput').val().trim();
                if (searchQuery) {
                    window.location.href = 'recipe.php?name=' + encodeURIComponent(searchQuery);
                }
            });
        });
    </script>
</body>

</html>