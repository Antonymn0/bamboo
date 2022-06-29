<template>
    <div class="modal fade " :id="id" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" :id="id+'Label'">{{title}}</h5>
            <a href="#" @click.prevent="" class="btn-close" data-bs-dismiss="modal" >  </a>
        </div>
        <div class="modal-body">
            <slot name="form"></slot>
        </div>
        <div class="modal-footer">
            <button v-if="! dontShowSave" href="#" @click.prevent="saveForm" type="submit" class="btn btn-theme" :disabled="loading"> <small v-if="loading" class="fa fa-spinner fa-spin"></small> {{save}}</button>
            <a href="#" @click.prevent="" class="btn btn-secondary" data-bs-dismiss="modal">{{close}}</a>
        </div>
        </div>
    </div>
    </div>
</template>

<script>
export default {
    props:{
        id:{type:String,required:true},
        saveLabel:String,
        closeLabel:String,
        dontShowSave:Boolean,
        title:{type:String,required:true},
    },
    data() {
        return {
           save:this.saveLabel ? this.saveLabel : 'Save',
           close:this.closeLabel ? this.closeLabel : 'Cancel',
           loading:false
        }
    },
    methods:{
        saveForm(){
            this.loading = true
            this.$emit('save')
        }
    }
}
</script>

<style>

</style>