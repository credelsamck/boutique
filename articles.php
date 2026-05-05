<?php
session_start();
if(!isset($_SESSION['user'])){
    header("Location: connexion.php");
    exit();
}
include 'config.php';

$message = "";

// Ajouter un article
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $nom = $_POST['nom'];
    $description = $_POST['description'];
    $prix = $_POST['prix'];
    $quantite_stock = $_POST['quantite_stock'];

    $sql = "INSERT INTO articles (nom, description, prix, quantite_stock) 
            VALUES (:nom, :description, :prix, :quantite_stock)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':nom' => $nom,
        ':description' => $description,
        ':prix' => $prix,
        ':quantite_stock' => $quantite_stock
    ]);
    $message = "Article ajouté avec succès !";
}

// Récupérer la liste des articles
$articles = $pdo->query("SELECT * FROM articles")->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Articles</title>
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
        input, textarea {
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
    <h2>Liste des articles</h2>

    <?php if($message != "") echo "<p class='message'>$message</p>"; ?>

    <a href="#" class="btn btn-ajouter" 
       onclick="document.getElementById('form-ajout').style.display='block'">
        + Ajouter un article
    </a>
    <a href="accueil.php" class="btn btn-quitter">Quitter</a>

    <table>
        <tr>
            <th>ID</th>
            <th>Nom</th>
            <th>Description</th>
            <th>Prix (FCFA)</th>
            <th>Stock</th>
        </tr>
        <?php if(count($articles) > 0): ?>
            <?php foreach($articles as $article): ?>
            <tr>
                <td><?php echo $article['id']; ?></td>
                <td><?php echo htmlspecialchars($article['nom']); ?></td>
                <td><?php echo htmlspecialchars($article['description']); ?></td>
                <td><?php echo number_format($article['prix'], 2); ?></td>
                <td><?php echo $article['quantite_stock']; ?></td>
            </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="5" style="text-align:center;">Aucun article enregistré</td>
            </tr>
        <?php endif; ?>
    </table>

    <!-- Formulaire ajout article -->
    <div class="formulaire" id="form-ajout">
        <h3>Ajouter un article</h3>
        <form method="POST">
            <label>Nom de l'article :</label>
            <input type="text" name="nom" required>

            <label>Description :</label>
            <textarea name="description" rows="3" required></textarea>

            <label>Prix (FCFA) :</label>
            <input type="number" name="prix" step="0.01" required>

            <label>Quantité en stock :</label>
            <input type="number" name="quantite_stock" required>

            <button type="submit" class="btn-submit">Enregistrer</button>
        </form>
    </div>
</div>

</body>
</html>