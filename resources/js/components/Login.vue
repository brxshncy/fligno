<template>
    <div>
        <div class="container">
            <div class="row justify-content-center mt-5">
                <div class="col col-md-6">
                    <div class="card mt-5">
                        <div class="card-header text-center">Mini Shopping-Cart</div>
                        <form action="" v-on:submit.prevent="login">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col">
                                        <div class="form-group">
                                            <label for="">Email</label>
                                            <input type="text" v-model="email" class="form-control">
                                            <small>Not yet registered? <router-link to="/signup">Signup here</router-link></small>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-group">
                                            <label for="">Password</label>
                                            <input type="password" v-model="password" class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="row" v-if="errDiv">
                                    <div class="col">
                                        <div class="alert alert-danger text-center">
                                            <small>{{ invalid.error }}</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col"></div>
                                    <div class="col text-right">
                                        <button class="btn-primary btn btn-block">Login</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    data(){
        return{
            email:'',
            password:'',
            token:localStorage.getItem('access_token') || null,
            invalid:'',
            errDiv:false,
        }
    },
    methods:{
        login(){
           axios.post('/api/login',{
               email:this.email,
               password:this.password
           })
           .then(res => {
               if(Object.keys(res.data)[0] == 'error'){
                   this.invalid = res.data
                   this.errDiv = true;
               }
               else{
                    this.$emit('loggedIn');     
                    console.log(res.data)      
                    const accessToken = res.data.access_token;
                    this.token = accessToken;
                    localStorage.setItem('user_id',res.data.user_id);
                    localStorage.setItem('access_token',accessToken);
                    if(res.data.user_role == 'admin'){
                            localStorage.setItem('user_role',res.data.user_role);
                            this.errDiv=false;
                            this.$router.push('/dashboard');
                    }
                    else if(res.data.user_role == 'customer'){
                            localStorage.setItem('user_role',res.data.user_role);
                            this.errDiv=false;
                            this.$router.push('/home');
                    }
               }
              
           })
           .catch(err => console.log(err));
        }
    }
}
</script>
