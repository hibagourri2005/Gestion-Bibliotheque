<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consulter un Document</title>
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
        <h1>Consulter Document</h1>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <label for="id_document">ID Document:</label>
            <input type="text" id="id_document" name="id_document" required>
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

            $id_document = $conn->real_escape_string($_POST["id_document"]);
            $sql = "SELECT document.*, editeur.nom AS nom_editeur, editeur.prenom AS prenom_editeur 
                    FROM document 
                    JOIN editeur ON document.id_editeur = editeur.id_editeur 
                    WHERE document.id_document = '$id_document'";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo "<h2>Informations du Document</h2>";
                    echo "ID: " . $row["id_document"]. "<br>";
                    echo "Titre: " . $row["titre"]. "<br>";
                    echo "Année de Publication: " . $row["annee_publication"]. "<br>";
                    echo "Type de Document: " . $row["type_document"]. "<br>";
                    echo "Référence: " . $row["reference"]. "<br>";
                    echo "Éditeur: " . $row["nom_editeur"] . " " . $row["prenom_editeur"] . "<br>";
                }
            } else {
                echo "Aucun document trouvé avec cet ID.";
            }

            $conn->close();
        }
        ?>
           <button class="green-button" onclick="window.location.href='index.html'">Retourner</button>
    </div>
</body>
</html>
