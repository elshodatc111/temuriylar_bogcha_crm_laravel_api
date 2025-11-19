<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Child;
use App\Models\User;
use App\Models\Rooms;
use App\Models\Group;
use App\Models\Position;
use App\Models\GroupTarbiyachi;
use App\Models\GroupChild;
use App\Models\GroupDavomad;
use App\Models\UserPaymart;
use App\Models\BalansHistory;
use App\Models\SettingPaymart;
use Carbon\Carbon;

class GroupsController extends Controller{

    protected function calculateAge($birthDate){
        return Carbon::parse($birthDate)->age;
    }

    public function indexAktive(){
        $Group = Group::where('status',1)->get();
        $res = [];
        foreach ($Group as $key => $value) {
            $res[$key]['id'] = $value->id;
            $res[$key]['name'] = $value->name;
            $res[$key]['room'] = Rooms::find($value->room_id)->name;
            $res[$key]['price'] = $value->price;
            $res[$key]['status'] = $value->status;
            $res[$key]['user'] = User::find($value->user_id)->name;
            $res[$key]['created_at'] = Carbon::parse($value->created_at)->format('Y-m-d h:i');
        }
        return response()->json([
            'status' => true,
            'message' => "Aktiv guruhlar",
            'data' => $res,
        ], 200);
    }

    public function indexEnd(){
        $Group = Group::where('status',0)->get();
        $res = [];
        foreach ($Group as $key => $value) {
            $res[$key]['id'] = $value->id;
            $res[$key]['name'] = $value->name;
            $res[$key]['room'] = Rooms::find($value->room_id)->name;
            $res[$key]['price'] = $value->price;
            $res[$key]['status'] = $value->status;
            $res[$key]['user'] = User::find($value->user_id)->name;
            $res[$key]['created_at'] = Carbon::parse($value->created_at)->format('Y-m-d h:i');
            $res[$key]['end_at'] = Carbon::parse($value->updated_at)->format('Y-m-d h:i');
        }
        return response()->json([
            'status' => true,
            'message' => "Yakunlangan guruhlar",
            'data' => $res,
        ], 200);
    }
    protected function groupAbout($id){
        $group = Group::find($id);
        $active_child = count(GroupChild::where('group_id',$id)->where('status',true)->get());
        $active_end = count(GroupChild::where('group_id',$id)->where('status',false)->get());
        $child = GroupChild::where('group_id',$id)->where('status',true)->get();
        $debet = 0;
        $debet_count = 0;
        foreach ($child as $key => $value) {
            $chil_item = Child::find($value->child_id);
            if($chil_item->balans<0){
                $debet_count = $debet_count + 1;
                $debet = $debet + $chil_item['balans'];
            }
        }
        $tarbiyachi_count = count(GroupTarbiyachi::where('group_id',$id)->where('status',true)->get());
        return [
            'group_id' => $group->id,
            'group_name' => $group->name,
            'group_room' => Rooms::find($group->room_id)->name,
            'group_price' => $group->price,
            'active_child' => $active_child,
            'end_child' => $active_end,
            'group_debet_count' => $debet_count,
            'group_debet' => $debet,
            'group_tarbiyachilar' => $tarbiyachi_count,
            'group_create' => Carbon::parse($group->created_at)->format('Y-m-d h:i'),
            'group_create_user' => User::find($group->user_id)->name,
        ];
    }
    public function show($id){
        return response()->json([
            'status' => true,
            'message' => "Guruh haqida",
            'group' => $this->groupAbout($id),
        ], 200);
    }

    public function getRoom(){
        $rooms = Rooms::where('status',1)->get();
        $res = [];
        $i = 0;
        foreach ($rooms as $value) {
            $Group = Group::where('room_id',$value->id)->where('status',1)->first();
            if(!$Group){
                $res[$i]['id'] = $value->id;
                $res[$i]['name'] = $value->name;
                $res[$i]['size'] = $value->size;
                $i++;
            }
        }
        return response()->json([
            'status' => true,
            'message' => "Guruh biriktirilmagan xonalar",
            'data' => $res,
        ], 200);
    }

    public function create(Request $request){
        $data = $request->validate([
            'room_id' => ['required','integer','exists:rooms,id'],
            'name' => ['required','string'],
            'price' => ['required','integer']
        ]);
        $Group = Group::where('room_id',$data['room_id'])->where('status',1)->first();
        if($Group){
            return response()->json([
                'status' => false,
                'message' => "Bu xona band.",
            ], 402);
        }
        $group = Group::create([
            'name' => $data['name'],
            'room_id' => $data['room_id'],
            'price' => $data['price'],
            'status' => true,
            'user_id' => auth()->user()->id,
        ]);
        return response()->json([
            'status' => true,
            'message' => "Yangi guruh ochildi",
            'data' => $group,
        ], 200);
    }

    public function showGroup($id){
        $value = Group::find($id);
        $res = [];
        $res['id'] = $value->id;
        $res['name'] = $value->name;
        $res['room_id'] = $value->room_id;
        $res['room'] = Rooms::find($value->room_id)->name;
        $res['price'] = $value->price;
        $res['status'] = $value->status;
        $res['created_at'] = Carbon::parse($value->created_at)->format('Y-m-d h:i');
        $rooms = Rooms::where('status',1)->get();
        $room = [];
        $i = 0;
        foreach ($rooms as $value) {
            $Group = Group::where('room_id',$value->id)->where('status',1)->first();
            if(!$Group){
                $room[$i]['id'] = $value->id;
                $room[$i]['name'] = $value->name;
                $room[$i]['size'] = $value->size;
                $i++;
            }
        }
        return response()->json([
            'status' => true,
            'message' => "Guruhni yangilash uchun",
            'data' => $res,
            'room' => $room,
        ], 200);
    }

    public function update(Request $request){
        $data = $request->validate([
            'id' => ['required','integer','exists:groups,id'],
            'room_id' => ['required','integer','exists:rooms,id'],
            'name' => ['required','string'],
            'price' => ['required','integer']
        ]);
        $Check = Group::where('room_id',$data['room_id'])->where('id','!=',$data['id'])->where('status',1)->first();
        if($Check){
            return response()->json([
                'status' => false,
                'message' => "Tanlangan xona band.",
            ], 402);
        }
        $Group = Group::find($data['id']);
        $Group->name = $data['name'];
        $Group->room_id = $data['room_id'];
        $Group->price = $data['price'];
        $Group->save();
        return response()->json([
            'status' => true,
            'message' => "Guruh malumotlari yangilandi",
            'data' => $Group,
        ], 200);
    }

    public function getNewHodim(){
        $users = User::whereHas('position', function ($q) {$q->where('category', 'Education-Care');})->where('status', true)->get();
        $res = [];
        foreach ($users as $key => $value) {
            $res[$key]['id'] = $value->id;
            $res[$key]['name'] = $value->name;
            $res[$key]['position'] = Position::find($value->position_id)->name;
            $res[$key]['group_count'] = count(GroupTarbiyachi::where('user_id',$value->id)->where('status',true)->get());
        }
        return response()->json([
            'status' => true,
            'message' => "Barcha aktiv tarbiyachilar",
            'data' => $res,
        ], 200);
    }

    public function createHodim(Request $request){
        $data = $request->validate([
            'user_id' => ['required','integer','exists:users,id'],
            'group_id' => ['required','integer','exists:groups,id'],
            'about' => ['required','string'],
        ]);
        $GroupTarbiyachi = GroupTarbiyachi::where('user_id',$data['user_id'])->where('group_id',$data['group_id'])->where('status',true)->first();
        if($GroupTarbiyachi){
            return response()->json([
                'status' => false,
                'message' => "Bu tarbiyachi guruhda aktiv.",
            ], 402);
        }
        $res = GroupTarbiyachi::create([
            'user_id' => $data['user_id'],
            'group_id' => $data['group_id'],
            'status' => true,
            'start_data' => date("Y-m-d"),
            'start_user_id' => auth()->user()->id,
            'start_about' => $data['about'],
        ]);
        return response()->json([
            'status' => true,
            'message' => "Guruhga yangi tarbiyachi qo'shildi",
            'data' => $res,
        ], 200);
    }

    public function getAktiveHodim($id){
        $GroupTarbiyachi = GroupTarbiyachi::where('group_id',$id)->where('status',true)->get();
        $res = [];
        foreach ($GroupTarbiyachi as $key => $value) {
            $res[$key]['id'] = $value->user_id;
            $res[$key]['name'] = User::find($value->user_id)->name;
            $res[$key]['start_data'] = Carbon::parse($value->start_data)->format('Y-m-d');
            $res[$key]['start_about'] = $value->start_about;
        }
        return response()->json([
            'status' => true,
            'message' => "Guruhdagi tarbiyachilar",
            'data' => $res,
        ], 200);
    }

    public function deleteHodim(Request $request){
        $data = $request->validate([
            'user_id' => ['required','integer','exists:group_tarbiyachis,user_id'],
            'group_id' => ['required','integer','exists:group_tarbiyachis,group_id'],
            'end_about' => ['required','string'],
        ]);
        $GroupTarbiyachi = GroupTarbiyachi::where('group_id',$data['group_id'])->where('user_id',$data['user_id'])->where('status',true)->first();
        if(!$GroupTarbiyachi){
            return response()->json([
                'status' => false,
                'message' => "Bu tarbiyachi guruhda aktiv emas.",
            ], 402);
        }
        $GroupTarbiyachi->end_about = $data['end_about'];
        $GroupTarbiyachi->end_data = date("Y-m-d");
        $GroupTarbiyachi->end_user_id = auth()->user()->id;
        $GroupTarbiyachi->status = false;
        $GroupTarbiyachi->save();
        return response()->json([
            'status' => true,
            'message' => "Guruh tarbiyachisi guruhdan o'chirildi",
            'data' => $GroupTarbiyachi,
        ], 200);
    }

    public function getNewChild(){
        $child = Child::where('status',false)->get();
        $res = [];
        foreach ($child as $key => $value) {
            $res[$key]['id'] = $value->id;
            $res[$key]['name'] = $value->name;
            $res[$key]['tkun'] = Carbon::parse($value->thun)->format('Y-m-d');
            $res[$key]['yoshi'] = $this->calculateAge($value->tkun);
            $res[$key]['registr'] = Carbon::parse($value->created_at)->format('Y-m-d h:i');
        }
        return response()->json([
            'status' => true,
            'message' => "Guruhga qo'shilmagan bolalar.",
            'data' => $res,
        ], 200);
    }

    public function createChild(Request $request){
        $data = $request->validate([
            'child_id' => ['required','integer','exists:children,id'],
            'group_id' => ['required','integer','exists:groups,id'],
            'start_about' => ['required','string'],
        ]);
        $GroupChild1 = GroupChild::where('child_id',$data['child_id'])->where('group_id',$data['group_id'])->where('status',true)->first();
        if($GroupChild1){
            return response()->json([
                'status' => false,
                'message' => "Bu bola guruhda aktiv.",
            ], 402);
        }
        $GroupChild2 = GroupChild::where('child_id',$data['child_id'])->where('status',true)->first();
        if($GroupChild2){
            return response()->json([
                'status' => false,
                'message' => "Bu bola boshqa guruhda aktiv.",
            ], 402);
        }
        $GroupChild = GroupChild::create([
            'child_id' => $data['child_id'],
            'group_id' => $data['group_id'],
            'status' => true,
            'start_data' => date("Y-m-d"),
            'start_user_id' => auth()->user()->id,
            'start_about' => $data['start_about'],
        ]);
        $child = Child::find($data['child_id']);
        $child->status = true;
        $child->save();
        return response()->json([
            'status' => true,
            'message' => "Guruhga yangi bola qo'shildi",
            'data' => $GroupChild,
        ], 200);
    }

    public function activeChild($id){
        $group_id = $id;
        $GroupChild = GroupChild::where('status',true)->where('group_id',$group_id)->get();
        $res = [];
        foreach ($GroupChild as $key => $value) {
            $res[$key]['group_id'] = $value->group_id;
            $res[$key]['group'] = Group::find($value->group_id)->name;
            $res[$key]['child_id'] = $value->child_id;
            $res[$key]['child'] = Child::find($value->child_id)->name;
            $res[$key]['start_data'] = Carbon::parse($value->start_data)->format('Y-m-d');
            $res[$key]['child_balans'] = Child::find($value->child_id)->balans;
            $res[$key]['group_id'] = $value->group_id;
            $res[$key]['group_id'] = $value->group_id;
        }
        return response()->json([
            'status' => true,
            'message' => "Guruhga yangi bola qo'shildi",
            'data' => $res,
        ], 200);
    }

    public function deleteChild(Request $request){
        $data = $request->validate([
            'child_id' => ['required','integer','exists:children,id'],
            'group_id' => ['required','integer','exists:groups,id'],
            'end_about' => ['required','string'],
        ]);
        $GroupChild1 = GroupChild::where('child_id',$data['child_id'])->where('group_id',$data['group_id'])->where('status',true)->first();
        if(!$GroupChild1){
            return response()->json([
                'status' => false,
                'message' => "Bu bola guruhda aktiv emas",
            ], 402);
        }
        $GroupChild1->end_data =  date("Y-m-d");
        $GroupChild1->end_user_id =  auth()->user()->id;
        $GroupChild1->end_about =  $data['end_about'];
        $GroupChild1->status =  false;
        $GroupChild1->save();
        return response()->json([
            'status' => true,
            'message' => "Bola guruhdan o'chirildi",
            'data' => $GroupChild1,
        ], 200);
    }

    public function createDavomat(Request $request){
        $data = $request->validate([
            'group_id' => ['required','exists:groups,id'],
            'attendance' => ['required','array','min:1'],
            'attendance.*.child_id' => ['required','exists:children,id'],
            'attendance.*.status' => ['required','in:keldi,kelmadi,kechikdi,kasal,sababli'],
        ]);
        foreach ($data['attendance'] as $item) {
            $GroupChild = GroupChild::where('child_id',$item['child_id'])->where('group_id',$data['group_id'])->where('status',true)->first();
            if($GroupChild){
                GroupDavomad::updateOrCreate([
                    'group_id' => $data['group_id'],
                    'child_id' => $item['child_id'],
                    'data'     => date("Y-m-d"),
                ],[
                    'status'     => $item['status'],
                    'user_id'    => auth()->user()->id,
                ]);
            }
        }
        return response()->json([
            'status' => true,
            'message' => 'Davomad saqlandi',
        ], 200);
    }

}
