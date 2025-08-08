
<header class="header">
    <div class="header-inner">

        <div class="header-logo">
            <a href="/user/account" class="logo-link">
                    <img class="logo-image" src="img/PronajemOnline_logo_transparent.png" alt="PronajemOnline Logo" height="40px">
            </a>
        </div>
        <div class="header-right">
            <div class="header-login" x-data="{user_menu_open: false}">
                <span class="user_welcome">Ahoj,&nbsp</span><a href="" @click.prevent.stop="user_menu_open = !user_menu_open"  class="user_name"><?= $_SESSION['username']; ?>.</a>
                <div x-show="user_menu_open" x-cloak @click.outside="user_menu_open = false" class="header-user-menu">
                    <a class="login_link" href="user/settings"><i class="fa-solid fa-gear"></i> Nastavení</a>
                    <a class="login_link" href="user/logout"><i class="fa-solid fa-arrow-right-from-bracket"></i> Odhlásit se</a>
                </div>
            </div>
        </div>
        <button class="burger" type="button" id="navToggle">
            <span class="burger__item">Menu</span>
        </button>




    </div>
</header>