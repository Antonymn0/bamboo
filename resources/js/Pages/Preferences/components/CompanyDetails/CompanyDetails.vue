<template>
    <Head title="Dashboard" />
    <BreezeAuthenticatedLayout>
 <app-header title="Preferences" subtitle="Company details"  />
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
                            <span class="fa fa-id-card"></span> 
                            Update company details
                        </h2>

                        <div class="py-3 row">						
                            <div class="col-md-6">
                                <div class='my-3'>
                                    <TextInput :class="{'border-danger':errors.company_name}" sync  :syncurl="route('company.patch', company.id)" id="company_name" name="company_name" type="text" :min="3" :max="255" noDigits required noSymbols placeholder="Company name" classes="text-capitalize"  :initVal="company.company_name"/>
                                </div>
                                <div class='my-3'>
                                    <TextInput :class="{'border-danger':errors.physical_address}" id="physical_address" sync  :syncurl="route('company.patch', company.id)" name="physical_address" type="text" :min="3" :max="255" noDigits required noSymbols placeholder="Physical address" classes="text-capitalize"  :initVal="getMetaValue('physical_address', company.meta)"/>
                                </div>
                                <div class='my-3'>
                                    <TextInput :class="{'border-danger':errors.postal_code}" sync  :syncurl="route('company.patch', company.id)" id="postal_code" name="postal_code" type="text" :min="3" :max="255" noLetters required noSymbols placeholder="Postal Code" classes="text-capitalize"  :initVal="getMetaValue('postal_code', company.meta)"/>
                                </div>
                            </div> 

                            <div class="col-md-6">
                                <div class='my-3'>
                                    <AddressInput sync  :syncurl="route('company.patch', company.id)" placeholder="Company Location"  name="company_address" id="company_address" type="text" :class="{'border-danger':errors.company_address}"    :initVal="getMetaValue('company_address', company.meta)"/>
                                </div>
                                <div class='my-3'>
                                    <TextInput :class="{'border-danger':errors.country}" sync  :syncurl="route('company.patch', company.id)" id="country" name="country" type="text" :min="3" :max="255" noDigits required noSymbols placeholder="Country" classes="text-capitalize"  :initVal="getMetaValue('country', company.meta)"/>
                                </div>
                                <div class='my-3'>
                                    <TextInput :class="{'border-danger':errors.city}" sync  :syncurl="route('company.patch', company.id)" id="city" name="city" type="text" :min="3" :max="255" noDigits required noSymbols placeholder="City" classes="text-capitalize"  :initVal="getMetaValue('city', company.meta)"/>
                                </div>
                            </div> 					
                        </div>
                        <div class="text-right">
                            <Link  :href="route('preferences')" class="btn btn-secondary submit px-2 "> <span class="fa fa-chevron-left"></span> Back </Link>
                            <Link :href="route('preferences.company-details.departments',company.id )" class="btn btn-theme submit px-5 mx-2">  Continue </Link>
                        </div>				
                </form>
                </div>
                </div>                
            </div>            
        </div>        
    </BreezeAuthenticatedLayout>
</template>

<script>
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue';
import { Head,Link } from '@inertiajs/inertia-vue3';
import Sidebar from '../../Layouts/Sidebar.vue';
import AppHeader from '@/Components/AppHeader.vue';
import TextInput from '@/Components/TextInput.vue';
import SelectInput from '@/Components/SelectInput.vue';
import AddressInput from '@/Components/AddressInput.vue'

export default {
    props:{
        company:Object
    },
    components:{
        Head,
        Sidebar,
        BreezeAuthenticatedLayout,
        SelectInput,
        AppHeader,
        TextInput,
        AddressInput,
        Link
    },
    data(){
        return{
            field:{},
            errors:{},
            
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
        
    },
    mounted(){
        //
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