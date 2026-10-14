<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier un Document</title>
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
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Modifier un Document</h1>
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

        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["id_document"])) {
            $id_document = $conn->real_escape_string($_POST["id_document"]);
            $sql = "SELECT * FROM document WHERE id_document='$id_document'";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                $document = $result->fetch_assoc();
            } else {
                echo "Document non trouvé.";
                $conn->close();
                exit();
            }
        }

        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["update"])) {
            $id_document = $conn->real_escape_string($_POST["id_document"]);
            $titre = $conn->real_escape_string($_POST["titre"]);
            $annee_publication = $conn->real_escape_string($_POST["annee_publication"]);
            $type_document = $conn->real_escape_string($_POST["type_document"]);
            $reference = $conn->real_escape_string($_POST["reference"]);
            $id_editeur = $conn->real_escape_string($_POST["id_editeur"]);

            $sql = "UPDATE document SET titre='$titre', annee_publication='$annee_publication', type_document='$type_document', reference='$reference', id_editeur='$id_editeur' WHERE id_document='$id_document'";

            if ($conn->query($sql) === TRUE) {
                echo "Document modifié avec succès";
            } else {
                echo "Erreur de modification: " . $conn->error;
            }

            $conn->close();
        }
        ?>
        <?php if (!isset($_POST["id_document"]) || !isset($document)): ?>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <label for="id_document">ID Document:</label>
            <input type="text" id="id_document" name="id_document" required>
            <input type="submit" value="Consulter">
        </form>
        <?php else: ?>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <input type="hidden" name="id_document" value="<?php echo $document['id_document']; ?>">
            <input type="hidden" name="update" value="1">
            <label for="titre">Titre:</label>
            <input type="text" id="titre" name="titre" value="<?php echo $document['titre']; ?>" required>
            <label for="annee_publication">Année de Publication:</label>
            <input type="text" id="annee_publication" name="annee_publication" value="<?php echo $document['annee_publication']; ?>" required>
            <label for="type_document">Type de Document:</label>
            <select id="type_document" name="type_document" required>
                <option value="livre" <?php if($document['type_document']=='livre') echo 'selected'; ?>>Livre</option>
                <option value="periodique" <?php if($document['type_document']=='periodique') echo 'selected'; ?>>Périodique</option>
            </select>
            <label for="reference">Référence:</label>
            <input type="text" id="reference" name="reference" value="<?php echo $document['reference']; ?>">
            <label for="id_editeur">ID Éditeur:</label>
            <input type="text" id="id_editeur" name="id_editeur" value="<?php echo $document['id_editeur']; ?>">
            <input type="submit" value="Modifier">
        </form>
        <?php endif; ?>
        <button class="green-button" onclick="window.location.href='index.html'">Retourner</button>
    </div>
</body>
</html>
