<template>
  <div class="type">
    <a title="Calculate Balance" href="#" class="calculator float-right">
        <span class="fa fa-calculator text-theme"></span>
    </a>
    <h2>{{title}}</h2>
    <p class="mt-2 mb-2 icon">
        <span v-if="icon" :class="icon"></span> {{balance}}
    </p>
    <p class="color-theme text-uppercase">
        {{period}} Available
    </p>
</div>
</template>

<script>
export default {
    props:{
        title:String,
        balance:String,
        period:String,
        icon:String
    },
    data() {
        return {
            
        }
}
}
</script>

<style scoped>
.type{
    max-width: 300px;
    background-color: var(--grey);
    text-align: center;
    border-radius: 5px;
    position: relative;
    cursor: pointer;
    padding: 15px;
}
.type h2{
    font-size: 1.4em;
    font-weight: 500;
}
.type .icon{
    font-size: 1.8em;
    font-weight: 700;
    color: var(--theme-color);
}
.btn-close{
    opacity: 1;
}
.calculator{
    display: none;
}
.type:hover .calculator{
    display: block;
}
</style>