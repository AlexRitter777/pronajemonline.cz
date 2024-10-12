
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
                    <span class="user_welcome">Ahoj,&nbsp</span><a href="admin" class="user_name"><?= $_SESSION['username']; ?>.</a>
                    <a class="login_link" style="width: 90px;" href="user/logout">Odhlásit se</a>
            </div>

            <nav class="header-menu" id="nav">
                <a class="nav_link" href="\">Go to web</a>
            </nav>
        </div>

        <button class="burger" type="button" id="navToggle">
            <span class="burger__item">Menu</span>
        </button>



    </div>
</header>