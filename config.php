<?php
	//on démarre la session
	session_start();

    //information de connexion à la base de données
    $host = "localhost"; //adresse du serveur MySQL;
    $user = "root"; //nom d'utilisateur
	$password = ""; //mot de passe
	$database = "prweb"; //nom de la base de données
	
	//connexion au serveur MySQL
	$cnx = new PDO("mysql:host=$host;dbname=$database","$user","$password") or die('Erreur de connexion ');
	
	
?>