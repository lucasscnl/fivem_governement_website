<?php
session_start();
include '../config.php';

// Vérifier que l'utilisateur est connecté et qu'il a les bonnes permissions
if (!isset($_SESSION['user']) || $_SESSION['user']['perm'] !== 'PERM_ADMIN') {
    $_SESSION['message'] = "Vous n'avez pas les permissions nécessaires pour ajouter un membre.";
    $_SESSION['message_type'] = "error";
    header('Location: dashboard.php'); // Redirection vers le tableau de bord si l'utilisateur n'a pas les permissions
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['username'] ?? '';
    $post = $_POST['post'] ?? '';
    $img = $_POST['img'] ?? '';

    if (!empty($name) && !empty($post)) {
        $query = "INSERT INTO member (name, post, img) VALUES (:name, :post, :img)";
        $stmt = $pdo->prepare($query);

        try {
            $stmt->execute([
                ':name' => $name,
                ':post' => $post,
                ':img' => $img,
            ]);
            $_SESSION['message'] = "Membre ajouté avec succès.";
            $_SESSION['message_type'] = "success";
        } catch (PDOException $e) {
            $_SESSION['message'] = "Erreur lors de l'ajout du membre : " . $e->getMessage();
            $_SESSION['message_type'] = "error";
        }
    } else {
        $_SESSION['message'] = "Tous les champs sont requis.";
        $_SESSION['message_type'] = "error";
    }

    header('Location: dashboard.php'); // Redirection vers la page du formulaire
    exit;
}
?>
