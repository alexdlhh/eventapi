<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\City;
use App\Models\Chat;
use App\Models\Event;
use App\Labels\Lang;
use Tymon\JWTAuth\JWTAuth;
use App\Http\Repository\TrackingRepository;

class EventController extends Controller
{
    protected $jwt;

    public function __construct(JWTAuth $jwt){
        $this->middleware('auth:api', ['except' => []]);
        $this->jwt = $jwt;
    }

    /**
     * This function will create a new Event in the database
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function insert(Request $request){
        $this->validate($request, [
            'title' => 'required|string',
            'image' => 'required|string',
            'date_start' => 'required|date',
            'date_end' => 'required|date',
            'time_start' => 'required|string',
            'time_end' => 'required|string',
            'id_city' => 'required|integer',
            'payment_method' => 'required|string',
            'chat_hash' => 'required|string',
            'description' => 'required|string',
            'asistence_confirm' => 'required|integer',
            'share_confirm' => 'required|integer',
            'admins' => 'required|string',
            'id_user' => 'required|integer', 
        ]);
        $event = new Event();
        $event->title = $request->title;
        $event->image = $request->image;
        $event->date_start = $request->date_start;
        $event->date_end = $request->date_end;
        $event->time_start = $request->time_start;
        $event->time_end = $request->time_end;
        $event->id_city = $request->id_city;
        $event->payment_method = $request->payment_method;
        $event->chat_hash = $request->chat_hash;
        $event->description = $request->description;
        $event->asistence_confirm = $request->asistence_confirm;
        $event->share_confirm = $request->share_confirm;
        $event->admins = $request->admins;
        $event->id_user = $request->id_user;
        $event->save();
        return response()->json(['message' => 'Event created successfully'], 201);
    }

    /**
     * This function will get all the events from the database
     * @return \Illuminate\Http\JsonResponse
     */
    public function get_all(Request $request){
        $query = Event::query();
        if(!empty($request->title)){
            $query->where('title', 'like', '%'.$request->title.'%');
        }
        if(!empty($request->date_start)){
            $query->where('date_start', 'like', '%'.$request->date_start.'%');
        }
        if(!empty($request->description)){
            $query->where('description', 'like', '%'.$request->description.'%');
        }
        if(!empty($request->id_city)){
            $query->where('id_city', 'like', '%'.$request->id_city.'%');
        }
        $events = $query->get();

        foreach($events as $key => $event):
            $city = City::where('id', $event->id_city)->first();
            $events[$key]->city = $city;
            $user = User::where('id', $event->id_user)->first();
            $events[$key]->user = $user;
            //lista vacia
            $admins = [];
            //separar por comas
            $admins_id = explode(',', $event->admins);
            //recorrer el array de ids
            foreach($admins_id as $admin_id):
                //buscar el usuario por id
                $admin = User::where('id', $admin_id)->first();
                //agregarlo a la lista
                $admins[] = $admin;
            endforeach;
            //agregar la lista de admins al evento
            $events[$key]->admins = $admins;
        endforeach;


        return response()->json(['events' => $events], 200);
    }

    /**
     * This function will get a event by its id
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function get_by_id($id){
        $event = Event::find($id);
        if(!$event){
            return response()->json(['message' => 'Event not found'], 404);
        }
        return response()->json(['event' => $event], 200);
    }

    /**
     * This function will update a event by its id
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update_by_id(Request $request){
        $event = event::find($request->id);
        if(!$event){
            return response()->json(['message' => 'Event not found'], 404);
        }
        $this->validate($request, [
            'title' => 'required|string',
            'image' => 'required|string',
            'date_start' => 'required|date',
            'date_end' => 'required|date',
            'time_start' => 'required|string',
            'time_end' => 'required|string',
            'id_city' => 'required|integer',
            'payment_method' => 'required|string',
            'chat_hash' => 'required|string',
            'description' => 'required|string',
            'asistence_confirm' => 'required|integer',
            'share_confirm' => 'required|integer',
            'admins' => 'required|string',
            'id_user' => 'required|integer', 
        ]);
        $event = new Event();
        $event->title = $request->title;
        $event->image = $request->image;
        $event->date_start = $request->date_start;
        $event->date_end = $request->date_end;
        $event->time_start = $request->time_start;
        $event->time_end = $request->time_end;
        $event->id_city = $request->id_city;
        $event->payment_method = $request->payment_method;
        $event->chat_hash = $request->chat_hash;
        $event->description = $request->description;
        $event->asistence_confirm = $request->asistence_confirm;
        $event->share_confirm = $request->share_confirm;
        $event->admins = $request->admins;
        $event->id_user = $request->id_user;
        $event->save();
        return response()->json(['message' => 'Event updated successfully'], 200);
    }
    /**
     * This function will delete a event by its id
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete_by_id($id){
        $event = event::find($id);
        if(!$event){
            return response()->json(['message' => 'Event not found'], 404);
        }
        $event->delete();
        return response()->json(['message' => 'Event deleted successfully'], 200);
    }
}