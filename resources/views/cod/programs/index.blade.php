@extends('cod.main')

@section('content')
    <div class="box">
        <div class="box-header bg-warning text-center text-uppercase">{{ __('Programs') }}</div>
        <div class="box-body">
            <div class="col-md-12 text-center">
                <a href="{{ route('cod.programs.export') }}" class="btn btn-primary btn-sm"><i class="fa fa-arrow-down"></i>  {{ __('Download Excel Sheet') }}</a>
            </div>
        </div>
        <div class="box-footer"></div>
    </div>
@endsection
