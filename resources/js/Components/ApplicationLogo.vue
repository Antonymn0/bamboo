<template>
    <img v-if="logo_url" class="img img-fluid" :src="logo_url" alt="">
</template>
<script>
export default {
    props:{
    },
    data: function(){
      return{
        showEditor:false,
        title_val:this.title ? this.title : '',
        user: this.$page.props.auth.user ? this.$page.props.auth.user : '',
        logo_url: this.$page.props.auth.logo ? this.$page.props.auth.logo.public_uri : '/images/logo.png'
      }
    },
    methods:{
        
    },
    
}
</script>
<style scoped>
img{
    height: 80px;
    width: 80px;
    border-radius: 50%;
    object-fit: cover;
    object-position: center;
    margin-top: 15px;
}
</style>
