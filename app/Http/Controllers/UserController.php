<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\City;
use App\Models\Chat;
use App\Models\Event;
use App\Models\Favs;
use App\Models\Statics_texts;
use App\Models\User_confirmation;
use App\Labels\Lang;
use Tymon\JWTAuth\JWTAuth;
use App\Http\Repository\TrackingRepository;

class UserController extends Controller
{
    protected $jwt;

    public function __construct(JWTAuth $jwt){
        $this->middleware('auth:api', ['except' => []]);
        $this->jwt = $jwt;
    }

    /**
     * This function will create a new User in the database
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function insert(Request $request){
        $this->validate($request, [
            'name' => 'required|string',
            'email' => 'required|string',
            'password' => 'required|string',
            'role' => 'required|string',
            'remember_token' => 'required|string',
            'type' => 'required|string',
            'external_token' => 'required|string',
            'surname' => 'required|string',
            'birthdate' => 'required|string',
            'id_city' => 'required|string',
            'phone' => 'required|string',
            'tipe_account' => 'required|string',
            'gender' => 'required|int',
            'notification_perm' => 'required|int',
            'fbc_token' => 'required|string',
        ]);
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = $request->password;
        $user->role = $request->role;
        $user->remember_token = $request->remember_token;
        $user->type = $request->type;
        $user->external_token = $request->external_token;
        $user->surname = $request->surname;
        $user->birthdate = $request->birthdate;
        $user->id_city = $request->id_city;
        $user->phone = $request->phone;
        $user->tipe_account = $request->tipe_account;
        $user->gender = $request->gender;
        $user->notification_perm = $request->notification_perm;
        $user->fbc_token = $request->fbc_token;
        $user->save();
        return response()->json(['message' => 'User created successfully'], 201);
    }

    /**
     * This function will get all the user from the database
     * @return \Illuminate\Http\JsonResponse
     */
    public function get_all(Request $request){
        if(!empty($request->message)){
            $user = user::where('name', 'like', '%'.$request->name.'%')->get();
            $user = user::where('surname', 'like', '%'.$request->surname.'%')->get();
        }else{
            $user = user::all();
        }
        return response()->json(['user' => $user], 200);
    }

    /**
     * This function will get a user by its id
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function get_by_id($id){
        $user = user::find($id);
        if(!$user){
            return response()->json(['message' => 'User not found'], 404);
        }
        return response()->json(['user' => $user], 200);
    }

    /**
     * This function will update a user by its id
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update_by_id(Request $request){
        $user = user::find($request->id);
        if(!$user){
            return response()->json(['message' => 'User not found'], 404);
        }
        $this->validate($request, [
            'name' => 'required|string',
            'email' => 'required|string',
            'password' => 'required|string',
            'role' => 'required|string',
            'remember_token' => 'required|string',
            'type' => 'required|string',
            'external_token' => 'required|string',
            'surname' => 'required|string',
            'birthdate' => 'required|string',
            'id_city' => 'required|string',
            'phone' => 'required|string',
            'tipe_account' => 'required|string',
            'gender' => 'required|string',
            'notification_perm' => 'required|int',
            'fbc_token' => 'required|string',
        ]);
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = $request->password;
        $user->role = $request->role;
        $user->remember_token = $request->remember_token;
        $user->type = $request->type;
        $user->external_token = $request->external_token;
        $user->surname = $request->surname;
        $user->birthdate = $request->birthdate;
        $user->id_city = $request->id_city;
        $user->phone = $request->phone;
        $user->tipe_account = $request->tipe_account;
        $user->gender = $request->gender;
        $user->notification_perm = $request->notification_perm;
        $user->fbc_token = $request->fbc_token;
        $user->save();
        return response()->json(['message' => 'User updated successfully'], 200);
    }

    /**
     * This function will delete a user by its id
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete_by_id($id){
        $user = user::find($id);
        if(!$user){
            return response()->json(['message' => 'User not found'], 404);
        }
        $user->delete();
        return response()->json(['message' => 'User deleted successfully'], 200);
    }
}