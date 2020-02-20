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
    Route::get('/login',['as'=>'student.login.form','uses'=>'Auth\Student\StudentLoginController@showLoginForm']);
    Route::post('/login',['as'=>'student.login','uses'=>'Auth\Student\StudentLoginController@login']);
    Route::get('/dashboard',['as'=>'student.dashboard','uses'=>'Student\StudentsController@index']);
});
