<div class="hidden">
</div>
  <header class="main-header">
    <!-- Logo -->
    <a href="index2.html" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><b>MM</b>UST</span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><b>PORTAL</span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>

      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          <!-- Notifications: style can be found in dropdown.less -->
          <li class="dropdown notifications-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <i class="fa fa-bell-o"></i>
              <span class="label label-warning">{{ count(Auth::user()->unreadNotifications )}}</span>
            </a>
            <ul class="dropdown-menu">
              @foreach(Auth::user()->unreadNotifications as $notification)
                <li class="header">{{ $notification->id}}</li>
              @endforeach
              <li>
              </li>
              <li class="footer"><a href="">View all</a></li>
            </ul>
          </li>
          <!-- User Account: style can be found in dropdown.less -->
          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                <img src="{{ asset('/uploads/images/logo/admin.jpg') }}" alt="Dr'Photo" style="" class="user-image">
              {{-- <img src="{!! asset('admin/dist/img/user2-160x160.jpg') !!}" class="user-image" alt="User Image"> --}}
              <span class="hidden-xs">{{ Auth::user()->name}}</span>
            </a>
            <ul class="dropdown-menu">
              <!-- User image -->
              <li class="user-header">
                {{-- <img src="{!! asset('admin/dist/img/user2-160x160.jpg') !!}" class="img-circle" alt="User Image"> --}}
                <img src="{{ asset('/uploads/images/logo/admin.jpg') }}" alt="Dean's Photo" style="">
                <p>
                  {{-- {{ Auth::user()->surname }} --}}
                  <small>Registrar AA</small>
                </p>
              </li>
              <!-- Menu Footer-->
              <li class="user-footer">
                <div class="pull-left">
                  <a href="" class="btn btn-default btn-flat">Profile</a>
                </div>
                <div class="pull-right">
                      <a class="btn btn-default btn-flat" href="{{ route('registrar.logout') }}">
                   {{ __('Sign Out') }}
               </a>
                </div>
              </li>
            </ul>
          </li>
        </ul>
      </div>
    </nav>
  </header>
