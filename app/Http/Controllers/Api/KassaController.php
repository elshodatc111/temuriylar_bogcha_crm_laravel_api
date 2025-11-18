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
use App\Models\Balans;
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
            'pedding_paymart' => $res_pay_pedding,
            'pedding_chiqim' => [],
            'pedding_xarajat' => [],
            'pedding_ish_haqi' => [],
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
        return response()->json([
            'status' => true,
            'message' => 'To\'lov tasdiqlandi',
        ], 200);
    }

    public function chiqim_post(Request $request){

    }

    public function success_chiqim(Request $request){

    }


}
