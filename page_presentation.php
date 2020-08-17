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

        <p>Le GBAF est le représentant de la profession bancaire et des assureurs sur tous  les axes de la réglementation financière française. Sa mission est de promouvoir  l'activité bancaire à l’échelle nationale. C’est aussi un interlocuteur privilégié des pouvoirs publics.  </p><br/>
        <h2>Présentation des acteurs</h2>
    	</section>

    	<!--Présentation des acteurs-->

        <?php $reponse=$bdd->query('SELECT * FROM acteur');
                                while ($donnees = $reponse->fetch())
                                {   ?><section id="acteur">
           
                <div id="conteneur_acteur">
                    <div class="acteur">
                        <div class="presentation_acteur">
                                <figure>
                                <img class="logo_acteur" src="img/<?php echo $donnees['logo']; ?>" alt="logo_acteur">
                                </figure>
                        <div class="description"><h3><?php echo $donnees['acteur'];?></h3></div>
                        </div>
                        <a class="button" href="display_details.php?idacteur=<?php echo $donnees['id_acteur']; ?>">Lire la suite</a>
                    </div>
                </div>
        </section>

                <?php } ?>
                

        <!-- PHP de la partie commentaire-->

        <?php
            if(isset($_GET['id']) AND !empty($_GET['id'])) {
                $getid = htmlspecialchars($_GET['id']);
                $acteur = $bdd->prepare('SELECT * FROM acteur WHERE id = ?');
                $acteur->execute(array($getid));
                $acteur = $acteur->fetch();
                if(isset($_POST['submit_commentaire'])) {
                    if(isset($_POST['pseudo'],$_POST['commentaire']) AND !empty($_POST['pseudo']) AND !empty($_POST['commentaire'])) {
                        $pseudo = htmlspecialchars($_POST['pseudo']);
                        $commentaire = htmlspecialchars($_POST['commentaire']);
                        if(strlen($pseudo) < 25) {
                        $ins = $bdd->prepare('INSERT INTO post (id_user, id_acteur, date_add, post) VALUES (?,?,NOW(),?)');
                        $ins->execute(array($pseudo,$commentaire,$getid));
                        $c_msg = "<span style='color:green'>Votre commentaire a bien été posté</span>";
                    } else {
                        $c_msg = "Erreur: Le pseudo doit faire moins de 25 caractères";
                    }
                } else {
                    $c_msg = "Erreur: Tous les champs doivent être complétés";
                }
            }
            $commentaires = $bdd->prepare('SELECT * FROM post WHERE id_acteur = ? ORDER BY id DESC');
            $commentaires->execute(array($getid));
        ?>

        <!-- Affichage de la partie commentaire-->

            <p><?= $acteur['contenu'] ?></p>
            <br />
            <h2>Commentaires:</h2>
            <form method="POST">
                <input type="text" name="pseudo" placeholder="Votre pseudo" /><br />
                <textarea name="commentaire" placeholder="Votre commentaire..."></textarea><br />
                <input type="submit" value="Poster mon commentaire" name="submit_commentaire" />
            </form>
            <?php if(isset($c_msg)) { echo $c_msg; } ?>
            <br /><br />
            <?php while($c = $commentaires->fetch()) { ?>
                <b><?= $c['pseudo'] ?>:</b> <?= $c['commentaire'] ?><br />
            <?php } ?>
            <?php
            }
            ?>


        <!-- Système de likes et dislikes A FINALISER 
            <?php
        if(isset($_GET['id']) AND !empty($_GET['id'])) {
            $get_id = htmlspecialchars($_GET['id']);
            $acteur = $bdd->prepare('SELECT * FROM acteur WHERE id_acteur = ?');
            $acteur->execute(array($get_id));
            if($acteur->rowCount() == 1) {
                $acteur = $acteur->fetch();
                $id = $acteur['id_acteur'];
                $titre = $acteur['acteur'];
                $contenu = $acteur['description'];
                $likes = $bdd->prepare('SELECT id_acteur FROM vote WHERE id_acteur = ?');
                $likes->execute(array($id));
                $likes = $likes->rowCount();
                $dislikes = $bdd->prepare('SELECT id_acteur FROM vote WHERE id_acteur = ?');
                $dislikes->execute(array($id));
                $dislikes = $dislikes->rowCount();
            } else {
                die('Cet article n\'existe pas !');
            }
        } else {
            die('Erreur');
        }
        ?>

        <p><a href="action.php?t=1&id=<?= $id ?>">J'aime</a> (<?= $likes ?>)</p>
        <br />
        <p><a href="action.php?t=2&id=<?= $id ?>">Je n'aime pas</a> (<?= $dislikes ?></p>

        // Compte combien il y a de Likes et des Dislikes à l'acteur
        $like = countWhereAnd('countLike', 'vote', 'id_acteur', 'vote', $id, 1);
        $dislike = countWhereAnd('countDislike', 'vote', 'id_acteur', 'vote', $id, 2);
        A FINALISER -->

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