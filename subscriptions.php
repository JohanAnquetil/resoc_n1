<!doctype html>
<html lang="fr">
    <head>
        <meta charset="utf-8">
        <title>Mes abonnements</title>
        <meta name="author" content="Julien Falconnet">
        <link rel="stylesheet" href="style.css"/>
    </head>
    <body>

        <?php include('header.php'); ?>

        <div id="wrapper">
            
            <aside>
                <section>
                    <h3>Mes abonnements</h3>
                    <p>Retrouvez la liste des personnes dont
                        l'utilisatrice n° <?php echo intval($_GET['user_id']) ?>
                        suit les messages.
                    </p>
                    <img src="user.jpg" alt="Portrait de l'utilisatrice"/>
                </section>
            </aside>

            <main class='contacts'>
                <?php
                // Etape 1: récupérer l'id de l'utilisateur
                $userId = intval($_GET['user_id']);
                // Etape 2: se connecter à la base de donnée
                $mysqli = new mysqli("localhost", "root", "root", "socialnetwork");
                // Etape 3: récupérer le nom de l'utilisateur
                $laQuestionEnSql = "
                    SELECT users.*
                    FROM followers
                    LEFT JOIN users ON users.id=followers.followed_user_id
                    WHERE followers.following_user_id='$userId'
                    GROUP BY users.id
                    ";
                $lesInformations = $mysqli->query($laQuestionEnSql);
                // Etape 4: à vous de jouer
                //@todo: faire la boucle while de parcours des abonnés et mettre les bonnes valeurs ci dessous
                while ($followed = $lesInformations->fetch_assoc()) {
                ?>
                <article>
                    <img src="user.jpg" alt="blason"/>
                    <h3><?php echo $followed["alias"] ?></h3>
                    <p><?php echo $followed["email"] ?></p>
                </article>
                <?php  }?>
            </main>
        </div>
    </body>
</html>
