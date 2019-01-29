import common from '../mixin/common';
import Pagination from './partials/Pagination.vue';
Vue.component('codes', {
    props: ['coupon_bank_id', 'funnel_id'],
    components: {Pagination},

    mixins: [common],

    data() {
        return {
            couponCodes: [],

            formData: {
                code: '',
                coupon_bank_id: '',
                busy: false
            },
            bank: {
                name: '',
                description: '',
                type: '',
            },
            filterCode: 'all',
            redemptionDetails: '',
            itemsCount: true,
            reults: true,
            exportRedemptions:false


        };
    },

    created() {
        this.getCouponCodes();
        this.setCouponBank(this.coupon_bank_id);
    },

    methods: {
       
        setCouponBank(id) {
            axios.get('/api/couponBanks/show/' + id).then(response => {

                console.log(response);
                if (response.status === 200 && response.data.status === 200) {
                    this.bank = {
                        id: response.data.data.id,
                        name: response.data.data.name,
                        description: response.data.data.description,
                        type: response.data.data.type

                    }

                } else {

                    this.$toasted.show(response.data.error.code)
                }
            });

        },
        onPaginate(e) {
            this.currentPage = e.currentPage;
            this.getCouponCodes();
        },
        onItemDisplay(e) {
            this.currentPage = 1;
            this.numItemsDisplay = e.itemsPage;
            this.getCouponCodes();
        },

        resetModal() {
            this.formData = {
                editing: false,
                code: '',
                coupon_bank_id: '',
                index: 0,
                busy: false

            }

        },
        viewRedemption(data) {
            this.redemptionDetails = data;
            $('#redemption-modal').modal('show');

        },

        getCouponCodes(filter = false) {
            this.loading();
            this.couponCodes = [];
            this.itemsCount = true;
            this.results = true;
            this.exportRedemptions=false;
            axios.get('/api/couponCodes/' + this.coupon_bank_id + '/?page=' + this.currentPage + '&limit=' + this.numItemsDisplay + '&type=' + this.filterCode).then(response => {
                console.log(response);
                if (response.status === 200 && response.data.status === 200) {
                    this.couponCodes = response.data.data;
                    this.currentPage = response.data.pagination.currentPage;
                    this.totalPages = response.data.pagination.totalPages;
                }
                if (!this.couponCodes.length) {
                    
                    if (!filter) {
                        this.itemsCount = false;
                    } else {
                        this.results = false;
                    }
                }else{
                    for(let el in this.couponCodes){
                        if(this.couponCodes[el].redeemed){
                            this.exportRedemptions=true;
                            break;
                        } 
                    }
                }
                this.doneLoading();
            });
        },

        createCouponCode() {
            this.formData.busy = true;
            axios.post('/api/couponCodes/' + this.coupon_bank_id, this.formData).then(response => {
                console.log(response);
                if (response.status === 200 && response.data.status === 200 && Array.isArray(response.data.data)) {
                    response.data.data.map((el, i) => {
                        this.couponCodes.push(el);
                    });
                    $('#CCModal').modal('hide');
                } else {
                    this.formData.busy = false;
                    this.$toasted.show(response.data.error.code)
                }

            });
        },

        confirmDelete(id, index) {

            axios.delete('/api/couponCodes/' + id).then(response => {
                if (response.status === 200 && response.data.status === 200) {
                    this.couponCodes.splice(index, 1);
                    $('#deleteCode').modal('hide');
                } else {
                    this.$toasted.show('There was an error, try again!')
                }
            })
        },

        editCode(couponCode, index) {
            this.formData = {
                editing: true,
                id: couponCode.id,
                code: couponCode.code,
                index: index,
                busy: false

            }
            $('#CCModal').modal('show');

        },

        updateCouponCode() {
            this.formData.busy = true;
            axios.post('/api/couponCodes/update/' + this.formData.id, this.formData).then(response => {
                console.log(response);
                if (response.status === 200 && response.data.status === 200 && response.data.data != null) {
                    Vue.set(this.couponCodes, this.formData.index, response.data.data);
                    $('#CCModal').modal('hide');
                } else if (response.data.error) {
                    this.$toasted.show(response.data.error.code)
                } else {
                    $('#CCModal').modal('hide');
                }
                this.formData.busy = false;
            })
        },

    }
});
