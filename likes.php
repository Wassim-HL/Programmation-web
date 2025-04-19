<?php
function enregistrerLike($postId, $action)
{
    $fichierLikes = 'likes.json';
    $donneesLikes = file_exists($fichierLikes) ? json_decode(file_get_contents($fichierLikes), true) : [];

    if (!is_array($donneesLikes)) {
        $donneesLikes = [];
    }

    if (!isset($donneesLikes[$postId])) {
        $donneesLikes[$postId] = ["like" => 0, "dislike" => 0];
    }

    $donneesLikes[$postId][$action] += 1;

    $nouvelleChaine = json_encode($donneesLikes, JSON_PRETTY_PRINT);
    file_put_contents($fichierLikes, $nouvelleChaine);

    return $donneesLikes[$postId];
}

// Traitement AJAX
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $postId = $_POST['postId'] ?? null;
    $action = $_POST['action'] ?? null;

    if ($postId !== null && in_array($action, ['like', 'dislike'])) {
        $resultat = enregistrerLike($postId, $action);
        header('Content-Type: application/json');
        echo json_encode($resultat);
    } else {
        http_response_code(400);
        echo json_encode(['error' => 'Données invalides']);
    }
}
