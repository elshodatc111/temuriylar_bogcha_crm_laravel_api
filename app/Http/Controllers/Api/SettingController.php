<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SettingSms;
use App\Models\SettingPaymart;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;

class SettingController extends Controller{
    public function sms(){
        $setting = SettingSms::first();
        if(!$setting){
            $setting = SettingSms::create();
        }
        return response()->json([
            'status' => true,
            'data'   => [
                'login' => $setting['login'],
                'parol' => $setting['parol'],
                'token' => $setting['token'],
                'token_data' => $setting['token_data'],
                'create_child_status' => $setting['create_child_status'],
                'create_child_text' => $setting['create_child_text'],
                'debet_send_status' => $setting['debet_send_status'],
                'debet_send_text' => $setting['debet_send_text'],
                'paymart_status' => $setting['paymart_status'],
                'paymart_text' => $setting['paymart_text'],
            ],
        ], 200);
    }
    public function sms_update(Request $request){
        $validator = Validator::make($request->all(), [
            'login'               => ['nullable', 'string', 'max:100'],
            'parol'               => ['nullable', 'string', 'max:100'],
            'create_child_status' => ['required', 'boolean'],
            'create_child_text'   => ['required', 'string', 'min:5'],
            'debet_send_status'   => ['required', 'boolean'],
            'debet_send_text'     => ['required', 'string', 'min:5'],
            'paymart_status'      => ['required', 'boolean'],
            'paymart_text'        => ['required', 'string', 'min:5'],
        ], [
            'create_child_status.required' => "Yangi bola uchun notification statusi majburiy.",
            'create_child_text.required'   => "Yangi bola uchun sms matnini kiriting.",
            'debet_send_status.required'   => "Qarzdorlik statusi majburiy.",
            'debet_send_text.required'     => "Qarzdorlik sms matnini kiriting.",
            'paymart_status.required'      => "To'lov sms yuborish statusi majburiy.",
            'paymart_text.required'        => "To'lov sms matnini kiriting.",
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status'  => false,
                'message' => 'Validatsiya xatoliklari mavjud',
                'errors'  => $validator->errors(),
            ], 422);
        }
        $data = $validator->validated();
        $settingSms = SettingSms::first();
        if (!$settingSms) {
            $settingSms = SettingSms::create($data);
        } else {
            $settingSms->update($data);
        }
        return response()->json([
            'status' => true,
            'data'   => "SMS sozlamalari yangilandi.",
        ], 200);
    }

    public function paymart(){
        $setting = SettingPaymart::first();
        if(!$setting){
            $setting = SettingPaymart::create([
                'exson_foiz' => 0,
                'bonus_80_plus' => 0,
                'bonus_85_plus' => 0,
                'bonus_90_plus' => 0,
                'bonus_95_plus' => 0,
            ]);
        }
        return response()->json([
            'status' => true,
            'data'   => [
                'exson_foiz' => $setting['exson_foiz'],
                'bonus_80_plus' => $setting['bonus_80_plus'],
                'bonus_85_plus' => $setting['bonus_85_plus'],
                'bonus_90_plus' => $setting['bonus_90_plus'],
                'bonus_95_plus' => $setting['bonus_95_plus'],
            ],
        ], 200);
    }
    public function paymart_update(Request $request){
        $validator = Validator::make($request->all(), [
            'exson_foiz'    => ['required', 'integer', 'between:0,100'],
            'bonus_80_plus' => ['required', 'integer', 'min:0'],
            'bonus_85_plus' => ['required', 'integer', 'min:0'],
            'bonus_90_plus' => ['required', 'integer', 'min:0'],
            'bonus_95_plus' => ['required', 'integer', 'min:0'],
        ], [
            'exson_foiz.required' => "Asosiy foiz ko'rsatkichi majburiy.",
            'exson_foiz.between'  => "Foiz 0 va 100 orasida bo'lishi kerak.",
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status'  => false,
                'message' => 'Validatsiya xatoliklari mavjud',
                'errors'  => $validator->errors(),
            ], 422);
        }
        $data = $validator->validated();
        $settingPaymart = SettingPaymart::first();
        if (!$settingPaymart) {
            $settingPaymart = SettingPaymart::create($data);
        } else {
            $settingPaymart->update($data);
        }
        return response()->json([
            'status'  => true,
            'message' => "To'lov sozlamalari muvaffaqiyatli saqlandi.",
            'data'    => [
                'exson_foiz'=>$settingPaymart->exson_foiz,
                'bonus_80_plus'=>$settingPaymart->bonus_80_plus,
                'bonus_85_plus'=>$settingPaymart->bonus_85_plus,
                'bonus_90_plus'=>$settingPaymart->bonus_90_plus,
                'bonus_95_plus'=>$settingPaymart->bonus_95_plus,
            ],
        ], 200);
    }
}
