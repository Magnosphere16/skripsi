<template>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card mt-5">
                <div class="card-header" style="position:relative;"><strong>Items</strong>
                    <button style="position: absolute; right: 10px; bottom:8px;" type="button" id="add_item_cat" class="btn btn-secondary btn-sm" data-toggle="modal" data-target="#addItemFCatForm">+</button>
                </div>
                <div class="card-body">
                        <!-- item list -->
                        <table class="table table-striped">
                            <thead>
                                <th>Item Name</th>
                                <th>Item Description</th>
                                <th>Item Quantity (pcs)</th>
                                <th>Item Buy Price</th>
                                <th>Item Sell Price</th>
                                <th>Action</th>
                            </thead>
                            <tbody>
                                <tr v-for="a in items" :key="a.id" :value="a.id">
                                    <td>{{a.item_name}}</td>
                                    <td>{{a.item_desc}}</td>
                                    <td>{{a.item_qty}}</td>
                                    <td>Rp {{a.item_buy_price}}</td>
                                    <td>Rp {{a.item_sell_price}}</td>
                                    <td><a href="">Edit</a>|<a href="">Delete</a></td>
                                </tr>
                            </tbody>
                        </table>
                        <!-- modal -->
                        <div class="modal fade" id="addItemFCatForm" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content" >
                                    <div class="modal-header text-center">
                                        <h4 class="modal-title" id="exampleModalLongTitle">New Item</h4>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form @submit.prevent="postData()" id="addItemForm">
                                            <div class="form-group row">
                                                <label for="name" class="col-md-4 col-form-label text-md-right">Item Name</label>

                                                <div class="col-md-6">
                                                    <input v-model="form.item_name" 
                                                        id="item_name" 
                                                        type="text" 
                                                        class="form-control" 
                                                        :class="{ 'is-invalid' : form.errors.has(item_name) }" 
                                                        name="item_name" 
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
                                                        :class="{ 'is-invalid' : form.errors.has(item_desc) }" 
                                                        name="item_desc" 
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
                                                        :class="{ 'is-invalid' : form.errors.has(item_category_id) }"
                                                        style="width:inherit;">
                                                            <option value="">Select Category</option>
                                                            <option v-for="item in categories" :key="item.id" :value="item.id">
                                                                {{item.category_name}}
                                                            </option>
                                                    </select>
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
                                                        :class="{ 'is-invalid' : form.errors.has(item_qty) }" 
                                                        name="item_qty"  
                                                        placeholder="1">
                                                    <has-error :form="form" field="item_qty"></has-error>
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="buy" class="col-md-4 col-form-label text-md-right">Item Buy Price</label>

                                                <div class="col-md-6">
                                                    <input v-model="form.item_buy_price" 
                                                        id="item_buy" 
                                                        type="number" 
                                                        class="form-control" 
                                                        :class="{ 'is-invalid' : form.errors.has(item_buy_price) }"
                                                        name="item_buy" 
                                                        min="0" 
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
                                                        :class="{ 'is-invalid' : form.errors.has(item_sell_price) }" 
                                                        name="item_sell" 
                                                        placeholder="0">
                                                    <has-error :form="form" field="item_sell_price"></has-error>
                                                </div>
                                            </div>

                                            <div class="form-group row mb-0">
                                                <div class="col-md-6 offset-md-4">
                                                    <button type="submit" class="btn btn-primary btn-block">
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
        data(){
            return{
                categories : {},
                items : {},
                deletes :{},
                form: new Form({
                    id:"",
                    item_name:"",
                    item_desc:"",
                    item_qty:"",
                    item_category_id:"",
                    item_buy_price:"",
                    item_sell_price:""
                }),
            }
        },
        methods:{
            loadData(){
                // untuk call route yang ada di api.php>> bisa call controller 
                axios
                    .get('api/get_category')
                    .then(({data}) => (this.categories = data));
                axios
                    .get('api/getItem')
                    .then(({data}) => (this.items = data));
            },
            postData(){
                this.form.post('add_item').then(()=>{
                    Fire.$emit("refreshData");
                    $('#addItemFCatForm').modal('hide');
                    Toast.fire({
                        icon: 'success',
                        title: 'Item Saved successfully'
                        });
                    })
                .catch();
            },
        },
        created(){
            this.loadData();
            Fire.$on('refreshData',() => {
                this.loadData();
            })
        }
    }
</script>
