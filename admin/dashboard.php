<?php
session_start();
header("Cache-Control: no-cache, must-revalidate");
header("Pragma: no-cache");
header("Expires: 0");
include 'config.php';

// error_reporting(E_ALL);
// ini_set('display_errors', 1);

// // Debug : Affichage du contenu de la session
// var_dump($_SESSION);

// Vérifier si une session est ouverte et que l'utilisateur est authentifié
if (!isset($_SESSION['user'])) {
    $_SESSION['message'] = "Vous devez être connecté pour accéder à cette page.";
    $_SESSION['message_type'] = "error";
    header('Location: login.php'); // Rediriger vers la page de connexion si non connecté
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style.css">
    <script src="https://kit.fontawesome.com/800ce2d647.js" crossorigin="anonymous"></script>
    <link rel="shortcut icon" href="../img/avatar.png" type="image/x-icon">
    <script src="../js/smooth.js"></script>
    <title>Department Of State - FlashLand</title>
</head>
<body style="display: flex;">

<aside>
    <a href="logout.php"><img src="../img/avatar.png" alt="logo DOS"></a>
</aside>
    
<main class="dashboard-container">
    <div class="dashboard-items">

    <?php if (isset($message) && is_array($message)): ?>
        <div class="alert <?= htmlspecialchars($messageType) ?>">
            <?= htmlspecialchars($message['content']) ?>
        </div>
    <?php endif; ?>

        <section class="form-container">
            <div class="login-title">
                <h3>Add Members</h3>
            </div>
            <form action="member_add.php" method="POST">
                <div class="form-box">
                    <label for="username">Nom Prénom</label>
                    <input type="text" name="username" id="username" required>
                    <label for="post">Poste</label>
                    <select name="post" id="post" required>
                        <option value="">★ Choisir une valeur ★</option>
                        <option value="Governor">Gouverneur</option>
                        <option value="Vice-Governor">Vice Gouverneur</option>
                        <option value="Chief Of Staff">Chef de cabinet</option>
                        <option value="Secretary Of Defense">Secrétaire à la sécurité intérieure</option>
                        <option value="Secretary Of Treasury">Secrétaire au trésor publique</option>
                        <option value="Secretary Of State">Secrétaire d'état</option>
                        <option value="Attorney General">Procureur Général</option>
                        <option value="Deputy Attorney">Substitut du procureur</option>
                        <option value="Judge">Juge</option>
                        <option value="Lawyer">Avocat</option>
                    </select>
                    
                    <label for="img">Lien vers l'image</label>
                    <input type="text" name="img" id="img">
                </div>
                <button type="submit">★ Add ★</button>
            </form>
        </section>

        <section class="form-container">
            <div class="login-title">
                <h3>Send News</h3>
            </div>
            <form action="news_add.php" method="POST">
                <div class="form-box">
                    <label for="title">Titre</label>
                    <input type="text" name="title" id="title" required>
                    <label for="desc">Description</label>
                    <textarea id="desc" name="desc" rows="6" required></textarea>
                    <label for="nimg">Lien vers l'image</label>
                    <input type="text" name="nimg" id="nimg" required>
                </div>
                <button type="submit">★ Send ★</button>
            </form>
        </section>

        <section class="form-container">
            <div class="login-title">
                <h3>New User</h3>
            </div>
            <form action="user_add.php" method="POST">
                <div class="form-box">n,
                    <label for="user">Nom d'utilisateur</label>
                    <input type="text" name="user" id="user" required>
                    <label for="pass">Mots de passe</label>
                    <input type="password" name="pass" id="pass" required>
                    <label for="perm">Perms Level</label>
                    <select name="perm" id="perm" required>
                        <option value="">★ Choisir une valeur ★</option>
                        <option value="PERM_ADMIN">Administrateur</option>
                        <option value="PERM_RECRUT">Recruteur</option>
                        <option value="PERM_REPORTER">Redacteur de news</option>
                    </select>
                </div>
                <button type="submit">★ Create ★</button>
            </form>
        </section>
    </div>
</main>

<script>
    // Sélectionne tous les labels associés à un champ requis
  document.querySelectorAll('.form-box input[required], .form-box select[required]').forEach(input => {
    const label = document.querySelector(`label[for="${input.id}"]`);
    if (label) {
      label.classList.add('required');
    }
  });

  // Cache l'alert après 10 secondes
  setTimeout(function() {
        const alertBox = document.getElementById('alert-box');
        if (alertBox) {
            alertBox.style.transition = "opacity 0.5s"; // Transition douce
            alertBox.style.opacity = 0; // Rend le message invisible
            setTimeout(() => alertBox.remove(), 500); // Supprime l'élément après la transition
        }
    }, 10000); // 10 secondes en millisecondes
</script>


</body>
</html>