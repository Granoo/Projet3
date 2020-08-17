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
    </body>

    <footer>
            <p><a href="#">Mentions légales</a> | <a href="#">Contact</a></p>
    </footer>
</html>