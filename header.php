<?php
    session_start();
    $user_idactuel = isset ( $_SESSION['connected_id']) ?  $_SESSION['connected_id'] : null;
?> 

 <?php /*
if (!isset($_SESSION['email'],$_SESSION['password'])){
echo "Vous devez vous connecter pour acceder à la page !";
}else{
    echo " Vous pouvez continuer !";
} */
?> 



<header>

    <div id="logo">
        <a href='admin.php'><img src="admin_violet.png" alt="Logo de notre réseau social"/></a>
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
            <a href="tags.php?tag_id=">Mots-clés</a>
        <div>

        <div id="user">
            <a href="#">Profil
                <?php
            if (!isset($_SESSION['connected_id'])){
                ?>
                <form method='post' action="login.php">
                 <input type='hidden' name='???' value='a_changer'> 
                <input
                    
                    type="submit"
                    name="submit"
                    value="Se connecter"
                >
                </form> </a>
<?php 
            }else{ 
                ?>
                     </a>
            <ul>
                <li><?php echo "<a href=". "settings.php?user_id=" . "$user_idactuel". ">" ?> Paramètres</a></li>
                <li><?php echo "<a href=". "followers.php?user_id=" . "$user_idactuel". ">" ?> Mes suiveurs</a></li>
                <li><?php echo "<a href=". "subscriptions.php?user_id=" . "$user_idactuel". ">" ?> Mes abonnements</a></li>
                <li><a href="login.php">Déconnexion</a>
                </li>
                <?php
            } ?> 





        
            </ul>
        </div>

    </nav>
    

</header>
