<template>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-xl">
            <div class="card mt-5">
                <div class="card-header" style="position:relative;"><strong>Items</strong>
                    <button style="position: absolute; right: 10px; bottom:8px;" @click="showModalAdd()" type="button" id="add_item" class="btn btn-secondary btn-sm">+</button>
                </div>
                <div class="card-body">
                        <!-- item list -->
                        <table class="table table-striped">
                            <thead>
                                <th>Item Name</th>
                                <th>Item Description</th>
                                <th>Item Quantity</th>
                                <th>Item Unit Type</th>
                                <th>Item Buy Price</th>
                                <th>Item Sell Price</th>
                                <th>Action</th>
                            </thead>
                            <tbody>
                                <tr v-for="a in items" :key="a.id" :value="a.id">
                                    <td>{{a.item_name}}</td>
                                    <td>{{a.item_desc}}</td>
                                    <td>{{a.item_qty}}</td>
                                    <div v-for="unit in unitTypes" :key="unit.id" :value="unit.id">
                                       <td v-if="a.unit_type_id === unit.id">{{unit.unit_type_name}}</td>
                                    </div>
                                    <td>Rp {{a.item_buy_price}}</td>
                                    <td>Rp {{a.item_sell_price}}</td>
                                    <td>
                                            <a
                                                href="#"
                                                @click="showModalEdit(a)"
                                                ><i class="fas fa-edit blue"></i
                                            ></a>
                                            | <a
                                                href="#"
                                                @click="deleteData(a.id)"
                                                ><i
                                                    class="fas fa-trash-alt red"
                                                ></i
                                            ></a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <!-- Pop Up Add Item-->
                        <div class="modal fade" id="addItemForm" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
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
                                                        :class="{ 
                                                            'is-invalid' : form.errors.has(item_category_id) 
                                                            }" 
                                                        name="item_category_id" 
                                                        placeholder="create new category" style="display:none;">
                                                    <has-error :form="form" field="item_category_id"></has-error>
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
                                                            <!-- <option value="create new category">Others</option> -->
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
                </div>
            </div>
        </div>
    </div>
</div>

</template>

<script>
    export default {
        props: ['userInfo'],
        data(){
            return{
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
                $("#addItemForm").modal("show");
            },
            showModalEdit(a){
                this.modal = true;
                this.form.reset();
                $("#addItemForm").modal("show");
                this.form.fill(a);
            },
            loadData(){
                //untuk panggil progress bar
                this.$Progress.start();

                // untuk call route yang ada di api.php>> bisa call controller untuk get data dari database
                axios
                    .get('api/get_category')
                    .then(({data}) => (this.categories = data));
                axios
                    .get('api/getItem')
                    .then(({data}) => (this.items = data));
                axios
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
