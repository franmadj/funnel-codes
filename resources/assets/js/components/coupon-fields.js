import common from '../mixin/common';
import Pagination from './partials/Pagination.vue';
Vue.component('fields', {
    props: ['coupon_bank_id'],
    components: {Pagination},
    mixins: [common],

    data() {
        return {
            couponFields: [],

            formData: {
                name: '',
                description: '',
                required: '',
                validationType: '',
                id: '',
                field_type: '',
                busy: false
            },
        };
    },

    created() {
        this.getCouponFields();
    },

    methods: {
        onPaginate(e) {
            this.currentPage = e.currentPage;
            this.getCouponFields();
        },
        onItemDisplay(e) {
            this.currentPage = 1;
            this.numItemsDisplay = e.itemsPage;
            this.getCouponFields();
        },

        resetModal() {
            this.formData = {
                editing: false,
                name: '',
                description: '',
                required: '',
                validation_type: '',
                id: '',
                field_type: '',
                busy: false

            }

        },
        getCouponFields() {
            this.loading();

            axios.get('/api/couponFields/' + this.coupon_bank_id + '/?page=' + this.currentPage+'&limit='+this.numItemsDisplay).then(response => {
                console.log(response);
                if (response.status === 200 && response.data.status === 200) {
                    this.couponFields = response.data.data;
                    this.currentPage = response.data.pagination.currentPage;
                    this.totalPages = response.data.pagination.totalPages;
                    

                }
                this.doneLoading();
            });
        },
        
        confirmDelete(id, index) {

            axios.delete('/api/couponFields/' + id).then(response => {
                if (response.status === 200 && response.data.status === 200) {
                    this.couponFields.splice(index, 1);
                    $('#deleteCode').modal('hide');
                } else {
                    this.$toasted.show('There was an error, try again!')
                }
            })
        },

        createCouponField() {
            axios.post('/api/couponFields/' + this.coupon_bank_id, this.formData).then(response => {
                console.log(response);
                if (response.status === 200 && response.data.status === 200) {
                    this.couponFields.push(response.data.data);

                    $('#CFModal').modal('hide');

                } else {

                    this.$toasted.show(response.data.error.code)
                }

            });
        },

        editCF(couponField, index) {
            this.formData = {
                editing: true,
                index: index,
                name: couponField.name,
                description: couponField.description,
                required: couponField.required,
                validation_type: couponField.validation_type,
                id: couponField.id,
                field_type: couponField.field_type,
                busy: false
            }
            $('#CFModal').modal('show');

        },

        updateCouponField() {
            axios.post('/api/couponFields/update/' + this.formData.id, this.formData).then(response => {
                if (response.status === 200 && response.data.status === 200) {
                    Vue.set(this.couponFields, this.formData.index, response.data.data);
                    $('#CFModal').modal('hide');
                }else {

                    this.$toasted.show(response.data.error.code)
                }
            })
        },

    }
});
