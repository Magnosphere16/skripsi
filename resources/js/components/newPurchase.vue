<template>
    <div class="container">
        <h1 class="mt-5">New Purchase Transaction</h1>
        <form method="POST" action="/addSaleTrans" enctype="multipart/form-data" id="addSaleTransForm">
            <label for="tr_transaction_date">Transaction Date</label>
            <input  v-model="form.tr_transaction_date"
                    id="tr_transaction_date" 
                    class="form-control"
                    name="tr_transaction_date" 
                    type="date" 
                    :placeholder="new Date().toLocaleString()">
            <div class="row justify-content-center mt-5">
                <table class="table table-bordered table-striped">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col">Item Name</th>
                            <th scope="col">Item Quantity</th>
                            <th scope="col">Unit Type</th>
                            <th scope="col">Item Price</th>
                            <th scope="col">Total Price</th>
                        </tr>
                    </thead>
                    <tbody class="add_purchase_transaction">
                        <tr>
                            <td>
                                <input  class="form-control"
                                        id="item_name" 
                                        type="text" 
                                        v-model="form.tr_item_name" 
                                        name="item_name" 
                                        required
                                        placeholder="Item Name">
                                        <has-error :form="form" field="item_name"></has-error> 
                                <!-- <select v-model="form.tr_item_id" 
                                    name="tr_item_id" id="tr_item_id" 
                                    class="form-control input-lg dynamic" 
                                    style="width:inherit;"
                                    @change="itemChange($event)">
                                        <option value="">Select Item</option>
                                        <option v-for="item in items" :key="item.id" :value="item.id">
                                            {{item.item_name}}
                                        </option>
                                </select> -->
                            </td>
                            <td>
                                <input v-model="form.tr_item_qty"
                                        id="tr_item_qty" 
                                        type="number" 
                                        class="form-control"
                                        name="tr_item_qty"
                                        placeholder="min. 1"
                                        @change="calcPrice(form.tr_item_qty,form.tr_item_price)"
                                        >
                            </td>
                            <td>
                                <select v-model="form.tr_unit_type_id" 
                                    name="unit_type_id" id="unit_type_id" 
                                    class="form-control input-lg dynamic" 
                                    style="width:inherit;"
                                    >
                                        <option value="">Select Unit Type</option>
                                        <option v-for="item in unitTypes" :key="item.id" :value="item.id">
                                            {{item.unit_type_name}}
                                        </option>
                                        <!-- <option value="create new category">Others</option> -->
                                </select>
                            </td>
                            <td>
                                <input v-model="form.tr_item_price" 
                                    id="item_buy" 
                                    type="number" 
                                    class="form-control" 
                                    name="tr_item_price" 
                                    value="0"
                                    required
                                    placeholder="0"
                                    @change="calcPrice(form.tr_item_qty,form.tr_item_price)"
                                    >
                                <has-error :form="form" field="tr_item_price"></has-error>
                            </td>
                            <td id="result_price">
                                0
                            </td>
                        </tr>
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>
                                <button class="btn btn-primary btn-md" v-on:click="addItemRow" type="button" id="addItems"> Add Items </button>
                            </th>
                        </tr>
                    </tfoot>
                </table>
            </div>
            <div id="total_price" style="float:right; right:0;">
                <h5>Total:</h5>
                <h3>100,000</h3>
            </div>
        </form>
    </div>
</template>

<script>
    export default {
        props: ['userInfo'],
        data(){
            return{
                loading: false,
                disabled: false,
                items : {},
                item_info :{},
                item_price :{},
                unitTypes: {},
                form: new Form({    
                    id:"",
                    tr_item_name:"",
                    tr_item_qty:"",
                    tr_item_price:"",
                    tr_unit_type_id:"",
                    tr_transaction_date:"",
                    total_price:"",
                }),
            }
        },
        methods:{
            change_item_info(event){
                var e = document.getElementById("tr_item_id_add");
                var new_value=e.options[e.selectedIndex].value;
                console.log(new_value);
                //change unit type info
                for(var item of this.items){
                    if(item.id == id){
                        for(var unit of this.unitTypes){
                            if(item.unit_type_id == unit.id){
                                document.getElementById("unit_type_id_add").innerHTML = unit.unit_type_name;
                            }
                        }
                    }
                }
            },
            addItemRow(){
                var addItem = "<tr class='newEntry'>"
                addItem+="<td><input  class='form-control' id='item_name' type='text' v-model='form.tr_item_name' name='item_name' placeholder='Item Name'></td>"
                addItem+="<td><input v-model='form.tr_item_qty' id='tr_item_qty' type='number' class='form-control' name='tr_item_qty' placeholder='min. 1' @change='calcPrice(form.tr_item_qty,form.tr_item_price)'></td>"
                addItem+="<td><select name='tr_unit_type_id' id='tr_unit_type_id' class='form-control input-lg dynamic' style='width:inherit;'><option value=1>Select Unit Type</option>";
                for (var unit of this.unitTypes) {
                    addItem+=`<option value=${unit.id}>${unit.unit_type_name}</option>`;
                }
                addItem+="</select></td>"
                addItem+="<td><input v-model='form.tr_item_price' id='tr_item_price' type='number' class='form-control' name='tr_item_price' value='0' placeholder='0' @change='calcPrice(form.tr_item_qty,form.tr_item_price)'</td>"
                addItem+="<td id='total_price_add'>0</td>"
                addItem+="<tr>"
                $("table .add_purchase_transaction").append(addItem);
            },
            itemChange(event){
                this.form.tr_item_qty=
                document.getElementById("result_price").innerHTML = 0;
            },
            calcPrice($qty,$price){
                document.getElementById("result_price").innerHTML = $qty*$price;
            },
            getPrice($price){
                this.item_price=$price;
            },
            loadData(){
                //untuk panggil progress bar
                this.$Progress.start();

                // untuk call route yang ada di api.php>> bisa call controller untuk get data dari database
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
                console.log(this.userInfo.id);
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

