<template>
  <input  type="file" :name="name" :id="id" :multiple="multiple" class="d-none" @change="process" >
</template>

<script>
export default {
    props:{
        name:{type:String,required:true},
        id:{type:String,required:true},
        activator:{type:String,required:true},
        resizeWidth:Number,
        multiple:Boolean,
        purpose:String,
        mediaableType:String,
        mediaableId:Number
    },
    data() {
            return {
                value: '',
                error:null,
                makeApiCall:false,
                resize_width_value: this.resizeWidth ? this.resizeWidth : 400,
            }
        },
    methods:{
            process:function(){

                let files = $('#'+this.id).prop('files');
                

                    let resize_width = this.resize_width_value;
                    let srcEncoded = null;

                    //create a FileReader
                    let reader = new FileReader();
                    //image turned to base64-encoded Data URI.
                    reader.readAsDataURL(files[0]);
                    //reader.name = file.name;//get the image's name
                    reader.size = files[0].size; //get the image's size
                    reader.onload = (event,srcEncoded) => {
                        let img = new Image();//create a image
                        img.src = event.target.result;//result is base64-encoded Data URI
                        //img.name = event.target.name;//set name (optional)
                        img.size = event.target.size;//set size (optional)
                        img.onload = (el,srcEncoded) => {
                            let elem = document.createElement('canvas');//create a canvas
                            //scale the image to 600 (width) and keep aspect ratio
                            let scaleFactor = resize_width / el.target.width;
                            elem.width = resize_width;
                            elem.height = el.target.height * scaleFactor;
                            //draw in canvas
                            let ctx = elem.getContext('2d');
                            ctx.drawImage(el.target, 0, 0, elem.width, elem.height);
                            //get the base64-encoded Data URI from the resize image
                            srcEncoded = ctx.canvas.toDataURL(el.target, 'image/png', 0);
                            var blob = this.DataURIToBlob(srcEncoded)

                            this.syncToServer( blob );
                        }
                    }


            },

            DataURIToBlob:function(dataURI) {
                const splitDataURI = dataURI.split(',')
                const byteString = splitDataURI[0].indexOf('base64') >= 0 ? atob(splitDataURI[1]) : decodeURI(splitDataURI[1])
                const mimeString = splitDataURI[0].split(':')[1].split(';')[0]
                const ia = new Uint8Array(byteString.length)
                for (let i = 0; i < byteString.length; i++)
                    ia[i] = byteString.charCodeAt(i)
                return new Blob([ia], { type: mimeString })
            },

            emit(emit='changed'){

                let response = {
                    value:this.value,
                    error:this.error,
                    name:this.name,
                    sync: emit == 'changed' ? true : false
                };

                this.$emit('changed',response)

                this.makeApiCall = false

            },

             syncToServer(blob){

                var fd = new FormData();
                fd.append('file', blob, this.name+'.png')
                fd.append('name',this.name)
                fd.append('mediaable_id',this.mediaableId)
                fd.append('mediaable_type',this.mediaableType)
                if( this.purpose )
                    fd.append('purpose',this.purpose)
                this.uploading = true

                axios({
                    method: 'post',
                    url:'/v1/media',
                    data: fd,
                    }).then( response => {
                        this.value = response.data 
                        this.emit()
                    })
                    .catch( error => {
                    console.log(error.response);
                });

            },


    },
    mounted(){
        $( "#"+this.activator ).click(() => {
            $("#"+this.id).click();
        });
    }

}
</script>

<style>

</style>