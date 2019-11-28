<template>
    <div class="row justify-content-center">
        <div class="col-md-4">
            <div class="alert alert-danger" v-if="authError">
                {{ authError }}
            </div>
            <div class="card bg-white">
                <h5 class="card-header">Login</h5>
                <div class="card-body">
                    <form @submit.prevent="authenticate">
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input v-model="form.email" id="email" type="email" class="form-control" autocomplete="off"
                                placeholder="Email Address" autofocus />
                        </div>
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input v-model="form.password" id="password" type="password" class="form-control"
                                placeholder="Password" />
                        </div>
                        <div class="form-group">
                            <template v-if="!isLoading">
                                <button class="btn btn-primary" type="submit">Login</button>
                            </template>
                            <template v-else>
                                <button class="btn btn-primary" type="button" disabled>
                                    <span class="spinner-border spinner-border-sm" role="status"
                                        aria-hidden="true"></span>
                                    Log in
                                </button>
                            </template>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import {
        login
    } from '../../helpers/auth';
    export default {
        name: 'login',
        created() {
            if (this.currentUser) {
                return this.$router.push('/')
            }
        },
        data() {
            return {
                form: {
                    email: '',
                    password: ''
                },
            }
        },
        methods: {
            authenticate() {
                this.$store.dispatch('login');

                login(this.$data.form)
                    .then((res) => {
                        this.$store.commit('loginSuccess', res);
                        this.$router.push({
                            path: '/'
                        });
                    })
                    .catch((error) => {
                        this.$store.commit('loginFailed', {
                            error
                        });
                    });
            }
        },
        computed: {
            isLoading() {
                return this.$store.getters.isLoading
            },
            authError() {
                return this.$store.getters.authError
            },
            currentUser() {
                return this.$store.getters.currentUser
            }
        }

    }

</script>

<style>
    .error {
        text-align: center;
        color: red;
    }

</style>
