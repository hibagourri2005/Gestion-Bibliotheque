<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter un Document</title>
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
        <h1>Ajouter un Document</h1>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
            <label for="titre">Titre:</label>
            <input type="text" id="titre" name="titre" required>
            <label for="annee_publication">Année de Publication:</label>
            <input type="text" id="annee_publication" name="annee_publication" required>
            <label for="type_document">Type de Document:</label>
            <select id="type_document" name="type_document" required>
                <option value="livre">Livre</option>
                <option value="periodique">Périodique</option>
            </select>
            <label for="reference">Référence:</label>
            <input type="text" id="reference" name="reference">
            <label for="id_editeur">ID Éditeur:</label>
            <input type="text" id="id_editeur" name="id_editeur">
            <input type="submit" value="Ajouter">
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

            $titre = $_POST["titre"];
            $annee_publication = $_POST["annee_publication"];
            $type_document = $_POST["type_document"];
            $reference = $_POST["reference"];
            $id_editeur = $_POST["id_editeur"];

            $sql = "INSERT INTO document (titre, annee_publication, type_document, reference, id_editeur) VALUES ('$titre', '$annee_publication', '$type_document', '$reference', '$id_editeur')";

            if ($conn->query($sql) === TRUE) {
                echo "Document ajouté avec succès";
            } else {
                echo "Erreur d'ajout: " . $conn->error;
            }

            $conn->close();
        }
        ?>
        <button class="green-button" onclick="window.location.href='index.html'">Retourner</button>
    </div>
</body>
</html>
