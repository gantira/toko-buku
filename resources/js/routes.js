import Home from './components/Home.vue';
import Login from './components/auth/Login.vue';
import About from './components/view/About.vue';
import CustomersMain from './components/customers/Main.vue';
import CustomersList from './components/customers/List.vue';
import NewCustomer from './components/customers/New.vue';
import Customer from './components/customers/View.vue';
import UsersMain from './components/users/Main.vue';
import UsersList from './components/users/List.vue';
import NewUser from './components/users/New.vue';
import User from './components/users/View.vue';
import ProductsMain from './components/products/Main.vue';
import ProductsList from './components/products/List.vue';
import NewProduct from './components/products/New.vue';
import Product from './components/products/View.vue';
import ProductAddStock from './components/products/Stock.vue';
import TransactionMain from './components/transaction/Main.vue';
import TransactionList from './components/transaction/List.vue';
import ReportMain from './components/report/Main.vue';
import ReportList from './components/report/List.vue';
import PageNotFound from './components/PageNotFound.vue';
import Forbidden from './components/Forbidden.vue';

export const routes = [
    {
        path: '/',
        name: 'home',
        component: Home,
    },
    {
        path: '/login',
        name: 'login',
        component: Login,
    },
    {
        path: '/about',
        name: 'about',
        component: About,
    },
    {
        path: '/customers',
        component: CustomersMain,
        meta: {
            requiresAuth: true,
            roles: ['admin', 'superadmin']
        },
        children: [
            {
                path: '/',
                component: CustomersList
            },
            {
                path: 'new',
                component: NewCustomer
            },
            {
                path: ':id',
                component: Customer
            },
        ]
    },
    {
        path: '/users',
        component: UsersMain,
        meta: {
            requiresAuth: true,
            roles: ['superadmin']
        },
        children: [
            {
                path: '/',
                component: UsersList
            },
            {
                path: 'new',
                component: NewUser
            },
            {
                path: ':id',
                component: User
            },
        ]
    },
    {
        path: '/products',
        component: ProductsMain,
        meta: {
            requiresAuth: true,
            roles: ['admin', 'superadmin']
        },
        children: [
            {
                path: '/',
                component: ProductsList
            },
            {
                path: 'new',
                component: NewProduct
            },
            {
                path: ':id',
                component: Product
            },
            {
                path: ':id/addstock',
                component: ProductAddStock
            },
        ]
    },
    {
        path: '/transaction',
        component: TransactionMain,
        meta: {
            requiresAuth: true,
            roles: ['admin', 'superadmin']
        },
        children: [
            {
                path: '/',
                component: TransactionList
            },
        ]
    },
    {
        path: '/report',
        component: ReportMain,
        meta: {
            requiresAuth: true,
            roles: ['admin', 'superadmin']
        },
        children: [
            {
                path: '/',
                component: ReportList
            },
        ]
    },
    {
        path: '/403',
        name: 'forbidden',
        component: Forbidden
    },
    {
        path: '*',
        name: 'notfound',
        component: PageNotFound,
        redirect: '/'
    },

];
