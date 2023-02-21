<?php $user_idactuel = $_SESSION['connected_id'] ?>

<article>

    <?php
    //Récupérer l'id du compte sur lequel on se trouve
    $userId = intval($_GET['user_id']);

    //Connexion à la base de données
    $mysqli = new mysqli("localhost", "root", "root", "socialnetwork");

    //Vérifier si le formulaire contient un message
    $enCoursDeTraitement = isset($_POST['message']);
    
    //Si un message a été soumis :
    if ($enCoursDeTraitement) {
        
        //1. Stocker le message dans une variable
        $postContent = $_POST['message'];
        
        //2. Eviter les injection SQL : https://www.w3schools.com/sql/sql_injection.asp
        $postContent = $mysqli->real_escape_string($postContent);

        //3. Construire la requête
        $lInstructionSql = "INSERT INTO posts VALUES (NULL, '$userId', '$postContent', NOW(), $postId)";
        //VALUES = id / user_id / content / created / parent_id=post_id
        
        //4. Executer la requête
        $ok = $mysqli->query($lInstructionSql);
            //Si ça ne fonctionne pas :
            if (! $ok) {
                echo "Impossible de publier la réponse : " . $mysqli->error;
            }
    }
    ?>

    <form action=<?php echo "news.php" ?> method='post'>
        <input type='hidden' name='???' value='a_changer'>
        <textarea name='message' id="publish_message" placeholder="Votre réponse" rows="1" cols="50"></textarea>
        <input class="submit" type='submit' value="Publier ma réponse">
    </form>


    <?php
        
        $lesReponses = "
            SELECT * FROM posts
            WHERE posts.parent_id='$postId'
            ORDER BY posts.created DESC
        ";
        $lesInformations = $mysqli->query($lesReponses);
        if (! $lesInformations) {
            echo "Échec de la requete : " . $mysqli->error;
        }

        while ($answer = $lesInformations->fetch_assoc()) {

        }
    
    ?>

    <div id="answer">

    </div>

</article>