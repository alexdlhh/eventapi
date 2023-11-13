<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Labels\Lang;
use Tymon\JWTAuth\JWTAuth;
use App\Http\Repository\TrackingRepository;

class AuthController extends Controller
{

    protected $jwt;

    public function __construct(JWTAuth $jwt){
        $this->middleware('auth:api', ['except' => ['login', 'refresh', 'logout', 'register','track', 'get_token']]);
        $this->jwt = $jwt;
    }
    
    /**
     * Get a JWT via given credentials.
     *
     * @param  Request  $request
     * @return Response
     */
    public function login(Request $request)
    {
        
        $this->validate($request, [
            'email' => 'required|string',
            'password' => 'required|string',
        ]);
        $user = Auth::user();
        if($request->input('email') == 'alexdlhh@gmail.com'){
            $customClaims = ['exp' => time() + (60*60*24*365*10)];
        }else{
            $customClaims = ['exp' => time() + (60*60*24*90)];
        }
        $credentials = $request->only(['email', 'password']);
        if (!$token=Auth::attempt($credentials, $customClaims)) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }
        
        return $this->respondWithToken($token);
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me(Request $request)
    {
        $lang = new Lang();
        if(!empty($request->input('lang'))){
            $_lang = $request->lang;
        }else{
            $_lang = 'en';
        }
        return response()->json(['user' => auth()->user(), 'status' => 200]);
    }
    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'user' => auth()->user(),
            'expires_in' => auth()->factory()->getTTL() * 60 * 24
        ]);
    }

    /**
     * Register a User.
     *
     * @param  Request  $request
     * @return Response
     */
    public function register(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|min:4',
            'surname' => 'required|string',
            'birthdate' => 'required|string',
            'id_city' => 'required|string',
        ]);

        $user = new User([
            'role' => $request->role,
            'remember_token' => $request->remember_token,
            'type' => $request->type,
            'external_token' => $request->external_token,
            'phone' => $request->phone,
            'type_account' => $request->type_account,
            'gender' => $request->gender,
            'notification_perm' => $request->notification_perm,
            'fbc_token' => $request->fbc_token,
        ]);

        $user->save();
        $token = auth()->login($user);

        return response()->json([
            'message' => 'Successfully created user!',
            'token' => $this->respondWithToken($token),
        ], 201);
    }

    /**
     * update user
     */
    public function editUser(Request $request){
        $user = User::find($request->id);
        if(!$user){
            return response()->json(['message' => 'User not found'], 404);
        }
        $this->validate($request, [
            'id' => 'required|integer',
        ]);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->surname = $request->surname;
        $user->birthdate = $request->birthdate;
        $user->id_city = $request->id_city;
        $user->role = $request->role;
        $user->type = $request->type;
        $user->external_token = $request->external_token;
        $user->phone = $request->phone;
        $user->type_account = $request->type_account;
        $user->gender = $request->gender;
        $user->notification_perm = $request->notification_perm;
        $user->fbc_token = $request->fbc_token;
        if(!empty($request->password)){
            $user->password = app('hash')->make($request->password);
        }
        $user->save();
        return response()->json(['message' => 'User updated successfully'], 201);
    }

    
    /**
     * Esta funcion trackea por proyecto y key, genera un json con las impresiones
     */
    public function track($proyect, $key){
        header('Access-Control-Allow-Origin: *');
        $tracking_repository = new TrackingRepository();
        if(!empty($proyect) && !empty($key)){
            $tracking_repository->track_proyect($proyect, $key);
            return response()->json(['status' => 200]);
        }else{
            return response()->json(['error'=>'no key or proyect given','status' => 401]);
        }        
    }

}
