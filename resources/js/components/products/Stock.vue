<template>
    <div class="d-flex justify-content-between" v-if="product">
        <div class="pr-3">
            <img :src="url ? url : '/storage/' + product.image " width="150px" class="rounded">
        </div>
        <div class="table overflow-auto">
            <form @submit.prevent="update">
                <table class="table">
                    <tr>
                        <th>ID</th>
                        <td>{{ product.id }} <a href="#!" class="fas fa-cart-plus" @click="toggleEdit" title="Add Stock"
                                v-if="edit"></a></td>
                    </tr>
                    <tr>
                        <th>Title</th>
                        <td>{{ product.title }}</td>
                    </tr>
                    <tr>
                        <th>Current Stock</th>
                        <td v-if="edit">
                            {{ product.stock }}
                        </td>
                        <td v-else>
                            {{ product.stock }} +
                            <input type="number" v-model="addstock" class="" min="1">
                            <div v-if="errors.addstock" class="text-danger">{{ errors.addstock[0] }}</div>
                        </td>
                    </tr>
                </table>
                <router-link to="/products" v-if="edit">Back to all products</router-link>
                <div v-else class="d-flex justify-content-between">
                    <div>
                        <button v-if="!loading" type="submit" class="btn btn-primary">Save</button>
                        <button v-else class="btn btn-primary" type="button" disabled>
                        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                            Loading...
                        </button>
                        <button class="btn btn-outline-secondary" @click.prevent="toggleEdit">Cancel</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
    export default {
        name: 'view',
        created() {
            if (this.products.length) {
                this.product = this.products.find((product) => product.id == this.$route.params.id)
            } else {
                axios.get(`/api/products/${this.$route.params.id}`)
                    .then((response) => {
                        this.product = response.data.product;
                    })
            }
        },
        data() {
            return {
                product: {
                    title: '',
                    author: '',
                    isbn: '',
                    publisher: '',
                    curriculum: '',
                    price: '',
                    stock: '',
                    image: null,
                },
                addstock: 0,
                edit: true,
                errors: [],
                url: false,
                loading: false,
            }
        },
        computed: {
            currentUser() {
                return this.$store.getters.currentUser;
            },
            products() {
                return this.$store.getters.products;
            },
        },
        methods: {
            toggleEdit() {
                this.edit = !this.edit
            },
            onImageChange(e) {
                const file = e.target.files[0];
                this.product.image = file;

                console.log(file);
                this.url = URL.createObjectURL(file);
            },
            update() {
                this.loading = true

                axios.patch(`/api/products/${this.$route.params.id}/addstock`, {addstock: this.addstock})
                    .then((response) => {
                        this.product = response.data.product
                        this.$store.dispatch('getProducts')
                        this.edit = true
                        this.loading = false
                        console.log(response.data.product)
                    })
                    .catch((error) => {
                        this.loading = false
                        this.errors = error.response.data.errors
                    });
            },
            destroy() {
                var conf = confirm('Yakin hapus '+ this.product.title + ' ?')
                this.loading = true

                if (conf) {

                    axios.delete(`/api/products/${this.$route.params.id}`)
                    .then((response) => {
                        this.product = response.data.product;
                        this.$router.push('/products')
                        this.products.splice(`${this.$route.params.id}`, 1);
                        this.loading = false
                        this.edit = true
                    })
                    .catch((error) => {
                        this.loading = false
                        this.errors = error.response.data.errors;
                    });

                } else
                this.loading = false
            },

        }
    }

</script>

<style>
    .upload {
        z-index: -2;
        position: absolute;
    }

</style>
