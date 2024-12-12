<?php
session_start();
include '../config.php';

// Vérifier que l'utilisateur est authentifié et a les permissions nécessaires (ajouter des utilisateurs)
if (!isset($_SESSION['user'])) {
    $_SESSION['message'] = "Vous devez être connecté pour accéder à cette page.";
    $_SESSION['message_type'] = "error";
    header('Location: ../login.php');
    exit;
}

if ($_SESSION['user']['perm'] != 'PERM_ADMIN') {
    $_SESSION['message'] = "Vous n'avez pas les permissions nécessaires.";
    $_SESSION['message_type'] = "error";
    header('Location: dashboard.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['user'] ?? '';
    $password = $_POST['pass'] ?? '';
    $perm = $_POST['perm'] ?? '';

    if (!empty($username) && !empty($password) && !empty($perm)) {
        // Hashage du mot de passe
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

        $query = "INSERT INTO user (username, pass, perm) VALUES (:username, :pass, :perm)";
        $stmt = $pdo->prepare($query);

        try {
            $stmt->execute([
                ':username' => $username,
                ':pass' => $hashedPassword,
                ':perm' => $perm,
            ]);
            $_SESSION['message'] = "Utilisateur ajouté avec succès.";
            $_SESSION['message_type'] = "success";
        } catch (PDOException $e) {
            $_SESSION['message'] = "Erreur lors de l'ajout de l'utilisateur : " . $e->getMessage();
            $_SESSION['message_type'] = "error";
        }
    } else {
        $_SESSION['message'] = "Tous les champs sont requis.";
        $_SESSION['message_type'] = "error";
    }

    // Redirection pour éviter un refresh ou un renvoi des données
    header('Location: dashboard.php');
    exit;
}
?>