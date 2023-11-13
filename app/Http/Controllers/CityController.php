<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\City;
use App\Labels\Lang;
use Tymon\JWTAuth\JWTAuth;
use App\Http\Repository\TrackingRepository;

class CityController extends Controller
{
    protected $jwt;

    public function __construct(JWTAuth $jwt){
        $this->middleware('auth:api', ['except' => []]);
        $this->jwt = $jwt;
    }

    /**
     * This function will create a new City in the database
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function insert(Request $request){
        $this->validate($request, [
            'name' => 'required|string',
            'alias' => 'required|string',
            'description' => 'required|string',
        ]);
        $city = new City();
        $city->name = $request->name;
        $city->alias = $request->alias;
        $city->description = $request->description;
        $city->save();
        return response()->json(['message' => 'City created successfully'], 201);
    }

    /**
     * This function will get all the cities from the database
     * @return \Illuminate\Http\JsonResponse
     */
    public function get_all(Request $request){
        if(!empty($request->name)){
            $cities = City::where('name', 'like', '%'.$request->name.'%')->get();
        }else{
            $cities = City::all();
        }
        return response()->json(['cities' => $cities], 200);
    }

    /**
     * This function will get a city by its id
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function get_by_id($id){
        $city = City::find($id);
        if(!$city){
            return response()->json(['message' => 'City not found'], 404);
        }
        return response()->json(['city' => $city], 200);
    }

    /**
     * This function will update a city by its id
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update_by_id(Request $request){
        $city = City::find($request->id);
        if(!$city){
            return response()->json(['message' => 'City not found'], 404);
        }
        $this->validate($request, [
            'name' => 'required|string',
            'alias' => 'required|string',
            'description' => 'required|string',
        ]);
        $city->name = $request->name;
        $city->alias = $request->alias;
        $city->description = $request->description;
        $city->save();
        return response()->json(['message' => 'City updated successfully'], 200);
    }

    /**
     * This function will delete a city by its id
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete_by_id($id){
        $city = City::find($id);
        if(!$city){
            return response()->json(['message' => 'City not found'], 404);
        }
        $city->delete();
        return response()->json(['message' => 'City deleted successfully'], 200);
    }
}