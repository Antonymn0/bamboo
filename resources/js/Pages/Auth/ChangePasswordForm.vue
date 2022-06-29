<template>
    <Head title="Dashboard" />
    <BreezeAuthenticatedLayout>
 <app-header title="Preferences" subtitle="Password Reset"  />
        <div class="container">
           
            <div class="section">
                <h1> <span class="fa fa-cog"></span> Preferences   </h1>
            </div>
            <div class="row">
                <div class="col-md-3">
                    <Sidebar />
                </div>
                <div class="col-md-9 ">                    
                    <div class="tab-pane-content pt-4">
				<form @submit.prevent="" class="border  mx-auto p-3">
				<h2 class="title-border pb-2"> 
					<span class="fa fa-lock"></span>
					Reset password
				</h2>

				<div class="py-5 row">
                    <div class="col-md-6">
                        <div>
                            <label for="logo"> New password </label> <br>
                            <TextInput :class="{'border-danger':errors.color}" label="New password"  id="new_password" name="new_password" type="password" :min="4" :max="255"  v-on:changed="update"  required  placeholder="New password" classes="text-capitalize"  initVal=""/>					
                        </div>
                        <small class="text-danger">{{this.errors.new_password}}</small>			
                    </div>			
					<div class="col-md-6">                        
						<div >
                           
                           <div class="mt-2">
                                <label for="logo"> Confirm new password </label> <br>
                                <TextInput :class="{'border-danger':errors.color}" label="Confirm new password"  id="confirm_password" name="confirm_password" type="password" :min="4" :max="255"  v-on:changed="update" required  placeholder="Confirm password" classes="text-capitalize"  initVal=""/>					
                            </div>
                            <small class="text-danger">{{this.errors.confirm_password}}</small>
						</div>					
					</div> 				 					
					 					 					
				</div>
				<div class="text-right">
                    <Link :href="route('preferences')" class="btn btn-secondary submit px-3 m-2 ">  Cancel</Link>
                    <button class="btn btn-theme submit px-5 mx-2" @click.prevent="resetPassword()"> <span class="spinner-border  spinner-border-sm" v-if="spinner"></span> Reset </button>
                </div>	
				</form>			
			</div>	
                </div>                
            </div>            
        </div>        
    </BreezeAuthenticatedLayout>      
</template>>

<script>
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue';
import { Head,Link } from '@inertiajs/inertia-vue3';
import Sidebar from '../Preferences/Layouts/Sidebar.vue';
import AppHeader from '@/Components/AppHeader.vue';

import TextInput from '@/Components/TextInput.vue';

export default {
    props:{
        user:Object,
        company:Object
    },
    components:{
        Head,
        Sidebar,
        BreezeAuthenticatedLayout,
        TextInput,
        AppHeader
    },
	data(){
		return{
           
            new_password:null,
            confirm_password:null,
			errors:{},
            spinner:false
		}
	},
	methods:{
        update(response){
            let name = response.name
            let error = response.error
            let value = response.value
            this[name] = value;
            if( error ) this.errors[name] = error;
            else delete this.errors[name];

            this.checkPasswordmatch();
            
            if( name == 'disability' ) 
                if( value ) this.toggleDisabilityFields(true) 
                else this.toggleDisabilityFields(false) 
        },
        resetPassword(){
            this.validateForm();
            if(Object.keys(this.errors).length) return;
            var form_data = new FormData();
                form_data.append('new_password', this.new_password);

            if(!confirm("Change your password?")) return;
            this.spinner=true;
            
            axios.post(route('process.password.reset', this.user.id), form_data)
            .then(response=>{
                this.spinner=false;
                this.$inertia.get(route('preferences')  );
            })
            .catch(error=>{
                this.spinner=false;
                if (error.response.status == 401) this.errors.current_password = 'Invalid password';
                console.log(error.response);
            })
        },
        checkPasswordmatch(){    
            this.errors={}      
            if(this.new_password !== this.confirm_password) this.errors.confirm_password = 'Password does not match';
            
        },
        validateForm(){
            this.errors={}
            if(!this.new_password) this.errors.new_password = 'Please enter new password';
            if(!this.confirm_password) this.errors.confirm_password = 'Please enter new password again';

            if(this.new_password !== this.confirm_password) this.errors.confirm_password = 'Password does not match';
        }
		
	}
}
</script>


<style scoped>
.section{
    padding: 30px 0;
    border-bottom: 1px solid var(--grey);
}
.section h1{
    color: var(--theme-color);
}

li{
    padding: 15px;
}
li:hover{
    cursor: pointer;
    color: var(--theme-color);
}
.active{
    color: var(--theme-color);
}
</style>