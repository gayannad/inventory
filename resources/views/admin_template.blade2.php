<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Siegman Lanka Inventory</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

    <!-- Scripts -->
    <script src="{{ asset('js/angular.min.js') }}"></script>
    <script src="{{ asset('js/sweetalert.min.js') }}"></script>
    {{--<script src="{{ asset('js/app.js') }}"></script>--}}
    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <script src="{{ asset('js/date.js') }}"></script>
    <script src="{{ asset('js/jquery-ui.js') }}"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/adminlte.min.js') }}"></script>
    <script src="{{ asset('js/bootbox.min.js') }}"></script>
    <script src="{{ asset('js/jquery.table2excel.min.js') }}"></script>
    <script src="{{ asset('js/jquery.tabletoCSV.js') }}"></script>
    <script src="{{ asset('js/jquery.dataTables.min.js') }}"></script>


    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/css.css') }}" rel="stylesheet">
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet">
    <link href="{{ asset('css/jquery-ui.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/AdminLTE.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/ionicons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/skin-blue.min.css') }}">

    <!--    fonts-->
    <link href="{{ asset('css/fa-brands.css') }}" rel="stylesheet">
    <link href="{{ asset('css/fa-regular.css') }}" rel="stylesheet">
    <link href="{{ asset('css/fa-solid.css') }}" rel="stylesheet">
    <link href="{{ asset('css/font-awesome.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/fontawesome-all.css') }}" rel="stylesheet">
    <link href="{{ asset('fonts/fontawesome-webfont.woff2') }}" rel="stylesheet">


</head>

<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper" id="app">
@guest
@else
    <!-- Main Header -->
        <header class="main-header">

            <!-- Logo -->
            <a href="#" class="logo">
                <!-- mini logo for sidebar mini 50x50 pixels -->
                <span class="logo-mini font-weight-bold"><b>B</b>I</span>
                <!-- logo for regular state and mobile devices -->
                <span class="logo-lg text-black font-weight-bold"><b>Siegman Lanka</b> </span>
            </a>

            <!-- Header Navbar -->
            <nav class="navbar navbar-static-top" role="navigation">
                <!-- Sidebar toggle button-->
                <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
                    <span class="sr-only">Toggle navigation</span>
                </a>
                <!-- Navbar Right Menu -->
                <div class="navbar-custom-menu">
                    <ul class="nav navbar-nav">
                        <!-- Messages: style can be found in dropdown.less-->

                        <!-- User Account Menu -->
                        <li class="dropdown user-menu">
                            <!-- Menu Toggle Button -->
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <!-- The user image in the navbar-->
                                @if(Auth::user()->img_url != null)
                                    <img src="../uploads/users/{{Auth::user()->img_url}}" class="user-image"
                                         alt="User Image">
                                @else
                                    <img src="{{ asset('images/user.png')}}" class="user-image" alt="User Image">
                            @endif
                            <!-- hidden-xs hides the username on small devices so only the image appears. -->
                                <span class="hidden-xs">{{\Illuminate\Support\Facades\Auth::user()->first_name}}</span>
                            </a>
                            <ul class="dropdown-menu">
                                <!-- The user image in the menu -->
                                <li class="user-header">
                                    @if(Auth::user()->img_url != null)
                                        <img src="../uploads/users/{{Auth::user()->img_url}}" class="user-image"
                                             alt="User Image">
                                    @else
                                        <img src="{{ asset('images/user.png')}}" class="user-image" alt="User Image">
                                    @endif

                                    <p>
                                        {{\Illuminate\Support\Facades\Auth::user()->first_name}}
                                    </p>
                                </li>
                                <!-- Menu Body -->

                                <!-- Menu Footer-->
                                <li class="user-footer">
                                    <div class="pull-left">
                                        <a href="/user/profile" class="btn btn-default btn-flat">Profile</a>
                                    </div>
                                    <div class="pull-right">
                                        <a href="/logout" class="btn btn-default btn-flat">Sign out</a>
                                    </div>
                                </li>
                            </ul>
                        </li>
                        <!-- Control Sidebar Toggle Button -->

                    </ul>
                </div>
            </nav>
        </header>
        <!-- Left side column. contains the logo and sidebar -->
        <aside class="main-sidebar">

            <!-- sidebar: style can be found in sidebar.less -->
            <section class="sidebar">

                <!-- Sidebar user panel (optional) -->
                <div class="user-panel">
                    <div class="pull-left image">
                        @if(Auth::user()->img_url != null)
                            <img src="../uploads/users/{{Auth::user()->img_url}}" class="img-circle" alt="User Image">
                        @else
                            <img src="{{ asset('images/user.png')}}" class="img-circle" alt="User Image">
                        @endif
                    </div>
                    <div class="pull-left info">
                        <p>{{Auth::user()->first_name}}</p>
                        <!-- Status -->
                        <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
                    </div>
                </div>


                <!-- Sidebar Menu -->
                <ul class="sidebar-menu" data-widget="tree" id="sm">

                    <!-- Optionally, you can add icons to the links -->
                    <li class="active font-weight-bold"><a href="/home"><i class="fa fa-bars"></i>
                            <span>Dashboard</span></a></li>
                    <li class="active font-weight-bold"><a href="/user/list"><i class="fa fa-user"></i>
                            <span>User</span></a></li>
                    <li class="active font-weight-bold"><a href="/location/index"><i class="fa fa-map-marker"></i>
                            <span>Location</span></a>
                    </li>
                    <li class="active font-weight-bold"><a href="/product/index"><i class="fa fa-cubes"></i> <span>Product</span></a>
                    </li>
                    <li class="active font-weight-bold"><a href="/supplier/index"><i class="fa fa-truck"></i> <span>Supplier</span></a>
                    </li>
                    <li class="active font-weight-bold"><a href="/po/index"><i class="fa fa-credit-card"></i> <span>Purchase Order</span></a>
                    </li>
                    <li class="active font-weight-bold"><a href="/grn/index"><i class="fa fa-arrow-circle-down"></i>
                            <span>Good Receive Note</span></a></li>
                    <li class="active font-weight-bold"><a href="/gtn/index"><i class="fa fa-arrow-circle-up"></i>
                            <span>Good Transfer Note</span></a>
                    </li>
                    <li class="active font-weight-bold"><a href="/invoice/index"><i class="fa fa-receipt"></i> <span>Invoice</span></a>
                    </li>
                    <li class="active font-weight-bold"><a href="/return/index"><i class="fa fa-reply-all"></i> <span>Return</span></a>
                    </li>
                    <li class="active font-weight-bold"><a href="/reports/index"><i class="fa fa-line-chart"></i> <span>Reports</span></a>
                    </li>
                    <li class="treeview font-weight-bold">
                        <a href="#"><i class="fa fa-align-center "></i> <span>Administration</span>
                            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
                </span>
                        </a>
                        <ul class="treeview-menu">
                            <li><a href="/user/role/create">User Role</a></li>
                            <li><a href="/user/permission">User Permission</a></li>
                        </ul>
                    </li>
                </ul>
                <!-- /.sidebar-menu -->
            </section>
            <!-- /.sidebar -->
        </aside>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
        {{--<section class="content-header">--}}
        {{--<h1>--}}
        {{--Page Header--}}
        {{--<small>Optional description</small>--}}
        {{--</h1>--}}
        {{--<ol class="breadcrumb">--}}
        {{--<li><a href="#"><i class="fa fa-dashboard"></i> Level</a></li>--}}
        {{--<li class="active">Here</li>--}}
        {{--</ol>--}}
        {{--</section>--}}

        <!-- Main content -->
            <section class="content container-fluid">
            @yield('content')
            <!--------------------------
             | Your Page Content Here |
             -------------------------->

            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->

        <!-- Main Footer -->
        <footer class="main-footer">
            <!-- To the right -->

            <!-- Default to the left -->
            <strong>Copyright &copy; 2023 <a href="#">Siegmanlanka</a>.</strong> All rights reserved.
        </footer>


        <!-- /.control-sidebar -->
        <!-- Add the sidebar's background. This div must be placed
    immediately after the control sidebar -->
        <div class="control-sidebar-bg"></div>
    @endguest
</div>
<style>

    #sm li:hover {
        color: red;
    }
</style>
</body>
</html>