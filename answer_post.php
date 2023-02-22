<?php $user_idactuel = $_SESSION['connected_id'] ?>
<link rel="stylesheet" href="styles.css"/>

<div id="answer">

    <?php

    //Connexion à la base de données -->
    $mysqli = new mysqli("localhost", "root", "root", "socialnetwork");

    //Vérifier si le formulaire contient un message
    //$enCoursDeTraitement = isset($_POST[$postId]);
    $enCoursDeTraitement = isset($_POST['reponse']);
    
    //Si un message a été soumis :
    if ($enCoursDeTraitement || $_POST['post_id'] == "$postId") {

        //1. Stocker le message dans une variable
        //$answerContent = $_POST[$postId];
        $answerContent = $_POST['reponse'];
        
        //2. Eviter les injection SQL
        $answerContent = $mysqli->real_escape_string($answerContent);

        //3. Construire la requête
        $lInstructionSql = "INSERT INTO posts VALUES (NULL, '$user_idactuel', '$answerContent', NOW(), $postId)";
        //VALUES = id / user_id=personne qui commente=nous / content / created / parent_id=id du post qui est commenté
        $postParentId = $lInstructionSql['parent_id'];
        
        //4. Executer la requête
        $ok = $mysqli->query($lInstructionSql);
        if (! $ok) {
            echo "Impossible de publier la réponse : " . $mysqli->error;
        }
    }

    ?>

    <?php
        //5. Récupérer l'id du dernier commentaire
        $SQLquery = "SELECT user_id, parent_id FROM posts WHERE parent_id IS NOT NULL ORDER BY created DESC LIMIT 1";
        $lastComment = $mysqli->query($SQLquery)->fetch_assoc();
        $author = $lastComment['user_id'];
        $commentParentId = $lastComment['parent_id'];
    ?>

    <form action=<?php echo "news.php" ?> method='post'>
        <input type='hidden' name='post_id' value='<?php echo $postId ?>'>
        <textarea name='reponse' id="publish_message" placeholder="Écrivez un commentaire..." rows="1" cols="50"></textarea>
        <!-- <textarea name='<?php echo $postId ?>' id="publish_message" placeholder="Écrivez un commentaire..." rows="1" cols="50"></textarea> -->
        <input class="submit" type='submit' value="✓">
    </form>

    <!-- Problème : le commentaire se publie sous chaque post -->
    <?php
        if ($enCoursDeTraitement) {
    ?>

    <div class="comment">
        <?php if ($commentParentId == $postId) { ?>
            <p>Utilisatrice n°<?php echo $author;?> : <?php echo $answerContent; ?> </p>
        <?php } ?>
    </div>

    <?php
        }
    ?>


</div>