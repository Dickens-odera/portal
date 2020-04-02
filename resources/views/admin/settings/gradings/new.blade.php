@extends('admin.main')

@section('content')
    <div class="box">
        <div class="box-header bg-warning text-center text-uppercase">{{ __('add a new grade') }}</div>
        <div class="box-body">
            <div class="col-md-2"></div>
            <div class="col-md-8 row">
                @include('includes.errors.custom')
                <form action="{{ route('admin.grading.add.submit') }}" method="POST" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <div class="form-group row">
                        <label for="name" class="form-label text-md-right col-md-4">{{ __('Name') }}</label>
                        <div class="col-md-8">
                            <input type="text" class="form-control" name="name" value="{{ old('name')}}">
                        </div>
                    </div>
                    <div class="col-md-8 col-md-offset-4">
                        <button type="submit" class="btn btn-sm btn-success"><i class="fa fa-send"></i> Submit</button>
                        <a href="{{ route('admin.dashboard') }}" class="btn btn-sm btn-danger pull-right"><i class="fa fa-arrow-left"></i> Cancel</a>
                    </div>
                </form>
            </div>
            <div class="col-md-2"></div>
        </div>
        <div class="box-footer"></div>
    </div>
@endsection
