require('./bootstrap');
window.Vue = require('vue');
import VueRouter from 'vue-router';

Vue.use(VueRouter);
Vue.component('example-component', require('./components/ExampleComponent.vue').default);
Vue.component('landing-page',require('./components/Landing.vue').default);

const routes = [
    {
        path:'/home',
        component:require('./components/Home.vue').default
    },
    {
        path:'/signup', 
        component:require('./components/Signup.vue').default
    },
    {
        path:'/login',
        component:require('./components/Login.vue').default
    },
    {
        path:'/shop',
        component:require('./components/Shope.vue').default
    },
    {
        path:'/dashboard',
        component:require('./components/Dashboard').default,
        beforeEnter(to,from,next){
            let user_role = window.localStorage.getItem('user_role');
            let token = window.localStorage.getItem('access_token');
            if(!token){
                return next('/login');
            }
            if(user_role == 'admin'){
                return next();
            }
               return next();
            
            
        }
    },
    {
        path:'/checkout/:productId',
        name:'checkout',
        component:require('./components/Checkout.vue').default,
        beforeEnter(to,from,next){
            let user_role = window.localStorage.getItem('user_role');
            let token = window.localStorage.getItem('access_token');
            if(!token){
                return next('/login');
            }
            if(user_role == 'customer'){
                return next();
            }
               return next();
        }
    },
    {
        path:'/sales',
        name:'sales',
        component:require('./components/Sales.vue').default,
        beforeEnter(to,from,next){
            let user_role = window.localStorage.getItem('user_role');
            let token = window.localStorage.getItem('access_token');
            if(!token){
                return next('/login');
            }
            if(user_role == 'admin'){
                return next();
            }
               return next();
        }
    },
    {
        path:'/product/:productId',
        name:'product',
        component:require('./components/Product.vue').default,
        beforeEnter(to,from,next){
            let user_role = window.localStorage.getItem('user_role');
            let token = window.localStorage.getItem('access_token');
            if(!token){
                return next('/login');
            }
            if(user_role == 'admin'){
                return next();
            }
               return next();
            
            
        }
    }
]
const router = new VueRouter({
    routes,
    mode: 'history'
})

const app = new Vue({
    el: '#app',
    router
});
