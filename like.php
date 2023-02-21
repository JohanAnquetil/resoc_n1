<?php $user_idactuel = $_SESSION['connected_id'] ?>

<div>

    <?php
    $like_number_var = $post['like_number'];
    print_r($like_number_var);
    //$userId = intval($_GET['user_id']);
    $mysqli = new mysqli("localhost", "root", "root", "socialnetwork");
    
    //Vérifier si le bouton est cliqué
    $enCoursDeTraitement = isset($_POST[$postId]);
    // $lInstructionDeleteSql = "DELETE FROM likes WHERE user_id = '$user_idactuel'AND post_id = '$postId";

    //Si le bouton est cliqué :
    if ($enCoursDeTraitement) {
        
      //Construire la requête
        $lInstructionSql = "INSERT INTO likes VALUES (NULL, '$user_idactuel', '$postId')";
        //$lInstructionSql = "INSERT INTO likes VALUES (id, user_id (=nous), post_id)";
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
    
   <?php $lInstructionSql = "SELECT * FROM likes WHERE user_id = $user_idactuel AND post_id = $postId"; 
    $ok = $mysqli->query($lInstructionSql);
    $post = $ok->fetch_assoc();
    ?>


  <?php  if ($post['user_id'] != $user_idactuel) { ?>
    <form method='post'>
    <input type='hidden' name='action' value='Like'>
        
        <input
            id="like"
            type='submit'
            name="<?php echo $postId ?>"
            value="♥ <?php echo $like_number_var ?> J'aime">
    </form>
    
    <?php } else { 
         // echo $post['like_number'];
        // echo " J'aime"; ?>

        <form method='post'>
        <input type='hidden' name='action' value='Dislike'>
        
        <input
            id="dislike"
            type='submit'
            name="<?php echo $postId?>"
            value="<?php echo $like_number_var ?> ♥ Je n'aime plus">
    </form>
   <?php } ?>

</div>	
