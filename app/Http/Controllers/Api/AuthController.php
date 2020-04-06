<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Login;
use App\Http\Requests\Register;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class AuthController extends Controller
{

    /**
     * @SWG\Post(
     *     path="/auth/signup",
     *     summary="Register user",
     *     tags={"User"},
     *     @SWG\Parameter(name="body", in="body", required=true, @SWG\Schema(
     *  @SWG\Property(
     *      property="name",
     *      type="string",
     *  ),
     *  @SWG\Property(
     *     property="email",
     *     type="string",
     *  ),
     *  @SWG\Property(
     *     property="password",
     *     type="string",
     *  ),
     *  @SWG\Property(
     *     property="password_confirmation",
     *     type="string",
     *  )
     * )),
     *     @SWG\Response(
     *         response=201,
     *         description="Successfully created user!",
     *     ),
     *     @SWG\Response(
     *         response=500,
     *         description="Error registration",
     *     )
     * )
     */
    public function signup(Register $request)
    {
        try{
            $user = new User([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password)
            ]);
            $user->save();
        }catch (\Exception $exception){
            return response()->json([
                'message' =>  $exception->getMessage()
            ], 500);
        }
        return response()->json([
            'message' => __('messages.register')
        ], 201);
    }

    /**
     * @SWG\Post(
     *     path="/auth/login",
     *     summary="Login user",
     *     tags={"User"},
     *     @SWG\Parameter(name="body", in="body", required=true, @SWG\Schema(
     *  @SWG\Property(
     *     property="email",
     *     type="string"
     *  ),
     *  @SWG\Property(
     *     property="password",
     *     type="string"
     *  )
     * )),
     *     @SWG\Response(
     *         response=201,
     *         description="Success login",
     *         @SWG\schema(
     *     		type="object",
     *                  @SWG\Property(property="access_token", type="string"),
     *              	@SWG\Property(property="token_type", type="string"),
     *                  @SWG\Property(property="expires_at", type="string"),
     *      )
     *     ),
     *   @SWG\Response(
     *         response=500,
     *         description="Error login",
     *     )
     * )
     */
    public function login(Login $request)
    {
        try{
            $credentials = request(['email', 'password']);
            if(!Auth::attempt($credentials))
                return response()->json([
                    'message' => 'Unauthorized'
                ], 401);
            $user = $request->user();
            $tokenResult = $user->createToken('Personal Access Token');
            $token = $tokenResult->token;
            if ($request->remember_me)
                $token->expires_at = Carbon::now()->addWeeks(1);
            $token->save();
        }catch (\Exception $exception){
            return response()->json([
                'message' => __('messages.logInError')
            ], 500);
        }
        return response()->json([
            'access_token' => $tokenResult->accessToken,
            'token_type' => 'Bearer',
            'expires_at' => Carbon::parse(
                $tokenResult->token->expires_at
            )->toDateTimeString()
        ]);
    }

    /**
     * @SWG\Get(
     *     path="/auth/logout",
     *     summary="logout",
     *     tags={"User"},
     *     @SWG\Response(
     *         response=200,
     *         description="Successfully logged out",
     *     ),
     *     @SWG\Response(
     *         response="500",
     *         description="LogOut error",
     *     ),
     *     security={{"Bearer": {}}}
     * )
     */
    public function logout(Request $request)
    {
        try{
            $request->user()->token()->revoke();
        }catch (\Exception $exception){
            return response()->json([
                'message' => __('messages.logOutError')
            ], 500);
        }
        return response()->json([
            'message' => 'Successfully logged out'
        ],200);
    }
}
