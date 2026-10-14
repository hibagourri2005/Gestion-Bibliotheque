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
        <!-- Ajouter un bibliothécaire -->
        <h2>Ajouter un bibliothécaire</h2>
        <form action="" method="POST">
            <label for="nom_prenom">Nom et Prénom :</label>
            <input type="text" name="nom_prenom" id="nom_prenom" required>

            <label for="email">Email :</label>
            <input type="email" name="email" id="email" required>

            <label for="telephone">Téléphone :</label>
            <input type="tel" name="telephone" id="telephone" required>

            <label for="categorie">Catégorie :</label>
            <select name="categorie" id="categorie" required>
                <option value="stagiaire">Stagiaire</option>
                <option value="principal">Principal</option>
            </select>

            <label for="date_debut">Date de début :</label>
            <input type="date" name="date_debut" id="date_debut" required>

            <label for="date_fin">Date de fin :</label>
            <input type="date" name="date_fin" id="date_fin">

            <label for="mot_de_passe">Mot de Passe :</label>
            <input type="password" name="mot_de_passe" id="mot_de_passe" required>

            <button type="submit" name="action" value="ajouter_bibliothecaire">Ajouter le bibliothécaire</button>
        </form>

        <?php
        // Connexion à la base de données
        $dsn = 'mysql:host=localhost;dbname=bibliotheque';
        $username = 'root';
        $password = '';

        try {
            $pdo = new PDO($dsn, $username, $password);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Ajouter un bibliothécaire
            if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action']) && $_POST['action'] == 'ajouter_bibliothecaire') {
                $nom_prenom = $_POST['nom_prenom'];
                $email = $_POST['email'];
                $telephone = $_POST['telephone'];
                $categorie = $_POST['categorie'];
                $date_debut = $_POST['date_debut'];
                $date_fin = $_POST['date_fin'];
                $mot_de_passe = $_POST['mot_de_passe'];

                $stmt = $pdo->prepare("INSERT INTO bibliothecaire (nom_prenom, email, telephone, categorie, date_debut, date_fin, password) VALUES (?, ?, ?, ?, ?, ?, ?)");
                $stmt->execute([$nom_prenom, $email, $telephone, $categorie, $date_debut, $date_fin, $mot_de_passe]);

                echo "<div class='success'>Bibliothécaire ajouté avec succès.</div>";
            }

        } catch (PDOException $e) {
            echo "<div class='notification'>Erreur de connexion : " . htmlspecialchars($e->getMessage()) . "</div>";
        }
        ?>
    </div>
</body>
</html>
