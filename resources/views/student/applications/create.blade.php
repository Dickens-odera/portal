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
<link href="https://cdn.jsdelivr.net/npm/smartwizard@5/dist/css/smart_wizard_all.min.css" rel="stylesheet" type="text/css" />

    <div class="box">
        <div class="box-header"></div>
            <div class="box-body">
                <div class="col-md-12 text-uppercase text-white text-center bg-warning" style="margin:2em;padding:5px;border-radius:2px">{{ __('student application area') }}</div>
                    {!!Form::open(['action'=>'Student\Applications\ApplicationsController@store','method'=>'post','enctype'=>'multipart/form-data'])!!}
                    <div class="col-md-12 row">
                        @include('includes.errors.custom')
                        <div class="col-md-4">
                            <div class="card">
                                <div class="table-responsive card-header text-uppercase text-white text-center bg-success" style="margin-bottom:2em">{{ __('PERSONAL INFORMATION') }}</div>
                                <div class="card-body">
                                    <div class="form-group row">
                                        {!! Form::label('student_name','Name',['class'=>'form-label text-md-right col-md-4']) !!}
                                        <div class="col-md-8">
                                            {!!Form::text('student_name',Auth::user()->surname.' '.Auth::user()->middleName.' '.Auth::user()->lastName,['class'=>'form-control'])!!}
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        {!!Form::label('reg_number','Reg No/Adm',['class'=>'form-label text-md-right col-md-4'])!!}
                                        <div class="col-md-8">
                                            {!!Form::text('reg_number',Auth::user()->regNumber,['class'=>'form-control','placeholder'=>'Reg No/Adm'])!!}
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        {!! Form::label('student_phone','Phone No:', ['class'=>'form-label text-md-right col-md-4']) !!}
                                        <div class="col-md-8">
                                            {!! Form::text('student_phone',old('student_phone'), ['class'=>'form-control']) !!}
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        {!! Form::label('student_id','ID No:', ['class'=>'form-label text-md-right col-md-4']) !!}
                                        <div class="col-md-8">
                                            {!! Form::text('student_id',old('student_id'), ['class'=>'form-control']) !!}
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
                                       {{-- {!! Form::select('current_program',
                                    [''=>'Select...',
                                       'Bsc Computer Science'=>'Bsc Computer Science',
                                       'Bsc Information Technology'=>'Bsc Information Technology',
                                       'Bsc Education Technolofy Computer Studies'=>'Bsc Education Technolofy Computer Studies',
                                       'Bsc Information Systems and Knowledge Management'=>'Bsc Information Systems and Knowledge Management'
                                    ],
                                        old('current_program'),
                                        ['class'=>'form-control']) !!} --}}
                                        <select name="current_program" id="current_program" class="form-control">
                                            <option value="">Select Program...</option>
                                            @if(count($programs) > 0)
                                                @foreach ($programs as $key=>$value)
                                                    <option value="{{ $value->program }}">{{ $value->program }}</option>
                                                @endforeach
                                            @endif
                                            {{ old('current_program')}}
                                        </select>
                                    </div>
                                    </div>
                                    {{-- <div class="form-group row">
                                        <label for="current_school" class="form-label text-md-right col-md-4">{{ __('Present School') }}</label>
                                        <div class="col-md-8">
                                            {!! Form::select('current_school',
                                            [''=>'Select...',
                                                'School of Computing and Informatics'=>'School of Computing and Informatics',
                                                'School of Education'=>'School of Education',
                                                'School of Medicine'=>'School of Medicine',
                                                'School of Arts and Social Sciences'=>'School of Arts and Social Sciences',
                                                'School of Natural Sciences'=>'School of Natural Sciences',
                                                'School of Business'=>'School of Business',
                                                'School of Disaster and Humanitarian Assisstance'=>'School of Disaster and Humanitarian Assisstance',
                                                'School of Nursing and Paramedic Sciences'=>'School of Nursing and Paramedic Sciences',
                                                'School of Agriculture,Vetenery Siences and Technology'=>'School of Agriculture,Vetenery Siences and Technology',
                                                'School of Public Health'=>'School of Public Health'],
                                             old('current_school'),
                                             ['class'=>'form-control']) !!}
                                         </div>
                                    </div> --}}
                                    <div class="form-group row">
                                        {!! Form::label('preffered_program','Preffered Program', ['class'=>'form-label col-md-4 text-md-right']) !!}
                                        <div class="col-md-8">
                                            {{-- {!! Form::select('preffered_program',
                                            [''=>'Select...',
                                                'Bsc Computer Science'=>'Bsc Computer Science',
                                                'Bsc Information Technology'=>'Bsc Information Technology',
                                                'Bsc Education Technolofy Computer Studies'=>'Bsc Education Technolofy Computer Studies',
                                                'Bsc Information Systems and Knowledge Management'=>'Bsc Information Systems and Knowledge Management'
                                            ],
                                             old('preffered_program'),
                                             ['class'=>'form-control'])
                                             !!} --}}
                                             <select name="preffered_program" id="preffered_program" class="form-control">
                                                <option value="">Select Program...</option>
                                                @if(count($programs) > 0)
                                                    @foreach ($programs as $key=>$value)
                                                        <option value="{{ $value->program }}">{{ $value->program }}</option>
                                                    @endforeach
                                                @endif
                                                {{ old('preffered_program')}}
                                            </select>
                                         </div>
                                    </div>
                                    <div class="form-group row">
                                        {!! Form::label('cluster_no','Cluster No', ['class'=>'form-label text-md-right col-md-4']) !!}
                                        <div class="col-md-8">
                                            {!! Form::number('cluster_no',old('cluster_no'), ['class'=>'form-control']) !!}
                                        </div>
                                    </div>
                                    {{-- <div class="form-group row">
                                        {!! Form::label('preffered_school','Preffered School', ['class'=>'form-label text-md-right col-md-4']) !!}
                                        <div class="col-md-8">
                                            {!! Form::select('preffered_school',
                                            [''=>'Select...',
                                                'School of Computing and Informatics'=>'School of Computing and Informatics',
                                                'School of Education'=>'School of Education',
                                                'School of Medicine'=>'School of Medicine',
                                                'School of Arts and Social Sciences'=>'School of Arts and Social Sciences',
                                                'School of Natural Sciences'=>'School of Natural Sciences',
                                                'School of Business'=>'School of Business',
                                                'School of Disaster and Humanitarian Assisstance'=>'School of Disaster and Humanitarian Assisstance',
                                                'School of Nursing and Paramedic Sciences'=>'School of Nursing and Paramedic Sciences',
                                                'School of Agriculture,Vetenery Siences and Technology'=>'School of Agriculture,Vetenery Siences and Technology',
                                                'School of Public Health'=>'School of Public Health'],
                                             old('preffered_school'),
                                             ['class'=>'form-control'])
                                             !!}
                                         </div>
                                    </div> --}}
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
                                            <select name="sub_1" id="sub_1" class="form-control">
                                                <option value="">Select Subject</option>
                                                @if(count($subjects) > 0)
                                                    @foreach($subjects as $k=>$v)
                                                        <option value="{{ $v->name }}">{{ $v->name }}</option>
                                                    @endforeach
                                            {{-- {!! Form::text('sub_1',old('sub_1'),['class'=>'form-control','required'=>true]) !!} --}}
                                                @endif
                                                {{ old('sub_1') }}
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        {!! Form::label('sub_2','Subject Two', ['class'=>'form-label col-md-4 text-md-right']) !!}
                                        <div class="col-md-8">
                                            <select name="sub_2" id="sub_2" class="form-control" value="{{ old('sub_2') }}">
                                                <option value="">Select Subject</option>
                                                @if(count($subjects) > 0)
                                                    @foreach($subjects as $k=>$v)
                                                        <option value="{{ $v->name }}">{{ $v->name }}</option>
                                                    @endforeach
                                            {{-- {!! Form::text('sub_1',old('sub_1'),['class'=>'form-control','required'=>true]) !!} --}}
                                                @endif
                                                {{ old('sub_2') }}
                                            </select>
                                            {{-- {!! Form::text('sub_2',old('sub_2'), ['class'=>'form-control','required'=>true]) !!} --}}
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        {!! Form::label('sub_3','Subject Three', ['class'=>'form-label text-md-right col-md-4']) !!}
                                        <div class="col-md-8">
                                            <select name="sub_3" id="sub_3" class="form-control">
                                                <option value="">Select Subject</option>
                                                @if(count($subjects) > 0)
                                                    @foreach($subjects as $k=>$v)
                                                        <option value="{{ $v->name }}">{{ $v->name }}</option>
                                                    @endforeach
                                            {{-- {!! Form::text('sub_1',old('sub_1'),['class'=>'form-control','required'=>true]) !!} --}}
                                                @endif
                                                {{ old('sub_3') }}
                                            </select>
                                            {{-- {!! Form::text('sub_3',old('sub_3'), ['class'=>'form-control','required'=>true]) !!} --}}
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        {!! Form::label('sub_4','Subject Four', ['class'=>'form-label text-md-right col-md-4']) !!}
                                        <div class="col-md-8">
                                            <select name="sub_4" id="sub_4" class="form-control">
                                                <option value="">Select Subject</option>
                                                @if(count($subjects) > 0)
                                                    @foreach($subjects as $k=>$v)
                                                        <option value="{{ $v->name }}">{{ $v->name }}</option>
                                                    @endforeach
                                            {{-- {!! Form::text('sub_1',old('sub_1'),['class'=>'form-control','required'=>true]) !!} --}}
                                                @endif
                                                {{ old('sub_4') }}
                                            </select>
                                            {{-- {!! Form::text('sub_4', old('sub_4'), ['class'=>'form-control','required'=>true]) !!} --}}
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        {!! Form::label('sub_5','Subject Five', ['class'=>'form-label text-md-right col-md-4']) !!}
                                        <div class="col-md-8">
                                            <select name="sub_5" id="sub_5" class="form-control">
                                                <option value="">Select Subject</option>
                                                @if(count($subjects) > 0)
                                                    @foreach($subjects as $k=>$v)
                                                        <option value="{{ $v->name }}">{{ $v->name }}</option>
                                                    @endforeach
                                            {{-- {!! Form::text('sub_1',old('sub_1'),['class'=>'form-control','required'=>true]) !!} --}}
                                                @endif
                                                {{ old('sub_5') }}
                                            </select>
                                            {{-- {!! Form::text('sub_5',old('sub_5'), ['class'=>'form-control','required'=>true]) !!} --}}
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        {!! Form::label('sub_6','Subject Six', ['class'=>'form-label text-md-right col-md-4']) !!}
                                        <div class="col-md-8">
                                            <select name="sub_6" id="sub_6" class="form-control">
                                                <option value="">Select Subject</option>
                                                @if(count($subjects) > 0)
                                                    @foreach($subjects as $k=>$v)
                                                        <option value="{{ $v->name }}">{{ $v->name }}</option>
                                                    @endforeach
                                            {{-- {!! Form::text('sub_1',old('sub_1'),['class'=>'form-control','required'=>true]) !!} --}}
                                                @endif
                                                {{ old('sub_6') }}
                                            </select>
                                            {{-- {!! Form::text('sub_6', old('sub_6'), ['class'=>'form-control','required'=>true]) !!} --}}
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        {!! Form::label('sub_7','Subject Seven', ['class'=>'form-label text-md-right col-md-4']) !!}
                                        <div class="col-md-8">
                                            <select name="sub_7" id="sub_7" class="form-control">
                                                <option value="">Select Subject</option>
                                                @if(count($subjects) > 0)
                                                    @foreach($subjects as $k=>$v)
                                                        <option value="{{ $v->name }}">{{ $v->name }}</option>
                                                    @endforeach
                                            {{-- {!! Form::text('sub_1',old('sub_1'),['class'=>'form-control','required'=>true]) !!} --}}
                                                @endif
                                                {{ old('sub_7') }}
                                            </select>
                                            {{-- {!! Form::text('sub_7',old('sub_7'), ['class'=>'form-control','required'=>true]) !!} --}}
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        {!! Form::label('sub_8','Subject Eight', ['class'=>'form-label text-md-right col-md-4']) !!}
                                        <div class="col-md-8">
                                            <select name="sub_8" id="sub_8" class="form-control">
                                                <option value="">Select Subject</option>
                                                @if(count($subjects) > 0)
                                                    @foreach($subjects as $k=>$v)
                                                        <option value="{{ $v->name }}">{{ $v->name }}</option>
                                                    @endforeach
                                            {{-- {!! Form::text('sub_1',old('sub_1'),['class'=>'form-control','required'=>true]) !!} --}}
                                                @endif
                                                {{ old('sub_8') }}
                                            </select>
                                            {{-- {!! Form::text('sub_8', old('sub_8'), ['class'=>'form-control','required'=>true]) !!} --}}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        {!! Form::label('grade_1','Grade 1', ['class'=>'form-label col-md-4 text-md-right']) !!}
                                        <div class="col-md-8">
                                            {{-- {!! Form::select('grade_1',
                                            ['A'=>'A','A-'=>'A-','B+'=>'B+','B'=>'B','B-'=>'B-','C+'=>'C+','C'=>'C','C-'=>'C-','D+'=>'D+','D'=>'D','D-'=>'D-','E'=>'E'],
                                            old('grade_1'), ['class'=>'form-control','required'=>true]) !!} --}}
                                            <select name="grade_1" class="form-control">
                                                <option value="">Select Grade...</option>
                                                @if(count($grades) > 0)
                                                    @foreach($grades as $k=>$v)
                                                        <option value="{{ $v->name }}">{{ $v->name }}</option>
                                                    @endforeach
                                                @endif
                                                {{ old('grade_1') }}
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        {!! Form::label('grade_2','Grade 1', ['class'=>'form-label col-md-4 text-md-right']) !!}
                                        <div class="col-md-8">
                                            {{-- {!! Form::select('grade_2',
                                            ['A'=>'A','A-'=>'A-','B+'=>'B+','B'=>'B','B-'=>'B-','C+'=>'C+','C'=>'C','C-'=>'C-','D+'=>'D+','D'=>'D','D-'=>'D-','E'=>'E'],
                                            old('grade_2'), ['class'=>'form-control','required'=>true]) !!} --}}
                                            <select name="grade_2" class="form-control">
                                                <option value="">Select Grade...</option>
                                                @if(count($grades) > 0)
                                                    @foreach($grades as $k=>$v)
                                                        <option value="{{ $v->name }}">{{ $v->name }}</option>
                                                    @endforeach
                                                @endif
                                                {{ old('grade_2') }}
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        {!! Form::label('grade_3','Grade 3', ['class'=>'form-label col-md-4 text-md-right']) !!}
                                        <div class="col-md-8">
                                            {{-- {!! Form::select('grade_3',
                                            ['A'=>'A','A-'=>'A-','B+'=>'B+','B'=>'B','B-'=>'B-','C+'=>'C+','C'=>'C','C-'=>'C-','D+'=>'D+','D'=>'D','D-'=>'D-','E'=>'E'],
                                            old('grade_3'), ['class'=>'form-control','required'=>true]) !!} --}}
                                            <select name="grade_3" class="form-control">
                                                <option value="">Select Grade...</option>
                                                @if(count($grades) > 0)
                                                    @foreach($grades as $k=>$v)
                                                        <option value="{{ $v->name }}">{{ $v->name }}</option>
                                                    @endforeach
                                                @endif
                                                {{ old('grade_3') }}
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        {!! Form::label('grade_4','Grade 4', ['class'=>'form-label col-md-4 text-md-right']) !!}
                                        <div class="col-md-8">
                                            {{-- {!! Form::select('grade_4',
                                            ['A'=>'A','A-'=>'A-','B+'=>'B+','B'=>'B','B-'=>'B-','C+'=>'C+','C'=>'C','C-'=>'C-','D+'=>'D+','D'=>'D','D-'=>'D-','E'=>'E'],
                                            old('grade_4'), ['class'=>'form-control','required'=>true]) !!} --}}
                                            <select name="grade_4" class="form-control">
                                                <option value="">Select Grade...</option>
                                                @if(count($grades) > 0)
                                                    @foreach($grades as $k=>$v)
                                                        <option value="{{ $v->name }}">{{ $v->name }}</option>
                                                    @endforeach
                                                @endif
                                                {{ old('grade_4') }}
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        {!! Form::label('grade_5','Grade 5', ['class'=>'form-label col-md-4 text-md-right']) !!}
                                        <div class="col-md-8">
                                            {{-- {!! Form::select('grade_5',
                                            ['A'=>'A','A-'=>'A-','B+'=>'B+','B'=>'B','B-'=>'B-','C+'=>'C+','C'=>'C','C-'=>'C-','D+'=>'D+','D'=>'D','D-'=>'D-','E'=>'E'],
                                            old('grade_5'), ['class'=>'form-control','required'=>true]) !!} --}}
                                            <select name="grade_5" class="form-control">
                                                <option value="">Select Grade...</option>
                                                @if(count($grades) > 0)
                                                    @foreach($grades as $k=>$v)
                                                        <option value="{{ $v->name }}">{{ $v->name }}</option>
                                                    @endforeach
                                                @endif
                                                {{ old('grade_5') }}
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        {!! Form::label('grade_6','Grade 6', ['class'=>'form-label col-md-4 text-md-right']) !!}
                                        <div class="col-md-8">
                                            {{-- {!! Form::select('grade_6',
                                            ['A'=>'A','A-'=>'A-','B+'=>'B+','B'=>'B','B-'=>'B-','C+'=>'C+','C'=>'C','C-'=>'C-','D+'=>'D+','D'=>'D','D-'=>'D-','E'=>'E'],
                                            old('grade_6'), ['class'=>'form-control','required'=>true]) !!} --}}
                                            <select name="grade_6" class="form-control">
                                                <option value="">Select Grade...</option>
                                                @if(count($grades) > 0)
                                                    @foreach($grades as $k=>$v)
                                                        <option value="{{ $v->name }}">{{ $v->name }}</option>
                                                    @endforeach
                                                @endif
                                                {{ old('grade_6') }}
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        {!! Form::label('grade_7','Grade 7', ['class'=>'form-label col-md-4 text-md-right']) !!}
                                        <div class="col-md-8">
                                            {{-- {!! Form::select('grade_7',
                                            ['A'=>'A','A-'=>'A-','B+'=>'B+','B'=>'B','B-'=>'B-','C+'=>'C+','C'=>'C','C-'=>'C-','D+'=>'D+','D'=>'D','D-'=>'D-','E'=>'E'],
                                            old('grade_7'), ['class'=>'form-control','required'=>true]) !!} --}}
                                            <select name="grade_7" class="form-control">
                                                <option value="">Select Grade...</option>
                                                @if(count($grades) > 0)
                                                    @foreach($grades as $k=>$v)
                                                        <option value="{{ $v->name }}">{{ $v->name }}</option>
                                                    @endforeach
                                                @endif
                                                {{ old('grade_7') }}
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        {!! Form::label('grade_8','Grade 8', ['class'=>'form-label col-md-4 text-md-right']) !!}
                                        <div class="col-md-8">
                                            {{-- {!! Form::select('grade_8',
                                            ['A'=>'A','A-'=>'A-','B+'=>'B+','B'=>'B','B-'=>'B-','C+'=>'C+','C'=>'C','C-'=>'C-','D+'=>'D+','D'=>'D','D-'=>'D-','E'=>'E'],
                                            old('grade_8'), ['class'=>'form-control','required'=>true]) !!} --}}
                                            <select name="grade_8" class="form-control">
                                                <option value="">Select Grade...</option>
                                                @if(count($grades) > 0)
                                                    @foreach($grades as $k=>$v)
                                                        <option value="{{ $v->name }}">{{ $v->name }}</option>
                                                    @endforeach
                                                @endif
                                                {{ old('grade_8') }}
                                            </select>
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
                                                {!! Form::file('result_slip', ['class'=>'btn btn-success btn-sm']) !!}
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

        <script src="https://cdn.jsdelivr.net/npm/smartwizard@5/dist/js/jquery.smartWizard.min.js" type="text/javascript"></script>

        <script type="text/javascript">

$('#smartwizard').smartWizard({
    selected: 0, // Initial selected step, 0 = first step
    theme: 'default', // theme for the wizard, related css need to include for other than default theme
    justified: true, // Nav menu justification. true/false
    darkMode:false, // Enable/disable Dark Mode if the theme supports. true/false
    autoAdjustHeight: true, // Automatically adjust content height
    cycleSteps: false, // Allows to cycle the navigation of steps
    backButtonSupport: true, // Enable the back button support
    enableURLhash: true, // Enable selection of the step based on url hash
    transition: {
        animation: 'none', // Effect on navigation, none/fade/slide-horizontal/slide-vertical/slide-swing
        speed: '400', // Transion animation speed
        easing:'' // Transition animation easing. Not supported without a jQuery easing plugin
    },
    toolbarSettings: {
        toolbarPosition: 'bottom', // none, top, bottom, both
        toolbarButtonPosition: 'right', // left, right, center
        showNextButton: true, // show/hide a Next button
        showPreviousButton: true, // show/hide a Previous button
        toolbarExtraButtons: [] // Extra buttons to show on toolbar, array of jQuery input/buttons elements
    },
    anchorSettings: {
        anchorClickable: true, // Enable/Disable anchor navigation
        enableAllAnchors: false, // Activates all anchors clickable all times
        markDoneStep: true, // Add done state on navigation
        markAllPreviousStepsAsDone: true, // When a step selected by url hash, all previous steps are marked done
        removeDoneStepOnNavigateBack: false, // While navigate back done step after active step will be cleared
        enableAnchorOnDoneStep: true // Enable/Disable the done steps navigation
    },
    keyboardSettings: {
        keyNavigation: true, // Enable/Disable keyboard navigation(left and right keys are used if enabled)
        keyLeft: [37], // Left key code
        keyRight: [39] // Right key code
    },
    lang: { // Language variables for button
        next: 'Next',
        previous: 'Previous'
    },
    disabledSteps: [], // Array Steps disabled
    errorSteps: [], // Highlight step with errors
    hiddenSteps: [] // Hidden steps
});
        </script>
@endsection
