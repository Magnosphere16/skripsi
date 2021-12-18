<template>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-xl">
            <div class="card mt-5">
                <div class="card-header" style="position:relative;"><strong>Sale Transaction Lists</strong>
                        <router-link to="newSale" class="btn btn-danger btn-sm" style="float:right; right:0;" tag="button">+ New Sale Transaction</router-link>
                    <!-- <router-link to="newSale" style="display:inline-block; float:right; right: 0; bottom:8px;" type="button" id="sell_item_btn" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#addItemFCatForm">+ New Sale Transactions</router> -->
                    <!-- <button style="display:inline-block; float:right; right: 0; bottom:8px;" type="button" id="buy_item_btn" class="btn btn-success btn-sm" data-toggle="modal" data-target="#addItemFCatForm">Buy Items</button> -->
                </div>
                <div class="card-body">
                    <table class="table table-striped">
                        <thead>
                            <th>Transaction ID</th>
                            <th>Transaction Date</th>
                            <th>Transaction Type</th>
                            <th>Total Price</th>
                        </thead>
                        <tbody>
                            <tr v-for="a in transactionsHeader" :key="a.id" :value="a.id">
                                <td>{{a.id}}</td>
                                <td>{{a.tr_transaction_date}}</td>
                                <div v-for="type in transactionType" :key="type.id" :value="type.id">
                                    <td v-if="a.tr_transaction_type_id === type.id" style="color:red">{{type.transaction_type_name}}</td>
                                </div>
                                <td>Rp {{a.tr_total_price}}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

</template>

<script src="http://code.jquery.com/jquery-3.4.1.js"></script>
<script>
    function form_submit(){
        document.getElementById("addItemForm").submit();
    }
</script>

<script>
    export default {
        props: ['userInfo'],
        data(){
            return{
                loading: false,
                disabled: false,
                transactionsHeader : {},
                transactionsDetail : {},
                transactionType : {},
                categories : {},
                items : {},
                unitTypes : {},
            }
        },
        methods:{
            loadData(){
                //untuk panggil progress bar
                this.$Progress.start();

                // untuk call route yang ada di api.php>> bisa call controller untuk get data dari database
                axios
                    .get('api/getSaleTransactions')
                    .then(({data}) => (this.transactionsHeader = data));
                
                axios
                    .get('api/getTransactionType')
                    .then(({data}) => (this.transactionType = data));

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
        },
        created(){
            this.loadData();
            Fire.$on('refreshData',() => {
                this.loadData();
            })
        }

    }
</script>
