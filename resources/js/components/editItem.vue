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
                                            Edit Product
                                        </h1>
                                        <div class="page-header-subtitle">Edit selected products data by changing the information about the product with the form provided.</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </header>
                    
           <div class="card mt-3">
                <div class="card-body">
                    <form @submit.prevent="editData()">
                        <div class="row gx-3 mb-3">
                            <div class="col-md-6">
                                <label for="name">Item Name</label>
                                <input
                                    class="form-control"
                                    id="item_name" 
                                    type="text" 
                                    v-model="form.item_name"
                                    name="item_name" 
                                    required
                                    :placeholder="item_info.item_name">
                                    <has-error :form="form" field="item_name"></has-error> 
                            </div>
                            <div class="col-md-6">
                                <label for="item_desc">Item Category</label>
                                <select v-model="form.item_category_id" 
                                    name="category_id" id="category_id" 
                                    class="form-control input-lg dynamic" 
                                    style="width:inherit;"
                                    @change="onChangeCategory($event)">
                                        <option value="">Select Category</option>
                                        <option v-for="item in categories" :key="item.id" :value="item.id">
                                            {{item.category_name}}
                                        </option>
                                        <option value="new">Others</option>
                                </select>
                                <input
                                    class="form-control"
                                    id="category_id_others" 
                                    type="text" 
                                    v-model="form.item_category_id"
                                    name="item_category_id"
                                    value="" 
                                    placeholder="create new category..." style="display:none;">
                                    <has-error :form="form" field="item_desc"></has-error> 
                            </div>
                        </div>
                        <div class="row gx-3 mb-3">
                            <div class="col-md-6">
                                <label for="item_desc">Item Description</label>
                                    <textarea v-model="form.item_desc"
                                        id="item_desc" 
                                        rows="5" 
                                        cols="50" 
                                        class="form-control" 
                                        name="item_desc" 
                                        required
                                        placeholder="Item Description">
                                    </textarea>
                                    <has-error :form="form" field="item_desc"></has-error> 
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="qty">Item Quantity</label>
                                    <input v-model="form.item_qty" 
                                        id="item_qty" 
                                        type="number" 
                                        class="form-control"
                                        name="item_qty"
                                        required  
                                        placeholder="1">
                                    <has-error :form="form" field="item_qty"></has-error>
                                </div>
                                <div class="mb-3">
                                    <label for="item_unit_type">Unit Type</label>
                                    <select v-model="form.unit_type_id" 
                                        name="unit_type_id" id="unit_type_id" 
                                        class="form-control input-lg dynamic" 
                                        style="width:inherit;"
                                        >
                                            <option value="">Select Unit Type</option>
                                            <option v-for="item in unitTypes" :key="item.id" :value="item.id">
                                                {{item.unit_type_name}}
                                            </option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row gx-3 mb-3">
                            <div class="col-md-6">
                                <label for="buy">Item Buy Price</label>
                                <input v-model="form.item_buy_price" 
                                    id="item_buy" 
                                    type="number" 
                                    class="form-control" 
                                    name="item_buy_price" 
                                    required
                                    placeholder="0">
                                <has-error :form="form" field="item_buy_price"></has-error>
                            </div>
                            <div class="col-md-6">
                                 <label for="sell">Item Sell Price</label>
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
                        <div class="mb-3">
                            <router-link :to="'/items'" class="btn btn-secondary btn-md" style="float:right">Cancel</router-link>
                            <button type="submit" class="btn btn-primary btn-md mr-3" style="float:right" :disabled="disabled">
                                <i v-show="loading" class="fa fa-spinner fa-spin"></i>
                                    Save Changes
                            </button>
                        </div>
                    </form>
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
                id:0,
                file: '',
                item_info:{},
                loading: false,
                disabled: false,
                modal: false,
                categories : {},
                unitTypes: {},
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
            async loadData(){
                //untuk panggil progress bar
                this.$Progress.start();

                // untuk call route yang ada di api.php>> bisa call controller untuk get data dari database
                await axios
                    .get('http:/api/get_category')
                    .then(({data}) => (this.categories = data));
                await axios
                    .get('http:/api/getUnitType')
                    .then(({data}) => (this.unitTypes = data));
                await axios
                    .get('http:/api/getItemInfo/'+this.id)
                    .then(({data}) => (this.item_info = data));
                    this.form.fill(this.item_info);
                //untuk mengakhiri progress bar setelah halaman muncul
                this.$Progress.finish();
            },
            editData(){
                this.$Progress.start();
                this.loading = true;
                this.disabled = true;

                this.form
                    .post('http:/api/edit_item/'+this.form.id)
                    .then(()=>{
                    Fire.$emit("refreshData");
                    Swal.fire(
                        'Success!',
                        'Product Edited Successfully!',
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
                    this.$Progress.fail();
                    this.loading = false;
                    this.disabled = false; 
                });
            },
            onChangeCategory(event){
                if(event.target.value=="new"){
                    document.getElementById("category_id_others").style.display="block";
                }else{
                    document.getElementById("category_id_others").style.display="none";
                }
            },
        },
        created(){
            this.id = this.$route.params.id;
            this.loadData();
            Fire.$on('refreshData',() => {
                this.loadData();
            })
        }
    }
</script>
