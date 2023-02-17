<!doctype html>
<html lang="fr">
    <head>
        <meta charset="utf-8">
        <title>Les messages par mot-clé</title>
        <meta name="author" content="Julien Falconnet">
        <link rel="stylesheet" href="styles.css"/>
    </head>
    <body>
        

        <?php include('header.php'); ?>

        <div id="wrapper">
            <!-- Cette page est similaire à wall.php ou feed.php
            mais elle porte sur les mots-clés (tags) -->
            
            <?php
            //Etape 1: Le mur concerne un mot-clé en particulier
            $tagId = intval($_GET['tag_id']); //change selon le tag sur lequel on clique
            ?>
            
            <?php
            //Etape 2: se connecter à la base de donnée
            $mysqli = new mysqli("localhost", "root", "root", "socialnetwork");
            ?>

            <aside>

                <!-- <img src="user.jpg" alt="Portrait de l'utilisatrice"/> -->

                <section>
                    <h3>Mots-clés</h3>
                    <p>Cliquez sur un mot-clé pour retrouver les derniers messages le comportant :</p>

                <!-- Etape 3: -->

                    <!-- Récupérer tous les mots clés -->
                    <?php
                        $listTags = [];
                        $laQuestionEnSql = "SELECT * FROM tags";
                        $lesInformations = $mysqli->query($laQuestionEnSql);

                        $tag = $lesInformations->fetch_assoc(); //Array ( [id] => 7 [label] => culture )
                        
                        while ($tag = $lesInformations->fetch_assoc()) {
                            $listTags[$tag['id']] = $tag['label']; //Array ( [7] => culture )
                            $tagLabel = $tag["label"];
                            $idTag = $tag["id"];
                        //print_r($tag);
                        //print_r($listTags);
                    ?>

                    <div>
                        <p class="tag" >
                            <?php
                            echo '<a href="tags.php?tag_id=' . $idTag . '">' . '#' . $tagLabel . ' ' . '</a>';
                            ?>
                        </p>
                    </div>

                    <?php
                        } //fermeture de la boucle while
                    ?>

                </section>

                <!-- Demande initiale : récupérer le nom du mot-clé -->
                <!-- <?php
                $laQuestionEnSql = "SELECT * FROM tags WHERE id= '$tagId' ";
                $lesInformations = $mysqli->query($laQuestionEnSql);
                $tag = $lesInformations->fetch_assoc();
                ?> -->
                <!-- <section>
                    <h3>Présentation</h3>
                    <p>Sur cette page vous trouverez les derniers messages comportant
                        le mot-clé <?php echo $tag['label'] ?>
                        (n° <?php echo $tagId ?>).
                    </p>
                </section> -->

            </aside>

            <main>
            
            <!-- Etape 3 -->
            <?php
                $laQuestionEnSql = "
                    SELECT posts.content,
                    posts.created,
                    users.alias as author_name,
                    users.id as author_id,
                    posts.id as post_id,
                    count(likes.id) as like_number,
                    GROUP_CONCAT(DISTINCT tags.label) AS taglist,
                    GROUP_CONCAT(DISTINCT tags.id) AS tag_id
                    FROM posts_tags as filter
                    JOIN posts ON posts.id=filter.post_id
                    JOIN users ON users.id=posts.user_id
                    LEFT JOIN posts_tags ON posts.id = posts_tags.post_id
                    LEFT JOIN tags       ON posts_tags.tag_id  = tags.id
                    LEFT JOIN likes      ON likes.post_id  = posts.id
                    WHERE filter.tag_id = '$tagId'
                    GROUP BY posts.id
                    ORDER BY posts.created DESC
                    ";
                $lesInformations = $mysqli->query($laQuestionEnSql);
                if (! $lesInformations) {
                    echo "Échec de la requete : " . $mysqli->error;
                }

                //Etape 4: @todo Parcourir les messsages et remplir correctement le HTML avec les bonnes valeurs php
                while ($post = $lesInformations->fetch_assoc()) {
                    $taglist = $post['taglist'];
                    $tags = explode(',', $taglist); // Divisez la chaîne de caractères en un tableau
                    $tagIdList = $post['tag_id'];
                    $tagId = explode(',', $tagIdList); // Divisez la chaîne de caractères en un tableau
                    $tagIdReverse = array_reverse($tagId);
                    $authorId = $post['author_id'];
                    $postId = $post['post_id'];
    
                    // echo "<pre>" . print_r($post, 1) . "</pre>";

                    ?>
                    <article>
                        <h3>
                            <time datetime='2020-02-01 11:12:13' ><?php echo $post['created'] ?></time>
                        </h3>
                        <address><?php echo '<a href="wall.php?user_id=' .$authorId. '">'. $post['author_name'] . '</a>'; ?></address>
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
                } //fin de la boucle while
            ?>


            </main>
        </div>
    </body>
</html>