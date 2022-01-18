<template>
    <div class="container">
  
    <!-- Portfolio Item Row -->
    <div class="row mt-5">
      <div class="col-md-4 mt-4">
        <img class="img-fluid" :src="item_info.item_image" alt="itemimage">
      </div>
      <div class="col-md-8">
        <h3 class="my-4">
            <strong>{{item_info.item_name}}</strong>
        </h3>
        <h1>
            <strong>Rp. {{(item_info.item_sell_price).toLocaleString('en')}}/{{item_info.unit_type.unit_type_name}}</strong>
        </h1>
        <p>{{item_info.item_desc}}</p>
        <h4 class="my-3"><strong>Details</strong></h4>
        <p id="stock">{{item_info.item_qty===0 ? 'Out of Stock' : 'Stock(s): '
                                            +item_info.item_qty+' '+item_info.unit_type.unit_type_name+' '}} <span v-if="(item_info.item_qty<=5 && item_info.item_qty>0)"><i class="fas fa-exclamation-triangle"></i></span></p>
        <p>Category: {{item_info.category.category_name}}</p>
        <p><strong>Buy Price: Rp. {{(item_info.item_sell_price).toLocaleString('en')}}</strong></p>
      </div>
  
    </div>
    <!-- /.row -->
  </div>
  <!-- /.container -->
</template>

<script src="http://code.jquery.com/jquery-3.4.1.js"></script>
<script>

</script>

<script>
     export default {
        data(){
            return{
                id:0,
                item_info : {},
            }
        },
        methods:{
            async loadData(){
                //untuk panggil progress bar
                this.$Progress.start();

                // untuk call route yang ada di api.php>> bisa call controller untuk get data dari database
                await axios
                    .get('http:/api/getItemInfo/'+this.id)
                    .then(({data}) => (this.item_info = data));
                //untuk mengakhiri progress bar setelah halaman muncul

                if(this.item_info.item_qty<=0){
                    document.getElementById("stock").style.color="red";
                }

                this.$Progress.finish();
            },
        },
        created(){
            this.id = this.$route.params.id;
            this.loadData();
        },
        mounted(){
        }
    }
</script>
