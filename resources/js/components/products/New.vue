<template>
    <div class="product-new">
        <form @submit.prevent="add">
            <div class="form-group row">
                <label for="title" class="col-sm-2 col-form-label">Title</label>
                <div class="col-sm-10">
                    <input type="text" v-model="product.title" class="form-control" id="title"
                        placeholder="Book Title">
                    <div v-if="errors.title" class="text-danger">{{ errors.title[0] }}</div>
                </div>
            </div>
            <div class="form-group row">
                <label for="author" class="col-sm-2 col-form-label">Author</label>
                <div class="col-sm-10">
                    <input type="author" v-model="product.author" class="form-control" id="author"
                        placeholder="Book Author">
                    <div v-if="errors.author" class="text-danger">{{ errors.author[0] }}</div>
                </div>
            </div>
            <div class="form-group row">
                <label for="isbn" class="col-sm-2 col-form-label">Isbn</label>
                <div class="col-sm-10">
                    <input type="text" v-model="product.isbn" class="form-control" id="isbn"
                        placeholder="Book isbn">
                    <div v-if="errors.isbn" class="text-danger">{{ errors.isbn[0] }}</div>
                </div>
            </div>
            <div class="form-group row">
                <label for="publisher" class="col-sm-2 col-form-label">Publisher</label>
                <div class="col-sm-10">
                    <input type="text" v-model="product.publisher" class="form-control" id="publisher"
                        placeholder="Book Publisher">
                    <div v-if="errors.publisher" class="text-danger">{{ errors.publisher[0] }}</div>
                </div>
            </div>
            <div class="form-group row">
                <label for="year" class="col-sm-2 col-form-label">Year</label>
                <div class="col-sm-10">
                    <input type="text" v-model="product.year" class="form-control" id="year"
                        placeholder="Book Year">
                    <div v-if="errors.year" class="text-danger">{{ errors.year[0] }}</div>
                </div>
            </div>
            <div class="form-group row">
                <label for="curriculum" class="col-sm-2 col-form-label">Curriculum</label>
                <div class="col-sm-10">
                    <input type="text" v-model="product.curriculum" class="form-control" id="curriculum"
                        placeholder="Book Curriculum">
                    <div v-if="errors.curriculum" class="text-danger">{{ errors.curriculum[0] }}</div>
                </div>
            </div>
            <div class="form-group row">
                <label for="price" class="col-sm-2 col-form-label">Price</label>
                <div class="col-sm-10">
                    <input type="text" v-model="product.price" class="form-control" id="price"
                        placeholder="Book Price">
                    <div v-if="errors.price" class="text-danger">{{ errors.price[0] }}</div>
                </div>
            </div>
            <div class="form-group row">
                <label for="stock" class="col-sm-2 col-form-label">Stock</label>
                <div class="col-sm-10">
                    <input type="text" v-model="product.stock" class="form-control" id="stock"
                        placeholder="Book Stock">
                    <div v-if="errors.stock" class="text-danger">{{ errors.stock[0] }}</div>
                </div>
            </div>
            <div class="form-group row">
                <label for="image" class="col-sm-2 col-form-label">Image</label>
                <div class="col-sm-10">
                    <input type="file" class="form-control-file" @change="onImageChange">
                    <div>
                        <img v-if="url" :src="url" class="img-thumbnail" width="200px" />
                    </div>
                    <div v-if="errors.image" class="text-danger">{{ errors.image[0] }}</div>
                </div>
            </div>

            <div class="form-group d-flex justify-content-between">
                <router-link to="/products" class="">Cancel</router-link>
                <template v-if="! loading">
                    <input type="submit" value="Create" class="btn btn-primary">
                </template>
                <template v-else>
                    <button class="btn btn-primary" type="button" disabled>
                        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                        Loading...
                    </button>
                </template>
            </div>
        </form>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                product: {
                    title: '',
                    author: '',
                    isbn: '',
                    publisher: '',
                    year: '',
                    curriculum: '',
                    price: '',
                    stock: '',
                    image: '',
                },
                errors: [],
                loading: false,
                url: false,
            }
        },
        computed: {
            currentUser() {
                return this.$store.getters.currentUser;
            },
        },
        methods: {
            onImageChange(e) {
                const file = e.target.files[0];
                this.product.image = file;

                console.log(file);
                this.url = URL.createObjectURL(file);
            },
            add() {
                this.loading = true;
                let formData = new FormData();
                formData.append('title', this.product.title);
                formData.append('author', this.product.author);
                formData.append('isbn', this.product.isbn);
                formData.append('publisher', this.product.publisher);
                formData.append('year', this.product.year);
                formData.append('curriculum', this.product.curriculum);
                formData.append('price', this.product.price);
                formData.append('stock', this.product.stock);
                formData.append('image', this.product.image);

                axios.post('/api/products/new', formData)
                    .then((response) => {
                        this.loading = false;
                        this.$store.dispatch('getProducts');
                        this.$router.push('/products');

                        this.$bvToast.toast(`${this.product.title} added.`, {
                            title: 'New Product Added',
                            solid: true,
                            variant: 'success',
                            toaster: 'b-toaster-bottom-right',
                            autoHideDelay: 4000,
                            appendToast: false
                        })

                    })
                    .catch((error) => {
                        this.loading = false;
                        this.errors = error.response.data.errors;
                    });
            },
        }
    }

</script>
