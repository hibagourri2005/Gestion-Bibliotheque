<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier un Emprunt</title>
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
        input[type="text"],
        input[type="date"],
        select {
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
        <h1>Modifier un Emprunt</h1>
        <?php
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

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $id_emprunt = $_POST["id_emprunt"];
            $date_fin = $_POST["date_fin"];
            $statut = $_POST["statut"];

            $sql = "UPDATE emprunt SET date_fin='$date_fin', statut='$statut' WHERE id_emprunt='$id_emprunt'";

            if ($conn->query($sql) === TRUE) {
                echo "Emprunt modifié avec succès";
            } else {
                echo "Erreur de modification: " . $conn->error;
            }
        }

        // Check if id_emprunt is set in the GET request
        if (isset($_GET["id_emprunt"])) {
            $id_emprunt = $_GET["id_emprunt"];
            $sql = "SELECT * FROM emprunt WHERE id_emprunt='$id_emprunt'";
            $result = $conn->query($sql);
            $emprunt = $result->fetch_assoc();
        } else {
            $emprunt = ["id_emprunt" => "", "date_fin" => "", "statut" => ""]; // Default values to avoid warnings
        }

        $conn->close();
        ?>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
            <input type="hidden" name="id_emprunt" value="<?php echo htmlspecialchars($emprunt['id_emprunt']); ?>">
            <label for="date_fin">Nouvelle Date de Fin:</label>
            <input type="date" id="date_fin" name="date_fin" value="<?php echo htmlspecialchars($emprunt['date_fin']); ?>" required>
            <label for="statut">Statut:</label>
            <select id="statut" name="statut" required>
                <option value="en cours" <?php if($emprunt['statut']=='en cours') echo 'selected'; ?>>En cours</option>
                <option value="en retard" <?php if($emprunt['statut']=='en retard') echo 'selected'; ?>>En retard</option>
                <option value="prolongé" <?php if($emprunt['statut']=='prolongé') echo 'selected'; ?>>Prolongé</option>
                  <option value="prolongé" <?php if($emprunt['statut']=='retourne') echo 'selected'; ?>>retourne</option>
            </select>
            <input type="submit" value="Modifier">
        </form>
        <button class="green-button" onclick="window.location.href='index.html'">Retourner</button>
    </div>
</body>
</html>
