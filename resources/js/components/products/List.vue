<template>
    <div>
        <div class="d-flex justify-content-between pb-3">
            <div>
                <router-link to="/products/new" class="btn btn-primary btn-sm">New</router-link>
            </div>
            <div>
                <input type="text" v-model="search" placeholder="Search" class="form-control">
            </div>
        </div>
        <table class="table table-hover">
            <thead>
                <th>Title</th>
                <th>Author</th>
                <th>Publisher</th>
                <th>Isbn</th>
                <th>Year</th>
                <th>Curriculum</th>
                <th>Price</th>
                <th>Stock</th>
                <th>Actions</th>
            </thead>
            <tbody>
                <template>
                    <tr v-if="!products.length">
                        <td colspan="9" class="text-center">No products Available</td>
                    </tr>
                </template>
                <template>
                    <tr v-for="(product, index) in filteredProduct" :key="index">
                        <td><a href="javascript:void(0)" @click="showModal(product)">{{ product.title }}</a>
                        </td>
                        <td>{{ product.author }}</td>
                        <td>{{ product.publisher }}</td>
                        <td><mark>{{ product.isbn }}</mark></td>
                        <td>{{ product.year }}</td>
                        <td>{{ product.curriculum }}</td>
                        <td>{{ product.price | money }}</td>
                        <td>{{ product.stock }}</td>
                        <td>
                            <router-link :to="`/products/${product.id}`" class="btn btn-outline-info btn-sm" title="view"><i class="fas fa-search"></i></router-link>
                            <router-link :to="`/products/${product.id}/addstock`" class="btn btn-outline-secondary btn-sm" title="add stock"><i class="fas fa-cart-plus"></i></router-link>
                        </td>

                    </tr>
                </template>
            </tbody>
        </table>

        <!-- Modal -->
        <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog"
            aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalCenterTitle">Modal title</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <pre>{{ product }}</pre>
                    </div>

                </div>
            </div>
        </div>

    </div>
</template>

<script>
    export default {
        name: 'list',

        data() {
            return {
                product: [],
                search: '',
            }
        },
        mounted() {
            if (!this.products.length) {
                this.$store.dispatch('getProducts');
            }
        },
        computed: {
            products() {
                return this.$store.getters.products;
            },
            isLoading() {
                return this.$store.getters.isLoading;
            },
            filteredProduct() {
                return this.products.filter((product) => {
                    return product.title.toLowerCase().includes(this.search.toLowerCase()) || product.isbn.toLowerCase().includes(this.search.toLowerCase())
                })
            }
        },
        methods: {
            showModal(product) {
                $('#exampleModalCenter').modal('show');
                this.product = product
            }
        }

    }

</script>

<style>
    .btn-wrapper {
        text-align: right;
        margin-bottom: 20px;
    }

</style>
