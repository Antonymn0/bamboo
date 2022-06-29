<template>
        <div>
            <label class="text-capitalize" v-if="label" :for="name">{{formartWords(label ? label : name)}}</label>
            <select :data-none-selected-text="placeholder" v-model="value"  :name="name" :class="classes" :id="id" :placeholder="placeholder" @change="save" @blur="save" :required="required"  :data-live-search="search">
                <option v-for="(item,count) in data" :key="count"  >{{item.meta_description}}</option>
            </select>
            <p class="text-left m-0 p-0" v-if="error">
            <small  class="text-danger"> {{ error }} </small>
            </p>
        </div>
</template>

<script>

export default {
    props:{ 
        id:String,
        min:Number,
        max:Number,
        name:{type:String,required:true},
        classes:String,
        label:String,
        placeholder:String,
        unique:Boolean,
        uniqueurl:String,
        nosymbols:Boolean,
        nodigits:Boolean,
        noletters:Boolean,
        required:Boolean,
        initial:String,
        phoneoremail:Boolean,
        modelid:Number,
        errors:Object,
        krapin:Boolean,
        search:Boolean,
        data:Array,
    },
    data: function(){
      return{
        value: this.initial ? this.initial : '',
        error:this.errors[this.name] ? Array.isArray(this.errors[this.name]) ? this.errors[this.name].toString() : null : null,
       //errorsVal:this.errors[this.name] ? Array.isArray(this.errors[this.name]) ? this.errors[this.name] : [] : []
      }
    },
    methods:{
      save(){
        this.validateValue();
        this.emit()
      },
      emit(){
       // this.errorsVal = []
        //this.errorsVal.push(this.error)
       // alert(this.errors.length)
      },
      validateValue(){
        
        if( !this.value.length && this.required ) this.error = '*'

       else  if( this.krapin )
          if( ! Boolean(this.value.charAt(0).match(/[a-zA-Z]/)) ||  ! Boolean(this.value.slice(this.value.length - 1).match(/[a-zA-Z]/)) )
            this.error = '!'
          //else 
          //  this.error = ''

      else  if( this.type === 'email' && ! /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(this.value) )
          this.error = '!'

      else  if ( this.value.length < this.min) 
                this.error = '!'

       // else if (this.value.length > this.max)
          //      this.error = 'Too long'
        
        

        else if( this.unique )
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
          console.log(error);
        });
      },
      addRemoveErrorClass(){
        if( this.error ){
          jQuery("#submit").attr("disabled", true);
          jQuery('#'+this.id).addClass('border-danger')
        }
        else{
          jQuery("#submit").attr("disabled", false);
          jQuery('#'+this.id).removeClass('border-danger')
        } 
      },
      getErrorsString(errors){
        for( let i = 0; i < errors.length; i++ )
          this.error += errors+'<br/>'
      },
      formartWords(slug){
            return slug ? slug.toString().replace(/[^a-zA-Z0-9,. ]/g,' ') : slug;
        },
    },
    /*computed:{
      errosLength(){
        return this.errorsVal ? this.errorsVal.length : 0;
      }
    },*/
    watch:{
      value(val){
        if( this.nosymbols )
          this.value = val.replace(/[^a-zA-Z0-9, ]/g,'');
        if( this.nodigits ) 
          this.value = this.value.replace(/[0-9]/g, '');
        if( this.noletters ) 
          this.value = this.value.replace(/\D/g,'');
        if( this.phoneoremail )
          this.value = val.replace(/[^a-zA-Z0-9@.]/g,'');
        if( this.max )
          if( this.value.length > this.max )
            this.value = this.value.toString().substring(0, this.max)
      },
      error(val){
        this.addRemoveErrorClass()
      },
    },
    mounted(){
        this.addRemoveErrorClass()
    }
}
</script>

<style>

</style>