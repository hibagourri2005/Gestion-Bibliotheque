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
        button {
    padding: 10px;
    background-color: #28a745; /* Vert */
    color: #fff;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    font-size: 16px;
}

button:hover {
    background-color: #218838; /* Vert foncé au survol */
}
    </style>
</head>
<body>
    <header>
        <h1>Gestion des Bibliothécaires</h1>
    </header>

    <div class="container">
        <h2>Liste des bibliothécaires</h2>
        <div id="bibliothecaires-container">
            <!-- Les lignes seront générées dynamiquement ici -->
            <?php
            try {
                // Connexion à la base de données
                $pdo = new PDO('mysql:host=localhost;dbname=bibliotheque', 'root', '');
                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                // Lister les bibliothécaires
                $stmt = $pdo->query("SELECT * FROM bibliothecaire");

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
             <button onclick="window.location.href='../index.html'">Se deconnecter</button>
        </div>
    </div>
</body>
</html>
