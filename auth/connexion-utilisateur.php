<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "bibliotheque";

$conn = new mysqli($servername, $username, $password, $dbname);

// Vérifier la connexion
if ($conn->connect_error) {
    die("Connexion échouée: " . $conn->connect_error);
}

// Récupérer les données du formulaire
$nom = $_POST['nom'];
$prenom = $_POST['prenom'];
$mot_de_passe = $_POST['mot_de_passe'];

// Préparer la requête SQL
$sql = "SELECT * FROM utilisateur WHERE nom='$nom' AND prenom='$prenom' AND `mot de passe`='$mot_de_passe'";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    header("Location: bienvenue-connexion.html");
} else {
    echo "
    <!DOCTYPE html>
    <html lang='en'>
    <head>
        <meta charset='UTF-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
        <title>Erreur de Connexion</title>
        <style>
            body {
                font-family: Arial, sans-serif;
                background: url('../assets/img/img5.jpg') no-repeat center center fixed; /* Ajoutez votre image d'arrière-plan ici */
                background-size: cover; /* Assure que l'image couvre tout l'arrière-plan */
                display: flex;
                justify-content: center;
                align-items: flex-start; /* Aligne les éléments en haut */
                height: 100vh;
                margin: 0;
                padding-top: 50px; /* Ajustez cette valeur pour déplacer le cadre plus ou moins en haut */
            }

            .message-container {
                background-color: rgba(255, 255, 255, 0.8); /* Couleur de fond avec transparence */
                padding: 20px;
                border-radius: 5px;
                box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
                text-align: center;
                width: 400px; /* Ajustez cette valeur pour la largeur du cadre */
            }

            .message {
                color: #d9534f; /* Couleur du texte */
                margin-bottom: 20px;
            }

            .retry-button {
                padding: 10px;
                background-color: #28a745; /* Vert */
                color: #fff;
                border: none;
                border-radius: 5px;
                cursor: pointer;
                font-size: 16px;
            }

            .retry-button:hover {
                background-color: #218838; /* Vert foncé au survol */
            }
        </style>
    </head>
    <body>
        <div class='message-container'>
            <p class='message'>Nom, prénom ou mot de passe incorrect.</p>
            <button class='retry-button' onclick='window.history.back()'>Réessayer</button>
        </div>
    </body>
    </html>";
}

$conn->close();
?>
