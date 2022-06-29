<template>
  <div class="section">
          <h2 class="title-border pb-2"> <span class="fa fa-comments"></span> Social Media</h2>
          <div class="row g-3 pt-2">
            <div class="col-8">
                <label for="facebook_link">
                   <StatusIcon :showLoading="loading.facebook_link"  /> 
                    Facebook 
                    <small class="text-danger"> {{errors.facebook_link}} </small>
                </label>
                <TextInput sync :syncurl="'/v1/users/'+this.user.id" :class="{'border-danger':errors.facebook_link}" id="facebook_link" name="facebook_link" type="text"  required  placeholder="Facebook link"  v-on:save="update" v-on:loading="setLoading" :initVal="facebook_link"/>
            </div>
            <div class="col-8">
                <label for="twitter_link">
                   <StatusIcon :showLoading="loading.twitter_link"  /> 
                    Twitter 
                    <small class="text-danger"> {{errors.twitter_link}} </small>
                </label>
                <TextInput sync :syncurl="'/v1/users/'+this.user.id" :class="{'border-danger':errors.twitter_link}" id="twitter_link" name="twitter_link" type="text"  required  placeholder="Twitter link"  v-on:save="update" v-on:loading="setLoading" :initVal="twitter_link"/>
            </div>
            <div class="col-8">
                <label for="linkedin_link">
                   <StatusIcon :showLoading="loading.linkedin_link"  /> 
                    Linkedin 
                    <small class="text-danger"> {{errors.linkedin_link}} </small>
                </label>
                <TextInput sync :syncurl="'/v1/users/'+this.user.id" :class="{'border-danger':errors.linkedin_link}" id="linkedin_link" name="linkedin_link" type="text"  required  placeholder="Linkedin link"  v-on:save="update" v-on:loading="setLoading" :initVal="linkedin_link"/>
            </div>
            <div class="col-8">
                <label for="instagram_link">
                   <StatusIcon :showLoading="loading.instagram_link"  /> 
                    Instagram  
                    <small class="text-danger"> {{errors.instagram_link}} </small>
                </label>
                <TextInput sync :syncurl="'/v1/users/'+this.user.id" :class="{'border-danger':errors.instagram_link}" id="instagram_link" name="instagram_link" type="text"  required  placeholder="Instagram link"  v-on:save="update" v-on:loading="setLoading" :initVal="instagram_link"/>
            </div>
          </div>
      </div>
</template>

<script>
import TextInput from '@/Components/TextInput.vue';
import BreezeLabel from '@/Components/Label.vue';
import StatusIcon from './Components/StatusIcon.vue';
export default {
    props:{
        user:Object
    },
    data() {
        return {
           facebook_link:this.user.facebook_link ? this.user.facebook_link : '',
           twitter_link:this.user.twitter_link ? this.user.twitter_link : '',
           linkedin_link:this.user.linkedin_link ? this.user.linkedin_link : '',
           instagram_link:this.user.instagram_link ? this.user.instagram_link : '',
           auth_user:this.$page.props.auth.user,
           errors:{},
           loading:{}
        }
    },
    components: {
        BreezeLabel,
        TextInput,
        StatusIcon,
    },
     methods:{
        update(response){
                let name = response.name
                let error = response.error
                let value = response.value
                this[name] = value;
                if( error ) this.errors[name] = error;
                else delete this.errors[name];
            },
        syncToServer(field,value,type){
            this.loading[field] = true
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
                    this.loading[field] = false
                })
                .catch( (error) => {
                console.log(error.response);
            });
        },
        setLoading(response){
            let name = response.name
            let value = response.value
            this.loading[name] = value;
            if( value ) this.loading[name] = value;
            else delete this.loading[name];
        },
    }
}
</script>

<style>

</style>