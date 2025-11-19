<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Child;
use App\Models\User;
use App\Models\ChildRelative;
use App\Models\ChildDocument;
use App\Models\ChildPaymart;
use App\Models\Kassa;
use App\Models\KassaHistory;
use App\Models\Balans;
use App\Models\UserPaymart;
use App\Models\BalansHistory;
use App\Models\SettingPaymart;
use Carbon\Carbon;


class KassaController extends Controller{

    public function kassa(){
        $kassa = Kassa::first();
        $pedding_paymart = ChildPaymart::orderby('id','desc')->where('status',false)->get();
        $res_pay_pedding = [];
        foreach ($pedding_paymart as $key => $value) {
            $res_pay_pedding[$key]['id'] = $value->id;
            $res_pay_pedding[$key]['child'] = Child::find($value->child_id)->name;
            $res_pay_pedding[$key]['relative'] = ChildRelative::find($value->child_relative_id)->name;
            $res_pay_pedding[$key]['amount'] = $value->amount;
            $res_pay_pedding[$key]['type'] = $value->type;
            $res_pay_pedding[$key]['status'] = $value->status;
            $res_pay_pedding[$key]['meneger'] = User::find($value->user_id)->name;
            $res_pay_pedding[$key]['data'] = Carbon::parse($value->created_at)->format('Y-m-d h:i');
        }
        $kassaHistory = KassaHistory::orderby('id','desc')->wherein('type',['chiqim','xarajat'])->where('status',false)->get();
        $resKassa = [];
        foreach ($kassaHistory as $key => $value) {
            $resKassa[$key]['id'] = $value->id;
            $resKassa[$key]['type'] = $value->type;
            $resKassa[$key]['amount'] = $value->amount;
            $resKassa[$key]['user'] = User::find($value->user_id)->name;
            $resKassa[$key]['create_data'] = Carbon::parse($value->create_data)->format('Y-m-d h:i');
        }
        $kassaIshHaqi = KassaHistory::orderby('id','desc')->wherein('type',['ish_haqi'])->where('status',false)->get();
        $resIshHaqi = [];
        foreach ($kassaIshHaqi as $key => $value) {
            $resIshHaqi[$key]['id'] = $value->id;
            $resIshHaqi[$key]['type'] = $value->type;
            $resIshHaqi[$key]['amount'] = $value->amount;
            $resIshHaqi[$key]['hodim'] = User::find($value->teacher_id)->name;
            $resIshHaqi[$key]['meneger'] = User::find($value->user_id)->name;
            $resIshHaqi[$key]['create_data'] = Carbon::parse($value->create_data)->format('Y-m-d h:i');
        }
        return response()->json([
            'message' => 'Kassa Malumotlari',
            'kassa'    => [
                'kassa_naqt' => $kassa->kassa_naqt,
                'kassa_pedding_naqt' => $kassa->kassa_pedding_naqt,
                'kassa_pedding_card' => $kassa->kassa_pedding_card,
                'kassa_pedding_shot' => $kassa->kassa_pedding_shot,
                'teacher_pedding_pay_naqt' => $kassa->teacher_pedding_pay_naqt,
                'xarajat_pedding_naqt' => $kassa->xarajat_pedding_naqt,
            ],
            'tulovlar' => $res_pay_pedding,
            'chiqim_xarajat' => $resKassa,
            'ish_haqi' => $resIshHaqi,
            'qaytarish' => [],
            'chegirma' => [],
        ], 200);
    }

    public function success_paymart(Request $request){
        $data = $request->validate([
            'id' => ['required','integer']
        ]);
        $paymart = ChildPaymart::find($data['id']);
        if($paymart->status==true){
            return response()->json([
                'status' => false,
                'message' => 'To\'lov oldin tasdiqlangan'
            ], 401);
        }
        $paymart->status = true;
        $child = Child::find($paymart->child_id);
        $child->balans = $child->balans + $paymart->amount;
        $settinPay = SettingPaymart::first();
        $exson = $settinPay->exson_foiz;
        $exson_amount = $exson * $paymart->amount / 100;
        $balans_amount = $paymart->amount - $exson_amount;
        $kassa = Kassa::first();
        if(!$kassa){
            $kassa = Kassa::create([
                'kassa_naqt' => 0,
                'kassa_card' => 0,
                'kassa_shot' => 0,
                'kassa_pedding_naqt' => 0,
                'kassa_pedding_card' => 0,
                'kassa_pedding_shot' => 0,
                'teacher_pedding_pay_naqt' => 0,
                'xarajat_pedding_naqt' => 0,
            ]);
        }
        $balans = Balans::first();
        if(!$balans){
            $balans = Balans::create([
                'naqt' => 0,
                'card' => 0,
                'shot' => 0,
                'exson_naqt' => 0,
                'exson_card' => 0,
                'exson_shot' => 0,
            ]);
        }
        if($paymart->type == 'card'){
            $kassa->kassa_pedding_card = $kassa->kassa_pedding_card - $paymart->amount;
            $balans->card =  $balans->card + $balans_amount;
            $balans->exson_card = $balans->exson_card + $exson_amount;
        }else{
            $kassa->kassa_pedding_shot = $kassa->kassa_pedding_shot - $paymart->amount;
            $balans->shot =  $balans->shot + $balans_amount;
            $balans->exson_shot = $balans->exson_shot + $exson_amount;
        }
        $child->save();
        $paymart->save();
        $kassa->save();
        $balans->save();
        BalansHistory::create([
            'type' => $paymart->type,
            'status' => $paymart->type=='card'?"tulov_card":"tulov_shot",
            'amount' => $paymart->amount,
            'about' => "Balansga: $balans_amount, Exson uchun: $exson_amount",
            'user_id' => $paymart->user_id,
            'admin_id' => auth()->user()->id
        ]);
        return response()->json([
            'status' => true,
            'message' => 'To\'lov tasdiqlandi',
        ], 200);
    }

    public function chiqim_post(Request $request){
        $data = $request->validate([
            'type' => ['required', 'string', 'in:chiqim,xarajat'],
            'amount' => ['required','integer'],
            'about' => ['required','string'],
        ]);
        $kassa = Kassa::first();
        $mavjud = $kassa->kassa_naqt;
        if($mavjud<$data['amount']){
            return response()->json([
                'status' => false,
                'message' => "Kassada yetarli mablag' mavjud emas.",
            ], 402);
        }
        $kassa->kassa_naqt = $kassa->kassa_naqt - $data['amount'];
        if($data['type']=='chiqim'){
            $kassa->kassa_pedding_naqt = $kassa->kassa_pedding_naqt + $data['amount'];
        }else{
            $kassa->xarajat_pedding_naqt = $kassa->xarajat_pedding_naqt + $data['amount'];
        }
        $kassa->save();
        $history = KassaHistory::create([
            'type' => $data['type'],
            'amount' => $data['amount'],
            'user_id' => auth()->user()->id,
            'create_data' => date("Y-m-d h:i"),
            'status' => false,
            'about' => $data['about'],
        ]);
        return response()->json([
            'status' => true,
            'message' => "Kassadan chiqim qilindi",
            'data' => $history
        ], 200);
    }

    public function cancel_chiqim(Request $request){
        $data = $request->validate([
            'id' => ['required','integer','exists:kassa_histories,id']
        ]);
        $history = KassaHistory::find($data['id']);
        if($history->status==true){
            return response()->json([
                'status' => true,
                'message' => "Chiqim tasdiqlangan bekor qilib bo'lmaydi",
            ], 402);
        }
        $kassa = Kassa::first();
        if($history->type=='chiqim'){
            $kassa->kassa_pedding_naqt = $kassa->kassa_pedding_naqt - $history['amount'];
        }else{
            $kassa->xarajat_pedding_naqt = $kassa->xarajat_pedding_naqt - $history['amount'];
        }
        $kassa->kassa_naqt = $kassa->kassa_naqt + $history['amount'];
        $kassa->save();
        $history->delete();
        return response()->json([
            'status' => true,
            'message' => "Bekor qilindi",
        ], 200);
    }

    public function success_chiqim(Request $request){
        $data = $request->validate([
            'id' => ['required','integer','exists:kassa_histories,id']
        ]);
        $history = KassaHistory::find($data['id']);
        if($history->status==true){
            return response()->json([
                'status' => true,
                'message' => "Chiqim tasdiqlangan bekor qilib bo'lmaydi",
            ], 402);
        }
        $kassa = Kassa::first();
        $balans = Balans::first();
        $SettingPaymart = SettingPaymart::first();
        $exsonFoiz = $SettingPaymart->exson_foiz;
        $exson = $history['amount'] * $exsonFoiz / 100;
        $chiqim = $history['amount'] - $exson;
        if($history->type=='chiqim'){
            $kassa->kassa_pedding_naqt = $kassa->kassa_pedding_naqt - $history['amount'];
            $balans->naqt = $balans->naqt + $chiqim;
            $balans->exson_naqt = $balans->exson_naqt + $exson;
        }else{
            $kassa->xarajat_pedding_naqt = $kassa->xarajat_pedding_naqt - $history['amount'];
            $balans->naqt = $balans->naqt - $exson;
            $balans->exson_naqt = $balans->exson_naqt + $exson;
        }
        $balans->save();
        $kassa->save();
        $history->status = true;
        $history->admin_id = auth()->user()->id;
        $history->success_data = date("Y-m-d h:i");
        $history->save();
        $BalansHistory = BalansHistory::create([
            'type' => 'naqt',
            'status' => $history->type=='chiqim'?"kassa_chiqim":"kassa_xarajat",
            'amount' => $history['amount'],
            'about' => $history->type=='chiqim'?"Balansga: $chiqim, Exson uchun: $exson":"Kassadan Xarajat:".$history['amount']." Exson uchun: $exson",
            'user_id' => $history['user_id'],
            'admin_id' => auth()->user()->id,
        ]);
        return response()->json([
            'status' => true,
            'message' => "Tasdiqlandi",
        ], 200);
    }

    public function success_ishHaqi(Request $request){
        $data = $request->validate([
            'id' => ['required','integer','exists:kassa_histories,id']
        ]);
        $SettingPaymart = SettingPaymart::first();
        $exson_foiz = $SettingPaymart->exson_foiz;
        $KassaHistory = KassaHistory::find($data['id']);
        if($KassaHistory->status == 1){
            return response()->json([
                'status' => false,
                'message' => "Bu to'lov oldin tasdiqlangan.",
            ], 402);
        }
        $KassaHistory->admin_id = auth()->user()->id;
        $KassaHistory->success_data = date("Y-m-d h:i");
        $KassaHistory->status = true;
        $tulov = $KassaHistory->amount;
        $exson = $exson_foiz * $tulov / 100;
        $Balans = Balans::first();
        $Balans->naqt = $Balans->naqt - $exson;
        $Balans->exson_naqt = $Balans->exson_naqt + $exson;
        $Balans->save();
        $Kassa = Kassa::first();
        $Kassa->teacher_pedding_pay_naqt = $Kassa->teacher_pedding_pay_naqt - $KassaHistory['amount'];
        $Kassa->save();
        $BalansHistory = BalansHistory::create([
            'type' => 'naqt',
            'status' => 'ish_haqi_naqt',
            'amount' => $KassaHistory['amount'],
            'about' => "Kassadan tulov. Exson: $exson ".$KassaHistory['about'],
            'user_id' => $KassaHistory['user_id'],
            'admin_id' => auth()->user()->id,
        ]);
        $UserPaymart = UserPaymart::create([
            'user_id' => $KassaHistory['teacher_id'],
            'admin_id' => auth()->user()->id,
            'status' => true,
            'amount' => $KassaHistory['amount'],
            'type' => 'naqt',
            'about' => $KassaHistory['about'],
        ]);
        $KassaHistory->user_paymart_id = $UserPaymart->id;
        $KassaHistory->save();
        return response()->json([
            'status' => true,
            'message' => "Ish haqi to'lovi tasdiqlandi.",
        ], 200);
    }
    public function cancel_ishHaqi(Request $request){
        $data = $request->validate([
            'id' => ['required','integer','exists:kassa_histories,id']
        ]);
        $KassaHistory = KassaHistory::find($data['id']);
        if($KassaHistory->status == 1){
            return response()->json([
                'status' => false,
                'message' => "Bu to'lov oldin tasdiqlangan.",
            ], 402);
        }
        $Kassa = Kassa::first();
        $kassa_naqt = $Kassa->kassa_naqt;
        $teacher_pedding_pay_naqt = $Kassa->teacher_pedding_pay_naqt;
        $Kassa->kassa_naqt = $Kassa->kassa_naqt + $KassaHistory['amount'];
        $Kassa->teacher_pedding_pay_naqt = $Kassa->teacher_pedding_pay_naqt - $KassaHistory['amount'];
        $Kassa->save();
        $KassaHistory->delete();
        return response()->json([
            'status' => true,
            'message' => "Ish haqi to'lovi bekor qilindi.",
        ], 200);
    }

}
