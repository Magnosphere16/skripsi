<template>
<!-- body structure -->
    <div class="container">
           <div class="card mt-3">
            <div class="card-header text-center">
                <h4 class="card-title" id="exampleModalLongTitle">Import New Item</h4>
            </div>
            <div class="card-body">
                    <div>
                        <p>You may Download the template with the link below:</p>
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
                        <button v-on:click="importData()" class="btn btn-primary btn-block">
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
                    Toast.fire({
                        icon: 'success',
                        title: 'Item Imported successfully'
                        });
                    this.$Progress.finish();
                    
                    this.loading = false;
                    this.disabled = false;
                    })
                // else
                .catch(()=>{
                    this.$Progress.fail();
                    this.loading = false;
                    this.disabled = false; 
                    window.location.href="/home"
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
