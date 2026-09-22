export function loaderSpinnerModalOn(){
    $('#modal-opacity').addClass('opacity');
    $('.loader-wrapper').removeAttr('style');
    $('.btn-submit').attr('disabled', 'disabled');
}

export function loaderSpinnerModalOff(){
    $('#modal-opacity').removeClass('opacity');
    $('.loader-wrapper').attr('style', 'display:none;');
    $('.btn-submit').removeAttr('disabled');
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