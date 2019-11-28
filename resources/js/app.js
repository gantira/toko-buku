require('./bootstrap')

import Vue from 'vue'
import VueRouter from 'vue-router'
import Vuex from 'vuex'
import { routes } from './routes'
import App from './components/App.vue'
import StoreData from './store'
import { initialize } from './helpers/general'
import VueBarcode from '@xkeshi/vue-barcode'
import BootstrapVue from 'bootstrap-vue'

Vue.use(BootstrapVue)
Vue.use(VueRouter)
Vue.use(Vuex)
Vue.component(VueBarcode.name, VueBarcode)
Vue.filter('money', function(value) {
    let val = (value / 1).toFixed(0).replace('.', ',')
    return 'Rp ' + val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".")
})

const store = new Vuex.Store(StoreData)
const router = new VueRouter({
    routes,
    mode: 'history'
})

initialize(store, router)

new Vue({
    router,
    store,
    render: h => h(App)
}).$mount('#app')
