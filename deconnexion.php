<?php
	
	//on supprime les variables de session
        session_start();
        $_SESSION=[];
	
	//on supprime les données de session
	
	
	//on redirige l'utilisateur sur la page d'accueil
	header('location:index.php');
?>