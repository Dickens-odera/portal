@extends('registrar.main')
@section('content')
    <div class="box">
        {{-- <link href="//netdna.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="//cdn.datatables.net/1.10.7/css/jquery.dataTables.min.css"> --}}
        <div class="box-header bg-warning text-center text-uppercase">{{ __('Forwarded applications for approval by deans of schools') }}</div>
        <div class="box-body">
            <div class="col-md-12 row table-responsive">
                @include('includes.errors.custom')
                @if(count($applications) > 0)
                <table class="table table-bordered table-hover table-dark" style="width:100%" id="table-data">
                    <thead class="thead-dark !important" style="color:#fff; background:#000">
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Reg No</th>
                            <th>ID No:</th>
                            <th>Phone</th>
                            <th>Current Program</th>
                            <th>Current School</th>
                            <th>Preffered Program</th>
                            <th>Preffered School</th>
                            <th>KCSE Index</th>
                            {{-- <th>KCSE Year</th> --}}
                            {{-- <th>KUCCPS Password</th>
                            <th>Mean Grade</th>
                            <th>Aggregate Points</th>
                            <th>Cut Off Points</th>
                            <th>Weighted Clusters</th> --}}
                            <th>Dean</th>
                            <th>Comment</th>
                            {{-- <th>Status</th> --}}
                            <th>Type</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                     @foreach($applications as $key=>$value)
                        <tbody>
                            <tr>
                                <td>{{$value->comment_id}}</td>
                                <td>{{$value->student_name}}</td>
                                <td>{{ $value->reg_number}}</td>
                                <td></td>
                                <td>{{ $value->student_phone}}</td>
                                <td>{{ $value->present_program}}</td>
                                <td>{{ $value->present_school}}</td>
                                <td>{{ $value->preffered_program}}</td>
                                <td>{{ $value->preffered_school}}</td>
                                <td>{{ $value->kcse_index}}</td>
                                {{-- <td>{{ $value->kcse_year}}</td> --}}
                                {{-- <td>{{ $value->kuccps_password}}</td>
                                <td>{{ $value->mean_grade}}</td>
                                <td>{{ $value->aggregate_points}}</td>
                                <td>{{ $value->cut_off_points }}</td>
                                <td>{{ $value->weighted_clusters}}</td> --}}
                                <td style="color:green">{{ $value->dean }}</td>
                                <td style="color:red">{{ $value->comment }}</td>
                                {{-- <td>{{ $value->status}}</td> --}}
                                <td>{{ $value->app_type }}</td>
                                 <td class="btn-group btn-group-sm" style="width:100%">
                                    <a href="{{ route('registrar.application.single.view',['app_id'=>$value->app_id]) }}" class="btn btn-success btn-sm"><i class="fa fa-eye"></i></a>
                                    <a href="" class="btn btn-sm btn-primary"><i class="fa fa-send"></i> Approve</a>
                                    {{-- <form action="" method="post">
                                               {{ csrf_field() }}
                                                <button class="btn btn-sm btn-primary" type="submit">
                                                        <i class="fa fa-window-close"></i>Approve
                                                </button>
                                    </form> --}}
                                </td>
                            </tr>
                        </tbody>
                    @endforeach
                </table>
                {{ $applications->links() }}
                 @else
                     <table class="table table-responsive table-dark">
                        <thead>
                            <tr>
                                <td class="">No recent applications made.
                                    {{-- Kindly click<a href="{{ route('student.application.form') }}" class="btn btn-success btn-sm"><i class="fa fa-arrow-left"></i> Here</a> to apply --}}
                                </td>
                            </tr>
                        </thead>
                    </table>
                @endif
            </div>
        </div>
        <div class="box-footer"></div>
    </div>
    {{-- <script src="https://code.jquery.com/jquery.js"></script>
<script src="https://cdn.datatables.net/1.10.7/js/jquery.dataTables.min.js"></script>
<script src="https://netdna.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function(){
            $('#table-data').DataTable({
                "processing":true,
                "serverSide":true,
                "ajax":"{{ route('registrar.applications.view.data') }}",
                        "type":'GET',
                "columns":[
                    {data:'app_id', name:'app_id'},
                    {data:'student_name', name:'student_name'},
                    {data:'reg_number',name:'reg_number'},
                    {data:'student_phone',name:'student_phone'},
                    {data:'present_program',name:'present_program'},
                    {data:'present_school',name:'present_school'},
                    {data:'preffered_program',name:'preffered_program'},
                    {data:'preffered_school',name:'preffered_school'},
                    {data:'kcse_index',name:'kcse_index'},
                    {data:'kcse_year',name:'kcse_year'},
                    {data:'kuccps_password',name:'kuccps_password'},
                    {data:'mean_grade',name:'mean_grade'},
                    {data:'aggregate_points',name:'aggregate_points'},
                    {data:'cut_off_points',name:'cut_off_points'},
                    {data:'weighted_clusters',name:'weighted_clusters'},
                    {data:'status',name:'status'},
                    {data:'action',name:'action', orderable:false, searchable:false}
                ]
            });
        });
    </script> --}}

        {{-- <script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap.min.js"></script> --}}
@endsection
