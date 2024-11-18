<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Flasher\Prime\FlasherInterface;

class DepartmentController extends Controller
{

    public function index(Request $request)
    {
        $query = Department::query();

        if ($request->has('name') && $request->name != '') {
            $query->where('name', 'like', '%' . $request->name . '%');
        }
        $departments = $query->paginate(10);
        $departments->appends($request->all());
        return view('departments.index', compact('departments'));
    }

    public function store(Request $request)
    {
        $inputs =$request->all();
        $validator = Validator::make($inputs,[
            'name' => 'required|string|max:255',
        ]);
        Department::create($inputs);
        return redirect()->route('departments.index')->with('success','تم اضافة القسم بنجاح');
    }


    public function update(Request $request, string $id, FlasherInterface $flasher)
    {

        $inputs =$request->all();
        $department = Department::findOrFail($request->department_id);

        $validator = Validator::make($inputs, [
                'name' => 'required|string|max:255',
            ], [
                'name.required' => 'يجب ادخال قسم',
                'name.max' => 'الاسم يجب أن يكون أقل من 255 حرفًا.',
            ]);

            if ($validator->fails()) {
                foreach ($validator->errors()->all() as $error) {
                    $flasher->addError($error);
                }
                return redirect()->route('departments.index')->withInput();
            }
            $department->update($inputs);
            return redirect()->route('departments.index')->with('success', 'تم تعديل القسم بنجاح');
    }


    public function destroy(Request $request, string $id, FlasherInterface $flasher)
    {
        Department::find( $request->department_id)->delete();
        $flasher->addError('تم حذف القسم بنجاح');
        return redirect()->route('departments.index');
    }
}
