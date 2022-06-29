<template>
  <form>
        <div class="section">
            <h2 class="title-border pb-2">
                 <span class="fa fa-graduation-cap"></span>
                  Education
            </h2>

            <span v-for="(education,count) in fields" :key="education.id">
                <div :class="{'border-top':count}"  class="mt-3">
                    <a v-if="loading.id == education.id" class="float-right  mt-2" href="#" @click.prevent=""> <span class="fa fa-spinner fa-spin"></span> </a>
                    <a v-else class="float-right  mt-2" href="#" @click.prevent="remove(education.id)"> <span class="fa fa-times"></span> </a>
                </div>
                <EducationFields :serial="count + 1" :user="user" :education="education" />
            </span>

          <p class="mt-2 ">
            <a v-if="processing" href="#" @click.prevent="" class="text-muted"> <span class="fa fa-spinner fa-spin" ></span> Add Education</a>
            <a v-else href="#" @click.prevent="add"> <span class="fa fa-plus-circle" ></span> Add Education</a>
          </p>
          
        </div>

       

    </form>
</template>

<script>

import EducationFields from './Components/EducationFields.vue';
export default {
    props:{
        settings:Array,
        user:Object,
        permissions:Array,
        showVerifyBox:Boolean,
    },
    data() {
        return {
            fields: this.user.education ? this.user.education : [{}],
            loading:{id:''},
            processing:false,
            permissions_arr:this.permissions ? this.permissions : [],
            showVerifyOption:this.showVerifyBox ? this.showVerifyBox : false,
            verificationPermission:'verify_reg_details',
            education_details_verified_at:this.user.education_details_verified_at ? this.user.education_details_verified_at : '',
            education_details_comments:this.user.education_details_comments ? this.user.education_details_comments : '',
            errors:{}
        }
    },
    components: {
        EducationFields
    },
    methods:{
        add(){
          this.processing = true
            axios({
                method: 'post',
                url: '/v1/education',
                data: {
                    user_id:this.user.id
                }
                }).then((response) => {
                    this.processing = false
                    this.fields.push(response.data)
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
                url: '/v1/education/'+id,
                data: {
                    
                }
                }).then((response) => {
                    //console.log(response.data)
                    this.loading.id = ''
                    this.fields = this.fields.filter((item)=> item.id.toString() != id.toString() );
                })
                .catch( (error) => {
                console.log(error);
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
                   // console.log(response.data)
                   if( assignFieldValue )
                        this[field] = value
                    this.loading[field] = false
                })
                .catch( (error) => {
                console.log(error.response);
            });
        },
        can(permission){
            return this.permissions_arr.includes(permission);
        }
    },
    mounted(){
       // console.log(this.user)
    }
     
}
</script>

<style>

</style>