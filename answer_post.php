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
    if ($enCoursDeTraitement) {
        
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
        //Sélectionne tous les commentaires
        /*
        $query = "SELECT * FROM posts WHERE parent_id IS NOT NULL ORDER BY created DESC LIMIT 1";
        $commentQuery = $mysqli->query($query);
        while ($comments = $commentQuery->fetch_assoc()) {
            print_r($comments);
            $commentId = $comments['id'];
            print_r("Id du comment : " . $commentId);
            $commentContent = $comments['content'];
            $commentParentId = $comments['parent_id'];
        }*/

        //5. Récupérer l'id du dernier commentaire
        $SQLquery = "SELECT parent_id FROM posts WHERE parent_id IS NOT NULL ORDER BY created DESC LIMIT 1";
        $lastComment = $mysqli->query($SQLquery)->fetch_assoc();
        $commentParentId = $lastComment['parent_id'];
    ?>

    <form action=<?php echo "news.php" ?> method='post'>
        <input type='hidden' name='???' value='a_changer'>
        <textarea name='reponse' id="publish_message" placeholder="Votre réponse" rows="1" cols="50"></textarea>
        <!-- <textarea name='<?php echo $postId ?>' id="publish_message" placeholder="Votre réponse" rows="1" cols="50"></textarea> -->
        <input class="submit" type='submit' value="✓">
    </form>

    <!-- Problème : le commentaire se publie sous chaque post -->
    <p>
        <?php
            //Si parent_id du commentaire = id du post qu'on commente : afficher le commentaire
            if ($commentParentId == $postId) {
                echo $answerContent;
            }
        ?>
    </p>

</div>