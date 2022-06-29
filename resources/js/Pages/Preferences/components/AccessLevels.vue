<template>
    <Head title="Dashboard" />

    <BreezeAuthenticatedLayout>
            <app-header title="Access levels" subtitle="Manage access & permisions"  />
        <div class="container">
            <div class="section">
                <h1> <span class="fa fa-cog"></span> Preferences   </h1>
            </div>

            <div class="row">
                <div class="col-md-3">
                    <Sidebar />
                </div> 
                <div class="col-md-9 p-2">
                    <div class="border rounded p-2 my-1" >
                        <h1 class="pl-2">Roles & permisions</h1>
                        <div class="pt-2 pb-4">
                            <ul v-for="(role, index) in current_roles" :key="index">
                                <li>
                                    <div class="accordion " id="accordionExample">
                                        <div class="accordion-item">
                                            <h2 class="accordion-header" id="headingOne">
                                            <button class="accordion-button " type="button" data-bs-toggle="collapse" :data-bs-target="'#collapse'+ index " data-bs-parent aria-expanded="false" :aria-controls="'collapseOne'+index">
                                                <span class="text-capitalize fw-bold"> {{role.name}} </span>
                                            </button>
                                            </h2>
                                            <div :id="'collapse'+ index " class="accordion-collapse collapse " aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                                <div class="accordion-body">
                                                <ul v-for="(permission, index) in current_permissions" :key="index">
                                                    <li >                                                            
                                                        <input type="checkbox" :id="index + role.id" :checked="checkIfRoleHasPermission(permission, role.permissions)" @change.prevent="toggleRolePermission(role.id, permission.id)" name="admin_permission" class="form-control mr-2" > 
                                                        <label :for="index + role.id"> {{permission.name.replace(/_/g, ' ')}}</label>
                                                    </li>
                                                </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            </ul>                           
                        </div>
                    </div> 

                    <div class="border rounded p-3 my-2 " >
                        <h2 class="py-3">Assign User permissions</h2>
                        <div class="row">
                                <div class="col-md-6">
                                    <p class="fw-bold mb-4"> Search user <br> </p>
                                    <p>
                                        <SearchInput  label="Search employee" modeltype="user" searchurl="/v1/users/search"  placeholder="Search Employee..." name="field.name" id="field.id" type="text" classes="form-control text-capitalize"  required v-on:selection="selectUser" :initVal="user.username"  />
                                    </p>
                                 </div>                    
                                <div class="col-md-6 px-3">
                                    <p class="fw-bold mb-3">Assigned Permissions </p>
                                    <ul  style="height:400px; overflow:scroll">
                                        <li v-for="(permission, index) in current_permissions" :key="index">                                                            
                                            <input type="checkbox" :id="index + 100 " :checked="checkIfRoleHasPermission(permission, current_user_permissions)" @change.prevent="toggleUserPermission(permission_user.id, permission.id)" name="admin_permission" class="form-control mr-2" > 
                                            <label :for="index + 100 "> {{permission.name.replace(/_/g, ' ')}}</label>
                                        </li>
                                    </ul>
                                </div>                    
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
import AppHeader from '@/Components/AppHeader.vue';
import ProfileSidebar from '@/Components/ProfileSidebar.vue';
import Personal from '@/Components/Profile/Personal.vue';
import Job from '@/Components/Profile/Job.vue';
import Sidebar from '../Layouts/Sidebar.vue';
import SearchInput from '../../../Components/SearchInput.vue';
export default {
    props:{
        roles:Object,
        permissions:Object,
        user_permissions:Object
    },
    components:{
        BreezeAuthenticatedLayout,
        Head,
        Link,
        AppHeader,
        ProfileSidebar,
        Personal,
        Job,
        Sidebar,
        SearchInput,
        
    },
    data(){
        return{
            user:this.$page.props.auth.user,
            current_roles:this.roles,
            current_permissions:  Object.keys(this.permissions) ? this.permissions : {},
            current_user_permissions:   Object.keys(this.user_permissions) ? this.user_permissions : {},
            permission_user: this.$page.props.auth.user, // default current auth user
        }
    },
    methods: {
        checkIfRoleHasPermission(permission, permissions_obj){
            if(! Object.keys(permissions_obj).length) return false;

            var role_has_permission = false;
            permissions_obj.forEach( (permission_item) =>{
                if(permission_item.id == permission.id ) return role_has_permission = true;
            });
            return role_has_permission;            
        },
        toggleRolePermission(role_id, permission_id){
            var form_data = new FormData();
                form_data.append('role_id', role_id);
                form_data.append('permission_id', permission_id);
            axios.post(route('toggle.role.permissions', this.user.id), form_data)
            .then(response=>{
                this.current_roles = response.data.data.roles;
                this.current_permissions = response.data.data.permissions;
            })
            .catch(error=>{
                console.log(error.response)
            })
        },
        toggleUserPermission(user_id, permission_id){
            var form_data = new FormData();
                form_data.append('user_id', user_id);
                form_data.append('permission_id', permission_id);
            axios.post(route('toggle.user.permissions', this.user.id), form_data)
            .then(response=>{
                console.log(response);
                this.current_permissions = response.data.data.permissions;
                this.current_user_permissions = response.data.data.user_permissions.length ? response.data.data.user_permissions : {};
            })
            .catch(error=>{
                console.log(error.response)
            })
        },
        getUserPermissions(user_id){
            axios.get(route('get.user.permissions', user_id))
            .then(response=>{
                console.log(response);
                this.current_permissions = response.data.data.permissions;
                this.current_user_permissions = response.data.data.user_permissions.length ? response.data.data.user_permissions : {};
            })
            .catch(error=>{
                console.log(error.response)
            })
        },
        selectUser(user){
            this.permission_user = user
            this.getUserPermissions(user.id);
        },
    },
    mounted(){
        this.getUserPermissions(this.permission_user.id);
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
    padding: 5px;
}
li label:hover{
    cursor: pointer;
    color: var(--theme-color);
}
.active{
    color: var(--theme-color);
}

.accordion-button:not(.collapsed) {
    color:rgb(82, 79, 79); 
    background-color: rgba(187, 185, 187, 0.027); 
    box-shadow: inset 0 -1px 0 rgba(0, 0, 0, 0.125);
}
.accordion-button:focus {
    z-index: 3;
    border-color: #9272922e;
    outline: 0;
    color:rgb(71, 70, 70);
    box-shadow: 0 0 0 0.25rem #80008063;
}
</style>