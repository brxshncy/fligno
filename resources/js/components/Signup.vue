<template>
    <div>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col col-md-6">
                    <div class="card">
                        <div class="card-header text-center">
                            Signup
                        </div>
                        <form v-on:submit.prevent="register">      
                        <div class="card-body">
                            <div class="row">
                                <div class="col">
                                    <div class="form-group">
                                        <label for="">Name</label>
                                        <input type="text" v-model="name" class="form-control" required>
                                    </div>
                                </div>
                            </div>
                             <div class="row">
                                <div class="col">
                                    <div class="form-group">
                                        <label for="">Address</label>
                                        <input type="text" v-model="address" class="form-control" required>
                                    </div>
                                </div>
                                  <div class="col">
                                    <div class="form-group">
                                        <label for="">Contact</label>
                                        <input type="number" v-model="contact" class="form-control" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <div class="form-group">
                                        <label for="">Email</label>
                                        <input type="email" v-model="email" class="form-control" required>
                                    </div>
                                </div>
                                  <div class="col">
                                    <div class="form-group">
                                        <label for="">Password</label>
                                        <input type="text" v-model="password" class="form-control" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row" v-show="errDiv">
                                <div class="col">
                                    <div class="alert alert-danger text-center">
                                       <small> {{ errorMsg.error }} </small> 
                                    </div>
                                </div>
                            </div>
                               <div class="row" v-show="succDiv">
                                <div class="col">
                                    <div class="alert alert-success text-center">
                                       <small>Account successfuly registered <router-link to="/login">Click here</router-link> </small> 
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                               <div class="col">
                                   <router-link to="/login">
                                        <button class="btn btn-secondary btn-block">Back</button>
                                   </router-link>
                               </div>
                                <div class="col text-right">
                                    <button class="btn btn-primary btn-block">Login</button>
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
            name:'',
            address:'',
            contact:'',
            email:'',
            password:'',
            errorMsg:'',
            errDiv:false,
            succDiv:false,
        }
    },
    
    methods:{
        register(){
           axios.post(`/api/register`,
           {
               name:this.name,
               address:this.address,
               contact:this.contact,
               email:this.email,
               password:this.password
               
           })
           .then((res) => {
               console.log(res.data);
               if(Object.keys(res.data)[0] == "error"){
                   this.errorMsg  = res.data;
                   this.errDiv = true;
               }
               else{
                   this.errDiv = false;
                   this.$router.push('login');
               }
           })
           .catch((err) => {
               if(err.response.status == 422){
                   console.log(err.response.data.errors);
                   this.validationErrors = error.response.data.errors;
               }
           });
        },
    }
}
</script>