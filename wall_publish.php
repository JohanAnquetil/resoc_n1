<?php $user_idactuel = $_SESSION['connected_id'] ?>

<article>

    <?php
    $userId =intval($_GET['user_id']);
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
        $lInstructionSql = "INSERT INTO posts VALUES (NULL, '$userId', '$postContent', NOW(), NULL)";
        //$lInstructionSql = "INSERT INTO posts VALUES (id, user_id, content, created, post_id)";
        
        //4. Executer la requête
        $ok = $mysqli->query($lInstructionSql);
        if (! $ok) {
            echo "Impossible de publier le message: " . $mysqli->error;
        }
    }
    //echo "<pre>" . print_r($_SESSION['user_id']) . "</pre>";
    ?>

    <form action=<?php echo "wall.php?user_id=" . $user_idactuel ?> method='post'>
        <input type='hidden' name='???' value='a_changer'>
        <textarea name='message' id="publish_message" placeholder="Que voulez-vous dire ?" rows="5" cols="110"></textarea>
        <input class="submit" type='submit' value="Publier mon message">
    </form>

</article>
