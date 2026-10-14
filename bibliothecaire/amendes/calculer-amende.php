
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calculer une Amende</title>
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
        input[type="text"], input[type="date"] {
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
            color: red;
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
        <h1>Calculer une Amende</h1>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
            <label for="id_emprunt">ID Emprunt:</label>
            <input type="text" id="id_emprunt" name="id_emprunt" required>
            <label for="date_retour">Date de Retour:</label>
            <input type="date" id="date_retour" name="date_retour" required>
            <input type="submit" value="Calculer">
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
            $date_retour = $_POST["date_retour"];

            $sql = "SELECT date_fin FROM emprunt WHERE id_emprunt='$id_emprunt'";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $date_fin = $row['date_fin'];
                $datetime1 = new DateTime($date_fin);
                $datetime2 = new DateTime($date_retour);
                $interval = $datetime1->diff($datetime2);

                if ($datetime2 > $datetime1) {
                    $days_late = $interval->days;
                    $fine_amount = $days_late * 1; // Assuming 1 unit per day of delay
                    echo "<div class='message'>Amende: $fine_amount unités monétaires pour $days_late jours de retard</div>";
                } else {
                    echo "<div class='message'>Aucun retard détecté.</div>";
                }
            } else {
                echo "<div class='message'>Aucun emprunt trouvé avec cet ID.</div>";
            }
        }

        $conn->close();
        ?>
                 <button class="green-button" onclick="window.location.href='index.html'">Retourner</button>

    </div>
</body>
</html>
