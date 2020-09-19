<template>
<div>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="#">Shopping Cart</a>
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
             <li class="nav-item" v-if="token && user_role">
                <router-link to='/dashboard' class="nav-link">Dashboard</router-link>
            </li>
            <li class="nav-item" v-if="user_role && token">
                <router-link to='/dashboard' class="nav-link">Notification</router-link>
            </li>
            <li class="nav-item" v-if="token">
                <a href="" @click.prevent="logout()" class="nav-link">Logout</a>
            </li>
            </ul>
        </div>
    </nav>
    <router-view v-on:loggedIn="loggedIn($event)"></router-view>
</div>
</template>
<script>
export default {
    data(){
        return{
            token:null,
            user_role:null
        }
    },
    methods:{
        loggedIn(data){
            this.token = data.token
            this.user_role = data.user_role
        },
        logout(){
            axios.post('/api/logout',{
                token: this.token
            })
            .then(() =>{
                  if(this.user_role == "admin"){
                      localStorage.removeItem("user_role")
                      this.user_role = null
                  }
                  localStorage.removeItem("access_token")
                  this.token = null;
                  this.$router.push('/login')
            })
        }
    },
}
</script>
