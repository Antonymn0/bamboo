<template>
  <div class="tab-pane-content">
    <h1 class="title-border pb-2"> <small class="fa fa-ambulance"></small> Emergency Contact </h1>
    <form action="">
        
        <div class="section">
          <h2 class="pb-2"> <span class="fa fa-user-circle"></span> Contact information</h2>
          <span v-for="(x,count) in fields" :key="x">
                <div v-if="count" class="border-top mt-3">
                    <a class="float-right  mt-2" href="#" @click.prevent="remove(x.id)"> <span class="fa fa-times"></span> </a>
                </div>
                <EmergencyFields />
            </span>

          <p class="mt-2 ">
            <a href="#" @click.prevent="add"> <span class="fa fa-plus-circle"></span> Add Emergency</a>
          </p>
              
      </div>


    </form>

 </div>
</template>

<script>

import EmergencyFields from './Sections/Components/EmergencyFields.vue';
export default {
    data() {
        return {
            fields:[
                {id:1}
            ]
        }
    },
    components: {
        EmergencyFields
    },
    methods:{
        add(){
            let item = {id:this.fields.length + 1};
            this.fields.push(item); 
        },
        remove(val){

            for( var i = 0; i < this.fields.length; i++)
                if( val == this.fields[i].id )
                    this.fields.splice(i,1);
        }
    }
     
}
</script>