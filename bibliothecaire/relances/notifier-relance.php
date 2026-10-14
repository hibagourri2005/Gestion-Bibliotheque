<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notifier une Relance</title>
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
        <h1>Notifier une Relance</h1>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
            <label for="id_emprunt">ID Emprunt:</label>
            <input type="text" id="id_emprunt" name="id_emprunt" required>
            <input type="submit" value="Notifier">
        </form>
        <?php
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "bibliotheque";
        $message = "";

        // Create connection
        $conn = new mysqli($servername, $username, $password, $dbname);

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $id_emprunt = $_POST["id_emprunt"];

            // Fetch emprunt and user details
            $sql = "SELECT e.id_utilisateur, u.email 
                    FROM emprunt e 
                    JOIN utilisateur u ON e.id_utilisateur = u.id_utilisateur 
                    WHERE e.id_emprunt = '$id_emprunt'";
            $result = $conn->query($sql);
            
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $id_utilisateur = $row['id_utilisateur'];
                $email = $row['email'];
                $date_relance = date('Y-m-d H:i:s');
                $relance_message = "Votre emprunt ID: $id_emprunt est en retard. Veuillez le retourner dès que possible.";

                // Check the time interval since the last relance
                $sql_last_relance = "SELECT date_relance FROM relance WHERE id_emprunt='$id_emprunt' ORDER BY date_relance DESC LIMIT 1";
                $result_last_relance = $conn->query($sql_last_relance);
                $can_send_relance = true;

                if ($result_last_relance->num_rows > 0) {
                    $last_relance = $result_last_relance->fetch_assoc();
                    $last_relance_date = new DateTime($last_relance['date_relance']);
                    $current_date = new DateTime();

                    $interval = $last_relance_date->diff($current_date);

                    // Determine if enough time has passed since the last relance
                    $sql_count = "SELECT COUNT(*) as count FROM relance WHERE id_emprunt='$id_emprunt'";
                    $result_count = $conn->query($sql_count);
                    $count_row = $result_count->fetch_assoc();
                    $nb_relances = $count_row['count'];

                    if (($nb_relances == 1 && $interval->days < 7) || ($nb_relances == 2 && $interval->days < 7)) {
                        $can_send_relance = false;
                        $message = "Une relance a déjà été envoyée il y a moins d'une semaine.";
                    }
                }

                if ($can_send_relance) {
                    // Insert a new relance
                    $sql_insert = "INSERT INTO relance (id_emprunt , date_relance, message) VALUES ('$id_emprunt', '$date_relance', '$relance_message')";
                    if ($conn->query($sql_insert) === TRUE) {
                        // Update emprunt status to 'en retard'
                        $sql_update = "UPDATE emprunt SET statut='en retard' WHERE id_emprunt='$id_emprunt'";
                        if ($conn->query($sql_update) === TRUE) {
                            // Send email notification
                            $to = $email;
                            $subject = "Relance Emprunt";
                            $headers = "From: noreply@yourdomain.com";
                            //
                            // If there are three relances, notify the director
                            if ($nb_relances == 2) {
                                $director_message = "L'emprunt ID: $id_emprunt a reçu trois relances sans retour. Veuillez prendre des mesures supplémentaires.";
                                // Envoi de l'email au directeur
                               
                                $message .= " Alerte envoyée au directeur.";
                            }

                            // Display confirmation message in the interface
                            $message = "Relance notifiée et email envoyé à l'utilisateur." . $message;
                        } else {
                            $message = "Erreur de mise à jour: " . $conn->error;
                        }
                    } else {
                        $message = "Erreur d'insertion de la relance: " . $conn->error;
                    }
                }
            } else {
                $message = "Aucun emprunt trouvé avec cet ID.";
            }
        }

        $conn->close();
        ?>
        <?php if ($message): ?>
            <div class="message"><?php echo $message; ?></div>
        <?php endif; ?>
                        <button class="green-button" onclick="window.location.href='index.html'">Retourner</button>

    </div>
</body>
</html>
