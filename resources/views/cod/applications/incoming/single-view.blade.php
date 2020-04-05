{{-- <div class="hidden">
    $email = null;
    @if($application->students->email)
    $email = $application->students->email;
    @else
    $email = null;
    @endif
</div> --}}
@extends('cod.main')

@section('content')
    <div class="box">
        <div class="box-header bg-warning text-center text-uppercase">application sr no: {{ $application->app_id }} - {{ $department->name}} {{ __('department') }}</div>
        <div class="box-body">
            <div class="col-md-12 row">
                @include('includes.errors.custom')
                <div class="col-md-4">
                    <div class="box">
                        <div class="box-header bg-success text-center text-uppercase">{{ __('student information') }}</div>
                        <div class="box-body">
                            {!! Form::open() !!}
                                <div class="form-group row">
                                    {!! Form::label('student_name','Name:', ['class'=>'form-label text-md-right col-md-4 ']) !!}
                                    <div class="col-md-8">
                                        {!! Form::text('student_name',$application->student_name, ['class'=>'form-control','disabled']) !!}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    {!! Form::label('student_reg','Reg/Adm No:', ['class'=>'form-label text-md-right col-md-4 ']) !!}
                                    <div class="col-md-8">
                                        {!! Form::text('student_reg',$application->reg_number, ['class'=>'form-control','disabled']) !!}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    {!! Form::label('student_id','ID No:', ['class'=>'form-label text-md-right col-md-4 ']) !!}
                                    <div class="col-md-8">
                                        {!! Form::text('student_id',$application->idNumber, ['class'=>'form-control','disabled']) !!}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    {!! Form::label('student_phone','Phone No:', ['class'=>'form-label text-md-right col-md-4 ']) !!}
                                    <div class="col-md-8">
                                        {!! Form::text('student_phone',$application->student_phone, ['class'=>'form-control','disabled']) !!}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    {!! Form::label('student_email','Email Addres:', ['class'=>'form-label text-md-right col-md-4 ']) !!}
                                    <div class="col-md-8">
                                        {!! Form::text('student_phone',$application->students->email, ['class'=>'form-control','disabled']) !!}
                                    </div>
                                </div>
                            {!! Form::close() !!}
                        </div>
                        <div class="box-footer bg-default"></div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="box">
                        <div class="box-header bg-success text-center text-uppercase">{{ __('kcse information') }}</div>
                        <div class="box-body">
                            {!! Form::open() !!}
                            <div class="form-group row">
                                {!! Form::label('kcse_year','Examination Year:', ['class'=>'form-label col-md-4 text-md-right']) !!}
                                <div class="col-md-8">
                                    {!! Form::text('kcse_year',$application->kcse_year, ['class'=>'form-control','disabled']) !!}
                                </div>
                            </div>
                                <div class="form-group row">
                                    {!! Form::label('kcse_index','Index No:', ['class'=>'form-label col-md-4 text-md-right']) !!}
                                    <div class="col-md-8">
                                        {!! Form::text('kcse_index',$application->kcse_index, ['class'=>'form-control','disabled']) !!}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    {!! Form::label('kuccps_pwd','KUCCPS Password:', ['class'=>'form-label col-md-4 text-md-right']) !!}
                                    <div class="col-md-8">
                                        {!! Form::text('kuccps_pwd',$application->kuccps_password, ['class'=>'form-control','disabled']) !!}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    {!! Form::label('mean_grade','Mean Grade:', ['class'=>'form-label col-md-4 text-md-right']) !!}
                                    <div class="col-md-8">
                                        {!! Form::text('mean_grade',$application->mean_grade, ['class'=>'form-control','disabled']) !!}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    {!! Form::label('aggregate','Aggregate Points:', ['class'=>'form-label col-md-4 text-md-right']) !!}
                                    <div class="col-md-8">
                                        {!! Form::text('aggregate',$application->aggregate_points, ['class'=>'form-control','disabled']) !!}
                                    </div>
                                </div>
                            {!! Form::close() !!}
                        </div>
                        <div class="box-footer bg-default"></div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="box">
                        <div class="box-header bg-success text-center text-uppercase">{{ __('transfer information') }}</div>
                        <div class="box-body">
                            {!! Form::open() !!}
                                <div class="form-group row">
                                    {!! Form::label('present_program','Present Program', ['class'=>'form-label text-md-right col-md-4']) !!}
                                    <div class="col-md-8">
                                        {!! Form::text('present_program',$application->present_program, ['class'=>'form-control','disabled']) !!}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    {!! Form::label('present_school','Current School', ['class'=>'form-label text-md-right col-md-4']) !!}
                                    <div class="col-md-8">
                                        {!! Form::text('present_school',$application->present_school, ['class'=>'form-control','disabled']) !!}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    {!! Form::label('preffered_program','Preffered Program', ['class'=>'form-label text-md-right col-md-4']) !!}
                                    <div class="col-md-8">
                                        {!! Form::text('preffered_program',$application->preffered_program, ['class'=>'form-control','disabled']) !!}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    {!! Form::label('weighted_clusters','Weighted Clusters:', ['class'=>'form-label text-md-right col-md-4']) !!}
                                    <div class="col-md-8">
                                        {!! Form::text('weighted_clusters',$application->weighted_clusters, ['class'=>'form-control','disabled']) !!}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    {!! Form::label('cut_off_points','Cut Off Points:', ['class'=>'form-label text-md-right col-md-4']) !!}
                                    <div class="col-md-8">
                                        {!! Form::text('cut_off_points',$application->cut_off_points, ['class'=>'form-control','disabled']) !!}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    {!! Form::label('cluster_no','Cluster No:', ['class'=>'form-label text-md-right col-md-4']) !!}
                                    <div class="col-md-8">
                                        {!! Form::text('cluster_no',$application->cluster_no, ['class'=>'form-control','disabled']) !!}
                                    </div>
                                </div>
                            {!! Form::close() !!}
                        </div>
                        <div class="box-footer bg-default"></div>
                    </div>
                </div>
            </div>
            <div class="col-md-2"></div>
            <div class="col-md-8 row">
                <div class="box">
                    <div class="box-header bg-success text-center text-uppercase">{{ __('cod comments section') }}</div>
                    <div class="box-body">
                        <div class="col-md-6">
                            <div class="box">
                                <div class="box-header bg-warning text-center text-uppercase">{{ __('current cod') }}</div>
                                <div class="box-body">
                                    {!! Form::open() !!}
                                    <div class="form-group row">
                                        {{-- {!! Form::label('status','Status', ['class'=>'col-md-4 form-label text-md-right']) !!}
                                        <div class="col-md-8">
                                            {!! Form::select('status',['','Aproved','Not Approved','Approved But No Capacity'],old('status'), ['class'=>'form-control','disabled']) !!}
                                        </div> --}}
                                    </div>
                                    <div class="form-group row">
                                        {!! Form::label('comment','Comments', ['class'=>'col-md-4 form-label text-md-right']) !!}
                                        <div class="col-md-8">
                                            {!! Form::textarea('comments',old('comments'), ['class'=>'form-control','disabled']) !!}
                                        </div>
                                    </div>
                                    {!! Form::close() !!}
                                </div>
                                <div class="box-footer"></div>
                            </div>
                    </div>
                    <div class="col-md-6">
                        <div class="box">
                            <div class="box-header bg-warning text-center text-uppercase">{{ __('receiving cod') }}</div>
                            <div class="box-body">
                                {{-- {!! Form::open() !!}
                                <div class="form-group row">
                                    {!! Form::label('status','Status', ['class'=>'col-md-4 form-label text-md-right']) !!}
                                    <div class="col-md-8">
                                        {!! Form::select('status',['Select ...','Aproved','Not Approved','Approved But No Capacity'],old('status'), ['class'=>'form-control']) !!}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    {!! Form::label('comments','Comments', ['class'=>'col-md-4 form-label text-md-right']) !!}
                                    <div class="col-md-8">
                                        {!! Form::textarea('comments',old('comments'), ['class'=>'form-control']) !!}
                                    </div>
                                </div>
                                <div class="col-md-8 col-md-offset-4">
                                    {!! Form::submit('submit', ['class'=>'btn btn-success btn-sm text-center text-uppercase']) !!}
                                </div>
                                {!! Form::close() !!} --}}
                                {!! Form::open(['action'=>['COD\CODController@approveAnIncomingApplication','app_id'=>$application->app_id],'method'=>'post','enctype'=>'multipart/form-data']) !!}
                                <div class="form-group row">
                                    <div class="form-group row">
                                        {!! Form::label('message_channel','Message Channel', ['class'=>'col-md-4 form-label text-md-right']) !!}
                                        <div class="col-md-8 row">
                                            SMS <input type="radio" name="message_channel" value="sms"> <br>
                                            Email <input type="radio" name="message_channel" value="email"><br>
                                            All <input type="radio" name="message_channel" value="both">
                                            {{-- {!! Form::select('status',['Select ....','Aproved','Not Approved','Approved But No Capacity'],old('status'), ['class'=>'form-control']) !!} --}}
                                        </div>
                                    </div>
                                    {!! Form::label('comment','Comments', ['class'=>'col-md-4 form-label text-md-right']) !!}
                                    <div class="col-md-8">
                                        {!! Form::textarea('comment',old('comment'), ['class'=>'form-control','placeholder'=>'e.g Approved/Not Aproved']) !!}
                                    </div>
                                </div>
                                <div class="col-md-8 col-md-offset-4">
                                     {!! Form::submit('forward to dean', ['class'=>'btn btn-success btn-sm text-center text-uppercase']) !!}
                                </div>
                                {!! Form::close() !!}
                            </div>
                            <div class="box-footer"></div>
                        </div>
                    </div>
                    </div>
                    <div class="box-footer"></div>
                </div>
            </div>
            <div class="col-md-2"></div>
        </div>
        <div class="box-footer"></div>
    </div>
@endsection

