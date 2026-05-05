<?php
session_start();
if(!isset($_SESSION['user'])){
    header("Location: connexion.php");
    exit();
}
$user = $_SESSION['user'];
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Accueil</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            margin: 0;
        }
        header {
            background-color: #2c3e50;
            color: white;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 20px;
        }
        header h1 { font-size: 20px; }
        header img { height: 60px; }

        .contenu {
            text-align: center;
            margin-top: 60px;
        }
        .contenu h2 {
            color: #2c3e50;
            margin-bottom: 10px;
        }
        .contenu p {
            color: #555;
            margin-bottom: 40px;
        }
        .menu {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            gap: 20px;
            margin-top: 20px;
        }
        .carte {
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            padding: 30px 40px;
            text-align: center;
            text-decoration: none;
            color: #2c3e50;
            font-size: 18px;
            font-weight: bold;
            transition: background 0.2s;
        }
        .carte:hover {
            background-color: #2c3e50;
            color: white;
        }
        .carte span {
            display: block;
            font-size: 35px;
            margin-bottom: 10px;
        }
        .btn-vente {
            display: inline-block;
            margin-top: 40px;
            padding: 12px 30px;
            background-color: #27ae60;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-size: 16px;
        }
        .btn-vente:hover { background-color: #1e8449; }

        .btn-quitter {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 25px;
            background-color: #e74c3c;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-size: 15px;
        }
        .btn-quitter:hover { background-color: #c0392b; }
    </style>
</head>
<body>

<header>
    <img src="assets/logo_eneam.png" alt="ENEAM">
    <h1>Bienvenue sur ma plateforme</h1>
    <img src="assets/logo_uac.png" alt="UAC">
</header>

<div class="contenu">
    <h2>Bonjour, <?php echo htmlspecialchars($user['prenom']); ?> !</h2>
    <p>Que souhaitez-vous faire ?</p>

    <div class="menu">
        <a href="/boutique/clients.php" class="carte">
            Clients
        </a>
        <a href="/boutique/users.php" class="carte">
            Utilisateurs
        </a>
        <a href="/boutique/articles.php" class="carte">
            Articles
        </a>
        <a href="/boutique/ventes.php" class="carte">
            Ventes
        </a>
    </div>

    <br><br>
    <a href="/boutique/effectuer_vente.php" class="btn-vente"> Effectuer une vente</a>
    <br>
    <a href="/boutique/deconnexion.php" class="btn-quitter"> Quitter</a>
</div>

</body>
</html>