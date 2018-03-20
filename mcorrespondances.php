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

    if (!isset($_SESSION['id']) || !isset($_SESSION['pseudo'])) {
        //l'utilisateur n'est pas connecté
        echo '<p>Vous n\'etes pas encore connecté(e)
											<a class = "btn btn-sm btn-primary" href = "connexion.php"><i class = "glyphicon glyphicon-off"></i> Connexion</a> ou
											<a class = "btn btn-sm btn-success" href = "inscription.php"><i class = "glyphicon glyphicon-user"></i> Créer votre compte</a>
											</p>';
    } else 
	{
        // il est connecté on recupere ses infos
        $id = $_SESSION['id'];
        $config = (require 'config.php');

        $conn = new PDO($config['DB_HOST'], $config['DB_USER'], $config['DB_PASS']);
        $query = $conn->prepare("SELECT * FROM users WHERE users_id = ?");
        $query->execute(array($id));
        //les donnees sous forme de tableau
        $donnees = $query->fetch();
        ?>
     
        <?php //on charge le texte si s�lectionn�
        if(isset($_POST['submit'])){
					//la variable erreur vaut null par défaut
					$erreur = null;
					//on convertit chaque champ en variable avec la fonction extract()
					extract($_POST);
					
					//on verifie les champs vides
					if(empty($choix)){
						$erreur = '<p class = "alert alert-danger">Veuillez remplir tous les champs</p>';
					}
					
					//on verifie si le pseudo existe déja
					$query=$conn->prepare("SELECT titre, texte FROM messages WHERE messages_id= ?") ;
                                        $query->execute(array($choix));
					$res=$query->fetch();
                                        
                                        $titre=$res['titre'];
                                        $content=$res['texte'];
        }
        
        
        
    ?>
    
    <body>
        <div class = "container"><br />
            <div class "row">
                 <div class = "col-lg-offset-3 col-lg-6 col-lg-offset-3 well">
					<h1>Ma correspondance avec ...</h1>
					<a class = "btn btn-sm btn-primary" href = "index.php">Retour</a>
					<form action="mcorrespondances.php" method="post" class="well">
						<?php 
						$query = $conn->prepare("SELECT titre, messages_id FROM messages WHERE users_id = ?");
						$query->execute(array($donnees['users_id']));
						$res=$query->fetchAll();
						
						
						for ($i=0;$i<count($res);$i++)
						{
							echo '<input type="radio" name="choix" value="'.$res[$i]['messages_id'].'" id="choix'.$i.'">';
							echo '<label for = "choix'.$i.'">'.$res[$i]['titre'].'</label><br>';
						}
						?>
						<input type = "submit" name = "submit" value = "Valider" class = "btn btn-sm btn-primary btn-block"> 
					</form>	
						
								<h2><?php if(isset($titre)){echo "$titre";} else {echo "";} ?> </h2>
								
							
							<input id="x" name="content" value="<?php if(isset($content)){echo "$content"; }else { echo "";} ?>" type="hidden" name="content">
						 
							<trix-editor input="x"></trix-editor>
                </div>
            </div>
        </div>
    </body>
        <?php
    }
    ?>


</html>
