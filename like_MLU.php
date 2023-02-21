<?php $user_idactuel = $_SESSION['connected_id'] ?>

<div>

    <?php
    //$userId = intval($_GET['user_id']);
    $mysqli = new mysqli("localhost", "root", "root", "socialnetwork");

    //Récupèrer la value de l'input name likeCounter (=0)
    //$result = 0
    //$likeCounter = $_POST['likeCounter']
    //print_r($likeCounter)
    
    //Vérifier si le bouton est cliqué
    $enCoursDeTraitement = isset($_POST[$postId]);

    
    //Si le bouton est cliqué :
    if ($enCoursDeTraitement) {
        //Si la value de l'input name likeCounter = 0
        if ($likeCounter == 0) {
            //Passer la value de l'input à 1
            $likeCounter = 1;
    
            //Construire la requête : ajout du like à la db
            $lInstructionSql = "INSERT INTO likes VALUES (NULL, '$user_idactuel', '$postId')";
            
            //Executer la requête
            $ok = $mysqli->query($lInstructionSql);
            if (! $ok) {
                echo "Impossible de liker ce post : " . $mysqli->error;
            } else {
                //echo "Vous avez bien liké le post n°$postId";
                header("refresh: 0");
            }

        //Sinon, si la value de l'input name likeCounter = 1
        } else {
            //Remettre la value de l'input hidden à 0
            $likeCounter = 0;

            //Construire la requête : supprimer le like de la db
            $sqlQuery = "DELETE FROM likes VALUES (NULL, '$user_idactuel', '$postId')";
            
            //Executer la requête
            $queryOk = $mysqli->query($sqlQuery);
            if (! $queryOk) {
                echo "Impossible de unliker ce post : " . $mysqli->error;
            } else {
                //echo "Vous avez bien unliké le post n°$postId";
                header("refresh: 0");
            }
        }
    }
    
    ?>

    <form method='post'>
        <input type='hidden' name='likeCounter' value='<?php echo $result; ?>' >
        <input
            id="like"
            type='submit'
            name="<?php echo $postId ?>"
            value="♥ <?php echo $post['like_number'] ?>"
        >
    </form>

</div>