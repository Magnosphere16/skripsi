<template>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-xl mt-5">
            <h1><strong>Sale Transaction Lists</strong></h1>
            <div class="mt-5">
                <div class="form-inline">
                    <a class="btn btn-success btn-md mb-2 mr-3" :href="'api/downloadTransaction/'+userInfo.id+'/'+start_date+'/'+end_date">Download Transaction Report</a>
                    <div class="form-group mb-2">
                        <input type="date" v-model="start_date" class="form-control">
                        <label for="inputPassword2" class="ml-3">To</label>
                    </div>  
                    <div class="form-group mx-sm-3 mb-2">
                        <input type="date" v-model="end_date" class="form-control">
                    </div>
                </div>
            </div>
            <div class="card mt-2">
                <div class="card-header">
                    <router-link to="newSale" class="btn btn-danger btn-md" style="float:right; right:0;" tag="button">+ New Sale Transaction</router-link>
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
                                <td>Rp {{(a.tr_total_price).toLocaleString('en')}}</td>
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
                start_date: {},
                end_date : {},
            }
        },
        methods:{
            // downloadTransaction(){
            //         axios
            //             .get("api/downloadTransaction/"+this.userInfo.id+"/"+this.start_date+"/"+this.end_date, {
            //                 start_date:this.start_date,
            //                 end_date:this.end_date
            //             })
            // },
            async loadData(){
                //untuk panggil progress bar
                this.$Progress.start();

                // untuk call route yang ada di api.php>> bisa call controller untuk get data dari database
                await axios
                    .get('api/getSaleTransactions')
                    .then(({data}) => (this.transactionsHeader = data));
                
                await axios
                    .get('api/getTransactionType')
                    .then(({data}) => (this.transactionType = data));

                await axios
                    .get('api/get_category')
                    .then(({data}) => (this.categories = data));
                await axios
                    .get('api/getItem')
                    .then(({data}) => (this.items = data));
                await axios
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
