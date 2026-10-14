<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payer une Amende</title>
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
            background-color: #45a049; /* Vert foncé */
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Payer une Amende</h1>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
            <label for="id_amende">ID Amende:</label>
            <input type="text" id="id_amende" name="id_amende" required>
            <input type="submit" value="Payer">
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
            $id_amende = $_POST["id_amende"];

            $sql = "UPDATE amende SET statut='payee', date_paiement=NOW() WHERE id_amende='$id_amende'";
            if ($conn->query($sql) === TRUE) {
                echo "<div class='message'>Amende payée avec succès.</div>";
            } else {
                echo "<div class='message'>Erreur de paiement de l'amende: " . $conn->error . "</div>";
            }
        }

        $conn->close();
        ?>
                <button class="green-button" onclick="window.location.href='index.html'">Retourner</button>

    </div>
</body>
</html>
