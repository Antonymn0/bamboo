<template>
<div class="modal fade" :id="id_val" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" :id="id_val+'Title'">{{title_val}}</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        {{message_val}}
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{closeTitle_val}}</button>
        <button type="button" class="btn btn-primary" data-dismiss="modal" @click="save">{{saveTitle_val}}</button>
      </div>
    </div>
  </div>
</div>
</template>

<script>
export default {
    props:{
        message:String,
        closeTitle:String,
        id:String,
        saveTitle:String,
        title:String, 
    },
    data: function(){
      return{
        closeTitle_val: this.closeTitle ? this.closeTitle : 'Close',
        id_val:this.id ? this.id : 'confirmation-modal',
        message_val: this.message ? this.message : 'Are you sure you want to proceed?',
        saveTitle_val: this.saveTitle ? this.saveTitle : 'Save',
        title_val: this.title ? this.title : 'Confirmation',

      }
    },
    methods:{
        save(){
             this.$emit('save')
        }
    }
}
</script>

<style>

</style>