<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enregistrer une Amende</title>
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
        input[type="text"], input[type="number"], select {
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
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Enregistrer une Amende</h1>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
            <label for="id_emprunt">ID Emprunt:</label>
            <input type="text" id="id_emprunt" name="id_emprunt" required>
            <label for="montant">Montant de l'Amende:</label>
            <input type="number" id="montant" name="montant" required step="0.01">
            <label for="statut">Statut:</label>
            <select id="statut" name="statut" required>
                <option value="non_payee">Non Payée</option>
                <option value="payee">Payée</option>
            </select>
            <input type="submit" value="Enregistrer">
        </form>
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
            $montant = $_POST["montant"];
            $statut = $_POST["statut"];

            $sql = "INSERT INTO amende (id_emprunt, montant, statut) VALUES ('$id_emprunt', '$montant', '$statut')";
            if ($conn->query($sql) === TRUE) {
                echo "<div class='message'>Amende enregistrée avec succès.</div>";
            } else {
                echo "<div class='message'>Erreur d'enregistrement de l'amende: " . $conn->error . "</div>";
            }
        }

        $conn->close();
        ?>
        <button class="green-button" onclick="window.location.href='index.html'">Retourner</button>
    </div>
</body>
</html>
