<?php
session_start();
include 'config.php';

$message = "";

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $age = $_POST['age'];
    $adresse = $_POST['adresse'];
    $ville = $_POST['ville'];
    $email = $_POST['email'];
    $telephone = $_POST['telephone'];
    $mot_de_passe = password_hash($_POST['mot_de_passe'], PASSWORD_DEFAULT);

    $sql = "INSERT INTO users (nom, prenom, age, adresse, ville, email, telephone, mot_de_passe) 
            VALUES (:nom, :prenom, :age, :adresse, :ville, :email, :telephone, :mot_de_passe)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':nom' => $nom,
        ':prenom' => $prenom,
        ':age' => $age,
        ':adresse' => $adresse,
        ':ville' => $ville,
        ':email' => $email,
        ':telephone' => $telephone,
        ':mot_de_passe' => $mot_de_passe
    ]);

    $message = "Inscription réussie !";
    header("Location: connexion.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Inscription</title>
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
            max-width: 500px;
            margin: 40px auto;
            background: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }
        h2 {
            text-align: center;
            color: #2c3e50;
            margin-bottom: 20px;
        }
        label {
            display: block;
            margin-top: 10px;
            font-weight: bold;
        }
        input {
            width: 100%;
            padding: 8px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }
        button {
            width: 100%;
            margin-top: 20px;
            padding: 10px;
            background-color: #2c3e50;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }
        button:hover { background-color: #1a252f; }
        .lien {
            text-align: center;
            margin-top: 15px;
        }
        .lien a { color: #2c3e50; }
        .message {
            color: green;
            text-align: center;
            margin-bottom: 10px;
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
    <h2>Formulaire d'inscription</h2>
    <?php if($message != "") echo "<p class='message'>$message</p>"; ?>
    <form method="POST">
        <label>Nom :</label>
        <input type="text" name="nom" required>

        <label>Prénom :</label>
        <input type="text" name="prenom" required>

        <label>Âge :</label>
        <input type="number" name="age" required>

        <label>Adresse :</label>
        <input type="text" name="adresse" required>

        <label>Ville :</label>
        <input type="text" name="ville" required>

        <label>Email :</label>
        <input type="email" name="email" required>

        <label>Téléphone :</label>
        <input type="text" name="telephone" required>

        <label>Mot de passe :</label>
        <input type="password" name="mot_de_passe" required>

        <button type="submit">S'inscrire</button>
    </form>
    <div class="lien">
        <a href="connexion.php">Déjà inscrit ? Se connecter</a>
    </div>
</div>

</body>
</html>