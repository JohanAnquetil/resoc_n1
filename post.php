<header class="header_post">
    <?php if ($user_idactuel != $userId) { ?>
        <p class="author"> <?php echo '<a href="wall.php?user_id=' . $authorId . '">' . $post['author_name'] . '</a>'; ?> </p>
    <?php } ?>
    <h3> <time><?php echo $post['created'] ?></time> </h3>
</header>

<div>
    <p class="post_content">
        <?php
            //echo $post['content'];
            //Si le post ($postContent) contient le tag ($tagLabel) :
            foreach ($tags as $key => $tag) {
                if (strpos($post['content'], $tag)) {
                    $tagLink = '<a href="tags.php?tag_id=' . $tagIdReverse[$key] . '">' . $tag . '</a>';
                    $newContent = str_replace($tag, $tagLink, $post['content']);
                }
            }
            echo $newContent;
        ?>
    </p>
</div>

<footer>
    <small>
        <?php include('like.php'); ?>
    </small>
    <!-- <div>
        <?php
            foreach ($tags as $key => $tag) {
                if ($tag != null) {
                    echo '<a href="tags.php?tag_id=' . $tagIdReverse[$key] . '">' . $tag . '</a>'; // Ajouter le lien pour chaque tag
                }
            }
        ?>
    </div> -->
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
