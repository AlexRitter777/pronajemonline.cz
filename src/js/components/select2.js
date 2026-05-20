
export default (options = {}) => ({

    init() {
        console.log('select2 init');

        this.select = window.$(this.$root);

        this.select.select2(options);

        this.select.on('change', () => {

            this.$dispatch('change', this.select.val());

        });
    },


    destroy() {
        if (this.select) {

            this.select.select2('destroy');

            }
        },

})