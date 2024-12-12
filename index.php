<?php
// Inclure le fichier de configuration pour la connexion à la base de données
include 'config.php';

// Récupérer les 3 derniers enregistrements de la table `news`
$query = "SELECT * FROM news ORDER BY date DESC LIMIT 3";
$stmt = $pdo->prepare($query);
$stmt->execute();
$newsItems = $stmt->fetchAll(PDO::FETCH_ASSOC);

$query = "SELECT * FROM member ORDER BY id ASC LIMIT 6";
$stmt = $pdo->prepare($query);
$stmt->execute();
$members = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <script src="https://kit.fontawesome.com/800ce2d647.js" crossorigin="anonymous"></script>
    <link rel="shortcut icon" href="img/avatar.png" type="image/x-icon">
    <script src="js/smooth.js"></script>
    <title>Department Of State - FlashLand</title>
</head>
<body>
    <header>
        <div>
            <a href="#welcome"><img src="img/avatar.png" alt="Logo DOS"></a>
        </div>
        <nav>
            <a href="#government">Government</a>
            <a href="#news">News</a>
            <a href="">Documents</a>
            <a href="">Events</a>
            <a href="#about-us">About Us</a>
            <a href="login.php">Login</a>
        </nav>
    </header>

    <main>

        <section class="slider" id="welcome">
            <img src="img/gov.webp" alt="Batiment Gouvernement" class="slider-img">
            <div class="slider-txt">
                <h1>Welcome, Bienvenu</h1>
                <h2>Nous vous souhaitons une bonne visite!</h2>
                <a href="#about-us">Learn More ➜</a>
            </div>
        </section>

        <section class="news" id="news">
            <h3>In other News</h3>
            <div class="news-container">
                <?php foreach ($newsItems as $news): ?>
					<article class="news-box">
						<div class="news-img">
							<img src="img/<?php echo htmlspecialchars($news['img']); ?>" alt="News img">
						</div>
						<div class="news-txt">
							<h4><?php echo htmlspecialchars($news['title']); ?></h4>
							<p><?php echo htmlspecialchars($news['description']); ?></p>
							<p><small><?php echo htmlspecialchars($news['date']); ?></small></p>
						</div>
					</article>
				<?php endforeach; ?>
            </div>
        </section>

        <section class="about" id="about-us">
            <h3>About Us</h3>
            <p>
                Le gouvernement de l’état de San Andréas a pour fonction la gestions des différentes politiques.Il est composer d’un corp de gouvernance, à sa tête on y retrouve le Gouverneur de l’état épaulé par le Lieutenant-Gouverneur aussi appellé Vice-Gouverneur.Le gouvernement contient aussi le dit cabinet, gerer par le Chef de Cabinet nommé en début de mandat par la gouvernance. Ce cabinet contient l’ensembles des
                secretariats qui supervisent differents secteurs en fonctions de leurs comptétences. Ensuite vient le Departement de la Justice ou D.O.J (Department Of Justice), superviser par le Procureur Général, lui aussi nommé par la gouvernance. Il est épaulé par 
                un substitut, ensemble ils dirigent les instances de justices.
            </p>
        </section>

        <section class="gov" id="government">
            <h3>Government</h3>
            <div class="gov-container">
                <?php foreach ($members as $member): ?>
					<article class="gov-card">
						<div class="gov-img">
							<img src="<?php echo htmlspecialchars($member['img']); ?>" alt="Gov Member">
						</div>
						<div class="gov-infos">
							<h5><?php echo htmlspecialchars($member['post']); ?></h5>
							<h6><?php echo htmlspecialchars($member['name']); ?></h6>
						</div>
					</article>
				<?php endforeach; ?>
            </div>
        </section>
    </main>
    <footer>
        <nav>
            <a href="#government">Government</a>
            <a href="#news">News</a>
            <a href="">Documents</a>
            <a href="">Events</a>
            <a href="#about-us">About Us</a>
            <a href="login.php">Login</a>
        </nav>
        <img src="img/avatar.png" alt="Logo DOS">
        <p>website developed and designed by lucass - &copy 2024 All copies are prohibited</p>
    </footer>
</body>
</html>