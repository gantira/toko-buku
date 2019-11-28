<template>
    <div class="d-flex justify-content-between" v-if="user">
        <div class="table overflow-auto">
            <form @submit.prevent="update">
                <table class="table">
                    <tr>
                        <th>ID</th>
                        <td>{{ user.id }} <a href="#!" class="fa fa-edit" @click="toggleEdit" title="edit" v-if="edit"></a></td>
                    </tr>
                    <tr>
                        <th>Name</th>
                        <td v-if="edit">{{ user.name }}</td>
                        <td v-else>
                            <input type="text" v-model="user.name" class="form-control">
                            <div v-if="errors.name" class="text-danger">{{ errors.name[0] }}</div>
                        </td>
                    </tr>
                    <tr>
                        <th>Email</th>
                        <td v-if="edit">{{ user.email }}</td>
                        <td v-else>
                            <input type="text" v-model="user.email" class="form-control">
                            <div v-if="errors.email" class="text-danger">{{ errors.email[0] }}</div>
                        </td>
                    </tr>
                    <tr>
                        <th>Roles</th>
                        <td v-if="edit">{{ user.roles }}</td>
                        <td v-else>
                            <select v-model="user.roles" class="form-control" >
                                <option v-for="item in optionSelectRoles" :key="item.value" :value="item.value">{{ item.name }}</option>
                            </select>
                            <div v-if="errors.roles" class="text-danger">{{ errors.roles[0] }}</div>
                        </td>
                    </tr>
                </table>
                <router-link to="/users" v-if="edit">Back to all users</router-link>
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
            if (this.users.length) {
                this.user = this.users.find((user) => user.id == this.$route.params.id)
            } else {
                axios.get(`/api/users/${this.$route.params.id}`)
                    .then((response) => {
                        this.user = response.data.user;
                    })
            }
        },
        data() {
            return {
                user: {
                    id: '',
                    name: '',
                    roles: '',
                    email: '',
                },
                optionSelectRoles: [
                    {value: 'superadmin', name: 'Superadmin'},  
                    {value: 'admin', name: 'Admin'},  
                ],
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
            users() {
                return this.$store.getters.users;
            }
        },
        methods: {
            toggleEdit() {
                this.edit = !this.edit
            },
            update() {
                this.loading = true
               
                axios.patch(`/api/users/${this.$route.params.id}/update`, this.user)
                    .then((response) => {
                        this.user = response.data.user;
                        this.$store.dispatch('getUsers');
                        this.edit = true
                        this.loading = false
                    })
                    .catch((error) => {
                        this.loading = false
                        this.errors = error.response.data.errors;
                    });
            },
            destroy() {
                var conf = confirm('Yakin hapus '+ this.user.name + ' ?')
                this.loading = true

                if (conf) {

                    axios.delete(`/api/users/${this.$route.params.id}`)
                    .then((response) => {
                        this.user = response.data.user;
                        this.$store.dispatch('getUsers');
                        this.$router.push('/users')
                        // this.users.splice(`${this.$route.params.id}`, 1);
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

<style scoped>
    .upload {
        z-index: -2;
        position: absolute;
    }

</style>
