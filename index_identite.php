


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
		
		<?php include 'fonctions.php' ?>

    </head>
    <body>
        <div class = "container">
            <br />
            <div class "row">
                 <div class = "col-lg-offset-3 col-lg-6 col-lg-offset-3 well">
				 <p></br></br></br></br>
						<a class = "btn btn-sm btn-primary" href = "index.php"> &laquo;  <i class = "glyphicon glyphicon"></i> Index / Espace Membre </a>
                        </p>
						
						
                    <h2></br> Affichage de mon identité </br> Possibilité d'ajouter des détails sur mon identité intellectuelle</h2>
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
                        /*
						$config = (require 'config.php');
						$conn = new PDO($config['DB_HOST'], $config['DB_USER'], $config['DB_PASS'], [$config['DB_OPT']]);
                        $query= $conn->prepare("SELECT * FROM users WHERE users_id = ?");
                        $query->execute(array($_SESSION['id']));
                        $donnees=$query->fetchAll();
                        extract($donnees['0'])
						*/
						
						$stmt = '
							SELECT membre.pseudo, profil.desc_1
							FROM membre 
							INNER JOIN profil 
							ON membre.profil_id = profil.profil_id
							WHERE membre.membre_id = ?
							';
						$exe = [$_SESSION['id']];
						$sql = requete($stmt, $exe);
						//print_r($sql); // ___ VISU SQL ___
						extract($sql['0']);
						
                        ?>

						<p>Bienvenue dans votre espace identité, <b><?php echo $pseudo . ' ! '; ?></b>.<br> Voici votre description :</p>
						<p><b><?php echo $desc_1; ?></b></p>
						<p></br></br></br></br>
						<a class = "btn btn-sm btn-primary" href = "index_identite_modifier.php"> &laquo;  <i class = "glyphicon glyphicon-edit"></i> Modifier mon identité </a>	
                        </p>
						
						
						<p></br></br></br></br>
                        </p>
						
						
                        <p></br></br></br></br>
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