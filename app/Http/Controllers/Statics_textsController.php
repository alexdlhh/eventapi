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
use App\Labels\Lang;
use Tymon\JWTAuth\JWTAuth;
use App\Http\Repository\TrackingRepository;

class Statics_textsController extends Controller
{
    protected $jwt;

    public function __construct(JWTAuth $jwt){
        $this->middleware('auth:api', ['except' => []]);
        $this->jwt = $jwt;
    }

    /**
     * This function will create a new Statics_texts in the database
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function insert(Request $request){
        $this->validate($request, [
            'title' => 'required|string',
            'body' => 'required|string',
        ]);
        $statics_texts = new Statics_texts();
        $statics_texts->title = $request->title;
        $statics_texts->body = $request->body;
        $statics_texts->save();
        return response()->json(['message' => 'Statics_texts created successfully'], 201);
    }

    /**
     * This function will get all the statics_texts from the database
     * @return \Illuminate\Http\JsonResponse
     */
    public function get_all(Request $request){
        $query = Statics_texts::query();
        if(!empty($request->title)){
            $query->where('title', 'like', '%'.$request->title.'%');
        }
        if(!empty($request->body)){
            $query->where('body', 'like', '%'.$request->body.'%');
        }
        $statics_texts = $query->get();
        return response()->json(['statics_texts' => $statics_texts], 200);
    }

    /**
     * This function will get a statics_texts by its id
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function get_by_id($id){
        $statics_texts = statics_texts::find($id);
        if(!$statics_texts){
            return response()->json(['message' => 'Statics_texts not found'], 404);
        }
        return response()->json(['statics_texts' => $statics_texts], 200);
    }

    /**
     * This function will update a statics_texts by its id
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update_by_id(Request $request){
        $statics_texts = statics_texts::find($request->id);
        if(!$statics_texts){
            return response()->json(['message' => 'Statics_texts not found'], 404);
        }
        $this->validate($request, [
            'title' => 'required|string',
            'body' => 'required|string',
        ]);
        $statics_texts = new Statics_texts();
        $statics_texts->title = $request->title;
        $statics_texts->body = $request->body;
        $statics_texts->save();
        return response()->json(['message' => 'Statics_texts updated successfully'], 200);
    }

    /**
     * This function will delete a statics_texts by its id
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete_by_id($id){
        $statics_texts = statics_texts::find($id);
        if(!$statics_texts){
            return response()->json(['message' => 'Statics_texts not found'], 404);
        }
        $statics_texts->delete();
        return response()->json(['message' => 'Statics_texts deleted successfully'], 200);
    }
}