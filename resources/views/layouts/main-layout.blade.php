<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>POS App | {{ $title }}</title>

        <!-- Google Font: Source Sans Pro -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="/plugins/fontawesome-free/css/all.min.css">
        <!-- Ionicons -->
        <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">

        <link rel="stylesheet" href="/dist/css/adminlte.min.css">
        <!-- overlayScrollbars -->
        <link rel="stylesheet" href="/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
        <link rel="stylesheet" href="/plugins/select2/css/select2.min.css">
        <link rel="stylesheet" href="/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
        @yield('content-class')
    </head>
    <body class="hold-transition sidebar-mini layout-fixed">
        <div class="wrapper">

            <!-- Preloader -->
            <!-- <div class="preloader flex-column justify-content-center align-items-center">
                <img class="animation__shake" src="dist/img/AdminLTELogo.png" alt="AdminLTELogo" height="60" width="60">
            </div> -->

            <!-- Navbar -->
            <nav class="main-header navbar navbar-expand navbar-white navbar-light">
                <!-- Left navbar links -->
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" data-widget="pushmenu" href="javascript.void(0)" role="button"><i class="fas fa-bars"></i></a>
                    </li>
                </ul>

                <!-- Right navbar links -->
                <ul class="navbar-nav ml-auto">
                <!-- Notifications Dropdown Menu -->
                    <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-expanded="false">
                                {{ auth()->user()->name }}
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <li>
                                    <a class="dropdown-item" href="#">
                                        <i class="fas fa-user text-primary"></i> Profile
                                    </a>
                                    <form action="/logout" method="post">
                                        @csrf
                                        <button type="submit" class="dropdown-item">
                                            <i class="fas fa-sign-out-alt text-danger"></i> Logout
                                        </button>
                                    </form>
                                </li>
                            </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                            <i class="fas fa-expand-arrows-alt"></i>
                        </a>
                    </li>
                </ul>
            </nav>
            <!-- /.navbar -->

            <!-- Main Sidebar Container -->
            <aside class="main-sidebar sidebar-dark-primary elevation-4">
                <!-- Brand Logo -->
                <a href="/" class="brand-link">
                    <img src="/dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
                    <span class="brand-text font-weight-light">Toko SS</span>
                </a>

                <!-- Sidebar -->
                <div class="sidebar">
                <!-- Sidebar user panel (optional) -->
                <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <div class="image">
                        <img src="/dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
                    </div>
                    <div class="info">
                        <a href="#" class="d-block"> {{ auth()->user()->name }}</a>
                    </div>
                </div>

                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                    <!-- Add icons to the links using the .nav-icon class
                        with font-awesome or any other icon font library -->
                        <li class="nav-item">
                            <a href="/" class="nav-link  {{Request::is('/')?'active':''}}">
                                <i class="nav-icon fas fa-tachometer-alt"></i>
                                <p>Dashboard</p>
                            </a>
                        </li>
                        <li class="nav-item {{ (Request::is('bank*')||Request::is('payment*')||Request::is('product*')||Request::is('category*')||Request::is('uom*'))?'menu-open':'' }}">
                            <a href="#" class="nav-link ">
                                <i class="nav-icon fas fa-th"></i>
                                <p>
                                    Master
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="/product" class="nav-link {{Request::is('product*')?'active':''}}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Barang</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="/category" class="nav-link {{Request::is('category*')?'active':''}}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Kategori</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="/uom" class="nav-link {{Request::is('uom*')?'active':''}}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Satuan</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="/payment" class="nav-link {{Request::is('payment*')?'active':''}}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Tipe Pembayaran</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="/bank" class="nav-link {{Request::is('bank*')?'active':''}}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Bank</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item {{ (Request::is('transaction*'))?'menu-open':'' }}">
                            <a href="#" class="nav-link ">
                                <i class="nav-icon far fa-money-bill-alt"></i>
                                <p>
                                    Aplikasi Kasir
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="/transaction/create" class="nav-link {{Request::is('transaction/create')?'active':''}}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Penjualan</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="/transaction" class="nav-link {{Request::is('transaction')?'active':''}}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Detail Penjualan</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-header">User</li>
                        <li class="nav-item">
                            <a href="/user" class="nav-link">
                                <i class="nav-icon far fa-user"></i>
                                <p>User</p>
                            </a>
                        </li>
                        <li class="nav-header">EXAMPLES</li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon far fa-calendar-alt"></i>
                                <p>Calendar</p>
                            </a>
                        </li>
                    </ul>
                </nav>
                <!-- /.sidebar-menu -->
                </div>
                <!-- /.sidebar -->
            </aside>

            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                <!-- Content Header (Page header) -->
                <div class="content-header">
                    <div class="container-fluid">
                        {{-- <div class="row mb-2">
                            <div class="col-sm-6">
                                <h1 class="m-0">{{ $title }}</h1>
                            </div><!-- /.col -->
                            <div class="col-sm-6">
                                <ol class="breadcrumb float-sm-right">
                                    <li class="breadcrumb-item">{{ $menu }}</li>
                                    <li class="breadcrumb-item active">{{ $title }}</li>
                                </ol>
                            </div><!-- /.col -->
                        </div><!-- /.row --> --}}
                    </div><!-- /.container-fluid -->
                </div>
                <!-- /.content-header -->

                <!-- Main content -->
                <section class="content">
                    <div class="container-fluid">
                        <div class="row">
                            @yield('content-child')
                        </div>
                        
                    </div><!-- /.container-fluid -->
                </section>
                <!-- /.content -->
            </div>
            <!-- /.content-wrapper -->
            <footer class="main-footer">
                <strong>Copyright &copy; 2022 <a href="#">Toko SS</a>.</strong>
                All rights reserved.
                <div class="float-right d-none d-sm-inline-block">
                    <b>Version</b> 1.0.0
                </div>
            </footer>

        </div>
        <!-- ./wrapper -->

        <!-- jQuery -->
        <script src="/plugins/jquery/jquery.min.js"></script>
        <!-- Tempusdominus Bootstrap 4 -->
        <script src="/plugins/bootstrap/js/bootstrap.bundle.min.js"></script> 
        <script src="/dist/js/adminlte.js"></script>
        <script src="/plugins/jquery-validation/jquery.validate.min.js"></script>
        <script src="/plugins/jquery-validation/additional-methods.min.js"></script>
        <script src="/plugins/select2/js/select2.full.min.js"></script>
        @yield('content-script')
        <!-- AdminLTE App -->
        <script src="/js/script.js"></script>
    </body>
</html>
