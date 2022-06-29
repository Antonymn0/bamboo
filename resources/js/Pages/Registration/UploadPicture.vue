<template>
    <Head title="Dashboard" />

    <BreezeAuthenticatedLayout :hideNavItems="true">
        <app-header :user="newEmployee" :title="newEmployee.first_name+' '+newEmployee.last_name" />

		<div class="container-fluid profile">
        <div class="row">
            <div class="col-3 profile-panel">
                <RegistrationSidebar :user="newEmployee" />
            </div>
            <div class="col-9">

                <nav>
                   <Tabs :active="9" :employee="newEmployee" :link="'/employee/registration/'+newEmployee.username" />
                </nav>

                    
			<div class="tab-pane-content p-4">
				<form @submit.prevent="" class="border  p-3">
				<h2 class="title-border pb-2"> 
					<span class="fa fa-info-circle"></span> 
					Upload Picture
				</h2>

				<div class="company-reg-logo-panel">
					<div class="row">
						<div class="col text-center">
							<div class="company-logo">
								<img  :src="avatar_url"  />
							</div>
							<a v-if="media" href="#" @click.prevent="remove" class="text-danger">
								<small>
									Remove
								</small>
							</a>
						</div>

						<div class="col border-start d-flex align-items-center">
							<a href="#" id="company-logo-btn" class="btn  btn-sm btn-success mb-2">Upload New Picture</a>
							<ImageInput activator="company-logo-btn" :mediaableId="newEmployee.id" mediaableType="App\Models\User" purpose="avatar" name="avatar" id="avatar" v-on:changed="save" />

						</div>

					</div>
					
				</div>

				
				</form>			
			</div>			

                <form class="border-top p-2 bg-light" id="submit-form" :action="route('employee.submit',newEmployee.username)">
                <Link :href="'/employee/registration/'+newEmployee.username+'?step=8'" class="btn btn-sm btn-secondary"> <span class="fa fa-chevron-left"></span> Back</Link>

                <Link :href="'/employee/registration/'+newEmployee.username+'?step=10'" class="ml-4 btn btn-sm btn-theme submit" :class="{ 'opacity-25': processing }" :disabled="processing">
                    Next Page
                </Link>
                    <Link @click.prevent="continueLater()" class="ml-4" >
                            Save and continue later 
                    </Link>
                </form>
                
                </div>

        </div>
    </div>
			
		
    </BreezeAuthenticatedLayout>      
</template>>

<script>
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue';
import { Head,Link } from '@inertiajs/inertia-vue3';
import AppHeader from '@/Components/AppHeader.vue';
import RegistrationSidebar from '@/Components/RegistrationSidebar.vue';
import Tabs from '@/Components/Tabs.vue';

import TextInput from '@/Components/TextInput.vue';
import DateInput from '@/Components/DateInput.vue';
import SelectInput from '@/Components/SelectInput.vue';
import BreezeLabel from '@/Components/Label.vue';
import ImageInput from '@/Components/ImageInput.vue';
export default {
	props:{
		newEmployee:Object,
		avatar:Object
	},
    components: {
    BreezeLabel,
    TextInput,
    SelectInput,
    DateInput,
    BreezeAuthenticatedLayout,
    Head,
    Link,
    AppHeader,
	RegistrationSidebar,
    ImageInput,
	Tabs
},
	data(){
		return{
				avatar_url: this.avatar ? this.avatar.public_uri : '/images/no-img.png',
				error:'',
				media: this.avatar ? this.avatar : '',
          		processing:false,
		}
	},
	methods:{
		getMetaValue(key,metaData){
            let value = '';
            for( let i = 0; i < metaData.length; i++ )
            {
                if( metaData[i].key == key ){
                    value = metaData[i].value;
                    break;
                }
            }
            return value;
        },

		save(response){
				//let name = response.name
               // let error = response.error
                //let blob = response.value.length ? response.value[0] : '' 





                /*this[name] = value;
                if( error ) this.errors[name] = error;
                else delete this.errors[name];*/

				let media = response.value

				if( media ){
					this.avatar_url = media.public_uri;
					this.media = media;
				}

		},

		attachDetach(){

		},



		remove(){
			if( ! this.media ) return;

			if( ! confirm("Are you sure you want to remove image?") ) return;

			axios({
                    method: 'delete',
                    url:'/v1/media/'+this.media.id,
                    data: {
					},
                    }).then( response => {
                        if( response.data ){
							this.media = ''
							this.avatar_url = '/images/no-image.png'
						} 
                    })
                    .catch( error => {
                    console.log(error.response);
                });
		}
		
	}
}
</script>

<style>

</style>