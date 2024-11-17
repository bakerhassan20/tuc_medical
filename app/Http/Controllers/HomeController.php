<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Flasher\Prime\FlasherInterface;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('dashboard');
    }
    public function profile()
    {
        $roles = Role::pluck('name','name')->all();

        return view('profile.edit',compact('roles'));
    }

    public function profile_update(Request $request,FlasherInterface $flasher){

        $validator = Validator::make($request->all(), [
            'phone'=>"required",
            'name'=>"required|unique:users,name,".auth()->user()->id,
            'email'=>"required|email|unique:users,email,".auth()->user()->id,
            'roles' => 'required',
            'avatar' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',  // Image validation

            ], [
                'name.required' => 'الاسم مطلوب.',
                'name.unique' => 'الاسم موجود بالفعل.',
                'email.required' => 'البريد الإلكتروني مطلوب.',
                'email.email' => 'يرجى إدخال بريد إلكتروني صالح.',
                'email.unique' => 'البريد الإلكتروني مستخدم بالفعل.',
                'phone.required' => 'رقم الهاتف مطلوب.',
                'phone.unique' => 'رقم الهاتف موجود بالفعل.',
                'roles.required' => 'الرجاء تحديد اسم الدور.',
                'avatar.image' => 'يجب أن يكون الملف صورة.',
                'avatar.mimes' => 'الصورة يجب أن تكون من نوع jpeg, png, jpg, gif, svg.',
                'avatar.max' => 'حجم الصورة يجب ألا يتجاوز 2MB.',
            ]);


            if ($validator->fails()) {
                foreach ($validator->errors()->all() as $error) {
                    $flasher->addError($error);
                }
                return redirect()->route('profile')->withInput();
            }
            $input = $request->all();

            if ($request->hasFile('avatar')) {
                if (auth()->user()->avatar && Storage::exists('public/' . auth()->user()->avatar)) {
                    Storage::delete('public/' . auth()->user()->avatar);
                }
                $avatar = $request->file('avatar');
                $imageName = time() . '.' . $avatar->getClientOriginalExtension();
                $imagePath = $avatar->storeAs('public/image/users', $imageName);
                $input['avatar'] = 'image/users/'. $imageName;
            }

            auth()->user()->update($input);
            auth()->user()->syncRoles($request->input('roles'));

            $flasher->addInfo('تم تعديل الحساب بنجاح');
            return redirect()->route('profile');


    }

    public function update_password(Request $request,FlasherInterface $flasher){
        $validator = Validator::make($request->all(),[
            'old_password'=>"required",
            'password' => 'required|same:confirm-password',
        ], [
            'old_password.required' => 'كلمة المرور الحالية مطلوبة.',
            'password.required' => 'كلمة المرور الجديدة مطلوبه.',
            'password.same' => 'كلمة المرور وتأكيد كلمة المرور غير متطابقين.',
        ]);

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                $flasher->addError($error);
            }
            return redirect()->route('profile')->withInput();
        }

        if(Hash::check($request->old_password, auth()->user()->password)){
            auth()->user()->update([
                'password'=>Hash::make($request->password)
            ]);
           $flasher->addInfo('تم تغيير كلمة المرور بنجاح');
           return redirect()->route('profile');

        }else{
            $flasher->addError('كلمة المرور الحالية التي أدخلتها غير صحيحة');
            return redirect()->back();
        }
    }
}
