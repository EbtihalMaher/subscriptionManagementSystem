<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
{{-- <html lang="{{LaravelLocalization::getCurrentLocale()}}"> --}}

<html lang="{{LaravelLocalization::getCurrentLocale()}}" direction="{{LaravelLocalization::getCurrentLocaleDirection()}}"
	style="direction: {{LaravelLocalization::getCurrentLocaleDirection()}};">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Laravel 12 | @yield('page-title')</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet"
    href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="{{asset('cms/plugins/fontawesome-free/css/all.min.css')}}">

  <!-- Theme style -->
  @if(LaravelLocalization::getCurrentLocale() == 'en') 
    <link rel="stylesheet" href="{{asset('cms/dist/css/adminlte.min.css')}}">
  @else
    <!-- Bootstrap 4 RTL -->
    <link rel="stylesheet" href="https://cdn.rtlcss.com/bootstrap/v4.2.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{asset('cms/dist/css/ar/adminlte.min.css')}}">
    <link rel="stylesheet" href="{{asset('cms/dist/css/ar/adminlte-rtl.css')}}">
  @endif


  <!-- Toastr -->
  <link rel="stylesheet" href="{{asset('cms/plugins/toastr/toastr.min.css')}}">
  @yield('styles')
</head>

<body class="hold-transition sidebar-mini">
  <div class="wrapper">

    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
      <!-- Left navbar links -->
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
          <a href="index3.html" class="nav-link">Home</a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
          <a href="#" class="nav-link">Contact</a>
        </li>
      </ul>

      <!-- Right navbar links -->
      <ul class="navbar-nav ml-auto">
        <!-- Navbar Search -->
        <li class="nav-item">
          <a class="nav-link" data-widget="navbar-search" href="#" role="button">
            <i class="fas fa-search"></i>
          </a>
          <div class="navbar-search-block">
            <form class="form-inline">
              <div class="input-group input-group-sm">
                <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
                <div class="input-group-append">
                  <button class="btn btn-navbar" type="submit">
                    <i class="fas fa-search"></i>
                  </button>
                  <button class="btn btn-navbar" type="button" data-widget="navbar-search">
                    <i class="fas fa-times"></i>
                  </button>
                </div>
              </div>
            </form>
          </div>
        </li>

        <li class="nav-item dropdown">
          <a class="nav-link" data-toggle="dropdown" href="#">
            <i class="far fa-bell"></i>
            <span class="badge badge-danger navbar-badge">0</span>
          </a>
          <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                @foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                  <a class="dropdown-item" rel="alternate" hreflang="{{ $localeCode }}" href="{{ LaravelLocalization::getLocalizedURL($localeCode, null, [], true) }}">
                  <!-- Message Start -->
                  <div class="media">
                    <div class="media-body">
                      <h3 class="dropdown-item-title">
                        {{ $properties['native'] }}
                      </h3>
                    </div>
                  </div>
                @endforeach
              <!-- Message End -->
            </a>
            <div class="dropdown-divider"></div>
          </div>
        </li>
        <!-- Messages Dropdown Menu -->
        <li class="nav-item dropdown">
          <a class="nav-link" data-toggle="dropdown" href="#">
            <i class="far fa-bell"></i>
            <span class="badge badge-danger navbar-badge">{{auth()->user()->unreadNotifications->count()}}</span>
          </a>
          <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
            @foreach (auth()->user()->notifications as $notification)
              <a href="#" class="dropdown-item">
              <!-- Message Start -->
              <div class="media">
                <img src="{{asset('cms/dist/img/user1-128x128.jpg')}}" alt="User Avatar" class="img-size-50 mr-3 img-circle">
                <div class="media-body">
                  <h3 class="dropdown-item-title">
                    {{$notification->data['title']}}
                    @if($notification->unread())
                    <span class="float-right text-sm text-danger"><i class="fas fa-star"></i></span>
                    {{-- {{$notification->markAsRead()}} --}}
                    @endif
                  </h3>
                  <p class="text-sm">{{$notification->data['title']}}</p>
                  <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> {{$notification->created_at->diffForHumans()}}</p>
                </div>
              </div>
              <!-- Message End -->
            </a>
            @endforeach
            <div class="dropdown-divider"></div>
            <a href="{{route('notifications.index')}}" class="dropdown-item dropdown-footer">See All Messages</a>
          </div>
        </li>
        <li class="nav-item">
          <a class="nav-link" data-widget="fullscreen" href="#" role="button">
            <i class="fas fa-expand-arrows-alt"></i>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button">
            <i class="fas fa-th-large"></i>
          </a>
        </li>
      </ul>
    </nav>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
      <!-- Brand Logo -->
      <a href="index3.html" class="brand-link">
        <img src="dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
          style="opacity: .8">
        <span class="brand-text font-weight-light">AdminLTE 3</span>
      </a>

      <!-- Sidebar -->
      <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
          <div class="image">
            <img src="dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
          </div>
          <div class="info">
            <a href="#" class="d-block">{{auth()->user()->user_name}}</a>
          </div>
        </div>

        <!-- SidebarSearch Form -->
        <div class="form-inline">
          <div class="input-group" data-widget="sidebar-search">
            <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
            <div class="input-group-append">
              <button class="btn btn-sidebar">
                <i class="fas fa-search fa-fw"></i>
              </button>
            </div>
          </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
          <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
            <li class="nav-item menu-open">
              <a href="#" class="nav-link active">
                <i class="nav-icon fas fa-tachometer-alt"></i>
                <p>
                  Starter Pages
                  <i class="right fas fa-angle-left"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="#" class="nav-link active">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Active Page</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="#" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Inactive Page</p>
                  </a>
                </li>
              </ul>
            </li>

            @canany(['Read-Roles','Create-Role','Read-Permissions'])
            <li class="nav-header">{{__('cms.roles_permissions')}}</li>
            @canany(['Create-Role', 'Read-Roles'])
            <li class="nav-item">
              <a href="#" class="nav-link">
                <i class="nav-icon fas fa-user-tag"></i>
                <p>
                  {{__('cms.roles')}}
                  <i class="fas fa-angle-left right"></i>
                </p>
              </a>
              <ul class="nav nav-treeview" style="display: none;">
                @can('Read-Roles')
                  <li class="nav-item">
                    <a href="{{route('roles.index')}}" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>{{__('cms.index')}}</p>
                    </a>
                  </li>
                @endcan
                @can('Create-Role')
                  <li class="nav-item">
                    <a href="{{route('roles.create')}}" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>{{__('cms.create')}}</p>
                    </a>
                  </li>
                @endcan
              </ul>
            </li>       
            @endcanany

            @canany(['Read-Permissions'])
             <li class="nav-item">
              <a href="#" class="nav-link">
                <i class="nav-icon fas fa-bullseye"></i>
                <p>
                  {{__('cms.permissions')}}
                  <i class="fas fa-angle-left right"></i>
                </p>
              </a>
              <ul class="nav nav-treeview" style="display: none;">
                @can('Read-Permissions')
                  <li class="nav-item">
                    <a href="{{route('permissions.index')}}" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>{{__('cms.index')}}</p>
                    </a>
                  </li>
                @endcan
              </ul>
            </li>
            @endcanany
            @endcanany

            @canany(['Read-Admins','Create-Admin','Read-Users','Create-User'])
            <li class="nav-header">{{__('cms.hr')}}</li>
            @canany(['Read-Admins','Create-Admin'])
            <li class="nav-item">
              <a href="#" class="nav-link">
                <i class="nav-icon fas fa-table"></i>
                <p>
                  {{__('cms.admins')}}
                  <i class="fas fa-angle-left right"></i>
                </p>
              </a>
              <ul class="nav nav-treeview" style="display: none;">
                @can('Read-Admins')
                <li class="nav-item">
                  <a href="{{route('admins.index')}}" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>{{__('cms.index')}}</p>
                  </a>
                </li>
                @endcan
                @can('Create-Admin')
                <li class="nav-item">
                  <a href="{{route('admins.create')}}" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>{{__('cms.create')}}</p>
                  </a>
                </li>
                @endcan
              </ul>
            </li>
            @endcanany
            @canany(['Read-Users','Create-User'])
            <li class="nav-item">
              <a href="#" class="nav-link">
                <i class="nav-icon fas fa-table"></i>
                <p>
                  {{__('cms.users')}}
                  <i class="fas fa-angle-left right"></i>
                </p>
              </a>
              <ul class="nav nav-treeview" style="display: none;">
                @can('Read-Users')
                <li class="nav-item">
                  <a href="{{route('users.index')}}" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>{{__('cms.index')}}</p>
                  </a>
                </li>
                @endcan
                @can('Create-User')
                <li class="nav-item">
                  <a href="{{route('users.create')}}" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>{{__('cms.create')}}</p>
                  </a>
                </li>
                @endcan
              </ul>
            </li>
            @endcanany
            @endcanany

            @canany(['Read-Cities','Create-City'])
            <li class="nav-header">{{__('cms.content_management')}}</li>
            @canany(['Read-Cities','Create-City'])
            <li class="nav-item">
              <a href="#" class="nav-link">
                <i class="nav-icon fas fa-table"></i>
                <p>
                  {{__('cms.cities')}}
                  <i class="fas fa-angle-left right"></i>
                </p>
              </a>
              <ul class="nav nav-treeview" style="display: none;">
                @can('Read-Cities')
                <li class="nav-item">
                  <a href="{{route('cities.index')}}" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>{{__('cms.index')}}</p>
                  </a>
                </li>
                @endcan
                @can('Create-City')
                <li class="nav-item">
                  <a href="{{route('cities.create')}}" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>{{__('cms.create')}}</p>
                  </a>
                </li>
                @endcan
              </ul>
            </li>
            @endcanany
            @canany(['Read-Categories','Create-Category'])
            <li class="nav-item">
              <a href="#" class="nav-link">
                <i class="nav-icon fas fa-table"></i>
                <p>
                  {{__('cms.categories')}}
                  <i class="fas fa-angle-left right"></i>
                </p>
              </a>
              <ul class="nav nav-treeview" style="display: none;">
                @can('Read-Categories')
                <li class="nav-item">
                  <a href="{{route('categories.index')}}" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>{{__('cms.index')}}</p>
                  </a>
                </li>
                @endcan
                @can('Create-Category')
                <li class="nav-item">
                  <a href="{{route('categories.create')}}" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>{{__('cms.create')}}</p>
                  </a>
                </li>
                @endcan
              </ul>
            </li>
            @endcanany
            @canany(['Read-SubCategories','Create-SubCategory'])
            <li class="nav-item">
              <a href="#" class="nav-link">
                <i class="nav-icon fas fa-table"></i>
                <p>
                  {{__('cms.sub_categories')}}
                  <i class="fas fa-angle-left right"></i>
                </p>
              </a>
              <ul class="nav nav-treeview" style="display: none;">
                @can('Read-SubCategories')
                <li class="nav-item">
                  <a href="{{route('sub-categories.index')}}" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>{{__('cms.index')}}</p>
                  </a>
                </li>
                @endcan
                @can('Create-SubCategory')
                <li class="nav-item">
                  <a href="{{route('sub-categories.create')}}" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>{{__('cms.create')}}</p>
                  </a>
                </li>
                @endcan
              </ul>
            </li>
            @endcanany
            @canany(['Read-Tasks','Create-Task'])
            <li class="nav-item">
              <a href="#" class="nav-link">
                <i class="nav-icon fas fa-table"></i>
                <p>
                  {{__('cms.tasks')}}
                  <i class="fas fa-angle-left right"></i>
                </p>
              </a>
              <ul class="nav nav-treeview" style="display: none;">
                @can('Read-Tasks')
                <li class="nav-item">
                  <a href="{{route('tasks.index')}}" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>{{__('cms.index')}}</p>
                  </a>
                </li>
                @endcan
                @can('Create-Task')
                <li class="nav-item">
                  <a href="{{route('tasks.create')}}" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>{{__('cms.create')}}</p>
                  </a>
                </li>
                @endcan
              </ul>
            </li>
            @endcanany
            @endcanany

            <li class="nav-header">{{__('cms.settings')}}</li>
            <li class="nav-item">
              <a href="{{route('cms.edit-password')}}" class="nav-link">
                <i class="nav-icon fas fa-lock"></i>
                <p>
                  {{__('cms.change_password')}}
                </p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{route('cms.logout')}}" class="nav-link">
                <i class="nav-icon fas fa-sign-out-alt"></i>
                <p>
                  {{__('cms.logout')}}
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
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1 class="m-0">@yield('lg-title')</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">@yield('main-title')</a></li>
                <li class="breadcrumb-item active">@yield('sm-title')</li>
              </ol>
            </div><!-- /.col -->
          </div><!-- /.row -->
        </div><!-- /.container-fluid -->
      </div>
      <!-- /.content-header -->

      <!-- Main content -->
      @yield('content')
      <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
      <!-- Control sidebar content goes here -->
      <div class="p-3">
        <h5>Title</h5>
        <p>Sidebar content</p>
      </div>
    </aside>
    <!-- /.control-sidebar -->

    <!-- Main Footer -->
    <footer class="main-footer">
      <!-- To the right -->
      <div class="float-right d-none d-sm-inline">
        Anything you want
      </div>
      <!-- Default to the left -->
      <strong>Copyright &copy; 2014-2021 <a href="https://adminlte.io">AdminLTE.io</a>.</strong> All rights reserved.
    </footer>
  </div>
  <!-- ./wrapper -->

  <!-- REQUIRED SCRIPTS -->

  <!-- jQuery -->
  <script src="{{asset('cms/plugins/jquery/jquery.min.js')}}"></script>
  <!-- Bootstrap 4 -->
  <script src="{{asset('cms/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
  <!-- AdminLTE App -->
  <script src="{{asset('cms/dist/js/adminlte.min.js')}}"></script>

  <!-- Toastr -->
  <script src="{{asset('cms/plugins/toastr/toastr.min.js')}}"></script>
  <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
  {{-- <script src="{{asset('js/axios.js')}}"></script> --}}
  <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  @yield('scripts')
</body>

</html>