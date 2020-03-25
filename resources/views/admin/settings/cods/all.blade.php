@extends('admin.main')

@section('content')
    <div class="box">
        <div class="box-header bg-warning text-center text-uppercase">{{ __('cods of departments') }}</div>
        <div class="box-body table-responsive">
            <table class="table table-bordered">
                @if(count($cods) > 0)
                    <thead class="" style="background:#000; color:#fff">
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>School</th>
                            <th>Department</th>
                            <th>Phone</th>
                        </tr>
                    </thead>
                    @foreach($cods as $key=>$value)
                        <tbody>
                            <tr>
                                <td>{{ $value->id }}</td>
                                <td>{{ $value->name }}</td>
                                <td>{{ $value->email }}</td>
                                <td>{{ $value->school->school_name }}</td>
                                <td>{{ $value->department->name }}</td>
                                <td>{{ $value->phone }}</td>
                            </tr>
                        </tbody>
                    @endforeach
                   
                    @else
                        <div class="table-responsive">
                            <td class="bg-warning">No cods Information Found</td>
                        </div>
                @endif

            </table> 
            {{ $cods->links() }}   
        </div>
        <div class="box-footer"></div>
    </div>
@endsection