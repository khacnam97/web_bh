<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title')</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('plugins/jquery-ui/1.12.1/jquery-ui.js') }}"></script>
    <script src="{{ asset('js/sweetalert2.all.min.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('css/sweetalert2.min.css')  }}">
    <!-- AdminLTE App -->
    <script src="{{ asset('dist/js/adminlte.js')}}"></script>
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">



    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css')}}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('dist/css/adminlte.min.css')}}">
    <!-- DataTables -->
    <script src="{{ asset('plugins/datatables/jquery.dataTables.js') }}"></script>
    <script src="{{ asset('plugins/datatables-bs4/js/dataTables.bootstrap4.js') }}"></script>
    {{-- Datatable responsive --}}
    <script src="{{ asset('plugins/datatables-bs4/js/dataTables.responsive.min.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/responsive.dataTables.min.css') }}">
    <!-- Toastr -->
    <link rel="stylesheet" href="{{ asset('plugins/toastr/toastr.min.css') }}">
    <script src="{{ asset('plugins/toastr/toastr.min.js') }}" defer></script>
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/layout.css') }}" rel="stylesheet">
    @yield('custom-header')
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">
    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
        <!-- Left navbar links -->
        <ul class="navbar-nav">
            <li class="nav-item">
                <div class="page-title">@yield('title')</div>
            </li>


        </ul>
        <!-- Right navbar links -->
        <ul class="navbar-nav ml-auto">
            <!-- Navbar Search -->
            <li class="nav-item">
            <li class="nav-item dropdown">
                <a class="nav-link" data-toggle="dropdown" href="#">
                        {{Auth::user()->username}}
                        <i class="fa fa-caret-down" aria-hidden="true"></i>
                </a>
                <div class="dropdown-menu dropdown-menu dropdown-menu-right">
                    <a href="{{route('user.getProfile')}}" class="dropdown-item">
                        {{__('admin.Profile')}} <i class="fas fa-info-circle"></i>
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="{{route('getChangePassword')}}" class="dropdown-item">
                       {{__('admin.Change Password')}} <i class="fas fa-unlock-alt"></i>
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="{{route('logout')}}" class="dropdown-item">
                        {{__('admin.Sign Out')}} <i class="fas fa-sign-in-alt"></i>
                    </a>
                </div>
            </li>
        </ul>
    </nav>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <!-- Brand Logo -->
        <a href="" class="brand-link">
            <span class="brand-text font-weight-light">  {{__('admin.App.Name')}}
</span>
        </a>

        <!-- Sidebar -->
        <div class="sidebar">


            <!-- Sidebar Menu -->
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                    @php
                    $currentRoute = Route::currentRouteName();
                    @endphp

                    @if (auth()->user()->hasRole('admin'))
                    <li class="nav-item">
                        <a href="{{route('user.index')}}" class="nav-link @if ($currentRoute === 'user.index' || $currentRoute === 'user.getCreate' || $currentRoute === 'user.getEdit') active @endif">
                            <i class="nav-icon fas fa-users"></i>
                            <p>
                                {{__('user.User')}}
                            </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{route('script.index')}}" class="nav-link @if ($currentRoute === 'script.index' || $currentRoute === 'script.getCreate' || $currentRoute === 'script.getEdit') active @endif">
                            <i class="nav-icon fas fa-tasks"></i>
                            <p>
                                {{__('user.Script')}}
                            </p>
                        </a>
                    </li>
                    @endif

                </ul>
            </nav>
            <!-- /.sidebar-menu -->
        </div>
        <!-- /.sidebar -->
    </aside>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">

        <!-- Main content -->
        <section class="content" style="padding: 8px">
            <div class="container-fluid" style="padding: 8px">
                <div class="row">
                    <div class="col-12">
                        <div class="card" style="min-height: calc( 100vh - 88px); margin-bottom: 0">
                            <div class="card-body">
                                 @yield('content')
                            </div>
                        </div>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
        <!-- Control sidebar content goes here -->
    </aside>
    <!-- /.control-sidebar -->

    <script>
        let basePath = '{{ url('') }}'
    </script>
    @yield('custom-js')
</div>
<!-- ./wrapper -->

</body>
</html>
