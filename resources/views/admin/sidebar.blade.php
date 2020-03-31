 <!-- Left side column. contains the logo and sidebar -->
 <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel">
        <div class="pull-left image">
          {{-- <img src="{!! asset('admin/dist/img/user2-160x160.jpg') !!}" class="img-circle" alt="User Image"> --}}
          <img src="/storage/uploads/logo/admin.jpg" alt="Dr'Photo" style="" class="img-circle">
        </div>
        <div class="pull-left info">
          <p>{{ Auth::user()->name }}</p>
          <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
        </div>
      </div>
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu" data-widget="tree">
        <li class="header">SETTINGS</li>
        <li class="treeview">
          <a href="#">
            <i class="fa fa-users"></i>
            <span>Deans</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="{{ route('admin.dean.add.form') }}"><i class="fa fa-circle-o"></i> New</a></li>
            <li><a href="{{ route('admin.deans.view.all') }}"><i class="fa fa-circle-o"></i> All</a></li>
          </ul>
        </li>
        <li class="treeview">
            <a href="#">
              <i class="fa fa-users"></i>
              <span>CODS</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
              <li><a href="{{ route('admin.cod.add.form') }}"><i class="fa fa-circle-o"></i> New</a></li>
              <li><a href="{{ route('admin.cods.view.all') }}"><i class="fa fa-circle-o"></i> All</a></li>
            </ul>
          </li>
          <li class="treeview">
            <a href="#">
              <i class="fa fa-user"></i>
              <span>Registrar(AA)</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
              <li><a href="{{ route('admin.registrar.add.form') }}"><i class="fa fa-circle-o"></i> New</a></li>
              <li><a href="{{ route('admin.registrars.view.all') }}"><i class="fa fa-circle-o"></i> All</a></li>
            </ul>
          </li>
          <li class="treeview">
            <a href="#">
              <i class="fa fa-bars"></i>
              <span>Schools</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
              <li><a href="{{ route('admin.schools.add.form') }}"><i class="fa fa-circle-o"></i> New</a></li>
              <li><a href="{{ route('admin.schools.view.all') }}"><i class="fa fa-circle-o"></i> All</a></li>
            </ul>
          </li>
          <li class="treeview">
            <a href="#">
              <i class="fa fa-bars"></i>
              <span>Departments</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
              <li><a href="{{ route('admin.department.add.form') }}"><i class="fa fa-circle-o"></i> New</a></li>
              <li><a href="{{ route('admin.departments.view.all') }}"><i class="fa fa-circle-o"></i> All</a></li>
            </ul>
          </li>
          {{-- <li class="treeview">
            <a href="#">
              <i class="fa fa-bars"></i>
              <span>Applications</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
              <li><a href=""><i class="fa fa-circle-o"></i> All</a></li>
            </ul>
          </li> --}}
          </ul>
        </li>
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>
