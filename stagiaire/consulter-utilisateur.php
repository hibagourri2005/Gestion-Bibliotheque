<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consulter un Utilisateur</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-image: url('../assets/img/back3.jpg');
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
        input[type="text"] {
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
            margin-top: 10px;
        }
        input[type="submit"]:hover {
            background-color: #45a049;
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
        <h1>Consulter Utilisateur</h1>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
            <label for="id_utilisateur">ID Utilisateur:</label>
            <input type="text" id="id_utilisateur" name="id_utilisateur" required>
            <input type="submit" value="Consulter">
        </form>
        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
         $servername = "localhost";
                $username = "root";
                $password = "";
                $dbname = "bibliotheque";
            // Create connection
            $conn = new mysqli($servername, $username, $password, $dbname);

            // Check connection
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            $id_utilisateur = $_POST["id_utilisateur"];
            $sql = "SELECT * FROM utilisateur WHERE id_utilisateur='$id_utilisateur'";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo "<h2>Informations de l'Utilisateur</h2>";
                    echo "ID: " . $row["id_utilisateur"]. "<br>";
                    echo "Nom: " . $row["nom"]. "<br>";
                    echo "Prénom: " . $row["prenom"]. "<br>";
                    echo "Téléphone: " . $row["telephone"]. "<br>";
                    echo "Type d'utilisateur: " . $row["type_utilisateur"]. "<br>";
                    echo "Statut: " . $row["statut"]. "<br>";
                    echo "Date d'inscription: " . $row["date_inscription"]. "<br>";
                    echo "Mot de passe: " . $row["mot de passe"]. "<br>";
                }
            } else {
                echo "Aucun utilisateur trouvé avec cet ID.";
            }

            $conn->close();
        }
        ?>
         <button class="green-button" onclick="window.location.href='index.html'">Retourner</button>
    </div>
</body>
</html>
