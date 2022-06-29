<template>
    <Head title="Dashboard" />
    <BreezeAuthenticatedLayout>
 <app-header title="Preferences" subtitle="Time tracking"  />
        <div class="container">
           
            <div class="section">

                <h1> <span class="fa fa-cog"></span> Preferences   </h1>
            </div>
            <div class="row">
                <div class="col-md-3">
                    <Sidebar />
                </div>
                <div class="col-md-9 ">                    
                    <div class="container">
                            <div class="tab-pane-content pt-4">
                        <form action="#" class="border  mx-auto p-3" @submit.prevent="submitForm()">            
                                <h2 class="title-border pb-2"> 
                                    <span class="fa fa-chart-pie"></span> 
                                    Set opening & closing time
                                </h2>
                                <div class="pt-3 row ">                    
                                    <div class=' col-md-6 my-3'>
                                        <SelectInput :class="{'border-danger':errors.opening_time}" :options="opening_time_options"  id="opening_time" name="opening_time" type="text" :min="3" :max="255" sync :syncurl="route('company.patch', company.id)" required  placeholder="opening time" classes="text-capitalize" v-on:save="update" v-on:changed="update" :initVal="getMetaValue('opening_time',company.meta)"/> 
                                        <small class="text-danger"> {{this.errors.opening_time}} </small>
                                    </div>
                                    <div class='col-md-6 my-3'>
                                        <SelectInput :class="{'border-danger':errors.closing_time}" :options="closing_time_options"  id="closing_time" name="closing_time" type="text" :min="3" :max="255"  required sync :syncurl="route('company.patch', company.id)" placeholder="closing time" classes="text-capitalize" v-on:save="update" v-on:changed="update" :initVal="getMetaValue('closing_time',company.meta)"/>
                                        <small class="text-danger"> {{this.errors.closing_time}} </small>
                                  </div>
                                </div>
                                <div class="text-right pb-2 pt-4">
                                    <a :href="route('preferences')" class="btn btn-theme submit px-5 " > <span class="fa fa-chevron-left"></span> Back</a>
                                </div>
                            </form>
                        </div>    
                    </div>
                </div>                
            </div>            
        </div>        
    </BreezeAuthenticatedLayout>
</template>

<script>
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue';
import { Head,Link } from '@inertiajs/inertia-vue3';
import Sidebar from '../Layouts/Sidebar.vue';
import AppHeader from '@/Components/AppHeader.vue';

import SelectInput from '@/Components/SelectInput.vue';

export default {
    props:{
        company:Object
    },
    components:{
        Head,
        Sidebar,
        BreezeAuthenticatedLayout,
        SelectInput,
        AppHeader
    },
    data(){
        return{
            field:{},
            errors:{},
            opening_time_options:[
                    '07:00',
                    '07:30',
                    '08:00',
                    '08:30',
                    '09:00',
                    '09:30',
                    '10:00',
                    '10:30',
                    '11:00',
                    '11:30',
                    '12:00',
                    '12:30',
                    '13:00',
                    '13:30',
                    '14:00',
                    '14:30',
                    '15:00',
                    '15:30',
                    '16:00',
                    '16:30',
                    '17:00',
                    '17:30',
                    '18:00',
                    '18:30',
                    '19:00',
                    '19:30',
                    '20:00',
                    '20:30',
                    '21:00',
                    '21:30',
                    '22:00',
                    '22:30',
                    '23:00',
                    '23:30',
                    '00:00',
                    '00:30'
                    ],
            closing_time_options:[
                    '07:00',
                    '07:30',
                    '08:00',
                    '08:30',
                    '09:00',
                    '09:30',
                    '10:00',
                    '10:30',
                    '11:00',
                    '11:30',
                    '12:00',
                    '12:30',
                    '13:00',
                    '13:30',
                    '14:00',
                    '14:30',
                    '15:00',
                    '15:30',
                    '16:00',
                    '16:30',
                    '17:00',
                    '17:30',
                    '18:00',
                    '18:30',
                    '19:00',
                    '19:30',
                    '20:00',
                    '20:30',
                    '21:00',
                    '21:30',
                    '22:00',
                    '22:30',
                    '23:00',
                    '23:30',
                    '00:00',
                    '00:30'
                ]
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
        update(response){
            let name = response.name
            let error = response.error
            let value = response.value
            this[name] = value;
            if( error ) this.errors[name] = error;
            else delete this.errors[name];

            // if(  name == 'dob' ) this.calcAge(value)
            if( name == 'disability' ) 
                if( value ) this.toggleDisabilityFields(true) 
                else this.toggleDisabilityFields(false) 
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