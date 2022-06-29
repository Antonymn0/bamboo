<template>
  
          <div class="row g-3 pt-2 mt-2">

            <div class="col-8 mb-2">
                <TextInput :label="serial+'. Institution Name'" :class="{'border-danger':errors.institution_name}" id="institution_name" name="institution_name" type="text" :min="3" :max="255" noDigits required noSymbols placeholder="Institution Name" classes="text-capitalize" v-on:save="update" v-on:changed="save" :initVal="institution_name"/>
            </div>
            
            <div class="col-4 mb-2">
                <SelectInput label="Qualification" :options="qualificationOptions"  :class="{'border-danger':errors.qualification}" id="qualification" name="qualification" required noSymbols placeholder="Choose..." classes="text-capitalize" v-on:save="update" v-on:changed="save" :initVal="qualification" />
            </div>
             
            <div v-if="qualification == 'kcpe'" class="col-4 mb-2">
                <TextInput :class="{'border-danger':errors.marks}" id="marks" name="marks" type="text" noLetters required noSymbols placeholder="Marks" classes="text-capitalize" v-on:save="update" :initVal="marks" v-on:changed="update"/>
            </div>
            <div v-else-if="qualification == 'kcse' || qualification == 'cpe'" class="col-4">
                <SelectInput label="Grade Attained" :key="gradeAttainedOptions" :options="gradeAttainedOptions" :class="{'border-danger':errors.grade_attained}" id="grade_attained" name="grade_attained" required placeholder="Choose..." classes="text-capitalize" v-on:save="update" v-on:changed="save" :initVal="grade_attained" />
            </div>
            <div v-else-if="qualification == 'o level'" class="col-4">
                <SelectInput label="Grade Attained" :key="gradeAttainedOptions" :options="gradeAttainedOptions" :class="{'border-danger':errors.grade_attained}" id="grade_attained" name="grade_attained" required placeholder="Choose..." classes="text-capitalize" v-on:save="update" v-on:changed="save" :initVal="grade_attained" />
            </div>
            <div v-else-if="qualification == 'a level'" class="col-4">
                <SelectInput label="Grade Attained" noformat :key="gradeAttainedOptions" :options="gradeAttainedOptions" :class="{'border-danger':errors.grade_attained}" id="grade_attained" name="grade_attained" required noSymbols placeholder="Choose..." classes="text-capitalize" v-on:save="update" v-on:changed="save" :initVal="grade_attained" />
            </div>
            <div v-else class="col-4">
                <TextInput  id="field_of_study" label="Field of Study" required name="field_of_study" type="text"  :max="255" noDigits noSymbols placeholder="Field of study" classes="text-capitalize" v-on:save="update" v-on:changed="save" :initVal="field_of_study"/>
            </div>
            <!--<div v-if="qualification == 'kcpe' || qualification == 'kcse' || qualification == 'a level' || qualification == 'o level' || qualification == 'cpe'" class="col-5 p-0 m-0"></div>-->
            <div v-if="graduated && qualification != 'kcpe'" class="col-4">
                <SelectInput label="Grade" noformat :key="gradeOptions" :options="gradeOptions" :class="{'border-danger':errors.grade}" id="grade" name="grade" required noSymbols placeholder="Choose..." classes="text-capitalize" v-on:save="update" v-on:changed="save" :initVal="grade" />
            </div>
           <div v-if="grade == 'gpa'" class="col-4 p-0 m-0">
                <TextInput :class="{'border-danger':errors.gpa}" id="gpa" name="gpa" type="text"  noSymbols required  placeholder="GPA" classes="text-capitalize" v-on:save="update" :initVal="gpa" v-on:changed="update"/>
            </div>

            <div v-if="qualification == 'doctorate' || qualification == 'masters' || qualification == 'bachelor' || qualification == 'certificate' || qualification == 'diploma' || qualification == 'higher diploma'" class="col-12 mb-2">
                <input v-model="graduated" type="checkbox"  @change="save" > Already graduated 
            </div>

            <div  class="col-4">
                <DateInput label="Start Date"  :id="serial+'-start_date'" name="start_date" type="text"  required  placeholder="Start Date" classes="text-capitalize" v-on:save="update" v-on:changed="save" :initVal="start_date"/>
            </div>

            <div  class="col-4">
                <DateInput label="End Date" :key="start_date" :id="serial+'-end_date'" name="end_date" type="text" :min="start_date"  required placeholder="End Date" classes="text-capitalize" v-on:save="update" v-on:changed="save" :initVal="end_date"/>
            </div>
          </div>

</template>

<script>
import TextInput from '@/Components/TextInput.vue';
import DateInput from '@/Components/DateInput.vue';
import BreezeLabel from '@/Components/Label.vue';
import SelectInput from '@/Components/SelectInput.vue';
export default {
    props:{
        user:Object,
        education:Object,
        serial:Number
    },
    data() {
        return {
            id:this.education.id ? this.education.id : '',
            institution_name: this.education ? this.education.institution_name : '',
            qualification:this.education.qualification ? this.education.qualification : '',
            field_of_study:this.education.field_of_study ? this.education.field_of_study : '',
            start_date:this.education.start_date ? this.education.start_date : '',
            end_date:this.education.end_date ? this.education.end_date : '',
            grade:this.education.grade ? this.education.grade : '',
            gpa:this.education.gpa ? this.education.gpa : '',
            marks:this.education.marks ? this.education.marks : '',
            grade_attained:this.education.grade_attained ? this.education.grade_attained : '',
            graduated:this.education.graduated ? true : false,
            qualificationOptions:['kcpe',"cpe","kcse","o level","a level","certificate","diploma","higher diploma","bachelor","masters","doctorate"],
            gradeAttainedOptions:[],
            gradeOptions:[],
            errors:{},
            loading:false
        }
    },
    components: {
    BreezeLabel,
    TextInput,
    SelectInput,
    DateInput
},

    methods:{
        update(response){
                let name = response.name
                let error = response.error
                let value = response.value
                this[name] = value;
                if( error ) this.errors[name] = error;
                else delete this.errors[name];
                if( response.sync )
                    this.save()
                //this.disableSubmit( )
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
        save(){
            this.loading = true
            axios({
                method: 'post',
                url: '/v1/education',
                data: {
                    id:this.id,
                    institution_name: this.institution_name,
                    qualification:this.qualification,
                    field_of_study:this.field_of_study,
                    start_date:this.start_date,
                    end_date:this.end_date,
                    grade:this.grade,
                    gpa:this.gpa,
                    marks:this.marks,
                    graduated:this.graduated ? 1 : '',
                    grade_attained:this.grade_attained,
                    user_id:this.user.id
                }
                }).then((response) => {
                    this.id = response.data.id
                    this.loading = false
                    //console.log(this.id,response.data)
                })
                .catch( (error) => {
                console.log(error.response);
            });
        },
        getGradeOptions(){
            if( this.qualification == 'certificate' || this.qualification == 'diploma' || this.qualification == 'higher diploma' )
                this.gradeOptions =  ["pass","credit","distinction"];
            else if( this.qualification == 'bachelor' )
                this.gradeOptions = ["first class","second class upper","second class lower","pass"];
            else if( this.qualification == 'masters' )
                this.gradeOptions = ["masters"];
            else if( this.qualification == 'doctorate' )
                this.gradeOptions = ["doctor"];
            else if( this.qualification )
                this.gradeOptions = ["gpa"];
        },
        getGradeAttainedOptions(){
            if( this.qualification == 'kcse' )
                this.gradeAttainedOptions = ["A","A-","B+","B","B-","C+","C","C-","D+","D","D-","E"];
            else if( this.qualification == 'a level' )
                this.gradeAttainedOptions = ["A","B","C","D","O"];
            else if( this.qualification == 'o level' )
                this.gradeAttainedOptions = ["Division 1","Division 2","Division 3","Division 4"];
        },
        disableSubmit( ){

            if( ! Object.keys(this.errors).length )
                $('.submit').css('pointer-events','').removeClass('opacity-25');
            else 
                $('.submit').css('pointer-events','none').addClass('opacity-25');
        },
    },
    watch:{
        qualification(val){
            this.getGradeOptions()
            this.getGradeAttainedOptions()
        }
    },
    mounted(){
        //console.log(this.id)
        this.getGradeOptions()
        this.getGradeAttainedOptions()

    }
}
</script>

<style>

</style>