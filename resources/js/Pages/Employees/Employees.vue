<template>
    <Head title="Dashboard" />

    <BreezeAuthenticatedLayout>
        <div class="container">
            <div class="section">
                <h1> <span class="fa fa-users"></span> People <small v-if="total_employees" class="text-muted">({{formatNumber(total_employees)}})</small>  </h1>
                
                <!--<div v-if="total_employees" class="row pt-4">               
                    <span class="col-md-2">
                        <SelectInput :class="{'border-danger':errors.bulk_action}"  :options="bulk_action_options"  id="bulk_action" label="Bulk Actions" name="bulk_action" type="text" :min="3" :max="255"  required noSymbols placeholder="" classes="text-capitalize" v-on:save="update" v-on:changed="update" initVal=""/>     
                    </span>-->
                    <!--<span class="col-md-4"> 
                        <button class="btn shadow btn-sm btn-theme text-capitalize" @click.prevent="detectBulkAction()"> 
                            <span v-if="bulk_action !== ''"> {{bulk_action}}</span> 
                            <span v-else> Action</span> 
                            </button>
                    </span>-->
                    <!--<span class="col text-right">
                        <button class="btn btn-sm btn-theme" @click.prevent="downloadEmployeesData()">Download</button>
                        <small class="text-danger pt-2"> <br> {{this.errors.download}} </small> 
                    </span>
                     <small class="text-danger pt-2"> {{this.errors.bulk_action}} </small>             
                </div>-->
            </div>       
            
            <div class="mt-2">
                    <a :href="route('onboard')" class="btn btn-outline-dark  btn-sm"> <span class="fa fa-plus-circle"></span> Create Employee</a>
                    
                    <select v-model="bulk_action" v-if="selected_employees.length" @change="detectBulkAction" class="form-control form-control-sm d-inline-block ml-3" style="max-width:150px">
                        <option value="">Choose Action</option>
                        <option v-for="(option,count) in bulk_action_options" :value="option" :key="count">{{formartWords(option)}}</option>
                    </select>

                    <a href="#" v-if="selected_employees.length" @click.prevent="downloadEmployeesData()" class="btn btn-outline-dark ml-3 btn-sm"> <span class="fa fa-download"></span> Download Records</a>

            </div>

            <div class="table-responsive mt-3">
                <table class="table">
                    <thead class="bg-light">
                        <tr>
                            <!--<th scope="col" class="text-center"> 
                            <span class="btn btn-theme rounded p-1 px-2" @click.prevent="selectAll()" v-if="! selected_employees.length">Select all </span>  
                            <span class="btn btn-theme rounded p-1 px-2" @click.prevent="unselectAll()" v-if="selected_employees.length">Unselect all</span> </th>-->
                            <th scope="col"> <input type="checkbox" @click="selectAll($event.target)" /> </th>
                            <th scope="col">Employee Photo </th>
                            <th scope="col">Staff ID</th>
                            <th scope="col">Full Name</th>
                            <th scope="col">Department</th>
                            <th scope="col">Contract Type</th>
                            <th scope="col">Hire Date</th>
                        </tr>
                    </thead>
                    <tbody class="text-capitalize">
                        <tr v-for="(employee,count) in employees_arr" :key="count">
                            <td class="align-middle">
                                <input type="checkbox"   name="employees" :id="employee.id" :value="employee.id" v-model="selected_employees">
                            </td>
                            <td :style="employee.reg_status != '0' ? 'opacity:0.5' : ''" style="position:relative">   
                                <Link :href="route('profile',employee.username)">                
                                    <div class="photo" :style="'background-image:url(https://i.pravatar.cc/300?img='+count+')'"></div>
                                    <div class="text-danger max-1-line image-label" >
                                        <small v-if="employee.reg_status == '1'">Registration intiated</small>
                                        <small v-else-if="employee.reg_status == '2'">Registration in review</small>
                                        <small v-else-if="employee.reg_status == '3'">Corrections requested</small>
                                        <small v-else-if="employee.reg_status == '4'">Registration review complete</small>
                                    </div>
                                </Link>
                            </td>
                            <td>
                                 <Link :href="route('profile',employee.username)">
                                    {{getMetaValue('staff_id',employee.meta)}}
                                </Link>
                            </td>
                            <td>
                                 <Link :href="route('profile',employee.username)">
                                    {{employee.first_name}} {{employee.last_name}}
                                </Link>
                            </td>
                            <td>
                                {{employee.department ? employee.department.name : ''}}
                            </td>
                            <td>
                                {{getMetaValue('contract_type',employee.meta)}}
                            </td>
                            <td>
                                {{formatDate(getMetaValue('contract_start_date',employee.meta))}}
                            </td>
                        </tr>
                    </tbody>
                    </table>
            </div>

            <div v-if="last_page > current_page" class="text-center text-theme">
                <a href="#" @click.prevent="fetchEmployees(current_page + 1)">Load more ... <small v-if="loading" class="fa fa-spinner fa-spin"></small> </a>
            </div>

        </div>
    </BreezeAuthenticatedLayout>
</template>

<script>
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue';
import { Head,Link } from '@inertiajs/inertia-vue3';
import AppHeader from '@/Components/AppHeader.vue';
import ProfileSidebar from '@/Components/ProfileSidebar.vue';
import Personal from '@/Components/Profile/Personal.vue';
import Job from '@/Components/Profile/Job.vue';
import SelectInput from '@/Components/SelectInput.vue';
import moment from 'moment';

export default {
    props:{
        
    },
    data: function(){
        return{
            auth_user:this.$page.props.auth.user,
            employees_arr:  [],
            total_employees:  '',
            selected_employees:[],
            current_page: '',
            last_page: '',
            loading:false,
            per_page:10,
            errors:{},
            bulk_action:'',
            bulk_action_options:[
                'clock in',
                'clock out',
                'suspend',                
                'unsuspend',
                'offboard' ,
                'download'              
            ],
            company:this.$page.props.auth.company,
        }
    },
    components:{
        BreezeAuthenticatedLayout,
        Head,
        Link,
        AppHeader,
        ProfileSidebar,
        Personal,
        Job,
        SelectInput,
    },
    watch: {
        selected_employees: function (new_value, old_value) {
           // console.log(new_value, old_value);
            if(new_value.length > old_value.length)this.detectBulkAction();
            else return;
        }
    },
    methods:{
        formatDate(date){
            return date ? moment(date).format('MMM Do YYYY') : date;
        },
        formatNumber(number){
            return number ? number : number;
        },
        getMetaValue(key,metaData){

            let value = '';

            for( let i = 0; i < metaData.length; i++ )
            {
                if( metaData[i].key == key ){
                    value = metaData[i].value
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

        fetchEmployees(page=1){
            this.loading = true
            axios({
                method: 'get',
                url: '/v1/employee/?per_page='+this.per_page+'&page='+page,
                data: {
                }
                }).then((response) => {
                    this.employees_arr = [...this.employees_arr, ...response.data.data] 
                    this.current_page = response.data.current_page
                    this.last_page = response.data.last_page
                    this.total_employees = response.data.total
                    this.loading= false
                })
                .catch( (error) => {
                console.log(error.response);
            });
        },
        selectAll(element){

            if( ! element.checked ) return this.unselectAll();

            this.employees_arr.forEach(employee => {
                this.selected_employees.push(employee.id);
                this.errors ={}
            });
        },
        unselectAll(){
                    this.selected_employees = [];
                },
        detectBulkAction(){
            this.errors={}
            if(this.selected_employees.length < 1) {this.errors.bulk_action = `Please select one  or more records`; return; }
            if(this.bulk_action == '' ) {/*this.errors.bulk_action = 'Select an action to perform';*/ return; } 
            if(! confirm(`Proceed with this ${this.bulk_action} operation`)) return;

            switch(this.bulk_action) {
                case 'clock in':
                    this.clockIn();
                    break;
                case 'clock out':
                    this.clockOut();
                    break;
                case 'clock out':
                    this.clockOut();
                    break;             
                case 'suspend':
                    this.suspend();
                    break;
                case 'unsuspend':
                    this.unSuspend();
                    break;
                case 'offboard':
                    this.offBoard();
                    break;
                case 'download':
                    this.downloadEmployeesData();
                    break;
                default:
                    this.errors.bulk_action = 'This action cannot be performed at this time';
                    return;
            }
        },
        clockIn(){
            var form_data = new FormData();
                form_data.append('selected_employees', this.selected_employees);
                form_data.append('company_id', this.company.id);
     
            axios.post(route('clock.in',this.auth_user.id ), form_data)
            .then(response=>{//console.log(response.data)
                alert('Success \n Clock in successful!');
            })
            .catch(error=>{
                if(error.response.status == 409) alert('One or more employees have already been clocked in today. \n Please select a different  record(s)')
                console.log(error.response);
            })
        },
        clockOut(){
            var form_data = new FormData();
                form_data.append('selected_employees', this.selected_employees);
                form_data.append('company_id', this.company.id);

            axios.post(route('clock.out',this.auth_user.id ), form_data)
            .then(response=>{
               // console.log(response);
                alert('Success \n Clock out successful!');
            })
            .catch(error=>{
                if(error.response.status == 404) alert('One or more employee have not been clocked in today!')
                if(error.response.status == 409) alert('Employee has already been clocked out today. \n Please select different  record')
                console.log(error.response);
            })
        },

        suspend(){
            var form_data = new FormData();
                form_data.append('selected_employees', this.selected_employees);

            axios.post(route('suspend.user',this.auth_user.id ), form_data)
            .then(response=>{
                //console.log(response);
                alert('Success \n User(s) suspended!');
            })
            .catch(error=>{
                if(error.response.status == 409) alert('Operation failed! \n User already suspended');
                console.log(error.response);
            })
        },
        unSuspend(){
            var form_data = new FormData();
                form_data.append('selected_employees', this.selected_employees);

            axios.post(route('un-suspend.user',this.auth_user.id ), form_data)
            .then(response=>{
                //console.log(response);
                alert('Success \n User restored!');
            })
            .catch(error=>{
                if(error.response.status == 409) alert('Operation failed! \n This user is not suspended');
                console.log(error.response);
            })
        },
      
        offBoard(){
            if(this.selected_employees.length >1) { alert('Operation failed! \n Please select only one record to offboard at a time!'); return; }
            else this.$inertia.get(route('offboard.user', this.selected_employees[0])  );
        },
        downloadEmployeesData(){
            if(this.selected_employees.length < 1) {this.errors.download = `Please select  records to download`; return; }
            if(!confirm('Dowload employee data?'))  return; 

            window.open( route('download.employees.data', JSON.stringify(this.selected_employees)  ) );
        },
        formartWords(slug){
            return slug ? slug.toString().replace(/[^a-zA-Z0-9,. ]/g,' ').replace('_',' ').replace(/\b\w/g, l => l.toUpperCase()) : slug;
        },
    },
    
    mounted(){
        this.fetchEmployees()
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
.photo{
    width: 50px;
    height: 50px;
    /*background-color: var(--theme-color);*/
    border-radius: 50%;
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
    display: inline-block;
}
.image-label{
    position:absolute;bottom:0;font-size:12px
}
</style>