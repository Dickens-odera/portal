<style type="text/css">
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
                <div class="col-md-12 text-uppercase text-white text-center bg-warning" style="margin:2em;padding:5px;border-radius:2px">{{ __('student application (Edit To Update)') }}</div>
                    {!!Form::open(['action'=>['Student\Applications\ApplicationsController@update','app_id'=>$application->app_id],'method'=>'post','enctype'=>'multipart/form-data'])!!}
                    <div class="col-md-12 row">
                        @include('includes.errors.custom')
                        <div class="col-md-4">
                            <div class="card">
                                <div class="table-responsive card-header text-uppercase text-white text-center bg-success" style="margin-bottom:2em">{{ __('PERSONAL INFORMATION') }}</div>
                                <div class="card-body">
                                    <div class="form-group row">
                                        {!! Form::label('student_name','Name',['class'=>'form-label text-md-right col-md-4']) !!}
                                        <div class="col-md-8">
                                            {!!Form::text('student_name',$application->student_name,['class'=>'form-control'])!!}
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        {!!Form::label('reg_number','Reg No/Adm',['class'=>'form-label text-md-right col-md-4'])!!}
                                        <div class="col-md-8">
                                            {!!Form::text('reg_number',$application->reg_number,['class'=>'form-control','placeholder'=>'Reg No/Adm'])!!}
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        {!! Form::label('student_phone','Phone No:', ['class'=>'form-label text-md-right col-md-4']) !!}
                                        <div class="col-md-8">
                                            {!! Form::text('student_phone',$application->student_phone, ['class'=>'form-control']) !!}
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        {!! Form::label('student_id','ID No:', ['class'=>'form-label text-md-right col-md-4']) !!}
                                        <div class="col-md-8">
                                            {!! Form::text('student_id',$application->IdNumber, ['class'=>'form-control']) !!}
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
                                       'Bsc Computer Science'=>'Bsc Computer Science',
                                       'Bsc Information Technology'=>'Bsc Information Technology',
                                       'Bsc Education Technolofy Computer Studies'=>'Bsc Education Technolofy Computer Studies',
                                       'Bsc Information Systems and Knowledge Management'=>'Bsc Information Systems and Knowledge Management'
                                    ],
                                    $application->present_program,
                                        ['class'=>'form-control']) !!}
                                    </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="current_school" class="form-label text-md-right col-md-4">{{ __('Present School') }}</label>
                                        <div class="col-md-8">
                                            {!! Form::select('current_school',
                                            [''=>'Select...',
                                            'SCI'=>'School of Computing and Informatics',
                                            'SEDU'=>'School of Education',
                                            'SOM'=>'School of Medicine',
                                            'SASS'=>'School of Arts and Social Sciences',
                                            'SONAS'=>'School of Natural Sciences',
                                            'SOBE'=>'School of Business',
                                            'SIDHMA'=>'School of Disaster and Humanitarian Assisstance'],
                                            $application->present_school,
                                             ['class'=>'form-control']) !!}
                                         </div>
                                    </div>
                                    <div class="form-group row">
                                        {!! Form::label('prefferd_program','Preffered Program', ['class'=>'form-label col-md-4 text-md-right']) !!}
                                        <div class="col-md-8">
                                            {!! Form::select('preffered_program',
                                            [''=>'Select...',
                                       'Bsc Computer Science'=>'Bsc Computer Science',
                                       'Bsc Information Technology'=>'Bsc Information Technology',
                                       'Bsc Education Technolofy Computer Studies'=>'Bsc Education Technolofy Computer Studies',
                                       'Bsc Information Systems and Knowledge Management'=>'Bsc Information Systems and Knowledge Management'
                                    ],
                                            $application->preffered_program,
                                             ['class'=>'form-control']) !!}
                                         </div>
                                    </div>
                                    <div class="form-group row">
                                        {!! Form::label('cluster_no','Cluster No', ['class'=>'form-label text-md-right col-md-4']) !!}
                                        <div class="col-md-8">
                                            {!! Form::number('cluster_no',$application->cluster_no, ['class'=>'form-control']) !!}
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        {!! Form::label('preffered_school','Preffered School', ['class'=>'form-label text-md-right col-md-4']) !!}
                                        <div class="col-md-8">
                                            {!! Form::select('preffered_school',
                                            [''=>'Select...',
                                            'SCI'=>'School of Computing and Informatics',
                                            'SEDU'=>'School of Education',
                                            'SOM'=>'School of Medicine',
                                            'SASS'=>'School of Arts and Social Sciences',
                                            'SONAS'=>'School of Natural Sciences',
                                            'SOBE'=>'School of Business',
                                            'SIDHMA'=>'School of Disaster and Humanitarian Assisstance'],
                                            $application->preffered_school,
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
                                            {!! Form::number('kcse_index',$application->kcse_index , ['class'=>'form-control','required'=>true]) !!}
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        {!!Form::label('kcse_year','KCSE Year',['class'=>'form-label text-md-right col-md-4'])!!}
                                        <div class="col-md-8">
                                            {!! Form::selectRange('kcse_year',date('Y')-6,date('Y')-1,$application->kcse_year ,['class'=>'form-control'])!!}
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        {!! Form::label('kuccps_password', 'KUCCPS Password',['class'=>'form-label col-md-4 text-md-right']) !!}
                                        <div class="col-md-8">
                                            {!! Form::text('kuccps_password',$application->kuccps_password, ['class'=>'form-control','placeholder'=>'either KCSE Index/Birth Cert No','required'=>true]) !!}
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        {!! Form::label('mean_grade','Mean Grade', ['class'=>'form-label text-md-right col-md-4']) !!}
                                        <div class="col-md-8">
                                            {!! Form::text('mean_grade',$application->mean_grade, ['class'=>'form-control','required'=>true]) !!}
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        {!! Form::label('aggregate','Aggregate Points', ['class'=>'form-label col-md-4 text-md-right']) !!}
                                        <div class="col-md-8">
                                            {!! Form::number('aggregate',$application->aggregate_points , ['class'=>'form-control','required'=>true]) !!}
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        {!! Form::label('cut_off_points','Cut Off Points', ['class'=>'form-label text-md-right col-md-4']) !!}
                                        <div class="col-md-8">
                                            {!! Form::number('cut_off_points',$application->cut_off_points , ['class'=>'form-control','required'=>true]) !!}
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        {!! Form::label('weighted_clusters','Weighted Cluster points', ['class'=>'form-label text-md-right col-md-4']) !!}
                                        <div class="col-md-8">
                                            {!! Form::number('weighted_clusters',$application->weighted_clusters , ['class'=>'form-control','required'=>true]) !!}
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
                                            {!! Form::text('sub_1',$application->subject_1,['class'=>'form-control','required'=>true]) !!}
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        {!! Form::label('sub_2','Subject Two', ['class'=>'form-label col-md-4 text-md-right']) !!}
                                        <div class="col-md-8">
                                            {!! Form::text('sub_2',$application->subject_2, ['class'=>'form-control','required'=>true]) !!}
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        {!! Form::label('sub_3','Subject Three', ['class'=>'form-label text-md-right col-md-4']) !!}
                                        <div class="col-md-8">
                                            {!! Form::text('sub_3',$application->subject_3, ['class'=>'form-control','required'=>true]) !!}
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        {!! Form::label('sub_4','Subject Four', ['class'=>'form-label text-md-right col-md-4']) !!}
                                        <div class="col-md-8">
                                            {!! Form::text('sub_4',$application->subject_4, ['class'=>'form-control','required'=>true]) !!}
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        {!! Form::label('sub_5','Subject Five', ['class'=>'form-label text-md-right col-md-4']) !!}
                                        <div class="col-md-8">
                                            {!! Form::text('sub_5',$application->subject_5, ['class'=>'form-control','required'=>true]) !!}
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        {!! Form::label('sub_6','Subject Six', ['class'=>'form-label text-md-right col-md-4']) !!}
                                        <div class="col-md-8">
                                            {!! Form::text('sub_6',$application->subject_6, ['class'=>'form-control','required'=>true]) !!}
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        {!! Form::label('sub_7','Subject Seven', ['class'=>'form-label text-md-right col-md-4']) !!}
                                        <div class="col-md-8">
                                            {!! Form::text('sub_7',$application->subject_7, ['class'=>'form-control','required'=>true]) !!}
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        {!! Form::label('sub_8','Subject Eight', ['class'=>'form-label text-md-right col-md-4']) !!}
                                        <div class="col-md-8">
                                            {!! Form::text('sub_8',$application->subject_8, ['class'=>'form-control','required'=>true]) !!}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        {!! Form::label('grade_1','Grade', ['class'=>'form-label col-md-4 text-md-right']) !!}
                                        <div class="col-md-8">
                                            {!! Form::select('grade_1',
                                            ['A'=>'A','A-'=>'A-','B+'=>'B+','B'=>'B','B-'=>'B-','C+'=>'C+','C'=>'C','C-'=>'C-','D+'=>'D+','D'=>'D','D-'=>'D-','E'=>'E'],
                                            $application->grade_1, ['class'=>'form-control','required'=>true]) !!}
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        {!! Form::label('grade_2','Grade', ['class'=>'form-label col-md-4 text-md-right']) !!}
                                        <div class="col-md-8">
                                            {!! Form::select('grade_2',
                                            ['A'=>'A','A-'=>'A-','B+'=>'B+','B'=>'B','B-'=>'B-','C+'=>'C+','C'=>'C','C-'=>'C-','D+'=>'D+','D'=>'D','D-'=>'D-','E'=>'E'],
                                            $application->grade_2, ['class'=>'form-control','required'=>true]) !!}
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        {!! Form::label('grade_3','Grade', ['class'=>'form-label col-md-4 text-md-right']) !!}
                                        <div class="col-md-8">
                                            {!! Form::select('grade_3',
                                            ['A'=>'A','A-'=>'A-','B+'=>'B+','B'=>'B','B-'=>'B-','C+'=>'C+','C'=>'C','C-'=>'C-','D+'=>'D+','D'=>'D','D-'=>'D-','E'=>'E'],
                                            $application->grade_3, ['class'=>'form-control','required'=>true]) !!}
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        {!! Form::label('grade_4','Grade', ['class'=>'form-label col-md-4 text-md-right']) !!}
                                        <div class="col-md-8">
                                            {!! Form::select('grade_4',
                                            ['A'=>'A','A-'=>'A-','B+'=>'B+','B'=>'B','B-'=>'B-','C+'=>'C+','C'=>'C','C-'=>'C-','D+'=>'D+','D'=>'D','D-'=>'D-','E'=>'E'],
                                            $application->grade_4, ['class'=>'form-control','required'=>true]) !!}
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        {!! Form::label('grade_5','Grade', ['class'=>'form-label col-md-4 text-md-right']) !!}
                                        <div class="col-md-8">
                                            {!! Form::select('grade_5',
                                            ['A'=>'A','A-'=>'A-','B+'=>'B+','B'=>'B','B-'=>'B-','C+'=>'C+','C'=>'C','C-'=>'C-','D+'=>'D+','D'=>'D','D-'=>'D-','E'=>'E'],
                                            $application->grade_5, ['class'=>'form-control','required'=>true]) !!}
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        {!! Form::label('grade_6','Grade', ['class'=>'form-label col-md-4 text-md-right']) !!}
                                        <div class="col-md-8">
                                            {!! Form::select('grade_6',
                                            ['A'=>'A','A-'=>'A-','B+'=>'B+','B'=>'B','B-'=>'B-','C+'=>'C+','C'=>'C','C-'=>'C-','D+'=>'D+','D'=>'D','D-'=>'D-','E'=>'E'],
                                            $application->grade_6, ['class'=>'form-control','required'=>true]) !!}
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        {!! Form::label('grade_7','Grade', ['class'=>'form-label col-md-4 text-md-right']) !!}
                                        <div class="col-md-8">
                                            {!! Form::select('grade_7',
                                            ['A'=>'A','A-'=>'A-','B+'=>'B+','B'=>'B','B-'=>'B-','C+'=>'C+','C'=>'C','C-'=>'C-','D+'=>'D+','D'=>'D','D-'=>'D-','E'=>'E'],
                                            $application->grade_7, ['class'=>'form-control','required'=>true]) !!}
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        {!! Form::label('grade_8','Grade', ['class'=>'form-label col-md-4 text-md-right']) !!}
                                        <div class="col-md-8">
                                            {!! Form::select('grade_8',
                                            ['A'=>'A','A-'=>'A-','B+'=>'B+','B'=>'B','B-'=>'B-','C+'=>'C+','C'=>'C','C-'=>'C-','D+'=>'D+','D'=>'D','D-'=>'D-','E'=>'E'],
                                            $application->grade_8, ['class'=>'form-control','required'=>true]) !!}
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-12 row">
                                    <hr>
                                    <div class="col-md-6">
                                        <div class="form-group row">
                                            {!! Form::label('transfer_reason','Reason for Transfer', ['class'=>'form-label text-md-right col-md-4']) !!}
                                            <div class="col-md-8">
                                                {!! Form::textarea('transfer_reason',$application->transfer_reason, ['class'=>'form-control']) !!}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group row">
                                             {!! Form::label('result_slip','Upload a copy of KCSE result slip', ['class'=>'form-label text-md-right col-md-4 text-danger']) !!} 
                                            <div class="col-md-8">
                                                <img src="/storage/uploads/images/applications/result-slips/{{ $application->result_slip}}" alt="No image" style=""><br>
                                                 {!! Form::file('result_slip', ['class'=>'btn btn-success btn-sm']) !!} 
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12 text-center text-white">
                                        <button class="btn btn-sm btn-primary text-center" type="submit" id="submit-btn">
                                            {{ __('UPDATE') }}
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
