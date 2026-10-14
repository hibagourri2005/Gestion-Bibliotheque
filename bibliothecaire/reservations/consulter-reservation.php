<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consulter une Réservation</title>
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
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #4CAF50;
            color: white;
        }
        tr:hover {
            background-color: #f5f5f5;
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
        <h1>Consulter une Réservation</h1>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
            <label for="id_reservation">ID Réservation:</label>
            <input type="text" id="id_reservation" name="id_reservation" required>
            <input type="submit" value="Consulter">
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
            $id_reservation = $conn->real_escape_string($_POST["id_reservation"]);

            $sql = "
                SELECT r.id_reservation, r.date_reservation, u.nom AS utilisateur_nom, u.prenom AS utilisateur_prenom, d.titre AS document_titre
                FROM reservation r
                JOIN utilisateur u ON r.id_utilisateur = u.id_utilisateur
                JOIN exemplaire e ON r.id_exemplaire = e.id_exemplaire
                JOIN document d ON e.id_document = d.id_document
                WHERE r.id_reservation='$id_reservation'
            ";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                echo "<table>
                        <thead>
                            <tr>
                                <th>ID Réservation</th>
                                <th>Nom Utilisateur</th>
                                <th>Nom Exemplaire</th>
                                <th>Date de Réservation</th>
                            </tr>
                        </thead>
                        <tbody>";
                while($row = $result->fetch_assoc()) {
                    echo "<tr>
                            <td>{$row['id_reservation']}</td>
                            <td>{$row['utilisateur_nom']} {$row['utilisateur_prenom']}</td>
                            <td>{$row['document_titre']}</td>
                            <td>{$row['date_reservation']}</td>
                          </tr>";
                }
                echo "</tbody></table>";
            } else {
                echo "<div class='message'>Aucune réservation trouvée avec cet ID.</div>";
            }
        }

        $conn->close();
        ?>
        <button class="green-button" onclick="window.location.href='index.html'">Retourner</button>
    </div>
</body>
</html>
