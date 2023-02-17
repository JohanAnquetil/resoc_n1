<?php
    session_start();
    $user_idactuel = $_SESSION['connected_id']
?>



<header>

    <div id="logo">
        <a href='admin.php'><img src="resoc.jpg" alt="Logo de notre réseau social"/></a>
    </div>

    <nav id="menu">

        <div class="lienMenu">
            <a href="news.php">Actualités</a>
        <div>

        <div class="lienMenu">
            <?php echo "<a href=". "wall.php?user_id=" . "$user_idactuel". ">" ?> Mur</a>
        <div>

        <div class="lienMenu">
            <?php echo "<a href=". "feed.php?user_id=" . "$user_idactuel". ">" ?> Flux</a>
        <div>

        <!-- <a href="tags.php?tag_id=9">Mots-clés</a> -->
        <div class="lienMenu">
            <a href="tags.php">Mots-clés</a>
        <div>

        <div id="user">
            <a href="#">Profil</a>
            <ul>
                <li><?php echo "<a href=". "settings.php?user_id=" . "$user_idactuel". ">" ?> Paramètres</a></li>
                <li><?php echo "<a href=". "followers.php?user_id=" . "$user_idactuel". ">" ?> Mes suiveurs</a></li>
                <li><?php echo "<a href=". "subscriptions.php?user_id=" . "$user_idactuel". ">" ?> Mes abonnements</a></li>
                <li><a href="login.php">Déconnexion</a></li>
            </ul>
        </div>

    </nav>
    

</header>
