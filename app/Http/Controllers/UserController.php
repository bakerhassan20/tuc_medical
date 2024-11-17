<?php
namespace App\Http\Controllers;
use DB;
use Hash;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Flasher\Prime\FlasherInterface;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;


class UserController extends Controller
{

public function index(Request $request)
        {
        $data = User::orderBy('id','DESC')->paginate(5);
        return view('users.index',compact('data'))
        ->with('i', ($request->input('page', 1) - 1) * 5);
        }

        public function create()
        {

            $roles = Role::pluck('name','name')->all();
            return view('users.create',compact('roles'));

        }


        public function store(Request $request, FlasherInterface $flasher)
        {

            $validator = Validator::make($request->all(), [
                'name' => 'required|unique:users,name',
                'email' => 'required|email|unique:users,email',
                'phone' => 'required|unique:users,phone',
                'password' => 'required|same:confirm-password',
                'roles_name' => 'required',
                'avatar' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',  // Image validation
            ], [
                'name.required' => 'الاسم مطلوب.',
                'name.unique' => 'الاسم موجود بالفعل.',
                'email.required' => 'البريد الإلكتروني مطلوب.',
                'email.email' => 'يرجى إدخال بريد إلكتروني صالح.',
                'email.unique' => 'البريد الإلكتروني مستخدم بالفعل.',
                'phone.required' => 'رقم الهاتف مطلوب.',
                'phone.unique' => 'رقم الهاتف موجود بالفعل.',
                'password.required' => 'كلمة المرور مطلوبة.',
                'password.same' => 'كلمة المرور وتأكيد كلمة المرور غير متطابقين.',
                'roles_name.required' => 'الرجاء تحديد اسم الدور.',
                'avatar.required' => 'يجب اختيار صوره للمستخدم',
                'avatar.image' => 'يجب أن يكون الملف صورة.',
                'avatar.mimes' => 'الصورة يجب أن تكون من نوع jpeg, png, jpg, gif, svg.',
                'avatar.max' => 'حجم الصورة يجب ألا يتجاوز 2MB.',
            ]);


            if ($validator->fails()) {
                foreach ($validator->errors()->all() as $error) {
                    $flasher->addError($error);
                }
                return redirect()->route('users.create')->withInput();
            }


            $input = $request->all();

            if ($request->hasFile('avatar')) {

                $image = $request->file('avatar');
                $imageName = time() . '.' . $image->getClientOriginalExtension();
                $imagePath = $image->storeAs('public/image/users', $imageName);
                $input['avatar'] = 'image/users/'. $imageName;

            }


            // Hash the password
            $input['password'] = Hash::make($input['password']);

            // Create the new user
            $user = User::create($input);

            // Assign role
            $user->assignRole($request->input('roles_name'));

            // Flash success message
            $flasher->addSuccess('تم اضافه المستخدم بنجاح');

            // Redirect to users index page
            return redirect()->route('users.index');
        }



public function show($id)
        {
        $user = User::find($id);
        return view('users.show',compact('user'));
        }

public function edit($id)
        {
        $user = User::find($id);
        $roles = Role::pluck('name','name')->all();
        $userRole = $user->roles->pluck('name','name')->all();
        return view('users.edit',compact('user','roles','userRole'));
        }
        public function update(Request $request, $id, FlasherInterface $flasher)
        {

            // Validate the input
            $this->validate($request, [
                'name' => 'required|unique:users,name,' . $id,
                'email' => 'required|email|unique:users,email,' . $id,
                'phone' => 'required|unique:users,phone,' . $id,
                'password' => 'same:confirm-password',
                'roles' => 'required|array', // Ensure roles are provided as an array
                'avatar' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048', // Validate avatar upload (optional)
            ], [
                'name.required' => 'الاسم مطلوب.',
                'name.unique' => 'الاسم موجود بالفعل.',
                'email.required' => 'البريد الإلكتروني مطلوب.',
                'email.email' => 'يرجى إدخال بريد إلكتروني صالح.',
                'email.unique' => 'البريد الإلكتروني مستخدم بالفعل.',
                'phone.required' => 'رقم الهاتف مطلوب.',
                'phone.unique' => 'رقم الهاتف موجود بالفعل.',
                'password.same' => 'كلمة المرور وتأكيد كلمة المرور غير متطابقين.',
                'roles.required' => 'الرجاء تحديد الدور.',
                'roles.array' => 'الدور يجب أن يكون مصفوفة.',
                'avatar.image' => 'يجب أن يكون الملف صورة.',
                'avatar.mimes' => 'الصورة يجب أن تكون بصيغة JPG أو PNG أو GIF.',
                'avatar.max' => 'حجم الصورة يجب أن لا يتجاوز 2 ميجابايت.',
            ]);

            $user = User::findOrFail($id);
            $input = $request->all();

            if (!empty($input['password'])) {
                $input['password'] = Hash::make($input['password']);
            } else {
                unset($input['password']);
            }

            if ($request->hasFile('avatar')) {
                if ($user->avatar && Storage::exists('public/' . $user->avatar)) {
                    Storage::delete('public/' . $user->avatar);
                }
                $avatar = $request->file('avatar');
                $imageName = time() . '.' . $avatar->getClientOriginalExtension();
                $imagePath = $avatar->storeAs('public/image/users', $imageName);
                $input['avatar'] = 'image/users/'. $imageName;
            }

            $user->update($input);
            $user->syncRoles($request->input('roles'));

            $flasher->addSuccess('تم تعديل المستخدم بنجاح');
             return redirect()->route('users.index');
        }
public function destroy(Request $request,$id,FlasherInterface $flasher)
        {

        User::find( $request->user_id)->delete();
        $flasher->addError('تم حذف المستخدم بنجاح');
        return redirect()->route('users.index');
        }
}
