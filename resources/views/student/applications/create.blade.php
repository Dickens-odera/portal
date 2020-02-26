<style>
    #submit-btn{
        width:100%;
        height:auto;
        text-align: center;
        color:#fff;
        background: rgba(45,178,255,0.4);
        font-family: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif;
        font-size: 1rem;
    }
</style>
@extends('student.main')
{{-- @include('student.header') --}}
@section('content')
    <div class="box">
        <div class="box-header"></div>
            <div class="box-body">
                <div class="col-md-12 text-uppercase text-white text-center bg-warning" style="margin:2em;padding:5px;border-radius:2px">{{ __('student application area') }}</div>
                @include('includes.errors.custom')
                    {!!Form::open(['action'=>'Student\Applications\ApplicationsController@store','method'=>'post','enctype'=>'multipart/form-data'])!!}
                    <div class="col-md-12 row">
                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-header text-uppercase text-white text-center bg-success" style="margin-bottom:2em">{{ __('PERSONAL INFORMATION') }}</div>
                                <div class="card-body">
                                    <div class="form-group row">
                                        {!! Form::label('name','Name',['class'=>'form-label text-md-right col-md-4']) !!}
                                        <div class="col-md-8">
                                            {!!Form::text('name',Auth::user()->name,['class'=>'form-control'])!!}
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        {!!Form::label('reg_number','Reg No/Adm',['class'=>'form-label text-md-right col-md-4'])!!}
                                        <div class="col-md-8">
                                            {!!Form::text('reg_number',old('reg_number'),['class'=>'form-control','placeholder'=>'Reg No/Adm'])!!}
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        {!! Form::label('phone','Phone No:', ['class'=>'form-label text-md-right col-md-4']) !!}
                                        <div class="col-md-8">
                                            {!! Form::text('phone',old('phone'), ['class'=>'form-control']) !!}
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer"></div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-header text-center bg-success text-white" style="margin-bottom:2em">PROGRAMME INFORMATION</div>
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
                                        old('current_program'),
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
                                             old('current_school'),
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
                                             old('preffered_program'),
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
                                             old('preffered_school'),
                                             ['class'=>'form-control']) !!}
                                         </div>
                                    </div>
                                </div>
                                <div class="card-footer"></div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-header text-white bg-success text-uppercase text-center" style="margin-bottom:2em">KCSE INFORMATION</div>
                                <div class="card-body">
                                    <div class="form-group row">
                                        {!! Form::label('kcse_index', 'KCSE Index No:', ['class'=>'col-md-4 form-label text-md-right']) !!}
                                        <div class="col-md-8">
                                            {!! Form::number('kcse_index',old('kcse_index') , ['class'=>'form-control','required'=>true]) !!}
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        {!!Form::label('kcse_year','KCSE Year',['class'=>'form-label text-md-right col-md-4'])!!}
                                        <div class="col-md-8">
                                            {!! Form::selectRange('kcse_year',date('Y')-6,date('Y')-1,old('kcse_year') ,['class'=>'form-control'])!!}
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        {!! Form::label('kuccps_password', 'KUCCPS Password',['class'=>'form-label col-md-4 text-md-right']) !!}
                                        <div class="col-md-8">
                                            {!! Form::text('kuccps_password',old('kuccps_password') , ['class'=>'form-control','placeholder'=>'either KCSE Index/Birth Cert No','required'=>true]) !!}
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        {!! Form::label('mean_grade','Mean Grade', ['class'=>'form-label text-md-right col-md-4']) !!}
                                        <div class="col-md-8">
                                            {!! Form::text('mean_grade',old('mean_grade'), ['class'=>'form-control','required'=>true]) !!}
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        {!! Form::label('aggregate','Aggregate Points', ['class'=>'form-label col-md-4 text-md-right']) !!}
                                        <div class="col-md-8">
                                            {!! Form::number('aggregate', old('aggregate') , ['class'=>'form-control','required'=>true]) !!}
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        {!! Form::label('cut_off_points','Cut Off Points', ['class'=>'form-label text-md-right col-md-4']) !!}
                                        <div class="col-md-8">
                                            {!! Form::number('cut_off_points',old('cut_off_points') , ['class'=>'form-control','required'=>true]) !!}
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        {!! Form::label('weighted_clusters','Weighted Cluster points', ['class'=>'form-label text-md-right col-md-4']) !!}
                                        <div class="col-md-8">
                                            {!! Form::number('weighted_clusters',old('weighted_clusters') , ['class'=>'form-control','required'=>true]) !!}
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 row">
                        <div class="box">
                            <div class="box-header text-uppercase text-white bg-info text-center">{{ __('kcse performance subject and grades') }}</div>
                            <div class="box-body">
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        {!! Form::label('sub_1','Subject One', ['class'=>'form-label col-md-4 text-md-right']) !!}
                                        <div class="col-md-8">
                                            {!! Form::text('sub_1',old('sub_1'),['class'=>'form-control','required'=>true]) !!}
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        {!! Form::label('sub_2','Subject Two', ['class'=>'form-label col-md-4 text-md-right']) !!}
                                        <div class="col-md-8">
                                            {!! Form::text('sub_2',old('sub_2'), ['class'=>'form-control','required'=>true]) !!}
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        {!! Form::label('sub_3','Subject Three', ['class'=>'form-label text-md-right col-md-4']) !!}
                                        <div class="col-md-8">
                                            {!! Form::text('sub_3',old('sub_3'), ['class'=>'form-control','required'=>true]) !!}
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        {!! Form::label('sub_4','Subject Four', ['class'=>'form-label text-md-right col-md-4']) !!}
                                        <div class="col-md-8">
                                            {!! Form::text('sub_4', old('sub_4'), ['class'=>'form-control','required'=>true]) !!}
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        {!! Form::label('sub_5','Subject Five', ['class'=>'form-label text-md-right col-md-4']) !!}
                                        <div class="col-md-8">
                                            {!! Form::text('sub_5',old('sub_5'), ['class'=>'form-control','required'=>true]) !!}
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        {!! Form::label('sub_6','Subject Six', ['class'=>'form-label text-md-right col-md-4']) !!}
                                        <div class="col-md-8">
                                            {!! Form::text('sub_6', old('sub_6'), ['class'=>'form-control','required'=>true]) !!}
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        {!! Form::label('sub_7','Subject Seven', ['class'=>'form-label text-md-right col-md-4']) !!}
                                        <div class="col-md-8">
                                            {!! Form::text('sub_7',old('sub_7'), ['class'=>'form-control','required'=>true]) !!}
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        {!! Form::label('sub_8','Subject Eight', ['class'=>'form-label text-md-right col-md-4']) !!}
                                        <div class="col-md-8">
                                            {!! Form::text('sub_8', old('sub_8'), ['class'=>'form-control','required'=>true]) !!}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        {!! Form::label('grade_1','Grade', ['class'=>'form-label col-md-4 text-md-right']) !!}
                                        <div class="col-md-8">
                                            {!! Form::select('grade_1',
                                            ['A'=>'A','A-'=>'A-','B+'=>'B+','B'=>'B','B-'=>'B-','C+'=>'C+','C'=>'C','C-'=>'C-','D+'=>'D+','D'=>'D','D-'=>'D-','E'=>'E'],
                                            old('grade_1'), ['class'=>'form-control','required'=>true]) !!}
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        {!! Form::label('grade_2','Grade', ['class'=>'form-label col-md-4 text-md-right']) !!}
                                        <div class="col-md-8">
                                            {!! Form::select('grade_2',
                                            ['A'=>'A','A-'=>'A-','B+'=>'B+','B'=>'B','B-'=>'B-','C+'=>'C+','C'=>'C','C-'=>'C-','D+'=>'D+','D'=>'D','D-'=>'D-','E'=>'E'],
                                            old('grade_2'), ['class'=>'form-control','required'=>true]) !!}
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        {!! Form::label('grade_3','Grade', ['class'=>'form-label col-md-4 text-md-right']) !!}
                                        <div class="col-md-8">
                                            {!! Form::select('grade_3',
                                            ['A'=>'A','A-'=>'A-','B+'=>'B+','B'=>'B','B-'=>'B-','C+'=>'C+','C'=>'C','C-'=>'C-','D+'=>'D+','D'=>'D','D-'=>'D-','E'=>'E'],
                                            old('grade_3'), ['class'=>'form-control','required'=>true]) !!}
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        {!! Form::label('grade_4','Grade', ['class'=>'form-label col-md-4 text-md-right']) !!}
                                        <div class="col-md-8">
                                            {!! Form::select('grade_4',
                                            ['A'=>'A','A-'=>'A-','B+'=>'B+','B'=>'B','B-'=>'B-','C+'=>'C+','C'=>'C','C-'=>'C-','D+'=>'D+','D'=>'D','D-'=>'D-','E'=>'E'],
                                            old('grade_4'), ['class'=>'form-control','required'=>true]) !!}
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        {!! Form::label('grade_5','Grade', ['class'=>'form-label col-md-4 text-md-right']) !!}
                                        <div class="col-md-8">
                                            {!! Form::select('grade_5',
                                            ['A'=>'A','A-'=>'A-','B+'=>'B+','B'=>'B','B-'=>'B-','C+'=>'C+','C'=>'C','C-'=>'C-','D+'=>'D+','D'=>'D','D-'=>'D-','E'=>'E'],
                                            old('grade_5'), ['class'=>'form-control','required'=>true]) !!}
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        {!! Form::label('grade_6','Grade', ['class'=>'form-label col-md-4 text-md-right']) !!}
                                        <div class="col-md-8">
                                            {!! Form::select('grade_6',
                                            ['A'=>'A','A-'=>'A-','B+'=>'B+','B'=>'B','B-'=>'B-','C+'=>'C+','C'=>'C','C-'=>'C-','D+'=>'D+','D'=>'D','D-'=>'D-','E'=>'E'],
                                            old('grade_6'), ['class'=>'form-control','required'=>true]) !!}
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        {!! Form::label('grade_7','Grade', ['class'=>'form-label col-md-4 text-md-right']) !!}
                                        <div class="col-md-8">
                                            {!! Form::select('grade_7',
                                            ['A'=>'A','A-'=>'A-','B+'=>'B+','B'=>'B','B-'=>'B-','C+'=>'C+','C'=>'C','C-'=>'C-','D+'=>'D+','D'=>'D','D-'=>'D-','E'=>'E'],
                                            old('grade_7'), ['class'=>'form-control','required'=>true]) !!}
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        {!! Form::label('grade_8','Grade', ['class'=>'form-label col-md-4 text-md-right']) !!}
                                        <div class="col-md-8">
                                            {!! Form::select('grade_8',
                                            ['A'=>'A','A-'=>'A-','B+'=>'B+','B'=>'B','B-'=>'B-','C+'=>'C+','C'=>'C','C-'=>'C-','D+'=>'D+','D'=>'D','D-'=>'D-','E'=>'E'],
                                            old('grade_8'), ['class'=>'form-control','required'=>true]) !!}
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-12 row">
                                    <hr>
                                    <div class="col-md-6">
                                        <div class="form-group row">
                                            {!! Form::label('transfer_reason','Reason for Transfer', ['class'=>'form-label text-md-right col-md-4']) !!}
                                            <div class="col-md-8">
                                                {!! Form::textarea('transfer_reason',old('transfer_reason'), ['class'=>'form-control']) !!}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group row">
                                            {!! Form::label('result_slip','Upload a copy of KCSE result slip', ['class'=>'form-label text-md-right col-md-4 text-danger']) !!}
                                            <div class="col-md-8">
                                                {!! Form::file('result_slip', ['class'=>'btn btn-success btn-sm','required'=>true]) !!}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12 text-center text-white">
                                        <button class="btn btn-sm btn-primary text-center" type="submit" id="submit-btn">
                                            {{ __('SUBMIT') }}
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="box-footer"></div>
                        </div>
                    </div>
                {!! Form::close() !!}
            </div>
            <div class="box-footer"></div>
        </div>
@endsection
