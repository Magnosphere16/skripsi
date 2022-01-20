<template>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-xl mt-3">
            <h1><strong>Transaction Lists</strong><router-link to="newSale" class="btn btn-primary btn-md" style ="float:right;" tag="button">+ New Sale Transaction</router-link></h1>
            <div class="card mt-3">
                <div class="card-header">
                    <div class="form-inline">
                        <a class="btn btn-success btn-md mb-2 mr-3" :href="'api/downloadTransaction/'+userInfo.id+'/'+start_date+'/'+end_date">Download Transaction Report</a>
                        <div class="form-group mb-2">
                            <label for="inputDateFrom" class="mr-3">From</label>
                            <input type="date" class="form-control">
                            <label for="inputDateTo" class="ml-3">To</label>
                        </div>  
                        <div class="form-group mx-sm-3 mb-2">
                            <input type="date" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="ml-4">
                        <pagination :meta="meta" v-on:pagination="getTransaction"></pagination>
                    </div>
                    <table class="table table-striped" id="myTable">
                        <thead>
                            <th class="text-center">Transaction ID</th>
                            <th class="text-center">Transaction Date</th>
                            <th style="text-align: right;">Total Price</th>
                        </thead>
                        <tbody>
                            <tr v-for="trans in transactionsHeader" :key="trans.id" :value="trans.id">
                                <td class="text-center">{{trans.id}}</td>
                                <td class="text-center"><router-link :to="'/transaction_detail/'+trans.id" class="link-primary"><strong>{{trans.tr_transaction_date}}</strong></router-link></td>
                                <td style="text-align: right;"><strong>Rp {{(trans.tr_total_price).toLocaleString('en')}}</strong></td>
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
                transactionsHeader : [],
                transactionsDetail : {},
                transactionType : {},
                categories : {},
                items : {},
                unitTypes : {},
                start_date: '',
                end_date : '',

                meta: {},
            }
        },
        methods:{
            onChangeStart(event){
                this.start_date=event.target.value;
                this.getTransaction();
            },
            onChangeEnd(event){
                this.end_date=event.target.value;
                this.getTransaction();
            },
            getTransaction(page){
                let start=0;
                let end=0;
                if(this.start_date!=""){
                    start=this.start_date;
                }
                if(this.end_date!=""){
                    end=this.this.end_date;
                }
                axios
                    .get('api/getSaleTransactions/'+this.userInfo.id+'/'+start+'/'+end,{
                        params:{    
                            page
                        }
                    })
                    .then(({data}) => (
                        this.transactionsHeader = data.data,
                        this.meta = data.meta
                        ));
            },
            async loadData(){
                //untuk panggil progress bar
                this.$Progress.start();

                // untuk call route yang ada di api.php>> bisa call controller untuk get data dari database
                //get all transaction pagination 5 data
                this.getTransaction();

                await axios
                    .get('api/getTransactionType')
                    .then(({data}) => (this.transactionType = data));

                await axios
                    .get('api/get_category')
                    .then(({data}) => (this.categories = data));
                await axios
                    .get('api/getItem/'+this.userInfo.id)
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
            });
        },
        computed:{
            // filteredTransaction: function (){
            //     return this.transactionsHeader.filter((trans)=>{
            //             let filtered = true;
            //             let start=this.start_date;
            //             let end =this.end_date;
            //             if(start!="" && end!=""){
            //                 console.log("ada smua")
            //                 filtered = (start <= trans.tr_transaction_date) && (trans.tr_transaction_date <= end);
            //             }else if(start !="" && end ==""){
            //                 console.log("start doang");
            //                 console.log(start);
            //                 console.log(trans.tr_transaction_date);
            //                 filtered = (start <= trans.tr_transaction_date);
            //                 console.log(filtered);
            //             }else if(start =="" && end != ""){
            //                 console.log("end doang");
            //                 filtered = trans.tr_transaction_date <= end;
            //             }
            //         return filtered
            //     })
            // },
        }

    }
</script>
