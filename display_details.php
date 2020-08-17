<!--NOTES PROVISOIRE-->
<div id="conteneur_acteur">
                    <div class="acteur">
                        <div class="presentation_acteur">
                                <?php $reponse=$bdd->query('SELECT * FROM acteur');
                                while ($donnees = $reponse->fetch())
                                {   ?>

                                <figure>
                                <img class="logo_acteur" src="img/<?php echo $donnees['logo']; ?>" alt="logo_acteur">
                                </figure>
                        <p><div class="description"><?php echo $donnees['acteur'];?></div> <br>
                        <a class="button" href="display_details.php?idacteur=<?php echo $donnees['id_acteur']; ?>">Lire la suite</a>
                        </p>
                        </div>
                    </div>
                </div>