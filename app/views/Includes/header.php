
<header class="header">
    <div class="header-inner">

        <div class="header-logo">
            <a href="\" class="logo-link">
                <div class="logo-items">
                    <h1 class="header-title">pronajemonline.cz</h1>
                    <h2 class="header-subtitle">Správa nemovitostí a pronájmů</h2>
                </div>

                <img class="logo-image" src="img/keys.png" alt="keys" height="40px">

            </a>
        </div>
        <div class="header-right">
            <div class="header-login">
                <?php if(is_user_logged_in()): ?>
                    <span class="user_welcome">Ahoj,&nbsp</span><a href="user/account" class="user_name"><?= $_SESSION['username']; ?>.</a>
                    <a class="login_link" style="width: 90px;" href="user/account">Můj účet</a>
                    <a class="login_link" style="width: 90px;" href="user/logout">Odhlásit se</a>
                <?php else: ?>
                    <a class="login_link" href="user/signup">Registrace /</a>
                    <a class="login_link" href="user/login">Přihlášení</a>
                <?php endif;?>
            </div>

            <nav class="header-menu" id="nav">
                <a class="nav_link" href="\">Home</a>
                <a class="nav_link" href="about">O projektu</a>
                <a class="nav_link" href="applications">Aplikace</a>
                <a class="nav_link" href="blog">Blog</a>
                <a class="nav_link" href="contact">Kontakt</a>
            </nav>
        </div>

        <button class="burger" type="button" id="navToggle">
            <span class="burger__item">Menu</span>
        </button>



    </div>
</header>