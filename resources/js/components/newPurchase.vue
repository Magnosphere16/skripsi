<template>
    <div class="container">
        <h1 class="mt-5">New Purchase Transaction</h1>
        <form @submit.prevent="postData()">
            <label for="tr_transaction_date">Transaction Date *</label>
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
                            <th scope="col">Item Name*</th>
                            <th scope="col">Item Quantity*</th>
                            <th scope="col">Unit Type*</th>
                            <th scope="col">Item Price*</th>
                            <th scope="col">Total Price</th>
                        </tr>
                    </thead>
                    <tbody class="add_purchase_transaction">
                        <tr v-for="(form, a) in forms" :key="a">
                            <td>
                                <i class="fas fa-trash-alt red" @click="deleteRow(a, form)"></i>
                            </td>
                            <td>
                                <input  class="form-control"
                                        id="tr_item_name" 
                                        type="text" 
                                        v-model="form.tr_item_name" 
                                        name="item_name" 
                                        placeholder="Item Name">
                                        <!-- <has-error :form="form" field="item_name"></has-error>  -->
                            </td>
                            <td>
                                <input v-model="form.tr_item_qty"
                                        id="tr_item_qty" 
                                        type="number" 
                                        class="form-control"
                                        name="tr_item_qty"
                                        placeholder="min. 1"
                                        @change="calcPrice(form)"
                                        >
                            </td>
                            <td>
                                <select v-model="form.tr_unit_type_id" 
                                    name="tr_unit_type_id" id="tr_unit_type_id" 
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
                                    id="tr_item_price" 
                                    type="number" 
                                    class="form-control" 
                                    name="tr_item_price" 
                                    value="0"
                                    placeholder="0"
                                    @change="calcPrice(form)"
                                    >
                                <!-- <has-error :form="form" field="tr_item_price"></has-error> -->
                            </td>
                            <td> 
                                <input v-model="form.tr_line_total" 
                                    id="tr_line_total" 
                                    type="number" 
                                    class="form-control" 
                                    name="tr_line_total"
                                    style="display:none;" 
                                    placeholder="0"
                                    >
                                Rp. {{
                                    (form.tr_item_qty * form.tr_item_price).toLocaleString('en')  
                                }}
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
                    <h3>Rp. {{(final_total).toLocaleString('en')}}</h3>
            </div>
                <div>
                    <button type="submit" class="btn btn-success" style="float:left; left:0;">
                        <i v-show="loading" class="fa fa-spinner fa-spin"></i>
                            Submit Transaction
                    </button>
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
                items: {},
                item_info :{},
                item_price :{},
                unitTypes: {},
                
                tr_user_id:this.userInfo.id,
                tr_transaction_type:1,
                tr_transaction_date:{},
                final_total:0,
                forms:[{  
                    tr_item_name:"",
                    tr_item_qty:"",
                    tr_item_price:"",
                    tr_unit_type_id:"",
                    tr_line_total:0,
                }],
            }
        },
        methods:{
            addItemRow(){
                this.forms.push({
                    tr_item_name:"",
                    tr_item_qty:"",
                    tr_item_price:"",
                    tr_unit_type_id:"",
                    tr_line_total:0,
                });
            },
            deleteRow(index, form) {
                var idx = this.forms.indexOf(form);
                console.log(idx, index);
                if (idx > -1) {
                    this.forms.splice(idx, 1);
                }
                this.calcPriceTotal();
            },
            itemChange(event){
                this.form.tr_item_qty=
                document.getElementById("result_price").innerHTML = 0;
            },
            calcPrice(form){
                var total=parseFloat(form.tr_item_qty) * parseFloat(form.tr_item_price);
                    form.tr_line_total=total;

                this.calcPriceTotal();
            },
            calcPriceTotal(){
                var total;
                total = this.forms.reduce(function(sum, product){
                    var lineTotal = parseFloat(product.tr_line_total);
                    if (!isNaN(lineTotal)){
                        return sum + lineTotal;
                    };
                },0);

                this.final_total = total;
            },
            async loadData(){
                //untuk panggil progress bar
                this.$Progress.start();

                // untuk call route yang ada di api.php>> bisa call controller untuk get data dari database
                await axios
                    .get('api/getItem')
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
                axios
                    .post("api/addPurchaseData", {
                        purchaseArray: this.forms,
                        transactionDate :this.tr_transaction_date,
                        transactionType:1,
                        userId:this.tr_user_id,
                        total_price:this.final_total
                    }).then(()=>{
                    Fire.$emit("refreshData");
                    Swal.fire(
                        'Success!',
                        'Purchase Transaction Saved Successfully!',
                        'success'
                        ).then(function() {
                        window.location = "/home";
                    });
                    this.$Progress.finish();
                    this.loading = false;
                    this.disabled = false;
                    })
                // else
                    .catch(()=>{
                        Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: "Don't Forget to Fill the required Inputs!",
                        })
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

