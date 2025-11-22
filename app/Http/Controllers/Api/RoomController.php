<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Rooms;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class RoomController extends Controller{

    public function index(){
        $Rooms = Rooms::where('status',true)->get();
        $rooms = [];
        foreach ($Rooms as $key => $value) {
            $rooms[$key]['id'] = $value->id;
            $rooms[$key]['name'] = $value->name;
            $rooms[$key]['about'] = $value->about;
            $rooms[$key]['size'] = $value->size;
            $rooms[$key]['status'] = $value->status;
            $rooms[$key]['created_at'] = Carbon::parse($value->created_at)->format('Y-m-d');
            $rooms[$key]['user'] = User::find($value->user_id)->name;
            if(!$value->status){
                $rooms[$key]['delete_user'] = User::find($value->delete_user_id)->name;
                $rooms[$key]['delete_data'] = Carbon::parse($value->updated_at)->format('Y-m-d');
            }else{
                $rooms[$key]['delete_user'] = " ";
                $rooms[$key]['delete_data'] = " ";
            }
        }
        return response()->json([
            'status' => true,
            'rooms'   => $rooms,
        ], 200);
    }

    public function create(Request $request){

        $validate = $request->validate([
            'name'  => 'required|string|max:100|unique:rooms,name',
            'about' => 'required|string|max:256',
            'size'  => 'required|integer|min:1|max:100',
        ]);
        $validate['status'] = true;
        $validate['user_id'] = auth()->user()->id;
        $rooms = Rooms::create($validate);
        return response()->json([
            'status' => true,
            'rooms'   => [
                'id' => $rooms['id'],
                'name' => $rooms['name'],
                'about' => $rooms['about'],
                'size' => $rooms['size'],
            ],
        ], 200);
    }

    public function delete(Request $request){
        $validate = $request->validate([
            'id'  => 'required|integer|min:1|max:1000',
        ]);
        $room = Rooms::find($request->id);
        $room->status = false;
        $room->delete_user_id = auth()->user()->id;
        $room->save();
        return response()->json([
            'status' => true,
            'message'   => "Xona mufaqqiyatli o'chirildi",
        ], 200);
    }

}
