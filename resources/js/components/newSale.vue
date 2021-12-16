<template>
    <div class="container">
        <h1 class="mt-5">New Sale Transaction</h1>
        <form method="POST" action="/addSaleTrans" enctype="multipart/form-data" id="addSaleTransForm">
            <label for="tr_transaction_date">Transaction Date</label>
            <input  v-model="tr_transaction_date"
                    id="tr_transaction_date" 
                    class="form-control"
                    name="tr_transaction_date" 
                    type="date" 
                    :placeholder="new Date().toLocaleString()">
            <div class="row justify-content-center mt-5">
                <table class="table table-bordered table-striped">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Item Name</th>
                            <th scope="col">Item Quantity</th>
                            <th scope="col">Unit Type</th>
                            <th scope="col">Item Price</th>
                            <th scope="col">Total Price</th>
                        </tr>
                    </thead>
                    <tbody class="add_sale_transaction">
                        <tr v-for="(form, a) in forms" :key="a">
                            <td>
                                <i class="fas fa-trash-alt red" @click="deleteRow(a, form)"></i>
                            </td>
                            <td>
                                <select v-model="form.tr_item_id" 
                                    name="tr_item_id" id="tr_item_id" 
                                    class="form-control input-lg dynamic" 
                                    style="width:inherit;"
                                    @change="itemChange($event, a)">
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
                                        @change="calcPrice(form[a])"
                                        >
                            </td>
                            <td>
                                <input v-model="form.tr_unit_type_id" style="display:none;" >
                                {{!items.find((item) => {
                                    return item.id === form.tr_item_id
                                }) ? '' : items.find((item) => {
                                    return item.id === form.tr_item_id
                                }).unit_type.unit_type_name}}
                            </td>
                            <td>
                                <input v-model="form.tr_item_price" style="display:none;">
                                {{!items.find((item) => {
                                    return item.id === form.tr_item_id
                                }) ? '' : items.find((item) => {
                                    return item.id === form.tr_item_id
                                }).item_sell_price}}
                                <!-- <has-error :form="form" field="tr_item_price"></has-error> -->
                            </td>
                            <td>    
                                <input v-model="form.tr_line_total" 
                                    id="tr_line_total" 
                                    type="number" 
                                    class="form-control" 
                                    name="tr_line_total"
                                    disabled 
                                    placeholder="0"
                                    >
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
            <div id="final_total" style="float:right; right:0;">
                    <h5>Total:</h5>
                    <h3>{{final_total}}</h3>
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
                items : [],
                unitTypes : [],

                tr_user_id:this.userInfo.id,
                tr_transaction_type:2,
                tr_transaction_date:{},
                final_total:0,
                forms:[{  
                    tr_item_id:"",
                    tr_item_qty:"",
                    tr_item_price:"",
                    tr_unit_type_id:"",
                    tr_line_total:0,
                }],
            }
        },
        methods:{
            calcPrice(form){
                console.log(form);
                var total=form.tr_item_qty * form.tr_item_price;
                    form.tr_line_total=total;

                this.calcPriceTotal();
            },
            // calcPriceTotal(){
            //     var total;
            //     total = this.forms.reduce(function(sum, product){
            //         var lineTotal = parseFloat(product.tr_line_total);
            //         if (!isNaN(lineTotal)){
            //             return sum + lineTotal;
            //         };
            //     },0);
            //     this.final_total = total.toFixed(2);
            // },
            addItemRow(){
                this.forms.push({
                    tr_item_id:"",
                    tr_item_qty:"",
                    tr_item_price:"",
                    tr_unit_type_id:"",
                    tr_line_total:0,
                });
            },
            itemChange(event, index){
                // find kalo gaketemu return undefined >> return value handling (?.)
                this.forms[index].tr_unit_type_id = this.items.find((item) => {
                    return item.id === event.target.value;
                })?.unit_type_id;

                // console.log("itemChange("+event.target.value+")");
            },
            calcPrice($qty,$price){
                // document.getElementById("result_price").innerHTML = $qty*$price;
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

