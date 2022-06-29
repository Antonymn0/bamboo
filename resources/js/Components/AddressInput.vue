<template>
<div class="panel">
    <div class="material-textfield">
        <input v-model="value" class="form-control" :type="type" :name="name" :class="classes" :id="id" :placeholder="placeholder" @change="change" @blur="save" :required="required" />
        <label>{{label ? label : placeholder}} <span class="text-danger">{{error}}</span> </label>
    </div>
</div>
</template>

<script>
import BreezeInput from '@/Components/Input.vue'
import BreezeLabel from '@/Components/Label.vue'

export default {
    props:{
        id:String,
        min:Number,
        max:Number,
        name:{type:String,required:true},
        classes:String,
        label:String,
        placeholder:String,
        unique:Boolean,
        noSymbols:Boolean,
        noDigits:Boolean,
        noLetters:Boolean,
        required:Boolean,
        type:{type:String,required:true},
        initVal:String,
        phoneOrEmail:Boolean,
        userId:Number,
        sync:Boolean,
        syncurl:String
    },
    data() {
            return {
                value: this.initVal ? this.initVal : '',
                data:{
                    lat:'',
                    lng: '',
                    location: '',
                    search_str: '',
                    postal_code: '',
                    country:'',
                },
                error:null,
                erorrs:{},
                makeApiCall:false,
            }
        },
    methods:{
        getSearchedPlace:function(){

            var map = new google.maps.Map(document.getElementById('location'), {
                center: {lat: -33.8688, lng: 151.2195},
                zoom: 13
                });
                var input = document.getElementById(this.id);
                map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);

                var options = {
                    //types: ['(cities)'],
                    componentRestrictions: {country: ["ke","ug","tz","rw","cd","ss","bi"]}
                    };

                var autocomplete = new google.maps.places.Autocomplete(input,options);
                autocomplete.bindTo('bounds', map);

                var infowindow = new google.maps.InfoWindow();
                var marker = new google.maps.Marker({
                    map: map,
                    anchorPoint: new google.maps.Point(0, -29)
                });

                autocomplete.addListener('place_changed', () => {
                    infowindow.close();
                    marker.setVisible(false);
                    var place = autocomplete.getPlace();
                    if (!place.geometry) {
                        window.alert("Autocomplete's returned place contains no geometry");
                        return;
                    }
                    if (place.geometry.viewport) {
                        map.fitBounds(place.geometry.viewport);
                    } else {
                        map.setCenter(place.geometry.location);
                        map.setZoom(17);
                    }
                    marker.setIcon(({
                        url: place.icon,
                        size: new google.maps.Size(71, 71),
                        origin: new google.maps.Point(0, 0),
                        anchor: new google.maps.Point(17, 34),
                        scaledSize: new google.maps.Size(35, 35)
                    }));
                    marker.setPosition(place.geometry.location);
                    marker.setVisible(true);
                
                    var address = '';
                    if (place.address_components) {
                        address = [
                        (place.address_components[0] && place.address_components[0].short_name || ''),
                        (place.address_components[1] && place.address_components[1].short_name || ''),
                        (place.address_components[2] && place.address_components[2].short_name || '')
                        ].join(' ');
                    }
                
                    infowindow.setContent('<div><strong>' + place.name + '</strong><br>' + address);
                    infowindow.open(map, marker);
                
                    // Location details
                    for (var i = 0; i < place.address_components.length; i++) {
                        if(place.address_components[i].types[0] == 'postal_code'){
                            this.data.postal_code = place.address_components[i].long_name;
                        }
                        if(place.address_components[i].types[0] == 'country'){
                            this.data.country = place.address_components[i].long_name;
                        }
                    }
                    this.data.location = place.formatted_address;
                    this.data.lat = place.geometry.location.lat();
                    this.data.lng = place.geometry.location.lng();
                    this.data.search_str = this.value

                    this.makeApiCall = true
                    if( this.sync && this.syncurl){
                        this.syncToServer(this.name,this.data.location);
                        this.syncToServer('postal_code_by_google',this.data.postal_code);
                        this.syncToServer('country',this.data.country);
                        this.syncToServer('lat',this.data.lat);
                        this.syncToServer('lng',this.data.lng);
                    }


                    this.save();
                });

          
        },

         searchedPlaceCallback:function(results, status){
          if(results[0]){
            this.data.lat =  results[0].geometry.location.lat();
            this.data.lng = results[0].geometry.location.lng();
            this.data.physical_address = results[0].name;

         }
       },

        save(){
            this.emit()
        },
        change(){
        this.emit('changed')
        
      },
        emit(emit='save'){
        let response = {
          value:this.data,
          error:this.error,
          name:this.name,
          sync: emit == 'changed' ? true : false
        };

        if( emit !== 'save' )
          this.$emit(emit,response)
        
        this.$emit('save',response)

        this.makeApiCall = false

      },
      loading(val = false){
        let response = {
          value:val,
          name:this.name,
        };

        this.$emit('loading',response)
      },
        syncToServer(name,value,type){
       // if( ! this.value ) return;
       if( ! this.makeApiCall ) return;
        this.loading(true)
            axios({
                method: 'patch',
                url: this.syncurl,
                data: {
                    field:name,
                    value:value,
                    type:type,
                }
                }).then((response) => {
                    //console.log(response.data)
                    this.loading(false)
                })
                .catch( (error) => {
                console.log(error.response);
            });
        }
        
       
    },
    components:{BreezeInput,BreezeLabel},
    mounted(){
        this.getSearchedPlace()
    }
   
}
</script>

<style scoped>
.panel {
  height: 100%;
  display: flex;
  /*justify-content: center;
  align-items: center;*/
}

.material-textfield {
  position: relative;
  width: 100%;
}

label {
  position: absolute;
  font-size: 1rem;
  left: 0;
  top: 50%;
  transform: translateY(-50%);
  background-color: var(--white);
  color: var(--dark);
  padding: 0 0.3rem;
  margin: 0 0.5rem;
  transition: 0.1s ease-out;
  transform-origin: left top;
  pointer-events: none;
}

input {
  font-size: 1rem;
  outline: none;
  border: 1px solid var(--grey);
  border-radius: 5px;
  padding: 1rem 0.7rem;
  color: var(--dark);
  transition: 0.1s ease-out;
}

input:focus {
  border-color: var(--theme-color);
}
.form-control:focus {
  border-color: var(--theme-color);
  box-shadow: inset 0 1px 1px var(--light), 0 0 1px var(--theme-color);
}
input:focus+label {
  color: var(--theme-color);
  top: 0;
  transform: translateY(-50%) scale(0.9) !important;
}

input:not(:placeholder-shown)+label {
  top: 0;
  transform: translateY(-50%) scale(0.9) !important;
}

input:not(:focus)::placeholder {
  opacity: 0;
}
</style>