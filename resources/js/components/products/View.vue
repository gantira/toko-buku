<template>
    <div class="d-flex justify-content-between" v-if="product">
        <div class="pr-3">
            <img :src="url ? url : '/storage/' + product.image " width="150px" class="rounded">
            <div class="text-center pt-2" v-if="!edit">
                <label for="file" class="font-weight-bold" style="cursor: pointer;"><mark>Select a file</mark></label>
                <input type="file" class="upload" id="file" @change="onImageChange">
                <div v-if="errors.image" class="text-danger">{{ errors.image[0] }}</div>
            </div>
        </div>
        <div class="table overflow-auto">
            <form @submit.prevent="update">
                <table class="table">
                    <tr>
                        <th>ID</th>
                        <td>{{ product.id }} <a href="#!" class="fa fa-edit" @click="toggleEdit" title="edit"
                                v-if="edit"></a></td>
                    </tr>
                    <tr>
                        <th>Title</th>
                        <td v-if="edit">{{ product.title }}</td>
                        <td v-else>
                            <input type="text" v-model="product.title" class="form-control">
                            <div v-if="errors.title" class="text-danger">{{ errors.title[0] }}</div>
                        </td>
                    </tr>
                    <tr>
                        <th>Isbn</th>
                        <td v-if="edit">
                            <barcode :value="product.isbn" :options="{ displayValue: false, height: 25 }"></barcode>
                            {{ product.isbn }}</td>
                        <td v-else>
                            <input type="text" v-model="product.isbn" class="form-control">
                            <div v-if="errors.isbn" class="text-danger">{{ errors.isbn[0] }}</div>
                        </td>
                    </tr>
                    <tr>
                        <th>Author</th>
                        <td v-if="edit">{{ product.author }}</td>
                        <td v-else>
                            <input type="text" v-model="product.author" class="form-control">
                            <div v-if="errors.author" class="text-danger">{{ errors.author[0] }}</div>
                        </td>
                    </tr>
                    <tr>
                        <th>Publisher</th>
                        <td v-if="edit">{{ product.publisher }}</td>
                        <td v-else>
                            <input type="text" v-model="product.publisher" class="form-control">
                            <div v-if="errors.publisher" class="text-danger">{{ errors.publisher[0] }}</div>
                        </td>
                    </tr>
                    <tr>
                        <th>Year</th>
                        <td v-if="edit">{{ product.year }}</td>
                        <td v-else>
                            <input type="text" v-model="product.year" class="form-control">
                            <div v-if="errors.year" class="text-danger">{{ errors.year[0] }}</div>
                        </td>
                    </tr>
                    <tr>
                        <th>Curriculum</th>
                        <td v-if="edit">{{ product.curriculum }}</td>
                        <td v-else>
                            <input type="text" v-model="product.curriculum" class="form-control">
                            <div v-if="errors.curriculum" class="text-danger">{{ errors.curriculum[0] }}</div>
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
                    <div>
                        <button v-if="!loading" class="btn btn-outline-danger" @click.prevent="destroy">Delete</button>
                        <button v-else class="btn btn-primary" type="button" disabled>
                        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                            Loading...
                        </button>
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
            }
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
                let formData = new FormData();
                this.loading = true

                formData.append('title', this.product.title);
                formData.append('author', this.product.author);
                formData.append('isbn', this.product.isbn);
                formData.append('publisher', this.product.publisher);
                formData.append('year', this.product.year);
                formData.append('curriculum', this.product.curriculum);
                formData.append('image', this.product.image);
                formData.append('_method', 'patch');

                axios.post(`/api/products/${this.$route.params.id}/update`, formData)
                    .then((response) => {
                        this.product = response.data.product;
                        this.$store.dispatch('getProducts');
                        this.edit = true
                        this.loading = false
                    })
                    .catch((error) => {
                        this.loading = false
                        this.errors = error.response.data.errors;
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



            }

        }
    }

</script>

<style>
    .upload {
        z-index: -2;
        position: absolute;
    }

</style>
