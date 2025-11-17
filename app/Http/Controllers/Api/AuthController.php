<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class AuthController extends Controller{

    private function normalizePhone(string $phone): string{
        return str_replace(' ', '', $phone);
    }

    public function login(Request $request){
        $data = $request->validate([
            'phone'    => ['required', 'string', 'regex:/^\+998\s?\d{2}\s?\d{3}\s?\d{2}\s?\d{2}$/'],
            'password' => ['required', 'string'],
        ]);
        $phone = $this->normalizePhone($data['phone']);
        $user = User::with('position')->whereRaw("REPLACE(phone, ' ', '') = ?", [$phone])->first();
        if (!$user || !Hash::check($data['password'], $user->password)) {
            return response()->json([
                'status'  => false,
                'message' => "Telefon raqam yoki parol noto‘g‘ri",
            ], 401);
        }
        if (!$user->status) {
            return response()->json([
                'status'  => false,
                'message' => "Siz tizimga kirishga bloklangansiz. Administrator bilan bog'laning.",
            ], 403);
        }
        $category = optional($user->position)->category;
        if (!in_array($category, ['Management', 'Education-Care'])) {
            return response()->json([
                'status'  => false,
                'message' => "Tizimga kirishga sizga ruxsat berilmagan.",
            ], 404);
        }
        $user->tokens()->delete();
        $token = $user->createToken('api-token')->plainTextToken;
        return response()->json([
            'status'  => true,
            'message' => "Muvaffaqiyatli tizimga kirdingiz",
            'token'   => $token,
            'user'    => [
                'id' => $user['id'],
                'name' => $user['name'],
                'phone' => $user['phone'],
                'status' => $user['status'],
                'position' => $user['position']['name'],
            ],
        ],200);
    }

    public function profile(Request $request){
        $user = $request->user();
        return response()->json([
            'status' => true,
            'user'   => [
                'id' => $user['id'],
                'name' => $user['name'],
                'phone' => $user['phone'],
                'status' => $user['status'],
                'address' => $user['address'],
                'tkun' => Carbon::parse($user['tkun'])->format('Y-m-d'),
                'seriya' => $user['seriya'],
                'salary' => $user['salary'],
                'position' => $user['position']['name'],
            ],
        ], 200);
    }

    public function changePassword(Request $request){
        $request->validate([
            'current_password'      => ['required', 'string'],
            'password'              => ['required', 'string', 'min:8', 'confirmed'],
        ]);
        $user = $request->user();
        if (!Hash::check($request->current_password, $user->password)) {
            return response()->json([
                'status'  => false,
                'message' => 'Joriy parol noto‘g‘ri',
            ], 422);
        }
        $user->password = Hash::make($request->password);
        $user->save();
        return response()->json([
            'status'  => true,
            'message' => 'Parol muvaffaqiyatli o‘zgartirildi',
        ],200);
    }

    public function logout(Request $request){
        $user = $request->user();
        $user->currentAccessToken()->delete();
        $user->tokens()->delete();
        return response()->json([
            'status'  => true,
            'message' => 'Muvaffaqiyatli tizimdan chiqildi',
        ],200);
    }

    public function checkToken(Request $request){
        $user = $request->user();
        if (!$user) {
            return response()->json([
                'status'  => false,
                'message' => 'Token yaroqsiz yoki tizimga kirmagansiz',
            ], 401);
        }
        return response()->json([
            'status'  => true,
            'message' => 'Token aktiv — foydalanuvchi tizimda',
        ], 200);
    }

}
