<?php
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Auth::routes();


Route::get('/', function () {
    return view('welcome');
});

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
Route::prefix('student')->group(function()
{
    Route::get('/login-form',['as'=>'student.login','uses'=>'Auth\Student\StudentLoginController@showLoginForm']);
    Route::post('/login','Auth\Student\StudentLoginController@login')->name('student.login.submit');
    Route::get('/dashboard','Student\StudentController@index')->name('student.dashboard');
    Route::get('/logout','Auth\Student\StudentLoginController@logout')->name('student.logout');
    Route::get('/applications','Student\Applications\ApplicationsController@index')->name('student.application.form');
});
//the dean of school
Route::prefix('dean')->group(function()
{
    Route::get('/login-form',['as'=>'dean.login','uses'=>'Auth\Deans\DeanLoginController@showLoginForm']);
    Route::post('/login',['as'=>'dean.login.submit','uses'=>'Auth\Deans\DeanLoginController@login']);
    Route::get('/dashboard',['as'=>'dean.dashboard','uses'=>'Auth\Deans\DeanLoginController@index']);
});
//the registrar
Route::prefix('registrar')->group(function()
{
    Route::get('/login-form',['as'=>'registrar.login','uses'=>'Auth\Registrar\RegistrarLoginController@showLoginForm']);
    Route::post('/login',['as'=>'registrar.login.submit','uses'=>'Auth\Registrar\RegistrarLoginController@login']);
    Route::get('/dashboard','Auth\Registrar\RegustrarLoginCotroller@index')->name('registrar.dashboard');
    Route::post('/student-add',['as'=>'registrar.student.add','uses'=>'Registrar\RegistrarController@addStudent']);
});
//the chairperson of department
Route::prefix('cod')->group(function()
{
    Route::get('/login-form',['as'=>'cod.login','uses'=>'Auth\COD\CODLoginController@showLoginForm']);
    Route::post('/login',['as'=>'cod.login.submit','uses'=>'Auth\COD\CODLoginController@login']);
    Route::get('/dashboard',['as'=>'cod.dashboard','uses'=>'Auth\COD\CODLoginController@index']);
});

