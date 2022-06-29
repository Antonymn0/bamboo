<template>
<div class="panel">
    <div class="material-textfield">
      <flat-pickr  v-model="value" :defaultDate="initVal" :class="[error ? '' : '', classes ? classes : '']" class="form-control bg-white" :config="config"  :id="id" :placeholder="placeholder" @on-change="change"></flat-pickr>
    <label>  
      <small v-if="processing" class="fa fa-spinner fa-spin"></small>
      {{formartWords(label)}} 
      <small class="text-danger">{{error}} </small> 
      <small v-if="showAge && age" class="text-theme"> {{age}}</small> 
    </label>
    </div>
  </div>
</template>

<script>
import BreezeLabel from '@/Components/Label.vue'
import moment from 'moment';
import flatPickr from 'vue-flatpickr-component';
import 'flatpickr/dist/flatpickr.css';
export default {
    components:{BreezeLabel,flatPickr},
    props:{ 
        id:String,
        min:[String,Date],
        max:[String,Date],
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
        showAge:Boolean,
        readonly:Boolean,
        setMinimums:Array

    },
    data: function(){
      return{
        value: this.initVal ? this.initVal : '',
        error:null,
        makeApiCall:false,
        age:'',
        processing:false,
        config:{
         // dateFormat:"d/m/Y",
          minDate:this.min,
          maxDate:this.max,
        }
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
        };

        if( emit !== 'save' )
          this.$emit(emit,response)
        
        this.$emit('save',response)

        this.makeApiCall = false

        if( this.showAge ) 
          this.calcAge()

      },
      loading(val = false){
        let response = {
          value:val,
          name:this.name,
        };
        
        this.processing = val

        this.$emit('loading',response)
      },
      formartWords(slug){
            return slug ? slug.toString().replace(/[^a-zA-Z0-9,. ]/g,' ') : slug;
        },
      validateValue(){
        
        if( !this.value.length && this.required ) return this.error = '*'
        else this.error = null

        if( this.type === 'email' && ! /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(this.value) )
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
        },
        calcAge(){
            if( ! this.value ) return;
            let age = moment(new Date(this.value));
            let now = moment();

            this.age =  now.diff(age,'years') ? now.diff(age,'years') + 'years' : now.diff(age,'months') + 'months';
        },
        close(val){
          if( ! val ) return;
          $(".dp__select").click()

        },
        setMinimumDates(){

          if( ! this.setMinimums.length || ! this.id ) return;

          const start_date = flatpickr("#"+this.id, {}); 

          start_date.config.onChange.push(() => { 

            for( let i = 0; i < this.setMinimums.length; i++ )
            {
              let field = flatpickr("#"+this.setMinimums[i], {}); 
              field.config.minDate = start_date.input.value;
            }
            
          } );

          
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
        if( this.showAge && val )
          this.calcAge()
        if( val )
          this.change()
        else {
          this.age = ''
          this.value = ''
          this.change()
        }
      },
    },
    mounted(){
      /* $( "#"+this.id ).datepicker({
          onSelect: (dateText) => {
              this.value = dateText
              this.change()
          },
          minDate: this.min, 
          maxDate: this.max,
          changeMonth: true,
          changeYear: true, 
          dateFormat: 'dd/mm/yy',
      });
      */

       //flatpickr("#"+this.id, {});

       if( this.setMinimums )
        this.setMinimumDates()

       this.validateValue();
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
  top: 0%;
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