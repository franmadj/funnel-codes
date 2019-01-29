import common from '../mixin/common';
Vue.component('redemptions', {
    props: ['funnel', 'validations', 'couponBank'],
    mixins: [common],

    data() {
        return {

            formData: [],
            countDown: '',
            email: '',
            redemedCuponCode: false

        };
    },

    created() {
        this.startCountDown();
    },

    methods: {
        getCode() {
            this.formData = [];
            console.log(this.email);
            let error = false;
            this.validations.map((el, i) => {
                let value = $('#' + el.field_type + '_' + i).val();
                if (el.required && !value) {
                    error = true;
                    this.$toasted.show(el.name + " field is required");
                }
                if (!error)
                    switch (el.field_type) {
                        case 'email':
                            var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
                            error = !re.test(String(value).toLowerCase());
                            if (error)
                                this.$toasted.show(el.name + " field is not correct email format");
                            break;
//                        case 'phone':
//                            var re = /^(\([0-9]{3}\)\s?|[0-9]{3}-)[0-9]{3}-[0-9]{4}$/;
//                            error = !re.test(String(value).toLowerCase());
//                            if (error)
//                                this.$toasted.show(el.name + " field is not correct phone format");
//                            break;
                    }
                this.formData.push({key: el.field_type + '_' + i, value: $('#' + el.field_type + '_' + i).val()});
            });
            console.log(error);

            if (!error) {
                //check if entered fields do not exists
                axios.post('/api/couponCodes/getCode/' + this.couponBank.id, this.formData).then(response => {
                    console.log(response);
                    if (response.status === 200 && response.data.status === 200) {
                        this.redemedCuponCode = response.data.data.code;
                        console.log(this.redemedCuponCode);

                    } else {

                        this.$toasted.show(response.data.error.code);
                    }

                });
            }
        },
        twoDigits(n) {
            return n > 9 ? "" + n : "0" + n;
        },
        startCountDown() {

            // Set the date we're counting down to
            var countDownDate = new Date(this.funnel.ends_at).getTime();

// Update the count down every 1 second
            var x = setInterval(() => {

                // Get todays date and time
                var now = new Date().getTime();

                // Find the distance between now an the count down date
                var distance = countDownDate - now;

                // Time calculations for days, hours, minutes and seconds
                var days = Math.floor(distance / (1000 * 60 * 60 * 24));
                var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                var seconds = Math.floor((distance % (1000 * 60)) / 1000);

                // Display the result in the element with id="demo"
                this.countDown = this.twoDigits(days) + ":" + this.twoDigits(hours) + ":" + this.twoDigits(minutes) + ":" + this.twoDigits(seconds);


                // If the count down is finished, write some text 
                if (distance < 0) {
                    clearInterval(x);
                    this.countDown = "EXPIRED";
                }
            }, 1000);
        },

    }
});
