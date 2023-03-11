<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{asset('css/all.min.css')}}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Tempusdominus Bbootstrap 4 -->
    <link rel="stylesheet" href="{{asset('css/tempusdominus-bootstrap-4.min.css')}}">
    <!-- iCheck -->
    <link rel="stylesheet" href="{{asset('css/icheck-bootstrap.min.css')}}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{asset('css/adminlte.min.css')}}">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="{{asset('css/OverlayScrollbars.min.css')}}">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="{{asset('css/daterangepicker.css')}}">
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('css/gijgo.min.css')}}">

    <!-- jQuery -->
    <script src="{{asset('/js/jquery.min.js')}}"></script>
    <!-- jQuery UI 1.11.4 -->
    <script src="{{asset('/js/jquery-ui.min.js')}}"></script>
    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    <script>
        $.widget.bridge('uibutton', $.ui.button)
    </script>
    <script src="{{'/js/bootstrap.bundle.min.js'}}"></script>

    <script src="{{'/js/moment.min.js'}}"></script>
    <script src="{{asset('/js/daterangepicker.js')}}"></script>
    <script src="{{asset('/js/tempusdominus-bootstrap-4.min.js')}}"></script>

    <script src="{{asset('/js/OverlayScrollbars.min.js')}}"></script>
    <script src="{{asset('/js/adminlte.js')}}"></script>

    <script src="{{asset('/js/demo.js')}}"></script>
    <script src="{{asset('/js/bootbox.min.js')}}"></script>
    <script src="{{asset('/js/bootbox.all.min.js')}}"></script>
    <script src="{{asset('/js/bootbox.locales.min.js')}}"></script>
    <script src="{{asset('/js/sweetalert2@9.js')}}"></script>
    <script src="{{asset('/js/sweetalert2.all.min.js')}}"></script>
    <script src="{{asset('/js/gijgo.min.js')}}"></script>
    <script src="{{asset('/js/angular.min.js')}}"></script>
    <script src="{{asset('/js/jquery.tabletoCSV.js')}}"></script>
    <script src="{{asset('/js/date.js')}}"></script>
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

    <!-- Preloader -->
    <div class="preloader flex-column justify-content-center align-items-center">
        <img class="animation__shake" src="dist/img/AdminLTELogo.png">
    </div>

    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
        <!-- Left navbar links -->
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
            </li>
        </ul>
        <div class="card-body">

            <div class="row" style="height: 70px">

                <div class="col-md-4">
                    <div class="info-box">
                        <span class="info-box-icon bg-info elevation-1"><a href="https://lndinventory.com/stock_in.php"><i
                                        class="fas fa-cubes"></i></a></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Stock</span>
                            <span class="info-box-number">Rs.0.00</span>

                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>


                <div class="col-md-4">

                    <div class="info-box">

                        <span class="info-box-icon bg-danger elevation-1"> <a href="https://lndinventory.com/issue.php"><i
                                        class="fas fa-shipping-fast"></i></a></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Issues</span>
                            <span class="info-box-number">Rs. 0.00</span>


                        </div>
                        <!-- /.info-box-content -->
                    </div>

                </div>

                <div class="col-md-4">


                    <div class="info-box">
                        <span class="info-box-icon bg-success elevation-1"><a href="https://lndinventory.com/sales.php"><i
                                        class="fas fa-shopping-cart"></i></a></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Sales</span>
                            <span class="info-box-number">Rs. 0.00</span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>


                </div>

                {{--                <div class="col-md-3">--}}

                {{--                    <div class="info-box">--}}
                {{--                        <span class="info-box-icon bg-warning elevation-1"><a href="https://lndinventory.com/commission.php"><i class="fa fa-users"></i></a></span>--}}

                {{--                        <div class="info-box-content">--}}
                {{--                            <span class="info-box-text">Users</span>--}}
                {{--                            <span class="info-box-number">10</span>--}}

                {{--                        </div>--}}
                {{--                        <!-- /.info-box-content -->--}}
                {{--                    </div>--}}

                {{--                </div>--}}

            </div>
        </div>
    </nav>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <!-- Brand Logo -->
        <a href="index3.html" class="brand-link">
            <img src="{{asset('images/Sigman.png')}}" alt="AdminLTE Logo" class="brand-image  elevation-3"
                 style="opacity: .8">
            <span class="brand-text font-weight-light">Inventory</span>
        </a>

        <!-- Sidebar -->
        <div class="sidebar">

            <!-- Sidebar Menu -->
            <nav class="mt-2">
                <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <div class="image">
                        <i class="nav-icon fas fa-user"></i>
                    </div>
                    <div class="info">
                        <a href="#" class="d-block">{{Auth::user()->first_name}}</a>
                    </div>
                </div>
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                    data-accordion="false">
                    <li class="">
                        <a href="/home" class="nav-link">
                            <i class="nav-icon fas fa-tachometer-alt"></i>
                            <p>
                                Dashboard
                            </p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-users"></i>
                            <p>
                                Users
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="/user/create" class="nav-link">
                                    <i class="nav-icon fas fa-user-plus"></i>
                                    <p>User Register</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="/user/list" class="nav-link">
                                    <i class="nav-icon fas fa-list"></i>
                                    <p>User List</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-location-arrow"></i>
                            <p>
                                Location
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="/location/create" class="nav-link">
                                    <i class="nav-icon fas fa-plus-circle"></i>
                                    <p>Location Register</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="/location/index" class="nav-link">
                                    <i class="nav-icon fas fa-list"></i>
                                    <p>Location List</p>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-truck-moving"></i>
                            <p>
                                Supplier
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="/supplier/create" class="nav-link">
                                    <i class="nav-icon fas fa-plus-circle"></i>
                                    <p>Supplier Register</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="/supplier/index" class="nav-link">
                                    <i class="nav-icon fas fa-list"></i>
                                    <p>Supplier List</p>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-cube"></i>
                            <p>
                                Item
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="/product/create" class="nav-link">
                                    <i class="nav-icon fas fa-plus-circle"></i>
                                    <p>Item Register</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="/product/list" class="nav-link">
                                    <i class="nav-icon fas fa-list"></i>
                                    <p>Item List</p>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-cube"></i>
                            <p>
                                Stock
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="/stock/add" class="nav-link">
                                    <i class="nav-icon fas fa-download"></i>
                                    <p>Stock In</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="/stock/list" class="nav-link">
                                    <i class="nav-icon fas fa-list"></i>
                                    <p>Stock In List</p>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-cube"></i>
                            <p>
                                Issues and Sales
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="/issues/create" class="nav-link">
                                    <i class="nav-icon fas fa-truck"></i>
                                    <p>Issues</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="/issues/list" class="nav-link">
                                    <i class="nav-icon fas fa-list"></i>
                                    <p>Issues List</p>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a href="/invoice/create" class="nav-link">
                                    <i class="nav-icon fas fa-dollar-sign"></i>
                                    <p>Sales</p>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a href="/invoice/list" class="nav-link">
                                    <i class="nav-icon fas fa-list"></i>
                                    <p>Sales List</p>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-chart-line"></i>
                            <p>
                                Reports
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="/reports/stock" class="nav-link">
                                    <i class="nav-icon fas fa-file"></i>
                                    <p>Main Stock</p>
                                </a>
                            </li>
                            <!--<li class="nav-item">-->
                            <!--    <a href="/reports/valuation" class="nav-link">-->
                            <!--        <i class="nav-icon fas fa-file"></i>-->
                            <!--        <p>Stock Value</p>-->
                            <!--    </a>-->
                            <!--</li>-->
                            <li class="nav-item">
                                <a href="/reports/stockSupplier" class="nav-link">
                                    <i class="nav-icon fas fa-file"></i>
                                    <p>Stock by Supplier</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="/reports/stockLocation" class="nav-link">
                                    <i class="nav-icon fas fa-file"></i>
                                    <p>Stock by Location</p>
                                </a>
                            </li>
                            {{--                            <li class="nav-item">--}}
                            {{--                                <a href="/reports/salesReport" class="nav-link">--}}
                            {{--                                    <i class="nav-icon fas fa-file"></i>--}}
                            {{--                                    <p>Sales Report</p>--}}
                            {{--                                </a>--}}
                            {{--                            </li>--}}
                        </ul>
                    </li>

                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-wrench"></i>
                            <p>
                                Settings
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="/user/role/create" class="nav-link">
                                    <i class="nav-icon fas fa-user-check"></i>
                                    <p>User Role</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="/user/permission" class="nav-link">
                                    <i class="nav-icon fas fa-user-lock"></i>
                                    <p>User Permission</p>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li class="">
                        <a href="/logout" class="nav-link">
                            <i class="nav-icon fas fa-sign-out-alt"></i>
                            <p>
                                Logout
                            </p>
                        </a>
                    </li>

                </ul>
            </nav>
            <!-- /.sidebar-menu -->
        </div>
        <!-- /.sidebar -->
    </aside>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper mt-2">
        @yield('content')
    </div>
    <!-- /.content-wrapper -->
    <footer class="main-footer">
        <strong>Copyright &copy; 2023 <a href="https://adminlte.io">Siegmanlanka</a>.</strong>
        All rights reserved.
        <div class="float-right d-none d-sm-inline-block">
            <b>Version</b> 1.0
        </div>
    </footer>

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
        <!-- Control sidebar content goes here -->
    </aside>
    <!-- /.control-sidebar -->
</div>


<script>

    var url = window.location;

    // for sidebar menu entirely but not cover treeview
    $('ul.nav-sidebar a').filter(function () {
        return this.href == url;
    }).addClass('active');

    // for treeview
    $('ul.nav-treeview a').filter(function () {
        return this.href == url;
    }).parentsUntil(".nav-sidebar > .nav-treeview").addClass('menu-open').prev('a').addClass('active');
</script>


</body>
</html>
