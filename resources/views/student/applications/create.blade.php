@extends('student.main')
{{-- @include('student.header') --}}
@section('content')
    <div class="box">
        <div class="box-header"></div>
            <div class="box-body">
                    {!!Form::open(['action'=>'Student\Applications\ApplicationsController@store','method'=>'post','enctype'=>'multipart/form-data'])!!}
                    <div class="col-md-12 row">
                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-header text-uppercase text-white" style="margin-bottom:2em">{{ __('PERSONAL INFORMATION') }}</div>
                                <div class="card-body">
                                    <div class="form-group row">
                                        {!! Form::label('name','Name',['class'=>'form-label text-md-right col-md-4']) !!}
                                        <div class="col-md-8">
                                            {!!Form::text('name','',['class'=>'form-control'])!!}
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        {!!Form::label('reg_number','Reg No/Adm',['class'=>'form-label text-md-right col-md-4'])!!}
                                        <div class="col-md-8">
                                            {!!Form::text('reg_number','',['class'=>'form-control','placeholder'=>'Reg No/Adm'])!!}
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        {!! Form::label('phone','Phone No:', ['class'=>'form-label text-md-right col-md-4']) !!}
                                        <div class="col-md-8">
                                            {!! Form::text('phone', '', ['class'=>'form-control']) !!}
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer"></div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-header" style="margin-bottom:2em">PROGRAMME INFORMATION</div>
                                <div class="card-body">
                                    <div class="form-group row">
                                        {!! Form::label('current_program','Present Program', ['class'=>'form-label text-md-right col-md-4']) !!}
                                    <div class="col-md-8">
                                       {!! Form::select('current_program',
                                       [''=>'Select...',
                                       'com'=>'Bsc Computer Science',
                                       'it'=>'Bsc Information Technology',
                                       'ets'=>'Bsc Education Technolofy Computer Studies',
                                       'sik'=>'Bsc Information Systems and Knowledge Management'
                                    ],
                                        '',
                                        ['class'=>'form-control']) !!}
                                    </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="current_school" class="form-label text-md-right col-md-4">{{ __('Present School') }}</label>
                                        <div class="col-md-8">
                                            {!! Form::select('current_program',
                                            [''=>'Select...','sci'=>'School of Computing and Informatics',
                                            'sedu'=>'School of Education',
                                            'som'=>'School of Medicine',
                                            'sass'=>'School of Arts and Social Sciences',
                                            'sonas'=>'School of Natural Sciences',
                                            'sobe'=>'School of Business',
                                            'sidhma'=>'School of Disaster and Humanitarian Assisstance'],
                                             '',
                                             ['class'=>'form-control']) !!}
                                         </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="preffered_program" class="form-label col-md-4 text-md-right">{{ __('Preffered Program') }}</label>
                                        <div class="col-md-8">
                                            {!! Form::select('preffered_program',
                                            [''=>'Select...',
                                            'com'=>'Bsc Computer Science',
                                            'it'=>'Bsc Information Technology',
                                            'ets'=>'Bsc Education Technolofy Computer Studies',
                                            'sik'=>'Bsc Information Systems and Knowledge Management'
                                         ],
                                             '',
                                             ['class'=>'form-control']) !!}
                                         </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="preffered_school" class="form-label col-md-4 text-md-right">{{ __('Preffered School')}}</label>
                                        <div class="col-md-8">
                                            {!! Form::select('preffered_school',
                                            [''=>'Select...','sci'=>'School of Computing and Informatics',
                                            'sedu'=>'School of Education',
                                            'som'=>'School of Medicine',
                                            'sass'=>'School of Arts and Social Sciences',
                                            'sonas'=>'School of Natural Sciences',
                                            'sobe'=>'School of Business',
                                            'sidhma'=>'School of Disaster and Humanitarian Assisstance'],
                                             '',
                                             ['class'=>'form-control']) !!}
                                         </div>
                                    </div>
                                </div>
                                <div class="card-footer"></div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-header text-white bg-dark text-uppercase" style="margin-bottom:2em">KCSE INFORMATION</div>
                                <div class="card-body">
                                    <div class="form-group row">
                                        {!! Form::label('kcse_index', 'KCSE Index No:', ['class'=>'col-md-4 form-label text-md-right']) !!}
                                        <div class="col-md-8">
                                            {!! Form::number('kcse_index','', ['class'=>'form-control']) !!}
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        {!!Form::label('kcse_year','KCSE Year',['class'=>'form-label text-md-right col-md-4'])!!}
                                        <div class="col-md-8">
                                            {!! Form::selectRange('kcse_year',date('Y')-6,date('Y')-1,'',['class'=>'form-control'])!!}
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        {!! Form::label('kuccps_password', 'KUCCPS PWD(KCSE Index/Birth Cert No:)', ['class'=>'form-label col-md-4 text-md-right']) !!}
                                        <div class="col-md-8">
                                            {!! Form::text('kuccps_password','', ['class'=>'form-control']) !!}
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        {!! Form::label('mean_grade','Mean Grade', ['class'=>'form-label text-md-right col-md-4']) !!}
                                        <div class="col-md-8">
                                            {!! Form::text('mean_grade','', ['class'=>'form-control']) !!}
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        {!! Form::label('aggregate','Aggregate Points', ['class'=>'form-label col-md-4 text-md-right']) !!}
                                        <div class="col-md-8">
                                            {!! Form::number('aggregate', '', ['class'=>'form-control']) !!}
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        {!! Form::label('cut_off_points','Cut Off Points', ['class'=>'form-label text-md-right col-md-4']) !!}
                                        <div class="col-md-8">
                                            {!! Form::number('cut_off_points','', ['class'=>'form-control']) !!}
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer"></div>
                            </div>
                        </div>
                    </div>
                </form>
                {!! Form::close() !!}
            </div>
            <div class="box-footer">

            </div>
        </div>
@endsection
