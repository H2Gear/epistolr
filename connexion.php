<?php
	session_start();
	//on verifie si le formulaire a été envoyé
	if(isset($_POST['submit'])){
		//la variable erreur vaut null par défaut
		$erreur = null;
		//on convertit chaque champ en variable avec la fonction extract()
		extract($_POST);
		
		//on verifie les champs vides
		if(empty($pseudo) || empty($password)){
			$erreur = '<p class = "alert alert-danger">Veuillez remplir tous les champs</p>';
		}
		
		//on verifie si le pseudo existe déja
                $config=(require 'config.php');
                
                $conn=new PDO($config['DB_HOST'],$config['DB_USER'],$config['DB_PASS']);
		$query = $conn->prepare("SELECT * FROM users WHERE pseudo = ?");
		$query->execute(array($pseudo));
                $rows=$query->fetchAll();
                
		if(count($rows) != 1){
			//ce membre n'existe pas
			$erreur = '<p class = "alert alert-danger">Ce pseudo n\'existe pas dans notre base de donn�es</p>';
		}
		else{
			/*
				on verifie si le mot de passe est correct
				tout d'abord pour comparer le mot de passe avec celui dans la table 
				il faut le crypter avant en utilisant la fonction md5() 
			*/
			$password = md5($password);
			
			
                if($rows[0]['password'] !== $password){
				//le mot de passe est incorrect
				$erreur = '<p class = "alert alert-danger">Votre mot de passe est incorrect</p>';
			}
			else{
				//tout est bon on enregistre les données de l'utilisateur en session
				
                                $_SESSION['pseudo'] = $pseudo;
				$_SESSION['id'] = $rows[0]['users_id'];
				//on le redirige sur la page d'accueil
                                $conn=null;
                               
				header('location:index.php');
			}
			
		}		
	}
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
			
			//on affiche le formulaire
			//s'il ya des erreurs alors on les affiche
			if(isset($erreur)){
				echo $erreur;
			}
			?>
			<div class "row">
				<div class = "col-lg-offset-4 col-lg-4 col-lg-offset-4">
					<form action = "connexion.php" method = "post" class = "well">
						<h4 class = "head">Connexion à votre compte</h4>
						<div class = "form-group">
							<label for = "pseudo">Pseudo : </label>
							<input type = "text" name = "pseudo" value = "" class = "form-control input-sm">
						</div>
						<div class = "form-group">
							<label for = "password">Mot de passe : </label>
							<input type = "password" name = "password" value = "" class = "form-control  input-sm">
						</div>
						<div class = "form-group">
							<input type = "submit" name = "submit" value = "Valider" class = "btn btn-sm btn-primary btn-block">
						</div>
					</form>
				</div>
			</div>
				
	</div>
	<!-- Bibliothèque JavaScript jquery -->
    <script src="bootstrap/js/jquery.min.js"></script>
    
	<!--  JavaScript de Bootstrap -->
	<script src="bootstrap/js/bootstrap.min.js"></script>
  </body>
</html>