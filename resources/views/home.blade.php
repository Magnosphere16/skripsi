<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">
<head>
    @include('Template.head')
    <title>StockInFlow</title>
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">

<p>My Name IS Test</p>

  <!-- Navbar -->
    @include('Template.navbar')
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
    @include('Template.sidebar')


  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper" id="app">
        <new-component></new-component>
    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">

      </div>
      <!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!-- Main Footer -->
    @include('Template.footer')
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->
@include('Template.vueScript')

</body>
</html>
