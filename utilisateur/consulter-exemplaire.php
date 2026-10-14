<!DOCTYPE html>
<html>
<head>
    <title>Document Search</title>
    <style>
        body {
            background-image: url('../assets/img/back3.jpg'); /* Replace with your background image URL */
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
        form {
            text-align: center;
            margin: 20px auto; /* Center the form */
            padding: 20px;
            width: 50%; /* Wider form */
            background-color: rgba(255, 255, 255, 0.5); /* Transparent background */
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
        }
        label {
            color: brown; /* Make label text white */
            font-size: 18px; /* Larger font size */
        }
        input[type="text"] {
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
            width: 200px;
            margin-top: 10px; /* Add some space between label and input */
        }
        button {
            padding: 10px 20px;
            background-color: green;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 10px; /* Add some space between input and button */
        }
        button:hover {
            background-color: darkgreen;
        }
        table {
            width: 80%;
            background-color: rgba(255, 255, 255, 0.7); /* White transparent */
            border-collapse: collapse;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
            margin: 20px auto; /* Center the table */
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
        .messages {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 20px;
            margin-top: 20px;
        }
        .message-container {
            background-color: rgba(255, 255, 255, 0.5); /* Transparent background */
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
            text-align: center;
        }
        .message {
            font-size: 24px; /* Larger font size */
            color: brown; /* Brown color for messages */
            margin-bottom: 10px;
        }
        .buttons {
            text-align: center;
            margin-top: 10px;
        }
        .button {
            background-color: green;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            margin: 5px;
            border-radius: 5px;
        }
    </style>
</head>
<body>

<h2>Document Search</h2>

<form method="POST" action="">
    <label for="document_name">Enter Document Name:</label>
    <input type="text" id="document_name" name="document_name" required>
    <button type="submit">Search</button>
</form>

<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
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

    $document_name = $conn->real_escape_string($_POST['document_name']);

    $sql = "
        SELECT 
            e.id_exemplaire, 
            e.etat, 
            e.statut
        FROM 
            exemplaire e
        JOIN 
            document d ON e.id_document = d.id_document
        WHERE 
            d.titre = '$document_name'";

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo "<table>
                <tr>
                    <th>ID</th>
                    <th>State</th>
                    <th>Status</th>
                </tr>";
        while($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>" . $row["id_exemplaire"] . "</td>
                    <td>" . $row["etat"] . "</td>
                    <td>" . $row["statut"] . "</td>";
        }
        echo "</tr></table>";
    } else {
        echo "<p class='message'>No results found</p>";
    }

    $conn->close();
}
?>

<div class="messages">
    <div class="message-container">
        <div class="message">Voulez-vous effectuer une réservation ?</div>
        <div class="buttons">
            <a href="reservation.php" class="button">Oui</a>
            <a href="index.html" class="button">Non</a>
        </div>
    </div>
    <div class="message-container">
        <div class="message">Voulez-vous effectuer un emprunt ?</div>
        <div class="buttons">
            <a href="emprunt.php" class="button">Oui</a>
            <a href="index.html" class="button">Non</a>
        </div>
    </div>
</div>

</body>
</html>
