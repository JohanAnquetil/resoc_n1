<?php
    session_start();
?>

<!doctype html>
<html lang="fr">
    <head>
        <meta charset="utf-8">
        <title>Connexion</title>
        <meta name="author" content="Julien Falconnet">
        <link rel="stylesheet" href="style.css"/>
    </head>
    
    <body>

    <header>
        <img src="resoc.jpg" alt="Logo de notre réseau social"/>
    </header>

        <div id="wrapper" >

            <aside>
                <h2>Présentation</h2>
                <p>Bienvenue sur notre réseau social !</p>
            </aside>

            <main>
                <article>
                    <h2>Connexion</h2>
                    <?php
                    /**TRAITEMENT DU FORMULAIRE*/
                    // Etape 1 : vérifier si on est en train d'afficher ou de traiter le formulaire
                    // si on recoit un champs email rempli il y a une chance que ce soit un traitement
                    $enCoursDeTraitement = isset($_POST['email']);
                    // On ne fait ce qui suit que si un formulaire a été soumis.
                    if ($enCoursDeTraitement) {
                        // Etape 2: récupérer ce qu'il y a dans le formulaire @todo: c'est là que votre travaille se situe
                        // observez le résultat de cette ligne de débug (vous l'effacerez ensuite)
                                //echo "<pre>" . print_r($_POST, 1) . "</pre>";
                        // et complétez le code ci dessous en remplaçant les ???
                        $emailAVerifier = $_POST['email'];
                        $passwdAVerifier = $_POST['motpasse'];


                        //Etape 3 : Ouvrir une connexion avec la base de donnée.
                        $mysqli = new mysqli("localhost", "root", "root", "socialnetwork");

                        //Etape 4 : Petite sécurité
                            //pour éviter les injection sql : https://www.w3schools.com/sql/sql_injection.asp
                        $emailAVerifier = $mysqli->real_escape_string($emailAVerifier);
                        $passwdAVerifier = $mysqli->real_escape_string($passwdAVerifier);
                        // On crypte le mot de passe pour éviter d'exposer notre utilisatrice en cas d'intrusion dans nos systèmes
                        $passwdAVerifier = md5($passwdAVerifier);
                        // NB: md5 est pédagogique mais n'est pas recommandée pour une vraies sécurité

                        //Etape 5 : construction de la requete
                        $lInstructionSql = "SELECT * FROM users WHERE email LIKE '$emailAVerifier' ";

                        // Etape 6: Vérification de l'utilisateur
                        $res = $mysqli->query($lInstructionSql);
                        $user = $res->fetch_assoc();
                        if (! $user || $user["password"] != $passwdAVerifier) {
                            echo "La connexion a échouée.";
                        } else {
                            // Etape 7 : Se souvenir que l'utilisateur s'est connecté pour la suite
                            // documentation: https://www.php.net/manual/fr/session.examples.basic.php
                            $user_id = $user['id'];
                            $_SESSION['connected_id'] = $user_id;
                            // Etape 8 : Ouvrir l'accès à toutes les pages (redirection vers la page Admin)
                            header("refresh:0;url=admin.php");
                            //echo "Votre connexion est un succès " . $user_id . ".";
                        }
                    }
                    ?>

                    <form action="login.php" method="post">
                        <input type='hidden'name='id' value='$user_id'>
                        <dl>
                            <dt><label for='email'>E-mail</label></dt>
                            <dd><input type='email'name='email'></dd>
                            <dt><label for='motpasse'>Mot de passe</label></dt>
                            <dd><input type='password'name='motpasse'></dd>
                        </dl>
                        <input class="submit" type='submit'>
                    </form>

                    <br>

                    <p>
                        Pas de compte ?
                        <a class="registration" href='registration.php'>Inscrivez-vous.</a>
                    </p>

                </article>

            </main>

        </div>
    </body>
</html>
