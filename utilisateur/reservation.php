<!DOCTYPE html>
<html>
<head>
    <title>Formulaire de Réservation</title>
    <style>
        body {
            background-image: url('../assets/img/back3.jpg'); /* Remplacez par l'URL de votre image de fond */
            background-size: cover;
            background-attachment: fixed;
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh; /* Hauteur de la fenêtre */
        }
        .form-container {
            background-color: rgba(255, 255, 255, 0.85); /* Fond semi-transparent */
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.3);
            text-align: center;
            width: 400px; /* Largeur fixe pour le formulaire */
            backdrop-filter: blur(10px); /* Ajoute un effet de flou derrière le formulaire */
        }
        .form-container h2 {
            color: brown;
            margin-bottom: 20px;
        }
        .form-container label {
            display: block;
            margin-top: 15px;
            color: brown;
            font-weight: bold;
        }
        .form-container input[type="text"], .form-container input[type="password"] {
            width: calc(100% - 20px);
            padding: 10px;
            margin-top: 5px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }
        .form-container button {
            padding: 10px 20px;
            background-color: green;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 20px;
            width: 100%;
            font-size: 16px;
        }
        .form-container button:hover {
            background-color: darkgreen;
        }
        .message {
            color: brown;
            font-weight: bold;
            text-align: center;
            margin-top: 20px;
        }
    </style>
</head>
<body>

<div class="form-container">
    <h2>Formulaire de Réservation</h2>
    <form method="POST" action="">
        <label for="nom">Nom :</label>
        <input type="text" id="nom" name="nom" required>
        
        <label for="prenom">Prénom :</label>
        <input type="text" id="prenom" name="prenom" required>
        
        <label for="password">Mot de passe :</label>
        <input type="password" id="password" name="password" required>
        
        <label for="id_exemplaire">ID de l'exemplaire :</label>
        <input type="text" id="id_exemplaire" name="id_exemplaire" required>
        
        <button type="submit">Réserver</button>
        <button onclick="window.location.href='../index.html'">Se deconnecter</button>
        <button onclick="window.location.href='consulter-exemplaire.php'">retourner</button>


    </form>
</div>

<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "bibliotheque";

    // Créer une connexion
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Vérifier la connexion
    if ($conn->connect_error) {
        die("Connexion échouée : " . $conn->connect_error);
    }

    $nom = $conn->real_escape_string($_POST['nom']);
    $prenom = $conn->real_escape_string($_POST['prenom']);
    $user_password = $conn->real_escape_string($_POST['password']);
    $id_exemplaire = $conn->real_escape_string($_POST['id_exemplaire']);

    // Vérifier le statut de l'exemplaire
    $sql = "SELECT statut FROM exemplaire WHERE id_exemplaire = '$id_exemplaire'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if ($row['statut'] == 'en_pret') {
            // Insérer la réservation dans la table
            $sql = "INSERT INTO reservation (id_exemplaire, id_utilisateur, date_reservation)
                    SELECT '$id_exemplaire', id_utilisateur, CURDATE()
                    FROM utilisateur
                    WHERE nom = '$nom' AND prenom = '$prenom' AND `mot de passe` = '$user_password'";
            if ($conn->query($sql) === TRUE) {
                echo "<p class='message'>Réservation effectuée avec succès !</p>";
            } else {
                echo "<p class='message'>Erreur : " . $sql . "<br>" . $conn->error . "</p>";
            }
        } else {
            echo "<p class='message'>L'exemplaire n'est pas disponible pour la réservation.</p>";
        }
    } else {
        echo "<p class='message'>Exemplaire introuvable.</p>";
    }

    $conn->close();
}
?>

</body>
</html>
