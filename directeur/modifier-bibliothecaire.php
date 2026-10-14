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
            color: black ;
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

            // Modifier un bibliothécaire
            if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action']) && $_POST['action'] == 'modifier_bibliothecaire') {
                $id_bibliothecaire = $_POST['id_bibliothecaire_modif'];
                $new_nom_prenom = $_POST['new_nom_prenom'];
                $new_email = $_POST['new_email'];
                $new_telephone = $_POST['new_telephone'];
                $new_categorie = $_POST['new_categorie'];
                $new_date_debut = $_POST['new_date_debut'];
                $new_date_fin = $_POST['new_date_fin'];
                $new_mot_de_passe = $_POST['new_mot_de_passe'];

                $stmt = $pdo->prepare("UPDATE bibliothecaire SET nom_prenom = ?, email = ?, telephone = ?, categorie = ?, date_debut = ?, date_fin = ?, mot_de_passe = ? WHERE id_bibliothecaire = ?");
                $stmt->execute([$new_nom_prenom, $new_email, $new_telephone, $new_categorie, $new_date_debut, $new_date_fin, $new_mot_de_passe, $id_bibliothecaire]);

                echo "<div class='success'>Bibliothécaire modifié avec succès.</div>";
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

        <!-- Formulaire pour modifier un bibliothécaire -->
        <h2>Modifier un bibliothécaire</h2>
        <form action="" method="POST">
            <label for="id_bibliothecaire_modif">Bibliothécaire :</label>
            <input type="number" name="id_bibliothecaire_modif" id="id_bibliothecaire_modif" required>

            <label for="new_nom_prenom">Nom et Prénom :</label>
            <input type="text" name="new_nom_prenom" id="new_nom_prenom">

            <label for="new_email">Email :</label>
            <input type="email" name="new_email" id="new_email">

            <label for="new_telephone">Téléphone :</label>
            <input type="tel" name="new_telephone" id="new_telephone">

            <label for="new_categorie">Catégorie :</label>
            <select name="new_categorie" id="new_categorie">
                <option value="stagiaire">Stagiaire</option>
                <option value="principal">Principal</option>
            </select>

            <label for="new_date_debut">Date de début :</label>
            <input type="date" name="new_date_debut" id="new_date_debut">

            <label for="new_date_fin">Date de fin :</label>
            <input type="date" name="new_date_fin" id="new_date_fin">

            <label for="new_mot_de_passe">Nouveau Mot de Passe :</label>
            <input type="password" name="new_mot_de_passe" id="new_mot_de_passe">

            <button type="submit" name="action" value="modifier_bibliothecaire">Modifier le bibliothécaire</button>
            <button onclick="window.location.href='../index.html'">Se deconnecter</button>
        </form>
    </div>
</body>
</html>
