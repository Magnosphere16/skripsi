<template>
<!-- body structure -->
    <div class="container">
            <header class="page-header page-header-dark bg-gradient-primary-to-secondary pb-10">
                        <div class="container-xl px-4">
                            <div class="page-header-content pt-4">
                                <div class="row align-items-center justify-content-between">
                                    <div class="col-auto mt-4">
                                        <h1 class="page-header-title">
                                            <div class="page-header-icon"><i data-feather="edit-3"></i></div>
                                            Import New Item
                                        </h1>
                                        <div class="page-header-subtitle">Add Multiple Products data by uploading Excel data. To Help you with the data adjustment, we provided the template excel file for you to download.</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </header>
           <div class="card mt-3">
            <div class="card-body">
                    <div>
                        <p>You may Download the template by click the button below:</p>
                        <button class="btn btn-success" @click="downloadTemplate()">Download Template</button>
                    </div>
                    <hr>
                    <div class="input-group mb-3">
                        <div class="custom-file">
                                <input type="file" @change="handleFileUpload($event)" class="custom-file-input">
                            <label class="custom-file-label" for="customFile" id="customFile">Choose File</label>
                        </div>
                    </div>
                    <div>
                            <router-link :to="'/items'" class="btn btn-secondary btn-md" style="float:right">Cancel</router-link>
                            <button v-on:click="importData()" class="btn btn-primary btn-md mr-3" style="float:right" >
                            <i v-show="loading" class="fa fa-spinner fa-spin"></i>
                                Submit
                            </button>
                    </div>
                </div>
            </div>
    </div>
</template>

<script src="http://code.jquery.com/jquery-3.4.1.js"></script>
<script>

</script>

<script>
    export default {
        props: ['userInfo'],
        data(){
            return{
                file: '',
                loading: false,
                disabled: false,
                modal: false,
                categories : {},
                items : {},
                unitTypes: {},
                deletes :{},
                form: new Form({    
                    id:"",
                    item_name:"",
                    item_desc:"",
                    item_qty:"",
                    item_category_id:"",
                    unit_type_id:"",
                    item_buy_price:"",
                    item_sell_price:"",
                }),
            }
        },
        methods:{
            downloadTemplate(){
                axios({
                    url:"/files/template.xlsx",
                    method:'GET',
                    responseType:'blob'
                }).then((response) => {
                    var fileUrl = window.URL.createObjectURL(new Blob([response.data]));
                    var fileLink = document.createElement('a');
                    fileLink.href = fileUrl;

                    fileLink.setAttribute('download','template.xlsx');
                    document.body.appendChild(fileLink);

                    fileLink.click();
                })
            },
            importData(){
                this.$Progress.start();
                this.loading = true;
                this.disabled = true;

                let formData = new FormData();
                formData.append('file', this.file);
                axios.post('api/import_item/'+this.userInfo.id,
                    formData,
                    {
                        headers: {
                            'Content-Type': 'multipart/form-data'
                        }
                    }
                ).then(()=>{
                    Fire.$emit("refreshData");
                    Swal.fire(
                        'Success!',
                        'Item Imported Successfully!',
                        'success'
                        ).then(function() {
                        window.location = "/items";
                    });
                    this.$Progress.finish();
                    this.loading = false;
                    this.disabled = false;
                    })
                // else
                    .catch(()=>{
                        Swal.fire({
                        icon: 'error',
                        title: 'Import Failed',
                        text: "",
                        })
                        this.$Progress.fail();
                        this.loading = false;
                        this.disabled = false; 
                    });
            },
            handleFileUpload(event){
                this.file = event.target.files[0];
                document.getElementById("customFile").innerHTML=event.target.files[0].name;
            },
            fileUploadDismiss(){
                document.getElementById("customFile").innerHTML="Choose File";
            },
        },
        created(){

        }
    }
</script>
