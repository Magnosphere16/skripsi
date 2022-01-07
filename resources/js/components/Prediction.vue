<template>
    <div class="container mt-5">
        <div class="row">
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
              <div class="inner">
                <h4>Rp. {{ (turn_over.to_final_target_turnover).toLocaleString('en') }}</h4>

                <p>Target Turn Over</p>
              </div>
              <div class="icon">
                <i class="ion ion-bag"></i>
              </div>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-success">
              <div class="inner">
                <h4>Rp. {{ (harga_modal).toLocaleString('en') }}</h4>

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
            <div class="small-box bg-warning">
              <div class="inner">
                <h4>Rp. {{ (turn_over.to_current_turnover).toLocaleString('en') }}</h4>

                <p>Current Month Turn Over</p>
              </div>
              <div class="icon">
                <i class="ion ion-person-add"></i>
              </div>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-danger">
              <div class="inner">
                <h4>Rp. {{ (turn_over.to_current_month_target_turnover).toLocaleString('en') }}</h4>

                <p>Current Month Target Turn Over</p>
              </div>
              <div class="icon">
                <i class="ion ion-pie-graph"></i>
              </div>
            </div>
          </div>
          <!-- ./col -->
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title"><strong>Set Targeting Revenue Value</strong></h4>
                    </div>
                    <div class="card-body">
                        <form @submit.prevent="postData()">
                                            <div class="form-group row">
                                                <label for="name" class="col-md-4 col-form-label text-md-right">Target Revenue Value</label>
                                                <div class="col-md-6">
                                                    <input
                                                        v-model="form.target"
                                                        id="target" 
                                                        type="number" 
                                                        class="form-control"
                                                        name="target"
                                                        >
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="name" class="col-md-4 col-form-label text-md-right">Duration</label>
                                                <div class="col-md-4">
                                                    <input
                                                        v-model="form.duration"
                                                        id="duration" 
                                                        type="number" 
                                                        class="form-control"
                                                        name="duration"
                                                        >
                                                </div><strong>Month(s)</strong>
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
                omset : {},
                turn_over:{},
                form: new Form({    
                    id:"",
                    target:"",
                    duration:""
                }),
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

                axios
                      .get('api/userTurnOver/'+this.userInfo.id)
                      .then(({data}) => (this.turn_over = data));

                axios
                    .get('api/getSale')
                    .then(({data}) => (this.omset = data));

                axios
                    .get('api/getSale')
                    .then(({data}) => (this.total_jual = data));
                
                //untuk mengakhiri progress bar setelah halaman muncul
                this.$Progress.finish();
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
