import common from './../mixin/common';
import Autocomplete from 'vue2-autocomplete-js';
require('vue2-autocomplete-js/dist/style/vue2-autocomplete.css');
import DatePicker from 'vue2-datepicker';
import Pagination from './partials/Pagination.vue';
Vue.component('home', {
    props: ['user'],
    mixins: [common],
    components: {Autocomplete, DatePicker, Pagination},

    mounted() {
        //this.loaded = true;
    },

    data() {
        return {
            funnels: [],
            formData: {
                name: '',
                description: '',
                starts_at: '',
                ends_at: '',
                preTag: '',
                addedTags: [],
            },
            filters: {
                tags: [],
                expire: 'any',
                range: ''
            },
            itemsCount: true,
            reults: true
        };
    },

    created() {
        this.getFunnels();
        this.getFilterTags();
    },

    methods: {
        onPaginate(e) {
            this.currentPage = e.currentPage;
            this.filterFunnel();
        },
        onItemDisplay(e) {

            this.numItemsDisplay = e.itemsPage;
            this.filterFunnel(true);
        },

        getFilterTags() {
            axios.get('/api/tags/?filter=1').then(response => {
                console.log(response);
                if (response.status === 200 && response.data.status === 200) {
                    this.filters.tags = response.data.data;
                }

            });

        },

        removeTag(index) {
            this.formData.addedTags.splice(index, 1);
            this.clearInputTag();


        },
        clearInputTag() {
            setTimeout(() => {
                this.formData.preTag = '';
                console.log('e');
                Vue.set(this.formData, 'preTag', '');
                $('.autocomplete-input').val('');
            }, 500)

        },
        onSelectTag(obj) {
            let ids = this.formData.addedTags.filter(function (el) {
                return el.id == obj.id;
            });
            if (!ids.length)
                this.formData.addedTags.push(obj);
            this.clearInputTag();

        },

        resetModal() {
            this.formData = {
                editing: false,
                name: '',
                description: '',
                starts_at: '',
                ends_at: '',
                addedTags: [],
            }

        },
        resetFunnels() {
            this.funnels = [];
            this.itemsCount = true;
            this.results = true;
        },

        getFunnels() {
            this.loading();
            this.resetFunnels();
            axios.get('/api/funnels/?limit=' + this.numItemsDisplay + '&page=' + this.currentPage).then(response => {
                console.log(response);
                if (response.status === 200 && response.data.status === 200) {
                    this.funnels = response.data.data;
                    this.currentPage = response.data.pagination.currentPage;
                    this.totalPages = response.data.pagination.totalPages;
                    this.totalItems = response.data.pagination.total;
                    this.doneLoading();
                }
                if (!this.funnels.length)
                    this.itemsCount = false;

            });

        },
        filterFunnel(resetPages = false) {
            this.resetFunnels();
            if (resetPages)
                this.currentPage = 1;
            this.loading();
            setTimeout(() => {
                let tags = [];
                this.filters.tags.map((el) => {
                    if (el.checked)
                        tags.push(el.id);
                });
                let data = {tags: tags, expire: this.filters.expire, limit: this.numItemsDisplay, page: this.currentPage};

                console.log(this.filters);

                axios.post('/api/funnels/filter', data).then(response => {
                    console.log(response);
                    if (response.status === 200 && response.data.status === 200) {
                        this.funnels = response.data.data;
                        this.currentPage = response.data.pagination.currentPage;
                        this.totalPages = response.data.pagination.totalPages;
                        this.totalItems = response.data.pagination.total;

                    }
                    this.doneLoading();
                    if (!this.funnels.length)
                        this.results = false;


                });
            }, 50)

        },

        dataTransformer() {
            this.formData.tags = [];
            this.formData.addedTags.map((tag, n) => {
                this.formData.tags.push(tag.id);
            });
            this.formData.starts_at = this.formatDate(this.formData.starts_at, 'DB');
            this.formData.ends_at = this.formatDate(this.formData.ends_at, 'DB');

        },

        createFunnel() {
            this.dataTransformer();
            axios.post('/api/funnels', this.formData).then(funnel => {
                console.log(funnel);
                if (funnel.status === 200 && funnel.data.status === 200) {
                    this.funnels.push(funnel.data.data);
                    $('#funnelModal').modal('hide');
                } else {
                    this.$toasted.show(funnel.data.error.code)
                }

            });
        },

        confirmDeleteFunnel(id, index) {

            axios.delete('/api/funnels/' + id).then(response => {
                if (response.status === 200 && response.data.status === 200) {
                    this.funnels.splice(index, 1);
                    $('#deleteFunnel').modal('hide');
                } else {
                    this.$toasted.show('There was an error, try again!')
                }
            })
        },

        editFunnel(funnel, index) {
            console.log(funnel.name);
            this.formData = {
                editing: true,
                id: funnel.id,
                name: funnel.name,
                description: funnel.description,
                starts_at: moment(funnel.starts_at.date).format(this.config.format),
                ends_at: moment(funnel.ends_at.date).format(this.config.format),
                index: index,
                addedTags: funnel.tags,
            }
            $('#funnelModal').modal('show');

        },

        updateFunnel() {
            this.dataTransformer();
            axios.post('/api/funnels/' + this.formData.id, this.formData).then(response => {
                console.log(response);
                if (response.status === 200 && response.data.status === 200) {
                    Vue.set(this.funnels, this.formData.index, response.data.data);
                    $('#funnelModal').modal('hide');
                } else {
                    this.$toasted.show(response.data.error.code)
                }
            })
        },
        viewBankCodes(funnel_id) {
            window.location = "/funnel/" + funnel_id;

        },

    }
});
