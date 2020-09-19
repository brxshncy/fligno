<template>
    <div>
        shope
        {{ message }}
    </div>
</template>
<script>
export default {
    data(){
        return{
            token:localStorage.getItem('access_token') || null,
            message:''
        }
    },
    created(){
        this.loggedIn()
    },
    methods:{
        loggedIn(){
            if(this.token !=null){
                this.message = "You are logged in";
                this.$emit('loggedIn',{token:this.token});
            }
        }
    }
}
</script>