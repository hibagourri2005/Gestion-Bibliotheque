
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter un Exemplaire</title>
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
        <h1>Ajouter un Exemplaire</h1>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
            <label for="numero_ordre">Numéro d'ordre:</label>
            <input type="text" id="numero_ordre" name="numero_ordre" required>
            <label for="date_achat">Date d'achat:</label>
            <input type="date" id="date_achat" name="date_achat" required>
            <label for="etat">État:</label>
            <select id="etat" name="etat" required>
                <option value="neuf">Neuf</option>
                <option value="bon">Bon</option>
                <option value="usagé">Usagé</option>
                <option value="endommagé">Endommagé</option>
                <option value="détruit">Détruit</option>
            </select>
            <label for="statut">Statut:</label>
            <select id="statut" name="statut" required>
                <option value="en_rayon">En rayon</option>
                <option value="en_pret">En prêt</option>
                <option value="en_retard">En retard</option>
                <option value="en_reserve">En réserve</option>
                <option value="en_travaux">En travaux</option>
            </select>
            <label for="id_document">ID Document:</label>
            <input type="text" id="id_document" name="id_document" required>
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

            $numero_ordre = $_POST["numero_ordre"];
            $date_achat = $_POST["date_achat"];
            $etat = $_POST["etat"];
            $statut = $_POST["statut"];
            $id_document = $_POST["id_document"];

            $sql = "INSERT INTO exemplaire (numero_ordre, date_achat, etat, statut, id_document) VALUES ('$numero_ordre', '$date_achat', '$etat', '$statut', '$id_document')";

            if ($conn->query($sql) === TRUE) {
                echo "Exemplaire ajouté avec succès";
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
