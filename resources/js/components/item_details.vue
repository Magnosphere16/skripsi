<template>
        <div class="container">

    <!-- Portfolio Item Heading -->
    <h1 class="my-4">
        <strong>{{item_info.item_name}}</strong>
    </h1>
  
    <!-- Portfolio Item Row -->
    <div class="row">
  
      <div class="col-md-4">
        <img class="img-fluid" src="https://via.placeholder.com/500x300" alt="">
      </div>
      <div class="col-md-8">
        <h3 class="my-3">Project Description</h3>
        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam viverra euismod odio, gravida pellentesque urna varius vitae. Sed dui lorem, adipiscing in adipiscing et, interdum nec metus. Mauris ultricies, justo eu convallis placerat, felis enim.</p>
        <h3 class="my-3">Project Details</h3>
        <ul>
          <li>Lorem Ipsum</li>
          <li>Dolor Sit Amet</li>
          <li>Consectetur</li>
          <li>Adipiscing Elit</li>
        </ul>
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
