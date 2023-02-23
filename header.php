<?php
    session_start();
    $user_idactuel = isset ($_SESSION['connected_id']) ?  $_SESSION['connected_id'] : null;
?>

<header>

    <div id="logo">
        <a href='admin.php'><img src="admin_violet.png" alt="Logo de notre réseau social"/></a>
    </div>

    <nav id="menu">

    <!-- MENU QUAND ON N'EST PAS CONNECTE -->
                
    <?php if (!isset($_SESSION['connected_id'])) { ?>

        <div class="lienMenu">
            <a href="news.php">Actualités</a>
        <div>

        <div class="lienMenu">
            <a href="tags.php?tag_id=">Mots-clés</a>
        <div>

        <div class="lienMenu">
            <form method='post' action="login.php">
                <input type='hidden' name='???' value='a_changer'>
                <input
                    class="submit"
                    id="connexion"
                    type="submit"
                    name="submit"
                    value="Se connecter"
                >
            </form>
        </div>

    <!-- MENU QUAND ON EST CONNECTE -->
           
    <?php } else { ?>

        <div class="lienMenu">
            <a href="news.php">Actualités</a>
        <div>

        <div class="lienMenu">
            <?php echo "<a href=". "wall.php?user_id=" . "$user_idactuel". ">" ?> Mur</a>
        <div>

        <div class="lienMenu">
            <?php echo "<a href=". "feed.php?user_id=" . "$user_idactuel". ">" ?> Flux</a>
        <div>

        <div class="lienMenu">
            <a href="tags.php?tag_id=">Mots-clés</a>
        <div>

        <div id="user">
                <a href="#">Profil
                    <ul>
                        <li><?php echo "<a href=". "settings.php?user_id=" . "$user_idactuel". ">" ?> Paramètres</a></li>
                        <li><?php echo "<a href=". "followers.php?user_id=" . "$user_idactuel". ">" ?> Mes suiveurs</a></li>
                        <li><?php echo "<a href=". "subscriptions.php?user_id=" . "$user_idactuel". ">" ?> Mes abonnements</a></li>
                        <li><a href="login.php">Déconnexion</a></li>
                    </ul>
                </a>
        </div>

    <?php } ?>

    </nav>
    
</header>
