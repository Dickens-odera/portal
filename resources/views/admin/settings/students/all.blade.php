@extends('admin.main')
{{-- <div class="hidden">
    {{ $cods = App\CODS::all()}}
    @foreach($cods as $k=>$v)
    {{ dd($v->department->first()->pluck('name'))}}
    @endforeach
</div> --}}

@section('content')
    <div class="box">
        <div class="box-header bg-warning text-center text-uppercase">
            {{ __('cods of departments') }}
            <a href="{{ route('admin.dashboard')}}" class="btn btn-sm btn-info pull-right">Dashboard</a>
        </div>
        <div class="box-body table-responsive">
            <table class="table table-bordered">
                @if(count($students) > 0)
                    <thead class="" style="background:#000; color:#fff">
                        <tr>
                            <th>#</th>
                            <th>Surname</th>
                            <th>Middle Name</th>
                            <th>Last Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            {{-- <th>School</th>
                            <th>Department</th> --}}
                            <th>Action</th>
                        </tr>
                    </thead>
                    @foreach($students as $key=>$value)
                        <tbody>
                            <tr>
                                <td>{{ $value->id }}</td>
                                <td>{{ $value->surname }}</td>
                                <td>{{ $value->middleName }}</td>
                                <td>{{ $value->lastName }}</td>
                                <td>{{ $value->email }}</td>
                                <td>{{ $value->phone }}</td>
                                {{-- @if(isset($value->school))
                                <td>{{ $value->school }}</td>
                                @else
                                <td></td>
                                @endif
                                @if(isset($value->department))
                                <td>{{ $value->department }}</td>
                                @else
                                <td></td>
                                @endif --}}
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
                            <td class="bg-warning">No cods Information Found</td>
                        </div>
                @endif

            </table>
                {{ $students->links() }}
        </div>
        <div class="box-footer"></div>
    </div>
@endsection
