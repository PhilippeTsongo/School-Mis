<?php

namespace App\Http\Controllers\Auth;

use Throwable;
use App\Models\User;
use App\Models\UserToken;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Providers\RouteServiceProvider;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Support\Facades\Validator;

class AuthenticatedSessionController extends Controller
{
   
    public function create()
    {
        return view('auth.login');
    }

    
    public function store(LoginRequest $request)
    {
        //$request->authenticate();

        //$request->session()->regenerate();


        try {
            $rules=[
                'email'=>"required|exists:users|email",
                'password'=>"required|min:8|string",
            ];
            $validate = Validator::make($request->all(), $rules);
            if($validate->fails()){
                $errors=$validate->errors();
                return response()->json(["message" => "Invalid data in the request", "errors" => $errors, "status"=>422],422);
            }

            $user = User::where('email', $request->email)->first();
            if($user){
                if(Hash::check($request->password,$user->password)){
                    $token= $user->createToken('key')->plainTextToken;

                    $request->session()->regenerate();

                    $data=array(
                        'message'=>'Successfully Logged In',
                        'user'=>array(
                            'name'=>$user->name,
                            'email'=>$user->email,
                        ),
                        'accessToken'=>$token,
                        'status'=>200
                    );

                    return response()->json($data,200);
                }
                return response()->json(["message" => "Invalid Email or Password", "status" => 411],411);
            }
            return response()->json(["message" => "User Not Found or Invalid","status" => 411],411);
        } catch (Throwable $th) {
            //error_log($th);
            return response()->json(["Internal server error", "status" => 500, "errors"=>$th],500);
        }

        // $user = User::where('email', $request->email)->first();
        // $token = Str::random(45);
        // $save_token = UserToken::create([
        //     'token_name' => 'user_token',
        //     'user_id' => $user->id,
        //     'token' => $token,
        // ]);

        //return redirect()->intended(RouteServiceProvider::HOME);

    }

    
    public function destroy(Request $request) 
    {

        $user = User::where('email', $request->user_email)->first();
        
        $user->userToken->delete();

        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
