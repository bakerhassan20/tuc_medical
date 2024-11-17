<?php
namespace App\Http\Controllers;
use DB;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Flasher\Prime\FlasherInterface;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
/**
* Display a listing of the resource.
*
* @return \Illuminate\Http\Response
*/
function __construct()
{
/* $this->middleware('permission:role-list|role-create|role-edit|role-delete', ['only' => ['index','store']]);
$this->middleware('permission:role-create', ['only' => ['create','store']]);
$this->middleware('permission:role-edit', ['only' => ['edit','update']]);
$this->middleware('permission:role-delete', ['only' => ['destroy']]); */
}
/**
* Display a listing of the resource.
*
* @return \Illuminate\Http\Response
*/
public function index(Request $request)
{
$roles = Role::orderBy('id','DESC')->paginate(5);
return view('roles.index',compact('roles'))
->with('i', ($request->input('page', 1) - 1) * 5);
}
/**
* Show the form for creating a new resource.
*
* @return \Illuminate\Http\Response
*/
public function create()
{
$permission = Permission::get();
return view('roles.create',compact('permission'));
}
/**
* Store a newly created resource in storage.
*
* @param  \Illuminate\Http\Request  $request
* @return \Illuminate\Http\Response
*/
public function store(Request $request,FlasherInterface $flasher)
{
    $this->validate($request, [
        'name' => 'required|unique:roles,name', 
        'permission' => 'required|array', 
    ]);
    $role = Role::create(['name' => $request->input('name')]);
    $permissions = Permission::whereIn('id', $request->input('permission'))->pluck('name')->toArray();
    $role->syncPermissions($permissions);
    $flasher->addSuccess('تم اضافه الصلاحيه بنجاح');
    return redirect()->route('roles.index');
}
/**
* Display the specified resource.
*
* @param  int  $id
* @return \Illuminate\Http\Response
*/
public function show($id)
{
$role = Role::find($id);
$rolePermissions = Permission::join("role_has_permissions","role_has_permissions.permission_id","=","permissions.id")
->where("role_has_permissions.role_id",$id)
->get();
return view('roles.show',compact('role','rolePermissions'));
}
/**
* Show the form for editing the specified resource.
*
* @param  int  $id
* @return \Illuminate\Http\Response
*/
public function edit($id)
{
$role = Role::find($id);
$permission = Permission::get();
$rolePermissions = DB::table("role_has_permissions")->where("role_has_permissions.role_id",$id)
->pluck('role_has_permissions.permission_id','role_has_permissions.permission_id')
->all();
return view('roles.edit',compact('role','permission','rolePermissions'));
}
/**
* Update the specified resource in storage.
*
* @param  \Illuminate\Http\Request  $request
* @param  int  $id
* @return \Illuminate\Http\Response
*/
public function update(Request $request, $id,FlasherInterface $flasher)
{
    // Validate the incoming request
    $this->validate($request, [
        'name' => 'required', // Ensure the role name is required
        'permission' => 'required|array', // Validate that permissions are passed as an array
    ]);

    $role = Role::findOrFail($id);
    $role->name = $request->input('name');
    $role->save(); 

    $permissions = Permission::whereIn('id', $request->input('permission'))->pluck('name')->toArray();
    $role->syncPermissions($permissions);

    $flasher->addInfo('تم تعديل الصلاحيه بنجاح');
    return redirect()->route('roles.index');
}
/**
* Remove the specified resource from storage.
*
* @param  int  $id
* @return \Illuminate\Http\Response
*/
public function destroy($id,FlasherInterface $flasher)
{


DB::table("roles")->where('id',$id)->delete();
$flasher->addError('تم حذف الصلاحيه بنجاح');

return redirect()->route('roles.index');
}
}
