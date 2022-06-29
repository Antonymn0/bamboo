<template>
  <form>

      <div class="section">
          <h2 class="title-border pb-2"> 
              <span class="fa fa-language"></span> 
              Language <small class="text-danger">Add at least 1 language</small>
            </h2>

          
          <span v-for="(language,count) in fields" :key="language.id">
                <div :class="{'border-top':count}"  class="mt-3">
                    <a v-if="loading.id == language.id" class="float-right  mt-2" href="#" @click.prevent=""> <span class="fa fa-spinner fa-spin"></span> </a>
                    <a v-else class="float-right  mt-2" href="#" @click.prevent="remove(language.id)"> <span class="fa fa-times"></span> </a>
                </div>
                <LanguageFields :serial="count + 1" :user="user" :language="language" />

            </span>

          <p class="mt-2 ">
            <a v-if="processing" href="#" @click.prevent="" class="text-muted"> <span class="fa fa-spinner fa-spin" ></span> Add Language</a>
            <a v-else href="#" @click.prevent="add"> <span class="fa fa-plus-circle" ></span> Add Language</a>
          </p>
      </div>

    </form>
</template>

<script>

import LanguageFields from './Components/LanguageFields.vue';
export default {
    props:{
        settings:Array,
        user:Object,
        permissions:Array,
        showVerifyBox:Boolean,
    },
    data() {
        return {
            fields: this.user.languages ? this.user.languages : [{}],
            loading:{id:''},
            processing:false,
            permissions_arr:this.permissions ? this.permissions : [],
            showVerifyOption:this.showVerifyBox ? this.showVerifyBox : false,
            verificationPermission:'verify_reg_details',
            languages_details_verified_at:this.user.languages_details_verified_at ? this.user.languages_details_verified_at : '',
            languages_details_comments:this.user.languages_details_comments ? this.user.languages_details_comments : '',
            errors:{}
        }
    },
    components: {
        LanguageFields
    },
    methods:{
        add(){
          this.processing = true
            axios({
                method: 'post',
                url: '/v1/languages',
                data: {
                    user_id:this.user.id
                }
                }).then((response) => {
                    this.processing = false
                    this.fields.push(response.data)
                    this.disableSubmit( )
                })
                .catch( (error) => {
                console.log(error.response);
            });
        },
        remove(val){
            if( ! confirm("Are you sure you want to proceed") ) return;
            this.destroy(val);
        },
        destroy(id){
            this.loading.id = id
            axios({
                method: 'DELETE',
                url: '/v1/languages/'+id,
                data: {
                    
                }
                }).then((response) => {
                    this.loading.id = ''
                    this.fields = this.fields.filter((item)=> item.id.toString() != id.toString() );
                    this.disableSubmit( )
                })
                .catch( (error) => {
                console.log(error.response);
            });
        },
        syncToServer(field,value,type,ask=false,askMsg='Are you sure you want to proceed?',assignFieldValue=false){
            this.loading[field] = true
            if( ask )
                if( ! confirm(askMsg) ) return false;

            axios({
                method: 'patch',
                url: '/v1/users/'+this.user.id,
                data: {
                    field:field,
                    value:value,
                    type:type,
                }
                }).then((response) => {
                   if( assignFieldValue )
                        this[field] = value
                    this.loading[field] = false
                    this.disableSubmit( )
                })
                .catch( (error) => {
                console.log(error.response);
            });
        },
        can(permission){
            return this.permissions_arr.includes(permission);
        },
        disableSubmit( ){
            if( this.fields.length )
                $('.submit').css('pointer-events','').removeClass('opacity-25');
            else 
                $('.submit').css('pointer-events','none').addClass('opacity-25');
        }

    },
    mounted(){
        this.disableSubmit( )
    }
     
}
</script>