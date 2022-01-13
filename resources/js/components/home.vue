<template>
    <div class="container">    
      <div class="content">
      <div class="container-fluid">
        <div class="row mt-2">
            <div class="col-12 col-sm-7 col-md-5">
              <h3><strong>{{dates}}</strong></h3>
              {{times}}
            </div>
        </div>
        <div class="row mt-3">
          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box">
              <span class="info-box-icon bg-info elevation-1"><i class="fas fa-wallet"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Turnover Total</span>
                <span class="info-box-number">
                  Rp. {{ (omset).toLocaleString('en') }}
                  <!-- <small>%</small> -->
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-shopping-cart"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Total Products Sold</span>
                <span class="info-box-number">{{ (sold_product).toLocaleString('en') }}</span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->

          <!-- fix for small devices only -->

          <!-- /.col -->
          <div class="col-12 col-sm-6 col-md-6">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-bullseye"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Turnover Targeting Progress ({{period}}) </span>
                <span class="float-right"><b>Rp. {{(turn_over.to_current_turnover).toLocaleString('en')}}</b>/ Rp. {{(turn_over.to_current_month_target_turnover).toLocaleString('en')}} ({{((turn_over.to_current_turnover/turn_over.to_current_month_target_turnover)*100).toFixed(2)}} %)</span>
                <div class="progress">
                  <div class="progress-bar bg-primary" :style="{width: (((turn_over.to_current_turnover)/turn_over.to_current_month_target_turnover)*100) + '%'}"></div>
                </div>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
        </div>
        <div class="row">
          <div class="col-lg-6">
            <div class="card">
              <div class="card-header border-0">
                <div class="d-flex justify-content-between">
                  <h3 class="card-title"><strong>Sales Growth</strong></h3>
                </div>
              </div>
                <graphic :passing="userInfo"></graphic>
            </div>
            <!-- /.card -->

            <div class="card">
              <div class="card-header border-0">
                <h3 class="card-title"><strong>Best Seller Products</strong></h3>
              </div>
              <div class="card-body table-responsive p-0">
                <table class="table table-striped table-valign-middle">
                  <thead>
                  <tr>
                    <th>Product</th>
                    <th>Price</th>
                    <th>Sales</th>
                  </tr>
                  </thead>
                  <tbody>
                  <tr v-for="a in best_seller" :key="a.id" :value="a.id">
                      <td>
                        {{a.item_name}}
                      </td>
                      <td>Rp. {{a.item_buy_price}}</td>
                      <td>
                        <!-- <small class="text-success mr-1">
                          <i class="fas fa-arrow-up"></i>
                          12%
                        </small> -->
                        {{a.total}} Sold
                      </td>
                  </tr>
                  </tbody>
                </table>
              </div>
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col-md-6 -->
          <div class="col-lg-6">
            <div class="card">
              <div class="card-header border-0">
                <div class="d-flex justify-content-between">
                  <h3 class="card-title"><strong>Sales</strong></h3>
                </div>
              </div>               
                  <sales-graphic :passing="userInfo"></sales-graphic>
            </div>
            <!-- /.card -->

          <div class="card">
              <div class="card-header">
                <h3 class="card-title"><strong>Recently Added Products</strong></h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body p-0">
                <ul class="products-list product-list-in-card pl-2 pr-2">
                  <li class="item" v-for="a in items" :key="a.id" :value="a.id">
                    <div class="product-info">
                      <a href="javascript:void(0)" class="product-title">{{a.item_name}}
                        <span class="badge badge-success float-right">Rp. {{ (a.item_sell_price).toLocaleString('en') }}</span></a>
                      <span class="product-description">
                        {{a.item_desc}}
                      </span>
                    </div>
                  </li>
                </ul>
              </div>
            </div>
          </div>
          <!-- /.col-md-6 -->
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </div>
    </div>
</template>

<script src="https://unpkg.com/vue"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.1/Chart.min.js"></script>
<script src="https://unpkg.com/vue-chartjs/dist/vue-chartjs.min.js"></script>

<script>
    import LineChart from './graphic'

    export default {
      components: {
      LineChart
    },
      props: ['userInfo'],
        data(){
            return{
                maintainAspectRatio: true,

                loading: false,
                disabled: false,
                transactions: {},
                items : {},
                omset : {},
                period : {},
                dates : {},
                times : {},
                sold_product : {},
                best_seller : [],
                turn_over : {},
            };  
        },
        methods:{
            date(){
                var months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
                var days = ['Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday'];
                var date = new Date();

                this.period= months[date.getMonth()] + ' ' + date.getFullYear();

                this.dates= days[date.getDay()-1] + ', ' + date.getDate() + ' ' + months[date.getMonth()] + ' ' + date.getFullYear();
            },
            new_clock(){
                var date = new Date();
                var hour = (date.getHours()<10?'0':'') + date.getHours();
                var minutes = (date.getMinutes()<10?'0':'') + date.getMinutes(); 
                var seconds = (date.getSeconds()<10?'0':'') + date.getSeconds(); 

                if(hour>11){
                  this.times= hour + " : " + minutes + " : " + seconds + " PM" ;
                }else{
                  this.times= hour + " : " + minutes + " : " + seconds + " AM" ;
                }
            },
            async loadData(){
               //Contoh get Data dari Database 
                //untuk panggil progress bar
                this.$Progress.start();

                // untuk call route yang ada di api.php>> bisa call controller untuk get data dari database
                // await axios
                //     .get('api/getTransactionData')
                //     .then(({data}) => (this.transactions = data));

                await axios
                    .get('api/getItem/'+this.userInfo.id)
                    .then(({data}) => (this.items = data));

                this.items=this.items.sort((a,b) =>{
                    return b.id - a.id;
                } );

                await axios
                    .get('api/getSale/'+this.userInfo.id)
                    .then(({data}) => (this.omset = data));
                
                await axios
                      .get('api/userTurnOver/'+this.userInfo.id)
                      .then(({data}) => (this.turn_over = data));
                
                await axios
                    .get('api/getSoldProduct/'+this.userInfo.id)
                    .then(({data}) => (this.sold_product = data));

                await axios
                      .get('api/getBestSeller/'+this.userInfo.id)
                      .then(({data}) => (this.best_seller = Object.values(data)));

                this.best_seller=this.best_seller.sort((a,b) =>{
                    return b.total - a.total;
                } );
                //untuk mengakhiri progress bar setelah halaman muncul
                this.$Progress.finish();
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
            },
        },
        mounted(){
            setInterval(this.new_clock,1000);
            setInterval(this.date,1000);
        },
        created(){
            this.date();
            this.new_clock();
            this.loadData();
            Fire.$on('refreshData',() => {
                this.loadData();
            })
        }

    }
</script>