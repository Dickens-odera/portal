@extends('admin.main')

@section('content')
    <div class="box">
        <div class="box-header bg-warning text-center text-uppercase">{{ __('Deans of schools') }}</div>
        <div class="box-body table-responsive">
            <table class="table table-bordered">
                @if(count($deans) > 0)
                    <thead class="" style="background:#000; color:#fff">
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>School</th>
                        </tr>
                    </thead>
                    @foreach($deans as $key=>$value)
                        <tbody>
                            <tr>
                                <td>{{ $value->id }}</td>
                                <td>{{ $value->name }}</td>
                                <td>{{ $value->email }}</td>
                                <td>{{ $value->school->school_name }}</td>
                            </tr>
                        </tbody>
                    @endforeach
                    @else
                        <div class="table-responsive">
                            <td class="bg-warning">No Deans Information Found</td>
                        </div>
                @endif

            </table>    
        </div>
        <div class="box-footer"></div>
    </div>
@endsection