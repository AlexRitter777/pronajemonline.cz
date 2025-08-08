export default () => {

    document.querySelectorAll('.user-item-title').forEach(item => {

        if(item.href === window.location.href) {
            item.classList.add('active-item')
        }
    });

}