<template>
    <div>
        <div class="d-flex justify-content-between pb-3">

            <div>
                <router-link to="/users/new" class="btn btn-primary btn-sm">New</router-link>
            </div>
        </div>
        <table class="table table-hover">
            <thead>
                <th>Name</th>
                <th>Email</th>
                <th>Roles</th>
                <th>Actions</th>
            </thead>
            <tbody>
                <template>
                    <tr v-if="!users.length">
                        <td colspan="4" class="text-center">No Users Available</td>
                    </tr>
                </template>
                <template>
                    <tr v-for="(user, index) in users" :key="index">
                        <td><a href="javascript:void(0)" @click="showModal(user)">{{ user.name }}</a>
                        </td>
                        <td>{{ user.email }}</td>
                        <td>{{ user.roles }}</td>
                        <td>
                            <router-link :to="`/users/${user.id}`">View</router-link>
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
                        <pre>{{ user }}</pre>
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
                user: []
            }
        },
        mounted() {
            if (!this.users.length) {
                this.$store.dispatch('getUsers');
            }
        },
        computed: {
            users() {
                return this.$store.getters.users;
            },
            isLoading() {
                return this.$store.getters.isLoading;
            },
        },
        methods: {
            showModal(user) {
                $('#exampleModalCenter').modal('show');
                this.user = user
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
