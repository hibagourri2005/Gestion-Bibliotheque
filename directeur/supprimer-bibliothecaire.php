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
            color: black;
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
        <?php
        // Connexion à la base de données
        $dsn = 'mysql:host=localhost;dbname=bibliotheque';
        $username = 'root';
        $password = '';

        try {
             

       
            $pdo = new PDO($dsn, $username, $password);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            // Supprimer un bibliothécaire
            if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action']) && $_POST['action'] == 'supprimer_bibliothecaire') {
                $id_bibliothecaire = $_POST['id_bibliothecaire_supp'];

                $stmt = $pdo->prepare("DELETE FROM bibliothecaire WHERE id_bibliothecaire = ?");
                $stmt->execute([$id_bibliothecaire]);

                echo "<div class='success'>Bibliothécaire supprimé avec succès.</div>";
            }

            // Lister les bibliothécaires
            $stmt = $pdo->query("SELECT * FROM bibliothecaire");

            echo "<h2>Liste des bibliothécaires</h2>";
            echo "<table><tr><th>ID Bibliothécaire</th><th>Nom et Prénom</th><th>Email</th><th>Téléphone</th><th>Catégorie</th><th>Date de début</th><th>Date de fin</th></tr>";

            while ($bibliothecaire = $stmt->fetch(PDO::FETCH_ASSOC)) {
                echo "<tr>
                        <td>" . htmlspecialchars($bibliothecaire['id_bibliothecaire'] ?? '') . "</td>
                        <td>" . htmlspecialchars($bibliothecaire['nom_prenom'] ?? '') . "</td>
                        <td>" . htmlspecialchars($bibliothecaire['email'] ?? '') . "</td>
                        <td>" . htmlspecialchars($bibliothecaire['telephone'] ?? '') . "</td>
                        <td>" . htmlspecialchars($bibliothecaire['categorie'] ?? '') . "</td>
                        <td>" . htmlspecialchars($bibliothecaire['date_debut'] ?? '') . "</td>
                        <td>" . htmlspecialchars($bibliothecaire['date_fin'] ?? '') . "</td>
                      </tr>";
            }

            echo "</table>";

        } catch (PDOException $e) {
            echo "<div class='notification'>Erreur de connexion : " . htmlspecialchars($e->getMessage()) . "</div>";
        }
        ?>

        <!-- Formulaire pour supprimer un bibliothécaire -->
        <h2>Supprimer un bibliothécaire</h2>
        <form action="" method="POST">
            <label for="id_bibliothecaire_supp">ID Bibliothécaire :</label>
            <input type="number" name="id_bibliothecaire_supp" id="id_bibliothecaire_supp" required>

            <button type="submit" name="action" value="supprimer_bibliothecaire">Supprimer le bibliothécaire</button>
            <button onclick="window.location.href='../index.html'">Se déconnecter</button>
        </form>
    </div>
</body>
</html>
