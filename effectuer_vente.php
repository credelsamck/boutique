<?php
session_start();
if(!isset($_SESSION['user'])){
    header("Location: connexion.php");
    exit();
}
include 'config.php';

$message = "";

// Récupérer les clients et articles pour les listes déroulantes
$clients = $pdo->query("SELECT * FROM clients")->fetchAll(PDO::FETCH_ASSOC);
$articles = $pdo->query("SELECT * FROM articles")->fetchAll(PDO::FETCH_ASSOC);

// Traitement du formulaire
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $id_client = $_POST['id_client'];
    $montant_total = 0;

    // Calculer le montant total
    foreach($_POST['articles'] as $id_article => $quantite){
        if($quantite > 0){
            $sql = "SELECT prix FROM articles WHERE id = :id";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([':id' => $id_article]);
            $article = $stmt->fetch(PDO::FETCH_ASSOC);
            $montant_total += $article['prix'] * $quantite;
        }
    }

    // Insérer la vente
    $sql = "INSERT INTO ventes (id_client, date_vente, montant_total) 
            VALUES (:id_client, NOW(), :montant_total)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':id_client' => $id_client,
        ':montant_total' => $montant_total
    ]);
    $id_vente = $pdo->lastInsertId();

    // Insérer dans la table contenir
    foreach($_POST['articles'] as $id_article => $quantite){
        if($quantite > 0){
            $sql = "SELECT prix FROM articles WHERE id = :id";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([':id' => $id_article]);
            $article = $stmt->fetch(PDO::FETCH_ASSOC);

            $sql2 = "INSERT INTO contenir (id_vente, id_article, quantite, prix_unitaire) 
                     VALUES (:id_vente, :id_article, :quantite, :prix_unitaire)";
            $stmt2 = $pdo->prepare($sql2);
            $stmt2->execute([
                ':id_vente' => $id_vente,
                ':id_article' => $id_article,
                ':quantite' => $quantite,
                ':prix_unitaire' => $article['prix']
            ]);

            // Mettre à jour le stock
            $sql3 = "UPDATE articles SET quantite_stock = quantite_stock - :quantite 
                     WHERE id = :id";
            $stmt3 = $pdo->prepare($sql3);
            $stmt3->execute([
                ':quantite' => $quantite,
                ':id' => $id_article
            ]);
        }
    }

    $message = "Vente effectuée avec succès ! Montant total : " . number_format($montant_total, 2) . " FCFA";
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Effectuer une vente</title>
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
            max-width: 700px;
            margin: 30px auto;
            background: white;
            padding: 25px;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }
        h2 { color: #2c3e50; margin-bottom: 15px; }

        label {
            display: block;
            margin-top: 15px;
            font-weight: bold;
        }
        select {
            width: 100%;
            padding: 8px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
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
        input[type="number"] {
            width: 80px;
            padding: 5px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

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
        .btn-submit {
            margin-top: 20px;
            padding: 10px 30px;
            background-color: #27ae60;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }
        .btn-submit:hover { background-color: #1e8449; }
        .btn-quitter { background-color: #e74c3c; color: white; }
        .btn-quitter:hover { background-color: #c0392b; }

        .message { 
            color: green; 
            margin-bottom: 15px; 
            font-weight: bold;
            padding: 10px;
            background: #eaffea;
            border-radius: 4px;
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
    <h2>Effectuer une vente</h2>

    <?php if($message != "") echo "<p class='message'>$message</p>"; ?>

    <form method="POST">

        <!-- Sélection du client -->
        <label>Nom du client :</label>
        <select name="id_client" required>
            <option value="">-- Choisir un client --</option>
            <?php foreach($clients as $client): ?>
                <option value="<?php echo $client['id']; ?>">
                    <?php echo htmlspecialchars($client['prenom'].' '.$client['nom']); ?>
                </option>
            <?php endforeach; ?>
        </select>

        <!-- Tableau des articles -->
        <label>Articles commandés :</label>
        <table>
            <tr>
                <th>Article</th>
                <th>Prix unitaire (FCFA)</th>
                <th>Stock disponible</th>
                <th>Quantité</th>
            </tr>
            <?php foreach($articles as $article): ?>
            <tr>
                <td><?php echo htmlspecialchars($article['nom']); ?></td>
                <td><?php echo number_format($article['prix'], 2); ?></td>
                <td><?php echo $article['quantite_stock']; ?></td>
                <td>
                    <input type="number" 
                           name="articles[<?php echo $article['id']; ?>]" 
                           min="0" 
                           max="<?php echo $article['quantite_stock']; ?>"
                           value="0">
                </td>
            </tr>
            <?php endforeach; ?>
        </table>

        <button type="submit" class="btn-submit"> Valider la vente</button>
    </form>

    <br>
    <a href="accueil.php" class="btn btn-quitter">Quitter</a>
</div>

</body>
</html>