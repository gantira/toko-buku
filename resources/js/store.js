import { getLocalUser } from "./helpers/auth";

const user = getLocalUser();

export default {
    state: {
        currentUser: user,
        isLoggedIn: !!user,
        loading: false,
        auth_error: null,
        customers: [],
        products: [],
        transactions: [],
        users: [],
    },
    getters: {
        isLoading(state) {
            return state.loading;
        },
        isLoggedIn(state) {
            return state.isLoggedIn;
        },
        currentUser(state) {
            return state.currentUser;
        },
        authError(state) {
            return state.auth_error;
        },
        customers(state) {
            return state.customers;
        },
        products(state) {
            return state.products;
        },
        transactions(state) {
            return state.transactions;
        },
        users(state) {
            return state.users;
        },
    },
    mutations: {
        login(state) {
            state.loading = true;
            state.auth_error = null;
        },
        loginSuccess(state, payload) {
            state.auth_error = null;
            state.isLoggedIn = true;
            state.loading = false;
            state.currentUser = Object.assign({}, payload.user, {token: payload.access_token});

            localStorage.setItem('user', JSON.stringify(state.currentUser));
        },
        loginFailed(state, payload) {
            state.loading = false;
            state.auth_error = payload.error;
        },
        logout(state) {
            localStorage.removeItem('user');
            state.isLoading = false;
            state.currentUser = null;
        },
        updateCustomers(state, payload) {
            state.customers = payload;
        },
        updateProducts(state, payload) {
            state.products = payload;
        },
        updateTransactions(state, payload) {
            state.transactions = payload;
        },
        updateUsers(state, payload) {
            state.users = payload;
        },
    },
    actions: {
        login(context) {
            context.commit('login');
        },
        getCustomers(context) {
            axios.get('/api/customers')
            .then((response) => {
                context.commit('updateCustomers', response.data.customers);
            })
        },
        getProducts(context) {
            axios.get('/api/products')
            .then((response) => {
                context.commit('updateProducts', response.data.products);
            })
        },
        getTransactions(context) {
            axios.get('/api/transactions')
            .then((response) => {
                context.commit('updateTransactions', response.data.transactions);
            })
        },
        getUsers(context) {
            axios.get('/api/users')
            .then((response) => {
                context.commit('updateUsers', response.data.users);
            })
        },
    }
};
