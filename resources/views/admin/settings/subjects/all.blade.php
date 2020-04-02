@extends('admin.main')

@section('content')
{{-- <div class="col-md-2"></div>
<div class="col-md-8"> --}}
    <div class="box">
        <div class="box-header bg-warning text-center text-uppercase">
            {{ __('subjects') }}
            <a href="{{ route('admin.dashboard')}}" class="btn btn-sm btn-info pull-right">Dashboard</a>
        </div>
        <div class="box-body table-responsive">
            <table class="table table-bordered table-stripped">
                <thead style="background:#000;color:#fff">
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Action</th>
                        {{-- <th>Points</th> --}}
                    </tr>
                </thead>
                @if(count($subjects) > 0)
                    @foreach($subjects as $key=>$value)
                        <tbody>
                            <tr>
                                <td>{{ $value->subject_id }}</td>
                                <td>{{ $value->name }}</td>
                                <td class="btn-group btn-group-sm text-center" style="width:100%">
                                    <a href="" class="btn btn-sm btn-success"><i class="fa fa-eye"></i></a>
                                    <a href="" class="btn btn-sm btn-info"><i class="fa fa-pencil"></i></a>
                                    <a href="" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></a>
                                </td>
                                {{-- <td>{{ $value->points }}</td> --}}
                            </tr>
                        </tbody>
                    @endforeach
                    @else
                    <td>
                        No subjects Found
                    </td>
                @endif
            </table>
        </div>
        <div class="box-footer">
            {{$subjects->links()}}
        </div>
    </div>
</div>
{{-- <div class="col-md-2"></div> --}}
@endsection
