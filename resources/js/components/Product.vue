<template>
    <div>
       <div class="container">
           <div class="row justify-content-center mt-5">
               <div class="col col-md-6">
                   <div class="card">
                       <div class="card-header">Product Name: </div>
                       <div class="card-body">

                       </div>
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
            token:localStorage.getItem('access_token') || null,
            user_role:localStorage.getItem('user_role') || null,
            productId: this.$route.params.productId,
            product:'',
        }
    },
    watch:{
        '$route' (to,from){
            alert(to.$route.prams.productId);
        }
    },
    created(){
        axios.defaults.headers.common['Authorization'] = 'Bearer ' + this.token;
        axios.defaults.headers.post['Content-Type'] = 'multipart/form-data';
        axios.defaults.headers.post['Accept'] = 'application/json';
        this.loggedIn();
        this.getProduct();
    },
    methods:{
         loggedIn(){
            if(this.token !=null){
                this.$emit('loggedIn',{token:this.token,user_role:this.user_role});
            }
        },
          getProduct() {
            axios.get(`/view-product/${this.productId}`)
            .then(res => {
                console.log({result: res.data})
            })
            .catch(err => console.log(err));
           
        }
    }
}
</script>