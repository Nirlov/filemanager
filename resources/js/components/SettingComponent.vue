<template>
    <div id="page-content-wrapper">
        <div class="container-fluid">
            <h1 class="mt-4">Filemanager Configuration</h1>
            <hr>
            <form class="form-horizontal">
			    <div class="form-group row col-md-12">
			      	<label class="control-label col-sm-2 col-md-2" for="email">File Size:</label>
			      	<div class="col-sm-4 col-md-4">
			        	<input type="number" class="form-control" placeholder="Enter file size in MB" v-model="file_size">
			      	</div>
			    </div>
			    <div class="form-group row col-md-12">
			      	<label class="control-label col-sm-2" for="pwd">Allow Extensions:</label>
			      	<div class="col-sm-10 extenstion-section">          
			        	<div class="checkbox">
			          		<label><input type="checkbox" v-model="file_extension.jpg"> JPG</label>
			        	</div>
			        	<div class="checkbox">
			          		<label><input type="checkbox" v-model="file_extension.jpeg"> JPEG</label>
			        	</div>
			        	<div class="checkbox">
			          		<label><input type="checkbox" v-model="file_extension.png"> PNG</label>
			        	</div>
			        	<div class="checkbox">
			          		<label><input type="checkbox" v-model="file_extension.gif"> GIF</label>
			        	</div>

			     		<div class="checkbox">
			          		<label><input type="checkbox" v-model="file_extension.mp3"> MP3</label>
			        	</div>
			        	<div class="checkbox">
			          		<label><input type="checkbox" v-model="file_extension.wav"> WAV</label>
			        	</div>
			        	<div class="checkbox">
			          		<label><input type="checkbox" v-model="file_extension.wma"> WMA</label>
			        	</div>

			        	<div class="checkbox">
			          		<label><input type="checkbox" v-model="file_extension.mp4"> MP4</label>
			        	</div>
			        	<div class="checkbox">
			          		<label><input type="checkbox" v-model="file_extension.gp3"> 3GP</label>
			        	</div>
			        	<div class="checkbox">
			          		<label><input type="checkbox" v-model="file_extension.avi"> AVI</label>
			        	</div>

			        	<div class="checkbox">
			          		<label><input type="checkbox" v-model="file_extension.doc"> DOC</label>
			        	</div>
			        	<div class="checkbox">
			          		<label><input type="checkbox" v-model="file_extension.pptx"> PPTX</label>
			        	</div>
			        	<div class="checkbox">
			          		<label><input type="checkbox" v-model="file_extension.pdf"> PDF</label>
			        	</div>
			      	</div>
			    </div>
			    
			    <div class="form-group">        
			      	<div class="col-sm-offset-2 col-sm-10">
			        	<span class="btn btn-primary btn-block" @click="storeSetting">Submit</span>
			      	</div>
			    </div>
			  </form>
        </div>
    </div>
</template>

<script>
    export default {
    	name:'SettingComponent',
    	props:['data'],
    	data(){
    		return{
    			is_loading: false,
    			list: [],
    			file_size: '',
    			file_extension: {
    				jpg : true,
    				jpeg : true,
    				png : true,
    				gif : true,
    				mp3 : true,
    				wav : true,
    				wma : true,
    				mp4 : true,
    				gp3 : true,
    				avi : true,
    				doc : true,
    				pptx : true,
    				pdf : true
    			}
    		}
    	},
        mounted() {
            if(this.data != ''){
            	this.list = JSON.parse(this.data);
            	this.file_size = this.list.file_size;
            	this.file_extension = JSON.parse(this.list.file_extension);
            }
        },
        methods:{
        	storeSetting(){
				this.is_loading = true;
				let formData = new FormData();

				formData.append('file_size',this.file_size);
				formData.append('file_extension',JSON.stringify(this.file_extension));

				axios.post('/filemanager/setting-configuration',formData,
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
                }).catch((error)=>{
                	this.is_loading = false;
                	toast.fire({
					  	icon: 'error',
					  	title: 'Something Wrong'
					});
                });
			},
        }
    }
</script>

<style scoped>
div.extenstion-section{
	display: flex;
}
div.extenstion-section > div.checkbox{
	margin-right: 10px;
}
</style>
