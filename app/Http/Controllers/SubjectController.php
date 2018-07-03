<?php
namespace App\Http\Controllers;

use App\subject;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

use JWTAuth;
use JWTAuthException;
class SubjectController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | subject Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */


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
            'subject_name' => 'required|string|max:255',
            'desc' => 'required|string',
            'user_id' => 'required|string',
        ]);
    }

    protected function create(Request $request){

        $user = JWTAuth::toUser($request->token);        
        
        if($user==null)
            return response()->json([
                'success' =>false,
                'result' => 'token not valid'
                ]);

        if($user->role != '1')
            return response()->json([
                'success' =>false , 
                'result' => 'You\'re not Authorized to take such this action!!'
                ]);
        
        $newSub = Subject::create([
            'user_id' => $user->id,
            'subject_name' => $request->subject_name,
            'desc' => $request->desc,
            ]);
    
        return response()->json([
            'success' =>true,
            'result' => $newSub
            ]);
        
    }

    protected function delete(Request $request){
        $user = JWTAuth::toUser($request->token);
        if($user->role == '0')
            return response()->json([
                'success' =>false , 
                'result' => 'You\'re not Authorized to take such this action!!'
                ]);
                
        $subject=Subject::find($request->id);

        if($subject!=null){
            $subject->delete();
            return response()->json([
                'success' =>true,
                'result' => 'deleted successfully'
                ]);
        }

        return response()->json([
            'success' =>false,
            'result' => 'subject not found'
            ]);
    }

    protected function update(Request $request){
        $user = JWTAuth::toUser($request->token);        
        
        if($user==null)
            return response()->json([
                'success' =>false,
                'result' => 'token not valid'
                ]);

        if($user->role == '0')
            return response()->json([
                'success' =>false , 
                'result' => 'You\'re not Authorized to take such this action!!'
                ]);

        $subject=Subject::find($request->id);

        if($subject==null)
            return response()->json([
                'success' =>false,
                'result' => 'subject not found'
                ]);

        $attr = array();
        if($request->has('subject_name'))
            $attr['subject_name'] = $request->subject_name;
        
        if($request->has('desc'))
            $attr['desc'] = $request->desc;
        
        $upd = $subject->update($attr);
        if($upd)
            return response()->json([
                'success' =>true,
                'result' =>'Updated Successfully' 
                ]);

        return response()->json([
            'success' =>false,
            'result' =>'Updated failed' 
            ]);  
    }

    protected function find(Request $request){

      $result= Subject::find($request->id);

      if($result==null)
          return response()->json([
              'success' =>false,
              'result' => 'subject not found'
              ]);
      

        return response()->json([
            'success' =>true,
            'result' => $result
            ]);
    }

    protected function findAll(Request $request){
        return response()->json([
            'success' => true,
            'result' => Subject::all()
        ]);
    }


    protected function findByDoctor(Request $request){
        return response()->json([
            'success' => true,
            'result' => Subject::where('user_id',$request->id)->get()
        ]);
    }

    protected function findEntrolledSubject(Request $request){
        $user = JWTAuth::toUser($request->token);        
        
        if($user==null)
            return response()->json([
                'success' =>false,
                'result' => 'token not valid'
                ]);

        if($user->role != '0')
            return response()->json([
                'success' =>false , 
                'result' => 'user with this prelividge cannot enroll subject'
                ]);

        $subs = User::find($user->id);
        
        return response()->json([
            'success' =>true , 
            'result' => $subs->subjects
            ]);

    }

    protected function subjectExams(Request $request){
      
        $subs = subject::find($request->id);
        if($subs)
            return response()->json([
                'success' => true,
                'result' => $subs->exams
            ]);

        return response()->json([
            'success' => false,
            'result' => 'cannot find subject with is id'
        ]);
    }
}