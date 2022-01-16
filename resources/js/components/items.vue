<template>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-xl mt-5">
            <h1><strong>Product Lists</strong></h1>
            <div class="card mt-3">
                <div class="card-header" style="position:relative;">

                    <div class="row mt-2">
                        <div class="col-lg-3 col-6">
                            <div class="form-inline">
                                    <input type="search" id="form1" class="form-control" placeholder="Search...">
                                    <button type="button" class="btn btn-primary"><i class="fas fa-search"></i></button>
                            </div>
                        </div>
                        <div class="col-lg-3 col-6">
                            <select v-model="form.item_category_id" 
                                    name="category_id" id="category_id" 
                                    class="form-control input-lg dynamic" 
                                    style="width:inherit;"
                                    @change="onChange($event)">
                                        <option value="">Select Category</option>
                                        <option v-for="item in categories" :key="item.id" :value="item.id">
                                            {{item.category_name}}
                                        </option>
                                        <option value="create new category">Others</option>
                                </select>
                        </div>
                        <div class="card-tools">
                            <button  class="btn btn-secondary btn-sm" @click="showModalAdd" id="add_item">Add New Product</button>
                            <!-- <button  class="btn btn-primary btn-sm" @click="showModalImport" id="swal_upload">Import Product From File</button> -->
                            <router-link :to="'/import'" class="btn btn-primary btn-sm"><strong>Import Product From File</strong></router-link>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <!-- item list -->
                    <div class="row mt-2" v-for="i in Math.ceil(items.length / 4)" :key="i">
                        <div class="col-lg-3" v-for="item in items.slice((i - 1) * 4, i * 4)" :key="item.id">
                            <div class="card h-100 ">
                                <img class="card-img-top" :src="item.item_image" alt="Card image cap">
                                <div class="card-body">
                                    <h6 class="card-title"><router-link :to="'/item_details/'+item.id" class="link-primary"><strong>{{item.item_name}}</strong></router-link></h6>
                                    <p class="card-text">{{item.item_desc}}</p>
                                    <h5><strong>Rp. {{(item.item_sell_price).toLocaleString('en')
                                                        +'/'+items.find((a) => {
                                                        return a.id === item.id
                                                    }).unit_type.unit_type_name}}</strong></h5>
                                    <p id="stock">{{item.item_qty==0 ? ('Stok Habis') : 'Stock Tersisa: '
                                            +item.item_qty+' '+items.find((a) => {
                                                return a.id === item.id
                                            }).unit_type.unit_type_name}}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<!-- MODAL IMPORT -->
    <div class="modal" id="importItemForm" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content" >
                <div class="modal-header text-center">
                    <h4 class="modal-title" id="exampleModalLongTitle">Import New Item</h4>
                    <button type="button" class="close" data-dismiss="modal" @click="fileUploadDismiss()" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
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
    </div>
<!-- MODAL IMPORT -->
<!-- MODAL ADD -->
    <div class="modal" id="addItemForm" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content" >
                <div class="modal-header text-center">
                    <h4 class="modal-title" id="exampleModalLongTitle" v-show="!modal">New Item</h4>
                    <h4 class="modal-title" id="exampleModalLongTitle" v-show="modal">Edit Item</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form @submit.prevent="modal ? editData() : postData()">
                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">Item Name</label>
                            <div class="col-md-6">
                                <input
                                    class="form-control"
                                    id="item_name" 
                                    type="text" 
                                    v-model="form.item_name"
                                    name="item_name" 
                                    required
                                    placeholder="Item Name">
                                    <has-error :form="form" field="item_name"></has-error> 
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="item_desc" class="col-md-4 col-form-label text-md-right">Item Description</label>

                            <div class="col-md-6">
                                <textarea v-model="form.item_desc"
                                    id="item_desc" 
                                    rows="4" 
                                    cols="50" 
                                    class="form-control" 
                                    name="item_desc" 
                                    required
                                    placeholder="Item Description">
                                    
                                </textarea>
                                <has-error :form="form" field="item_desc"></has-error> 
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="item_desc" class="col-md-4 col-form-label text-md-right">Item Category</label>

                            <div class="col-md-6">
                                <select v-model="form.item_category_id" 
                                    name="category_id" id="category_id" 
                                    class="form-control input-lg dynamic" 
                                    style="width:inherit;"
                                    @change="onChange($event)">
                                        <option value="">Select Category</option>
                                        <option v-for="item in categories" :key="item.id" :value="item.id">
                                            {{item.category_name}}
                                        </option>
                                        <option value="create new category">Others</option>
                                </select>
                                <input
                                    class="form-control"
                                    id="category_id_others" 
                                    type="text" 
                                    v-model="form.item_category_id"
                                    name="item_category_id" 
                                    placeholder="create new category" style="display:none;">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="qty" class="col-md-4 col-form-label text-md-right">Item Quantity</label>

                            <div class="col-md-6">
                                <input v-model="form.item_qty" 
                                    id="item_qty" 
                                    type="number" 
                                    class="form-control"
                                    name="item_qty"
                                    required  
                                    placeholder="1">
                                <has-error :form="form" field="item_qty"></has-error>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="item_unit_type" class="col-md-4 col-form-label text-md-right">Unit Type</label>

                            <div class="col-md-6">
                                <select v-model="form.unit_type_id" 
                                    name="unit_type_id" id="unit_type_id" 
                                    class="form-control input-lg dynamic" 
                                    style="width:inherit;"
                                    @change="onChange($event)">
                                        <option value="">Select Unit Type</option>
                                        <option v-for="item in unitTypes" :key="item.id" :value="item.id">
                                            {{item.unit_type_name}}
                                        </option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="buy" class="col-md-4 col-form-label text-md-right">Item Buy Price</label>

                            <div class="col-md-6">
                                <input v-model="form.item_buy_price" 
                                    id="item_buy" 
                                    type="number" 
                                    class="form-control" 
                                    name="item_buy_price" 
                                    required
                                    placeholder="0">
                                <has-error :form="form" field="item_buy_price"></has-error>
                            </div>
                        </div>


                        <div class="form-group row">
                            <label for="sell" class="col-md-4 col-form-label text-md-right">Item Sell Price</label>

                            <div class="col-md-6">
                                <input v-model="form.item_sell_price" 
                                    id="item_sell" 
                                    type="number" 
                                    class="form-control"
                                    name="item_sell_price" 
                                    required
                                    placeholder="0">
                                <has-error :form="form" field="item_sell_price"></has-error>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary btn-block" :disabled="disabled">
                                    <i v-show="loading" class="fa fa-spinner fa-spin"></i>
                                        Submit
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
<!-- MODAL ADD -->
</div>
</template>

<script type="text/javascript" src="//code.jquery.com/jquery-1.11.3.min.js"></script>
<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>

<!-- jQuery Modal -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.js"></script>

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
                    $('#importItemForm').modal('hide');
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
                });
            },
            handleFileUpload(event){
                this.file = event.target.files[0];
                document.getElementById("customFile").innerHTML=event.target.files[0].name;
            },
            fileUploadDismiss(){
                document.getElementById("customFile").innerHTML="Choose File";
            },
            onChange(event){
                if(event.target.value=="create new category"){
                    document.getElementById("category_id_others").style.display="block";
                }else{
                    document.getElementById("category_id_others").style.display="none";
                }
            },
            showModalAdd(){
                console.log("showAddModal");
                this.modal = false;
                this.form.reset();
                console.log($("#addItemForm"));
                window.$("#addItemForm").modal("show");
            },
            showModalImport(){
                console.log("showImportModal");
                console.log($("#importItemForm"));
                window.$("#importItemForm").modal("show");
            },
            showModalEdit(a){
                this.modal = true;
                this.form.reset();
                window.$("#addItemForm").modal("show");
                this.form.fill(a);
            },
            async loadData(){
                //untuk panggil progress bar
                this.$Progress.start();

                // untuk call route yang ada di api.php>> bisa call controller untuk get data dari database
                await axios
                    .get('api/get_category')
                    .then(({data}) => (this.categories = data));
                await axios
                    .get('api/getItem/'+this.userInfo.id)
                    .then(({data}) => (this.items = data));
                 console.log(this.items);
                await axios
                    .get('api/getUnitType')
                    .then(({data}) => (this.unitTypes = data));

                //untuk mengakhiri progress bar setelah halaman muncul
                this.$Progress.finish();
            },
            postData(){
                this.$Progress.start();
                this.loading = true;
                this.disabled = true;

                this.form
                    .post('api/add_item/'+this.userInfo.id)
                    .then(()=>{
                    Fire.$emit("refreshData");
                    $('#addItemForm').modal('hide');
                    Toast.fire({
                        icon: 'success',
                        title: 'Item Saved successfully'
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
                });
            },
            editData(){
                this.$Progress.start();
                this.loading = true;
                this.disabled = true;

                this.form
                    .post('api/edit_item/'+this.form.id)
                    .then(()=>{
                    Fire.$emit("refreshData");
                    $('#addItemForm').modal('hide');
                    Toast.fire({
                        icon: 'success',
                        title: 'Item Edited successfully'
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
                });
            },
            deleteData(id){
                Swal.fire({
                title: "Do you wanto to delete this item ?",
                text: "Click cancel button to cancel the delete process",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Delete Item"
            }).then(result => {
                if (result.value) {
                    this.form
                        .post("api/delete_item/" + id)
                        .then(() => {
                            Swal.fire(
                                "Deleted",
                                "Your Item has deleted Successfully",
                                "success"
                            );
                            Fire.$emit("refreshData");
                        })
                        .catch(() => {
                            Swal.fire(
                                "Failed",
                                "Delete Item Failed",
                                "warning"
                            );
                        });
                }
            });
            }
        },
        created(){
            this.loadData();
            Fire.$on('refreshData',() => {
                this.loadData();
            })
        }
    }
</script>
