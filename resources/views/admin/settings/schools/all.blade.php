@extends('admin.main')

@section('content')
    <div class="box">
        <div class="box-header bg-warning text-center text-uppercase">
            {{ __('schools') }}
            <a href="{{ route('admin.dashboard')}}" class="btn btn-sm btn-info pull-right">Dashboard</a>
        </div>
        <div class="box-body table-responsive">
            <table class="table table-bordered">
                @if(count($_schools) > 0)
                    <thead class="" style="background:#000; color:#fff">
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Dean</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    @foreach($_schools as $key=>$value)
                        <tbody>
                            <tr>
                                <td>{{ $value->school_id }}</td>
                                <td>{{ $value->school_name }}</td>
                                <td> {{ $value->dean }}</td>
                                <td class="btn-group btn-group-sm text-center" style="width:100%">
                                    <a href="" class="btn btn-sm btn-success"><i class="fa fa-eye"></i></a>
                                    <a href="" class="btn btn-sm btn-info"><i class="fa fa-pencil"></i></a>
                                    <a href="" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></a>
                                </td>
                            </tr>
                        </tbody>
                    @endforeach
                    @else
                        <div class="table-responsive">
                            <td class="bg-warning">No schools Information Found</td>
                        </div>
                @endif
            </table>
        </div>
        <div class="box-footer">
            {{ $_schools->links() }}
        </div>
    </div>
@endsection
