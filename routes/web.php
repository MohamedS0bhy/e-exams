<?php
use App\User;
use App\subject;
use App\exam;
use App\question;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
	return view('login');
})->middleware('role.base');

Route::get('/login' , function(){
	return view('login');
})->middleware('role.base');

Route::post('/login' , 'AuthController@login');

Route::get('/register' , function(){
	return view('register');
});

Route::post('/register' , 'ApiController@register');

Route::get('/usr/ad' , function(){
	return view('admin.index');
})->name('adminDashboard');

Route::get('/usr/st' , function(){
	return view('student.index');
})->name('studentDashboard');

Route::get('/usr/dc' , function(){
	return view('doctor.index');
})->name('doctorDashboard');

Route::get('/subject/exams/{id}' , function($id){
	return view('student.subjectExams' , compact('id'));
});

Route::get('/dc/subject/exams/{id}' , function($id){
	return view('doctor.subjectExams' , compact('id'));
});

Route::get('/exam/submissions/{id}' , function($id){
	return view('doctor.examSubmissions' , compact('id'));
});

Route::get('/profile' , function(){

	if(isset($_COOKIE['token'])){

		JWTAuth::setToken($_COOKIE['token']);
		$usr = JWTAuth::toUser();
		
		if($usr->role == '10')
			return view('admin.profile');
		elseif($usr->role == '1')
			return view('doctor.profile');
		else
			return view('student.profile') ;
	  }
	  
	return view('login');
	
});

Route::get('/subject/update/{id}' , function($id){
	return view('doctor.subjectUpdate' ,compact('id'));
});

Route::get('/subject/create' , function(){
	return view('doctor.createSubject');
});
// ----------------------begain testing urls ------------------

Route::get('/test/onetomany' , function(){

	//insert
	$sub = subject::findOrFail(12);
	// $sub->exams()->save(new exam(['exam_name'=>'math' , 
	// 			'desc' => 'blabalabalabala bfaslfhdslj' , 
	// 			'grade'=>30]));

	
	//update
	// $sub->exams()->whereId(102)->update(['desc' => 'new description']);

	//read
	foreach($sub->exams as $e){
		echo '<pre>';
		print_r($e->id);
		echo '</pre>';

	}

	//delete
	// $sub->exams()->whereId(102)->delete();

});

Route::get('/test/manytomany' , function(){

	//insert
	$user = User::findOrFail(2);
	// $user->subjects()->save(new subject([
	// 	'subject_name' => 'new subject',
	// 	'desc' => 'lfdlksjljfd',
	// 	'user_id' => $user->id
	// ]));

	//update
	// $user->subjects()->where('subjects.id' , '=' , 62)->update([
	// 	'desc' => 'new description'
	// ]);

	//read
	foreach($user->subjects as $sub){
		echo $sub->subject_name; echo '<br>';
	}
	

	//delete
	// $user->subjects()->where('subjects.id' , '=' , 62)->delete();

	//attach add row to manytomany table 
	// $user->subjects()->attach(12);
	
	//detach remove row 
	// $user->subjects()->detach(12);

});

Route::get('/exam' , function(){
	// $token = (isset($_COOKIE['token']))? $_COOKIE['token'] : '';
	// JWTAuth::setToken($token);
	// // dd(JWTAuth::authenticate());
	// $e = JWTAuth::toUser();
	// dd($e->id);
	// $r = exam::with('test')->where('id' , '=' , '2')->first();
	// echo '<pre>';
	// print_r($r);
	// echo '</pre>';dd('j');
	
	

	return view('student.exam');
});


Route::get('/token/{value}',function(Request $request,$value)
{

	return view('student.token',['token'=>$value]);
});

// links to forget password view 
// Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
// Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');

// // links from sended view from email
// Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
// Route::post('password/reset', 'Auth\ResetPasswordController@reset');

// Route::get('user/verify/{verification_code}', 'AuthController@verifyUser');
// Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.request');
// Route::post('password/reset', 'Auth\ResetPasswordController@postReset')->name('password.reset');




// ----------------------end testing urls     ------------------
