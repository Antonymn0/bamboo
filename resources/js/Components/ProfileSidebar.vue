<template>
  <div class="profile-sidebar border">
      <div class="contacts  pb-2">
          <ul>
              <li class="mb-2">
                  <span class="fa fa-phone-alt"></span>&nbsp;&nbsp;
                  {{formatPhone(user.phone)}}
              </li>
              <li class="mb-2">
                  <span class="fa fa-envelope"></span>&nbsp;&nbsp;
                  {{user.email}}
              </li>
              <li v-if="contract_start_date && contract_end_date && contract_type != 'permanent'" class="mb-2">
                  <span class="fa fa-calendar-alt"></span>&nbsp;&nbsp;
                  Contract Term: {{ calcAge(contract_start_date,contract_end_date) }} 
              </li>
              <li v-if="contract_start_date && contract_end_date && contract_type != 'permanent'" class="mb-2">
                  <span class="fa fa-clock"></span>&nbsp;&nbsp;
                  <span v-if="calcAge(new Date(),contract_end_date)">
                      Contract Expires In: {{ calcAge(new Date(),contract_end_date) }} 
                  </span>
                  <span v-else class="text-danger">
                      Contract Expired
                  </span>
              </li>
          </ul>
          <!--<ul class="social-icons mt-3">
              <li class="d-inline-block mr-4">
                   <a href="#">
                        <span class="fab fa-facebook"></span>
                    </a>
              </li>
              <li class="d-inline-block mr-4">
                   <a href="#">
                        <span class="fab fa-twitter"></span>
                    </a>
              </li>
              <li class="d-inline-block mr-4">
                    <a href="#">
                        <span class="fab fa-instagram"></span>
                    </a>
              </li>
              <li class="d-inline-block mr-4">
                    <a href="#">
                        <span class="fab fa-linkedin"></span>
                    </a>
              </li>
          </ul>-->
      </div>

      <div v-if="contract_start_date" class="contacts border-top mt-3 pb-2">
          <h3 class="text-theme">Hire Date</h3>
          <p>{{ formartDate(contract_start_date) }}</p>
      </div>

      <div v-if="contract_end_date" class="contacts border-top mt-3 pb-2">
          <h3 class="text-theme">End Date</h3>
          <p>{{ formartDate(contract_end_date) }}</p>
      </div>

      <div class="contact border-top mt-3 pb-2 ">
          <p class="pb-1"><span class="fa fa-id-card"></span> {{staff_id ? staff_id : user.id}}</p>
          <p class="pb-1 text-capitalize" v-if="contract_type"><span class="fa fa-user-clock"></span> {{contract_type}}</p>
          <p class="pb-1 text-capitalize" v-if="user.department"><span class="fa fa-building"></span> {{user.department.name}}</p>
          <p class="pb-1 text-capitalize" v-if="address"><span class="fa fa-map-marker-alt"></span> {{address}}</p>
      </div>

      <div v-if="subordinates.length" class="contacts border-top mt-3 pb-2 text-capitalize">
          <h3 class="text-theme">Supervises</h3>
          <p v-for="(subordinate,count) in subordinates" :key="count">
            <a :href="route('profile',subordinate.username)">
                {{subordinate.first_name}} {{subordinate.last_name}}
            </a>
          </p>
          <div v-if="last_subordinate_page > current_subordinate_page" class="text-theme">
                <a href="#" @click.prevent="getSubordinates(current_subordinate_page + 1)">
                    <small>
                        Load more ... 
                    </small>
                    <small v-if="loading" class="fa fa-spinner fa-spin"></small>
                </a>
          </div>
      </div>

      <div v-if="user.supervisor" class="contacts text-capitalize mt-3 pb-2">
          <h3 class="text-theme">Reports To</h3>
          <p>
              <a :href="route('profile',user.supervisor.username)">
                  {{user.supervisor.first_name}} {{user.supervisor.last_name}}
              </a>
          </p>
      </div>

  </div>
</template>

<script>
import moment from 'moment';

export default {
props:{
        settings:Array,
        user:Object,
        permissions:Array,
    },
    data() {
        return {
            staff_id:this.getMetaValue('staff_id',this.user.meta),
            contract_start_date:this.getMetaValue('contract_start_date',this.user.meta),
            contract_end_date:this.getMetaValue('contract_end_date',this.user.meta),
            contract_type:this.getMetaValue('contract_type',this.user.meta),
            contract_validity_period:0,
            address:this.getMetaValue('address',this.user.meta),
            subordinates:[],
            total_subordinates:  '',
            current_subordinate_page: '',
            last_subordinate_page: '',
            loading:false,
            subordinate_per_page:10,
            loading:false,

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
        formartDate(val){
            if( ! val ) return val;

            return  moment(new Date(val)).format("Do MMM YYYY");
        },
        calcAge(start,end){
            if( ! start || ! end ) return;

            let date1 = moment(new Date(start));
            let date2 = moment(new Date(end));

            let age = date2.diff(date1,'years');

            if( age ) return age > 1 ? age + ' years' : age <= 0 ? 0 : age + 'year';

            age = date2.diff(date1,'months');

            if( age ) return age > 1 ? age + ' months' : age <= 0 ? 0 : age + 'month';

            age = date2.diff(date1,'days');

            if( age ) return age > 1 ? age + ' days' : age <= 0 ? 0 : age + 'day';

            age = date2.diff(date1,'hours');

            if( age ) return age > 1 ? age + ' hours' : age <= 0 ? 0 : age + ' hour';


        },
         formatPhone(val) {
            return val.toString().replace(/\d{3}(?=.)/g, '$& ');
        },
        getSubordinates(page=1){
            this.loading = true;
            axios({
                method: 'GET',
                url: '/v1/users/subordinates/'+this.user.id+'?per_page='+this.subordinate_per_page+'&page='+page,
                data: {
                }
                }).then((response) => {
                    if( ! response.data.data ) return;
                    this.subordinates = [...this.subordinates, ...response.data.data] 
                    this.current_subordinate_page = response.data.current_page
                    this.last_subordinate_page = response.data.last_page
                    this.total_subordinates = response.data.total
                    this.loading = false
                })
                .catch( (error) => {
                console.log(error.response);
            });
        }

    },
    mounted(){
        setTimeout(() => this.getSubordinates(), 3000);
    }
}
</script>

<style>

</style>