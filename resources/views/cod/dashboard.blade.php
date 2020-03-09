@extends('cod.main')
@section('content')
    <div class="box">
        @include('includes.errors.custom')
        <div class="box-header">
            <div class="box-body">
                {{ Auth::user()->name }}
            </div>
            <div class="box-footer">
                test
            </div>
        </div>
    </div>
@endsection
