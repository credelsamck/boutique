<?php
session_start();
if(!isset($_SESSION['user'])){
    header("Location: connexion.php");
    exit();
}
include 'config.php';

$message = "";

// Ajouter un utilisateur
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
    $message = "Utilisateur ajouté avec succès !";
}

// Récupérer la liste des utilisateurs
$users = $pdo->query("SELECT * FROM users")->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Utilisateurs</title>
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
            max-width: 900px;
            margin: 30px auto;
            background: white;
            padding: 25px;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }
        h2 { color: #2c3e50; margin-bottom: 15px; }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table th {
            background-color: #2c3e50;
            color: white;
            padding: 10px;
            text-align: left;
        }
        table td {
            padding: 8px 10px;
            border-bottom: 1px solid #ddd;
        }
        table tr:hover { background-color: #f9f9f9; }

        .btn {
            display: inline-block;
            padding: 8px 20px;
            margin: 5px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px;
            text-decoration: none;
        }
        .btn-ajouter { background-color: #27ae60; color: white; }
        .btn-ajouter:hover { background-color: #1e8449; }
        .btn-quitter { background-color: #e74c3c; color: white; }
        .btn-quitter:hover { background-color: #c0392b; }

        .formulaire {
            display: none;
            margin-top: 20px;
            background: #f9f9f9;
            padding: 20px;
            border-radius: 8px;
            border: 1px solid #ddd;
        }
        label {
            display: block;
            margin-top: 10px;
            font-weight: bold;
        }
        input {
            width: 100%;
            padding: 7px;
            margin-top: 4px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }
        .btn-submit {
            margin-top: 15px;
            padding: 9px 25px;
            background-color: #2c3e50;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 15px;
        }
        .btn-submit:hover { background-color: #1a252f; }
        .message { color: green; margin-bottom: 10px; font-weight: bold; }
    </style>
</head>
<body>

<header>
    <img src="assets/logo_eneam.png" alt="ENEAM">
    <h1>Bienvenue sur ma plateforme</h1>
    <img src="assets/logo_uac.png" alt="UAC">
</header>

<div class="contenu">
    <h2>Liste des utilisateurs</h2>

    <?php if($message != "") echo "<p class='message'>$message</p>"; ?>

    <a href="#" class="btn btn-ajouter" onclick="document.getElementById('form-ajout').style.display='block'">
        + Ajouter un utilisateur
    </a>
    <a href="accueil.php" class="btn btn-quitter">Quitter</a>

    <table>
        <tr>
            <th>ID</th>
            <th>Nom</th>
            <th>Prénom</th>
            <th>Âge</th>
            <th>Adresse</th>
            <th>Ville</th>
            <th>Email</th>
            <th>Téléphone</th>
        </tr>
        <?php if(count($users) > 0): ?>
            <?php foreach($users as $user): ?>
            <tr>
                <td><?php echo $user['id']; ?></td>
                <td><?php echo htmlspecialchars($user['nom']); ?></td>
                <td><?php echo htmlspecialchars($user['prenom']); ?></td>
                <td><?php echo $user['age']; ?></td>
                <td><?php echo htmlspecialchars($user['adresse']); ?></td>
                <td><?php echo htmlspecialchars($user['ville']); ?></td>
                <td><?php echo htmlspecialchars($user['email']); ?></td>
                <td><?php echo htmlspecialchars($user['telephone']); ?></td>
            </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="8" style="text-align:center;">Aucun utilisateur enregistré</td>
            </tr>
        <?php endif; ?>
    </table>

    <!-- Formulaire ajout utilisateur -->
    <div class="formulaire" id="form-ajout">
        <h3>Ajouter un utilisateur</h3>
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

            <button type="submit" class="btn-submit">Enregistrer</button>
        </form>
    </div>
</div>

</body>
</html>