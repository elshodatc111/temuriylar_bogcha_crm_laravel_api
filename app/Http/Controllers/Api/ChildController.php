<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Child;
use App\Models\User;
use App\Models\ChildBalansHistory;
use App\Models\ChildRelative;
use App\Models\ChildDocument;
use App\Models\ChildPaymart;
use App\Models\Group;
use App\Models\GroupChild;
use App\Models\GroupDavomad;
use App\Models\Kassa;
use Carbon\Carbon;
use Intervention\Image\Laravel\Facades\Image;
use Illuminate\Support\Str;

class ChildController extends Controller{

    public function child_all(){
        $child = Child::orderby('id','DESC')->get();
        $res = [];
        foreach ($child as $key => $value) {
            $res[$key]['id'] = $value->id;
            $res[$key]['name'] = $value->name;
            $res[$key]['seria'] = $value->seria;
            $res[$key]['tkun'] = Carbon::parse($value->tkun)->format('Y-m-d');
            $res[$key]['status'] = $value->status;
            $res[$key]['balans'] = $value->balans;
            $res[$key]['guvohnoma'] = $value->guvohnoma;
            $res[$key]['passport'] = $value->passport;
            $res[$key]['gepatet'] = $value->gepatet;
            $res[$key]['user_id'] = User::find($value->user_id)->name;
            $res[$key]['created_at'] = Carbon::parse($value->created_at)->format('Y-m-d h:i');
        }
        return response()->json([
            'message' => 'Barcha bolalar.',
            'data'    => $res,
        ], 200);
    }

    public function child_debet(){
        $child = Child::orderby('id','DESC')->where('balans','<',0)->get();
        $res = [];
        foreach ($child as $key => $value) {
            $res[$key]['id'] = $value->id;
            $res[$key]['name'] = $value->name;
            $res[$key]['seria'] = $value->seria;
            $res[$key]['tkun'] = Carbon::parse($value->tkun)->format('Y-m-d');
            $res[$key]['status'] = $value->status;
            $res[$key]['balans'] = $value->balans;
            $res[$key]['guvohnoma'] = $value->guvohnoma;
            $res[$key]['passport'] = $value->passport;
            $res[$key]['gepatet'] = $value->gepatet;
            $res[$key]['user_id'] = User::find($value->user_id)->name;
            $res[$key]['created_at'] = Carbon::parse($value->created_at)->format('Y-m-d h:i');
        }
        return response()->json([
            'message' => 'Qarzdor bolalar.',
            'data'    => $res,
        ], 200);
    }

    public function child_end(){
        $child = Child::orderby('id','DESC')->where('status',false)->get();
        $res = [];
        foreach ($child as $key => $value) {
            $res[$key]['id'] = $value->id;
            $res[$key]['name'] = $value->name;
            $res[$key]['seria'] = $value->seria;
            $res[$key]['tkun'] = Carbon::parse($value->tkun)->format('Y-m-d');
            $res[$key]['status'] = $value->status;
            $res[$key]['balans'] = $value->balans;
            $res[$key]['guvohnoma'] = $value->guvohnoma;
            $res[$key]['passport'] = $value->passport;
            $res[$key]['gepatet'] = $value->gepatet;
            $res[$key]['user_id'] = User::find($value->user_id)->name;
            $res[$key]['created_at'] = Carbon::parse($value->created_at)->format('Y-m-d h:i');
        }
        return response()->json([
            'message' => 'Guruhsiz bolalar.',
            'data'    => $res,
        ], 200);
    }

    public function child_active(){
        $child = Child::orderby('id','DESC')->where('status',true)->get();
        $res = [];
        foreach ($child as $key => $value) {
            $res[$key]['id'] = $value->id;
            $res[$key]['name'] = $value->name;
            $res[$key]['seria'] = $value->seria;
            $res[$key]['tkun'] = Carbon::parse($value->tkun)->format('Y-m-d');
            $res[$key]['status'] = $value->status;
            $res[$key]['balans'] = $value->balans;
            $res[$key]['guvohnoma'] = $value->guvohnoma;
            $res[$key]['passport'] = $value->passport;
            $res[$key]['gepatet'] = $value->gepatet;
            $res[$key]['user_id'] = User::find($value->user_id)->name;
            $res[$key]['created_at'] = Carbon::parse($value->created_at)->format('Y-m-d h:i');
        }
        return response()->json([
            'message' => 'Guruhi mavjud bolalar.',
            'data'    => $res,
        ], 200);
    }

    public function create(Request $request){
        $data = $request->validate([
            'name'  => ['required', 'string', 'min:3', 'max:255'],
            'seria' => ['required','string','max:50','unique:children,seria',],
            'tkun'  => ['required', 'date', 'before:today'],
        ]);
        $data['status'] = false;
        $data['balans'] = 0;
        $data['guvohnoma'] = false;
        $data['passport'] = false;
        $data['gepatet'] = false;
        $data['user_id'] = auth()->id();
        $child = Child::create($data);
        return response()->json([
            'message' => 'Bola muvaffaqiyatli yaratildi.',
            'data'    => $child,
        ], 200);
    }
    protected function childAbout($id){
        $child = Child::find($id);
        return [
            'id' => $id,
            'name' => $child->name,
            'seria' => $child->seria,
            'tkun' => Carbon::parse($child->tkun)->format('Y-m-d'),
            'status' => $child->status,
            'balans' => $child->balans,
            'balans_data' => $child->balans_data,
            'guvohnoma' => $child->guvohnoma,
            'passport' => $child->passport,
            'gepatet' => $child->gepatet,
            'user_id' => User::find($child->user_id)->name,
            'registr' => Carbon::parse($child->created_at)->format('Y-m-d h:i')
        ];
    }
    protected function childGroup($id){
        $GroupChild = GroupChild::where('child_id',$id)->orderby('id','desc')->get();
        $res = [];
        foreach ($GroupChild as $key => $value) {
            $res[$key]['group_id'] = $value->group_id;
            $res[$key]['group_name'] = Group::find($value->group_id)->name;
            $res[$key]['status'] = $value->status;
            $res[$key]['start_data'] = Carbon::parse($value->start_data)->format('Y-m-d');
            $res[$key]['start_user_id'] = User::find($value->start_user_id)->name;
            $res[$key]['start_about'] = $value->group_id;
            $res[$key]['end_data'] = $value->status==false?Carbon::parse($value->end_data)->format('Y-m-d'):"";
            $res[$key]['end_user_id'] = $value->status==false?User::find($value->end_user_id)->name:"";
            $res[$key]['end_about'] = $value->status==false?$value->end_about:"";
        }
        return $res;
    }
    protected function childDavomad($id){
        $GroupDavomad = GroupDavomad::where('child_id',$id)->orderBy('id','desc')->get();
        $res = [];
        foreach ($GroupDavomad as $key => $value) {
            $res[$key]['group_id'] = $value->group_id;
            $res[$key]['group'] = Group::find($value->group_id)->name;
            $res[$key]['data'] = Carbon::parse($value->data)->format('Y-m-d');
            $res[$key]['status'] = $value->status;
            $res[$key]['tarbiyachi'] = User::find($value->user_id)->name;
        }
        return $res;
    }
    protected function oylikTulovlar($id){
        $ChildBalansHistory = ChildBalansHistory::where('child_id',$id)->orderby('id','desc')->get();
        $res = [];
        foreach ($ChildBalansHistory as $key => $value) {
            $res[$key]['id'] = $value->id;
            $res[$key]['group_id'] = Group::find($value->group_id)->name;
            $res[$key]['amount'] = $value->amount;
            $res[$key]['about'] = $value->about;
            $res[$key]['created_at'] = Carbon::parse($value->created_at)->format('Y-m-d h:i');
        }
        return $res;
    }
    public function show($id){
        return response()->json([
            'message' => 'Bola haqida.',
            'about'    => $this->childAbout($id),
            'group'    => $this->childGroup($id),
            'group_tulovlari'    => $this->oylikTulovlar($id),
            'davomad'    => $this->childDavomad($id),
        ], 200);
    }

    public function showDocument($id){
        $ChildDocument = ChildDocument::where('child_id',$id)->get();
        $res = [];
        foreach ($ChildDocument as $key => $value) {
            $res['id'] = $value->id;
            $res['type'] = $value->type;
            $res['url'] = $value->url;
            $res['user_id'] = User::find($value->user_id)->name;
            $res['created_at'] = Carbon::parse($value->created_at)->format('Y-m-d h:i');
        }
        return response()->json([
            'message' => 'Bola hujjatlari.',
            'data'    => $res,
        ], 200);
    }

    public function showDocumentDelete(Request $request){
        $data = $request->validate([
            'id' => ['required', 'integer', 'exists:child_documents,id'],
        ]);
        $ChildDocument = ChildDocument::find($data['id']);
        $type = $ChildDocument->type;
        $child_id = $ChildDocument->child_id;
        $check = count(ChildDocument::where('child_id',$child_id)->where('type',$type)->get());
        if($check==1){
            $child = Child::find($child_id);
            if($type=='passport'){
                $child->passport = 0;
            }elseif($type=='gepatet'){
                $child->gepatet = 0;
            }else{
                $child->guvohnoma = 0;
            }
            $child->save();
        }
        $ChildDocument->delete();
        return response()->json([
            'status' => true,
            'message' => 'Bola hujjati o\'chirildi.',
        ], 200);
    }

    public function showQarindosh($id){
        $ChildRelative = ChildRelative::where('child_id',$id)->get();
        $res = [];
        foreach ($ChildRelative as $key => $value) {
            $res['id'] = $value->id;
            $res['name'] = $value->name;
            $res['phone'] = $value->phone;
            $res['address'] = $value->address;
            $res['about'] = $value->about;
            $res['user_id'] = User::find($value->user_id)->name;
            $res['created_at'] = Carbon::parse($value->created_at)->format('Y-m-d h:i');
        }
        return response()->json([
            'message' => 'Bola Qarindoshlari.',
            'data'    => $res,
        ], 200);
    }

    public function showQarindoshDelete(Request $request){
        $data = $request->validate([
            'id' => ['required', 'integer', 'exists:child_relatives,id'],
        ]);
        $ChildRelative = ChildRelative::find($data['id']);
        $ChildRelative->delete();
        return response()->json([
            'status' => true,
            'message' => 'Bola qarindoshi o\'chirildi.',
        ], 200);
    }

    public function all_paymart($id){
        $paymarts = ChildPaymart::orderby('id','desc')->where('user_id',$id)->get();
        $res = [];
        foreach ($paymarts as $key => $value) {
            $res[$key]['id'] = $value->id;
            $res[$key]['child'] = Child::find($value->child_id)->name;
            $res[$key]['relative'] = ChildRelative::find($value->child_relative_id)->name;
            $res[$key]['amount'] = $value->amount;
            $res[$key]['type'] = $value->type;
            $res[$key]['status'] = $value->status;
            $res[$key]['meneger'] = User::find($value->user_id)->name;
            $res[$key]['data'] = Carbon::parse($value->created_at)->format('Y-m-d h:i');
        }
        return response()->json([
            'message' => 'Bolaning barcha to\'lovlar.',
            'data'    => $res,
        ], 200);
    }

    public function all_paymarts(){
        $paymarts = ChildPaymart::orderby('id','desc')->get();
        $res = [];
        foreach ($paymarts as $key => $value) {
            $res[$key]['id'] = $value->id;
            $res[$key]['child'] = Child::find($value->child_id)->name;
            $res[$key]['relative'] = ChildRelative::find($value->child_relative_id)->name;
            $res[$key]['amount'] = $value->amount;
            $res[$key]['type'] = $value->type;
            $res[$key]['status'] = $value->status;
            $res[$key]['meneger'] = User::find($value->user_id)->name;
            $res[$key]['data'] = Carbon::parse($value->created_at)->format('Y-m-d h:i');
        }
        return response()->json([
            'message' => 'Barcha to\'lovlar.',
            'data'    => $res,
        ], 200);
    }

    public function create_document(Request $request){
        $data = $request->validate([
            'child_id' => ['required', 'integer', 'exists:children,id'],
            'type'     => ['required', 'string', 'in:guvohnoma,passport,gepatet'],
            'file'     => ['required','file','mimes:jpg,png','max:4096',],
        ], [
            'child_id.required' => 'Bola ID majburiy.',
            'child_id.exists'   => 'Bunday bola mavjud emas.',
            'type.required'     => 'Hujjat turi majburiy.',
            'type.in'           => 'Hujjat turi noto‘g‘ri (guvohnoma, passport yoki gepatet).',
            'file.required'     => 'Fayl yuklash majburiy.',
            'file.mimes'        => 'Fayl faqat jpg, png bo‘lishi mumkin.',
            'file.max'          => 'Fayl hajmi 4MB dan katta bo‘lmasin.',
        ]);
        $file = $request->file('file');
        $extension = $file->getClientOriginalExtension();
        $fileName  = time() . '_' . Str::random(10) . '.' . $extension;
        $uploadPath = public_path('uploads/children/' . $data['child_id']);
        if (!file_exists($uploadPath)) {
            mkdir($uploadPath, 0777, true);
        }
        $fileSizeKB = $file->getSize() / 1024;
        $quality = 100;
        if ($fileSizeKB > 3000) {
            $quality = 30;
        }elseif ($fileSizeKB > 2000) {
            $quality = 40;
        }elseif ($fileSizeKB > 1000) {
            $quality = 50;
        } elseif ($fileSizeKB > 500) {
            $quality = 60;
        }
        $image = Image::read($file->getPathname());
        $image->save($uploadPath.'/'.$fileName, quality: $quality);
        $document = ChildDocument::create([
            'child_id' => $data['child_id'],
            'type'     => $data['type'],
            'url'      => 'uploads/children/' . $data['child_id'] . '/' . $fileName,
            'user_id'  => auth()->id(),
        ]);
        $child = Child::find($data['child_id']);
        if($data['type']=='guvohnoma'){
            $child->guvohnoma = true;
        }elseif($data['type']=='passport'){
            $child->passport = true;
        }else{
            $child->gepatet = true;
        }
        $child->save();
        return response()->json([
            'message' => 'Hujjat muvaffaqiyatli yuklandi.',
            'data'    => $document,
        ], 200);
    }

    public function create_paymart(Request $request){
        $data = $request->validate([
            'child_id' => ['required', 'integer', 'exists:children,id'],
            'child_relative_id' => ['required', 'integer', 'exists:child_relatives,id'],
            'amount'     => ['required', 'integer', 'min:500'],
            'type'     => ['required', 'string', 'in:naqt,card,shot'],
            'about'     => ['required', 'string'],
        ]);
        $child = Child::find($data['child_id']);
        $type = $data['type'];
        $kassa = Kassa::first();
        if(!$kassa){
            $kassa = Kassa::create();
        }
        $message = "";
        if($type=='naqt'){
            $child->balans = $child->balans + $data['amount'];
            $child->save();
            $data['status'] = true;
            $kassa->kassa_naqt = $kassa->kassa_naqt + $data['amount'];
            $message = "To'lov bola balansiga qo'shildi";
        }else{
            $data['status'] = false;
            if($type=='card'){
                $kassa->kassa_pedding_card = $kassa->kassa_pedding_card + $data['amount'];
            }else{
                $kassa->kassa_pedding_shot = $kassa->kassa_pedding_shot + $data['amount'];
            }
            $message = "To'lov tasdiqlanishi kutilmoqda. To'lov tasdiqlangach bola balansiga qo'shiladi.";
        }
        $kassa->save();
        $data['user_id'] = auth()->user()->id;
        $paymart = ChildPaymart::create($data);
        return response()->json([
            'message' => $message,
            'data'    => $paymart,
        ], 200);
    }

    public function create_qarindosh(Request $request){
        $data = $request->validate([
            'child_id' => ['required', 'integer', 'exists:children,id'],
            'name'     => ['required', 'string'],
            'phone'     => ['required', 'string'],
            'address'     => ['required', 'string'],
            'about'     => ['required', 'string'],
        ]);
        $data['user_id'] = auth()->user()->id;
        ChildRelative::create($data);
        return response()->json([
            'message' => 'Yangi qarindos saqlandi.',
            'data'    => $data,
        ], 200);
    }

}
