<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Emprunts et Relances</title>
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
            width: 80%;
            overflow-y: auto;
            max-height: 90vh;
        }
        h1 {
            text-align: center;
        }
        table {
            width: 100%;
            border-collapse: collapse.
        }
        th, td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #4CAF50;
            color: white.
        }
        tr:hover {
            background-color: #f5f5f5.
        }
        .message {
            color: green;
            text-align: center;
            margin-top: 10px.
        }
        .green-button {
            padding: 10px;
            background-color: #4CAF50;
            color: white.
            border: none.
            border-radius: 5px.
            cursor: pointer.
            margin-top: 10px.
        }
        .green-button:hover {
            background-color: #45a049; /* Vert foncé */
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Liste des Emprunts et Relances</h1>
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

        // Fetching emprunts where the return date is past due and status is not 'retourné'
        $sql = "SELECT e.id_emprunt, CONCAT(u.nom, ' ', u.prenom) AS nom_utilisateur, d.titre AS titre_document, e.date_fin, u.email 
                FROM emprunt e 
                JOIN utilisateur u ON e.id_utilisateur = u.id_utilisateur 
                JOIN exemplaire ex ON e.id_exemplaire = ex.id_exemplaire 
                JOIN document d ON ex.id_document = d.id_document 
                WHERE e.date_fin < NOW() AND e.statut != 'retourné' AND e.statut != 'en_retard'";

        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $id_emprunt = $row['id_emprunt'];
                $date_relance = date('Y-m-d H:i:s');
                $relance_message = "Votre emprunt de l'exemplaire ID: {$row['titre_document']} est en retard. Veuillez le retourner dès que possible.";
                $email = $row['email'];

                // Escape special characters in the message string
                $relance_message_escaped = $conn->real_escape_string($relance_message);

                // Insert a new relance
                $sql_insert = "INSERT INTO relance (id_emprunt, date_relance, message) VALUES ('$id_emprunt', '$date_relance', '$relance_message_escaped')";
                if ($conn->query($sql_insert) === TRUE) {
                    // Update emprunt status to 'en_retard'
                    $sql_update = "UPDATE emprunt SET statut='en_retard' WHERE id_emprunt='$id_emprunt'";
                    $conn->query($sql_update);

                    // Send email notification (using mail() function or other mail service)
                    // mail($email, "Relance Emprunt", $relance_message);

                    // Display message on the page
                    $message = "Relances générées pour les emprunts en retard.";
                }
            }
        }

        // Display list of emprunts
        echo "<table>
                <thead>
                    <tr>
                        <th>ID Emprunt</th>
                        <th>Nom Utilisateur</th>
                        <th>Titre Document</th>
                        <th>Date de Fin</th>
                        <th>Email</th>
                    </tr>
                </thead>
                <tbody>";

        $sql = "SELECT e.id_emprunt, CONCAT(u.nom, ' ', u.prenom) AS nom_utilisateur, d.titre AS titre_document, e.date_fin, u.email 
                FROM emprunt e 
                JOIN utilisateur u ON e.id_utilisateur = u.id_utilisateur 
                JOIN exemplaire ex ON e.id_exemplaire = ex.id_exemplaire 
                JOIN document d ON ex.id_document = d.id_document";

        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>{$row['id_emprunt']}</td>
                        <td>{$row['nom_utilisateur']}</td>
                        <td>{$row['titre_document']}</td>
                        <td>{$row['date_fin']}</td>
                        <td>{$row['email']}</td>
                      </tr>";
            }
        } else {
            echo "<tr><td colspan='5'>Aucun emprunt trouvé</td></tr>";
        }

        echo "</tbody></table>";

        $conn->close();
        ?>
        <?php if ($message): ?>
            <div class="message"><?php echo $message; ?></div>
        <?php endif; ?>
        <button class="green-button" onclick="window.location.href='index.html'">Retourner</button>
    </div>
</body>
</html>
