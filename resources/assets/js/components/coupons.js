import common from '../mixin/common';
import Autocomplete from 'vue2-autocomplete-js';
require('vue2-autocomplete-js/dist/style/vue2-autocomplete.css');
import DatePicker from 'vue2-datepicker';
import Pagination from './partials/Pagination.vue';
Vue.component('coupons', {
    props: ['funnel_id'],

    mixins: [common],
    components: {Autocomplete, DatePicker, Pagination},

    mounted() {

    },

    data() {
        return {
            couponBanks: [],
            formData: {
                name: '',
                description: '',
                funnel_id: '',
                type: '',
                codes: ''
            },
            funnelData: {
                name: '',
                description: '',
                starts_at: '',
                ends_at: '',
                preTag: '',
                addedTags: [],
            },
            headerData: {
                name: '',
                starts_at: '',
                ends_at: '',
                tags:[]
            },
            redemptionUrl:''



        };
    },

    created() {
        this.getCouponBanks();
        this.setFunnel(this.funnel_id);
    },

    methods: {
        onPaginate(e) {
            this.currentPage = e.currentPage;
            this.getCouponBanks();
        },
        onItemDisplay(e) {
            this.currentPage = 1;
            this.numItemsDisplay = e.itemsPage;
            this.getCouponBanks();
        },

        couponCodes(id) {
            window.location = window.origin+'/coupon-codes/' + id

        },
        couponRedeemed(id) {
            this.redemptionUrl=window.origin+'/coupon-redemption/'+id;
        },
        couponFields(id) {
            window.location = window.origin+'/coupon-fields/' + id
        },

        resetModal() {
            this.formData = {
                editing: false,
                name: '',
                description: '',
                funnel_id: '',
                type: '',
                codes: '',
                index: 0

            }

        },

        getCouponBanks() {
            this.loading();
            axios.get('/api/couponBanks/' + this.funnel_id + '?page=' + this.currentPage+'&limit='+this.numItemsDisplay).then(response => {
                console.log(response);
                if (response.status === 200 && response.data.status === 200) {
                    this.couponBanks = response.data.data;
                    this.currentPage = response.data.pagination.currentPage;
                    this.totalPages = response.data.pagination.totalPages;


                }
                this.doneLoading()
            });
        },

        createCouponBank() {
            axios.post('/api/couponBanks/' + this.funnel_id, this.formData).then(response => {
                console.log(response);
                if (response.status === 200 && response.data.status === 200) {
                    this.couponBanks.push(response.data.data);

                    $('#CBModal').modal('hide');

                } else {
                    this.$toasted.show(response.data.error.code)
                }

            });
        },

        confirmDelete(id, index) {

            axios.delete('/api/couponBanks/' + id).then(response => {
                if (response.status === 200 && response.data.status === 200) {
                    this.couponBanks.splice(index, 1);

                    $('#deleteCoupon').modal('hide');
                } else {
                    this.$toasted.show('There was an error, try again!')
                }
            })
        },

        editCB(couponBank, index) {
            this.formData = {
                editing: true,
                id: couponBank.id,
                name: couponBank.name,
                description: couponBank.description,
                type: couponBank.type,
                codes: couponBank.codes ? couponBank.codes.join() : '',
                index: index
            }
            $('#CBModal').modal('show');

        },
        duplicateCB(id) {
            axios.get('/api/couponBanks/duplicate/' + id).then(response => {

                if (response.status === 200 && response.data.status === 200) {
                    this.couponBanks.push(response.data.data);

                    $('#CBModal').modal('hide');
                } else {
                    this.$toasted.show(response.data.error.code)
                }
            });

        },

        updateCouponBank() {
            axios.post('/api/couponBanks/update/' + this.formData.id, this.formData).then(response => {
                if (response.status === 200 && response.data.status === 200) {
                    Vue.set(this.couponBanks, this.formData.index, response.data.data);
                    $('#CBModal').modal('hide');
                } else {
                    this.$toasted.show(response.data.error.code)
                }
            })
        },

        /*Funnel I might move it later on*/
        removeTag(index) {
            this.funnelData.addedTags.splice(index, 1);
            this.clearInputTag();


        },
        clearInputTag() {
            setTimeout(() => {
                this.funnelData.preTag = '';
                console.log('e');
                Vue.set(this.funnelData, 'preTag', '');
                $('.autocomplete-input').val('');
            }, 500)

        },
        onSelectTag(obj) {
            let ids = this.funnelData.addedTags.filter(function (el) {
                return el.id == obj.id;
            });
            if (!ids.length)
                this.funnelData.addedTags.push(obj);
            this.clearInputTag();

        },

        resetModal() {
            this.funnelData = {
                editing: false,
                name: '',
                description: '',
                starts_at: '',
                ends_at: '',
                addedTags: [],
            }

        },

        setFunnel(id) {
            axios.get('/api/funnels/' + id).then(response => {
                console.log(response);
                if (response.status === 200 && response.data.status === 200) {
                    this.funnelData = {
                        editing: true,
                        id: response.data.data.id,
                        name: response.data.data.name,
                        description: response.data.data.description,
                        starts_at: response.data.data.starts_at.date,
                        ends_at: response.data.data.ends_at.date,
                        addedTags: response.data.data.tags,
                    }
                    this.setHeader();

                } else {

                    this.$toasted.show(response.data.error.code)
                }
            });

        },
        setHeader() {
            this.headerData = {
                name: this.funnelData.name,
                starts_at: this.funnelData.starts_at,
                ends_at: this.funnelData.ends_at,
                description: this.funnelData.description,
                tags: this.funnelData.addedTags,
            }
          

        },

        dataTransformer() {
            this.funnelData.tags = [];
            this.funnelData.addedTags.map((tag, n) => {
                this.funnelData.tags.push(tag.id);
            });
            this.funnelData.starts_at = this.formatDate(this.funnelData.starts_at, 'DB');
            this.funnelData.ends_at = this.formatDate(this.funnelData.ends_at, 'DB');

        },

        updateFunnel() {
            this.dataTransformer();
            axios.post('/api/funnels/' + this.funnelData.id, this.funnelData).then(response => {
                if (response.status === 200 && response.data.status === 200) {
                    console.log(response);
                    Vue.set(this.funnelData, this.funnelData.index, response.data.data);
                    this.setHeader();
                    $('#funnelModal').modal('hide');
                } else {

                    this.$toasted.show(response.data.error.code)
                }
            });
        },

    }
});
