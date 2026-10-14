<!DOCTYPE html>
<html lang="en">
<head>
    <title>Formulaire d'Emprunt</title>
    <style>
        body {
            background-image: url('../assets/img/back3.jpg');
            background-size: cover;
            background-attachment: fixed;
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .form-container {
            background-color: rgba(255, 255, 255, 0.85);
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.3);
            text-align: center;
            width: 400px;
            backdrop-filter: blur(10px);
        }
        .form-container h2 {
            color: brown;
            margin-bottom: 20px;
        }
        .form-container label {
            display: block;
            margin-top: 15px;
            color: brown;
            font-weight: bold;
        }
        .form-container input[type="text"], .form-container input[type="password"] {
            width: calc(100% - 20px);
            padding: 10px;
            margin-top: 5px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }
        .form-container button {
            padding: 10px 20px;
            background-color: green;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 20px;
            width: 100%;
            font-size: 16px;
        }
        .form-container button:hover {
            background-color: darkgreen;
        }
        .message {
            color: brown;
            font-weight: bold;
            text-align: center;
            margin-top: 20px;
        }
    </style>
</head>
<body>

<div class="form-container">
    <h2>Formulaire d'Emprunt</h2>
    <form method="POST" action="">
        <label for="nom">Nom :</label>
        <input type="text" id="nom" name="nom" required>
        
        <label for="prenom">Prénom :</label>
        <input type="text" id="prenom" name="prenom" required>
        
        <label for="password">Mot de passe :</label>
        <input type="password" id="password" name="password" required>
        
        <label for="id_exemplaire">ID de l'exemplaire :</label>
        <input type="text" id="id_exemplaire" name="id_exemplaire" required>
        
        <button type="submit">Emprunter</button>
        <button onclick="window.location.href='../index.html'" type="button">Se déconnecter</button>
        <button onclick="window.location.href='consulter-exemplaire.php'" type="button">Retourner</button>
    </form>
</div>

<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "bibliotheque";

    // Créer une connexion
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Vérifier la connexion
    if ($conn->connect_error) {
        die("Connexion échouée : " . $conn->connect_error);
    }

    $nom = $conn->real_escape_string($_POST['nom']);
    $prenom = $conn->real_escape_string($_POST['prenom']);
    $user_password = $conn->real_escape_string($_POST['password']);
    $id_exemplaire = $conn->real_escape_string($_POST['id_exemplaire']);

    // Vérifier les contraintes et règles de gestion
    $user_check_sql = "SELECT * FROM utilisateur WHERE nom='$nom' AND prenom='$prenom' AND `mot de passe`='$user_password'";
    $user_result = $conn->query($user_check_sql);
    
    if ($user_result->num_rows > 0) {
        $user = $user_result->fetch_assoc();

        // Vérifier si l'utilisateur a un emprunt en retard
        $emprunt_en_retard_sql = "SELECT * FROM emprunt WHERE id_utilisateur='{$user['id_utilisateur']}' AND statut='en_retard'";
        $emprunt_en_retard_result = $conn->query($emprunt_en_retard_sql);

        if ($emprunt_en_retard_result->num_rows == 0) {
            // Vérifier le nombre maximum d'emprunts autorisés
            $max_emprunts = 0;
            switch ($user['type_utilisateur']) {
                case 'occasionnel':
                    $max_emprunts = 1;
                    $duree_emprunt = 15; // jours
                    break;
                case 'abonné':
                    $max_emprunts = 4;
                    $duree_emprunt = 30; // jours
                    break;
                case 'abonné_privilégié':
                    $max_emprunts = 8;
                    $duree_emprunt = 30; // jours
                    break;
            }

            $emprunt_count_sql = "SELECT COUNT(*) as emprunt_count FROM emprunt WHERE id_utilisateur='{$user['id_utilisateur']}' AND statut='en_cours'";
            $emprunt_count_result = $conn->query($emprunt_count_sql);
            $emprunt_count = $emprunt_count_result->fetch_assoc()['emprunt_count'];

            if ($emprunt_count < $max_emprunts) {
                // Vérifier le statut de l'exemplaire
                $exemplaire_check_sql = "SELECT statut FROM exemplaire WHERE id_exemplaire='$id_exemplaire'";
                $exemplaire_result = $conn->query($exemplaire_check_sql);

                if ($exemplaire_result->num_rows > 0) {
                    $exemplaire = $exemplaire_result->fetch_assoc();
                    if ($exemplaire['statut'] == 'en_rayon') {
                        // Mettre à jour le statut de l'exemplaire et insérer l'emprunt dans la table
                        $conn->begin_transaction(); // Débuter une transaction
                        $update_sql = "UPDATE exemplaire SET statut = 'en_pret' WHERE id_exemplaire = '$id_exemplaire'";
                        $insert_sql = "INSERT INTO emprunt (id_exemplaire, id_utilisateur, date_debut, date_fin, statut)
                                       VALUES ('$id_exemplaire', '{$user['id_utilisateur']}', CURDATE(), DATE_ADD(CURDATE(), INTERVAL $duree_emprunt DAY), 'en_cours')";
                        if ($conn->query($update_sql) === TRUE && $conn->query($insert_sql) === TRUE) {
                            $conn->commit(); // Valider la transaction
                            echo "<p class='message'>Emprunt effectué avec succès !</p>";
                        } else {
                            $conn->rollback(); // Annuler la transaction en cas d'erreur
                            echo "<p class='message'>Erreur : " . $conn->error . "</p>";
                        }
                    } else {
                        echo "<p class='message'>L'exemplaire n'est pas disponible pour l'emprunt.</p>";
                    }
                } else {
                    echo "<p class='message'>Exemplaire introuvable.</p>";
                }
            } else {
                echo "<p class='message'>Vous avez atteint le nombre maximum d'emprunts.</p>";
            }
        } else {
            echo "<p class='message'>Vous ne pouvez pas effectuer d'emprunt car vous avez un emprunt en retard.</p>";
        }
    } else {
        echo "<p class='message'>Utilisateur non trouvé.</p>";
    }

    $conn->close();
}
?>

</body>
</html>
