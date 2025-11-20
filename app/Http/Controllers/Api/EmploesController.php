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
use App\Models\UserDavomad;
use App\Models\BalansHistory;
use App\Models\SettingPaymart;
use App\Models\UserPaymart;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
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

    protected function showIshHaqiPaymarts($id){
        $UserPaymart = UserPaymart::where('user_id',$id)->where('status',true)->orderby('id','desc')->get();
        $res = [];
        foreach ($UserPaymart as $key => $value) {
            $res[$key]['id']=$value->id;
            $res[$key]['admin_id']=User::find($value->admin_id)->name;
            $res[$key]['amount']=$value->amount;
            $res[$key]['type']=$value->type;
            $res[$key]['about']=$value->about;
            $res[$key]['created_at']=Carbon::parse($value->created_at)->format('Y-m-d h:i');
        }
        return $res;
    }
    protected function hodimAbout($id){
        $user = User::find($id);
            return [
                'id' => $user->id,
                'position_id' => $user->position_id,
                'name' => $user->name,
                'phone' => $user->phone,
                'address' => $user->address,
                'tkun' => Carbon::parse($user->tkun)->format('Y-m-d'),
                'seriya' => $user->seriya,
                'status' => $user->status,
                'salary' => $user->salary,
                'about' => $user->about,
            ];
        }
    protected function hodimDavomadi($id){
        $now = Carbon::now();
        $dataJStart = $now->copy()->startOfMonth()->format('Y-m-d');
        $dataJEnd   = $now->copy()->endOfMonth()->format('Y-m-d');
        $dataOStart = $now->copy()->subMonthNoOverflow()->startOfMonth()->format('Y-m-d');
        $dataOEnd   = $now->copy()->subMonthNoOverflow()->endOfMonth()->format('Y-m-d');
        $statuses = [
            'formada_keldi',
            'formasiz_keldi',
            'ish_kuni_emas',
            'kelmadi',
            'kechikdi',
            'kasal',
            'sababli'
        ];
        $getCounts = function ($start, $end) use ($id) {
            return UserDavomad::query()
                ->where('user_id', $id)
                ->whereBetween('data', [$start, $end])
                ->select('status', DB::raw('COUNT(*) as cnt'))
                ->groupBy('status')
                ->pluck('cnt', 'status') // [status => cnt]
                ->toArray();
        };
        $countsJ = $getCounts($dataJStart, $dataJEnd); // joriy oy
        $countsO = $getCounts($dataOStart, $dataOEnd); // o'tgan oy
        $J = [];
        $O = [];
        foreach ($statuses as $s) {
            $J[$s] = isset($countsJ[$s]) ? (int)$countsJ[$s] : 0;
            $O[$s] = isset($countsO[$s]) ? (int)$countsO[$s] : 0;
        }
        $jamiJ = $J['formada_keldi']
            + $J['formasiz_keldi']
            + $J['kelmadi']
            + $J['kechikdi']
            + $J['kasal']
            + $J['sababli'];
        $jamiO = $O['formada_keldi']
            + $O['formasiz_keldi']
            + $O['kelmadi']
            + $O['kechikdi']
            + $O['kasal']
            + $O['sababli'];
        return [
            'joriy_oy' => [
                'jami_ish_kuni'   => $jamiJ,
                'formada_keldi'   => $J['formada_keldi'],
                'formasiz_keldi'  => $J['formasiz_keldi'],
                'ish_kuni_emas'   => $J['ish_kuni_emas'],
                'kelmadi'         => $J['kelmadi'],
                'kechikdi'        => $J['kechikdi'],
                'kasal'           => $J['kasal'],
                'sababli'         => $J['sababli'],
            ],
            'otgan_oy' => [
                'jami_ish_kuni'   => $jamiO,
                'formada_keldi'   => $O['formada_keldi'],
                'formasiz_keldi'  => $O['formasiz_keldi'],
                'ish_kuni_emas'   => $O['ish_kuni_emas'],
                'kelmadi'         => $O['kelmadi'],
                'kechikdi'        => $O['kechikdi'],
                'kasal'           => $O['kasal'],
                'sababli'         => $O['sababli'],
            ],
        ];
    }
    public function show($id){
        return response()->json([
            'status' => true,
            'message' => "Hodim haqida.",
            'about' => $this->hodimAbout($id),
            'paymart' => $this->showIshHaqiPaymarts($id),
            'davomad' => $this->hodimDavomadi($id),
        ], 200);
    }

    public function davomad_emploes(){
        $users = User::where('status',true)->where('position_id','!=',1)->get();
        $res = [];
        foreach ($users as $key => $value) {
            $res[$key]['user_id'] = $value->id;
            $res[$key]['name'] = $value->name;
        }
        return response()->json([
            'status' => true,
            'message' => "Hodimlar davomad uchun.",
            'about' => $res
        ], 200);
    }

    public function create_davomad(Request $request){
        $data = $request->validate([
            'attendance' => ['required', 'array'],
            'attendance.*.user_id' => ['required', 'exists:users,id'],
            'attendance.*.status' => [
                'required',
                'in:formada_keldi,formasiz_keldi,ish_kuni_emas,kelmadi,kechikdi,kasal,sababli'
            ],
        ]);
        $today = now()->format('Y-m-d');
        foreach ($data['attendance'] as $item) {
            UserDavomad::updateOrCreate(
                [
                    'user_id' => $item['user_id'],
                    'data'    => $today,
                ],
                [
                    'status'   => $item['status'],
                    'admin_id' => auth()->user()->id,
                ]
            );
        }
        return response()->json([
            'status' => true,
            'message' => "Davomad muvaffaqiyatli saqlandi",
        ], 200);
    }
}
