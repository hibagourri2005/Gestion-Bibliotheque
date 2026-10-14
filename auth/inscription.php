<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "bibliotheque";

// Créer la connexion
$conn = new mysqli($servername, $username, $password, $dbname);

// Vérifier la connexion
if ($conn->connect_error) {
    die("Connexion échouée: " . $conn->connect_error);
}

// Récupérer les données du formulaire
$nom = $_POST['nom'];
$prenom = $_POST['prenom'];
$email = $_POST['email'];
$type_utilisateur = $_POST['type_utilisateur'];
$mot_de_passe = $_POST['mot_de_passe'];

// Vérifier si l'utilisateur existe déjà
$sql = "SELECT * FROM utilisateur WHERE nom='$nom' AND prenom='$prenom'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    header("Location: connexion-utilisateur.html");
} else {
    // Insérer le nouvel utilisateur
    $sql = "INSERT INTO utilisateur (nom, prenom, email, type_utilisateur, `mot de passe`, date_inscription)
            VALUES ('$nom', '$prenom', '$email', '$type_utilisateur', '$mot_de_passe', CURDATE())";
    if ($conn->query($sql) === TRUE) {
        header("Location: bienvenue-inscription.html");
    } else {
        echo "Erreur: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>

