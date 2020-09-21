<template>
<div>
    <div class="product" v-if="products.length > 0">
            <div class="product-card" v-for="product in products" v-bind:key="product.id">
                <div class="img-container">
                    <img :src="product.image !== null? '/uploads/'+product.image :'/uploads/no-image.jpg'" alt="">
                </div>
                <div class="" style="display:flex; justify-content:center; align-items:center">
                    <h5>Product Name: {{product.product}}</h5>
                </div>
                <div class="price mt-2">
                    <strong>Price:</strong> &#8369;{{ product.price }}
                </div>
                <div class="quantity">
                    <strong>Quantity:</strong> {{ product.quantity }} remaining
                </div>
                <div class="mt-3">
                    <div class="col text-right">
                        <router-link :to="/checkout/+product.id">
                            <button class="btn-danger btn btn-block btn-sm">Buy</button>
                        </router-link>
                    </div>
                </div>
            </div>
    </div>
    <div v-else>
        <div class="product">
            No Items Available please comeback later.
        </div>
    </div>
</div>
</template>

<script>
export default {
    data(){
        return{
            token:null,
            user_role:null,
            products:'',
        }
    },
    created(){
        this.newProduct();
        this.loggedIn();
    },
    methods:{
        loggedIn(data){
           this.token = localStorage.getItem('access_token'),
           this.user_role = localStorage.getItem('user_role')
           this.$emit('loggedIn');
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
        },
        newProduct(){
            axios.get('/api/products')
            .then((res) =>{
                this.products = res.data;
                //console.log(this.products);
            })
            .catch((err) =>{
                console.log(err.response.status);
            })
        }
    }
}
</script>
<style scoped>

.product{
    margin:auto;
    display:grid;
    width:80%;
    background:#ffffff ;
    grid-template-columns: repeat(4,1fr);
    grid-gap:20px;
    margin-top:50px;
    padding:20px;
}
.product .product-card{
    background:#fff;
    border:1px solid #777;
    min-height:400px;
    box-shadow:2px 2px 5px rgba(0,0,0,0.9);
    padding:10px;
}
.img-container{
    width:300px;
    height:250px;
    margin:auto;
}
.img-container img{
    width:100%;
    height:100%;
}
</style>
