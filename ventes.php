<?php
session_start();
if(!isset($_SESSION['user'])){
    header("Location: connexion.php");
    exit();
}
include 'config.php';

// Récupérer la liste des ventes avec le nom du client
$ventes = $pdo->query("
    SELECT v.id, c.nom, c.prenom, v.date_vente, v.montant_total 
    FROM ventes v 
    JOIN clients c ON v.id_client = c.id
")->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ventes</title>
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
        .btn-vente { background-color: #27ae60; color: white; }
        .btn-vente:hover { background-color: #1e8449; }
        .btn-quitter { background-color: #e74c3c; color: white; }
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
    <h2>Liste des ventes</h2>

    <a href="effectuer_vente.php" class="btn btn-vente">
        🛒 Effectuer une vente
    </a>
    <a href="accueil.php" class="btn btn-quitter">Quitter</a>

    <table>
        <tr>
            <th>ID Vente</th>
            <th>Client</th>
            <th>Date</th>
            <th>Montant total (FCFA)</th>
        </tr>
        <?php if(count($ventes) > 0): ?>
            <?php foreach($ventes as $vente): ?>
            <tr>
                <td><?php echo $vente['id']; ?></td>
                <td><?php echo htmlspecialchars($vente['prenom'].' '.$vente['nom']); ?></td>
                <td><?php echo $vente['date_vente']; ?></td>
                <td><?php echo number_format($vente['montant_total'], 2); ?></td>
            </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="4" style="text-align:center;">Aucune vente enregistrée</td>
            </tr>
        <?php endif; ?>
    </table>
</div>

</body>
</html>