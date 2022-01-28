<template>
    <div class="container">
        <h1 class="mt-3">New Sale Transaction</h1>
        <form @submit.prevent="postData()">
            <label for="tr_transaction_date">Transaction Date*</label>
            <input  
                    v-model="tr_transaction_date"
                    id="tr_transaction_date" 
                    class="form-control"
                    name="tr_transaction_date" 
                    type="date" 
                    disabled
                    >
            <div class="row justify-content-center mt-5">
                <table class="table table-bordered table-striped">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col">Action</th>
                            <th scope="col">Product Name*</th>
                            <th scope="col">Product Quantity*</th>
                            <th scope="col">Unit Type*</th>
                            <th scope="col">Price*</th>
                            <th scope="col">Sub Total Price*</th>
                        </tr>
                    </thead>
                    <tbody class="add_sale_transaction">
                        <tr v-for="(form, a) in forms" :key="a">
                            <td>
                                <a @click="deleteRow(a, form)"><i class="fas fa-trash-alt red"></i></a>
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
                                        @input="calcPrice(form,a)"
                                        >
                                <!-- <p id="warning_qty" class="text-danger" style="display:none;">*The amount of items filled exceeds the quantity of items that have been stored</p> -->
                            </td>
                            <td>
                                <input v-model="form.tr_unit_type_id" style="display:none;" >
                                {{!items.find((item) => {
                                    return item.id === form.tr_item_id
                                }) ? '' : items.find((item) => {
                                    return item.id === form.tr_item_id
                                }).unit_type.unit_type_name}}
                            </td>
                            <td style="text-align: right;">
                                <input v-model="form.tr_item_price" style="display:none;">
                                Rp. {{!items.find((item) => {
                                    form.tr_item_price=item.item_sell_price;
                                    return item.id === form.tr_item_id
                                }) ? 0 : items.find((item) => {
                                    return item.id === form.tr_item_id
                                }).item_sell_price.toLocaleString('en') }}
                                <!-- <has-error :form="form" field="tr_item_price"></has-error> -->
                            </td>
                            <td id="sub_total" style="text-align: right;">    
                                <input v-model="form.tr_line_total" style="display:none">
                                Rp. {{
                                    (form.tr_item_qty * form.tr_item_price).toLocaleString('en')  
                                }}
                            </td>
                        </tr>
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>
                                <button class="btn btn-primary btn-md" v-on:click="addItemRow" type="button" id="addItems"> Add Products </button>
                            </th>
                        </tr>
                    </tfoot>
                </table>
            </div>
            <div id="final_total" style="float:right; right:0;">
                    <h5>Grand Total:</h5>
                    <h3>Rp. {{(final_total).toLocaleString('en')}}</h3>
                    <div>
                        <button type="submit" class="btn btn-primary mr-2" style="float:left; left:0;">
                            <i v-show="loading" class="fa fa-spinner fa-spin"></i>
                                Submit Transaction
                        </button>
                        <router-link :to="'/sale_transactions'" class="btn btn-secondary" style="float:left">Cancel</router-link>
                    </div>
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
                errors: [],
                curr_date:{},

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
                    return item.id == event.target.value;
                })?.unit_type_id;
                
                this.calcPrice(this.forms[index],index);
                this.calcPriceTotal();
            },
            deleteRow(index, form) {
                var idx = this.forms.indexOf(form);
                console.log(idx, index);
                if (idx > -1) {
                    this.forms.splice(idx, 1);
                }
                this.calcPriceTotal();
            },
            calcPrice(form,index){
                var item_qty = this.items.find((item) => {
                    return item.id == form.tr_item_id
                })?.item_qty;

            // if Inputed item quantity not exceed the item quantity in database
                var total=form.tr_item_qty * form.tr_item_price;
                this.forms[index].tr_line_total=total;

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
                    axios
                    .post("api/addSaleData", {
                        saleArray: this.forms,
                        transactionDate :this.tr_transaction_date,
                        transactionType:2,
                        userId:this.tr_user_id,
                        total_price:this.final_total
                    }, {responseType: 'blob'})
                    .then(response => {
                            const url = window.URL.createObjectURL(new Blob([response.data]));
                            const link = document.createElement('a');
                            link.href = url;
                            link.setAttribute('download', 'TransactionReceipt.pdf'); //or any other extension
                            document.body.appendChild(link);
                            link.click();

                            Fire.$emit("refreshData");
                            Swal.fire(
                                'Success!',
                                'Sale Transaction Saved Successfully!',
                                'success'
                                ).then(function() {
                                window.location = "/sale_transactions";
                            });
                            this.$Progress.finish();
                            this.loading = false;
                            this.disabled = false;
                    })
                // else
                    .catch(()=>{
                        Swal.fire({
                        icon: 'error',
                        title: 'Transaction Failed',
                        text: "Please fill the required fields",
                        })
                        this.$Progress.fail();
                        this.loading = false;
                        this.disabled = false; 
                    });
            }
        },
        created(){
            const myDate = new Date();
            myDate.setHours( myDate.getHours() + 7 );
            this.tr_transaction_date=myDate.toISOString().slice(0,10);
            this.loadData();
            Fire.$on('refreshData',() => {
                this.loadData();
            })
        }

    }
</script>

