<template>
    <div>
        <a class="dropdown-item" href="#">
           
            Item: <strong>  {{ notif.data.product_name }}</strong>
            has been purchased by
            <b>{{ notif['data'].customer_name }}</b>
            with a total purchased of <b>{{ notif['data'].quantity }} pieces</b>
            with a total amount of <b> &#8369; {{ notif['data'].amount }}</b> 
        </a>
    </div>
</template>
<script>
export default {
    props:['notif','index'],
}
</script>