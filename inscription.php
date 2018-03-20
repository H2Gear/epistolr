<?php

// __ INCLUSION DU FICHIER DE CONFIGURATION // CONNEXION A BDD __ 

include('config.php');
?>

<!DOCTYPE html>
<html>
    <head>

        <meta charset="utf-8">	
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Espace membre</title>



        <!-- CSS de Bootstrap -->
        <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <!-- Notre style CSS  -->
        <link href="bootstrap/css/style.css" rel="stylesheet">

		
		
		
		
    </head>
	
	
	
    <body>
        <div class = "container">
            <br />
            <?php

            //  ___ VERIFICATION CONFORMITE AVANT ENVOI DANS BDD ___

            if (isset($_POST['submit'])) {
                //la variable erreur vaut null par défaut
                $erreur = null;
                //on convertit chaque champ en variable avec la fonction extract()
                extract($_POST);

                //on verifie les champs vides
                if (empty($pseudo) || empty($password) || empty($confirm_password) || empty($mail) || empty($confirm_mail)) {
                    $erreur = '<p class = "alert alert-danger">Veuillez remplir tous les champs</p>';
                }
                //si le mot de passe est égal à la confirmation
                else if ($password != $confirm_password) {
                    $erreur = '<p class = "alert alert-danger">Les deux mots de passe sont différents</p>';
                }
                //si les adresses mail diff
                else if ($mail != $confirm_mail) {
                    $erreur = '<p class = "alert alert-danger">Les deux adresses mail sont différentes</p>';
                }

				

                $config = require('config.php');
				$conn = new PDO($config['DB_HOST'], $config['DB_USER'], $config['DB_PASS']);
				$query = $conn->prepare('SELECT pseudo FROM membre WHERE pseudo = ?');
                $query->setFetchMode(PDO::FETCH_ASSOC);
                $query->execute(array($pseudo));
                $rows = $query->fetchAll();
                if (count($rows) != 0) 
				{
                    $erreur = '<p class = "alert alert-danger">Ce pseudo existe deja veuillez choisir un autre pseudo</p>';
                }

                if ($erreur == null) {
                    //tout est OK on enregistre l'utilisateur
                    //on crypte le mot de passe 
                    $password = md5($password);
                    $query = $conn->prepare("INSERT INTO membre (pseudo, email, mdp) VALUES(?, ?, ?)");
                    $query->execute(array($pseudo, $mail, $password));
                    $conn=null;

                    if ($query) {
                        echo '<p class = "alert alert-success">Votre compte a ete cree avec succes <a class = "btn btn-sm btn-primary" href = "connexion.php"><i class = "glyphicon glyphicon-off"></i> Connexion</a></p>';
                    } else {
                        $erreur = '<p class = "alert alert-danger">Une erreur est survenue lors de la création de votre compte</p>';
                    }
                }
            }

            //on affiche le formulaire
            //s'il ya des erreurs alors on les affiche
            if (isset($erreur)) {
                echo $erreur;
            }
            ?>
	<div class "row">
		<div class = "col-lg-offset-4 col-lg-4 col-lg-offset-4">


                    <form action = "inscription.php" method = "post" class = "well">
                        <h4 class = "head">Creer votre compte gratuitement</h4>
                        <div class = "form-group">
                            <label for = "pseudo">Pseudo : </label>
                            <input type = "text" name = "pseudo" value = "" class = "form-control input-sm">
                        </div>
                        <div class = "form-group">
                            <label for = "mail">Adresse mail : </label>
                            <input type = "email" name = "mail" value = "" class = "form-control  input-sm">
                        </div>
                        <div class = "form-group">
                            <label for = "confirm_mail">Confirmation adresse mail : </label>
                            <input type = "email" name = "confirm_mail" value = "" class = "form-control  input-sm">
                        </div>
                        <div class = "form-group">
                            <label for = "password">Mot de passe : </label>
                            <input type = "password" name = "password" value = "" class = "form-control  input-sm">
                        </div>
                        <div class = "form-group">
                            <label for = "confirm_password">Confirmation de mot de passe : </label>
                            <input type = "password" name = "confirm_password" value = "" class = "form-control  input-sm">
                        </div>
                        <div class = "form-group">
                            <input type = "submit" name = "submit" value = "Valider" class = "btn btn-sm btn-primary btn-block">
                        </div>
                    </form>
		</div>
	</div>


        <!-- Bibliothèque JavaScript jquery -->
        <script src="bootstrap/js/jquery.min.js"></script>

        <!--  JavaScript de Bootstrap -->
        <script src="bootstrap/js/bootstrap.min.js"></script>
    </body>
</html>
