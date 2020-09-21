<template>
    <div>
        <div class="container mt-5">
            <div class="row">
                <div class="col">
                    <div class="card mt-5">
                        <div class="card-header text-center">
                            Sales
                        </div>
                        <div class="card-body">
                            <div class="col text-right">
                               <!-- Total Sales for today : {{ total_sale[0] }}-->
                            </div>
                            <table class="table table-striped table-bordered">
                                <thead class="text-center">
                                    <tr>
                                    <th scope="col">Item</th>
                                    <th scope="col">Total Purchase</th>
                                    <th scope="col">Amount</th>
                                    <th scope="col">Customer</th>
                                     <th scope="col">Date Purchase</th>
                                    </tr>
                                </thead>
                                <tbody class="text-center" v-if="sales.length > 0">
                                  
                                        <tr v-for="sale in sales" v-bind:key="sale.id">
                                            <td>{{ sale.item }}</td>
                                            <td>{{ sale.total_purchase }}</td>
                                            <td>  &#8369; {{ sale.total_amount }}</td>
                                            <td>{{ sale.name }}</td>
                                            <td>{{ sale.date_purchase }}</td>
                                        </tr>
                                    
                                </tbody>
                                 <tbody class="text-center"  v-else>
                                    <tr>
                                        <td colspan="5">No Sales</td>
                                    </tr>
                                </tbody>
                            </table>
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
            sales:'',
            total_sale:'',
             token:localStorage.getItem('access_token') || null,
        }
    },
    mounted(){
       
        axios.defaults.headers.common['Authorization'] = 'Bearer ' + this.token;
        axios.defaults.headers.post['Content-Type'] = 'multipart/form-data';
        axios.defaults.headers.post['Accept'] = 'application/json';
        this.getSales();
    },
    methods:{
        getSales(){
        axios.get('/api/sales')
            .then(res => {
                this.sales = res.data.sales
                this.total_sale = res.data.total_sales;
              
            })
            .catch(err =>{
                console.log(err);
            })
     }
    }
}
</script>