<template>
    <!-- Modal -->
    <div class="modal fade" id="myModal" role="dialog">
        <div class="modal-dialog">
        
          <!-- Modal content-->
            <div class="modal-content">
                
                <div class="modal-body">
                    <div class="image_upload logo_upload" @click="$refs.logoFile.click()">
                        
                        <i class="fa fa-cloud-upload-alt"></i>
                        <p>{{ file_name }}</p>
                        <p class="form-text text-danger font-weight-bold" v-if="errors.thumbnail">{{ errors.thumbnail[0] }}</p>
                        <input  type="file" ref="logoFile" class="file-input" style="display: none" @change="logoChange">
                    </div>
                    <div class="lds-ellipsis" v-if="is_loading"><div></div><div></div><div></div><div></div></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" @click="save">Save</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name : 'FileuploadComponent',
        props : [],
        components:{},
        data(){
            return{
                thumbnail:'',
                file_name: '',
                is_loading: false,
                errors:{}
            }
        },
        methods:{
            logoChange(e){
                var files = e.target.files;
                this.tumbnailUpload(files[0]);
            },
            tumbnailUpload(file){
                this.file_name = file.name;
                this.thumbnail = file;
            },
            save(){
                this.is_loading = true;
                let formData = new FormData();

                formData.append('thumbnail',this.thumbnail);
                formData.append('directory_id',this.$parent.directory_id);

                axios.post('filemanager/content-store',formData,
                    {
                        headers: {
                            'Content-Type': 'multipart/form-data'
                        }
                    }
                ).then((response)=>{

                    toast.fire({
                        icon: 'success',
                        title: response.data.message
                    });

                    this.is_loading = false;
                    this.file_name = '';
                    this.thumbnail = '';
                    this.$parent.getContentBankPaginate();
                }).catch((error)=>{
                    this.errors = error.response.data.errors;
                    this.is_loading = false;
                })
            },
        }
    }
</script>

<style scoped>
.image_upload{
    width: 100%;
    height: 115px;
    border: 1px solid;
    background: #eceef0;
    text-align: center;
    cursor: pointer;
    position: relative;
}
.image_upload p{
    font-size: 12px;
}
.image_upload i{
    font-size: 34px;
    margin-top: 25px;
}
</style>
