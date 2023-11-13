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

class ChatController extends Controller
{
    protected $jwt;

    public function __construct(JWTAuth $jwt){
        $this->middleware('auth:api', ['except' => []]);
        $this->jwt = $jwt;
    }

    /**
     * This function will create a new Chat in the database
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function insert(Request $request){
        $this->validate($request, [
            'message' => 'required|string',
            'id_user' => 'required|string',
            'chat_hash' => 'required|string',
        ]);
        $chat = new Chat();
        $chat->message = $request->message;
        $chat->id_user = $request->id_user;
        $chat->chat_hash = $request->chat_hash;
        $chat->save();
        return response()->json(['message' => 'Chat created successfully'], 201);
    }

    /**
     * This function will get all the chats from the database
     * @return \Illuminate\Http\JsonResponse
     */
    public function get_all(Request $request){
        if(!empty($request->message)){
            $chats = Chat::where('message', 'like', '%'.$request->message.'%')->get();
        }else{
            $chats = Chat::all();
        }
        return response()->json(['chats' => $chats], 200);
    }

    /**
     * This function will get a chat by its id
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function get_by_id($id){
        $chat = chat::find($id);
        if(!$chat){
            return response()->json(['message' => 'Chat not found'], 404);
        }
        return response()->json(['chat' => $chat], 200);
    }

    /**
     * This function will update a chat by its id
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update_by_id(Request $request){
        $chat = chat::find($request->id);
        if(!$chat){
            return response()->json(['message' => 'Chat not found'], 404);
        }
        $this->validate($request, [
            'message' => 'required|string',
            'id_user' => 'required|string',
            'chat_hash' => 'required|string',
        ]);
        $chat = new Chat();
        $chat->message = $request->message;
        $chat->id_user = $request->id_user;
        $chat->chat_hash = $request->chat_hash;
        $chat->save();
        return response()->json(['message' => 'Chat updated successfully'], 200);
    }

    /**
     * This function will delete a chat by its id
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete_by_id($id){
        $chat = chat::find($id);
        if(!$chat){
            return response()->json(['message' => 'Chat not found'], 404);
        }
        $chat->delete();
        return response()->json(['message' => 'Chat deleted successfully'], 200);
    }
}