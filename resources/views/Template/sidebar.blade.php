<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="/home" class="brand-link">
      <i class="fas fa-cubes"></i><span class="brand-text font-weight-light"> KassaKu</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <!-- <div class="image">
          <img src="dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
        </div> -->
        <div class="info">
          <router-link to="profile" hashid="{{Auth::user()->id}}" class="d-block">{{ Auth::user()->userName }}</router-link>
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
                <router-link to="prediction" class="nav-link">
                  <i class="fas fa-bullseye red"></i>
                  <p>Revenue Targeting</p>
                </router-link>
              </li>
              <li class="nav-item">
                <router-link to="items" class="nav-link">
                  <i class="fas fa-archive blue"></i>
                  <p>Manage Items</p>
                </router-link>
              </li>
              <!-- <li class="nav-item menu-open">
                <router-link to="purchase_transactions" class="nav-link">
                  <i class="fas fa-shopping-cart green"></i>
                  <p>Purchase Transactions</p>
                </router-link>
              </li> -->
              <li class="nav-item menu-open">
                <router-link to="sale_transactions" class="nav-link">
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