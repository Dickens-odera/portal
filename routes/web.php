<?php
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Auth::routes();
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
    Route::get('/login-form',['as'=>'student.login.form','uses'=>'Auth\Student\StudentLoginController@showLoginForm']);
    Route::post('/login',['as'=>'student.login','uses'=>'Auth\Student\StudentLoginController@login']);
    Route::get('/dashboard',['as'=>'student.dashboard','uses'=>'Auth\Student\StudentLoginController@index']);
});
//the dean of school
Route::prefix('dean')->group(function()
{
    Route::get('/login-form',['as'=>'dean.login.form','uses'=>'Auth\Deans\DeansLoginController@showLoginForm']);
    Route::post('/login',['as'=>'dean.login','uses'=>'Auth\Deans\DeansLoginController@login']);
    Route::get('/dashboard',['as'=>'dean.dashboard','uses'=>'Auth\Deans\DeansLoginController@index']);
});
//the registrar
Route::prefix('registrar')->group(function()
{
    Route::get('/login-form',['as'=>'registrat.login.form','uses'=>'Auth\Registrar\RegistratLoginControler@showLoginForm']);
    Route::post('/login',['as'=>'registrar.login','uses'=>'Auth\Registrar\RegistrarLoginController@login']);
    Route::get('/dashboard','Auth\Registrar\RegustrarLoginCotroller@index')->name('registrar.dashboard');
    Route::post('/student-add',['as'=>'registrar.student.add','uses'=>'Registrar\RegistrarController@addStudent']);
});
//the chairperson of department
Route::prefix('cod')->group(function()
{
    Route::get('/login-form',['as'=>'cod.login.form','uses'=>'Auth\COD\CODLoginController@showLoginForm']);
    Route::post('/login',['as'=>'cod.login','uses'=>'Auth\COD\CODLoginController@login']);
    Route::get('/dashboard',['as'=>'cod.dashboard','uses'=>'Auth\COD\CODLoginController@index']);
});

