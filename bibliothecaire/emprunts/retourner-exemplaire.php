<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Retourner un Document</title>
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
        <h1>Retourner un Document</h1>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <label for="id_emprunt">ID Emprunt:</label>
            <input type="text" id="id_emprunt" name="id_emprunt" required>
            <input type="submit" value="Retourner l'emprunt">
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

            $id_emprunt = $conn->real_escape_string($_POST["id_emprunt"]);

            // Check the status of the exemplaire
            $sql_check = "
                SELECT ex.statut AS exemplaire_statut
                FROM emprunt e
                JOIN exemplaire ex ON e.id_exemplaire = ex.id_exemplaire
                WHERE e.id_emprunt = '$id_emprunt'
            ";
            $result_check = $conn->query($sql_check);

            if ($result_check->num_rows > 0) {
                $row = $result_check->fetch_assoc();
                if ($row['exemplaire_statut'] == 'en_pret' || $row['exemplaire_statut'] == 'en_retard') {
                    // Update the status of the exemplaire and emprunt
                    $sql_update_emprunt = "UPDATE emprunt SET statut='retourné' WHERE id_emprunt='$id_emprunt'";
                    $sql_update_exemplaire = "
                        UPDATE exemplaire
                        SET statut='en_rayon'
                        WHERE id_exemplaire = (SELECT id_exemplaire FROM emprunt WHERE id_emprunt='$id_emprunt')
                    ";

                    if ($conn->query($sql_update_emprunt) === TRUE && $conn->query($sql_update_exemplaire) === TRUE) {
                        echo "Document retourné avec succès";
                    } else {
                        echo "Erreur de retour: " . $conn->error;
                    }
                } else {
                    echo "Le statut de l'exemplaire ne permet pas le retour du document.";
                }
            } else {
                echo "Emprunt non trouvé.";
            }

            $conn->close();
        }
        ?>
         <button class="green-button" onclick="window.location.href='index.html'">Retourner</button>
    </div>
</body>
</html>
