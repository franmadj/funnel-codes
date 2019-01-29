var base = require('auth/register-stripe');

Vue.component('spark-register-stripe', {
    mixins: [base],
    methods:{
        /*
         * After obtaining the Stripe token, send the registration to Spark.
         */
        sendRegistration() {
            Spark.post('/register', this.registerForm)
                .then(response => { 
                    window.location = '/settings';
                });
        }
    }
});
