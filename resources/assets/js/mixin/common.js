export default {
    data() {
        return {
            config: {
                human: 'MMMM Do YYYY, h:mm:ss a',
                short: 'M/D/Y [at] h:mm A',
                DB: 'YYYY-MM-DD HH:mm:ss',
            },
            loaded:false,
            siteDomain:window.origin,
            currentPage: 1,
            totalPages: 0,
            totalItems: 0,
            idToDelete:0,
            indexToDelete:0,
            numItemsDisplay: 25, 
        }
    },
    methods: {
        showOpenDialog(id) {
            document.getElementById(id).click()
        },
        attachFile(event, post = false) {
            let input = event.target
            if (input.files && input.files[0]) {
                let reader = new FileReader()
                let vm = this
                reader.onload = function (e) {
                    vm.commentPostImage = e.target.result
                    if (vm.attachedCommentImage) {
                        vm.attachedCommentImage = e.target.result
                    }
                    if (post) {
                        vm.post.file = input.files[0]
                        if (vm.post.name) {
                            vm.post.name = input.files[0].filename
                        }
                    }
                }
                reader.readAsDataURL(input.files[0]);
        }

        },
        formatDate(date,format='human') {
            return moment(date).format(this.config[format]);
        },
        loading() {
            this.loaded = false;
        },
        doneLoading() {
            setTimeout(() => {
                this.loaded = true;
            }, 500);

        }
    }
}
