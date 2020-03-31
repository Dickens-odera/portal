@extends('admin.main')

@section('content')
    <div class="box">
        <div class="box-header bg-warning text-center text-uppercase">{{ __('add a new registrar Academic Affairs') }}</div>
        <div class="box-body">
            <div class="col-md-2"></div>
            <div class="col-md-8 row">
                @include('includes.errors.custom')
                <form action="{{ route('admin.registrar.add.submit') }}" method="POST" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <div class="form-group row">
                        <label for="name" class="form-label text-md-right col-md-4">{{ __('Name') }}</label>
                        <div class="col-md-8">
                            <input type="text" class="form-control" name="name" value="{{ old('name')}}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="email" class="form-label col-md-4 text-md-right">{{ __('Email') }}</label>
                        <div class="col-md-8">
                            <input type="email" class="form-control" name="email" value="{{ old('email') }}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="password" class="form-label col-md-4 text-md-right">{{ __('Password') }}</label>
                        <div class="col-md-8">
                            <input type="password" class="form-control" name="password" id="password">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="confirm_password" class="form-label col-md-4 text-md-right">{{ __('Confirm Password') }}</label>
                        <div class="col-md-8">
                            <input type="password" class="form-control" name="confirm_password" id="confirm_password">
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
