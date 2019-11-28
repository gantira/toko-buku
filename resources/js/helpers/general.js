export function initialize(store, router) {
    router.beforeEach((to, from, next) => {
        const requiresAuth = to.matched.some(record => record.meta.requiresAuth);
        const currentUser  = store.state.currentUser;

        if (requiresAuth && !currentUser) {
            next('/login')
        } else if(requiresAuth && currentUser && ! to.matched.some(record => record.meta.roles.includes(currentUser.roles))) {
            next('/')
        } else {
            next()
        }
        // console.log(to.matched.some(record => console.log(record.meta.roles.includes(currentUser.roles))))
    });

    axios.interceptors.response.use(null, (error) => {
        if (error.response.status == 401) {
            store.commit('logout')
            router.push('login')
        }

        return Promise.reject(error)
    });

    if (store.getters.currentUser) {
        setAuthorization(store.getters.currentUser.token)
    }
}

export function setAuthorization(token) {
    axios.defaults.headers.common['Authorization'] = `Bearer ${token}`
}