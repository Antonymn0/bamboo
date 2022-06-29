<template>
    <Head title="Dashboard" />
    <BreezeAuthenticatedLayout>
 <app-header title="Preferences" subtitle="Logo & color"  />
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
					<span class="fa fa-chart-pie"></span>
					Set color and logo
				</h2>

				<div class="py-3 row">
                    <div class="col-md-6">
                        <div>
                            <label for="logo"> Color </label>
                            <TextInput :class="{'border-danger':errors.color}" sync  :syncurl="route('company.patch', company.id)" id="color" name="color" type="text" :min="3" :max="255" noDigits required noSymbols placeholder="color" classes="text-capitalize"  :initVal="getMetaValue('color', company.meta)"/>					
                        </div>						
                    </div>			
					<div class="col-md-6">                        
						<div class=' text-center'>
                            <label for="logo"> Select Logo: </label>
                            <input type="file" id="file" class="form-control border py-2 rounded">
						</div>					
					</div> 				 					
					 					 					
				</div>
				<div class="text-right">
                    <Link :href="route('set.leave.options',company.id )" class="btn btn-secondary submit px-3 m-2 "> <span class="fa fa-chevron-left"></span>  Back</Link>
                    <Link :href="route('preferences.company.subscription',company.id )" class="btn btn-theme submit px-5 mx-2">  Continue </Link>
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
import Sidebar from '../../Layouts/Sidebar.vue';
import AppHeader from '@/Components/AppHeader.vue';

import TextInput from '@/Components/TextInput.vue';

export default {
    props:{
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
			errors:{}
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