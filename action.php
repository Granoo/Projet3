<!-- Système de likes et dislikes -->

   <?php
   $bdd = new PDO('mysql:host=localhost;dbname=gbaf','root','');

   checkConnect();
   $id = str_secur($_GET['id']);
   $value  = str_secur($_GET['value']);

// Redirection si l'utilisateur à déjà Like ou Dislike l'acteur
    $voted = countWhereAnd('countVote', 'vote', 'id_acteur', 'id_user', $id, $_SESSION['id']);
    if($voted['countVote'] != 0){
        header('Location: page_presentation.php?id='.$_SESSION['id'] .$id. '#comments');
        exit;
    }
    
// Redirection si l'id de l'acteur n'est pas existant
    $acteur = selectAllWhere('acteur', 'id_acteur', $id);
    if($acteur === false){
        header('erreur ');
    }

  // Insert la valeur (1 = Like | 2 = Dislike) si elle est comprise entre 0 et 3
    if($value < 3 && $value > 0){
        $insertValue = $db->prepare('INSERT INTO vote(id_user, id_acteur, vote) VALUES(?, ?, ?)');
        $insertValue->execute([$_SESSION['id'], $id, $value]);

        header('Location: page_presentation.php?id='.$_SESSION['id'] .$id. '#comments');
        exit;
    }