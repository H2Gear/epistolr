


<!DOCTYPE html>
<html>
    <head>
       
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Visu sur les thèmes</title>

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
				 <p></br></br></br></br>
						<a class = "btn btn-sm btn-primary" href = "index.php"> &laquo;  <i class = "glyphicon glyphicon"></i> Index / Espace Membre </a>
                        </p>
						
						
                    <h2></br> Affichage des différentes correspondances </br> Possibilité principale : réagir</h2>
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
                    } else {
                        // il est connecté on recupere ses infos
                        
						$config = (require 'config.php');
						$conn = new PDO($config['DB_HOST'], $config['DB_USER'], $config['DB_PASS'], [$config['DB_OPT']]);
                        $query= $conn->prepare("SELECT * FROM users WHERE users_id = ?");
                        $query->execute(array($_SESSION['id']));
                        $donnees=$query->fetchAll();
                        extract($donnees['0'])
                        ?>


                    <p>Bienvenue dans l'espace permettant de visualiser les relations. Les relations seront filtrés par tags par la suite.<b><?php echo $pseudo . ' ! '; ?></b><br>Bonne lecture ! <p>
                        <p>Titre relation 1 : </br>
							<?php echo 'lettre 1, naissance de la relation............'; ?></br>
							<?php echo 'deuxième lettre...........'; ?></br>
							<?php echo 'puis un bouton "lire plus ............'; ?></br>
						</p>
						<p>Titre relation 2 : </br>
							<?php echo 'Rebelote..........'; ?></br>
						</p>
							
                        <p>Ajouter un outil de tri</br>
							<?php echo 'menu défilant avec les tags existants............'; ?></br>
						</p>
							
							
						<p>Boutons spécifiques à la page
							</br></br></br></br>
							<a class = "btn btn-sm btn-primary" href = "index_identite_modifier.php"> &laquo;  <i class = "glyphicon glyphicon-edit"></i> Trier par : menu défilant </a>	
                        </p>
						
						
						<p>
							</br></br></br></br>
                        </p>
						
						
                        <p>
							</br></br></br></br>
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