<template>
    <span>
    <small v-if="showCheck" class="fa fa-check-circle text-success"></small>
    <small v-if="showVerified" class="fa fa-check-circle text-success"></small>
    <small v-if="showLoading" class="fa fa-spinner fa-spin text-success"></small>
    </span>
</template>

<script>
export default {
    props:{
        showCheck:Boolean,
        showLoading:Boolean,
        showVerified:Number
    }
}
</script>

<style>

</style>