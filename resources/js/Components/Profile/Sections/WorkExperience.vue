<template>
  <form>

      <div class="section">
          <h2 class="title-border pb-2"> 
              <span class="fa fa-user-tag"></span> 
              Work Experience
              
          </h2>
          
          <span v-for="(experience,count) in fields" :key="experience.id">
                <div :class="{'border-top':count}" class="mt-3">
                    <a v-if="loading.id == experience.id" class="float-right  mt-2" href="#" @click.prevent=""> <span class="fa fa-spinner fa-spin"></span> </a>
                    <a v-else class="float-right  mt-2" href="#" @click.prevent="remove(experience.id)"> <span class="fa fa-times"></span> </a>
                </div>
                <WorkExperienceFields :serial="count + 1" :user="user" :experience="experience" />
            </span>

          <p class="mt-2 ">
            <a v-if="processing" href="#" @click.prevent="" class="text-muted"> <span class="fa fa-spinner fa-spin" ></span> Add Work Experience</a>
            <a v-else href="#" @click.prevent="add"> <span class="fa fa-plus-circle" ></span> Add Work Experience</a>
          </p>

      </div>

    </form>
</template>

<script>

import WorkExperienceFields from './Components/WorkExperienceFields.vue';
export default {
    props:{
        settings:Array,
        user:Object,
        permissions:Array,
        showVerifyBox:Boolean,
    },
    data() {
        return {
            fields: this.user.work_experiences ? this.user.work_experiences : [{}],
            loading:{id:''},
            processing:false,
            permissions_arr:this.permissions ? this.permissions : [],
            showVerifyOption:this.showVerifyBox ? this.showVerifyBox : false,
            verificationPermission:'verify_reg_details',
            work_experience_details_verified_at:this.user.work_experience_details_verified_at ? this.user.work_experience_details_verified_at : '',
            work_experience_details_comments:this.user.work_experience_details_comments ? this.user.work_experience_details_comments : '',
            errors:{}
        }
    },
    components: {
        WorkExperienceFields
    },
    methods:{
        add(){
          this.processing = true
            axios({
                method: 'post',
                url: '/v1/work-experience',
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
                url: '/v1/work-experience/'+id,
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
    }
     
}
</script>