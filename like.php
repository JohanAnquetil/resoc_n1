<?php $user_idactuel = $_SESSION['connected_id'] ?>

<div>

    <?php
    //Connexion à la BDD
    $mysqli = new mysqli("localhost", "root", "root", "socialnetwork");

    //Nombre de likes sur la publication
    $like_number_var = $post['like_number'];
    
    //Vérifier si le bouton "J'aime" est cliqué
    $enCoursDeTraitement = isset($_POST[$postId]);

    //Si le bouton "J'aime" est cliqué :
    if ($enCoursDeTraitement) {
        
        //Construire la requête : ajouter le like à la BDD
        $lInstructionSql = "INSERT INTO likes VALUES (NULL, '$user_idactuel', '$postId')";

        //Si c'est le bouton DISLIKE qui est cliqué : supprimer le like de la BDD
        if ($_POST['action'] == "Dislike") {
            $lInstructionSql = "DELETE FROM likes WHERE user_id = $user_idactuel and post_id = $postId";
        }
        
        //Executer la requête
        $ok = $mysqli->query($lInstructionSql);
        if (! $ok) {
            echo "Impossible de liker ce post : " . $mysqli->error;
        } else {
            //echo "Vous avez bien liké le post n°$postId";
            header("refresh: 0");
        }
    }
 
    ?>
    
    <!-- On vérifie s'il existe déjà un like du user dans la BDD -->
    <?php
        $lInstructionSql = "SELECT * FROM likes WHERE user_id = $user_idactuel AND post_id = $postId";
        $ok = $mysqli->query($lInstructionSql);
        $post = $ok->fetch_assoc();
    ?>

    <!-- Si la personne qui like n'est pas ressortie dans la requête : bouton LIKE -->
    <?php
        if ($post['user_id'] != $user_idactuel) {
    ?>

    <form method='post'>
        <!-- HIDDEN -->
        <input type='hidden' name='action' value='Like'>
        <!-- LIKE -->
        <input
            id="like"
            type='submit'
            name="<?php echo $postId ?>"
            value="<?php echo $like_number_var ?> ♥">
    </form>
    
    <!-- Sinon, si la personne qui like est ressortie dans la requête : bouton DISLIKE -->
    <?php
        } else {
    ?>

    <form method='post'>
        <!-- HIDDEN -->
        <input type='hidden' name='action' value='Dislike'>
        <!-- DISLIKE -->
        <input
            id="dislike"
            type='submit'
            name="<?php echo $postId?>"
            value="<?php echo $like_number_var ?> ♥">
    </form>

    <!-- Fermeture de la boucle IF/ELSE -->
    <?php
        }
    ?>

</div>
