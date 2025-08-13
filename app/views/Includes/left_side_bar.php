
    <div class="cross-close">
        <svg fill="#000000" height="20px" width="20px" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
             viewBox="0 0 490 490" xml:space="preserve">
            <polygon points="456.851,0 245,212.564 33.149,0 0.708,32.337 212.669,245.004 0.708,457.678 33.149,490 245,277.443 456.851,490
	        489.292,457.678 277.331,245.004 489.292,32.337 "/>
        </svg>
    </div>
    <ul class="user-items-title">
        <li
            style="border-bottom: solid 1px #C9EED2; padding-bottom: 20px; position: relative;"
            x-data="{isSidebarModalOpen: false}"
        >
            <a
                style="display: block; width: 100%"
                href=""
                class="user-item-title"
                @click.prevent="isSidebarModalOpen = !isSidebarModalOpen"
                @click.outside="isSidebarModalOpen = false"
            >
                <i class="fa-regular fa-square-plus">
                </i> Nový <i style="text-align: right"  class="fa-solid fa-angle-right"></i></a>
            <div
                class="sidebar-modal"
                x-show="isSidebarModalOpen"
                x-transition.opacity.duration.200ms
                x-cloak
            >
                <ul>
                    <li><a href="user/calculations"><i class="far fa-file-alt"></i> Vyúčtování</a></li>
                    <li><a href="user/properties/add"><i class="far fa-building"></i> Nemovitost</a></li>
                    <li><a href="user/tenants/add"><i class="far fa-user"></i> Nájemník</a></li>
                    <li><a href="user/landlords/add"><i class="fa-regular fa-circle-user"></i> Pronájímatel</a></li>
                    <li><a href="user/admins/add"><i class="fa-regular fa-handshake"></i> Správce</a></li>
                    <li><a href="user/elsuppliers/add"><i class="fa-regular fa-lightbulb"></i> Dodavatel elektřiny</a></li>
                </ul>
            </div>
        </li>


        <li><a href="user/account" class="user-item-title"><i class="fa-regular fa-house"></i> Přehled</a></li>
        <li><a href="user/calculations" class="user-item-title"><i class="far fa-file-alt"></i> Vyúčtování</a></li>
        <li><a href="user/landlords" class="user-item-title"><i class="fa-regular fa-circle-user"></i> Pronajímatele</a></li>
        <li><a href="user/tenants" class="user-item-title"><i class="far fa-user"></i> Nájemníci</a></li>
        <li><a href="user/properties" class="user-item-title"><i class="far fa-building"></i> Nemovitosti</a></li>
        <li><a href="user/admins" class="user-item-title"><i class="fa-regular fa-handshake"></i> Správci</a>
        <li><a href="user/elsuppliers" class="user-item-title"><i class="fa-regular fa-lightbulb"></i> Dodavatelé elektřiny</a></li>
        <li><a href="user/settings" class="user-item-title"><i class="fa-solid fa-gear"></i> Nastavení</a></li>
        <li><a href="user/settings" class="user-item-title"><i class="fa-solid fa-arrow-right-from-bracket"></i> Odhlásit se</a></li>

        <li style="border-top: solid 1px #C9EED2; padding-top: 30px; margin-top: 20px"><a href="user/settings" class="user-item-title"><i class="fa-regular fa-file-word"></i> Šablony</a></li>
        <li><a href="user/settings" class="user-item-title"><i class="fa-solid fa-book"></i> Dokumentace</a></li>
        <li><a href="user/settings" class="user-item-title"><i class="fa-regular fa-circle-question"></i> Podpora</a></li>

    </ul>


