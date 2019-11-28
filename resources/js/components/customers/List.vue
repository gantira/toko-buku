<template>
    <div>
        <div class="d-flex justify-content-between pb-3">
            <div>
                <router-link to="/customers/new" class="btn btn-primary btn-sm">New</router-link>
            </div>
            <div>
                <input type="text" v-model="search" placeholder="Search" class="form-control">
            </div>
        </div>
        <table class="table table-hover">
            <thead>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Actions</th>
            </thead>
            <tbody>
                <template>
                    <tr v-if="!customers.length">
                        <td colspan="4" class="text-center">No Customers Available</td>
                    </tr>
                </template>
                <template>
                    <tr v-for="(customer, index) in filteredCustomer" :key="index">
                        <td><a href="javascript:void(0)" @click="showModal(customer)">{{ customer.name }}</a>
                        </td>
                        <td>{{ customer.email }}</td>
                        <td>{{ customer.phone }}</td>
                        <td>
                            <router-link :to="`/customers/${customer.id}`">View</router-link>
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
                        <pre>{{ customer }}</pre>
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
                customer: [],
                search: '',
            }
        },
        mounted() {
            if (!this.customers.length) {
                this.$store.dispatch('getCustomers');
            }
        },
        computed: {
            customers() {
                return this.$store.getters.customers;
            },
            isLoading() {
                return this.$store.getters.isLoading;
            },
            filteredCustomer() {
                return this.customers.filter((customer) => {
                    let listCustomer = ''

                    if (customer.name && customer.email) {
                        listCustomer = customer.name.toLowerCase().includes(this.search.toLowerCase()) || customer.email.toLowerCase().includes(this.search.toLowerCase())
                    } else if(customer.name) {
                        listCustomer = customer.name.toLowerCase().includes(this.search.toLowerCase())
                    } else {
                        listCustomer = customer.email.toLowerCase().includes(this.search.toLowerCase())
                    }

                    return listCustomer
                })
            }
        },
        methods: {
            showModal(customer) {
                $('#exampleModalCenter').modal('show');
                this.customer = customer
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
