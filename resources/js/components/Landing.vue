<template>
<div class="parent">
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <router-link to='/home' class="navbar-brand">FlignoPH Shopping Cart</router-link>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
            <li class="nav-item active" v-if="!token">
               <router-link to='/signup' class="nav-link">Sign up</router-link>
            </li>
            <li class="nav-item" v-if="!token">
                <router-link to='/login' class="nav-link">Login</router-link>
            </li>
             <li class="nav-item " v-if="token && user_role ==='admin'">
                <router-link to='/dashboard' class="nav-link">Dashboard 
                   
                </router-link>
            </li>
            <li class="nav-item dropdown notif" v-if="user_role ==='admin' && token">
                <router-link to='/dashboard' class="nav-link dropdown-toggle" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Notification <span class="badge badge-danger" v-text="notification.notifications"></span>
                </router-link>
                <div v-if="notifs.length > 0">
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown" v-for="(notif, index) in notifs" v-bind:key="notif.id">
                        <NotificationList :notif="notif" :index="index"></NotificationList>
                    </div>
                </div>    
                <div v-else>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                      <a class="dropdown-item" href="#">No Notification.</a>
                  </div>
                </div>
            </li>
            <li class="nav-item dropdown notif" v-if="user_role ==='admin' && token">
                <router-link to='/sales' class="nav-link">
                           Sales
                </router-link>
            </li>
            <li class="nav-item" v-if="token">
                <a href="" @click.prevent="logout()" class="nav-link">Logout</a>
            </li>
            </ul>
        </div>
    </nav>

    <router-view v-on:loggedIn="loggedIn"></router-view>
</div>
</template>
<script>
import NotificationList from './NotificationList.vue';
export default {
    props:['admin'],
    components:{NotificationList},
    data(){
        return{
            token:localStorage.getItem('access_token')|| null,
            user_role:localStorage.getItem('user_role')|| null,
            products:'',
            notification:{},
            notifs:[],
        }
    },
    mounted(){
        axios.defaults.headers.common['Authorization'] = 'Bearer ' + this.token;
        axios.defaults.headers.post['Content-Type'] = 'multipart/form-data';
        axios.defaults.headers.post['Accept'] = 'application/json';
        this.loggedIn();
        this.notifications();
        window.Echo.private('App.User.' + this.admin)
            .notification((notification) => {
             console.log(notification.type);
        });        
        console.log(Echo);
    },
    methods:{
        loggedIn(data){
           this.token = localStorage.getItem('access_token'),
           this.user_role = localStorage.getItem('user_role')
        },
        notifications(){
            axios.get('/api/unreadnotification')
            .then(res =>{
                this.notification = res.data;
                this.notifList(res.data.user_id)
            })
            .catch(err => {
                console.log(err);
            })
        },
        notifList(user_id){
          axios.get(`api/unreadnotification/${user_id}`)
            .then(res =>{
                this.notifs = res.data;
                //console.log(this.notifs);
            })
            .catch((err) => console.log(err));
        },

        logout(){
            axios.post('/api/logout',{
                token: this.token
            })
            .then((res) =>{   
                  localStorage.removeItem("user_role")  
                  localStorage.removeItem("access_token")
                  localStorage.removeItem('user_id');
                  this.user_role = null 
                  this.user_id = null;
                  this.token = null;
                  this.$router.push('/login')
            })
        }
    },
}
</script>
<style>
.parent{
    background:rgb(239,240,245);
    min-height:100vh;
}
.notif{
    position:relative;

}
</style>
