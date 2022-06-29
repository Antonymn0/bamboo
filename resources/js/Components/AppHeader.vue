<template >
    <header>
        <div class="container-fluid">
            <div class="row">
                <div class="col-3">
                    <div v-if="avatar_url" :style="{ backgroundImage: 'url(' + avatar_url + ')' }" @mouseenter="showEditor=true" @mouseleave="showEditor=false" class="logo-panel">
                        <div v-if="showEditor" class="logo-editor" @click="showUpdatePictureForm()">
                            <span class="fa fa-pen"></span>
                        </div>
                    </div>
                </div>
                <div class="col-9">
                    <div class="text-panel">
                        <h1>{{title_val}}</h1>
                        <hr v-if="subtitle">
                        <h2 v-if="subtitle" class="text-white">{{subtitle}}</h2>
                    </div>
                </div>
            </div>
        </div>
        <FormModal  :id="modalID" title="Profile Picture" closeLabel="Done" dontShowSave saveLabel="Change Picture" v-on:save="showUpdatePictureForm('hide')" >
            <template v-slot:form>
                <div class="company-reg-logo-panel">
					<div class="row">

						<div class="col text-center">
							<div class="company-logo">
								<img  :src="newPicture.public_uri ? newPicture.public_uri : avatar_url"  />
							</div>
							<a v-if="newPicture" href="#" @click.prevent="remove" class="text-danger">
								<small>
									Remove
								</small>
							</a>
						</div>

						<div class="col border-start d-flex align-items-center">
							<a href="#" id="company-logo-btn" class="btn btn-sm btn-success mb-2">Upload New Picture</a>
							<ImageInput activator="company-logo-btn" :mediaableId="authUser.id" mediaableType="App\Models\User" purpose="avatar" name="avatar_img" id="avatar_img" v-on:changed="save" />

						</div>

					</div>
					
				</div>
            </template>
        </FormModal>
    </header>
</template>

<script>
import FormModal from './FormModal.vue';
import ImageInput from '@/Components/ImageInput.vue';

export default {
    props:{
        user:Object,
        title:String,
        subtitle:String,
    },
    components:{
        FormModal,
        ImageInput
    },
    data: function(){
      return{
        showEditor:false,
        title_val:this.title ? this.title : '',
        avatar_url:this.$page.props.auth.avatar ? this.$page.props.auth.avatar.public_uri :  '/images/no-img.png',
        authUser:this.$page.props.auth.user,
        modalID:'updatePicture',
        newPicture:this.$page.props.auth.avatar ? this.$page.props.auth.avatar : ''
      }
    },
    methods:{
        showUpdatePictureForm(action='show'){
            jQuery('#'+this.modalID).modal(action);
        },
        save(response){
				let media = response.value

				if( media ){
					this.newPicture = media;
                    this.avatar_url = media.public_uri
                }

		},
        remove(){
			if( ! this.newPicture ) return;

			if( ! confirm("Are you sure you want to remove image?") ) return;

			axios({
                    method: 'delete',
                    url:'/v1/media/'+this.newPicture.id,
                    data: {
					},
                    }).then( response => {
                        if( response.data ){
							this.newPicture = ''
                            this.avatar_url = '/images/no-img.png'
                            this.getAvatar()
						} 
                    })
                    .catch( error => {
                    console.log(error.response);
                });
		}
    },
    mounted(){
    }
}
</script>

<style scoped>
header{
    background-color: var(--theme-color);
    padding-top: 12px;
    padding-bottom: 8px;
}
h1{
    text-transform: capitalize;
    color: var(--white);
    padding: 0px 0 0px 0;
    font-size: 2.4em;
}
.logo-panel{
    height: 120px;
    width: 120px;
    border: 2px solid var(--light);
    margin: 0 auto;
    border-radius: 5px;
    background-color:var(--theme-color-bright);
    position: relative;
    background-position: center;
    background-repeat: no-repeat;
    background-size: cover;
}
.logo-editor{
    height: 30px;
    width: 30px;
    background-color: var(--theme-color);
    border-radius: 50%;
    border: 1px solid var(--light);
    cursor: pointer;
    position: absolute;
    right: -20px;
    bottom: 5px;
    color: var(--white);
    text-align: center;
    line-height: 30px;
}
.text-panel{
    display: flex;
    height: 100%;
    flex-direction: column;
    justify-content: center;
}
hr{
    background: var(--light);
    margin: 10px 0;
}
</style>