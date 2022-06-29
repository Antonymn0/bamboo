<template>
<div class="panel">
      <div class="material-textfield">
        <VueTelInput :styleClasses="[error ? '' : '', true ? 'phone' : '']" :class="classes" :id="id" :name="name" :inputOptions="inputOptions" :validCharactersOnly="true" :defaultCountry="defaultCountry" v-model="value" mode="international" @blur="validate" @change="change" />
        <label class="text-capitalize"> <small v-if="processing" class="fa fa-spinner fa-spin"></small>  {{label ? label : formartWords(placeholder)}} <span class="text-danger">{{error}}</span> </label>
      </div>
  </div>
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
        notnull:Boolean,
    },
    data: function(){
      return{
        value: this.initVal ? this.initVal : '',
        error:null,
        defaultCountry: 'KE',
        inputOptions:{name:this.name,required:this.required,placeholder:this.placeholder},
        makeApiCall:false,
        processing:false,

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
                return this.error = '!'
        else  this.error = null

        if ( this.value.length && (this.value.length > this.max) )
              return  this.error = '!'
        else  this.error = null


        if( this.unique )
            this.valueExists()
        else
            this.error=null 

      this.emit()
      },
      valueExists(){
        if( ! this.value /*|| ! this.makeApiCall*/ ) return;
       this.loading(true)
        axios({
          method: 'post',
          url: this.uniqueurl,
          data: {
            field:this.name,
            value:this.value,
            id:this.modelid
          }
        }).then((response) => {
          if(response.data) this.error = '!';
          else this.error=null;
          this.emit()
          this.loading(false)
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
        this.processing = val;
        this.$emit('loading',response)
      },
      syncToServer(){
        //if( ! this.value ) return;
        if( ! this.makeApiCall || this.error || this.processing ) return;
        if( this.notnull && ! this.value ) return;
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
        },
        formartWords(slug){
            return slug ? slug.toString().replace(/[^a-zA-Z0-9,. ]/g,' ') : slug;
        },
    },
    watch:{
      /*value(val){
        this.validate()
      }*/
    },
    mounted(){
       this.validate();
       this.emit();
    }
   
}
</script>

<style scoped>
.panel {
  height: 100%;
  display: flex;
  /*justify-content: center;
  align-items: center;*/
}

.material-textfield {
  position: relative;
  width: 100%;
}

label {
  position: absolute;
  font-size: 1rem;
  left: 0;
  top: -1px;
  transform: translateY(-50%);
  background-color: var(--white);
  color: var(--dark);
  padding: 0 0.3rem;
  margin: 0 0.5rem;
  transition: 0.1s ease-out;
  transform-origin: left top;
  pointer-events: none;
}

input {
  font-size: 1rem;
  outline: none;
  border: 1px solid var(--grey);
  border-radius: 5px;
  padding: 1rem 0.7rem;
  color: var(--dark);
  transition: 0.1s ease-out;
}

input:focus {
  border-color: var(--theme-color);
}
.form-control:focus {
  border-color: var(--theme-color);
  box-shadow: inset 0 1px 1px var(--light), 0 0 1px var(--theme-color);
}
input:focus+label {
  color: var(--theme-color);
  top: 0;
  transform: translateY(-50%) scale(0.9) !important;

}

input:not(:placeholder-shown)+label {
  top: 0;
  transform: translateY(-50%) scale(0.9) !important;
}

input:not(:focus)::placeholder {
  opacity: 0;
}
</style>