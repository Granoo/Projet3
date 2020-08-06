<?php
session_start();

$bdd = new PDO('mysql:host=localhost;dbname=gbaf','root','');

if(isset($_POST['formconnexion']))
{
    $username = htmlspecialchars($_POST['username']);
    $pass = sha1($_POST['pass']);
    if(!empty($username) AND !empty($pass))
    {
        $requser = $bdd -> prepare("SELECT * FROM visiteurs WHERE pseudo = ? AND password = ?");
        $requser ->execute(array ($username, $pass));
        $userexist = $requser->rowCount();
        if ($userexist == 1)
        {
            $userinfo = $requser->fetch();
            $_SESSION['id'] = $userinfo['id'];
            $_SESSION['nom'] = $userinfo['nom'];
            $_SESSION['prenom'] = $userinfo['prenom'];
            $_SESSION['pseudo'] = $userinfo['pseudo'];
            header("Location: page_presentation.php?id=".$_SESSION['id']);
        }
        else
        {
            $erreur = "Nom d'utilisateur ou mot de passe incorrect";
        }
    }
    else
    {
        $erreur = "Tous les champs doivents être complétés !";
    }
}

?>


<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8"/>
		<link rel="stylesheet" href="style.css"/>
		<link rel="shortcut icon" href="img/gbaf.png" type="image/x-icon">
		<title>GBAF | Connexion</title>
	</head>

	<body>
        
        <header class="header_form">
            <a href="#"><img class="logo" src="img/gbaf.png" alt="logo de GBAF" /></a>
            <h1>Le Groupement Banque Assurance Français</h1>
        </header>
                
	<main>
    	<section class="form">
        	<h1>Connectez-vous</h1>
        	<form method="post" action="#">

            <p><label for="username">Nom d'utilisateur : </label><br /><input type="text" name="username" id="username" value="" /></p>

            <p><label for="pass">Mot de passe : </label><br /><input type="password" name="pass" id="pass" /></p>
            <p class="error"></p>

            <p><input type="submit" name="formconnexion" value="Se connecter" /></p>
        	</form>

            <?php
            if(isset($erreur))
            {
                echo '<font color="red">'.$erreur.'</font>';
            }
            ?>

        	<p>Pas encore de compte ? <a href="page_inscription.php">Inscrivez-vous !</a></p>
        	<p>Mot de passe oublié ? <a href="#">Créer un nouveau mot de passe</a></p>
    	</section>
	</main>

        <footer>
            <p><a href="#">Mentions légales</a> | <a href="#">Contact</a></p>
        </footer>
    </body>
</html>