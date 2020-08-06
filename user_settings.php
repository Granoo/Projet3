<?php
session_start();

$bdd = new PDO('mysql:host=localhost;dbname=gbaf','root','');

if (isset($_SESSION['id']) )
{
    $requser = $bdd->prepare("SELECT * FROM visiteurs WHERE id=?");
    $requser -> execute(array($_SESSION['id']));
    $user = $requser->fetch();

    if(isset($_POST['newpseudo']) AND !empty($_POST['newpseudo']) AND $_POST['newpseudo'] != $user['pseudo'])
    {
        $newpseudo = htmlspecialchars($_POST['newpseudo']);
        $insertpseudo= $bdd->prepare("UPDATE visiteurs SET pseudo = ? WHERE id=?");
        $insertpseudo->execute(array($newpseudo, $_SESSION['id']));
        header('Location: page_presentation.php?id='.$_SESSION['id']);
    }

    if(isset($_POST['newnom']) AND !empty($_POST['newnom']) AND $_POST['newnom'] != $user['nom'])
    {
        $newnom = htmlspecialchars($_POST['newnom']);
        $insertnom= $bdd->prepare("UPDATE visiteurs SET nom = ? WHERE id=?");
        $insertnom->execute(array($newnom, $_SESSION['id']));
        header('Location: page_presentation.php?id='.$_SESSION['id']);
    }

    if(isset($_POST['newprenom']) AND !empty($_POST['newprenom']) AND $_POST['newprenom'] != $user['prenom'])
    {
        $newprenom = htmlspecialchars($_POST['newprenom']);
        $insertprenom= $bdd->prepare("UPDATE visiteurs SET prenom = ? WHERE id=?");
        $insertprenom->execute(array($newprenom, $_SESSION['id']));
        header('Location: page_presentation.php?id='.$_SESSION['id']);
    }

    if(isset($_POST['newquestion']) AND !empty($_POST['newquestion']) AND $_POST['newquestion'] != $user['question'])
    {
        $newquestion = htmlspecialchars($_POST['newquestion']);
        $insertquestion= $bdd->prepare("UPDATE visiteurs SET question = ? WHERE id=?");
        $insertquestion->execute(array($newquestion, $_SESSION['id']));
        header('Location: page_presentation.php?id='.$_SESSION['id']);
    }

    if(isset($_POST['newreponse']) AND !empty($_POST['newreponse']) AND $_POST['newreponse'] != $user['reponse'])
    {
        $newreponse = htmlspecialchars($_POST['newreponse']);
        $insertreponse= $bdd->prepare("UPDATE visiteurs SET reponse = ? WHERE id=?");
        $insertreponse->execute(array($newreponse, $_SESSION['id']));
        header('Location: page_presentation.php?id='.$_SESSION['id']);
    }

    if(isset($_POST['newmdp1']) AND !empty($_POST['newmdp1']) AND isset($_POST['newmdp2']) AND !empty($_POST['newmdp2']))
    {
        $mdp1 = sha1($_POST['newmdp1']);
        $mdp2 = sha1($_POST['newmdp2']);

        if ($mdp1 == $mdp2)
        {
            $insetmdp=  $bdd->prepare("UPDATE visiteurs SET password = ? WHERE id= ?");
            $insertmdp-> execute(array($mdp1, $_SESSION['id']));
            header('Location: page_presentation.php?id='.$_SESSION['id']);
        }
        else
        {
            $msg= "Vos deux mots de passe ne correspondent pas !";
        }
    }

    if (isset($_POST['newpseudo']) AND $_POST['newpseudo'] == $user['pseudo'])
    {
        header('Location: page_presentation.php?id='.$_SESSION['id']);
    }
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8"/>
        <link rel="stylesheet" href="style.css"/>
        <link rel="shortcut icon" href="img/gbaf.png" type="image/x-icon">
        <title>GBAF | Edition du profil</title>
    </head>

    <body>
        <header class="header_form">
            <a href="#"><img class="logo" src="img/gbaf.png" alt="logo de GBAF" /></a>    
            
            <!--Recupération du nom et prénom de l'utilisateur avec option de mofication ou deconnexion-->
                <?php
                if(isset($_SESSION['id']))
                {
                    echo 'Bonjour ton id est le ' . $_SESSION['id'] . ' et ton pseudo est ' . $_SESSION['pseudo'] . ' et ton mot de passe est ' . $_POST['password'];
                ?>
                <div class="container-user">
                <a href="user_settings.php"><p>👦 <?php echo $_SESSION['nom'] ?> <?php echo $_SESSION['prenom']?></p></a>
                <a href="deconnexion.php">↪ Se déconnecter</a>
                </div>
                <?php
                }
                // var_dump($userinfo['id']); /**/
                ?>
        </header>
        
        <main>
            <section id="Presentation">
            <h1>Edition du profil !</h1>
            <div align="center"><br/>
                    <form method="POST" action="">
                        <label>Pseudo :</label>
                        <input type="texte" name="newpseudo" placeholder="pseudo" value="<?php echo $user['pseudo'];?>"/><br /><br />
                        <label>Mot de passe :</label>
                        <input type="text" name="newmdp1" placeholder="mot de passe" value="<?php echo $user['password'];?>"/><br /><br />
                        <!-- <label>Confirmation du mot de passe :</label>
                        <input type="text" name="newmdp2" placeholder="confirmation mot de passe"/><br /><br /> -->
                        <label>Nom :</label>
                        <input type="texte" name="newnom" placeholder="nom" value="<?php echo $user['nom'];?>"/><br /><br />
                        <label>Prénom :</label>
                        <input type="texte" name="newprenom" placeholder="prenom" value="<?php echo $user['prenom'];?>"/><br /><br />
                        <label>Question :</label>
                        <input type="texte" name="newquestion" placeholder="question" value="<?php echo $user['question'];?>"/><br /><br />
                        <label>Réponse :</label>
                        <input type="texte" name="newreponse" placeholder="reponse" value="<?php echo $user['reponse'];?>"/><br /><br /><br/>
                        <input type="submit" value="Mettre à jour" /> <br/><br/><br/>
                    </form>
                    <?php if (isset($msg)) {echo $msg;}?>
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
else
{
    header("Location: GBAF.php");
}
?>