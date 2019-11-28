<template>
    <div class="user-new">
        <form @submit.prevent="add">
            <div class="form-group row">
                <label for="name" class="col-sm-2 col-form-label">Name</label>
                <div class="col-sm-10">
                    <input type="text" v-model="user.name" class="form-control" id="name"
                        placeholder="Customer Name">
                    <div v-if="errors.name" class="text-danger">{{ errors.name[0] }}</div>
                </div>
            </div>
            <div class="form-group row">
                <label for="email" class="col-sm-2 col-form-label">Email</label>
                <div class="col-sm-10">
                    <input type="text" v-model="user.email" class="form-control" id="email" autocomplete="off"
                        placeholder="Customer Email">
                    <div v-if="errors.email" class="text-danger">{{ errors.email[0] }}</div>
                </div>
            </div>
            <div class="form-group row">
                <label for="roles" class="col-sm-2 col-form-label">Roles</label>
                <div class="col-sm-10">
                   <select v-model="user.roles" class="form-control" >
                       <option v-for="item in optionSelectRoles" :key="item.value" :value="item.value">{{ item.name }}</option>
                   </select>
                    <div v-if="errors.roles" class="text-danger">{{ errors.roles[0] }}</div>
                </div>
            </div>
            <hr>
            <div class="form-group row">
                <label for="password" class="col-sm-2 col-form-label">Password</label>
                <div class="col-sm-10">
                    <input type="password" v-model="user.password" class="form-control" id="password"
                        placeholder="Password">
                    <div v-if="errors.password" class="text-danger">{{ errors.password[0] }}</div>
                </div>
            </div>
            <div class="form-group row">
                <label for="password_confirmation" class="col-sm-2 col-form-label">Confirm Password</label>
                <div class="col-sm-10">
                    <input type="password" v-model="user.password_confirmation" class="form-control" id="password_confirmation"
                        placeholder="Password Confirmation">
                    <div v-if="errors.password_confirmation" class="text-danger">{{ errors.password_confirmation[0] }}</div>
                </div>
            </div>
            <div class="form-group d-flex justify-content-between">
                <router-link to="/users" class="">Cancel</router-link>
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
                user: {
                    name: '',
                    email: '',
                    roles: '',
                    password: '',
                    password_confirmation: '',
                },
                optionSelectRoles: [
                    {value: 'superadmin', name: 'Superadmin'},  
                    {value: 'admin', name: 'Admin'},  
                ],
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
            add() {
                this.loading = true;

                axios.post('/api/users/new', this.user)
                    .then((response) => {
                        this.loading = false;
                        this.$store.dispatch('getUsers');
                        this.$router.push('/users');
                    })
                    .catch((error) => {
                        this.loading = false;
                        this.errors = error.response.data.errors;
                    });
            },

        }

    }

</script>
