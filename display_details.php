<?php
session_start();

$bdd = new PDO('mysql:host=localhost;dbname=gbaf','root','');

?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8"/>
		<link rel="stylesheet" href="style.css"/>
		<link rel="shortcut icon" href="img/gbaf.png" type="image/x-icon">
		<title>GBAF | Acteurs</title>
	</head>

	<body>
        <header class="header_form">
            <a href="#"><img class="logo" src="img/gbaf.png" alt="logo de GBAF" /></a>    
            
            <!--Recupération du nom et prénom de l'utilisateur avec option de mofication ou deconnexion-->
                <?php
                if(isset($_SESSION['id']))
                {
                ?><br/>
                <div class="container-user">
                <a href="user_settings.php"><p>👦 <?php echo $_SESSION['nom'] ?> <?php echo $_SESSION['prenom']?></p></a>
                <a href="deconnexion.php">↪ Se déconnecter</a>
                </div>
                <?php
                }
                ?>
        </header>

            <!-- Affichage des données de l'acteur -->

    <section id="acteur">
           <h2><?= $donnees['acteur'] ?></h2>
               <?php $reponse=$bdd->query('SELECT * FROM acteur');
                                while ($donnees = $reponse->fetch())
                                {   ?>

                <div id="conteneur_acteur">
                    <div class="acteur">
                        <div class="presentation_acteur">
    

                                <figure>
                                <img class="logo_acteur" src="img/<?php echo $donnees['logo']; ?>" alt="logo_acteur">
                                </figure>
                                <h2><?= $donnees['acteur'] ?></h2>
                                <p><?= $donnees['description'] ?></p>
                        
                        </div>
                    </div>
                </div>

        </section>
    </body>

    <footer>
            <p><a href="#">Mentions légales</a> | <a href="#">Contact</a></p>
    </footer>
</html>
<?php
}
?>
