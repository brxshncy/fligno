<template>
    <div>
        <form action="/charge" ref="form" method="post" @submit.prevent="pay()">
          <div class="container">
            <div class="row mt-5">
                <div class="col col-md-7">
                    <div class="card">
                      <div class="card-body">
                        <div class="row justify-content-center">
                            <div class="img-container">
                              <img :src="product.image !==null ? '/uploads/'+product.image : '/uploads/no-image.jpg' " alt="">
                            </div>
                        </div>
                        <div class="row mt-1">
                            <div class="col text-center">
                                 <h5>{{ product.product }}</h5>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                              <label for="">Price</label>
                              <input type="text" v-model="product.price" class="form-control" readonly>
                            </div>
                            <div class="col">
                              <label for="">Quantity</label>
                              <input type="text" v-model="product.quantity" class="form-control" readonly>
                            </div>
                        </div>
                        <div class="row mt-1">
                          <div class="col">
                              <label for="">Description</label>
                              <textarea class="form-control" v-model="product.description" cols="30" rows="3" readonly></textarea>
                          </div>
                        </div>
                        <div class="row mt-3">
                          <div class="col">
                            <div class="form-group">
                              <label for="">Enter Number of Purchase</label>
                              <input type="number" v-model="purchase" name="number_purchase" v-on:change="totalAmount" class="form-control">
                            </div>
                          </div>
                           <div class="col">
                            <div class="form-group">
                              <label for="">Total Amount Price in Pesos</label>
                              <input type="text" v-model="amount" name="amount" class="form-control" readonly>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col col-md-5">
                    <div class="card">
                      <div class="card-header text-center">Payment</div>
                      <div class="card-body">
                        <div class="row">
                          <div class="col">
                              <div class="form-group">Email</div>
                              <input type="text" v-model="data.email" name="email" class="form-control" readonly>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col">
                              <div class="form-group">Name</div>
                              <input type="text" v-model="data.name" name="name"  class="form-control" readonly>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col">
                              <div class="form-group">Address</div>
                              <input type="text" v-model="data.address" name="address" class="form-control" readonly>
                              <input type="hidden" name="user_id" :value="data.id">
                              <input type="hidden" name="product_id" :value="product.id">
                          </div>
                        </div>
                        <div class="row">
                          <div class="col">
                            <div class="form-group">Contact</div> 
                            <input type="text" v-model="data.contact" name="contact" class="form-control" readonly>
                            <input type="hidden" name="_token" :value="csrf">
                          </div>
                        </div>
                          <div class="row mt-1">
                            <div class="col">
                              <div class="form-group" style="">
                                  <label for="card-element">Credit or debit card</label>
                                    <card class='stripe-card'
                                            :class='{ complete }'
                                            stripe='pk_test_51HTQZqGxwQufiUoYUN0coCdDhbgWivP0hLhITwPM13KVkUWx4mcwpqrQtsc2qvL0GijszWOU36AHkJrIJe4LSBD800LXiJuBP3'
                                            :options='stripeOptions'
                                            @change='change($event)'
                                    />
                                      <!-- Used to display form errors. -->
                                    <div id="card-errors" role="alert" class="text-danger" v-text="errMsg"></div>
                                  </div>
                              </div>
                            </div>  
                          <div class="row mt-1">
                            <div class="col">
                                <button type="submit" class="btn btn-success btn-block">Submit</button>
                            </div>
                          </div>  
                          <div class="row mt-1">
                            <div class="col">
                              <router-link to="/home">
                                    <button type="submit" class="btn btn-secondary btn-block">Back</button>
                              </router-link>
                            </div>
                          </div>                
                      </div>
                    </div>
                    <div class="row mt-3" v-if="err">
                      <div class="col">
                        <div class="alert alert-danger text-center">
                            <b>{{ msg }}</b> 
                        </div>
                      </div>
                    </div>
                  </div>
            </div>
          </div>
        </form>
    </div>
</template>
<script>
import { Card, createToken } from 'vue-stripe-elements-plus'
export default {
    components: { Card },
    data () {
        return {
            complete: false,
            errMsg:'',
            amount:'',
            purchase:'',
            product:{},
           // currUser:{},
            msg:'',
            data:{},
            user_id: localStorage.getItem('user_id'),
            csrf:document.head.querySelector('meta[name="csrf-token"]').content,
            err:false,
            stripeOptions: {
            style: {
                base: {
                  color: '#32325d',
                  fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
                  fontSmoothing: 'antialiased',
                  fontSize: '16px',
                    '::placeholder': {
                      color: '#aab7c4'
                  }
                },
                invalid: {
                    color: '#fa755a',
                    iconColor: '#fa755a'
                }
              }
            }
        }
    },
    computed:{
      totalAmount() {
         this.amount = this.purchase * this.product.price
         return this.amount;
      }
    },
    created(){
      this.purchasedItem();
      this.currUser();
    },
    methods: {
      pay () {
          if(this.purchase > this.product.quantity){
            this.err = true;
            this.msg='Number of purchases exceed to the current quantity of the Item!';
          }
          else if(this.amount == 0){
            this.msg='Unable to make transaction, please purchase something!';
             this.err = true;
          }
          else{
            let options = {
              name:this.data.name
            }
            createToken(options).then(result =>{
                console.log(result.token)
                var hiddenInput = document.createElement('input');
                hiddenInput.setAttribute('type', 'hidden');
                hiddenInput.setAttribute('name', 'stripeToken');
                hiddenInput.setAttribute('value', result.token.id);
                console.log(hiddenInput);
                this.$refs.form.appendChild(hiddenInput);
                this.$refs.form.submit();
            })
          }  
      },

      change(event){
          this.errMsg = event.error ? event.error.message : ''
      },
      purchasedItem(){
          axios.get(`/api/item/${this.$route.params.productId}`)
          .then((res) =>{
            this.product = res.data;
            console.log(this.product);
          })
          .catch(err =>{
            console.log(err);
          })
      },
      currUser(){
        let user_id = this.user_id;
        console.log(user_id);
        axios.get(`/api/user/${user_id}`)
        .then(res =>{
          console.log(res.data)
          this.data = res.data;
        })
        .catch(err => {
          console.log(err);
        })
      }
    }
}
</script>
<style>
input,
.stripe-card {
  width: 100%;
  border: 1px solid grey;
}
.stripe-card.complete {
  border-color: green;
}
.img-container{
  width:300px;
  height:300px;
}
img{
  width:100%;
  height:100%;
}
</style>