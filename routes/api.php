<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });


Route::post('login', 'ApiController@login');
Route::post('register', 'ApiController@register');

Route::get('subject/all','SubjectController@findAll');
Route::get('subject/find/{id}','SubjectController@find');
Route::get('subject/findByDoctor/{id}','SubjectController@findByDoctor');
Route::get('subject/get/exams/{id}', 'SubjectController@subjectExams');


Route::get('exam/all','ExamController@findAll');
Route::get('exam/find/{id}','ExamController@find');
Route::get('exam/findBySubject/{id}','ExamController@findBySubject');
Route::get('exam/submissions/{id}','ExamController@getSubmissions');

Route::get('question/all' , 'QuestionController@findAll');
Route::get('question/find/{id}' , 'QuestionController@find');
Route::get('question/findByExam/{id}' , 'QuestionController@findByExam');

Route::group(['middleware' => 'auth.jwt'], function () {
    Route::post('logout', 'ApiController@logout');

    Route::post('user', 'ApiController@getAuthUser');
    Route::post('updateUser', 'ApiController@updateUsrData');

    Route::post('subject/create', 'SubjectController@create');
    Route::post('subject/delete','SubjectController@delete');
    Route::post('subject/update', 'SubjectController@update');
    Route::post('subject/get/enrolled', 'SubjectController@findEntrolledSubject');
    

    Route::post('exam/create', 'ExamController@create');
    Route::post('exam/delete','ExamController@delete');
    Route::post('exam/update', 'ExamController@update');
    Route::post('exam/addToken', 'ExamController@addToken');
    Route::post('exam/addAns' , 'ExamController@submission');
    Route::post('exam/getAns' , 'ExamController@getAnswers');
    Route::post('exam/getUserAns','ExamController@getUserAns');
    Route::post('question/create', 'QuestionController@create');
    Route::post('question/delete', 'QuestionController@delete');
    Route::post('question/update', 'QuestionController@updateList');

    
});

//services file that contains all servces we provides
Route::get("/services",function()
{
    return File::get(public_path() . '/services.html');
});

