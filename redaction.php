<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" type="text/css" href="editor\dist\trix.css">
        <script type="text/javascript" src="editor\dist\trix.js"></script>
        <title>Rédaction</title>

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
    } else {
        // il est connecté on recupere ses infos
        $id = $_SESSION['id'];
        $config = (require 'config.php');

        $conn = new PDO($config['DB_HOST'], $config['DB_USER'], $config['DB_PASS']);
        $query = $conn->prepare("SELECT * FROM users WHERE users_id = ?");
        $query->execute(array($id));
        //les donnees sous forme de tableau
        $donnees = $query->fetch();
        ?>
        <?php
        //on verifie si le formulaire a été envoyé
        if (isset($_POST['submit'])) {
            
            
        
            //la variable erreur vaut null par défaut
            $erreur = null;
            //on convertit chaque champ en variable avec la fonction extract()
            extract($_POST);

            //on verifie les champs vides
            if (empty($content) || empty($titre)) {
                $erreur = '<p class = "alert alert-danger">Veuillez remplir tous les champs</p>';
            }

            if ($erreur == null) {


                //tout est OK on enregistre l'utilisateur
                //on crypte le mot de passe 

                $query = $conn->prepare("INSERT INTO messages(users_id, texte, titre) VALUES(?,?, ?)");
                $query->execute(array($donnees['users_id'], $content, $titre));
                $conn = null;

                if ($query) {
                    echo '<p class = "alert alert-success">Enregistré avec succès <a class = "btn btn-sm btn-primary" href = "index.php">Retour</a></p>';
                } else {
                    $erreur = '<p class = "alert alert-danger">Une erreur est survenue lors de la création de votre compte</p>';
                }
            }
        }

        //on affiche le formulaire
        //s'il ya des erreurs alors on les affiche
        if (isset($erreur)) {
            echo $erreur;
        }
        ?>
        
    
        <form action = "redaction.php" method = "post" class = "well">
            <div class = "form-group">
                <label for = "titre">Titre </label>
                <input type = "text" name = "titre" value = "<?php if(isset($titre)){echo "$titre";} else {echo "";} ?>" class = "form-control  input-sm">
            </div>
            <input id="x" name="content" value="<?php if(isset($content)){echo "$content"; }else { echo "";} ?>" type="hidden" name="content">
         
            <trix-editor input="x"></trix-editor>
            


            <div class = "form-group">
                <input type = "submit" name = "submit" value = "Valider">
            </div>
        </form>
        <?php
    }
    ?>


</html>
