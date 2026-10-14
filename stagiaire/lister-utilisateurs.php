
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Utilisateurs</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-image: url('../assets/img/back3.jpg');
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
            background-color:  #4CAF50 ; /* Vert */
            color: white;
            border: none;
            padding: 15px 32px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            margin: 10px 0;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
            width: 300px; /* Largeur fixe pour les boutons */
            height: 50px; /* Hauteur fixe pour les boutons */
        }

        .green-button:hover {
            background-color: #45a049; /* Vert foncé */
        }
    
    </style>
</head>
<body>
    <div class="container">
        <h1>Liste des Utilisateurs</h1>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nom</th>
                    <th>Prénom</th>
                    <th>Téléphone</th>
                    <th>Type d'utilisateur</th>
                    <th>Statut</th>
                    <th>Date d'inscription</th>
                    <th>Mot de passe</th>
                </tr>
            </thead>
            <tbody>
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

                $sql = "SELECT * FROM utilisateur";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo "<tr>
                                <td>{$row['id_utilisateur']}</td>
                                <td>{$row['nom']}</td>
                                <td>{$row['prenom']}</td>
                                <td>{$row['telephone']}</td>
                                <td>{$row['type_utilisateur']}</td>
                                <td>{$row['statut']}</td>
                                <td>{$row['date_inscription']}</td>
                                <td>{$row['mot de passe']}</td>
                              </tr>";
                    }
                } else {
                    echo "<tr><td colspan='8'>Aucun utilisateur trouvé</td></tr>";
                }

                $conn->close();
                ?>
                      
            </tbody>
        </table>
         <button class="green-button" onclick="window.location.href='index.html'">Retourner</button>
    </div>
</body>
</html>
