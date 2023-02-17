<!doctype html>
<html lang="fr">
    <head>
        <meta charset="utf-8">
        <title>Actualités</title>
        <meta name="author" content="Julien Falconnet">
        <link rel="stylesheet" href="styles.css"/>
    </head>
    <body>

        <?php include('header.php'); ?>

        <div id="wrapper">

            <aside>
                <!-- <img src="user.jpg" alt="Portrait de l'utilisatrice"/> -->
                <section>
                    <h3>Actualités</h3>
                    <p>Retrouvez les derniers messages de
                        toutes les utilisatrices du site.</p>
                </section>
            </aside>

            <main>
                <?php
                /*
                  // C'est ici que le travail PHP commence
                  // Votre mission si vous l'acceptez est de chercher dans la base
                  // de données la liste des 5 derniers messsages (posts) et
                  // de l'afficher
                  // Documentation : les exemples https://www.php.net/manual/fr/mysqli.query.php
                  // plus généralement : https://www.php.net/manual/fr/mysqli.query.php
                */

                // Etape 1: Ouvrir une connexion avec la base de donnée.
                $mysqli = new mysqli("localhost", "root", "root", "socialnetwork");
                //verification
                if ($mysqli->connect_errno) {
                    echo "<article>";
                    echo "Échec de la connexion : " . $mysqli->connect_error;
                    echo "<p>Indice: Vérifiez les parametres de <code>new mysqli(...</code></p>";
                    echo "</article>";
                    exit();
                }

                // Etape 2: Poser une question à la base de donnée et récupérer ses informations
                $laQuestionEnSql = "
                    SELECT posts.content,
                    posts.created,
                    users.alias as author_name,
                    users.id as author_id,
                    posts.id as post_id,
                    count(likes.id) as like_number,
                    GROUP_CONCAT(DISTINCT tags.label) AS taglist,
                    GROUP_CONCAT(DISTINCT tags.id) AS tag_id
                    FROM posts
                    JOIN users ON  users.id=posts.user_id
                    LEFT JOIN posts_tags ON posts.id = posts_tags.post_id
                    LEFT JOIN tags       ON posts_tags.tag_id  = tags.id
                    LEFT JOIN likes      ON likes.post_id  = posts.id
                    GROUP BY posts.id
                    ORDER BY posts.created DESC
                    LIMIT 5
                    ";
                $lesInformations = $mysqli->query($laQuestionEnSql);
                // Vérification
                if (! $lesInformations) {
                    echo "<article>";
                    echo "Échec de la requete : " . $mysqli->error;
                    echo "<p>Indice: Vérifiez la requete  SQL suivante dans phpmyadmin<code>$laQuestionEnSql</code></p>";
                    exit();
                }

                // Etape 3: Parcourir ces données et les ranger bien comme il faut dans du html
                // NB: à chaque tour du while, la variable post ci dessous reçois les informations du post suivant.
                while ($post = $lesInformations->fetch_assoc()) {
                    $taglist = $post['taglist'];
                    $tags = explode(',', $taglist); // Divisez la chaîne de caractères en un tableau
                    $tagIdList = $post['tag_id'];
                    $tagId = explode(',', $tagIdList); // Divisez la chaîne de caractères en un tableau
                    $tagIdReverse = array_reverse($tagId);
                    $authorId = $post['author_id'];
                    $postId = $post['post_id'];
    
                    //echo "<pre>" . print_r($post, 1) . "</pre>";

                    // avec le ? > ci-dessous on sort du mode php et on écrit du html comme on veut... mais en restant dans la boucle
                    ?>

                    <article>
                        <h3>
                            <time><?php echo $post['created'] ?></time>
                        </h3>
                        <address><?php echo '<a href="wall.php?user_id=' . $authorId . '">' . $post['author_name'] . '</a>'; ?></address>
                        <div>
                            <p><?php echo $post['content'] ?></p>
                        </div>
                        <footer>
                            <small>
                                <?php include('like.php'); ?>
                            </small>
                            <?php
                                foreach ($tags as $key => $tag) {
                                    echo '<a href="tags.php?tag_id=' . $tagIdReverse[$key] . '">' . '#' . $tag . ' ' . '</a>'; // Ajouter le lien pour chaque tag
                                }
                            ?>
                        </footer>
                    </article>

                    <?php
                    // avec le <?php ci-dessus on retourne en mode php

                    }// cette accolade ferme et termine la boucle while ouverte avant
                    ?>

            </main>

        </div>

    </body>
    
</html>
