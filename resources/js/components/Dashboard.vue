<template>
    <div>
        <div class="container">
            <div class="row mt-5">
                <div class="col">
                    <div class="card mb-5">
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
                                       <button class="btn btn-block btn-primary" @click="addModal"  data-toggle="modal" data-target="#exampleModal">Add Product</button>
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
                                     <th scope="col">Description</th>
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
                                        <td>{{ product.description }}</td>
                                        <td>
                                            <button class="btn btn-info" @click="editProduct(product)">Edit</button>
                                            <button class="btn btn-danger" @click="deleteItem(product.id)">Delete</button>
                                        </td>
                                    </tr>
                                </tbody>
                                <tbody v-else>
                                    <tr class="text-center">
                                        <td colspan="7">No Product added.</td>
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
            <div class="row" v-if="imgdiv">
                <div class="col">
                    <p>Product Image</p>
                    <div class="img-container">
                        <img :src="productImage" alt="">
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
            <button type="submit" class="btn btn-primary">Save</button>
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
            id:'',
            product_name:'',
            price:'',
            quantity:'',
            description:'',
            img:'',
            products:[],
            counter:1,
            alertMessage:false,
            edit:false,
            productImage:'',
            imgdiv:false,
        }
    },
    created(){
        axios.defaults.headers.common['Authorization'] = 'Bearer ' + this.token;
        axios.defaults.headers.post['Content-Type'] = 'multipart/form-data';
        axios.defaults.headers.post['Accept'] = 'application/json';
        this.loggedIn()
        this.getProducts();
        this.loggedIn();
    },
    methods:{
        loggedIn(data){
           this.token = localStorage.getItem('access_token'),
           this.user_role = localStorage.getItem('user_role')
           this.$emit('loggedIn');
        },
        uploadImage(e){
            let fileReader = new FileReader();
            fileReader.readAsDataURL(e.target.files[0]);
            fileReader.onload = (e) =>{
                this.img  = e.target.result
            }
        },
        addModal(){
            this.edit = false;
            this.imgdiv = false;
            this.product_name = '';
            this.product_name = '';
            this.price = '';
            this.quantity = '';
            this.description = '';
            this.img = '';
        },
        addProduct(){
            if(this.edit === false){
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
                    this.$emit('addProduct');
                    this.getProducts();
                })
                .catch((err) => console.log(err))
            }
            else{
                axios.put('/api/edit-product',{
                    id:this.id,
                    product:this.product_name,
                    price:this.price,
                    quantity:this.quantity,
                    description:this.description,
                    img:this.img,
                })
                .then((res)=>{
                    console.log(res.data);
                    $('#exampleModal').hide();
                    $('.modal-backdrop').remove();
                    this.getProducts();
                })
                .catch((err)=>{
                    console.log(err);
                })
            }
            
        },
        getProducts(){
            axios.get('/api/get-product')
            .then(res =>{
                this.products = res.data;
            })
            .catch(err =>{ 
                console.log(err)
                if(error.response.status == 401){
                    setInterval(()=>{
                        alert('Only Authorized Personne can access to this page');
                        this.$router.push('/login');
                    },2000)
                }
            });
        },
        editProduct(product){
            this.edit = true;
            this.imgdiv = true;
            this.id = product.id;
            this.product_name = product.product;
            this.price = product.price;
            this.quantity = product.quantity;
            this.description = product.description;
            this.productImage = product.image !==null ? '/uploads/'+product.image : '/uploads/no-image.jpg';
            this.img = product.img;
            $('#exampleModal').modal('show');
        },
        deleteItem(id){
            axios.delete(`/api/delete-product/${id}`)
            .then(res => {
                this.message = res.data.message;
                this.alertMessage=true;
                 this.$emit('addProduct');
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