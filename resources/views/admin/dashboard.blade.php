@extends('admin.main')
@section('content')
<section class="content-header">
    <h1>
      Dashboard
      <small>Control panel</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Dashboard</li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
    <!-- Small boxes (Stat box) -->
    <div class="row">
      <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-aqua">
          <div class="inner">
            <div class="hidden">
              {{ $deans = App\Deans::latest()->get() }}
              {{ $cods = App\CODs::latest()->get() }}
              {{ $registrars= App\Registrar::latest()->get() }}
              {{ $schools = App\Schools::latest()->get() }}
            </div>
            <h3>{{ count($deans)}}</h3>

            <p class="text-uppercase">Deans</p>
          </div>
          <div class="icon">
            <i class="ion ion-person"></i>
          </div>
          <a href="{{ route('admin.deans.view.all') }}" class="small-box-footer">View All <i class="fa fa-arrow-circle-right"></i></a>
        </div>
      </div>
      <!-- ./col -->
      <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-green">
          <div class="inner">
            <h3>{{ count($cods) }}</h3>

            <p class="text-uppercase">CODs</p>
          </div>
          <div class="icon">
            <i class="ion ion-person"></i>
          </div>
          <a href="{{ route('admin.cods.view.all') }}" class="small-box-footer">View All <i class="fa fa-arrow-circle-right"></i></a>
        </div>
      </div>
      <!-- ./col -->
      <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-yellow">
          <div class="inner">
            <h3>{{ count($registrars) }}</h3>

            <p class="text-uppercase">Registrars(AA)</p>
          </div>
          <div class="icon">
            <i class="ion ion-person"></i>
          </div>
          <a href="" class="small-box-footer">View All <i class="fa fa-arrow-circle-right"></i></a>
        </div>
      </div>
      <!-- ./col -->
      <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-red">
          <div class="inner">
            <h3>{{ count($schools) }}</h3>

            <p class="text-uppercase">Schools</p>
          </div>
          <div class="icon">
            <i class="ion ion-home"></i>
          </div>
          <a href="" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
        </div>
      </div>
      <!-- ./col -->
    </div>
    <!-- /.row -->
    <!-- Main row -->
    <div class="row">
      <div class="col-md-6">
          <div class="box">
              <div class="box-header text-white text-uppercase bg-success">{{ __('Deans') }}</div>
              <div class="box-body table-responsive">
                <table class="table table-bordered">
                  <thead>
                    <tr>
                      <th>#</th>
                      {{-- <th>Avartar</th> --}}
                      <th>Name</th>
                      <th>Email</th>
                      <th>School</th>
                      <th>Phone</th>
                      {{-- <th>Type</th> --}}
                    </tr>
                  </thead>
                  @if(count($deans) > 0)
                    @foreach($deans as $key=>$value)
                      <tbody>
                        <tr>
                          <td>{{ $value->id }}</td>
                          {{-- <td><img src="/storage/uploads/images/patients/{{ $value->avartar }}" alt="Admin Image" class="img-circle" style="width:50px; height:50px"></td> --}}
                          <td>{{ $value->name }}</td>
                          <td>{{ $value->email }}</td>
                          <td>{{ $value->school->school_name}}</td>
                          <td>{{ $value->phone }}</td>
                          {{--<td>{{ $value->type}}</td> --}}
                        </tr>
                      </tbody>
                    @endforeach
                  @endif
                </table>
              </div>
              <div class="box-footer"></div>
            </div>
      </div>
      <div class="col-md-6">
        <div class="box">
          <div class="box-header bg-info text-white text-uppercase">CODs</div>
          <div class="box-body table-responsive">
              <table class="table table-bordered">
                <thead>
                  <tr>
                    <th>#</th>
                    {{-- <th>Avatar</th> --}}
                    <th>Name</th>
                    <th>Email</th>
                    <th>School</th>
                    <th>Department</th>
                    <th>phone</th>
                  </tr>
                </thead>
                @if(count($cods) > 0)
                  @foreach($cods as $key=>$value)
                    <tbody>
                      <tr>
                        <td>{{ $value->id }}</td>
                        {{-- <td><img src="/storage/uploads/images/nurses/{{ $value->avartar }}" alt="Admin Image" class="img-circle" style="width:50px; height:50px"></td> --}}
                        <td>{{ $value->name }}</td>
                        <td>{{ $value->email }}</td>
                        <td>{{ $value->school->school_name }}</td>
                        <td>{{ $value->department->name}}</td>
                        <td>{{ $value->phone }}</td>
                      </tr>
                    </tbody>
                  @endforeach
                @endif
              </table>
          </div>
          <div class="box-footer">
            <!--  Some footer content go here-->
          </div>
        </div>
      </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="box">
                <div class="box-header bg-success text-white text-uppercase">{{ __('Schools') }}</div>
                <div class="box-body table-responsive">
                  <table class="table  table-bordered">
                    <thead>
                      <tr>
                        <th>#</th>
                        <th>Name</th>
                      </tr>
                    </thead>
                    @if(count($schools) > 0)
                      @foreach($schools as $key=>$value)
                        <tr>
                          <td>{{ $value->school_id }}</td>
                          <td>{{ $value->school_name }}</td>
                        </tr>
                      @endforeach
                    @endif
                  </table>
                </div>
                <div class="box-footer"></div>
              </div>
        </div>
      <div class="col-md-6">
          <div class="box">
              <div class="box-header bg-info text-white text-uppercase">Registrars</div>
              <div class="box-body table-responsive">
                <table class="table table-bordered">
                  <thead>
                    <tr>
                      <th>#</th>
                      {{-- <th>Avartar</th> --}}
                      <th>Name</th>
                      <th>Email</th>
                      <th>Phone</th>
                    </tr>
                  </thead>
                  @if(count($registrars) > 0)
                      @foreach($registrars as $key => $value )
                      <tbody>
                        <td>{{ $value->id }}</td>
                        <td>{{ $value->name }}</td>
                        <td>{{ $value->email }}</td>
                        <td>{{ $value->phone }}</td>
                      </tbody>
                      @endforeach
                  @endif
                </table>
              </div>
              <div class="box-footer"></div>
            </div>
      </div>
    </div>
@endsection
