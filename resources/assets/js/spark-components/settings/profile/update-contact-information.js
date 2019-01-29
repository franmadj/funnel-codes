var base = require('settings/profile/update-contact-information');

Vue.component('spark-update-contact-information', {
    mixins: [base],

    /**
     * The component's data.
     */
    data() {
        return {
            form: $.extend(true, new SparkForm({
                name: '',
                email: '',
                last_name:''
            }), Spark.forms.updateContactInformation)
        };
    },

    /**
     * Bootstrap the component.
     */
    mounted() {
        this.form.name = this.user.name;
        this.form.email = this.user.email;
        this.form.last_name = this.user.last_name;
    },
});
