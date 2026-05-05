<?php
session_start();
include 'config.php';

$message = "";

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $email = $_POST['email'];
    $mot_de_passe = $_POST['mot_de_passe'];

    $sql = "SELECT * FROM users WHERE email = :email";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':email' => $email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if($user && password_verify($mot_de_passe, $user['mot_de_passe'])){
        $_SESSION['user'] = $user;
        header("Location: accueil.php");
        exit();
    } else {
        $message = "Email ou mot de passe incorrect !";
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion</title>
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
            max-width: 400px;
            margin: 80px auto;
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
            color: red;
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
    <h2>Connexion</h2>
    <?php if($message != "") echo "<p class='message'>$message</p>"; ?>
    <form method="POST">
        <label>Email :</label>
        <input type="email" name="email" required>

        <label>Mot de passe :</label>
        <input type="password" name="mot_de_passe" required>

        <button type="submit">Se connecter</button>
    </form>
    <div class="lien">
        <a href="inscription.php">Pas encore inscrit ? S'inscrire</a>
    </div>
</div>

</body>
</html>