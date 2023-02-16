<!doctype html>
<html lang="fr">
    <head>
        <meta charset="utf-8">
        <title>ReSoC - Flux</title>
        <meta name="author" content="Julien Falconnet">
        <link rel="stylesheet" href="styles.css"/>
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

                <img src="user.jpg" alt="Portrait de l'utilisatrice"/>
                <section>

                    <h3>Présentation</h3>
                    <p>Sur cette page, vous trouverez tous les messages des utilisatrices
                        auxquelles l'utilisatrice <?php echo $user['alias'] ?> est abonnée.
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
                    $authorId = $post['author_id']

    
                ?>

                <article>

                    <h3>
                        <time datetime='2020-02-01 11:12:13' ><?php echo $post['created'] ?></time>
                    </h3>

                    <address><?php echo '<a href= "wall.php?user_id='. $authorId . '">' . $post['author_name'] . '</a>'; ?></address>
                    
                    <div>
                        <p><?php echo $post['content']?></p>
                    </div>
                    <footer>
                        <small>♥ <?php echo $post['like_number']?></small>
                        <?php
                                foreach ($tags as $key => $tag) {
                                    echo '<a href="tags.php?tag_id=' . $tagIdReverse[$key] . '">' . '#' . $tag . ' ' . '</a>'; // Ajouter le lien pour chaque tag
                                }
                            ?>
                    </footer>
                </article>
                <?php } ?>

            </main>
        </div>
    </body>
</html>
