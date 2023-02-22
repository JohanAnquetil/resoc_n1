<!doctype html>
<html lang="fr">

    <head>
        <meta charset="utf-8">
        <title>Mur</title>
        <meta name="author" content="Julien Falconnet">
        <link rel="stylesheet" href="styles.css"/>
    </head>

    <body>

        <?php
            include('header.php');
        ?>


        <div id="wrapper">

            <?php
            //Etape 1
            /**
             * Etape 1: Le mur concerne un utilisateur en particulier
             * La première étape est donc de trouver quel est l'id de l'utilisateur
             * Celui ci est indiqué en parametre GET de la page sous la forme user_id=...
             * Documentation : https://www.php.net/manual/fr/reserved.variables.get.php
             * ... mais en résumé c'est une manière de passer des informations à la page en ajoutant des choses dans l'url
             */
            $userId =intval($_GET['user_id']);
            ?>
            
            <?php
            //Etape 2: se connecter à la base de donnée
            $mysqli = new mysqli("localhost", "root", "root", "socialnetwork");
            ?>

            <aside>
                <?php
                //Etape 3: récupérer le nom de l'utilisateur
                $laQuestionEnSql = "SELECT * FROM users WHERE id= '$userId' ";
                $lesInformations = $mysqli->query($laQuestionEnSql);
                $user = $lesInformations->fetch_assoc();
                //@todo: afficher le résultat de la ligne ci dessous, remplacer XXX par l'alias et effacer la ligne ci-dessous
                //echo "<pre>" . print_r($user, 1) . "</pre>";
                ?>


                <section>
                    <h3>Mur</h3>
                    <p>Retrouvez tous les messages de <?php echo $user['alias'] ?>.</p>
                    <img src="minion.jpg" alt="Portrait de l'utilisatrice"/>

                    <?php
                    //Si l'id du user connecté ($user_idactuel) est différent
                    //de l'id du user dont c'est la page ($userId)
                    //afficher un bouton pour s'abonner (wall_subscribe.php)
                    if ($user_idactuel != $userId) {
                        include('wall_subscribe.php');
                    }
                    ?>

                </section>
                
            </aside>

            <main>

                <?php
                //Si l'id du user connecté ($user_idactuel) est le même que
                //l'id du user dont c'est la page ($userId)
                //afficher le formulaire de publication d'un message (wall_publish.php)
                if ($user_idactuel == $userId) {
                    include('wall_publish.php');
                }
                ?>


                <?php

                //Etape 3: récupérer tous les messages de l'utilisatrice
                $laQuestionEnSql = " SELECT
                                        posts.content,
                                        posts.created,
                                        users.alias as author_name,
                                        users.id as author_id,
                                        posts.id as post_id,
                    COUNT(likes.id) as like_number,
                    GROUP_CONCAT(DISTINCT tags.label) AS taglist,
                    GROUP_CONCAT(DISTINCT tags.id) AS tag_id
                    FROM posts
                    JOIN users ON  users.id=posts.user_id
                    LEFT JOIN posts_tags ON posts.id = posts_tags.post_id
                    LEFT JOIN tags       ON posts_tags.tag_id  = tags.id
                    LEFT JOIN likes      ON likes.post_id  = posts.id
                    WHERE posts.user_id='$userId'
                    GROUP BY posts.id
                    ORDER BY posts.created DESC
                    ";
                $lesInformations = $mysqli->query($laQuestionEnSql);
                if (! $lesInformations) {
                    echo "Échec de la requete : " . $mysqli->error;
                }

                //Etape 4: @todo Parcourir les messsages et remplir correctement le HTML avec les bonnes valeurs php

                while ($post = $lesInformations->fetch_assoc()) {
                    // echo "<pre>" . print_r($post, 1) . "</pre>";
                    $taglist = $post['taglist'];
                    $tags = explode(',', $taglist); // Divisez la chaîne de caractères en un tableau
                    //$tagId = intval($_GET['tag_id']);
                    $tagIdList = $post['tag_id'];
                    $tagId = explode(',', $tagIdList); // Divisez la chaîne de caractères en un tableau
                    $tagIdReverse = array_reverse($tagId);
                    $authorId = $post['author_id'];
                    $postId = $post['post_id'];
                    $postContent = $post['content'];

                ?>

                    <article>
                        <?php include('post.php'); ?>
                    </article>

                <?php } ?>


            </main>

        </div>

    </body>

</html>
