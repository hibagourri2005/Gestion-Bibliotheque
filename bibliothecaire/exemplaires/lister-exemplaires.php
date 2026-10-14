
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Exemplaires par Nom</title>
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
            border-collapse: collapse;
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
        <h1>Liste des Exemplaires par Nom</h1>
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

        // Fetching exemplaires grouped by document name
        $sql = "
            SELECT ex.id_exemplaire, ex.numero_ordre, d.titre
            FROM exemplaire ex
            JOIN document d ON ex.id_document = d.id_document
            ORDER BY d.titre, ex.id_exemplaire
        ";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $current_titre = "";
            while ($row = $result->fetch_assoc()) {
                if ($current_titre != $row['titre']) {
                    if ($current_titre != "") {
                        echo "</tbody></table></div>";
                    }
                    $current_titre = $row['titre'];
                    echo "<div class='container'>
                          <h2>Document: " . htmlspecialchars($current_titre) . "</h2>
                          <table>
                              <thead>
                                  <tr>
                                      <th>ID Exemplaire</th>
                                      <th>Numéro d'ordre</th>
                                  </tr>
                              </thead>
                              <tbody>";
                }
                echo "<tr>
                        <td>" . htmlspecialchars($row['id_exemplaire']) . "</td>
                        <td>" . htmlspecialchars($row['numero_ordre']) . "</td>
                      </tr>";
            }
            echo "</tbody></table></div>";
        } else {
            echo "<tr><td colspan='2'>Aucun exemplaire trouvé</td></tr>";
        }

        $conn->close();
        ?>
                 <button class="green-button" onclick="window.location.href='index.html'">Retourner</button>
    </div>
</body>
</html>
