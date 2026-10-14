<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notifier un Emprunt</title>
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
            background-color: white;
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
        input[type="text"], input[type="date"] {
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        input[type="submit"] {
            padding: 10px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #45a049;
        }
        .message {
            color: green;
            text-align: center;
            margin-top: 10px;
        }

         .green-button {
            padding: 10px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 10px;
        }
        .green-button:hover {
            background-color: #45a049; /* Vert foncé */
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Notifier un Emprunt</h1>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
            <label for="id_emprunt">ID Emprunt:</label>
            <input type="text" id="id_emprunt" name="id_emprunt" required>
            <label for="email_utilisateur">Email Utilisateur:</label>
            <input type="text" id="email_utilisateur" name="email_utilisateur" required>
            <label for="titre_document">Titre du Document:</label>
            <input type="text" id="titre_document" name="titre_document" required>
            <input type="submit" value="Notifier">
        </form>
        <?php
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "bibliotheque";
        $message = "";

        // Create connection
        $conn = new mysqli($servername, $username, $password, $dbname);

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $id_emprunt = $_POST["id_emprunt"];
            $email_utilisateur = $_POST["email_utilisateur"];
            $titre_document = $_POST["titre_document"];

            // Send email notification
            $to = $email_utilisateur;
            $subject = "Notification d'Emprunt";
            $message = "Bonjour,

Vous avez emprunté le document suivant :
Titre : $titre_document
ID Emprunt : $id_emprunt

Merci de retourner le document à temps pour éviter des amendes.

Cordialement,
Votre Bibliothèque";
            $headers = "bella7bella2@gmail.com";
            echo "<div class='message'>Notification envoyée avec succès.</div>";

            
        }

        $conn->close();
        ?>
                <button class="green-button" onclick="window.location.href='../index.html'">Retourner</button>

    </div>
</body>
</html>
