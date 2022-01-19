<template>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-xl mt-3">
            <h1><strong>Product Lists</strong></h1>
            <div class="card mt-3">
                <div class="card-header" style="position:relative;">

                    <div class="row mt-2">
                        <div class="col-lg-3 col-4">
                            <div class="form-inline">
                                    <input type="text" v-model="search" class="form-control" placeholder="Search...">
                            </div>
                        </div>
                        <div class="col-lg-3 col-7">
                            <label for="category_id" style="display: inline-block">
                                <span style="display: block">Category:</span>
                            </label>
                            <label for="">
                                <select v-model="category_search" 
                                    name="category_id" id="category_id" 
                                    class="form-control" style="display: block"
                                    @change="onChange($event)">
                                        <option value="">Select Category</option>
                                        <option v-for="item in categories" :key="item.id" :value="item.id">
                                            {{item.category_name}}
                                        </option>
                                        <option value="create new category">Others</option>
                                </select></label>
                        </div>
                         <div class="col-lg-6">
                            <router-link :to="'/import'" class="btn btn-secondary btn-md" style="float:right;"><strong>Import Product From File</strong></router-link>
                            <router-link :to="'/addNewItem'" class="btn btn-primary btn-md mr-3" style="float:right;"><strong>Add New Product</strong></router-link>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <!-- item list -->
                    <div class="row mt-2">
                        <div class="col-lg-3" v-for="item in filteredItems" :key="item.id">
                            <div class="card">
                                <img class="card-img-top" :src="item.item_image" alt="Card image cap">
                                <div class="card-body">
                                    <h6 class="card-title"><router-link :to="'/item_details/'+item.id" class="link-primary"><strong>{{item.item_name+" "}}</strong></router-link><a @click="deleteData(item.id)"><i class="fas fa-trash-alt red"></i></a></h6>
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
                items : [],
                unitTypes: {},
                deletes :{},
                search : '',
                category_search: '',
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
                this.modal = false;
                this.form.reset();
                window.$("#addItemForm").modal("show");
            },
            showModalImport(){
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
        },
        computed:{
            filteredItems: function (){
                let filterSearch= this.search;
                let filterCat = this.category_search;
                return this.items.filter((item)=>{
                        let filtered = true;
                        if(filterSearch && filterSearch.length > 0){
                                filtered = item.item_name.match(filterSearch)
                            }
                        if(filtered){
                            if(filterCat != ""){
                                filtered = item.item_category_id == filterCat
                            }
                        }
                    return filtered
                })
            },
        }
    }
</script>
