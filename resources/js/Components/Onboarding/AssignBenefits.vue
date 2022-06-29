<template>
  <div>
        <span v-for="(benefit,count) in fields" :key="benefit.id">
            <div :class="{'border-top':count}" class="text-right">
                <a  href="#" @click.prevent="remove(benefit.id)"> <span class="fa fa-times"></span> </a>
            </div>
            <AssignBenefitsFields :employee="employee" :benefit="benefit" :formFields="formFields" />
        </span>
          <p v-if="! fields.length">Assign benefits to <span class="text-capitalize"> {{employee.first_name}} </span> </p>
          <p class="mt-2">
            <a href="#" @click.prevent="add"> <span class="fa fa-plus-circle"></span> Add Benefit</a>
          </p>

  </div>
</template>

<script>
import AssignBenefitsFields from './Components/AssignBenefitsFields.vue';
export default {
  components: { AssignBenefitsFields },
    props:{
        settings:Array,
        employee:Object,
        formFields:Array,
    },
    data: function(){
      return{
         fields: [],
         user:this.$page.props.auth.user,
      }
    },
    methods:{
       add(){
           axios({
                method: 'POST',
                url: "/v1/benefits",
                data: {
                    user_id:this.employee.id,
                    assigned_by:this.user.id
                }
                }).then((response) => {
                      //console.log(this.fields)
                      this.fields.push( response.data )
                })
                .catch( (error) => {
                console.log(error.response);
            }); 
        },
        remove(val){

          if( ! confirm("Are you sure you want to delete benefit?") ) return;
          this.deleteBenefit(val);
            /*for( var i = 0; i < this.fields.length; i++)
                if( val == this.fields[i].id ){
                  console.log(this.fields[i])
                }*/
            
        },
        getBenefits(){
          axios({
                method: 'GET',
                url: "/v1/benefits?user_id="+ this.employee.id,
                data: {
                    
                }
                }).then((response) => {
                    if( response.data.data.length )
                      this.fields = response.data.data
                })
                .catch( (error) => {
                console.log(error.response);
            });
        },
        deleteBenefit(id){
          if( ! id ) return false;

          axios({
                method: 'DELETE',
                url: "/v1/benefits/"+id,
                data: {
                    
                }
                }).then((response) => {
                   //console.log(response.data)
                   this.fields = this.fields.filter((item)=> item.id.toString() != id.toString() );
                })
                .catch( (error) => {
                console.log(error.response);
            });

        }
    },
    mounted(){
      this.getBenefits()
    }
}
</script>

<style>

</style>