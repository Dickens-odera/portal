@extends('admin.main')

@section('content')
    <div class="box">
        <div class="box-header bg-warning text-center text-uppercase">
            {{ __('Grading System') }}
            <a href="{{ route('admin.dashboard')}}" class="btn btn-sm btn-info pull-right">Dashboard</a>
        </div>
        <div class="box-body table-responsive">
            <table class="table table-bordered table-stripped">
                <thead style="background:#000;color:#fff">
                    <tr>
                        <th>#</th>
                        <th>Grade</th>
                        <th>Points</th>
                    </tr>
                </thead>
                @if(count($grades) > 0)
                    @foreach($grades as $key=>$value)
                        <tbody>
                            <tr>
                                <td>{{ $value->grade_id }}</td>
                                <td>{{ $value->name }}</td>
                                <td>{{ $value->points }}</td>
                            </tr>
                        </tbody>
                    @endforeach
                    @else
                    <td>
                        No Grades Found
                    </td>
                @endif
            </table>
        </div>
        <div class="box-footer"></div>
    </div>
@endsection