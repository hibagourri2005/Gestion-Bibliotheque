<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier un Utilisateur</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-image: url('../../assets/img/back3.jpg');
            background-size: cover;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .container {
            background-color: rgba(255, 255, 255, 0.8);
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }
        h1 {
            text-align: center;
        }
        form {
            display: flex;
            flex-direction: column;
        }
        label {
            margin: 5px 0;
        }
        input[type="text"],
        input[type="date"],
        input[type="password"],
        select {
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        input[type="submit"], button {
            padding: 10px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 10px;
        }
        input[type="submit"]:hover, button:hover {
            background-color: #45a049;
        }
        button {
            text-align: center;
        }
        .message {
            color: green;
            text-align: center;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Rechercher ou Modifier Utilisateur</h1>
        <?php
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "bibliotheque";
        $message = "";
        $user = ["id_utilisateur" => "", "nom" => "", "prenom" => "", "email" => "", "type_utilisateur" => "", "statut" => "", "date_inscription" => "", "mot de passe" => ""]; // Initialisation

        // Create connection
        $conn = new mysqli($servername, $username, $password, $dbname);

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if (isset($_POST["rechercher"])) {
                $id_utilisateur = $_POST["id_utilisateur"];
                $sql = "SELECT * FROM utilisateur WHERE id_utilisateur='$id_utilisateur'";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    $user = $result->fetch_assoc();
                } else {
                    $message = "Utilisateur non trouvé";
                }
            } elseif (isset($_POST["modifier"])) {
                $id_utilisateur = $_POST["id_utilisateur"];
                $nom = $_POST["nom"];
                $prenom = $_POST["prenom"];
                $email = $_POST["email"];
                $type_utilisateur = $_POST["type_utilisateur"];
                $statut = $_POST["statut"];
                $date_inscription = $_POST["date_inscription"];
                $mot_de_passe = $_POST["mot_de_passe"];

                $sql = "UPDATE utilisateur SET nom='$nom', prenom='$prenom', email='$email', type_utilisateur='$type_utilisateur', statut='$statut', date_inscription='$date_inscription', `mot de passe`='$mot_de_passe' WHERE id_utilisateur='$id_utilisateur'";

                if ($conn->query($sql) === TRUE) {
                    $message = "Utilisateur modifié avec succès";
                } else {
                    $message = "Erreur de modification: " . $conn->error;
                }
            }
        }

        $conn->close();
        ?>

        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
            <label for="id_utilisateur">ID Utilisateur:</label>
            <input type="text" id="id_utilisateur" name="id_utilisateur" value="<?php echo htmlspecialchars($user['id_utilisateur']); ?>" required>
            <input type="submit" name="rechercher" value="Rechercher">
        </form>

        <?php if (!empty($user['id_utilisateur'])): ?>
            <h2>Modifier les informations de l'utilisateur</h2>
            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                <input type="hidden" name="id_utilisateur" value="<?php echo htmlspecialchars($user['id_utilisateur']); ?>">
                <label for="nom">Nom:</label>
                <input type="text" id="nom" name="nom" value="<?php echo htmlspecialchars($user['nom']); ?>" required>
                <label for="prenom">Prénom:</label>
                <input type="text" id="prenom" name="prenom" value="<?php echo htmlspecialchars($user['prenom']); ?>" required>
                <label for="email">Email:</label>
                <input type="text" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>">
                <label for="type_utilisateur">Type d'utilisateur:</label>
                <select id="type_utilisateur" name="type_utilisateur" required>
                    <option value="occasionnel" <?php if($user['type_utilisateur']=='occasionnel') echo 'selected'; ?>>Occasionnel</option>
                    <option value="abonné" <?php if($user['type_utilisateur']=='abonné') echo 'selected'; ?>>Abonné</option>
                    <option value="abonné_privilégié" <?php if($user['type_utilisateur']=='abonné_privilégié') echo 'selected'; ?>>Abonné Privilégié</option>
                </select>
                <label for="statut">Statut:</label>
                <select id="statut" name="statut" required>
                    <option value="actif" <?php if($user['statut']=='actif') echo 'selected'; ?>>Actif</option>
                    <option value="suspendu" <?php if($user['statut']=='suspendu') echo 'selected'; ?>>Suspendu</option>
                </select>
                <label for="date_inscription">Date d'inscription:</label>
                <input type="date" id="date_inscription" name="date_inscription" value="<?php echo htmlspecialchars($user['date_inscription']); ?>" required>
                <label for="mot_de_passe">Mot de passe:</label>
                <input type="password" id="mot_de_passe" name="mot_de_passe" value="<?php echo htmlspecialchars($user['mot de passe']); ?>" required>
                <input type="submit" name="modifier" value="Modifier">
            </form>
        <?php endif; ?>
        <button onclick="window.location.href='index.html'">Retourner</button>
        <?php if ($message): ?>
            <div class="message"><?php echo htmlspecialchars($message); ?></div>
        <?php endif; ?>
      
    </div>
</body>
</html>