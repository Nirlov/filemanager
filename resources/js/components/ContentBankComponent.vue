<template>
    <div id="page-content-wrapper">
        <div class="container-fluid">
        	<div class="row">
        		<div class="col-md-12 directory-section">
        			<div class="col-md-4">
        				<div class="treeview-animated w-20 border mx-4">
						  	<h6 class="pt-3 pl-3">Directory</h6>
						  	<hr>
						  	<ul class="treeview-animated-list mb-3" v-if="lists.length>0 && !store_directory">
						    	<li class="treeview-animated-items" v-for="(all,index) in lists" :class="{ active:(all.id==directory_id) }">
						      		<a class="closed" v-if="edit_directory_id!=all.id" @click="getContentBank(all.id)">
						        		<i class="fas fa-angle-right"></i>
						        		<span><i class="far fa-folder-open ic-w mx-1"></i>{{ all.title }}<span class="action-btn"><i class="far fa-edit" @click.stop="editDirectory(index)"></i><i class="fas fa-times" @click.stop="deleteDirectory(all.id)"></i></span></span>
						      		</a>

						      		<div v-if="edit_directory && edit_directory_id==all.id" class="input-section input-edit-section">
								  		<input type="text" placeholder="Enter directory name" v-model="all.title">
								  		<span class="correct">
								  			<i class="fas fa-check" @click="editDirectoryData(index)"></i>
								  		</span>
								  		<span class="times" @click="closeEditDirectory">
								  			<i class="fas fa-times"></i>
								  		</span>
								  	</div>
						    	</li>
						    	
						  	</ul>
						  	<span class="empty" v-else-if="lists.length==0 && !store_directory">
						  		<i class="fas fa-box-open"></i>
						  	</span>
						  	<span class="add-new" @click="addDirectory" v-if="!store_directory">
						  		Add new
						  	</span>
						  	<div v-if="store_directory" class="input-section">
						  		<input type="text" placeholder="Enter directory name" v-model="directory">
						  		<span class="correct">
						  			<i class="fas fa-check" @click="storeDirectory"></i>
						  		</span>
						  		<span class="times" @click="closeDirectory">
						  			<i class="fas fa-times"></i>
						  		</span>
						  	</div>
						  	<div class="lds-ellipsis" v-if="is_loading"><div></div><div></div><div></div><div></div></div>
						  	
						</div>
        			</div>
        			<div class="col-md-8">
        				<div class="card">
        					<div class="card-header">
							    <div class="header-section">
							    	<div class="row">
							    		<div class="col-md-3">
							    			<span class="order-by" v-if="content_bank.total>0 && order_by=='desc'" @click="orderBy('asc')">
							    				<i class="fas fa-sort-amount-down"></i>
							    			</span>
							    			<span class="order-by" v-if="content_bank.total>0 && order_by=='asc'" @click="orderBy('desc')">
							    				<i class="fas fa-sort-amount-up"></i>
							    			</span>

							    			<span class="order-by" v-if="content_bank.total>0" @click="refreshData">
							    				<i class="fas fa-sync"></i>
							    			</span>
							    		</div>
							    		<div class="col-md-6 header-search-button">
							    			<form @submit.prevent="searchData">
								    			<input type="text" placeholder="Search...." v-model="keyword">
								    		</form>
							    		</div>
							    		<div class="col-md-3 header-add-button">
							    			<span data-toggle="modal" data-target="#myModal" data-backdrop="static" data-keyboard="false" v-if="directory_id != ''">Add content</span>
							    		</div>
							    	</div>
							    </div>
							</div>
							<div class="card-body">
								<div class="row" v-if="content_bank.total>0">
									<div class="col-md-4" v-for="(all,index) in content_bank.data" :key="index">
										<div class="card">
										  	<img class="card-img-top" :src="'/uploads/files/'+all.file_name" :alt="all.title" v-if="all.content_type == 'image'">
										  	<div class="material" v-else>
										  		<i class="fas fa-file-alt"></i>
										  	</div>
										  	<div class="card-body">
										    	<p class="card-text">{{ all.title }}</p>
										  	</div>
										</div>
									</div>
								</div>
								<div class="row" v-else>
									<div class="col-md-12 text-center">
										<span><i class="fas fa-box-open" style="font-size: 100px;"></i></span>
									</div>
								</div>

								<div class="row" style="background: #d4d4d473" v-if="content_loading">
									<div class="lds-ellipsis" style="left: 44%;"><div></div><div></div><div></div><div></div></div>
								</div>

								<div class="row col-md-12 mt-3">
						      		<pagination :data="content_bank" @pagination-change-page="getContentBankPaginate" v-if="pagination"></pagination>
							    </div>
							</div>
						</div>
        			</div>
        		</div>

        		
        	</div>
        </div>
        <Add></Add>
    </div>
</template>

<script>
	import Add from './FileuploadComponent.vue';
    export default {
    	name : 'ContentBankComponent',
		props : [],
		components:{Add},
		data(){
			return{
				lists: [],
				content_bank: [],
				directory: '',
				is_loading : false,
				content_loading : false,
				store_directory : false,
				edit_directory : false,
				edit_directory_id : '',
				pagination : false,
				directory_id : '',
				keyword : '',
				order_by : 'asc'
			}
		},
        mounted() {
            this.getData();
        },
        methods:{
        	searchData(){
        		this.getContentBankPaginate();
        	},
        	orderBy(order_by){
        		this.order_by = order_by;
        		this.getContentBankPaginate();
        	},
        	refreshData(){
        		this.order_by = 'asc';
        		this.keyword = '';
        		this.getContentBankPaginate();
        	},
        	getData(){
				axios.get('filemanager/directory-list')
	            .then((response) => {
	                this.lists = response.data;
	                this.is_loading = false;
	            })
			},
			getContentBank(directory_id){
				this.directory_id = directory_id;
				this.getContentBankPaginate();
			},
			getContentBankPaginate(page = 1){
				this.content_loading = true;
				var keyword = this.keyword;
				var order_by = this.order_by;
				axios.get('filemanager/content-list/'+this.directory_id+'?page='+page + (keyword!=''?`&keyword=` + keyword :``) + (order_by!=''?`&order_by=` + order_by :``))
	            .then((response) => {
	                this.content_bank = response.data;
	                this.pagination = true;
	                this.content_loading = false;
	            })
			},
			addDirectory(){
				this.store_directory = true;
			},
			closeDirectory(){
				this.store_directory = false;
			},
			editDirectory(index){
				this.edit_directory = true;
				this.edit_directory_id = this.lists[index].id;
			},
			closeEditDirectory(){
				this.edit_directory = false;
				this.edit_directory_id = '';
			},
			storeDirectory(){
				this.is_loading = true;
				let formData = new FormData();

				formData.append('title',this.directory);

				axios.post('filemanager/directory-store',formData,
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
                	this.getData();
					this.directory = '';
					this.store_directory = false;
                })
			},
			editDirectoryData(index){
				this.is_loading = true;
				let formData = new FormData();

				formData.append('title',this.lists[index].title);

				axios.post('filemanager/directory-edit/'+this.lists[index].id,formData,
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
                	this.edit_directory = false;
					this.edit_directory_id = '';
                })
			},
			deleteDirectory(directory_id){

				swal.fire({
				  	title: 'Are you sure?',
				  	text: "You won't be able to revert this!",
					icon: 'warning',
					showCancelButton: true,
					confirmButtonColor: '#3085d6',
					cancelButtonColor: '#d33',
					confirmButtonText: 'Yes, delete it!'
				}).then((result) => {
				  	if (result.isConfirmed) {
						this.is_loading = true;

						axios.post('filemanager/directory-destroy/'+directory_id,
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
		                	this.getData();
							
		                }).catch((error)=>{
		                	this.is_loading = false;
		                	toast.fire({
							  	icon: 'error',
							  	title: 'Something Wrong'
							});
		                })
            		}
            	})
			}
        }
    }
</script>

<style scoped>
	div.treeview-animated{
		position: relative;	
	}
	span.add-new{
		position: absolute;
	    right: 0px;
	    bottom: 0px;
	    padding: 2px 20px;
	    background: #047c97;
	    color: #fff;
	    border-radius: 25px 0px 0px 0px;
	    cursor: pointer;
	    font-size: 10px;
	    font-weight: 600;
	}
	span.empty{
		display: block;
    	text-align: center;
	}
	span.empty > i{
		font-size: 50px;
	    color: #9d9d9d;
	    padding-bottom: 15px;
	}
	div.input-section{
		position: relative;
	    left: 10px;
	    bottom: 10px;
	}
	div.input-section > input{
		border: none;
		width: 200px;
	}
	div.input-section > input:focus{
		outline: none !important;
	    border-color: #719ECE;
	    box-shadow: 0 0 10px #719ECE;
	}
	div.input-section > span > i{
		padding: 0px 5px;
		cursor: pointer;
	}
	div.input-section > span.correct > i{
		color: green;
	}
	div.input-section > span.times > i{
		color: red;
	}
	li.treeview-animated-items{
		position: relative;
	}
	li.treeview-animated-items span.action-btn{
		position: absolute;
		left: 200px;
		top: 0px;
	}
	li.treeview-animated-items i.fa-edit{
		visibility:hidden;
		color: green;
		padding: 0px 10px;
	}
	li.treeview-animated-items:hover i.fa-edit{
		visibility: visible;
	}
	li.treeview-animated-items i.fa-times{
		visibility:hidden;
		color: red;
	}
	li.treeview-animated-items:hover i.fa-times{
		visibility: visible;
	}
	div.input-edit-section{
		bottom: 0px !important;
	}
	div.directory-section{
		display: flex !important;
	}
	div.header-add-button > span{
		padding: 5px 25px;
	    background: #047c97;
	    color: #ffffff;
	    font-weight: 600;
	    cursor: pointer;
	}
	div.header-search-button > form > input{
		width: 80%;
	}
	span.order-by{
		cursor: pointer;
	}
	div.material{
		text-align: center;
	    padding: 40px;
	    border-bottom: 1px solid #dddcdc;
	}
	div.material > i{
		font-size: 90px;
	}
	img.card-img-top{
		height: 170px;
    	object-fit: cover;
	}
</style>
