<?php
session_start();
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['pass'] ?? '';

    if (!empty($username) && !empty($password)) {
        // Vérification dans la base de données
        $query = "SELECT * FROM user WHERE username = :username";
        $stmt = $pdo->prepare($query);
        $stmt->execute([':username' => $username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['pass'])) {
            // Connexion réussie
            $_SESSION['user'] = [
                'id' => $user['id'],
                'username' => $user['username'],
                'perm' => $user['perm']
            ];
            $_SESSION['message'] = ['type' => 'success', 'content' => 'Connexion réussie !'];
            header('Location: admin/dashboard.php');
            exit;
        } else {
            // Mauvais identifiants
            $_SESSION['message'] = ['type' => 'error', 'content' => 'Nom d\'utilisateur ou mot de passe incorrect.'];
        }
    } else {
        // Champs vides
        $_SESSION['message'] = ['type' => 'error', 'content' => 'Tous les champs sont requis.'];
    }

    // Redirection vers login.php avec message
    header('Location: login.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <script src="https://kit.fontawesome.com/800ce2d647.js" crossorigin="anonymous"></script>
    <script src="js/smooth.js"></script>
    <title>Department Of State - FlashLand</title>
</head>
<body>
    <main class="form-page">
        <img src="img/gov.webp" alt="" class="form-back"> 
        <section class="form-container login-box">
            <div class="login-title">
                <a href="index.php"><img src="img/avatar.png" alt="gov batiments" class="form-logo"></a>
                <h3>Login</h3>
            </div>
            <form method="POST" action="">
                <div class="form-box">
                    <label for="username">Nom d'utilisateur</label>
                    <input type="text" name="username" id="username" required>
                    <label for="pass">Mot de passe</label>
                    <input type="password" name="pass" id="pass" required>
                </div>
                <button type="submit">★ Se connecter ★</button>
            </form>
        </section>
    </main>

</body>
</html>
