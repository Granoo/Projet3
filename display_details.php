<?php
session_start();

try
{
    // On se connecte à MySQL
    $bdd = new PDO('mysql:host=localhost;dbname=gbaf;charset=utf8', 'root', '');
}
catch(Exception $e)
{
    // En cas d'erreur, on affiche un message et on arrête tout
        die('Erreur : '.$e->getMessage());
}


?>

<!DOCTYPE html>
<html langue="fr">
    <head>
        <meta http-equiv="Content-Type" content="text/html"; charset="utf-8" />
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
           <h2></h2>
               <?php
                $req = $bdd->prepare('SELECT * FROM acteur WHERE id_acteur = ?');
                $req->execute(array($_GET['idacteur']));
                $donnees=$req->fetch();
                ?>
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

            <!-- Affichage de la partie commentaire-->

            <br />
            <h2>Commentaires:</h2>
            <form method="POST">
                <input type="text" name="pseudo" placeholder="Votre pseudo" /><br />
                <textarea name="commentaire" placeholder="Votre commentaire..."></textarea><br />
                <input type="submit" value="Poster mon commentaire" name="submit_commentaire" />
            </form>
            <?php if(isset($c_msg)) { echo $c_msg; } ?>
            <br /><br />
            <!--<?php //while($c = $commentaires->fetch()) { ?>
                <b><?= $c['pseudo'] ?>:</b> <?= $c['commentaire'] ?><br />-->
            
            
            
            
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

            <!--Fonctions de chargement des commentaires A REVOIR-->

    <?php
    function commentaires($url, $id_commentaire=0)
    {
        global $db;
    
        $i=0;
        $commentaires = '';
        $tcolor = ['blue','green','orange','purple','gray','red'];
        
        $sql = "SELECT id_commentaire, nom, commentaire, email, date FROM p3x_commentaire WHERE actif='y' AND url=".$db->quote($url);
        if($id_commentaire!=0){ $sql .= " AND id_sous_commentaire=".$id_commentaire; }else{ $sql .= " AND id_sous_commentaire=0"; }
        $sql .= " ORDER BY id_sous_commentaire, date";
        
        foreach($db->query($sql) as $data) {
            $i++;
            mt_srand(crc32($data['email']));
            
            $commentaires .= '<div class="box-light">';
                
                if($i==1 && $id_commentaire==0)
                {
                    $sql2 = "SELECT COUNT(id_commentaire) FROM p3x_commentaire WHERE actif='y' AND url=".$db->quote($url);
                    $query = $db->prepare($sql2); 
                    $query->execute(); 
                    $row = $query->fetch();
                    $count = $row[0];
                    $nb = $count;
                    $s='s';
                    
                    if($count==1){ $nb = 'Un'; }
                    
                    $commentaires .= '<h2>'.$nb.' commentaire'.$s.'</h2>';
                }
                
                $commentaires .= '<div class="separator"></div>
                                    <div class="box-light">
                                        <div class="letter '.$tcolor[mt_rand(0, count($tcolor) - 1)].'">'.htmlentities(substr($data['nom'], 0, 1)).'</div>
                                        <p class="chapeau">@'.htmlentities($data['nom']).' <span class="gray">'.$data['date'].'</span></p>
                                        <p>'.htmlentities($data['commentaire']).'</p>
                                        <form id="comform-'.$data['id_commentaire'].'" method="post" action="'.$url.'">
                                            <input name="action" value="poster-commentaire" type="hidden">
                                            <input name="email" class="hidden" type="text">
                                            <input name="id_sous_commentaire" value="'.$data['id_commentaire'].'" type="hidden">
                                            <div id="comform-div-'.$data['id_commentaire'].'" class="comform-div hidden">
                                                <p>Réponse à @'.htmlentities($data['nom']).'<br><textarea name="commentaire"></textarea></p>
                                                <p>Nom<br><input name="nom" type="text"></p>
                                                <p>Adresse e-mail<br><input name="emailtrue" type="text"></p>
                                            </div>
                                            <div class="clear"></div>
                                            <p><a class="repondre" data-rel="'.$data['id_commentaire'].'" href="#">Répondre</a></p>
                                            <div class="clear"></div>
                                        </form>
                                    </div>';
                
                $commentaires .= commentaires($url, $data['id_commentaire']);
                
            $commentaires .= '</div>';
        }
        
        return $commentaires;
    } ?>

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
    </body>

    <footer>
            <p><a href="#">Mentions légales</a> | <a href="#">Contact</a></p>
    </footer>
</html>
<?php
}
?>