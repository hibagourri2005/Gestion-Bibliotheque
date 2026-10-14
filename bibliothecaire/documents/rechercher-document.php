<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rechercher un Document</title>
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
        <h1>Rechercher un Document</h1>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
            <label for="titre">Titre:</label>
            <input type="text" id="titre" name="titre" required>
            <input type="submit" value="Rechercher">
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

            $titre = $_POST["titre"];
            $sql = "SELECT * FROM document WHERE titre LIKE '%$titre%'";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                echo "<table>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Titre</th>
                                <th>Année de Publication</th>
                                <th>Type de Document</th>
                                <th>Référence</th>
                                <th>ID Éditeur</th>
                            </tr>
                        </thead>
                        <tbody>";
                while($row = $result->fetch_assoc()) {
                    echo "<tr>
                            <td>{$row['id_document']}</td>
                            <td>{$row['titre']}</td>
                            <td>{$row['annee_publication']}</td>
                            <td>{$row['type_document']}</td>
                            <td>{$row['reference']}</td>
                            <td>{$row['id_editeur']}</td>
                          </tr>";
                }
                echo "  </tbody>
                      </table>";
            } else {
                echo "Aucun document trouvé avec ce titre.";
            }

            $conn->close();
        }
        ?>
        <button class="green-button" onclick="window.location.href='index.html'">Retourner</button>
    </div>
</body>
</html>
