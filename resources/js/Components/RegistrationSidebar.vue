<template>
  <div v-if="user" class="profile-sidebar border">
      <div class="contacts  pb-2">
          <ul>
              <li class="mb-2 text-capitalize border-bottom">
                  <span class="fa fa-user-tie"></span>&nbsp;&nbsp;
                  {{user.first_name}} {{user.last_name}}
              </li>
              <li class="mb-2 border-bottom pb-2">
                  <span class="fa fa-envelope"></span>&nbsp;&nbsp;
                  {{user.email}} 
              </li>
              <li class="mb-2 border-bottom pb-2">
                  <span class="fa fa-phone-alt"></span>&nbsp;&nbsp;
                  {{user.phone}} 
              </li>
               <li class="mb-2 border-bottom pb-2">
                  <span class="fa fa-calendar"></span>&nbsp;&nbsp;
                  Contract start date {{formartDate(getMetaValue('contract_start_date',user.meta))}} 
              </li>
              <li class="mb-2 border-bottom pb-2">
                  <span class="fa fa-calendar"></span>&nbsp;&nbsp;
                  Reports on {{formartDate(getMetaValue('reporting_date',user.meta))}} 
              </li>
              <li class="mb-2 border-bottom pb-2">
                  <span class="fa fa-building"></span>&nbsp;&nbsp;
                  {{user.department.name}} Department
              </li>
          </ul>
      </div>

      

  </div>
</template>

<script>
import { Link } from '@inertiajs/inertia-vue3';
import moment from 'moment';

export default {
    props:{
        user:Object
    },
    data(){
		return{

		}
	},
    components:{
        Link
    },
    methods:{
        getMetaValue(key,metaData){
            if( ! metaData ) return null;

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

<style scoped>
.avatar{
    width: 50px;
    height: 50px;
    border-radius: 50%;
    display: inline-block;
    margin: 5px;
    background-position: center;
    background-size: cover;
    background-repeat: no-repeat;
}
</style>