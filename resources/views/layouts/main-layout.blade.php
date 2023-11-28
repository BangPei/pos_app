<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="csrf-token" content="{{ csrf_token() }}" />
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="icon" href="{{ asset('image/logo/logo.png') }}">
        <title>POS App | {{ $title }}</title>

        <!-- Google Font: Source Sans Pro -->
        <link rel="stylesheet" href="/font.css">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="/plugins/fontawesome-free/css/all.min.css">
        <!-- Ionicons -->
        <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">

        <link rel="stylesheet" href="/plugins/jquery-ui/jquery-ui.min.css">
        <!-- overlayScrollbars -->
        <link rel="stylesheet" href="/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
        <link rel="stylesheet" href="/plugins/select2/css/select2.min.css">
        <link rel="stylesheet" href="/plugins/toastr/toastr.css">
        <link href="/plugins/bootstrap-datepicker/css/bootstrap-datepicker.css" rel="stylesheet" type="text/css" />
        
        {{-- <link href="/plugins/gijgo/css/gijgo.css" rel="stylesheet" type="text/css" /> --}}
        @yield('content-class')
        <link rel="stylesheet" href="/dist/css/adminlte.min.css">
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
                        <li class="nav-item {{ (Request::is('supplier*')|| Request::is('stock*')|| Request::is('bank*')||Request::is('payment*')||Request::is('product*')||Request::is('category*')||Request::is('uom*'))?'menu-open':'' }}">
                            <a href="#" class="nav-link ">
                                <i class="nav-icon fas fa-th"></i>
                                <p>
                                    Master
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview pl-2">
                                {{-- <li class="nav-item">
                                    <a href="/product" class="nav-link {{Request::is('product*')?'active':''}}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Barang</p>
                                    </a>
                                </li> --}}
                                <li class="nav-item">
                                    <a href="/stock" class="nav-link {{Request::is('stock*')?'active':''}}">
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
                                <li class="nav-item">
                                    <a href="/supplier" class="nav-link {{Request::is('supplier*')?'active':''}}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Supplier</p>
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
                            <ul class="nav nav-treeview pl-2">
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
                        <li class="nav-item {{ (Request::is('purchase-order*'))?'menu-open':'' }}">
                            <a href="#" class="nav-link ">
                                <i class="nav-icon far fa-money-bill-alt"></i>
                                <p>
                                    Aplikasi Pembelian
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview pl-2">
                                <li class="nav-item">
                                    <a href="/purchase-order/create" class="nav-link {{Request::is('purchase-order/create')?'active':''}}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Pembelian</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="/purchase-order" class="nav-link {{Request::is('purchase-order')?'active':''}}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Detail Pembelian</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item {{ (Request::is('multiple-discount*'))?'menu-open':'' }}">
                            <a href="#" class="nav-link ">
                                <i class="nav-icon fa fa-tag"></i>
                                <p>
                                    Diskon
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview pl-2">
                                <li class="nav-item">
                                    <a href="/multiple-discount" class="nav-link {{Request::is('multiple-discount*')?'active':''}}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Paket Diskon</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Promo Toko</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-header">Laporan</li>
                        <li class="nav-item {{ (Request::is('report*'))?'menu-open':'' }}">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-folder-open"></i>
                                <p>Laporan Penjualan <i class="right fas fa-angle-left"></i></p>
                            </a>
                            <ul class="nav nav-treeview pl-2">
                                <li class="nav-item">
                                    <a href="/report/hourly" class="nav-link {{Request::is('report/hourly')?'active':''}}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Perjam</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="/report/daily" class="nav-link {{Request::is('report/daily')?'active':''}}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Harian</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="/report/monthly" class="nav-link {{Request::is('report/monthly')?'active':''}}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Bulanan</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="/report/yearly" class="nav-link {{Request::is('report/yearly')?'active':''}}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Tahunan</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-header">Setting</li>
                        <li class="nav-item">
                            <a href="/user" class="nav-link">
                                <i class="nav-icon far fa-user"></i>
                                <p>User</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/setting" class="nav-link {{Request::is('setting')?'active':''}}">
                                <i class="nav-icon fa fa-cogs"></i>
                                <p>Pengaturan</p>
                            </a>
                        </li>
                        <li class="nav-header">Online Shop</li>
                        <li class="nav-item">
                            <a href="/platform" class="nav-link">
                                <i class="nav-icon fa fa-shopping-bag"></i>
                                <p>Platform</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/expedition" class="nav-link">
                                <i class="nav-icon fa fa-truck"></i>
                                <p>Expedisi</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/daily-task" class="nav-link {{Request::is('daily-task*')?'active':''}}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Tugas Harian</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/search-task" class="nav-link {{Request::is('search-task*')?'active':''}}">
                                <i class="fa fa-search nav-icon"></i>
                                <p>Pencarian</p>
                            </a>
                        </li>
                        {{-- <li class="nav-item {{ (Request::is('daily-task*')) || (Request::is('expedition*'))?'menu-open':'' }}">
                            <a href="#" class="nav-link {{Request::is('expedition')?'active':''}}">
                                <i class="nav-icon fa fa-barcode"></i>
                                <p>
                                    Tugas Harian
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="/daily-task/create" class="nav-link {{Request::is('daily-task/create')?'active':''}}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Buat Tugas Harian</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="/daily-task" class="nav-link {{Request::is('daily-task*')?'active':''}}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Detail Tugas Harian</p>
                                    </a>
                                </li>
                            </ul>
                        </li> --}}
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
        <script src="/plugins/jquery-ui/jquery-ui.min.js"></script>
        <script src="/plugins/bootstrap/js/bootstrap.bundle.min.js"></script> 
        <script src="/plugins/jquery-validation/jquery.validate.min.js"></script>
        <script src="/plugins/jquery-validation/additional-methods.min.js"></script>
        <script src="/plugins/select2/js/select2.js"></script>
        <script src="/plugins/toastr/toastr.min.js"></script>
        <script src="/plugins/jquery-mask/jquery.mask.min.js"></script>
        <script src="/dist/js/adminlte.js"></script>
        <script src="/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js" type="text/javascript"></script>
        
        {{-- <script src="/plugins/gijgo/js/gijgo.js" type="text/javascript"></script> --}}
        <script src="/js/script.js"></script>
        @yield('content-script')
        <!-- AdminLTE App -->
    </body>
</html>
