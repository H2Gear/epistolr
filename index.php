﻿


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
            <div class "row">
                 <div class = "col-lg-offset-3 col-lg-6 col-lg-offset-3 well">
                    <h2>Mon espace membre</h2>
                    <?php
                    /*
                      on verifie si l'utilisateur est connecté
                      si oui on affiche ses informations
                      dans le cas contraire on lui demande de se connecter ou s'inscrire
                      Pour verifier s'il est connecté	il suffit de tester
                      les variables $_SESSION['id'] et $_SESSION['pseudo']
                      existent
                     */
                    
                   session_start();
                  
                    if (!isset($_SESSION['pseudo']) || !isset($_SESSION['id']))
			{
                        //l'utilisateur n'est pas connecté
                        echo '<p>Vous n\'etes pas encore connecté(e)
											<a class = "btn btn-sm btn-primary" href = "connexion.php"><i class = "glyphicon glyphicon-off"></i> Connexion</a> ou
											<a class = "btn btn-sm btn-success" href = "inscription.php"><i class = "glyphicon glyphicon-user"></i> Créer votre compte</a>
											</p>';
                    } else {
                        // il est connecté on recupere ses infos
                        include 'config.php';
                        $query= $pdo->prepare("SELECT * FROM users WHERE id = ?");
			extract ($_SESSION);
                        $query->execute(array($id));
                        $donnees=$query->fetchAll();
                        extract($donnees['0'])
                        ?>


                    <p>Bienvenue dans votre compte, <b><?php echo $pseudo . ' ! '; ?></b><br> voici vos informations</p>
                        <p>Pseudo : <b><?php echo $pseudo; ?></b></p>
                        <p>Mail : <b><?php echo $mail; ?></b></p>
                        <p>
                            <a class = "btn btn-sm btn-primary" href = "redaction.php"><i class = "glyphicon glyphicon-edit"></i> Rédiger</a>
                            <a class = "btn btn-sm btn-success" href = "modifier.php"><i class = "glyphicon glyphicon-edit"></i> Modifier votre profil</a>
                            <a class = "btn btn-sm btn-info" href = "deconnexion.php"><i class = "glyphicon glyphicon-off"></i> Déconnexion</a>
                        </p>
                        <p>
					 <a class = "btn btn-sm btn-primary" href = "profil.php"><i class = "glyphicon glyphicon-th-list"></i> Profil </a>
					 <a class = "btn btn-sm btn-default" href = "index.php"> &laquo;  <i class = "glyphicon glyphicon-user"></i> Votre compte / Index / Espace Membre </a>
				 </p>
<?php
                    }
                    ?>
                </div>
            </div>
        </div>
        <!-- Bibliothèque JavaScript jquery -->
        <script src="bootstrap/js/jquery.min.js"></script>

        <!--  JavaScript de Bootstrap -->
        <script src="bootstrap/js/bootstrap.min.js"></script>
    </body>
</html>