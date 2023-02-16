<?php
    session_start();
    $user_idactuel = $_SESSION['connected_id']
?>



<header>

    <a href='admin.php'>
        <img src="resoc.jpg" alt="Logo de notre réseau social"/>
    </a>

    <nav id="menu">
        <a href="news.php">Actualités</a>
        <?php echo "<a href=". "wall.php?user_id=" . "$user_idactuel". ">" ?> Mur</a>
        <?php echo "<a href=". "feed.php?user_id=" . "$user_idactuel". ">" ?> Flux</a>
        <!-- <a href="tags.php?tag_id=9">Mots-clés</a> -->
        <a href="tags.php">Mots-clés</a>
    </nav>

    <nav id="user">
        <a href="#">Profil</a>
        <ul>
            <li><?php echo "<a href=". "settings.php?user_id=" . "$user_idactuel". ">" ?> Paramètres</a></li>
            <li><?php echo "<a href=". "followers.php?user_id=" . "$user_idactuel". ">" ?> Mes suiveurs</a></li>
            <li><?php echo "<a href=". "subscriptions.php?user_id=" . "$user_idactuel". ">" ?> Flux</a></li>
            <li><a href="login.php">Déconnexion</a></li>
        </ul>
    </nav>

</header>
