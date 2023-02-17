<?php $user_idactuel = $_SESSION['connected_id'] ?>

<div>

    <?php
    //$userId = intval($_GET['user_id']);
    $mysqli = new mysqli("localhost", "root", "root", "socialnetwork");

    //Vérifier si le bouton est cliqué
    $enCoursDeTraitement = isset($_POST[$postId]);

    //Si le bouton est cliqué :
    if ($enCoursDeTraitement) {

        //Construire la requête
        $lInstructionSql = "INSERT INTO likes VALUES (NULL, '$user_idactuel', '$postId')";
        //$lInstructionSql = "INSERT INTO likes VALUES (id, user_id (=nous), post_id)";
        
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

    <form method='post'>
        <input type='hidden' name='???' value='a_changer'>
        <input
            id="like"
            type='submit'
            name="<?php echo $postId ?>"
            value="♥ <?php echo $post['like_number'] ?>"
        >
    </form>

</div>
