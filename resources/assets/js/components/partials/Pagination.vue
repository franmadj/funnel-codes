<template>
    <div>
        <p><span v-if="totalPages>1">Page <span>{{currentPage}} of {{totalPages}}</span></span> <span class="pull-right">Items per page: <a :class="{linkdisabled:numItemsDisplay==25}" href="#" @click.prevent="itemsPerPage(25)">25</a> | <a :class="{linkdisabled:numItemsDisplay==50}" href="#" @click.prevent="itemsPerPage(50)">50</a> | <a :class="{linkdisabled:numItemsDisplay==100}" href="#" @click.prevent="itemsPerPage(100)">100</a></span></p>
        <nav aria-label="..." v-if="totalPages>1">
            <ul class="pager">
                <li ><a :class="currentPage>1 ? '' : 'linkdisabled'"  href="#" @click.prevent="paginate('p')">Previous</a></li>
                <li ><a :class="currentPage<totalPages ? '' : 'linkdisabled'" href="#" @click.prevent="paginate('n')">Next</a></li>
            </ul>
        </nav>
    </div>
</template>
<script>
    export default {
        props: ['currentPage', 'totalPages','numItemsDisplay'],
        data() {
            return{
                myCurrentPage: this.currentPage,
            }
        },

        methods: {
            paginate(action) {
                if (action == 'n') {
                    this.myCurrentPage++;
                } else {
                    this.myCurrentPage--;
                }
                this.$emit('on-paginate', {currentPage: this.myCurrentPage});
            },
            itemsPerPage(number) { 
                this.$emit('itemdisplay', {itemsPage: number});
            },

        }
    }
</script>
