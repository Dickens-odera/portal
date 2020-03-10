<?php
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

//Auth::routes(['verify'=>true]);
Auth::routes();

Route::get('/', function () {
    return view('welcome');
});
//Student Registration
Route::get('/student/new-account','Auth\Student\StudentRegisterController@create')->name('student.account.creation');
Route::post('/student','Auth\Student\StudentRegisterController@register')->name('student.register');
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
    Route::get('/admin-user','Auth\Admins\AdminLoginController@showLoginForm')->name('admin.login');
    Route::post('/login','Auth\Admins\AdminLoginController@login')->name('admin.login.submit');
    Route::get('/dashboard','Admin\AdminController@index')->name('admin.dashboard');
    Route::get('/logout','Auth\Admins\AdminLoginController@logout')->name('admin.logout');

});
Route::prefix('student')->group(function()
{
    Route::get('/login-form','Auth\Student\StudentLoginController@showLoginForm')->name('student.login');
    Route::post('/login','Auth\Student\StudentLoginController@login')->name('student.login.submit');
    Route::get('/dashboard','Student\StudentController@index')->name('student.dashboard');
    Route::get('/logout','Auth\Student\StudentLoginController@logout')->name('student.logout');
    Route::get('/applications','Student\Applications\ApplicationsController@create')->name('student.application.form');
    Route::post('/applications','Student\Applications\ApplicationsController@store')->name('student.application.submit');
    Route::get('/applications-history','Student\Applications\ApplicationsController@index')->name('student.applications.history');
    Route::get('/application','Student\Applications\ApplicationsController@show')->name('student.application.show');
    Route::post('/application/update','Student\Applications\ApplicationsController@update')->name('student.application.update');
    Route::post('/application/cancel','Student\Applications\ApplicationsController@cancel')->name('student.application.cancel');
});
//the dean of school
Route::prefix('dean')->group(function()
{
    Route::get('/login-form','Auth\Dean\DeanLoginController@showLoginForm')->name('dean.login');
    Route::post('/login','Auth\Dean\DeanLoginController@login')->name('dean.login.submit');
    Route::get('/dashboard','Dean\DeanController@index')->name('dean.dashboard');
    Route::get('/logout','Auth\Dean\DeanLoginController@logout')->name('dean.logout');
    Route::get('/programs','Dean\DeanController@showProgramsForm')->name('dean.programs');
    Route::post('/programs','Dean\DeanController@addProgram')->name('dean.program.add');
    Route::post('/programs/import','Dean\DeanController@importPrograms')->name('dean.programs.import');
    Route::get('/programs/export','Dean\DeanController@exportPrograms')->name('dean.programs.export');
    Route::get('/programs/all','Dean\DeanController@viewAllPrograms')->name('dean.programs.view.all');
});
//the registrar
Route::prefix('registrar')->group(function()
{
    Route::get('/login-form','Auth\Registrar\RegistrarLoginController@showLoginForm')->name('registrar.login');
    Route::post('/login','Auth\Registrar\RegistrarLoginController@login')->name('registrar.login.submit');
    Route::get('/dashboard','Registrar\RegistrarController@index')->name('registrar.dashboard');
    Route::get('/applications/data','Registrar\RegistrarController@getApplicationsTables')->name('registrar.applications.view.data');
    Route::get('/applications','Registrar\RegistrarController@getApplication')->name('registrar.applications.view');
    Route::post('/student-add',['as'=>'registrar.student.add','uses'=>'Registrar\RegistrarController@addStudent']);
    Route::get('/logout','Auth\Registrar\RegistrarLoginController@logout')->name('registrar.logout');
});
//the chairperson of department
Route::prefix('cod')->group(function()
{
    Route::get('/login-form','Auth\COD\CODLoginController@showLoginForm')->name('cod.login');
    Route::post('/login','Auth\COD\CODLoginController@login')->name('cod.login.submit');
    Route::get('/logout','Auth\COD\CODLoginController@logout')->name('cod.logout');
    Route::get('/dashboard','COD\CODController@index')->name('cod.dashboard');
    Route::get('/applications','COD\CODController@getAllApplications')->name('cod.applications.view.all');
    Route::get('/application','COD\CODController@getApplication')->name('cod.application.view');
});

