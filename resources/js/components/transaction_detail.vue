<template>
            <div class="container-xl px-4 mt-4">
                        <!-- Invoice-->
                        <div class="card invoice"> 
                            <div class="card-header p-4 p-md-5 border-bottom-0 bg-primary text-white-50">
                                <div class="row justify-content-between align-items-center">
                                    <div class="col-12 col-lg-auto mb-5 mb-lg-0 text-center text-lg-start">
                                        <!-- Invoice branding-->
                                        <img class="invoice-brand-img rounded-circle mb-4" alt="" />
                                        <div class="h2 text-white mb-0">{{userInfo.userBusinessName}}</div>
                                    </div>
                                    <div class="col-12 col-lg-auto text-center text-lg-end">
                                        <!-- Invoice details-->
                                        <div class="h3 text-white">Transaction Details #{{id}}</div>
                                        <div class="text-white">{{dates}}</div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body p-4 p-md-5">
                                <!-- Invoice table-->
                                <div class="table-responsive mb-4">
                                    <div class="mb-5">
                                        <router-link :to="'/sale_transactions'" style="float:left"><i class="fas fa-arrow-left"></i> Back</router-link>
                                    </div>
                                    <table class="table table-borderless mb-0">
                                        <thead class="border-bottom">
                                            <tr class="small text-uppercase">
                                                <th scope="col"><strong>Product Name</strong></th>
                                                <th class="text-end" scope="col"><strong>Product Quantity</strong></th>
                                                <th class="text-end" scope="col">Unit Type</th>
                                                <th style="text-align: right;" class="text-end" scope="col"><strong>Price</strong></th>
                                                <th style="text-align: right;" class="text-end" scope="col"><strong>Sub total</strong></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <!-- Invoice item 1-->
                                            <tr class="border-bottom" v-for="x in transaction_info" :key="x.id">
                                                <td>
                                                    <div class="fw-bold">{{x.item_name}}</div>
                                                </td>
                                                <td class="text-end fw-bold text-center">{{x.td_item_qty}}</td>
                                                <td class="text-end fw-bold text-center">{{!items.find((item) => {
                                                    return item.id === x.td_item_id
                                                }) ? '' : items.find((item) => {
                                                    return item.id === x.td_item_id
                                                }).unit_type.unit_type_name}}</td>
                                                <td style="text-align: right;" class="text-end fw-bold">Rp. {{(x.td_item_price).toLocaleString('en')}}</td>
                                                <td style="text-align: right;" class="text-end fw-bold">Rp. {{(x.td_sub_total_price).toLocaleString('en')}}</td>
                                            </tr>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td colspan="3"></td>
                                                <td style="text-align: right;"><strong>Total:</strong></td>
                                                <td style="text-align: right;"><strong>Rp. {{(transaction_info[0].tr_total_price).toLocaleString('en')}}</strong></td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

</template>

<script src="http://code.jquery.com/jquery-3.4.1.js"></script>
<script>
    export default {
        props: ['userInfo'],
        data(){
            return{
                id:{},
                transaction_info:{},
                dates:{},
                items:{},
            }
        },
        methods:{
            async loadData(){
                //untuk panggil progress bar
                this.$Progress.start();
                await axios
                    .get('/api/getTransactionDetail/'+this.id)
                    .then(({data})=>(this.transaction_info = data));  

                //untuk mengakhiri progress bar setelah halaman muncul
                await axios
                    .get('/api/getItem/'+this.userInfo.id)
                    .then(({data}) => (this.items = data));

                this.date();
                this.$Progress.finish();
            },
            date(){
                var months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
                var date = new Date(this.transaction_info[0].tr_transaction_date);
                this.dates= months[date.getMonth()] + ' ' + date.getDate() + ', ' +  date.getFullYear();
            }
        },
        created(){
            this.id = this.$route.params.id;
            this.loadData();
        },

    }
</script>
