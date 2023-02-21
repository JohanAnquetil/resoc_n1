<?php $user_idactuel = $_SESSION['connected_id'] ?>

<article>

    <?php
    //Connexion à la base de données
    $mysqli = new mysqli("localhost", "root", "root", "socialnetwork");

    //Vérifier si le formulaire contient un message
    $enCoursDeTraitement = isset($_POST['message']);
    
    //Si un message a été soumis :
    if ($enCoursDeTraitement) {
        
        //1. Stocker le message dans une variable
        $postContent = $_POST['message'];
        
        //2. Eviter les injection SQL
        $postContent = $mysqli->real_escape_string($postContent);

        //3. Construire la requête
        $lInstructionSql = "INSERT INTO posts VALUES (NULL, '$user_idactuel', '$postContent', NOW(), NULL)";
        //VALUES = post_id / user_id / content / created / parent_id
        
        //4. Executer la requête
        $ok = $mysqli->query($lInstructionSql);
        //Si la requête ne fonctionne pas :
        if (! $ok) {
            echo "Impossible de publier le message : " . $mysqli->error;
        }

        //5. Récupérer l'id du dernier post publié
        $SQLquery = "SELECT id FROM posts ORDER BY created DESC LIMIT 1";
        $lastPost = $mysqli->query($SQLquery)->fetch_assoc();
        $postId = $lastPost['id'];

        //6. Checker s'il y a un #tag dans le message

            //a. Récupérer tous les tags de la table TAGS
            $querySQL = "SELECT * FROM tags";
            $listOfTags = $mysqli->query($querySQL);
            if (! $listOfTags) { echo "Échec de la requete : " . $mysqli->error; }

            while ($tags = $listOfTags->fetch_all()) {

                //b. Comparer chaque tag au contenu du post
                foreach ($listOfTags as $tag) {
                    $tagLabel = $tag["label"];
                    $tagId = $tag["id"];
                    
                    //c. Si le post ($postContent) contient le tag ($tagLabel) :
                    if (strpos($postContent, $tagLabel)) {
                        //Ajouter le tag dans la table posts_tags
                        $sqlQuery = "INSERT INTO posts_tags VALUES (NULL, '$postId', '$tagId')";
                        $okQuery = $mysqli->query($sqlQuery);
                        if (! $okQuery) {
                            echo "Impossible d'intégrer le tag à la base de données : " . $mysqli->error;
                        }
                    }
                }
            }
    }

    ?>

    <form action=<?php echo "wall.php?user_id=" . $user_idactuel ?> method='post'>
        <input type='hidden' name='???' value='a_changer'>
        <textarea name='message' id="publish_message" placeholder="Que voulez-vous dire ?" rows="5" cols="110"></textarea>
        <input class="submit" type='submit' value="Publier mon message">
    </form>

</article>
