<template>
    <div class="container">
        <nav class="navbar navbar-expand-lg navbar-light mb-5 shadow-sm bg-white rounded">
            <router-link class="navbar-brand" to="/">KASIR</router-link>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto">
                    <template v-if="currentUser">
                        
                        <li class="nav-item">
                            <router-link to="/" class="nav-link">Home <span class="sr-only">(current)</span>
                            </router-link>
                        </li>
                        <!-- <li class="nav-item">
                            <router-link to="/about" class="nav-link">About </router-link>
                        </li> -->
                        <li class="nav-item" v-if="currentUser.roles == 'superadmin'">
                            <router-link to="/users" class="nav-link">User </router-link>
                        </li>
                        <li class="nav-item">
                            <router-link to="/customers" class="nav-link">Customers </router-link>
                        </li>
                        <li class="nav-item">
                            <router-link to="/products" class="nav-link">Products </router-link>
                        </li>
                        <li class="nav-item">
                            <router-link to="/transaction" class="nav-link">Transaction </router-link>
                        </li>
                        <li class="nav-item">
                            <router-link to="/report" class="nav-link">Report </router-link>
                        </li>
                    </template>
                </ul>
            </div>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ml-auto">
                    <template v-if="!currentUser">
                        <li class="nav-item">
                            <router-link to="/login" class="nav-link">Login </router-link>
                        </li>
                    </template>
                    <template v-else>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                {{ currentUser.name }}
                            </a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="#!" @click.prevent="logout">Logout</a>
                            </div>
                        </li>
                    </template>
                </ul>
            </div>

        </nav>
    </div>
</template>
<script>
    export default {
        computed: {
            currentUser() {
                return this.$store.getters.currentUser;
            }
        },
        methods: {
            logout() {
                this.$store.commit('logout');
                this.$router.push('login');
            }
        }
    }

</script>


