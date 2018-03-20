<?php
	session_start();
		/*
			on verifie si l'utilisateur est connecté 
		*/
		if(!isset($_SESSION['id']) || !isset($_SESSION['pseudo'])){
			//l'utilisateur n'est pas connecté on le redirige sur la page de connexion
			header('location:connexion.php');
		}
		else{
			// il est connecté on recupere ses infos
                        
									
			$config = (require 'config.php');
			$conn = new PDO($config['DB_HOST'], $config['DB_USER'], $config['DB_PASS'], [$config['DB_OPT']]);

			$query= $conn->prepare("SELECT * FROM users WHERE users_id = ?");
			$id = $_SESSION['id'];                       
			$query->execute(array($id));
                        //les donnees sous forme de tableau
			$donnees = $query->fetch();
                        
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
				//on verifie si le formulaire a été envoyé
				if(isset($_POST['submit'])){
					//la variable erreur vaut null par défaut
					$erreur = null;
					//on convertit chaque champ en variable avec la fonction extract()
					extract($_POST);
					
					//on verifie les champs vides
					if(empty($pseudo)){
						$erreur = '<p class = "alert alert-danger">Veuillez remplir tous les champs</p>';
					}
					
					//on verifie si le pseudo existe déja
					$query=$conn->prepare("SELECT * FROM users WHERE pseudo = ? AND users_id != ?") ;
					$query->execute(array($pseudo,$donnees['users_id']));
					$res=$query->fetchAll();
					if(count($res) != 0){
						//ce membre existe déja
						$erreur = '<p class = "alert alert-danger">Ce pseudo existe déjà veuillez choisir un autre pseudo</p>';
					}
					
					

					
					if($erreur == null){
						//tout est OK on fait la mise à jours de l'utilisateur
						/* si le mot de passe est saisi on change dans le cas contraire
							on garde l'ancien mot de passe 
						*/					
						if(empty($password)){
							$password = $donnees['password'];
						}
						else{
							//on crypte le mot de passe 
							$password = md5($password);
						}
						$query=$conn->prepare("UPDATE users SET pseudo = ?, password = ? WHERE 	id = ?") ;
                                                $query->execute(array($pseudo,$password,$donnees['id']));
						
							//on le redirige sur la page d'accueil
							header('location:index.php');
						
						
					}
					
				}
				
				//on affiche le formulaire
				//s'il ya des erreurs alors on les affiche
				if(isset($erreur)){
					echo $erreur;
				}
				?>
				<div class "row">
					<div class = "col-lg-offset-4 col-lg-4 col-lg-offset-4">
						<form action = "modifier.php" method = "post" class = "well">
							<h4 class = "head">Modification de votre compte </br> Modification de la table "identite" ou "profil (arthus)"</h4>
							<div class = "form-group">
								<label for = "pseudo">Choisissez avec le menu défilant un des titres à modifier : </label>
								<input type = "text" name = "pseudo" value = "menu défilant à mettre" class = "form-control input-sm">
							</div>
							<div class = "form-group">
								<label for = "texte">L'ancien texte s'affiche par défaut, et libre à l'utilisateur de mettre à jour</label>
								<input type = "texte" name = "texte" value = "ici le texte que j'avais écrit" class = "form-control  input-sm">
							</div>
							
							
							<div class = "form-group">
								<input type = "submit" name = "submit" value = "Valider" class = "btn btn-sm btn-primary btn-block">
							</div>
                                                        <a class = "btn btn-sm btn-primary" href = "index.php">Retour</a>
                                                         
						</form>
					</div>
				</div>
                       
		<?php	
			}
		?>		
		</div>
	<!-- Bibliothèque JavaScript jquery -->
    <script src="bootstrap/js/jquery.min.js"></script>
    
	<!--  JavaScript de Bootstrap -->
	<script src="bootstrap/js/bootstrap.min.js"></script>
  </body>
</html>