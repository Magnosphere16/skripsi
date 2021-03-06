<!DOCTYPE html>

<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">
<head>
    @include('Template.head')
    <title>KassaKu</title>
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper" id="app">
  <!-- Navbar -->
    @include('Template.navbar')
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="/home" class="brand-link">
      <i class="fas fa-cubes"></i><span class="brand-text font-weight-light"><strong> KassaKu</strong></span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <!-- <div class="image">
          <img src="dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
        </div> -->
        <div class="info">
          <router-link to="profile" hashid="{{Auth::user()->id}}" class="d-block" onclick="homeHide()">{{ Auth::user()->userName }}</router-link>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item menu-open">
            <a href="#" class="nav-link active">
              <p>
                Menu
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <router-link to="/target" class="nav-link" onclick="homeHide()">
                  <i class="fas fa-bullseye white"></i>
                  <p>Turnover Targeting</p>
                </router-link>
              </li>
              <li class="nav-item">
                <router-link to="/items" class="nav-link" onclick="homeHide()">
                  <i class="fas fa-archive blue"></i>
                  <p>Manage Products</p>
                </router-link>
              </li>
              <!-- <li class="nav-item menu-open">
                <router-link to="purchase_transactions" class="nav-link">
                  <i class="fas fa-shopping-cart green"></i>
                  <p>Purchase Transactions</p>
                </router-link>
              </li> -->
              <li class="nav-item menu-open">
                <router-link to="/sale_transactions" class="nav-link" onclick="homeHide()">
                  <i class="fas fa-cart-arrow-down red"></i>
                  <p>Transactions</p>
                </router-link>
              </li>
              <li class="nav-item">
                  <a href="{{ route('logout') }}" class="nav-link" onclick="event.preventDefault(); 
                      document.getElementById('logout-form').submit();">
                        <i class="fas fa-sign-out-alt grey"></i>
                        <p>Logout</p>
                  </a>
                  <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                      @csrf
                  </form>
                </li>
            </ul>
          </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    
    <!-- Main content -->
    <div class="content">
    <!-- ./wrapper -->
    @if (Request::is('home') )
        <div id="home">
          <home :user-info="{{Auth::user()}}"></home>
        </div>
    @endif 
         <router-view :user-info="{{Auth::user()}}"></router-view>
         <vue-progress-bar></vue-progress-bar>
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  @include('Template.footer')
  <!-- Main Footer -->
</div>
<!-- ./wrapper -->


<!-- REQUIRED SCRIPTS -->
@include('Template.vueScript')

</body>
</html>
<script>
      function homeHide(){
        document.getElementById("home").style.display="none";
      };
</script>