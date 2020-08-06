<?php
session_start();

$bdd = new PDO('mysql:host=localhost;dbname=gbaf','root','');

if (isset($_GET['id']) AND $_GET['id'] > 0)
{
    $getid = intval($_GET['id']);
    $requser = $bdd->prepare('SELECT * FROM visiteurs WHERE id= ?');
    $requser->execute(array($getid));
    $userinfo = $requser->fetch();

?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8"/>
		<link rel="stylesheet" href="style.css"/>
		<link rel="shortcut icon" href="img/gbaf.png" type="image/x-icon">
		<title>GBAF | Présentation</title>
	</head>

	<body>
        <header class="header_form">
            <a href="#"><img class="logo" src="img/gbaf.png" alt="logo de GBAF" /></a>    
            
            <!--Recupération du nom et prénom de l'utilisateur avec option de mofication ou deconnexion-->
                <?php
                if(isset($_SESSION['id']) AND $userinfo['id'] == $_SESSION['id'])
                {
                ?>
                <div class="container-user">
                <a href="user_settings.php"><p>👦 <?php echo $userinfo['nom'] ?> <?php echo $userinfo['prenom']?></p></a>
                <a href="deconnexion.php">↪ Se déconnecter</a>
            	</div>
                <?php
                }
                ?>
                
        </header>


            <!--Présentation du groupe-->

	<main>
    	<section id="presentation">
        	<h1>Présentation du Groupement Banque Assurance Français</h1>
        	<p>Le Groupement Banque Assurance Français​ (GBAF) est une fédération  représentant les 6 grands groupes français :</p>
                <div class="presentationListActeurs">
                    <ul>
                        <li><span  class="li_content">BNP Paribas ;</span></li>
                        <li><span  class="li_content">BPCE ;</span></li>
                        <li><span  class="li_content">Crédit Agricole ;</span></li>
                    </ul>
                    <ul>
                        <li><span  class="li_content">Crédit Mutuel-CIC ;</span></li>
                        <li><span  class="li_content">Société Générale ;</span></li>
                        <li><span  class="li_content">La Banque Postale.</span></li>
                    </ul>
                </div>

        <p>Le GBAF est le représentant de la profession bancaire et des assureurs sur tous  les axes de la réglementation financière française. Sa mission est de promouvoir  l'activité bancaire à l’échelle nationale. C’est aussi un interlocuteur privilégié des pouvoirs publics.  </p>
    	</section>


    	<!--Présentation des acteurs-->

    	<section id="acteur">
    	   <h2>Présentation des acteurs</h2>
    	       <div id="conteneur_acteur">
                    <div class="acteur">
                        <div class="presentation_acteur">
                            <figure>
                            <img class="logo_acteur" src="img/formation_co.png" alt="logo_acteur">
                            </figure>
                            <figcaption hidden>Logo de Formation&co</figcaption>
                        <div class="description">
                            <h3>FORMATION & CO</h3>
                            <p>Formation & co est une association française présente sur tout le territoire.</p>
                        </div>
                        </div>
                        <a class="button" href="#">Lire la suite</a>   
                    </div>
                </div>

                <div id="conteneur_acteur">
                    <div class="acteur">
                        <div class="presentation_acteur">
                            <figure>
                            <img class="logo_acteur" src="img/protectpeople.png" alt="logo_acteur">
                            </figure>
                            <figcaption hidden>Logo de Protect People</figcaption>
                        <div class="description">
                            <h3>PROTECT PEOPLE</h3>
                            <p>Chez Protect People, chacun cotise selon ses moyens et reçoit selon ses besoins.</p>
                        </div>
                        </div>
                        <a class="button" href="#">Lire la suite</a>   
                    </div>
                </div>

                <div id="conteneur_acteur">
                    <div class="acteur">
                        <div class="presentation_acteur">
                            <figure>
                            <img class="logo_acteur" src="img/Dsa_france.png" alt="logo_acteur">
                            </figure>
                            <figcaption hidden>Logo de Dsa France</figcaption>
                        <div class="description">
                            <h3>DSA FRANCE</h3>
                            <p>Dsa France accélère la croissance du territoire et s'engage avec les collectivités territoriales.</p>
                        </div>
                        </div>
                        <a class="button" href="#">Lire la suite</a>   
                    </div>
                </div>

                <div id="conteneur_acteur">
                    <div class="acteur">
                        <div class="presentation_acteur">
                            <figure>
                            <img class="logo_acteur" src="img/CDE.png" alt="logo_acteur">
                            </figure>
                            <figcaption hidden>Logo de CDE</figcaption>
                        <div class="description">
                            <h3>CHAMBRE DES ENTREPRENEURS CDE</h3>
                            <p>La CDE accompagne les entreprises dans leurs démarches de formation.</p>
                        </div>
                        </div>
                        <a class="button" href="#">Lire la suite</a>   
                    </div>
                </div>

    	</section>
        
	</main>

        <footer>
            <p><a href="#">Mentions légales</a> | <a href="#">Contact</a></p>
        </footer>
    </body>
</html>


<?php
}
?>