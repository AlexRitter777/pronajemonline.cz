export default () => {
    document.querySelectorAll('.user-item-title').forEach(item => {

        const itemPath = new URL(item.href).pathname;

        if(itemPath === window.location.pathname) {
            item.classList.add('active-item')
        }
    });

}