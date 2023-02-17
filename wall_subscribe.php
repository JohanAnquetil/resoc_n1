<?php $user_idactuel = $_SESSION['connected_id'] ?>

<div>

    <?php
    $userId = intval($_GET['user_id']);
    $mysqli = new mysqli("localhost", "root", "root", "socialnetwork");

    //Vérifier si le bouton est cliqué
    $enCoursDeTraitement = isset($_POST['subscribe']);

    //Si le bouton est cliqué :
    if ($enCoursDeTraitement) {

        //Construire la requête
        $lInstructionSql = "INSERT INTO followers VALUES (NULL, '$userId', '$user_idactuel')";
        //$lInstructionSql = "INSERT INTO followers VALUES (id, followed_user_id (=le compte qu'on suit), following_user_id (=nous))";
        
        //Executer la requête
        $ok = $mysqli->query($lInstructionSql);
        if (! $ok) {
            echo "Impossible de suivre ce compte : " . $mysqli->error;
        } else {
            echo "Vous suivez désormais le compte de l'utilisatrice n°$userId";
        }
    }
    ?>

    <form method='post'>
        <input type='hidden' name='???' value='a_changer'>
        <input class="submit" name="subscribe" type='submit' value="S'abonner">
    </form>

</div>
