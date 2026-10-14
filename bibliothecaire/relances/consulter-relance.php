<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consulter une Relance</title>
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
            background-color: #45a049; /* Vert foncé */
        }

    </style>
</head>
<body>
    <div class="container">
        <h1>Consulter une Relance</h1>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
            <label for="id_emprunt">ID Emprunt:</label>
            <input type="text" id="id_emprunt" name="id_emprunt" required>
            <input type="submit" value="Consulter">
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
            
            // Fetching relance details
            $sql = "SELECT * FROM relance WHERE id_emprunt='$id_emprunt'";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                echo "<table>
                        <thead>
                            <tr>
                                <th>ID Relance</th>
                                <th>ID Emprunt</th>
                                
                                <th>Date de Relance</th>
                                <th>Message</th>
                            </tr>
                        </thead>
                        <tbody>";
                while($row = $result->fetch_assoc()) {
                    echo "<tr>
                            <td>{$row['id_relance']}</td>
                            <td>{$row['id_emprunt']}</td>
                         
                            <td>{$row['date_relance']}</td>
                            <td>{$row['message']}</td>
                          </tr>";
                }
                echo "</tbody></table>";
            } else {
                echo "Aucune relance trouvée pour cet emprunt.";
            }
        }

        $conn->close();
        ?>
                <button class="green-button" onclick="window.location.href='index.html'">Retourner</button>

    </div>
</body>
</html>
