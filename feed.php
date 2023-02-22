<!doctype html>
<html lang="fr">
    <head>
        <meta charset="utf-8">
        <title>Flux</title>
        <meta name="author" content="Julien Falconnet">
        <link rel="stylesheet" href="style.css"/>
    </head>
    <body>

        <?php include('header.php'); ?>

        <div id="wrapper">
            <?php
            /**
             * Cette page est TRES similaire à wall.php.
             * Vous avez sensiblement à y faire la meme chose.
             * Il y a un seul point qui change c'est la requete sql.
             */
            /**
             * Etape 1: Le mur concerne un utilisateur en particulier
             */
            $userId = intval($_GET['user_id']);
            
            /**
             * Etape 2: se connecter à la base de donnée
             */
            $mysqli = new mysqli("localhost", "root", "root", "socialnetwork");
            ?>

            <aside>
                <?php
                /**
                 * Etape 3: récupérer le nom de l'utilisateur
                 */
                $laQuestionEnSql = "SELECT * FROM `users` WHERE id= '$userId' ";
                $lesInformations = $mysqli->query($laQuestionEnSql);
                $user = $lesInformations->fetch_assoc();
                ?>

                <!-- <img src="user.jpg" alt="Portrait de l'utilisatrice"/> -->
                <section>

                    <h3>Flux</h3>
                    <p>Retrouvez tous les messages des utilisatrices
                        auxquelles <?php echo $user['alias'] ?> est abonnée.
                    </p>

                </section>

            </aside>

            <main>

                <?php

                /**
                 * Etape 3: récupérer tous les messages des abonnements
                 */

                $laQuestionEnSql = "
                    SELECT posts.content,
                    posts.created,
                    users.alias as author_name,
                    users.id as author_id,
                    posts.id as post_id,
                    count(likes.id) as like_number,
                    GROUP_CONCAT(DISTINCT tags.label) AS taglist,
                    GROUP_CONCAT(DISTINCT tags.id) AS tag_id
                    FROM followers
                    JOIN users ON users.id=followers.followed_user_id
                    JOIN posts ON posts.user_id=users.id
                    LEFT JOIN posts_tags ON posts.id = posts_tags.post_id
                    LEFT JOIN tags       ON posts_tags.tag_id  = tags.id
                    LEFT JOIN likes      ON likes.post_id  = posts.id
                    WHERE followers.following_user_id='$userId'
                    GROUP BY posts.id
                    ORDER BY posts.created DESC
                    ";

                $lesInformations = $mysqli->query($laQuestionEnSql);
                if (! $lesInformations) {
                    echo "Échec de la requete : " . $mysqli->error;
                }

                /**
                 * Etape 4: @todo Parcourir les messsages et remplir correctement le HTML avec les bonnes valeurs php
                 * A vous de retrouver comment faire la boucle while de parcours...
                 */
                while ($post = $lesInformations->fetch_assoc()) {
                    $taglist = $post['taglist'];
                    $tags = explode(',', $taglist); // Divisez la chaîne de caractères en un tableau
                    $tagIdList = $post['tag_id'];
                    $tagId = explode(',', $tagIdList); // Divisez la chaîne de caractères en un tableau
                    $tagIdReverse = array_reverse($tagId);
                    $authorId = $post['author_id'];
                    $postId = $post['post_id'];
                ?>

                <article>
                    <header class="header_post">
                        <p class="author"> <?php echo '<a href="wall.php?user_id=' . $authorId . '">' . $post['author_name'] . '</a>'; ?> </p>
                        <h3> <time><?php echo $post['created'] ?></time> </h3>
                    </header>
                    <div>
                        <p><?php echo $post['content'] ?></p>
                    </div>
                    <footer>
                        <small>
                            <?php include('like.php'); ?>
                        </small>
                        <div>
                            <?php
                                foreach ($tags as $key => $tag) {
                                    if ($tag != null){
                                        echo '<a href="tags.php?tag_id=' . $tagIdReverse[$key] . '">' . '#' . $tag . ' ' . '</a>'; // Ajouter le lien pour chaque tag
                                    }
                                }
                            ?>
                        </div>
                    </footer>
                    <div>
                        <?php
                            //Si l'id du user connecté ($user_idactuel) est différent
                            //de l'id du user dont c'est le post ($authorId)
                            //pouvoir commenter le message
                            if ($user_idactuel != $authorId) {
                                include('answer_post.php');
                            }
                        ?>
                    </div>
                </article>
                <?php } ?>

            </main>
        </div>
    </body>
</html>
