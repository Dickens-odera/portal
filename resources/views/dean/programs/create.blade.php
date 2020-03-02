@extends('dean.main')

@section('content')
    <div class="box">
        <div class="box-header text-center bg-warning text-uppercase">{{ __('add a new program') }}</div>
        <div class="box-body">
            <div class="col-md-3"></div>
            <div class="col-md-6">
                @include('includes.errors.custom')
                {!! Form::open(['action'=>'Dean\DeanController@addProgram']) !!}
                    <div class="form-group row">
                        {!! Form::label('name','Program Name', ['class'=>'form-label col-md-4 text-md-right']) !!}
                        <div class="col-md-8">
                            {!! Form::text('name',old('name'), ['class'=>'form-control']) !!}
                        </div>
                    </div>
                    <div class="form-group row">
                        {!! Form::label('description','Description', ['class'=>'form-label text-md-right col-md-4']) !!}
                        <div class="col-md-8">
                            {!! Form::textarea('description',old('description') , ['class'=>'form-control','id'=>'description-form']) !!}
                        </div>
                    </div>
                    <div class="col-md-8 col-md-offset-4">
                        {!! Form::submit('SUBMIT', ['class'=>'btn btn-success btn-sm']) !!}
                    </div>
                    <div class="form-group row hidden">
                        {!! Form::label('school_id','School', ['class'=>'form-label text-md-right col-md-4']) !!}
                        <div class="col-md-8">
                            {!! Form::text('school_is', old('school_is'), ['class'=>'form-control']) !!}
                        </div>
                    </div>
                {!! Form::close() !!}
                {!! Form::open(['action'=>'Dean\DeanController@importPrograms','method'=>'post','enctype'=>'multipart/form-data']) !!}
                    <div class="form-group col-md-8 col-md-offset-4">
                        {!! Form::file('excel_program_file') !!} <br>
                        <button class="btn btn-sm btn-primary">{{ __('Import Excel File') }}</button>
                    </div>
                {!! Form::close() !!}
            </div>
            <div class="col-md-3"></div>
        </div>
        <div class="box-footer"></div>
    </div>
    <script>
        <script>
    ClassicEditor
    .create(document.querySelector('#description-form'))
    .catch(error=>{
        console.error(error);
    });
</script>
    </script>
@endsection
