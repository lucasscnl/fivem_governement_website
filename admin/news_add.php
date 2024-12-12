<?php
session_start();
include '../config.php';

// Vérifier que l'utilisateur est connecté et qu'il a les bonnes permissions
if (!isset($_SESSION['user']) || ($_SESSION['user']['perm'] !== 'PERM_ADMIN' && $_SESSION['user']['perm'] !== 'PERM_REPORTER')) {
    $_SESSION['message'] = "Vous n'avez pas les permissions nécessaires pour ajouter une actualité.";
    $_SESSION['message_type'] = "error";
    header('Location: dashboard.php'); // Redirection vers le tableau de bord si l'utilisateur n'a pas les permissions
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'] ?? '';
    $description = $_POST['desc'] ?? '';
    $img = $_POST['nimg'] ?? '';
    $date = date('Y-m-d H:i:s'); // Date actuelle

    if (!empty($title) && !empty($description) && !empty($img)) {
        $query = "INSERT INTO news (title, description, img, date) VALUES (:title, :description, :img, :date)";
        $stmt = $pdo->prepare($query);

        try {
            $stmt->execute([
                ':title' => $title,
                ':description' => $description,
                ':img' => $img,
                ':date' => $date,
            ]);
            $_SESSION['message'] = "Actualité ajoutée avec succès.";
            $_SESSION['message_type'] = "success";
        } catch (PDOException $e) {
            $_SESSION['message'] = "Erreur lors de l'ajout de l'actualité : " . $e->getMessage();
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
