<template>
    <div class="container">
        <h1 class="mt-5">New Sale Transaction</h1>
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
                    <tbody class="add_sale_transaction">
                        <tr>
                            <td>
                                <select v-model="form.tr_item_id" 
                                    name="tr_item_id" id="tr_item_id" 
                                    class="form-control input-lg dynamic" 
                                    style="width:inherit;"
                                    @change="itemChange($event)">
                                        <option value="">Select Item</option>
                                        <option v-for="item in items" :key="item.id" :value="item.id">
                                            {{item.item_name}}
                                        </option>
                                </select>
                            </td>
                            <td>
                                <input v-model="form.tr_item_qty"
                                        id="tr_item_qty" 
                                        type="number" 
                                        class="form-control"
                                        name="tr_item_qty"
                                        placeholder="min. 1"
                                        @change="calcPrice(form.tr_item_qty,item_price)"
                                        >
                            </td>
                            <div v-for="item in items" :key="item.id" :value="item.id">
                                <div v-if="item.id == form.tr_item_id">
                                    <div v-for="unit in unitTypes" :key="unit.id" :value="unit.id">
                                        <td v-if="unit.id == item.unit_type_id">{{unit.unit_type_name}}</td>
                                    </div>
                                </div>
                            </div>
                            <td>
                                <div v-for="item in items" :key="item.id" :value="item.id">
                                    <div v-if="item.id == form.tr_item_id">
                                        <p>{{item.item_sell_price}}</p>
                                        <input style="display:none;" :value="getPrice(item.item_sell_price)">
                                    </div>
                                </div>
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
                    tr_item_id:"",
                    tr_item_qty:"",
                    tr_item_price:"",
                    tr_transaction_date:"",
                    total_price:"",
                }),
            }
        },
        methods:{
            addItemRow(){
                var addItem = "<tr class='newEntry'>"
                addItem+="<td><select name='tr_item_id' id='tr_item_id_add' class='form-control input-lg dynamic' itemChange='(this)' style='width:inherit;'><option value=1>Select Item</option>";
                for (var item of this.items) {
                    addItem+=`<option value=item.id>${item.item_name}</option>`;
                }
                addItem+="</select></td>"
                // var e = document.getElementById("tr_item_id_add");
                // e.options[e.selectedIndex].value=1;
                // console.log($('#tr_item_id_add').find(":selected").text());
                // if(e.options[e.selectedIndex].value){
                //     for (var item of this.items) {
                //         if(item.id==e.options[e.selectedIndex].value){
                //             addItem+=`<td>${item.unit_type_id}</td>`
                //         }
                //     }
                // }
                // var item_value=e.options[e.selectedIndex].value;// get selected option value
                // console.log(item_value);
                addItem+="<td><input id='tr_item_qty_add' type='number' class='form-control' name='tr_item_qty' placeholder='min. 1' @change='calcPrice(form.tr_item_qty,item_price)'></td>";
                addItem+="<td id='unit_type_id_add'></td>"
                addItem+="<td id='item_price_add'></td>"
                addItem+="<td id='total_price_add'>0</td>"
                addItem+="<tr>"
                $("table .add_sale_transaction").append(addItem);
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

