import common from '../mixin/common';
import { Chrome } from 'vue-color';
import Pagination from './partials/Pagination.vue';
Vue.component('tags', {
    props: ['user'],
    mixins: [common],
    components: {
        'chrome-picker': Chrome,
        Pagination
    },

    mounted() {

    },

    data() {
        return {
            tags: [],

            formData: {
                name: '',
                color: '',
            },
        };
    },

    created() {
        this.getTags();
    },

    methods: {
        onPaginate(e) {
            this.currentPage = e.currentPage;
            this.getTags();
        },
        onItemDisplay(e) {
            this.currentPage = 1;
            this.numItemsDisplay = e.itemsPage;
            this.getTags();
        },


        resetModal() {
            this.formData = {
                editing: false,
                name: '',
                color: {
                    hex: '#194d33',
                    hsl: {
                        h: 150,
                        s: 0.5,
                        l: 0.2,
                        a: 1
                    },
                    hsv: {
                        h: 150,
                        s: 0.66,
                        v: 0.30,
                        a: 1
                    },
                    rgba: {
                        r: 25,
                        g: 77,
                        b: 51,
                        a: 1
                    },
                    a: 1
                },

            }

        },

        getTags() {
            this.loading();
            axios.get('/api/tags/?page=' + this.currentPage + '&limit=' + this.numItemsDisplay).then(response => {
                console.log(response);
                if (response.status === 200 && response.data.status === 200) {
                    this.tags = response.data.data;
                    this.currentPage = response.data.pagination.currentPage;
                    this.totalPages = response.data.pagination.totalPages;

                }
                this.doneLoading();
            });
        },

        createTag() {
            axios.post('/api/tags', this.formData).then(tag => {
                console.log(tag);
                if (tag.status === 200 && tag.data.status === 200) {
                    this.tags.push(tag.data.data);
                    $('#tagModal').modal('hide');
                } else {
                    this.$toasted.show(tag.data.error.code)
                }

            });
        },

        confirmDeleteTag(id, index) {
            axios.delete('/api/tags/' + id).then(response => {
                console.log(response);
                if (response.status === 200 && response.data.status === 200) {
                    this.getTags();

                    $('#deleteTag').modal('hide');
                } else {
                    this.$toasted.show('There was an error, try again!')
                }
            })
        },

        editTag(tag, index) {
            this.formData = {
                editing: true,
                id: tag.id,
                name: tag.name,
                color: tag.color,
                index: index,
            }
            $('#tagModal').modal('show');

        },

        updateTag() {
            axios.post('/api/tags/' + this.formData.id, this.formData).then(response => {
                if (response.status === 200 && tag.data.status === 200) {
                    Vue.set(this.tags, this.formData.index, response.data.data);
                    $('#tagModal').modal('hide');
                } else {
                    this.$toasted.show(response.data.error.code)
                }
            })
        },
        viewTag(tag) {

        },

        

    }
});
