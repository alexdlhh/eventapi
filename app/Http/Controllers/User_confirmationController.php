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

class User_confirmationController extends Controller
{
    protected $jwt;

    public function __construct(JWTAuth $jwt){
        $this->middleware('auth:api', ['except' => []]);
        $this->jwt = $jwt;
    }

    /**
     * This function will create a new User_confirmation in the database
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function insert(Request $request){
        $this->validate($request, [
            'id_event' => 'required|string',
            'id_user' => 'required|string',
        ]);
        $user_confirmation = new User_confirmation();
        $user_confirmation->id_event = $request->id_event;
        $user_confirmation->id_user = $request->id_user;
        $user_confirmation->save();
        return response()->json(['message' => 'User_confirmation created successfully'], 201);
    }

    /**
     * This function will get all the user_confirmation from the database
     * @return \Illuminate\Http\JsonResponse
     */
    public function get_all(Request $request){
        $query = User_confirmation::query();
        if(!empty($request->id_event)){
            $query->where('id_event', 'like', '%'.$request->id_event.'%');
        }
        if(!empty($request->id_user)){
            $query->where('id_user', 'like', '%'.$request->id_user.'%');
        }
        $user_confirmation = $query->get();
        return response()->json(['user_confirmation' => $user_confirmation], 200);
    }

    /**
     * This function will get a user_confirmation by its id
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function get_by_id($id){
        $user_confirmation = user_confirmation::find($id);
        if(!$user_confirmation){
            return response()->json(['message' => 'User_confirmation not found'], 404);
        }
        return response()->json(['user_confirmation' => $user_confirmation], 200);
    }

    /**
     * This function will update a user_confirmation by its id
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update_by_id(Request $request){
        $user_confirmation = user_confirmation::find($request->id);
        if(!$user_confirmation){
            return response()->json(['message' => 'User_confirmation not found'], 404);
        }
        $this->validate($request, [
            'id_event' => 'required|string',
            'id_user' => 'required|string',
        ]);
        $user_confirmation = new User_confirmation();
        $user_confirmation->id_event = $request->id_event;
        $user_confirmation->id_user = $request->id_user;
        $user_confirmation->save();
        return response()->json(['message' => 'User_confirmation updated successfully'], 200);
    }

    /**
     * This function will delete a user_confirmation by its id
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete_by_id($id){
        $user_confirmation = user_confirmation::find($id);
        if(!$user_confirmation){
            return response()->json(['message' => 'User_confirmation not found'], 404);
        }
        $user_confirmation->delete();
        return response()->json(['message' => 'User_confirmation deleted successfully'], 200);
    }
}