<template>
<div>

  <div class="panel">
  <div class="material-textfield">
    <input v-model="value" class="form-control bg-white" :readonly="readonly" type="text" :name="name" :class="[error ? '' : '', classes ? classes : '']" :id="id" :placeholder="placeholder"  :required="required" @keyup="search" autocomplete="off" />
    <label> <small v-if="processing" class="fa fa-spinner fa-spin"></small>  {{label ? label :  formartWords(placeholder)}} <span class="text-danger">{{error}}</span> </label>
  </div>
</div>
  <div v-if="results.length" class="search-container">
      <div class="search-panel border">
        <ul>
          <li  v-for="(result,count) in results" :key="count" class="text-sm text-capitalize transition duration-150 ease-in-out" :class="{'border-bottom':count < results.length - 1}" @click="selectResult(result)">
            <span>{{result.post_office_name}}-{{result.postal_code}}</span>
          </li>
        </ul>
      </div>
    </div>
</div>
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
        category:String,
        readonly:Boolean,
        notnull:Boolean,

    },
    data: function(){
      return{
        value: this.initVal ? this.initVal : '',
        error:null,
        makeApiCall:false,
        processing:false,
        results:[],
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

        this.processing = val

        this.$emit('loading',response)
      },
      validateValue(){
        
        if( ! this.value.length && this.required ) return this.error = '*'
        else this.error = null

        if( this.value.length && this.type === 'email' && ! /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(this.value) )
          return this.error = '!'
        else this.error = null

        if ( this.value.length && (this.value.length < this.min) ) 
                return this.error = '!'
        else  this.error = null

        if ( this.value.length && (this.value.length > this.max) )
              return  this.error = '!'
        else  this.error = null

        if (  this.krapin )
              if( ! isNaN( this.value.charAt(0) ) || ! isNaN( this.value.charAt(this.value.length - 1) ))
                return this.error = '!'
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
          if(response.data) this.error = '!';
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
        search(){
        if( this.value.length < 3  ) return;
        
        axios({
                method: 'POST',
                url: '/v1/search/postal-codes',
                data: {
                    string:this.value
                }
                }).then((response) => {
                    if( response.data.length )
                      this.results = response.data
                      this.loading(false)
                    //console.log(this.results)
                })
                .catch( (error) => {
                console.log(error.response);
            });

      },
        selectResult(result){

          this.value = result.post_office_name+'-'+result.postal_code
          this.change()
          this.results = [];
        }
    },
    watch:{
      /*value(val){
        if( this.noSymbols )
          this.value = val.replace(/[^a-zA-Z0-9,. ]/g,'');
        if( this.noDigits ) 
          this.value = this.value.replace(/[0-9]/g, '');
        if( this.noLetters ) 
          this.value = this.value.replace(/\D/g,'');
        if( this.phoneOrEmail )
          this.value = val.replace(/[^a-zA-Z0-9@.]/g,'');
      }*/
    },
    mounted(){

       //$( ".datepicker" ).datepicker();

       this.validateValue();

       this.emit();

    }
}
</script>

<style scoped>
.search-container{
  position: relative;
}
.search-panel{
  position: absolute;
  width: 100%;
  overflow: hidden;
  overflow-y: auto;
  background-color: var(--white);
  top:5px;
  border-radius: 5px;
  padding: 0.3rem;
  max-height: 230px;
  box-shadow: 8px 5px 8px 2px var(--grey);
  z-index: 1000;
}
.search-panel ul li{
  padding: 0.3rem;
  cursor: pointer;
}
.search-panel ul li a{
 color: inherit;
}
.search-panel ul li:hover{
 color: var(--theme-color);
 border-color: var(--theme-color)!important;
}

.panel {
  height: 100%;
  display: flex;
  /*justify-content: center;
  align-items: center;*/
}

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
  top: 50%;
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