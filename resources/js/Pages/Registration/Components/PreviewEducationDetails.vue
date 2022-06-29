<template>
  <article class="preview-details">
      <h2>
          Education and Certifications
          <Link :href="'/employee/registration/'+user.username+'?step=1'" class="float-right">
              <small class="fa fa-edit"></small> 
          </Link>
      </h2>
      <div class="row mt-3">

          <div class="col-4 mb-3">
              <p class="text-capitalize">
                  Name: {{user.first_name}} {{user.middle_name}} {{user.surname}}
              </p>
          </div>

          <div class="col-4 mb-3">
              <p >
                  Date of Birth: {{formartDate(getMetaValue('dob',user.meta))}}
              </p>
          </div>

          <div class="col-4 mb-3">
              <p class="text-capitalize">
                  Gender: {{getMetaValue('gender',user.meta)}}
              </p>
          </div>

          <div class="col-4 mb-3">
              <p class="text-capitalize">
                  marital status: {{getMetaValue('marital_status',user.meta)}}
              </p>
          </div>

          <div class="col-4 mb-3">
              <p class="text-capitalize">
                  religion: {{getMetaValue('religion',user.meta)}}
              </p>
          </div>

          <div class="col-4 mb-3">
              <p class="text-capitalize">
                  national ID no: {{getMetaValue('national_id_no',user.meta)}}
              </p>
          </div>

          <div class="col-4 mb-3">
              <p class="text-capitalize">
                  passport no: {{getMetaValue('passport_no',user.meta)}}
              </p>
          </div>

          <div class="col-4 mb-3">
              <p class="text-capitalize">
                  huduma no: {{getMetaValue('huduma_no',user.meta)}}
              </p>
          </div>

          <div class="col-4 mb-3">
              <p class="text-capitalize">
                  kra pin no: {{getMetaValue('kra_pin_no',user.meta)}}
              </p>
          </div>

          <div class="col-4 mb-3">
              <p class="text-capitalize">
                  nhif no: {{getMetaValue('nhif_no',user.meta)}}
              </p>
          </div>

          <div class="col-4 mb-3">
              <p class="text-capitalize">
                  nssf no: {{getMetaValue('nssf_no',user.meta)}}
              </p>
          </div>

          <div class="col-4 mb-3">
              <p class="text-capitalize">
                  driving license no: {{getMetaValue('driving_license_no',user.meta)}}
              </p>
          </div>

          <div class="col-4 mb-3">
              <p class="text-capitalize">
                  nationality: {{getMetaValue('nationality',user.meta)}}
              </p>
          </div>

          <div class="col-4 mb-3">
              <p class="text-capitalize">
                  disabled: {{getMetaValue('disability',user.meta) ? 'yes' : 'no'}}
              </p>
          </div>

          <div v-if="getMetaValue('disability',user.meta)" class="col-4 mb-3">
              <p class="text-capitalize">
                  disability cert no: {{getMetaValue('disability_cert_no',user.meta)}}
              </p>
          </div>

          <div v-if="getMetaValue('disability',user.meta)" class="col-4 mb-3">
              <p class="text-capitalize">
                  disability description: {{getMetaValue('disability_description',user.meta)}}
              </p>
          </div>

          <div class="col-4 mb-3">
              <p>
                  Email: {{user.email}}
              </p>
          </div>

          <div class="col-4 mb-3">
              <p>
                  Phone: {{user.phone}}
              </p>
          </div>

          <div class="col-4 mb-3">
              <p class="text-capitalize">
                  Postal address: {{getMetaValue('postal_address',user.meta)}}
              </p>
          </div>

          <div class="col-4 mb-3">
              <p class="text-capitalize">
                  Postal code: {{getMetaValue('postal_code',user.meta)}}
              </p>
          </div>

           <div class="col-4 mb-3">
              <p class="text-capitalize">
                  City/Town: {{getMetaValue('city',user.meta)}}
              </p>
          </div>

          <div class="col-4 mb-3">
              <p class="text-capitalize">
                  Estate name: {{getMetaValue('estate_name',user.meta)}}
              </p>
          </div>

          <div class="col-4 mb-3">
              <p class="text-capitalize">
                  Physical Address: {{getMetaValue('physical_address',user.meta)}}
              </p>
          </div>

          <div class="col-4 mb-3">
              <p class="text-capitalize">
                  Estate name: {{getMetaValue('estate_name',user.meta)}}
              </p>
          </div>

          <div class="col-4 mb-3">
              <p class="text-capitalize">
                  Building name: {{getMetaValue('building_name',user.meta)}}
              </p>
          </div>

          <div class="col-4 mb-3">
              <p class="text-capitalize">
                  House No: {{getMetaValue('house_number',user.meta)}}
              </p>
          </div>

      </div>
  </article>
</template>

<script>
import moment from 'moment';
import {Link } from '@inertiajs/inertia-vue3';

export default {
 props:{
        user:Object,
    },
    components:{
        Link
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
        formartDate(val){
            if( ! val ) return val;

            return  moment(new Date(val)).format("Do MMM YYYY");
        },
    }
}
</script>

<style>

</style>