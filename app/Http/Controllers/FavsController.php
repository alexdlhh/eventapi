<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\City;
use App\Models\Chat;
use App\Models\Event;
use App\Models\Favs;
use App\Labels\Lang;
use Tymon\JWTAuth\JWTAuth;
use App\Http\Repository\TrackingRepository;

class FavsController extends Controller
{
    protected $jwt;

    public function __construct(JWTAuth $jwt){
        $this->middleware('auth:api', ['except' => []]);
        $this->jwt = $jwt;
    }

    /**
     * This function will create a new Favs in the database
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function insert(Request $request){
        $this->validate($request, [
            'id_event' => 'required|string',
            'id_user' => 'required|string',
        ]);
        $favs = new Favs();
        $favs->id_event = $request->id_event;
        $favs->id_user = $request->id_user;
        $favs->save();
        return response()->json(['message' => 'Favs created successfully'], 201);
    }

    /**
     * This function will get all the favs from the database
     * @return \Illuminate\Http\JsonResponse
     */
    public function get_all(Request $request){
        $query = favs::query();
        if(!empty($request->id_event)){
            $query->where('id_event', 'like', '%'.$request->id_event.'%');
        }
        if(!empty($request->id_user)){
            $query->where('id_user', 'like', '%'.$request->id_user.'%');
        }
        $favs = $query->get();
        return response()->json(['favs' => $favs], 200);
    }

    /**
     * This function will get a favs by its id_user
     * @param $id_user
     * @return \Illuminate\Http\JsonResponse
     */
    public function get_by_user($id_user){
        $favs = favs::where('id_user', $id_user)->get();
        $events = [];
        foreach($favs as $fav){
            $event = Event::where('id', $fav->id_event)->first();
            $events[] = $event;
        }
        return response()->json(['favs' => $events], 200);
    }

    /**
     * This function will update a favs by its id
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update_by_id(Request $request){
        $favs = favs::find($request->id);
        if(!$favs){
            return response()->json(['message' => 'Favs not found'], 404);
        }
        $this->validate($request, [
            'id_event' => 'required|string',
            'id_user' => 'required|string',
        ]);
        $favs = new Favs();
        $favs->id_event = $request->id_event;
        $favs->id_user = $request->id_user;
        $favs->save();
        return response()->json(['message' => 'Favs updated successfully'], 200);
    }

    /**
     * This function will delete a favs by its id
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete_by_id($id){
        $favs = favs::find($id);
        if(!$favs){
            return response()->json(['message' => 'Favs not found'], 404);
        }
        $favs->delete();
        return response()->json(['message' => 'Favs deleted successfully'], 200);
    }
}