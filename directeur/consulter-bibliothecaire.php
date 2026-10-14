<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Bibliothécaires - Bibliothèque</title>
   <style>
       body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
          background-image: url('../assets/img/back3.jpg');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
        }

        /* En-tête */
        header {
            background-color: rgba(139, 69, 19, 0.8);
            color: #fff;
            padding: 10px;
            text-align: center;
        }

        header h1 {
            margin: 0;
        }

        /* Conteneur principal */
        .container {
            width: 80%;
            margin: 20px auto;
        }

        /* Formulaire */
        form {
            background-color: #fff;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        form input, form select, form button {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        form button {
            background-color: #4CAF50;
            color: white;
            cursor: pointer;
        }

        form button:hover {
            background-color: #45a049;
        }

        /* Table */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            padding: 12px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        tr:hover {
            background-color: #f1f1f1;
        }

        /* Message de notification */
        .notification {
            padding: 15px;
            margin-top: 20px;
            background-color: #f8d7da;
            border-radius: 4px;
            color: #721c24;
        }

        .success {
            background-color: #d4edda;
            color: #155724;
        } 
   </style>
</head>
<body>
    <header>
        <h1>Gestion des Bibliothécaires</h1>
    </header>

    <div class="container">
        <!-- Consulter un bibliothécaire -->
        <h2>Consulter un bibliothécaire</h2>
        <form action="" method="GET">
            <label for="id_bibliothecaire">Bibliothécaire :</label>
            <select name="id_bibliothecaire" id="id_bibliothecaire" required>
                <?php
                // Connexion à la base de données
                $pdo = new PDO('mysql:host=localhost;dbname=bibliotheque', 'root', '');
                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                // Récupérer les bibliothécaires pour les options du menu déroulant
                $stmt = $pdo->query("SELECT id_bibliothecaire, nom_prenom FROM bibliothecaire");
                while ($bibliothecaire = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    echo "<option value=\"" . htmlspecialchars($bibliothecaire['id_bibliothecaire']) . "\">" . htmlspecialchars($bibliothecaire['nom_prenom']) . "</option>";
                }
                ?>
            </select>
            <button type="submit" name="action" value="consulter_bibliothecaire">Consulter</button>
                         <button onclick="window.location.href='../index.html'">Se deconnecter</button>

        </form>

        <?php
        // Consulter un bibliothécaire
        if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['action']) && $_GET['action'] == 'consulter_bibliothecaire') {
            $id_bibliothecaire = $_GET['id_bibliothecaire'];

            $stmt = $pdo->prepare("SELECT * FROM bibliothecaire WHERE id_bibliothecaire = ?");
            $stmt->execute([$id_bibliothecaire]);
            $bibliothecaire = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($bibliothecaire) {
                echo "<h2>Détails du Bibliothécaire</h2>";
                echo "<table>
                        <tr><th>ID Bibliothécaire</th><td>" . htmlspecialchars($bibliothecaire['id_bibliothecaire'] ?? '') . "</td></tr>
                        <tr><th>Nom et Prénom</th><td>" . htmlspecialchars($bibliothecaire['nom_prenom'] ?? '') . "</td></tr>
                        <tr><th>Email</th><td>" . htmlspecialchars($bibliothecaire['email'] ?? '') . "</td></tr>
                        <tr><th>Téléphone</th><td>" . htmlspecialchars($bibliothecaire['telephone'] ?? '') . "</td></tr>
                        <tr><th>Catégorie</th><td>" . htmlspecialchars($bibliothecaire['categorie'] ?? '') . "</td></tr>
                        <tr><th>Date de Début</th><td>" . htmlspecialchars($bibliothecaire['date_debut'] ?? '') . "</td></tr>
                        <tr><th>Date de Fin</th><td>" . htmlspecialchars($bibliothecaire['date_fin'] ?? '') . "</td></tr>
                      </table>";
            } else {
                echo "<div class='notification'>Aucun bibliothécaire trouvé.</div>";
            }
        }
        ?>
    </div>
</body>
</html>
