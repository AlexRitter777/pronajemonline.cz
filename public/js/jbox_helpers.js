export function closeModalOnCross(modalWindow = null, id = 'jBox'){
    const modalCloseCross = document.querySelector(`#${id}-overlay .jBox-closeButton svg`);
    modalCloseCross.addEventListener('click', function () {
    modalWindow.destroy();
    })

}

export function closeModalOnButton(modalWindow = null, id = 'jBox'){
    const modalCloseButton = document.querySelector(`#${id} .submit_button_refresh_modal`);
    modalCloseButton.addEventListener('click', function () {
        modalWindow.destroy();
    })

}

export function closeOnClickOutside(modalWindow = null){
    document.addEventListener('click', function (e) {
        if (modalWindow) {
            if (!e.target.closest('.jBox-container')) {
                modalWindow.destroy();
            }
        }
    });
}


function removeJboxTraces(){
    //everytime JBox create new Modal window,
    //every time after close modal window we should delete the old one
    //because we have more than one modal box in different files, we dont use destroy() method
    document.querySelectorAll('.jBox-wrapper').forEach(element => element.remove());
    document.querySelectorAll('.jBox-overlay').forEach(element => element.remove());
}