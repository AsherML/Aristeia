<?php include_once("includes/sessions.php");?>

<header>
    <section class="nav_bar">
        <h1>Alexandria</h1>
        <nav>
            <ul>
                <li><a href="/">Authors</a></li>
                <li><a href="/books">Books</a></li>
                <?php if(!is_user_logged_in()) { ?>
                    <li><a href="/accountCreation">Create-Account</a></li>
                    <li><button id="open_login">Log In</button></li>
                <?php } else {?>
                    <li><a href="/author?id=<?php echo $current_user['id'];?>">My Profile</a></li>
                    <a href="<?php echo logout_url();?>" class="logout">Log Out</a>
                <?php } ?>

            </ul>
        </nav>
    </section>
    <?php echo_login_form($current_page, $session_messages);?>

</header>
