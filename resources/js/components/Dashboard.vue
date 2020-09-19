<template>
    <div>
        <div class="container">
            <div class="row mt-5">
                <div class="col">
                    <div class="card">
                        <div class="card-header text-center">Products</div>
                        <div class="card-body">
                            <div class="row" v-if="alertMessage">
                                <div class="col">
                                    <div class="alert alert-success text-center">
                                       <small> {{ message }}</small> 
                                    </div>
                                </div>
                            </div>
                             <div class="row">
                                   <div class="col"></div>
                                   <div class="col col-md-3 text-right">
                                       <button class="btn btn-block btn-primary"  data-toggle="modal" data-target="#exampleModal">Add Product</button>
                                   </div>
                               </div>
                           <table class="table table-striped table-bordered mt-3 ">
                                <thead>
                                    <tr class="text-center">
                                    <th scope="col">#</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Quantity</th>
                                    <th scope="col">Price</th>
                                    <th scope="col">Image</th>
                                    <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody v-if="products.length">
                                    <tr v-for="(product, index) in products" v-bind:key="product.id" class="text-center">
                                        <td>{{ index+1 }}</td>
                                        <td>{{ product.product }}</td>
                                        <td>{{ product.quantity }}</td>
                                        <td>{{ product.price }}</td>
                                        <td>
                                            <div class="img-container">
                                                <img :src="product.image !==null ? '/uploads/'+product.image : '/uploads/no-image.jpg'" class="img-thumbnail">
                                            </div>
                                        </td>
                                        <td>
                                            <router-link :to="{ name:'product',params:{productId:product.id} } ">
                                                <button class="btn btn-success">View</button>
                                            </router-link>
                                            <button class="btn btn-info">Edit</button>
                                            <button class="btn btn-danger" @click="deleteItem(product.id)">Delete</button>
                                        </td>
                                    </tr>
                                </tbody>
                                <tbody v-else>
                                    <tr class="text-center">
                                        <td colspan="6">No Product added.</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add Product</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="" v-on:submit.prevent="addProduct">
        <div class="modal-body">
            <div class="row">
                <div class="col">
                    <div class="form-group">
                    <label for="">Product Name</label>
                    <input type="text" v-model="product_name" class="form-control" required>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <div class="form-group">
                        <label for="">Quantity</label>
                        <input type="number" v-model="quantity" class="form-control" required>
                    </div>
                </div>
                <div class="col">
                    <div class="form-group">
                        <label for="">Price</label>
                        <input type="number" v-model="price" class="form-control" required>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <div class="form-group">
                    <label for="">Image</label>
                         <input type="file" @change="uploadImage" class="form-control">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col">
                <div class="form-group">
                    <label for="">Description</label>
                    <textarea  rows="4" v-model="description" class="form-control"></textarea>
                </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Add Product</button>
        </div>
      </form>
    </div>
  </div>
</div>
        </div>
        <!-- Modal -->
    </div>
</template>
<script>
export default {
    data(){
        return{
            token:localStorage.getItem('access_token') || null,
            user_role:localStorage.getItem('user_role') || null,
            message:'',
            product_name:'',
            price:'',
            quantity:'',
            description:'',
            img:'',
            products:[],
            counter:1,
            alertMessage:false,
        }
    },
    created(){
        this.loggedIn()
        this.getProducts();
    },
    methods:{
        loggedIn(){
            if(this.token !=null){
                this.$emit('loggedIn',{token:this.token,user_role:this.user_role});
            }
        },
        uploadImage(e){
            let fileReader = new FileReader();
            fileReader.readAsDataURL(e.target.files[0]);
            fileReader.onload = (e) =>{
                this.img  = e.target.result
    
            }
           
        },
        addProduct(){
            axios.post('/api/add-product',{
                product:this.product_name,
                price:this.price,
                quantity:this.quantity,
                description:this.description,
                img:this.img,
            })
            .then(res => {
                $('#exampleModal').hide();
                $('.modal-backdrop').remove();
                this.getProducts();
            })
            .catch((err) => console.log(err))
        },
        getProducts(){
            axios.get('/api/get-product')
            .then(res =>{
                this.products = res.data;
            })
            .catch(err => console.log(err));
        },
        deleteItem(id){
            axios.delete(`/api/delete-product/${id}`)
            .then(res => {
                this.message = res.data.message;
                this.alertMessage=true;
                this.getProducts();
            })
            .catch(err => console.log(err))
            .finally(()=>{
                setInterval(() => {
                    this.alertMessage = false;
                },2000)
            })
        }
    }
}
</script>
<style  scoped>
.img-container{
    width:200px;
    height:100px;
    margin:auto;
}
.img-container img{
    width:100%;
    height:100%;
    object-fit: cover;
}
</style>