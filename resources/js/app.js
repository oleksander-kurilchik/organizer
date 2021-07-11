window._ = require('lodash');
window.axios = require('axios');
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
window.axios.defaults.headers.common['Authorization'] = 'Bearer ' + localStorage.getItem('token');
window.axios.defaults.withCredentials = true;

import Vue from 'vue';
import {ValidationProvider} from 'vee-validate';
import {ValidationObserver} from 'vee-validate';

Vue.component('ValidationProvider', ValidationProvider);
Vue.component('ValidationObserver', ValidationObserver);
import VueRouter from 'vue-router'

Vue.use(VueRouter)


import App from './components/App'
import Layout from './components/Layout'
import Home from './components/home/Index.vue'
import EventIndex from './components/events/Index.vue'
import Login from './components/auth/Login'
import Registration from './components/auth/Registration'


const routes = [
    {
        path: '', component: Layout,
        children: [
            {
                path: '/', component: Home, name: 'index',
            },
            {
                path: 'app/events', component: EventIndex, name: 'events.index',
                beforeEnter: (to, from, next) => {
                    if (!localStorage.getItem('token')) {
                        return next({name: 'login'});
                    }
                    return next();
                }
            },
            {path: 'login', name: 'login', component: Login},
            {path: 'registration', name: 'registration', component: Registration},
        ]
    }
];


const router = new VueRouter({
    mode: 'history',
    base: '/',
    routes
})


const instanceAxios = axios.create({
});

instanceAxios.interceptors.response.use(undefined, (error) => {
    if (error.response && error.response.status === 401) {
       localStorage.removeItem('token');
        router.push({name: 'login'})
    }
    return Promise.reject(error);
});


Vue.prototype.$http = instanceAxios;

const app = new Vue({
    router,
    render: h => h(App)
}).$mount('#app');
