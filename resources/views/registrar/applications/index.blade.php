@extends('registrar.main')
@section('content')
    <div class="box">
        <div class="box-header bg-warning text-center text-uppercase">{{ __('student application history') }}</div>
        <div class="box-body">
            <div class="col-md-12 row table-responsive">
                @include('includes.errors.custom')
                @if(count($applications) > 0)
                <table class="table table-bordered table-hover table-dark" style="width:100%">
                    <thead class="thead-dark !important" style="color:#fff; background:#000">
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
                                    <a href="{{ route('student.application.show',['app_id'=>$value->app_id]) }}" class="btn btn-success btn-sm"><i class="fa fa-eye"></i>View</a>
                                    <form action="{{ route('student.application.cancel',['app_id'=>$value->app_id]) }}" method="post">
                                               {{ csrf_field() }}
                                                <button class="btn btn-sm btn-primary" type="submit">
                                                        <i class="fa fa-window-close"></i>Approve
                                                </button>
                                    </form>
                                </td>
                            </tr>
                        </tbody>
                    @endforeach
                </table>
                @else
                    {{-- <table class="table table-responsive table-dark">
                        <thead>
                            <tr>
                                <td class="">No recent applications made.
                                    Kindly click<a href="{{ route('student.application.form') }}" class="btn btn-success btn-sm"><i class="fa fa-arrow-left"></i> Here</a> to apply
                                </td>
                            </tr>
                        </thead>
                    </table> --}}
                @endif
            </div>
        </div>
        <div class="box-footer"></div>
    </div>
@endsection
