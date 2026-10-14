<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lister les Réservations</title>
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
        <h1>Lister les Réservations</h1>
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

        $sql = "
            SELECT r.id_reservation, r.date_reservation, u.nom AS utilisateur_nom, u.prenom AS utilisateur_prenom, d.titre AS document_titre
            FROM reservation r
            JOIN utilisateur u ON r.id_utilisateur = u.id_utilisateur
            JOIN exemplaire e ON r.id_exemplaire = e.id_exemplaire
            JOIN document d ON e.id_document = d.id_document
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
            echo "<div class='message'>Aucune réservation trouvée.</div>";
        }

        $conn->close();
        ?>
        <button class="green-button" onclick="window.location.href='index.html'">Retourner</button>
    </div>
</body>
</html>
