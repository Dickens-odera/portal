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
                @if(count($query) > 0)
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
                    @foreach($query as $key=>$value)
                        <tbody>
                            <tr>
                                <td>{{ $value->id }}</td>
                                <td>{{ $value->name }}</td>
                                <td>{{ $value->email }}</td>
                                @if(isset($value->school))
                                <td>{{ $value->school }}</td>
                                @else
                                <td></td>
                                @endif
                                @if(isset($value->department))
                                <td>{{ $value->department }}</td>
                                @else
                                <td></td>
                                @endif

                                <td></td>
                                @if(isset($value->phone))
                                    <td>{{ $value->phone }}</td>
                                @else
                                    <td></td>
                                @endif
                            </tr>
                        </tbody>
                    @endforeach
                    @else
                        <div class="table-responsive">
                            <td class="bg-warning">No cods Information Found</td>
                        </div>
                @endif

            </table>
                {{ $query->links() }}
        </div>
        <div class="box-footer"></div>
    </div>
@endsection
