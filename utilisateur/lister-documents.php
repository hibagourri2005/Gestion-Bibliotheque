<!DOCTYPE html>
<html>
<head>
    <title>Document List</title>
    <style>
        body {
            background-image: url('../assets/img/back3.jpg');
            background-size: cover;
            background-attachment: fixed;
            font-family: Arial, sans-serif;
        }
        h2 {
            background-color: rgba(139, 69, 19, 0.7); /* Brown transparent */
            color: white;
            text-align: center;
            padding: 20px;
        }
        table {
            width: 80%;
            background-color: rgba(255, 255, 255, 0.7); /* White transparent */
            border-collapse: collapse;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
            margin: 20px; /* Added margin */
        }
        th, td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: rgba(139, 69, 19, 0.7); /* Brown transparent */
            color: white;
        }
        tr:hover {
            background-color: rgba(139, 69, 19, 0.3); /* Brown light transparent */
        }
         button {
    padding: 10px;
    background-color: #28a745; /* Vert */
    color: #fff;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    font-size: 16px;
}

button:hover {
    background-color: #218838; /* Vert foncé au survol */
}
  
    </style>
</head>
<body>

<h2>Document List</h2>

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
    SELECT 
        d.id_document, 
        d.titre, 
        d.annee_publication, 
        d.type_document, 
        e.nom AS editeur_nom, 
        e.prenom AS editeur_prenom, 
        a.nom AS auteur_nom, 
        a.prenom AS auteur_prenom 
    FROM 
        document d
    LEFT JOIN 
        editeur e ON d.id_editeur = e.id_editeur
    LEFT JOIN 
        livre l ON d.id_document = l.id_document
    LEFT JOIN 
        realiser_par r ON l.code_isbn = r.code_isbn
    LEFT JOIN 
        auteur a ON r.id_auteur = a.id_auteur";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<table>
            <tr>
                <th>Document Title</th>
                <th>Publication Year</th>
                <th>Type</th>
                <th>Editeur</th>
                <th>Auteur</th>
            </tr>";
    while($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>" . $row["titre"] . "</td>
                <td>" . $row["annee_publication"] . "</td>
                <td>" . $row["type_document"] . "</td>
                <td>" . $row["editeur_nom"] . " " . $row["editeur_prenom"] . "</td>";
        if ($row["type_document"] == 'livre') {
            echo "<td>" . $row["auteur_nom"] . " " . $row["auteur_prenom"] . "</td>";
        } else {
            echo "<td>N/A</td>";
        }
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "0 results";
}

$conn->close();
?>
<button onclick="window.location.href='../index.html'">Se deconnecter</button>
</body>
</html>
