<?php
	//inclusion de fichier de configuration
	
	session_start();
	
                  print_r($_SESSION);
				  
	if(!isset($_SESSION['id']) || !isset($_SESSION['pseudo'])){
		//l'utilisateur n'est pas connecté on le redirige sur la page de connexion
		header('location:connexion.php');
	}
	
	//on verifie si l'id de existe 
	if(isset($_GET['id'])){
		//l'id de l'utilisateur n'existe pas on le redirige sur la page des membres
		header('location:index.php');
	}
	
	
                        // il est connecté on recupere ses infos
                        
						$config = (require 'config.php');
						$conn = new PDO($config['DB_HOST'], $config['DB_USER'], $config['DB_PASS'], [$config['DB_OPT']]);
                        $query= $conn->prepare("SELECT * FROM users WHERE users_id = ?");
                        $query->execute(array($_SESSION['id']));
                        $donnees=$query->fetchAll();
                        extract($donnees['0']);
						

	
/*
	else{
		$id = mysql_real_escape_string($_GET['id']);
		$sql = mysql_query("SELECT * FROM users WHERE users_id = '$id'") or die('Erreur de la requête SQL');
		//les donnees sous forme de tableau
		$donnees = mysql_fetch_array($sql);
		if(empty($donnees)){
			//Cet utilisateur n'existe pas on le redirige sur la page des membres
			header('location:membres.php');
		}
	}
*/

	
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
		<div class "row">
			<div class = "col-lg-offset-3 col-lg-6 col-lg-offset-3 well">
				<h2>Profil </br> Données de la table "compte" ou "membre"</h2>
				
				<p>Voici vos informations : </p>
				<p>Pseudo : <b><?php echo $pseudo;?></b></p>
				<p>Nom : <b><?php echo $nom;?></b></p>
				<p>Prénom : <b><?php echo $prenom;?></b></p>
				<p>Sexe : <b><?php echo $sexe;?></b></p>
				
				<p></br></br></br></br>	
				<a class = "btn btn-sm btn-success" href = "modifier.php"><i class = "glyphicon glyphicon-edit"></i> Modifier votre profil</a>
				</p>
							 
				 <p></br></br></br></br>
				 <a class = "btn btn-sm btn-default" href = "index.php"> &laquo;  <i class = "glyphicon glyphicon-user"></i> Votre espace membre</a>
				 </p>
				 
				 <p>
				 </br>
					Ci dessous les liens concernant tout ce qui a attrait au compte et paramètres
					</br>
					<a class = "btn btn-sm btn-default" href = "deconnexion.php"><i class = "glyphicon glyphicon-off"></i> Déconnexion</a>
				 </p>
				 
			</div>
		</div>
	</div>
	<!-- Bibliothèque JavaScript jquery -->
	<script src="bootstrap/js/jquery.min.js"></script>
	
	<!--  JavaScript de Bootstrap -->
	<script src="bootstrap/js/bootstrap.min.js"></script>
  </body>
  
</html>