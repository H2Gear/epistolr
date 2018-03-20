<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" type="text/css" href="editor\dist\trix.css">
        <script type="text/javascript" src="editor\dist\trix.js"></script>
        <title>Mes correspondances</title>

        <!-- CSS de Bootstrap -->
        <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <!-- Notre style CSS  -->
        <link href="bootstrap/css/style.css" rel="stylesheet">
		
		
						<?php include 'fonctions.php'; ?>

    </head>
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

    if (!isset($_SESSION['id']) || !isset($_SESSION['pseudo'])) 
	{
        //l'utilisateur n'est pas connecté
        echo '<p>Vous n\'etes pas encore connecté(e)
		<a class = "btn btn-sm btn-primary" href = "connexion.php"><i class = "glyphicon glyphicon-off"></i> Connexion</a> ou
		<a class = "btn btn-sm btn-success" href = "inscription.php"><i class = "glyphicon glyphicon-user"></i> Créer votre compte</a>
		</p>';
    } 
	else 
	{
		// ___ RECHERCHE DES CORRESPONDANCES ___
		
        $config = (require 'config.php');
        $conn = new PDO($config['DB_HOST'], $config['DB_USER'], $config['DB_PASS']);
        $query = $conn->prepare("
			SELECT *
			FROM membre
			WHERE membre_id = ?
			FULL JOIN theme ON correspondance.theme_id = theme.theme_id
			");
		$query->execute(array($_SESSION['id']));
		
        $donnees = $query->fetchAll();
		
        ?>
     
    
		<body>
			<div class = "container"><br />
				<div class "row">
					 <div class = "col-lg-offset-3 col-lg-6 col-lg-offset-3 well">
						<a class = "btn btn-sm btn-primary" href = "index.php">Retour</a>
						<h1>Toutes mes correspondances... </h1>
						<table>
							<?php
							
							
								
							$stmt = '
							
								SELECT correspondance.correspondance_id, theme.sujet, membre.pseudo, membre2.pseudo correspondant
								FROM correspondance
								
								INNER JOIN theme
								ON correspondance.theme_id = theme.theme_id
								INNER JOIN auteurs
								ON correspondance.auteurs_id = auteurs.auteurs_id
								INNER JOIN membre
								ON auteurs.membre_1_id = membre.membre_id
								INNER JOIN membre membre2
								ON auteurs.membre_2_id = membre2.membre_id								
								
								WHERE auteurs.membre_1_id = ? OR auteurs.membre_2_id = ?
								
								';
							$exe = [$_SESSION['id'],$_SESSION['id']];
							$sql = requete($stmt, $exe);
							print_r($sql); // ___ VISU SQL ___
							//extract($sql['0']);
							
							
							
							
							echo '</br></br>Bonjour <b>' . $sql['0']['pseudo'] . '</b> ! </br>';
							echo 'Ci dessous votre relations en cours (rajouter un bolléen relation en cours)</br></br>';
							
							?>
							
							
							<tr>
								<td>
									N
								</td>
								<td>
									Correspondance_id
								</td>
								<td>
									N
								</td>
								<td>
									Thème
								</td>
								<td>
									N
								</td>
								<td>
									Mon Pseudo
								</td>
								<td>
									N
								</td>
								<td>
									Pseudo Correspondant
								</td>
							</tr>
							<?php
							
							foreach ($sql as $ligne) 
							{
								echo '<tr>';
								foreach ($ligne as $cell) 
								{
									echo '<td>';
										echo $cell;
									echo '</td>';
								}
								echo '</tr>';
							}
							?>
							
						</table>
					</div>
				</div>
			</div>
		</body>
        <?php
    }
    ?>


</html>
