<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Rooms;
use App\Models\Position;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;

class EmploesController extends Controller{

    public function index(){
        $user = User::where('status',true)->get();
        $res = [];
        foreach ($user as $key => $value) {
            $res[$key]['id'] = $value->id;
            $res[$key]['name'] = $value->name;
            $res[$key]['phone'] = $value->phone;
            $res[$key]['position'] = $value->position->name;
        }
        return response()->json([
            'status' => true,
            'users'   => $res,
        ], 200);
    }

    public function index_end(){
        $user = User::where('status',false)->get();
        $res = [];
        foreach ($user as $key => $value) {
            $res[$key]['id'] = $value->id;
            $res[$key]['name'] = $value->name;
            $res[$key]['phone'] = $value->phone;
            $res[$key]['position'] = $value->position->name;
        }
        return response()->json([
            'status' => true,
            'users'   => $res,
        ], 200);
    }

    public function create(Request $request){
        $validator = Validator::make($request->all(), [
            'position_id' => ['required', 'integer', 'exists:positions,id'],
            'name'        => ['required', 'string', 'min:3', 'max:100'],
            'phone'       => ['required', 'string', 'regex:/^\+998\s?\d{2}\s?\d{3}\s?\d{4}$/', 'unique:users,phone'],
            'address'     => ['required', 'string', 'min:5', 'max:255'],
            'tkun'        => ['required', 'date_format:Y-m-d'],
            'seriya'      => ['required', 'string', 'regex:/^[A-Z]{2}\d{7}$/', 'unique:users,seriya'],
            'about'       => ['required', 'string', 'min:3'],
        ], [
            'phone.regex'       => 'Telefon raqam +998 90 123 0001 formatida bo‘lishi kerak.',
            'phone.unique'      => 'Bu telefon raqam bilan foydalanuvchi allaqachon mavjud.',
            'seriya.regex'      => 'Passport seriya AA1234567 formatida bo‘lishi kerak.',
            'seriya.unique'     => 'Bu passport seriya raqami oldin ro‘yxatdan o‘tgan.',
            'tkun.date_format'  => 'Tug‘ilgan sana YYYY-MM-DD formatida bo‘lishi kerak.',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status'  => false,
                'message' => 'Validatsiya xatoliklari mavjud',
                'errors'  => $validator->errors(),
            ], 422);
        }
        $data = $validator->validated();
        $data['password'] = Hash::make('password');
        $data['salary']   = 0;
        $data['status']   = true;
        $user = User::create($data);
        return response()->json([
            'status'  => true,
            'message' => 'Foydalanuvchi muvaffaqiyatli yaratildi',
            'user'    => $user->only([
                'id', 'position_id', 'name', 'phone', 'address', 'tkun', 'seriya', 'about', 'salary', 'status'
            ]),
        ], 200);
    }

    public function get_position(){
        $Position = Position::select('id','name','category')->get();
        return response()->json([
            'status'  => true,
            'message' => 'Lavozim turlari',
            'position'    => $Position,
        ], 200);
    }

}
