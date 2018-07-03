<?php
namespace App\Http\Controllers;

use App\question;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use JWTAuth;
use JWTAuthException;
class QuestionController extends Controller
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
            'question'=> 'required|string|max:500',
            'choices'=> 'required|string|max:1500',
            'exam_id'=>'required|string|max:500',
            'grade'=>'required|int'
        ]);
    }

    protected function create(Request $request){
        $user = JWTAuth::toUser($request->token);        
        
        if($user==null)
            return response()->json([
                'success' => false,
                'result' =>'token not valid'
                ]);

        if($user->role == "0")
            return response()->json([
                'success' => false,
                'result' =>'You\'re not Authorized to take such this action!!'
                ]);


        foreach($request->questions as $question){
            $newQ = question::create([
                    'question'=>$question['question'],
                    'choices'=>$question['choices'],
                    'exam_id'=>$question['exam_id'],
                    'grade'=>$question['grade'],
                    ]);
        }
                
        

        return response()->json([
            'success' => true,
            'result' =>'added successfully'
            ]);
    
    }

    protected function delete(Request $request){
        $user = JWTAuth::toUser($request->token); 
        $question=Question::find($request->id);

        if($user->role == "0")
            return response()->json([
                'success' => false,
                'result' =>'You\'re not Authorized to take such this action!!'
                ]);

        if($question==null)
            return response()->json([
                'success' => false,
                'result' =>'cannot find question'
                ]);
        
        $del = $question->delete();

        if($del)
            return response()->json([
                'success' => true,
                'result' =>'deleted successfully'
                ]);

        return response()->json([
            'success' => false,
            'result' =>'deleted failed'
            ]);
    }

    protected function update(Request $request){
        $user = JWTAuth::toUser($request->token);        
        
        if($user==null)
            return response()->json([
                'success' => false,
                'result' =>'token not valid'
                ]);

        if($user->role == "0")
            return response()->json([
                'success' => false,
                'result' =>'You\'re not Authorized to take such this action!!'
                ]);
    
    
        $question=Question::find($request->id);

        if($question==null)
            return response()->json([
                'success' => false,
                'result' =>'cannot find this question'
                ]);

        $attr = array();
        if($request->has('question'))
            $attr['question'] = $request->question;

        if($request->has('choices'))
            $attr['choices'] = $request->choices;

        if($request->has('grade'))
            $attr['grade'] = $request->grade;

        if($request->has('exam_id'))
            $attr['exam_id'] = $request->exam_id;

        $upd = $question->update($attr);
        if($upd)
            return response()->json([
                'success' => true,
                'result' =>'updated successfully'
                ]);

        return response()->json([
            'success' => false,
            'result' =>'updated failed'
            ]);
    
    }

    protected function find(Request $request){

        $result= Question::find($request->id);

        if($result==null)
            return response()->json([
                'success' => false,
                'result' =>'cannot find this question'
                ]);

        return response()->json([
            'success' => true,
            'result' =>$result
            ]);
    }

    protected function findAll(Request $request){
        return response()->json([
            'success' => true,
            'result' => question::all()
        ]);
    }

    protected function findByExam(Request $request){
        return response()->json([
            'success' => true,
            'result' => question::where('exam_id',$request->id)->get()
        ]);
    }

    protected function updateList(Request $request){
        $user = JWTAuth::toUser($request->token);        
        
        if($user==null)
            return response()->json([
                'success' => false,
                'result' =>'token not valid'
                ]);

        if($user->role == "0")
            return response()->json([
                'success' => false,
                'result' =>'You\'re not Authorized to take such this action!!'
                ]);

        $del = DB::table('questions')->where('exam_id' , $request->examId)->delete();
       // if($del){
            foreach($request->questions as $question){
                $newQ = question::create([
                        'question'=>$question['question'],
                        'choices'=>$question['choices'],
                        'exam_id'=>$question['exam_id'],
                        'grade'=>$question['grade'],
                        ]);
            }

            return response()->json([
                'success' => true,
                'result' =>'updated successfully'
                ]);
     //   }
        
        // return response()->json([
        //     'success' => false,
        //     'result' =>'cannot update questions'
        //     ]);
    }
}