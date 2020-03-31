@extends('cod.main')

@section('content')
    <div class="box">
        <div class="box-header bg-warning text-center text-uppercase">{{ __('Programs') }}</div>
            <div class="box-body">
                <div class="col-md-12 text-center">
                    <a href="{{ route('cod.programs.export') }}" class="btn btn-primary btn-sm"><i class="fa fa-arrow-down"></i>  {{ __('Download Excel Sheet') }}</a>
                </div>
                <div class="col-md-12 table-responsive">
                    @if(count($programs) > 0)
                    <table class="table table-bordered table-stripped">
                        <thead style="background:#000;color:#fff">
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        @foreach($programs as $key=>$value)
                            <tbody>
                                <tr>
                                    <td>{{ $value->program_id }}</td>
                                    <td>{{ $value->name }}</td>
                                    <td class="btn-group btn-group-sm" style="width:100%">
                                        <a href="" class="btn btn-sm btn-success"><i class="fa fa-eye"></i></a>
                                        <a href="" class="btn btn-sm btn-primary"><i class="fa fa-pencil"></i></a>
                                        <a href="" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></a>
                                    </td>
                                </tr>
                            </tbody>
                        @endforeach
                    </table>
                    @else
                    <td class="text-warning">
                        <p>No Programs Found</p>
                        <a href="{{ route('cod.programs') }}" class="btn btn-sm btn-success"> Click For New</a>
                    </td>
                    @endif

                </div>
            </div>
            <div class="box-footer"></div>
    </div>
@endsection
