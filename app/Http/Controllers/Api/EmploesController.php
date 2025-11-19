<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Rooms;
use App\Models\Position;
use App\Models\Kassa;
use App\Models\KassaHistory;
use App\Models\Balans;
use App\Models\BalansHistory;
use App\Models\SettingPaymart;
use App\Models\UserPaymart;
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
            'salary'       => ['required', 'integer'],
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

    public function create_paymart(Request $request){
        $data = $request->validate([
            'user_id' => ['required','integer','exists:users,id'],
            'type' => ['required','string', 'in:naqt,card,shot'],
            'amount' => ['required','integer'],
            'about' => ['required','string']
        ]);
        $Balans = Balans::first();
        $naqt = $Balans->naqt;
        $card = $Balans->card;
        $shot = $Balans->shot;
        $amount = $data['amount'];
        if($data['type']=='naqt'){
            if($naqt<$amount){
                return response()->json([
                    'status'  => false,
                    'message' => 'Balansda yetarli mablag\' mavjud emas.',
                ], 402);
            }
            $Balans->naqt = $naqt - $amount;
            $status = "ish_haqi_naqt";
        }elseif($data['type']=='card'){
            if($card<$amount){
                return response()->json([
                    'status'  => false,
                    'message' => 'Balansda yetarli mablag\' mavjud emas.',
                ], 402);
            }
            $Balans->card = $card - $amount;
            $status = "ish_haqi_card";
        }else{
            if($shot<$amount){
                return response()->json([
                    'status'  => false,
                    'message' => 'Balansda yetarli mablag\' mavjud emas.',
                ], 402);
            }
            $Balans->shot = $shot - $amount;
            $status= "ish_haqi_shot";
        }
        $Balans->save();
        $BalansHistory = BalansHistory::create([
            'type' => $data['type'],
            'status' => $status,
            'amount' => $data['amount'],
            'about' => $data['about'],
            'user_id' => $data['user_id'],
            'admin_id' => auth()->user()->id,
        ]);
        $UserPaymart = UserPaymart::create([
            'user_id' => $data['user_id'],
            'admin_id' => auth()->user()->id,
            'status' => true,
            'amount' => $data['amount'],
            'type' => $data['type'],
            'about' => $data['about'],
        ]);
        return response()->json([
            'status' => true,
            'message' => "Ish haqi to'landi.",
        ], 200);
    }

    public function create_paymart_meneger(Request $request){
        $Kassa = Kassa::first();
        $kassa_naqt = $Kassa->kassa_naqt;
        $teacher_pedding_pay_naqt = $Kassa->teacher_pedding_pay_naqt;
        $data = $request->validate([
            'techer_id' => ['required','integer','exists:users,id'],
            'amount' => ['required','integer'],
            'about' => ['required','string']
        ]);
        if($kassa_naqt<$data['amount']){
            return response()->json([
                'status'  => false,
                'message' => 'Kassada yetarli mablag\' mavjud emas.',
            ], 402);
        }
        $Kassa->kassa_naqt = $Kassa->kassa_naqt - $data['amount'];
        $Kassa->teacher_pedding_pay_naqt = $Kassa->teacher_pedding_pay_naqt + $data['amount'];
        $Kassa->save();
        $KassaHistory = KassaHistory::create([
            'type'=>'ish_haqi',
            'amount'=>$data['amount'],
            'user_id'=>auth()->user()->id,
            'teacher_id'=>$data['techer_id'],
            'create_data'=>date("Y-m-d h:i"),
            'status'=>false,
            'about'=>$data['about'],
        ]);
        return response()->json([
            'status' => true,
            'message' => "Ish haqi to'lovi tasdiqlash kutilmoqda.",
        ], 200);
    }

}
