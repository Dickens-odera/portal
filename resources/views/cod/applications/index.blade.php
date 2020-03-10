@extends('cod.main')

@section('content')
    <div class="box">
        <div class="box-header bg-warning text-center text-uppercase">{{ __('applications for transfer') }} ({{ Auth::user()->department->name}} {{ __('department') }})</div>
        <div class="box-body">
            <div class="col-md-12 table-responsive">
                <div class="col-md-12 row">
                <input type="text" class="col-md-10 form-control mb-2" name="term" style="width:80%" placeholder="Search by program name">
                <button class="col-md-2 btn btn-sm btn-success" style="width:20%"><i class="fa fa-search"></i></button>
            </div>
            @if(count($applications) > 0)
                    <table class="table table-bordered table-dark">
                        <thead style="background:#000; color:#fff">
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Reg No</th>
                                <th>Phone</th>
                                <th>Current Program</th>
                                <th>Current School</th>
                                <th>Preffered Program</th>
                                <th>Preffered School</th>
                                <th>KCSE Index</th>
                                <th>KCSE Year</th>
                                <th>KUCCPS Password</th>
                                <th>Mean Grade</th>
                                <th>Aggregate Points</th>
                                <th>Cut Off Points</th>
                                <th>Weighted Clusters</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        @foreach($applications as $key=>$value)
                        <tbody>
                            <tr>
                                <td>{{$value->app_id}}</td>
                                <td>{{$value->student_name}}</td>
                                <td>{{ $value->reg_number}}</td>
                                <td>{{ $value->student_phone}}</td>
                                <td>{{ $value->present_program}}</td>
                                <td>{{ $value->present_school}}</td>
                                <td>{{ $value->preffered_program}}</td>
                                <td>{{ $value->preffered_school}}</td>
                                <td>{{ $value->kcse_index}}</td>
                                <td>{{ $value->kcse_year}}</td>
                                <td>{{ $value->kuccps_password}}</td>
                                <td>{{ $value->mean_grade}}</td>
                                <td>{{ $value->aggregate_points}}</td>
                                <td>{{ $value->cut_off_points }}</td>
                                <td>{{ $value->weighted_clusters}}</td>
                                <td>{{ $value->status}}</td>
                                <td class="btn-group btn-group-sm">
                                    <a href="{{ route('student.application.show',['app_id'=>$value->app_id]) }}" class="btn btn-success btn-sm"><i class="fa fa-eye"></i> View</a>
                                    <form action="{{ route('student.application.cancel',['app_id'=>$value->app_id]) }}" method="post">
                                               {{ csrf_field() }}
                                                <button class="btn btn-sm btn-danger" type="submit">
                                                        <i class="fa fa-trash"></i> Delete
                                                </button>
                                    </form>
                                </td>
                            </tr>
                        </tbody>
                    @endforeach
                    </table>
                    {{$applications->links()}}
            @endif
        </div>
        </div>
        <div class="box-footer"></div>
    </div>
@endsection
