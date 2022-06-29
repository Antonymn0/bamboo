<template>
<div class="tab-pane-content">
    <h1 class="title-border pb-2 mb-2"> 
        <small class="fa fa-info-circle"></small>
         Assets  

         <a v-if="can('create_asset')" href="#"  @click.prevent="openModal" class="btn btn-secondary btn-sm"> <span class="fa fa-plus-circle"></span> Add Asset</a>
    </h1>
    
  <div class="section">
          <div v-if="assets.length" class="table-responsive">
                <table class="table">
                    <thead class="bg-light">
                        <tr>
                        <th scope="col">Name</th>
                        <th scope="col">Description</th>
                        <th scope="col">Serial No.</th>
                        <th scope="col">Date Assigned</th>
                        <th scope="col">Return Date</th>
                        <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody>

                        <tr v-for="asset in assets" :key="asset.id">
                            <td>
                                {{formartWords(asset.type)}}
                            </td>
                            <td>
                                Toyota Belta
                            </td>
                            <td>
                                {{getMeta(asset.meta,'reg_no') ? getMeta(asset.meta,'reg_no') : getMeta(asset.meta,'serial_no') }}
                            </td>
                            <td>
                               {{formatDate(asset.start_date)}}
                            </td>
                            <td>
                                {{formatDate(asset.end_date)}}
                            </td>
                            <td>
                                <button v-if="asset.assignee && can('edit_asset')" @click.prevent="assignAsset(asset.id, '')"  class="btn btn-sm btn-theme">Withdraw</button> 
                                <button v-else-if="can('edit_asset')" @click.prevent="assignAsset(asset.id)"  class="btn btn-sm btn-theme">Assign</button> 
                            </td>
                            
                        </tr>

                    </tbody>
                    </table>
            </div>
            <p v-else> No assets assigned to you.</p>

      </div>

      <FormModal :id="modalID" title="Create an Asset" v-on:save="save">
                <template v-slot:form>
                        <div class="row g-3">
                            <div v-for="(field,count) in fields_arr" :key="count" :class="[field.parent_classes ? field.parent_classes : 'col-4', (field.visible_if && user[field.visible_if]) || ! field.visible_if ? 'd-block' : 'd-none']" :id="field.name+'_parent'">
                                <DateInput v-if="field.type == 'date'" :setMinimums="field.set_minimums"  :class="[errors[field.name] ? 'border-danger' : '', field.classes ? field.classes : '']" :id="field.field_id" :name="field.name" :label="field.label" :type="field.type" :min="field.min"  :max="field.max" :noDigits="field.noDigits" :noSymbols="field.noSymbols" :noLetters="field.noLetters" :required="field.required" :placeholder="formartWords(field.placeholder ? field.placeholder : field.name)"  v-on:save="update" v-on:loading="setLoading" :initVal="field.init_val ? field.init_val :user[field.name]" :category="field.category" />
                                <SelectInput v-else-if="field.type == 'select' && field.options" :options="field.options"  :class="[errors[field.name] ? 'border-danger' : '', field.classes ? field.classes : '']" :id="field.field_id" :name="field.name" :label="field.label" :noDigits="field.noDigits" :noSymbols="field.noSymbols" :noLetters="field.noLetters" :type="field.type" :min="field.min"  :max="field.max" :required="field.required" :placeholder="formartWords(field.placeholder ? field.placeholder : 'Choose...')"  v-on:save="update" v-on:loading="setLoading" :initVal="field.init_val ? field.init_val :user[field.name]" :category="field.category" />
                                <ContentInput v-else-if="field.type == 'content'"  :class="[errors[field.name] ? 'border-danger' : '', field.classes ? field.classes : '']" :id="field.field_id" :name="field.name" :label="field.label" :type="field.type" :min="field.min" :noDigits="field.noDigits" :noSymbols="field.noSymbols" :noLetters="field.noLetters" :max="field.max"  :required="field.required" :placeholder="formartWords(field.placeholder ? field.placeholder : field.name)"  v-on:save="update" v-on:loading="setLoading" :initVal="field.init_val ? field.init_val :user[field.name]" :category="field.category" />
                                <PhoneInput v-else-if="field.type == 'phone'"  :class="[errors[field.name] ? 'border-danger' : '', field.classes ? field.classes : '']" :id="field.field_id" :name="field.name" :label="field.label" :type="field.type" :min="field.min"  :noDigits="field.noDigits" :noSymbols="field.noSymbols" :noLetters="field.noLetters" :max="field.max"  :required="field.required" :placeholder="formartWords(field.placeholder ? field.placeholder : field.name)"  v-on:save="update" v-on:loading="setLoading" :initVal="field.init_val ? field.init_val :user[field.name]" :category="field.category" />
                                <TimeInput v-else-if="field.type == 'time'"  :class="[errors[field.name] ? 'border-danger' : '', field.classes ? field.classes : '']" :id="field.field_id" :name="field.name" :label="field.label" :type="field.type" :min="field.min"  :max="field.max" :krapin="field.krapin" :noDigits="field.noDigits"  :noLetters="field.noLetters" :noSymbols="field.noSymbols" :required="field.required" :unique="field.unique" :uniqueurl="field.uniqueurl" :placeholder="formartWords(field.placeholder ? field.placeholder : field.name)"  v-on:save="update" v-on:loading="setLoading" :initVal="field.init_val ? field.init_val : task[field.name]" :modelid="employee.id" v-on:changed="update"  :category="field.category" />
                                <AddressInput v-else-if="field.type == 'address'"  :class="[errors[field.name] ? 'border-danger' : '', field.classes ? field.classes : '']" :id="field.field_id" :name="field.name" :label="field.label" :type="field.type" :min="field.min"  :max="field.max"  :krapin="field.krapin" :noDigits="field.noDigits" :noLetters="field.noLetters" :noSymbols="field.noSymbols" :required="field.required" :unique="field.unique" :uniqueurl="field.uniqueurl" :placeholder="formartWords(field.placeholder ? field.placeholder : field.name)"  v-on:save="update" v-on:loading="setLoading" :initVal="field.init_val ? field.init_val :user[field.name]" :modelid="user.id" v-on:changed="update"  :category="field.category" />
                                <TextInput v-else  :class="[errors[field.name] ? 'border-danger' : '', field.classes ? field.classes : '']" :id="field.field_id" :name="field.name" :label="field.label" :type="field.type"  :min="field.min"  :max="field.max" :krapin="field.krapin" :noDigits="field.noDigits" :noLetters="field.noLetters" :noSymbols="field.noSymbols" :required="field.required" :placeholder="formartWords(field.placeholder ? field.placeholder : field.name)"  v-on:save="update" v-on:loading="setLoading" :initVal="field.init_val ? field.init_val :user[field.name]" :category="field.category"/>
                            </div>
                        </div>
                </template>
            </FormModal>

</div>
</template>

<script>
import FormModal from '@/Components/FormModal.vue';
import TextInput from '@/Components/TextInput.vue';
import DateInput from '@/Components/DateInput.vue';
import SelectInput from '@/Components/SelectInput.vue';
import ContentInput from '@/Components/ContentInput.vue';
import PhoneInput from '@/Components/PhoneInput.vue';
import TimeInput from '@/Components/TimeInput.vue';
import AddressInput from '@/Components/AddressInput.vue';
import moment from 'moment';

export default {
    props:{
        user:Object,
        settings:Array,
        assetFormFields:Array,
        permissions:Array,

    },
    components:{
    TextInput,
    DateInput,
    SelectInput,
    ContentInput,
    PhoneInput,
    TimeInput,
    AddressInput,
    FormModal
},
    data: function(){
      return{
          processing:false,
          per_page:10,
          age:'',
          current_page:1,
          last_page:null,
          next_page:null,
          loading:{},
          modalID:'asset-form',
          errors:{},
          fields_arr:this.assetFormFields ? this.assetFormFields : [],
          assets: this.user.assets ? this.user.assets : [],
          permissions_arr:this.permissions ? this.permissions : [],
      }
    },
    methods:{
        formatDate(date){
                    return date ? moment(date).format('MMM Do YYYY') : date;
                },
        openModal(){
            jQuery('#'+this.modalID).modal('show');
        },
        save(){
               let fields = {}

               for( let i = 0; i < this.fields_arr.length; i ++  ){
                let field = this.fields_arr[i]
                
                if( this[field.name] )
                    fields[field.name] = this[field.name]

                fields['company_id'] = this.user.company_id
                fields['assigned_to'] = this.user.company_id
                

            }
            

            axios({
                method: 'post',
                url: '/v1/assets',
                data:fields,
                }).then((response) => {
                    window.location.search = '?active=5'
                })
                .catch( (error) => {
                console.log(error.response);
            });

        },
         formartWords(slug){
            return slug ? slug.toString().replace(/[^a-zA-Z0-9,. ]/g,' ') : slug;
        },
        update(response){
                let name = response.name
                let error = response.error
                let value = response.value
                this[name] = value;
                if( error ) this.errors[name] = error;
                else delete this.errors[name];

                if(  name == 'dob' ) this.calcAge(value)
                this.toggleFieldVisibility(name,value) 
                //else this.toggleFieldVisibility(name,false) 

            },
        updateAddress(response){
            let data = response.value
            this.lat = data.lat
            this.lng = data.lng
            this.country = data.country
            this.search_str = data.search_str
            this.postal_code = data.postal_code
            this.physical_address = data.physical_address
        },
        toggleFieldVisibility(id,value){

            if( ! $( "#"+id+"_parent" ).hasClass('toggler') )return;

            let selector = '.visible_if_'+id+'_'+value;

            $('.toggle_visibility').addClass('d-none') 

            if( $(selector).length )
                $(selector).removeClass('d-none')
            
        },
        setLoading(response){
            let name = response.name
            let value = response.value
            this.loading[name] = value;
            if( value ) this.loading[name] = value;
            else delete this.loading[name];
        },
        getMeta(metaData,key){
            if( ! metaData || ! key ) return;

            let value ='';
            for(let i=0; i< metaData.length; i++)
            {
                if( metaData[i].key == key )
                {
                    value = metaData[i].value;
                    break;
                }
            }
            return value;
        },
        assignAsset(assetID,value=this.user.id){
            if( ! confirm("Are you sure you want to proceed?")) return;

            axios({
                method: 'PATCH',
                url: '/v1/asset-patch/'+assetID,
                data:{
                    field:'assigned_to',
                    value:value
                },
                }).then((response) => {
                    window.location.search = '?active=5'
                })
                .catch( (error) => {
                console.log(error.response);
            });
        },
        can(permission){
            return this.permissions_arr.includes(permission);
        }
    }
}
</script>

<style scoped>
/*.edit{
    display: none;
}
tr:hover .edit{
    display: inline;
}*/
</style>