<template>
  <div class="tab-pane-content">
      <h2 class="title-border pb-2"> <small class="fa fa-briefcase"></small> Job </h2>

      <div class="section mt-3">
          <h2 class="title-border pb-2 pt-2"> <span class="fa fa-info-circle"></span> Employment Status</h2>
          <div class="table-responsive mt-3">
                <table class="table">
                    <thead class="bg-light">
                        <tr>
                        <th scope="col">Employment Date</th>
                        <th scope="col">Employment Type</th>
                        <th scope="col">Contract Term</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="text-capitalize">
                            <td>
                                {{formartDate(getMetaValue('contract_start_date',user.meta))}}
                            </td>
                            <td>
                                {{getMetaValue('contract_type',user.meta)}}
                            </td>
                            <td>
                                {{ calcAge(getMetaValue('contract_start_date',user.meta),getMetaValue('contract_end_date',user.meta)) }}
                            </td>
                        </tr>
                    </tbody>
                    </table>
            </div>
          </div>



           <div class="section mt-3">
          <h2 class="title-border pt-2 pb-2"> <span class="fa fa-info-circle"></span> Job Information</h2>
          <div class="table-responsive mt-3">
                <table class="table">
                    <thead class="bg-light">
                        <tr>
                        <th scope="col">Job Title</th>
                        <th scope="col">Location</th>
                        <th scope="col">Department</th>
                        <th scope="col">Reports To</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="text-capitalize">
                            <td>
                                {{getMetaValue('position',user.meta)}}
                            </td>
                            <td>
                                {{getMetaValue('address',user.meta)}}
                            </td>
                            <td v-if="user.department">
                                {{user.department.name}}
                            </td>
                            <td >
                                <span v-if="user.supervisor">
                                    {{user.supervisor.first_name}} {{user.supervisor.last_name}}
                                </span>
                            </td>
                        </tr>
                    </tbody>
                    </table>
            </div>
          </div>



          <div v-if="user.benefits.length" class="section mt-3">
          <h2 class="title-border pb-2 pt-2"> <span class="fa fa-money-bill-wave"></span> Compensation</h2>
          <div class="table-responsive mt-3">
                <table class="table">
                    <thead class="bg-light">
                        <tr>
                        <th scope="col">Pay Schedule</th>
                        <th scope="col">Pay Type</th>
                        <th scope="col">Pay Rate</th>
                        <th scope="col">Overtime</th>
                        <th scope="col">Overtime Rate</th>
                        <th scope="col">Change Reason</th>
                        <th scope="col">Comment</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="benefit in user.benefits" :key="benefit.id">
                            <td>
                                {{benefit.pay_schedule}}
                            </td>
                            <td>
                                {{benefit.type}}
                            </td>
                            <td>
                                KES {{benefit.amount}}
                            </td>
                            <td>
                                {{benefit.overtime}}
                            </td>
                            <td>
                                {{benefit.overtime_rate}}
                            </td>
                            <td>
                                -
                            </td>
                            <td>
                                -
                            </td>
                        </tr>
                    </tbody>
                    </table>
            </div>
          </div>


  </div>
</template>

<script>
import moment from 'moment';

export default {
    props:{
        user:Object
    },
    methods:{
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
    }
}
</script>
