<template>
    <div class="container mt-3">
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

    <div class="container mt-5">
        <h1><strong>Turnover Targeting</strong></h1>
        <div class="row mt-2">
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-primary">
              <div class="inner">
                <h4 v-if="turn_over.to_final_target_turnover!=null"><strong>Rp. {{ (turn_over.to_final_target_turnover).toLocaleString('en') }}</strong></h4>
                <h4 v-else><strong>Rp. 0</strong></h4>
                <p>Target Turnover</p>
              </div>
              <div class="icon">
                <i class="ion ion-bag"></i>
              </div>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-primary">
              <div class="inner">
                <h4 v-if="harga_modal!=null"><strong>Rp. {{ (harga_modal).toLocaleString('en') }}</strong></h4>

                <p>Asset</p>
              </div>
              <div class="icon">
                <i class="ion ion-stats-bars"></i>
              </div>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-primary">
              <div class="inner">
                <h4 v-if="turn_over.to_current_turnover!=null"><strong>Rp. {{ (turn_over.to_current_turnover).toLocaleString('en') }}</strong></h4>
                <h4 v-else><strong>Rp. 0</strong></h4>

                <p>Current Month Turnover</p>
              </div>
              <div class="icon">
                <i class="ion ion-person-add"></i>
              </div>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-primary">
              <div class="inner">
                <h4 v-if="turn_over.to_current_month_target_turnover!=null && turn_over.to_current_month_target_turnover>0"><strong>Rp. {{ (turn_over.to_current_month_target_turnover).toLocaleString('en') }}</strong></h4>
                <h4 v-else><strong>Rp. {{turn_over.to_final_target_turnover/turn_over.to_turnover_duration}}</strong></h4>

                <p>Current Month Target Turnover</p>
              </div>
              <div class="icon">
                <i class="ion ion-pie-graph"></i>
              </div>
            </div>
          </div>
          <!-- ./col -->
        </div>

        <div class="row">

          <div class="col-lg-6">
            <div class="card">
              <div class="card-header border-0 bg-primary">
                <div class="d-flex justify-content-between">
                  <h3 class="card-title"><strong>Turn Over</strong></h3>
                </div>
              </div>               
                <turn-over :passing="userInfo"></turn-over>
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col-md-6 -->
          <div class="col-lg-6">
            <div class="card">
                    <div class="card-header bg-primary">
                        <h4 class="card-title"><strong>Set Turnover Target Value</strong></h4>
                    </div>
                    <div class="card-body">
                        <form @submit.prevent="postData()">
                            <div class="form-group row">
                                <label for="target" class="col-md-4 col-form-label text-md-right">Turnover Target Value</label>
                                <div class="col-md-6">
                                    <input
                                        v-model="form.target"
                                        id="target" 
                                        type="number.toFixed(2)" 
                                        class="form-control"
                                        name="target"
                                        >
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="name" class="col-md-4 col-form-label text-md-right">Estimated achieved in (Months)</label>
                                <div class="col-md-6">
                                    <input
                                        v-model="form.duration"
                                        id="duration" 
                                        type="number" 
                                        class="form-control"
                                        name="duration">
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary btn-block" :disabled="disabled">
                                        <i v-show="loading" class="fa fa-spinner fa-spin"></i>
                                          Submit
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
<!--
                    <tr v-for="tes in transactionsHeader" :key="tes.id" :value="tes.id">
                            <td>{{tes.id}}</td>
                            <td>{{tes.tr_transaction_type_id}}</td>
                            <td>{{tes.tr_transaction_date}}</td>
                            <td>{{tes.tr_total_price}}</td>
                    </tr> -->

                <!-- /.card-footer -->
                </div>
            <!-- /.card --> 
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
            async loadData(){
               //Contoh get Data dari Database 
                //untuk panggil progress bar
                // untuk call route yang ada di api.php>> bisa call controller untuk get data dari database
                await axios
                    .get('api/getAsset')
                    .then(({data}) => (this.harga_modal = data));

                await axios
                      .get('api/userTurnOver/'+this.userInfo.id)
                      .then(({data}) => (this.turn_over = data));

                    console.log(this.total_jual);

                // axios
                // .get('api/getAllTransaction')
                // .then(({data}) => (this.transactionsHeader= data));

                // //untuk mengakhiri progress bar setelah halaman muncul
                // this.$Progress.finish();


                // await axios
                //     .get('api/getSale')
                //     .then(({data}) => (this.total_jual = data));
                
                //untuk mengakhiri progress bar setelah halaman muncul
            },
            //Contoh insert ke Database
            postData(){
                this.form
                    .post('api/setTarget/'+this.userInfo.id)
                    .then(()=>{
                    Fire.$emit("refreshData");
                    Swal.fire(
                        'Success!',
                        'Target Revenue Saved Successfully!',
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
