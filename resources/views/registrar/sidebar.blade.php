 <!-- Left side column. contains the logo and sidebar -->
 <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel">
        <div class="pull-left image">
          {{-- <img src="{!! asset('admin/dist/img/user2-160x160.jpg') !!}" class="img-circle" alt="User Image"> --}}
          <img src="{{ asset('/uploads/images/logo/admin.jpg') }}" alt="Dr'Photo" style="" class="img-circle">
        </div>
        <div class="pull-left info">
          <p>{{ Auth::user()->email}}</p>
          <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
        </div>
      </div>
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu" data-widget="tree">
        <li class="header">MAIN NAVIGATION</li>
        <li class="treeview">
          <a href="#">
            <i class="fa fa-pie-chart"></i>
            <span>Applications</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="{{ route('registrar.applications.incoming.all') }}"><i class="fa fa-circle-o"></i> Incoming</a></li> 
            <li><a href="{{ route('registrar.applications.outgoing.all') }}"><i class="fa fa-circle-o"></i> Outgoing</a></li> 
            <li><a href="{{ route('registrar.applications.view') }}"><i class="fa fa-circle-o"></i> View All</a></li>
          </ul>
        </li>
          </ul>
        </li>
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>
