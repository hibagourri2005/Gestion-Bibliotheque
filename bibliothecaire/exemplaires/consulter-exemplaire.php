<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consulter un Exemplaire</title>
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
        <h1>Consulter un Exemplaire</h1>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <label for="id_exemplaire">ID Exemplaire:</label>
            <input type="text" id="id_exemplaire" name="id_exemplaire" required>
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

            $id_exemplaire = $conn->real_escape_string($_POST["id_exemplaire"]);
            $sql = "
                SELECT ex.*, d.titre AS document_titre
                FROM exemplaire ex
                JOIN document d ON ex.id_document = d.id_document
                WHERE ex.id_exemplaire = '$id_exemplaire'
            ";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo "<h2>Informations de l'Exemplaire</h2>";
                    echo "ID: " . $row["id_exemplaire"]. "<br>";
                    echo "Numéro d'ordre: " . $row["numero_ordre"]. "<br>";
                    echo "Date d'achat: " . $row["date_achat"]. "<br>";
                    echo "État: " . $row["etat"]. "<br>";
                    echo "Statut: " . $row["statut"]. "<br>";
                    echo "Nom du Document: " . $row["document_titre"]. "<br>";
                }
            } else {
                echo "Aucun exemplaire trouvé avec cet ID.";
            }

            $conn->close();
        }
        ?>
        <button class="green-button" onclick="window.location.href='index.html'">Retourner</button>
    </div>
</body>
</html>
