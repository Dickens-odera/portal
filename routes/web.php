<?php
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

//Auth::routes(['verify'=>true]);
Auth::routes();

Route::get('/', function () {
    return view('welcome');
});
//Student Registration
//end account creation
Route::post('/applications',['as'=>'applications.submit','uses'=>'Student\Applications\ApplicationsController@store']);
Route::get('/home', 'HomeController@index')->name('home');
Route::post('/posts','Student\Posts\PostsController@post_data')->name('student.post.submit');
Route::patch('/applications/{app_id}',['as'=>'application.update','uses'=>'Student\Applications\ApplicationsController@update']);
//schools
Route::get('/staff/schools','Staff\Schools\SchoolsController@index')->name('schools.index');
Route::post('/addschool','Staff\Schools\SchoolsController@store')->name('school.submit');
Route::patch('/updateschool/{id}','Staff\Schools\SchoolsController@update')->name('school.update.submit');
Route::delete('/deleteSchool/{school_id}','Staff\Schools\SchoolsController@destroy')->name('school.delete');
//the student urls
Route::prefix('admin')->group(function()
{
    //Account routes
    Route::prefix('account')->group(function()
    {
        Route::get('/admin-superuser/v1/login','Auth\Admins\AdminLoginController@showLoginForm')->name('admin.login');
        Route::post('/login','Auth\Admins\AdminLoginController@login')->name('admin.login.submit');
        Route::get('/dashboard','Admin\AdminController@index')->name('admin.dashboard');
        Route::get('/logout','Auth\Admins\AdminLoginController@logout')->name('admin.logout');
    });


        /************************************ ADMIN SETTINGS URLS ***********************************/
    Route::prefix('settings')->group(function()
    {
        //Deans urls
        Route::prefix('deans')->group(function()
        {
            Route::get('/all','Admin\AdminController@getAllDeans')->name('admin.deans.view.all');
            Route::get('/add','Admin\AdminController@ShowNewDeanOfSchoolForm')->name('admin.dean.add.form');
            Route::post('/add','Admin\AdminController@addNewDeanOfSchool')->name('admin.dean.add.submit');
        });

        //CODs urls
        Route::prefix('cods')->group(function()
        {
            Route::get('/all','Admin\AdminController@getAllCODs')->name('admin.cods.view.all');
            Route::get('/add','Admin\AdminController@ShowNewCODForm')->name('admin.cod.add.form');
            Route::post('/add','Admin\AdminController@addNewSchoolDepartmentChair')->name('admin.cod.add.submit');
        });

        //DEPARTMENT URLS
        Route::prefix('departments')->group(function()
        {
            Route::get('/add','Admin\AdminController@showNewDepartmentForm')->name('admin.department.add.form');
            Route::post('/add','Admin\AdminController@addNewDepartment')->name('admin.department.add.submit');
            Route::get('/all','Admin\AdminController@getAllDepartments')->name('admin.departments.view.all');
        });

        //Schools urls
        Route::prefix('schools')->group(function()
        {
            Route::get('/add','Admin\AdminController@ShowNewAdditionSchoolForm')->name('admin.schools.add.form');
            Route::post('/add','Admin\AdminController@addNewSchool')->name('admin.schools.add.submit');
            Route::get('/all','Admin\AdminController@getAllSchools')->name('admin.schools.view.all');
        });

        //REGISTRAR URLS
        Route::prefix('registrars')->group(function()
        {
            Route::get('/add','Admin\AdminController@ShowRegistrarAAForm')->name('admin.registrar.add.form');
            Route::post('/add','Admin\AdminController@addNewRegistrarAA')->name('admin.registrar.add.submit');
            Route::get('/all','Admin\AdminController@getAllRegistrarsAA')->name('admin.registrars.view.all');
        });
        //GRADING SYSTEM
        Route::prefix('grading')->group(function()
        {
            Route::get('/grade/add','Admin\AdminController@showGradeNewForm')->name('admin.grading.add.form');
            Route::post('/grade','Admin\AdminController@addNewGrade')->name('admin.grading.add.submit');
            Route::get('/grade/edit','Admin\AdminController@showGradeEditForm')->name('admin.grading.edit.form');
            Route::post('/grade/edit','Admin\AdminController@updateGrade')->name('admin.grading.update');
            Route::get('/grades','Admin\AdminController@getAllGrades')->name('admin.grading.grades.all');
        });
        //SUBJECTS
        Route::prefix('subjects')->group(function()
        {
            Route::get('/add','Admin\AdminController@ShowSubjectForm')->name('admin.subjects.add.form');
            Route::post('/add','Admin\AdminController@addNewSubject')->name('admin.subjects.add.submit');
            Route::get('/all','Admin\AdminController@getAllSubjects')->name('admin.subjects.view.all');
            Route::get('/single-view','Admin\AdminController@viewASingeSubject')->name('admin.subjects.single.view');
        });
    });
            /********************************************* END OF ADMIN SETTINGS URLS*****************************/
});
Route::prefix('student')->group(function()
{
    //Account routes
    Route::prefix('account')->group(function()
    {
        Route::prefix('v1')->group(function()
        {
            Route::post('/register','Auth\Student\StudentRegisterController@register')->name('student.register');
            Route::get('/register','Auth\Student\StudentRegisterController@create')->name('student.account.creation');
            Route::get('/verification','Auth\Student\StudentRegisterController@showVerificationPage')->name('student.account.verification.message');
            Route::get('/login','Auth\Student\StudentLoginController@showLoginForm')->name('student.login');
            Route::post('/login','Auth\Student\StudentLoginController@login')->name('student.login.submit');
        });
        Route::get('/dashboard','Student\StudentController@index')->name('student.dashboard');
        Route::get('/logout','Auth\Student\StudentLoginController@logout')->name('student.logout');
    });
    Route::prefix('applications')->group(function()
    {
        Route::get('/add','Student\Applications\ApplicationsController@create')->name('student.application.form');
        Route::post('/add','Student\Applications\ApplicationsController@store')->name('student.application.submit');
        Route::get('/history','Student\Applications\ApplicationsController@index')->name('student.applications.history');
        Route::get('/single-view','Student\Applications\ApplicationsController@show')->name('student.application.show');
        Route::post('/single-view/update','Student\Applications\ApplicationsController@update')->name('student.application.update');
        Route::post('/single-view/cancel','Student\Applications\ApplicationsController@cancel')->name('student.application.cancel');
        Route::get('/kuccps','Student\Applications\ApplicationsController@getKuccpsPrograms')->name('student.kuccps.programs');
    });
    //password reset routes
    Route::prefix('password')->group(function()
    {
        Route::post('/email','Auth\Student\StudentForgotPasswordController@sendResetLinkEmail')->name('student.password.email');
        Route::post('/reset','Auth\Student\StudentResetPasswordController@reset')->name('student.password.update');
        Route::get('/reset','Auth\Student\StudentForgotPasswordController@showLinkRequestForm')->name('student.password.request');
        Route::get('/reset/{token}','Auth\Student\StudentResetPasswordController@showResetForm')->name('student.password.reset');
    });
});
//the dean of school
Route::prefix('dean')->group(function()
{
    //Account Urls
    Route::prefix('account')->group(function()
    {
        Route::get('/login','Auth\Dean\DeanLoginController@showLoginForm')->name('dean.login');
        Route::post('/login','Auth\Dean\DeanLoginController@login')->name('dean.login.submit');
        Route::get('/dashboard','Dean\DeanController@index')->name('dean.dashboard');
        Route::get('/logout','Auth\Dean\DeanLoginController@logout')->name('dean.logout');
    });
    //Applications routes
    Route::prefix('applications')->group(function()
    {
        Route::get('/incoming','Dean\DeanController@getAllIncomingApplications')->name('dean.applications.incoming.all');
        Route::get('/outgoing','Dean\DeanController@getAllOutgoingApplications')->name('dean.applications.outgoing.all');
        Route::get('/incoming/single-view','Dean\DeanController@getAnIncomingApplication')->name('dean.application.incoming.view');
        Route::get('/outgoing/single-view','Dean\DeanController@getAnOutGoingApplication')->name('dean.application.outgoing.view');
        Route::post('/incoming/comment','Dean\DeanController@submitFeedbackOnIncomingApp')->name('dean.application.incoming.comment.submit');
        Route::post('/outgoing/comment','Dean\DeanController@submitFeedbackOnOutgoingApp')->name('dean.application.outgoing.comment.submit');
    });
    //password reset routes
    Route::prefix('password')->group(function()
    {
        Route::post('/email','Auth\Dean\DeanForgotPasswordController@sendResetLinkEmail')->name('dean.password.email');
        Route::post('/reset','Auth\Dean\DeanResetPasswordController@reset')->name('dean.password.update');
        Route::get('/reset','Auth\Dean\DeanForgotPasswordController@showLinkRequestForm')->name('dean.password.request');
        Route::get('/reset/{token}','Auth\Dean\DeanResetPasswordController@showResetForm')->name('dean.password.reset');
    });
});
//the registrar
Route::prefix('registrar')->group(function()
{
    //Account urls
    Route::prefix('account')->group(function()
    {
        Route::get('/login','Auth\Registrar\RegistrarLoginController@showLoginForm')->name('registrar.login');
        Route::post('/login','Auth\Registrar\RegistrarLoginController@login')->name('registrar.login.submit');
        Route::get('/logout','Auth\Registrar\RegistrarLoginController@logout')->name('registrar.logout');
        Route::get('/dashboard','Registrar\RegistrarController@index')->name('registrar.dashboard');
    });
    //Applications urls
    Route::prefix('applications')->group(function()
    {
        Route::get('/data','Registrar\RegistrarController@getApplicationsTables')->name('registrar.applications.view.data');
        Route::get('/all','Registrar\RegistrarController@getApplication')->name('registrar.applications.view');
    });
    Route::post('/student-add',['as'=>'registrar.student.add','uses'=>'Registrar\RegistrarController@addStudent']);

    //password reset routes
    Route::prefix('password')->group(function()
    {
        Route::post('/email','Auth\Registrar\RegistrarForgotPasswordController@sendResetLinkEmail')->name('registrar.password.email');
        Route::post('/reset','Auth\Registrar\RegistrarResetPasswordController@reset')->name('registrar.password.update');
        Route::get('/reset','Auth\Registrar\RegistrarForgotPasswordController@showLinkRequestForm')->name('registrar.password.request');
        Route::get('/reset/{token}','Auth\Registrar\RegistrarResetPasswordController@showResetForm')->name('registrar.password.reset');
    });
});
//the chairperson of department
Route::prefix('cod')->group(function()
{
    //Account
    Route::prefix('account')->group(function()
    {
        Route::get('/login','Auth\COD\CODLoginController@showLoginForm')->name('cod.login');
        Route::post('/login','Auth\COD\CODLoginController@login')->name('cod.login.submit');
        Route::get('/logout','Auth\COD\CODLoginController@logout')->name('cod.logout');
        Route::get('/dashboard','COD\CODController@index')->name('cod.dashboard');
    });
    //APPLICATIONS
    Route::prefix('applications')->group(function()
    {
        Route::get('/all','COD\CODController@getAllApplications')->name('cod.applications.view.all');
        Route::get('/single-view','COD\CODController@getApplication')->name('cod.application.view');
        Route::get('/all/outgoing','COD\CODController@getAllOutgoingApplications')->name('cod.applications.outgoing.all');
        Route::get('/single-view/outgoing','COD\CODController@getAnOutgoingApplication')->name('cod.applications.outgoing.single.view');
        Route::get('/all/incoming','COD\CODController@getAllIncomingApplications')->name('cod.applications.incoming.all');
        Route::get('/single-view/incoming','COD\CODController@getAnIncomingApplication')->name('cod.applications.incoming.single.view');

        //Application approval
        Route::prefix('approval')->group(function()
        {
            Route::prefix('outgoing')->group(function()
            {
                Route::post('/approve','COD\CODController@approveAnOutgoingApplication')->name('cod.applications.approval.approve');
            });
            Route::prefix('incoming')->group(function()
            {
                Route::post('/approve','COD\CODController@approveAnIncomingApplication')->name('cod.applications.incoming.approval.approve');
            });
        });
    });
    //password reset routes
    Route::prefix('password')->group(function()
    {
        Route::post('/email','Auth\COD\CODForgotPasswordController@sendResetLinkEmail')->name('cod.password.email');
        Route::post('/reset','Auth\COD\CODResetPasswordController@reset')->name('cod.password.update');
        Route::get('/reset','Auth\COD\CODForgotPasswordController@showLinkRequestForm')->name('cod.password.request');
        Route::get('/reset/{token}','Auth\COD\CODResetPasswordController@showResetForm')->name('cod.password.reset');
    });
        //Programs routes
        Route::prefix('programs')->group(function()
        {
            Route::get('/add','COD\CODController@showProgramsForm')->name('cod.programs');
            Route::post('/add','COD\CODController@addProgram')->name('cod.program.add');
            Route::post('/import','COD\CODController@importPrograms')->name('cod.programs.import');
            Route::get('/export','COD\CODController@exportPrograms')->name('cod.programs.export');
            Route::get('/all','COD\CODController@viewAllPrograms')->name('cod.programs.view.all');
        });
});

