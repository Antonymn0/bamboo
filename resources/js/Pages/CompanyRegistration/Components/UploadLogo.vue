<template>
    <Head title="Dashboard" />

    <BreezeAuthenticatedLayout :hideNavItems="true">
        <app-header :title="company.company_name" subtitle="Setup"  />
			
		<div class="pt-5">
			<div class="tab-pane-content pt-4">
				<form @submit.prevent="" class="border  mx-auto p-3">
				<h2 class="title-border pb-2"> 
					<span class="fa fa-info-circle"></span> 
					Upload Logo
				</h2>

				<div class="company-reg-logo-panel">
					<div class="row">

						<div class="col text-center">
							<div class="company-logo">
								<img  :src="logo_url"  />
							</div>
							<a v-if="media" href="#" @click.prevent="remove" class="text-danger">
								<small>
									Remove
								</small>
							</a>
						</div>

						<div class="col border-start d-flex align-items-center">
							<a href="#" id="company-reg-logo-btn" class="btn btn-sm btn-success mb-2">Upload New Logo</a>
							<ImageInput activator="company-reg-logo-btn" :mediaableId="company.id" mediaableType="App\Models\Company" purpose="logo" name="company_logo" id="company_logo" v-on:changed="save" />

						</div>

					</div>
					
				</div>

				<div class="text-right">
                    <Link :href="route('company.registration.set-departments', user.username)" class="btn  btn-sm btn-secondary submit px-3 m-2 "> <span class="fa fa-chevron-left"></span>  Back</Link>
					<Link :href="route('company.registration.subscription', user.username)"  class="btn  btn-sm btn-theme submit px-5 " :class="{' disabled opacity-25':loading}" ><small class="spinner-border spinner-border-sm" v-if="loading"></small> Continue </Link>
				</div>	
				</form>			
			</div>			
		</div>
    </BreezeAuthenticatedLayout>      
</template>>

<script>
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue';
import { Head,Link } from '@inertiajs/inertia-vue3';
import AppHeader from '@/Components/AppHeader.vue';

import TextInput from '@/Components/TextInput.vue';
import DateInput from '@/Components/DateInput.vue';
import SelectInput from '@/Components/SelectInput.vue';
import BreezeLabel from '@/Components/Label.vue';
import ImageInput from '@/Components/ImageInput.vue';
export default {
	props:{
		user:Object,
		company:Object,
		logo:Object
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
    ImageInput
},
	data(){
		return{
				logo_url: this.logo ? this.logo.public_uri : '/images/no-img.png',
				error:'',
				media: this.logo ? this.logo : '',
				loading:false
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
					this.logo_url = media.public_uri;
					this.media = media;
				}

		},

		attachDetach(){

		},



		remove(){
			if( ! this.media ) return;

			if( ! confirm("Are you sure you want to remove image?") ) return;

			this.loading = true

			axios({
                    method: 'delete',
                    url:'/v1/media/'+this.media.id,
                    data: {
					},
                    }).then( response => {
                        if( response.data ){
							this.media = ''
							this.logo_url = '/images/no-image.png'
						} 
						this.loading = false

                    })
                    .catch( error => {
                    console.log(error.response);
                });
		},

		activate_account(){

			if( ! this.company || ! this.user ) return;
			this.loading = true

			axios({
                    method: 'post',
                    url:'/v1/subscribe/'+this.company.id,
                    data: {
					},
                    }).then( response => {
                        console.log(response.data)
						this.loading = true
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