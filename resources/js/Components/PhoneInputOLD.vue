<template>
    <VueTelInput styleClasses="phone"  class="form-control" :class="classes" :id="id" :name="name" :inputOptions="inputOptions" :validCharactersOnly="true" :defaultCountry="defaultCountry" v-model="value" mode="international" @blur="validate" @change="change" />
</template>

<script>
import BreezeLabel from '@/Components/Label.vue'
import { VueTelInput } from 'vue-tel-input';
import 'vue-tel-input/dist/vue-tel-input.css';

export default {
    components:{BreezeLabel,VueTelInput},
    props:{ 
        id:String,
        min:Number,
        max:Number,
        name:{type:String,required:true},
        classes:String,
        label:String,
        placeholder:String,
        unique:Boolean,
        noSymbols:Boolean,
        noDigits:Boolean,
        noLetters:Boolean,
        required:Boolean,
        type:{type:String,required:true},
        initVal:String,
        phoneOrEmail:Boolean,
        userId:Number,
        modelid:Number,
        uniqueurl:String,
        sync:Boolean,
        syncurl:String,
        options:Array,
        category:String,
    },
    data: function(){
      return{
        value: this.initVal ? this.initVal : '',
        error:null,
        defaultCountry: 'KE',
        inputOptions:{name:this.name,required:this.required},
        makeApiCall:false

      }
    },

    methods:{
       emit(emit='save'){
        let response = {
          value:this.value,
          error:this.error,
          name:this.name,
          sync: emit == 'changed' ? true : false
          };
          
         if( emit !== 'save' )
          this.$emit(emit,response)
        
        this.$emit('save',response)

        this.makeApiCall = false
      },
      validate(){
        this.value = this.value.replace(/\D/g,'');
        this.value = this.value
        ? this.value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, " ")
        : "";

        if( !this.value.length && this.required ) return this.error = '*'
        else this.error = null

        if ( this.value.length && (this.value.length < this.min) ) 
                return this.error = 'Too short'
        else  this.error = null

        if ( this.value.length && (this.value.length > this.max) )
              return  this.error = 'Too long'
        else  this.error = null


        if( this.unique )
            this.valueExists()
        else
            this.error=null 

      this.emit()
      },
      valueExists(){
        if( ! this.value || ! this.makeApiCall ) return;
        axios({
          method: 'post',
          url: this.uniqueurl,
          data: {
            field:this.name,
            value:this.value,
            id:this.modelid
          }
        }).then((response) => {
          if(response.data) this.error = 'Already taken';
          else this.error=null;
          this.emit()
        })
        .catch( (error) => {
          console.log(error.response);
        });
      },
      change(){
        this.validate();
        this.emit('changed')
        this.makeApiCall = true
        if( this.sync && this.syncurl)
          this.syncToServer();

      },
      loading(val = false){
        let response = {
          value:val,
          name:this.name,
        };

        this.$emit('loading',response)
      },
      syncToServer(){
        //if( ! this.value ) return;
        if( ! this.makeApiCall ) return;
        this.loading(true)
            axios({
                method: 'patch',
                url: this.syncurl,
                data: {
                    field:this.name,
                    value:this.value,
                    type:this.type,
                    category:this.category,
                }
                }).then((response) => {
                    //console.log(response.data)
                    this.loading(false)
                })
                .catch( (error) => {
                console.log(error.response);
            });
        }
    },
    watch:{
      /*value(val){
        this.validate()
      }*/
    },
    mounted(){
      if( this.value ) this.emit();
    }
   
}
</script>

<style>

</style>