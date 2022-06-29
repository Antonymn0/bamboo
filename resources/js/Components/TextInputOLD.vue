<template>
    <input v-model="value" class="form-control" :type="type" :name="name" :class="classes" :id="id" :placeholder="placeholder" @input="save" @change="change"  @blur="save" :required="required" />
    <!--<div class="panel">
    <div class="material-textfield">
      <input v-model="value" class="form-control" :type="type" :name="name" :class="classes" :id="id" :placeholder="placeholder" @input="save" @change="change"  @blur="save" :required="required" />
      <label>{{placeholder}}</label>
    </div>
  </div>-->
</template>

<script>
import BreezeLabel from '@/Components/Label.vue'

export default {
    components:{BreezeLabel},
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
        krapin:Boolean,
        modelid:Number,
        uniqueurl:String,
        sync:Boolean,
        syncurl:String,
        category:String

    },
    data: function(){
      return{
        value: this.initVal ? this.initVal : '',
        error:null,
        makeApiCall:false
      }
    },
    methods:{
      save(){
        this.validateValue();
        this.emit()
      },
      change(){
        this.validateValue();
        this.emit('changed')
        this.makeApiCall = true
        if( this.sync && this.syncurl)
          this.syncToServer();

      },
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
      loading(val = false){
        let response = {
          value:val,
          name:this.name,
        };

        this.$emit('loading',response)
      },
      validateValue(){
        
        if( !this.value.length && this.required ) return this.error = '*'
        else this.error = null

        if( this.type === 'email' && ! /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(this.value) )
          return this.error = 'Invalid'
        else this.error = null

        if ( this.value.length && (this.value.length < this.min) ) 
                return this.error = 'Too short'
        else  this.error = null

        if ( this.value.length && (this.value.length > this.max) )
              return  this.error = 'Too long'
        else  this.error = null

        if (  this.krapin )
              if( ! isNaN( this.value.charAt(0) ) || ! isNaN( this.value.charAt(this.value.length - 1) ))
                return this.error = 'Invalid Value'
              else  this.error = null

        if( this.unique )
            this.valueExists()
        else
            this.error=null 

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
      syncToServer(){
       // if( ! this.value ) return;
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
      value(val){
        if( this.noSymbols )
          this.value = val.replace(/[^a-zA-Z0-9,. ]/g,'');
        if( this.noDigits ) 
          this.value = this.value.replace(/[0-9]/g, '');
        if( this.noLetters ) 
          this.value = this.value.replace(/\D/g,'');
        if( this.phoneOrEmail )
          this.value = val.replace(/[^a-zA-Z0-9@.]/g,'');
      }
    },
    mounted(){

       //$( ".datepicker" ).datepicker();

       if( this.value ) this.emit();

    }
}
</script>

<style scoped>
.panel {
  height: 100%;
  display: flex;
  justify-content: center;
  align-items: center;
}

.material-textfield {
  position: relative;
}

label {
  position: absolute;
  font-size: 1rem;
  left: 0;
  top: 50%;
  transform: translateY(-50%);
  background-color: white;
  color: gray;
  padding: 0 0.3rem;
  margin: 0 0.5rem;
  transition: 0.1s ease-out;
  transform-origin: left top;
  pointer-events: none;
}

input {
  font-size: 1rem;
  outline: none;
  border: 1px solid gray;
  border-radius: 5px;
  padding: 1rem 0.7rem;
  color: gray;
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