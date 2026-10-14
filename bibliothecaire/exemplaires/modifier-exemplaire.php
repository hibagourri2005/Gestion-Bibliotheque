<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier un Exemplaire</title>
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
        <h1>Modifier un Exemplaire</h1>
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
            $id_exemplaire = $_POST["id_exemplaire"];
            $numero_ordre = $_POST["numero_ordre"];
            $date_achat = $_POST["date_achat"];
            $etat = $_POST["etat"];
            $statut = $_POST["statut"];
            $id_document = $_POST["id_document"];

            $sql = "UPDATE exemplaire SET numero_ordre='$numero_ordre', date_achat='$date_achat', etat='$etat', statut='$statut', id_document='$id_document' WHERE id_exemplaire='$id_exemplaire'";

            if ($conn->query($sql) === TRUE) {
                echo "Exemplaire modifié avec succès";
            } else {
                echo "Erreur de modification: " . $conn->error;
            }
        }

        // Check if id is set in the GET request
        if (isset($_GET["id"])) {
            $id_exemplaire = $_GET["id"];
            $sql = "SELECT * FROM exemplaire WHERE id_exemplaire='$id_exemplaire'";
            $result = $conn->query($sql);
            $exemplaire = $result->fetch_assoc();
        } else {
            $exemplaire = ["id_exemplaire" => "", "numero_ordre" => "", "date_achat" => "", "etat" => "", "statut" => "", "id_document" => ""]; // Default values to avoid warnings
        }

        $conn->close();
        ?>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
            <input type="hidden" name="id_exemplaire" value="<?php echo htmlspecialchars($exemplaire['id_exemplaire']); ?>">
            <label for="numero_ordre">Numéro d'ordre:</label>
            <input type="text" id="numero_ordre" name="numero_ordre" value="<?php echo htmlspecialchars($exemplaire['numero_ordre']); ?>" required><br><br>
            <label for="date_achat">Date d'achat:</label>
            <input type="date" id="date_achat" name="date_achat" value="<?php echo htmlspecialchars($exemplaire['date_achat']); ?>" required><br><br>
            <label for="etat">État:</label>
            <select id="etat" name="etat" required>
                <option value="neuf" <?php if($exemplaire['etat']=='neuf') echo 'selected'; ?>>Neuf</option>
                <option value="bon" <?php if($exemplaire['etat']=='bon') echo 'selected'; ?>>Bon</option>
                <option value="usagé" <?php if($exemplaire['etat']=='usagé') echo 'selected'; ?>>Usagé</option>
                <option value="endommagé" <?php if($exemplaire['etat']=='endommagé') echo 'selected'; ?>>Endommagé</option>
                <option value="détruit" <?php if($exemplaire['etat']=='détruit') echo 'selected'; ?>>Détruit</option>
            </select><br><br>
            <label for="statut">Statut:</label>
            <select id="statut" name="statut" required>
                <option value="en_rayon" <?php if($exemplaire['statut']=='en_rayon') echo 'selected'; ?>>En rayon</option>
                <option value="en_pret" <?php if($exemplaire['statut']=='en_pret') echo 'selected'; ?>>En prêt</option>
                <option value="en_retard" <?php if($exemplaire['statut']=='en_retard') echo 'selected'; ?>>En retard</option>
                <option value="en_reserve" <?php if($exemplaire['statut']=='en_reserve') echo 'selected'; ?>>En réserve</option>
                <option value="en_travaux" <?php if($exemplaire['statut']=='en_travaux') echo 'selected'; ?>>En travaux</option>
            </select><br><br>
            <label for="id_document">ID Document:</label>
            <input type="text" id="id_document" name="id_document" value="<?php echo htmlspecialchars($exemplaire['id_document']); ?>" required><br><br>
            <input type="submit" value="Modifier">
        </form>
        <button class="green-button" onclick="window.location.href='index.html'">Retourner</button>

    </div>
    
</body>
</html>
