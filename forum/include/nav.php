<div role="navigation">
    <nav class="main-menu">
        <div>
            <div class="settings"></div>
            <div class="scrollbar" id="style-1">
                <ul>
                    <li><a href="<?php echo $forum_http ?>/index.php"><i class="fa fa-home fa-lg"></i>
                        <span class="nav-text">Home</span></a></li>
                    <li><a href="<?php echo $forum_http ?>/pages/forum.php"><i class="fa fa-sitemap"></i><span class="nav-text">Forum</span></a></li>

        <?php if($logged_in === false){
         echo '<li><a href="'.$forum_http.'/include/access/register.php"><i class="fa fa-user-plus"></i><span class="nav-text">Register</span></a></li>';
}
        ?>

                
                <?php if($logged_in === true){
         echo '<li class="darkerli">
                    <a href="'.$forum_http.'/pages/create.php">
                        <i class="fa fa-pencil-square-o"></i>
                        <span class="nav-text">Create</span>
                    </a>
                </li>';
}
        ?>

                
                <?php if($logged_in === true){
                echo "<li class='darkerli'>
                    <a class='welcome'><i class='fa fa-user'></i><span class='nav-text'>User: " . $_SESSION['users']['username'] . "</span></a>
                </li>";                                        
                    }
                ?>
                            <?php if($logged_in === false){
         echo '<li><a href="'.$forum_http.'/include/access/login.php"><i class="fa fa-toggle-off"></i>
                        <span class="nav-text">Login</span></a></li>';
}
        ?>
                <?php if($logged_in === true){
         echo '<li><a href="'.$forum_http.'/include/access/logout.php"><i class="fa fa-toggle-on"></i><span class="nav-text">Logout</span></a></li>';
}
        ?>

            </ul>

            <ul>
                <li>
                    <a href="<?php echo $forum_http ?>/pages/help.php">
                        <i class="fa fa-question-circle fa-lg"></i>
                        <span class="nav-text">Help</span>
                    </a>
                </li>


            </ul>

            </div>
    </nav>
</div>