<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Position;
use App\Models\Rooms;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class PositionsController extends Controller{

    public function index(){
        return view('positions.index');
    }

    public function rooms(){
        $Rooms = Rooms::get();
        $rooms = [];
        foreach ($Rooms as $key => $value) {
            $rooms[$key]['id'] = $value->id;
            $rooms[$key]['name'] = $value->name;
            $rooms[$key]['about'] = $value->about;
            $rooms[$key]['size'] = $value->size;
            $rooms[$key]['status'] = $value->status;
            $rooms[$key]['created_at'] = $value->created_at;
            $rooms[$key]['user'] = User::find($value->user_id)->name;
            if(!$value->status){
                $rooms[$key]['delete_user'] = User::find($value->delete_user_id)->name;
                $rooms[$key]['delete_data'] = $value->updated_at;
            }else{
                $rooms[$key]['delete_user'] = " ";
                $rooms[$key]['delete_data'] = " ";
            }
        }
        return view('rooms.index',compact('rooms'));
    }

    public function rooms_create(Request $request){
        $validate = $request->validate([
            'name'  => 'required|string|max:100|unique:rooms,name',
            'about' => 'required|string|max:256',
            'size'  => 'required|integer|min:1|max:100',
        ],[
            'name.required'   => 'Xona nomi kiritilishi shart.',
            'name.unique'     => 'Bu xona nomi allaqachon mavjud.',
            'about.required'  => 'Xona haqida ma’lumot yozilishi shart.',
            'size.required'   => 'Xona sig‘imi kiritilishi shart.',
            'size.integer'    => 'Xona sig‘imi raqam bo‘lishi kerak.',
            'size.min'        => 'Xona sig‘imi 1 dan kam bo‘lishi mumkin emas.',
            'size.max'        => 'Xona sig‘imi 1000 dan oshmasligi kerak.',
            'about.max'        => 'Xona haqida 256 belgidan oshmasligi kerak.',
            'name.max'        => 'Xona nomi 100 belgidan oshmasligi kerak.',
        ]);
        $validate['status'] = true;
        $validate['user_id'] = auth()->user()->id;
        Rooms::create($validate);
        return redirect()->back()->with('success', 'Xona muvaffaqiyatli saqlandi!');
    }

    public function rooms_delete(Request $request){
        $validate = $request->validate([
            'id'  => 'required|integer|min:1|max:1000',
        ]);

        $test = [
        'php_time'     => date('Y-m-d H:i:s'),
        'laravel_time' => now()->toDateTimeString(),
        'mysql_time'   => DB::select("SELECT NOW() as db_time")[0]->db_time,
        'carbon_now'   => \Carbon\Carbon::now()->format('Y-m-d H:i:s'),
        'app_timezone' => config('app.timezone'),
        'php_timezone' => date_default_timezone_get(),
    ];
    dd($test);
        $room = Rooms::find($request->id);
        $room->status = false;
        $room->delete_user_id = auth()->user()->id;
        $room->save();
        return redirect()->back()->with('success', 'Xona muvaffaqiyatli o\'chirildi!');
    }

}
