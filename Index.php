
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr">
  <head>
    <title>TP : Mini jeu de combat</title>
    
    <meta http-equiv="Content-type" content="text/html; charset=iso-8859-1" />
  </head>
  <body>
    <form action="Personnage.php" method="get">
      <p>
        Nom : <input type="text" name="nom" maxlength="50" />
        <input type="submit" value="Créer ce personnage" name="creer" />
        <input type="submit" value="Utiliser ce personnage" name="utiliser" />
      </p>
    </form>

    <fieldset>
        <legend>Mes information</legend>
        <p>
            Nom : <?php echo htmlspecialchars($perso->getNom()); ?> <br/>
            Dégats : <?php echo $perso->getDegat(); ?>
        </p>
    </fieldset>

        <legend>Qui frapper ? </legend>
        <p>
            <?php
            $joueurs = $manager->getList($perso->getNom());

            if (empty($joueurs))
            {
                echo 'Personne à frapper !';
            }

            else 
            {
                foreach ( $joueurs as $joueur)
                {
                    echo ' <a href="?frapper=', $joueur->getId(), '">', htmlspecialchars($joueur->getNom()), '</a> (dégâts :', $joueur->getDegats(), ')<br/>';

                }

            }
            ?>
        </p>
  </body>
</html>

<?php 



if(isset($perso))
{
    $_SESSION['perso'] = $perso;
}


if(isset($_GET['deconnexion']))
{
    session_destroy();
    header('Location : .');
    exit();
}


if(isset( $_SESSION['perso']))
{
    $perso = $_SESSION['perso'] ;
}
