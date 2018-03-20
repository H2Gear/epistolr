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
					<p>
						</br>
						</br>
						</br>
						Ci dessous les liens concernant les visus sur l'exploration
						</br>
						<a class = "btn btn-sm btn-primary" href = "visu_membres.php"><i class = "glyphicon glyphicon-th-list"></i> Liste des membres</a>
						<a class = "btn btn-sm btn-primary" href = "visu_relations.php"><i class = "glyphicon glyphicon-th-list"></i> Liste des relations epistolaires</a>
						<a class = "btn btn-sm btn-primary" href = "visu_themes.php"><i class = "glyphicon glyphicon-th-list"></i> Liste des thèmes</a>
					</p>
				 
				 
                    <h2>Mon espace membre </br> Page Index </br> Affichage de mes relations en cours </br> Statistiques de mon activité </h2>
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
                    if (!isset($_SESSION['pseudo']) || !isset($_SESSION['id']) )
					{
                        //l'utilisateur n'est pas connecté
                        echo '<p>Vous n\'etes pas encore connecté(e)
							<a class = "btn btn-sm btn-primary" href = "connexion.php"><i class = "glyphicon glyphicon-off"></i> Connexion</a> ou
							<a class = "btn btn-sm btn-success" href = "inscription.php"><i class = "glyphicon glyphicon-user"></i> Créer votre compte</a>
							</p>';
                    } 
					else 
					{
                        // il est connecté on recupere ses infos
                        
						$config = (require 'config.php');
						$conn = new PDO($config['DB_HOST'], $config['DB_USER'], $config['DB_PASS'], [$config['DB_OPT']]);
                        $query= $conn->prepare("SELECT * FROM membre WHERE membre_id = ?");
                        $query->execute(array($_SESSION['id']));
                        $donnees=$query->fetchAll();
                        extract($donnees['0'])
                        ?>
						
						
                    <p>Bienvenue dans votre espace membre, <b><?php echo $pseudo . ' ! '; ?></b><br> voici vos informations</p>
                        <p>Nombre de relations epistolaires : </br>
							<?php echo 'détails sur mon activité de relations, temps restants etc............'; ?></p>
						<p>Mon identite : </br>
							<?php echo 'pourcentage de remplissage de mon identité............'; ?></p>
						<p>Mes correspondances suivies (hors solution minimale) : </br>
							<?php echo 'pourcentage de remplissage de mon identité............'; ?></p>
						<p>Autres détails : </br>
							<?php echo 'Les pages relations et identité pourraient être incluses dans cette page.. à débattre............'; ?></p>
							
                        <p>
						</br>
						</br>
						</br>
						</br>
						Ci dessous les liens spécifiques à la page
						</br>
                        <p>
						</br>
						</br>
						</br>
						</br>
						Ci dessous les liens concernant les modifications de ses données
						</br>
						<a class = "btn btn-sm btn-primary" href = "toutesmcorrespondances.php"><i class = "glyphicon glyphicon-th-list"></i> Voir mes relations épistolaires</a>
						<a class = "btn btn-sm btn-primary" href = "index_identite.php"><i class = "glyphicon glyphicon-th-list"></i> Voir mon identité Epistolr </a>
                        </p>
						</br>
						</br>
						</br>
						</br>
                        <p>
						
						Ci dessous les liens concernant tout ce qui a attrait au compte et paramètres
						</br>
					 <a class = "btn btn-sm btn-default" href = "profil.php"> &laquo;  <i class = "glyphicon glyphicon-user"></i> Mon compte</a>
                            <a class = "btn btn-sm btn-default" href = "deconnexion.php"><i class = "glyphicon glyphicon-off"></i> Déconnexion</a>
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