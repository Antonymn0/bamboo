<template>
  <div class="section">
          <h2 class="title-border pb-2"> <span class="fa fa-info-circle"></span> Visa Information</h2>
          <p class="mt-2 text-right">
            <a href="#" @click.prevent="openModal(0)"> <span class="fa fa-plus-circle"></span> Add Visa Information</a>
          </p>

          <div class="table-responsive mt-3">
                <table class="table">
                    <thead class="bg-light">
                        <tr>
                            <th scope="col">Date</th>
                            <th scope="col">Visa</th>
                            <th scope="col">Issuing Country</th>
                            <th scope="col">Issued</th>
                            <th scope="col">Expiry</th>
                            <th scope="col">Status</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                12/12/2021
                            </td>
                            <td>
                                Resident
                            </td>
                            <td>
                                Kenya
                            </td>
                            <td>
                                01/01/2021
                            </td>
                            <td>
                                01/01/2025
                            </td>
                            <td>
                                <span class="badge bg-success ">Valid</span>
                            </td>
                            <td>
                                <a href="#" @click.prevent="openModal(10)">
                                    <span class="fa fa-edit "></span>
                                </a>
                            </td>
                            
                        </tr>
                    </tbody>
                    </table>
            </div>

      <FormModal :id="modalID" title="Add Visa Information" >
          <template v-slot:form>
                <VisaFields :visa="selectedVisa"   />
          </template>
      </FormModal>

      </div>
</template>

<script>
import TextInput from '@/Components/TextInput.vue';
import BreezeLabel from '@/Components/Label.vue';
import FormModal from '@/Components/FormModal.vue';
import VisaFields from './Components/VisaFields.vue';
export default {
    data() {
        return {
            form: this.$inertia.form({
                first_name: '',
                middle_name: '',
                last_name: '',
                dob:'',
                gender:'',
                marital_status:'',
            }),
            errors:{},
            selectedVisa:{},
            modalID:'visaForm'
        }
    },
    components: {
        BreezeLabel,
        TextInput,
        FormModal,
        VisaFields,
    },
     methods:{
        update(response){
                let name = response.name
                let error = response.error
                let value = response.value
                this[name] = value;
                if( error ) this.errors[name] = error;
                else delete this.errors[name];
            },
        updateAddress(response){
            let data = response.value
            this.form.lat = data.lat
            this.form.lng = data.lng
            this.form.country = data.country
            this.form.search_str = data.search_str
            this.form.postal_code = data.postal_code
            this.form.physical_address = data.physical_address
        },
        openModal(id=null){
            if( id ) this.selectedVisa = {id:id} 
            else this.selectedVisa = {}
            jQuery('#'+this.modalID).modal('show');
        }
    }
}
</script>

<style>

</style>