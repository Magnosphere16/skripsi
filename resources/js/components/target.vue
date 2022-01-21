<template>

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
                  <h3 class="card-title"><strong>Turnover</strong></h3>
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
                                <label class="col-md-4 col-form-label text-md-right">Turnover Target Value</label>
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
                turn_over : 0,
                form:[{  
                    target:{},
                    duration:{},
                }],
            }
        },
        methods:{
            async loadData(){
                await axios
                    .get('api/getAsset/'+this.userInfo.id)
                    .then(({data}) => (this.harga_modal = data));

                await axios
                      .get('api/userTurnOver/'+this.userInfo.id)
                      .then(({data}) => (this.turn_over = data));
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
