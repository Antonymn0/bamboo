<template>
    <div>
      <div class="panel">
    <div class="material-textfield">
      <input v-model="value"  class="form-control" :type="type" :name="name" :class="classes" :id="id" :placeholder="placeholder" @keyup="search" :required="required" autocomplete="off" />
      <label>  {{label}} <span class="text-danger">{{error}}</span> </label>
    </div>
    </div>
      <div v-if="results.length" class="search-container">
        <div class="search-panel border">
          <ul>
            <li  v-for="(result,count) in results" :key="count" class="text-sm text-capitalize transition duration-150 ease-in-out" :class="{'border-bottom':count < results.length - 1}" @click="selectResult(result)">
              <span v-if="modeltype == 'user'"> {{result.first_name}} {{result.last_name}} </span>
              <span v-else> {{result.name}} </span>
            </li>
          </ul>
        </div>
      </div>
    </div>
</template>

<script>
import BreezeLabel from '@/Components/Label.vue'
import BreezeDropdown from '@/Components/Dropdown.vue';
import BreezeDropdownLink from '@/Components/DropdownLink.vue';
export default {
    components:{BreezeLabel, BreezeDropdown, BreezeDropdownLink},
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
        searchurl:String,
        modeltype:String,
        category:String
    },
    data: function(){
      return{
        value: this.initVal ? this.initVal : '',
        error:null,
        string:'',
        company:this.$page.props.auth.company,
        results:[],
      }
    },
    methods:{
      save(){
        //this.validateValue();
        this.emit()
      },
      change(){
        //this.save()
        this.emit('changed')
        if( this.sync && this.syncurl)
          this.syncToServer();

      },
      emit(emit = 'save'){
        let response = {
          value:this.value,
          error:this.error,
          name:this.name,
          sync: emit == 'changed' ? true : false
        };
          
        this.$emit('save',response)
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
          return this.error = '!'
        else this.error = null

        if ( this.value.length < this.min) 
                return this.error = '!'
        else  this.error = null

        if ( this.value.length > this.max)
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

      search(){
        if( this.value.length < 3 || ! this.searchurl ) return;
        
        axios({
                method: 'POST',
                url: this.searchurl,
                data: {
                    string:this.value,
                    company_id:this.company.id
                }
                }).then((response) => {//console.log(response.data)
                    if( response.data.data )
                      this.results = response.data.data  
                    
                    this.loading(false)
                })
                .catch( (error) => {
                console.log(error.response);
            });

      },
      selectResult(result){

        if( this.modeltype == 'user' )
          this.value = result.first_name + ' ' + result.last_name
        else 
          this.value = result.name

        this.$emit('selection',result)
        this.results = [];
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