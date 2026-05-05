<?php
session_start();
if(isset($_SESSION['user'])){
    header("Location: accueil.php");
    exit();
}
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
        header h1 {
            font-size: 20px;
        }
        header img {
            height: 60px;
        }
        .contenu {
            text-align: center;
            margin-top: 100px;
        }
        .contenu h2 {
            margin-bottom: 30px;
            color: #2c3e50;
        }
        .contenu a {
            display: inline-block;
            margin: 10px;
            padding: 10px 25px;
            background-color: #2c3e50;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }
        .contenu a:hover {
            background-color: #1a252f;
        }
    </style>
</head>
<body>

<header>
    <img src="assets/logo_eneam.png" alt="ENEAM">
    <h1>Bienvenue sur ma plateforme</h1>
    <img src="assets/logo_uac.png" alt="UAC">
</header>

<div class="contenu">
    <h2>Que voulez-vous faire ?</h2>
    <a href="/boutique/inscription.php">S'inscrire</a>
    <a href="/boutique/connexion.php">Se connecter</a>
</div>

</body>
</html>