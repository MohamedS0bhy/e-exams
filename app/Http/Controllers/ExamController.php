<?php
namespace App\Http\Controllers;

use App\exam;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use JWTAuth;
use JWTAuthException;
class ExamController extends Controller
{
  
    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
       // $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data){
        return Validator::make($data, [
            'exam_name'=> 'required|string|max:255',
            'desc'=> 'required|string|max:255',
            'grade'=> 'required|int',
            'open'=> 'required|int',
            'subject_id'=> 'required|int'
        ]);
    }

    protected function create(Request $request){

        $user = JWTAuth::toUser($request->token);        
        
        if($user==null)
            return response()->json([
                "success" => false,
                'result' =>"token not valid"
                ]);

        if($user->role == '0')
            return response()->json([
                "success" => false,
                'result' =>"You\'re not Authorized to take such this action!!"
                ]);
        $exam = new exam();
        $exam->exam_name = $request->exam_name;
        $exam->desc = $request->desc;
        $exam->grade = $request->grade;
        if($request->has('open'))
            $exam->open = $request->open;
        $exam->subject_id = $request->subject_id;
        if($request->has('duration'))
            $exam->duration = $request->duration;
        $exam->save();

        return response()->json([
            "success" => true,
            "result" =>exam::find($exam->id)
            ]);
        
       
    }

    protected function delete(Request $request){
        $exam=exam::find($request->id);
        $user = JWTAuth::toUser($request->token);

        if($exam==null)
            return response()->json([
                "success" => false,
                'result' =>"there is no exam with is id"
                ]);

        if($user->role == '0')
            return response()->json([
                "success" => false,
                'result' =>"You\'re not Authorized to take such this action!!"
                ]);

        if($exam->delete())
            return response()->json([
                "success" => true,
                'result' => "deleted successfully"
                ]);

        return response()->json([
            "success" => false,
            'result' => "deleted failed"
            ]);

    }

    protected function update(Request $request){
        $user = JWTAuth::toUser($request->token);        
        
        if($user==null)
            return response()->json([
                "success" => false,
                'result' =>"token not valid"
                ]);

        if($user->role == '0')
            return response()->json([
                "success" => false,
                'result' =>"You\'re not Authorized to take such this action!!"
                ]);
    
        $exam=Exam::find($request->id);

        if($exam==null)
            return response()->json([
                "success" => false,
                'result' =>"there is no exam with this id"
                ]);
        
        $attr = array();
        if($request->has('exam_name'))
            $attr['exam_name'] = $request->exam_name;

        if($request->has('desc'))
            $attr['desc'] = $request->desc;

        if($request->has('grade'))
            $attr['grade'] = $request->grade;

        if($request->has('open'))
            $attr['open'] = $request->open;

        if($request->has('subject_id'))
            $attr['subject_id'] = $request->subject_id;

        if($request->has('duration'))
            $attr['duration'] = $request->duration;

        $upd = $exam->update($attr);
        if($upd)
            return response()->json([
                'success' => true,
                'result' =>"updated successfully"
                ]);

        return response()->json([
            'success' => false,
            'result' =>"update failed"
            ]);

    }

    protected function find(Request $request){
      $result= Exam::with('questions')->find($request->id);
       
      if($result==null)
          return response()->json([
              "success" =>false,
              "result" => "there is no exam with is id"
              ]);
      
      return response()->json([
          'success' => true,
          'result' => $result
      ]);
    }

    protected function findAll(Request $request){
        return response()->json([
            'success' => true,
            'result' => Exam::with('questions')->get()
        ]);
    }

    protected function findBySubject(Request $request){
        return response()->json([
            'success' => true,
            'result' =>exam::with('questions')->where('subject_id',$request->id)->get()
        ]);
    }

    protected function addToken(Request $request){
        $user = JWTAuth::toUser($request->token);        
        
        if($user==null)
            return response()->json([
                "success" => false,
                'result' =>"token not valid"
                ]);

        if($user->role == '0')
            return response()->json([
                "success" => false,
                'result' =>"You\'re not Authorized to take such this action!!"
                ]);

        $exam= exam::find($request->id);
        if($exam == null)
            return response()->json([
                'success' => false,
                'result' => 'cannot find exam with is id'
            ]);
            
        $exam->token = $request->examToken;
        $exam->token_creation_time = DB::raw('CURRENT_TIMESTAMP');
        $exam->save();

        if($exam)
            return response()->json([
                'success' => true,
                'result' => $exam
            ]);

        return response()->json([
            'success' => false,
            'result' => 'update failed'
        ]); 
    }

    protected function submission(Request $request){
        
        $user = JWTAuth::toUser($request->token);   
        
        $attach = $user->exams()->attach($request->examId , ['answers' => $request->answers,'grade'=>$request->grade]);
        return response()->json([
            "success" => true,
            'result' =>$attach
            ]);
    }

    protected function getSubmissions(Request $request){
        
        $answers = DB::table('exam_user')->join('exams' , 'exam_user.exam_id', '=','exams.id')->select('user_id' , 'exam_id' , 'exam_name' , 'desc')->where('exam_id' , $request->id)->get();
        if($answers)
            return response()->json([
                "success" => true,
                'result' =>$answers
                ]);

        return response()->json([
            "success" => false,
            'result' =>'cannot find exam with this id'
            ]);
    }


    protected function getAnswers(Request $request){
        $user = JWTAuth::toUser($request->token);
        $answers = DB::table('exam_user')->select('answers' , 'enrolled_at')->where('user_id' , $user->id)->where('exam_id' , $request->examId)->first();
        if($answers)
            return response()->json([
                "success" => true,
                'result' =>$answers
                ]);

        return response()->json([
            "success" => false,
            'result' =>'cannot find exam with this id'
            ]);
        
    }


    protected function getUserAns(Request $request){
        $user = JWTAuth::toUser($request->token);
        $answers = DB::table('exam_user')->select('answers' , 'enrolled_at')->where('user_id' , $request->userId)->where('exam_id' , $request->examId)->first();
        if($answers)
            return response()->json([
                "success" => true,
                'result' =>$answers
                ]);

        return response()->json([
            "success" => false,
            'result' =>'cannot find exam with this id'
            ]);
        
    }
    

}