<?php
$bdd = new PDO('mysql:host=localhost;dbname=gbaf','root','');

if (isset ($_POST['forminscription']))
{
	$nom = htmlspecialchars($_POST['nom']);
    $prenom = htmlspecialchars($_POST['prenom']);
    $pseudo = htmlspecialchars($_POST['pseudo']);
    $password = sha1($_POST['password']);
    $question = htmlspecialchars($_POST['question']);
    $reponse = htmlspecialchars($_POST['reponse']);
    $pass_hache = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hachage du mot de passe

	if (!empty($_POST['nom']) AND !empty($_POST['prenom']) AND !empty($_POST['pseudo']) AND !empty($_POST['password']) AND !empty($_POST['question']) AND !empty($_POST['reponse']))
	{
        $pseudolength = strlen($pseudo);
        if ($pseudolength <= 255)
        {
        	$insertmbr = $bdd->prepare("INSERT INTO visiteurs(nom, prenom, pseudo, password, question, reponse) VALUES(?,?,?,?,?,?)");
        	$insertmbr->execute(array($nom, $prenom, $pseudo, $password, $question, $reponse));
        	$erreur = "Votre compte a bien été créer ! <a href=\"GBAF.php\">Me connecter</a>";
        }
        else
        {
        	$erreur = "Votre pseudo ne doit pas dépasser 255 caractères !";
        }
	}
	else
	{
		$erreur = "Tous les champs doivent être complétés !";
	}
}
?>


<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8"/>
		<link rel="stylesheet" href="style.css"/>
		<link rel="shortcut icon" href="img/gbaf.png" type="image/x-icon">
		<title>GBAF | Inscription</title>
	</head>

	<body>
        
        <header class="header_form">
            <a href="#"><img class="logo" src="img/gbaf.png" alt="logo de GBAF" /></a>
            <h1>Le Groupement Banque Assurance Français</h1>
        </header>
                
	<main>
    	<section class="form">
        	<h1>Inscription</h1>
        	<form method="post" action="#">

            <div><label for="nom">Nom <span class="required">*</span>  : </label>
            <input type="text" id="nom" name="nom"></div>
                
                
            <div><label for="prenom">Prénom <span class="required">*</span>  : </label>
            <input type="text" id="prenom" name="prenom"></div>
                
                
            <div><label for="pseudo">Pseudonyme <span class="required">*</span>  : </label>
            <input type="text" id="pseudo" name="pseudo" ></div>
                
                
            <div><label for="password">Mot de passe <span class="required">*</span>  : </label>
            <input type="password" id="password" name="password"></div>
                
                
            <div><label for="question">Question secrête <span class="required">*</span>  : </label>
            <input type="text" id="question" name="question"></div>
                
                
            <div><label for="reponse">Réponse secrête <span class="required">*</span>  : </label>
            <input type="text" id="reponse" name="reponse"></div>

            <p><input type="submit" name="forminscription" value="Valider" /></p>
        	</form>
            
            <?php
            if(isset($erreur))
            {
            	echo '<font color="red">'.$erreur.'</font>';
            }
            ?>

        	<p>Vous êtes déjà inscrit ? <a href="GBAF.php">Se connecter</a></p>
    	</section>
	</main>

        <footer>
            <p><a href="#">Mentions légales</a> | <a href="#">Contact</a></p>
        </footer>
    </body>
</html>