<template>
    <div class="container">
        <div class="row justify-content-center mt-5">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Profit Prediction</div>
                        <div class="card-body">Primary Card</div>
                        <div class="card-footer d-flex align-items-center justify-content-between">
                            <a class="small text-white stretched-link" href="#">View Details</a>
                            <div class="small text-white"><svg class="svg-inline--fa fa-angle-right fa-w-8" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="angle-right" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512" data-fa-i2svg=""><path fill="currentColor" d="M224.3 273l-136 136c-9.4 9.4-24.6 9.4-33.9 0l-22.6-22.6c-9.4-9.4-9.4-24.6 0-33.9l96.4-96.4-96.4-96.4c-9.4-9.4-9.4-24.6 0-33.9L54.3 103c9.4-9.4 24.6-9.4 33.9 0l136 136c9.5 9.4 9.5 24.6.1 34z"></path></svg><!-- <i class="fas fa-angle-right"></i> Font Awesome fontawesome.com --></div>
                        </div>

                    <div class="card-body">
                        Harga Modal : Rp. {{ (harga_modal).toLocaleString('en') }}<br>
                        Total Jual  : Rp. {{ (total_jual).toLocaleString('en') }}
                    </div>
<!--
                    <tr v-for="tes in transactionsHeader" :key="tes.id" :value="tes.id">
                            <td>{{tes.id}}</td>
                            <td>{{tes.tr_transaction_type_id}}</td>
                            <td>{{tes.tr_transaction_date}}</td>
                            <td>{{tes.tr_total_price}}</td>
                    </tr> -->

                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
       props: ['userInfo'],
        data(){
            return{
                loading: false,
                disabled: false,
                harga_modal : 0,
                total_jual : 0,
                // transactionsHeader : {}
            }
        },
        methods:{
            loadData(){
               //Contoh get Data dari Database
                //untuk panggil progress bar
                this.$Progress.start();

                // untuk call route yang ada di api.php>> bisa call controller untuk get data dari database
                axios
                    .get('api/getAsset')
                    .then(({data}) => (this.harga_modal = data));

                    console.log(this.harga_modal);

                axios
                    .get('api/getSale')
                    .then(({data}) => (this.total_jual = data));

                    console.log(this.total_jual);

                // axios
                // .get('api/getAllTransaction')
                // .then(({data}) => (this.transactionsHeader= data));

                // //untuk mengakhiri progress bar setelah halaman muncul
                // this.$Progress.finish();



            },
            //Contoh insert ke Database
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
                    }).then(()=>{
                        //pop up
                    Fire.$emit("refreshData");
                    Swal.fire(
                        'Success!',
                        'Sale Transaction Saved Successfully!',
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
            this.loadData();
            Fire.$on('refreshData',() => {
                this.loadData();
            })
        }

    }
</script>
