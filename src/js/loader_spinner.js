export function loaderSpinnerModalOn(){
    $('#modal-opacity').addClass('opacity');
    $('.loader-wrapper').removeAttr('style');
    $('#new-admin').attr('disabled', 'disabled').removeClass('submit_button').addClass('submit_button_pushed');
}

export function loaderSpinnerModalOff(){
    $('#modal-opacity').removeClass('opacity');
    $('.loader-wrapper').attr('style', 'display:none;');
    $('#new-admin').removeAttr('disabled').removeClass('submit_button_pushed').addClass('submit_button');
}


export function loaderSpinnerOn(){
    $('#opacity').addClass('opacity');
    $('.loader-wrapper').removeAttr('style');
    $('.profile-form-submit').attr('disabled', 'disabled');
}

export function loaderSpinnerOff(){
    $('#opacity').removeClass('opacity');
    $('.loader-wrapper').attr('style', 'display:none;');
    $('.profile-form-submit').removeAttr('disabled');
}