<template>
    <select  multiple="multiple" class="form-control select"  :name="name" :class="classes" :id="id"   :required="required" >
      <option value="">{{placeholder_val}}</option>
      <option v-for="(option,count) in options_arr" :key="count" :value="option">{{formartWords(option).replace(/\b\w/g, l => l.toUpperCase())}}</option>
    </select>
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
        options:Array,
        category:String
    },
    data: function(){
      return{
        value: this.initVal ? this.initVal : '',
        placeholder_val: this.placeholder ? this.placeholder : 'Choose...',
        options_arr : this.options ? this.options : [],
        data:[],
        error:null,
        makeApiCall:false

      }
    },
    methods:{
      save(){
        this.validateValue();
        this.emit()
      },
      getSelection(selected){
        let val = selected.id ? selected.id : selected.text
        let added = selected.selected
        if( added ) this.data.push(val)
        else delete this.data[this.data.indexOf(val)] 
        this.data = this.data.filter(x => x) 
        this.value = this.data;
        this.change()
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
      formartWords(slug){
            return slug ? slug.toString().replace(/[^a-zA-Z0-9,. ]/g,' ') : slug;
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

      $('#'+this.id).select2({
         placeholder: this.placeholder,
      });

      $('#'+this.id).val(this.value ? this.value : []);
      $('#'+this.id).trigger('change');

      $('#'+this.id).on('select2:select',  (e) => {
        this.getSelection(e.params.data)
      });

      $('#'+this.id).on('select2:unselect',  (e) => {
        this.getSelection(e.params.data)
      });


      //check if value is  not in option array add it to option array
      if( ! this.options_arr.includes(this.value) && this.value ){
        // Create a DOM Option and pre-select by default
        var newOption = new Option(this.formartWords(this.value), this.value, true, true);
        // Append it to the select
        $('#'+this.id).append(newOption).trigger('change');

      }

       //$( ".datepicker" ).datepicker();
       if( this.value ) this.emit();


    }
}
</script>

<style>

</style>