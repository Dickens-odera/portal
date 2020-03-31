 <!-- Left side column. contains the logo and sidebar -->
 <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel">
        <div class="pull-left image">
          {{-- <img src="{!! asset('admin/dist/img/user2-160x160.jpg') !!}" class="img-circle" alt="User Image"> --}}
          <img src="/storage/uploads/logo/admin.jpg" alt="Dean's Photo" style="" class="img-circle">
        </div>
        <div class="pull-left info">
          <p>{{ Auth::user()->name}}</p>
          <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
        </div>
      </div>
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu" data-widget="tree">
        <li class="header">MAIN NAVIGATION</li>
        <li class="treeview">
          <a href="#">
            <i class="fa fa-bars"></i>
            <span>Applications</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            {{-- <li><a href=""><i class="fa fa-circle-o"></i> New</a></li> --}}
            <li><a href="{{ route('cod.applications.view.all') }}"><i class="fa fa-circle-o"></i> All</a></li>
            <li><a href="{{ route('cod.applications.outgoing.all') }}"><i class="fa fa-circle-o"></i> Outgoing</a></li>
            <li><a href="{{ route('cod.applications.incoming.all') }}"><i class="fa fa-circle-o"></i> Incoming</a></li>
            <li><a href=""><i class="fa fa-circle-o"></i> Approved</a></li>
            <li><a href=""><i class="fa fa-circle-o"></i> Not Approved</a></li>
          </ul>
        </li>
        <li class="treeview">
            <a href="#">
              <i class="fa fa-bars"></i>
              <span>Programs</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
              <li><a href="{{ route('cod.programs') }}"><i class="fa fa-circle-o"></i> New</a></li>
              <li><a href="{{ route('cod.programs.view.all') }}"><i class="fa fa-circle-o"></i> All</a></li>
            </ul>
          </li>
          </ul>
        </li>
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>
