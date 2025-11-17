<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller{
    public function loginPage(){
        return view('login.login');
    }
    public function login(Request $request){
        $request->validate([
            'phone'    => 'required',
            'password' => 'required',
        ]);
        $user = User::where('phone', $request->phone)->first();
        if (!$user || !Hash::check($request->password, $user->password)) {
            return back()->with('error', 'Telefon yoki parol xato!')->withInput();
        }
        $type = $user->position->name;
        if ($type == 'admin' || $type == 'direktor') {
            Auth::login($user);
            return redirect()->route('home');
        }
        return back()->with('error', 'Tizimga kirishga sizga ruxsat berilmagan.')->withInput();
    }
    public function logout(){
        Auth::logout();
        return redirect()->route('login_page')->with('message', 'Tizimdan chiqdingiz!');
    }
}
