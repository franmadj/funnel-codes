module.exports = {
    props: ['user'],

    /**
     * The component's data.
     */
    data() {
        return {
            form: $.extend(true, new SparkForm({
                first_name: '',
                last_name: '',
                email: ''
            }), Spark.forms.updateContactInformation)
        };
    },


    /**
     * Bootstrap the component.
     */
    mounted() {
        this.form.first_name = this.user.first_name;
        this.form.last_name = this.user.last_name;
        this.form.email = this.user.email;
    },


    methods: {
        /**
         * Update the user's contact information.
         */
        update() {
            Spark.put('/settings/contact', this.form)
                .then(() => {
                    Bus.$emit('updateUser');
                });
        }
    }
};
