<div
    class="relative"
    x-data="{isOpen: false}"
    @close-all.window="isOpen = false"
>
    <span class="item-delete-button-trash-icon">
        <i
                @click.prevent.stop="$dispatch('close-all'); isOpen = true"
                class="fa-regular fa-trash-can"
        ></i>
    </span>

    <div
            x-cloak
            x-show="isOpen"
            @click.outside="isOpen = false"
            x-transition.opacity.duration.200ms
            class="item-delete-button-buttons-wrapper"
    >

        <div class="item-delete-button-small-buttons-wrapper">
            <form action="user/<?=$entityName;?>s/destroy" method="post">
                <input type="hidden" name="token" value="<?=$token;?>">
                <input type="hidden" name="landlord" value="<?=$entityId;?>">
                <input type="submit" class="item-delete-button-input-btn" value="Smazat">
            </form>
            <span @click.stop="isOpen = false">Storno</span>
        </div>

    </div>
</div>