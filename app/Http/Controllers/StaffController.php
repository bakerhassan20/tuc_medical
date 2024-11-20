<?php

namespace App\Http\Controllers;

use App\Models\Staff;
use App\Models\Engineer;
use App\Models\Department;
use Illuminate\Http\Request;
use Flasher\Prime\FlasherInterface;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class StaffController extends Controller
{
    public function index(Request $request)
    {
        $query = Staff::query();

        if ($request->has('engineer_id') && $request->engineer_id != '' && $request->engineer_id != 'all') {
            $query->where('engineer_id', $request->engineer_id);
        }

        if ($request->has('department_id') && $request->department_id != '' && $request->department_id != 'all') {
            $query->where('department_id', $request->department_id);
        }

        if ($request->has('college_id') && $request->college_id != '' && $request->college_id != 'all') {
            $query->where('college_id', $request->college_id);
        }

        $staff = $query->paginate(10);
        $staff->appends($request->all());
        $departments = Department::where('type','قسم')->get();
        $colleges = Department::where('type','كلية')->get();
        $engineers = Engineer::all();


        return view('staff.index', compact('staff', 'departments','colleges','engineers'));
    }

    public function create()
    {
        $engineers = Engineer::all();
        $departments = Department::where('type','قسم')->get();
        $colleges = Department::where('type','كلية')->get();
        return view('staff.create', compact('departments', 'colleges','engineers'));
    }

    public function store(Request $request, FlasherInterface $flasher)
    {
        $validator = Validator::make($request->all(), [
            'engineer_id' => 'required|integer|exists:engineers,id',
            'college_id' => 'required|exists:departments,id',
            'department_id' => 'required|exists:departments,id',
            'date' => 'required|date',
            'img' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ], [
            'engineer_id.required' => 'حقل مهندس مطلوب.',
            'college_id.required' => 'حقل كلية مطلوب.',
            'department_id.required' => 'حقل قسم مطلوب.',
            'date.required' => 'حقل تاريخ مطلوب.',
            'img.image' => 'يجب أن يكون الملف صورة.',
            'img.mimes' => 'يجب أن تكون الصورة بصيغة jpg, jpeg أو png.',
            'img.max' => 'يجب ألا يتجاوز حجم الصورة 2 ميجابايت.',
        ]);

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                $flasher->addError($error);
            }
            return redirect()->route('staff.create')->withInput();
        }

        $data = $request->all();

        // Handle image upload
        if ($request->hasFile('img')) {
            $filename = time() . '_' . $request->file('img')->getClientOriginalName();
            $path = "staff";
            $data['img'] = $request->file('img')->storeAs($path, $filename, 'public');
        }

        Staff::create($data);

        $flasher->addSuccess('تم إضافة الموظف بنجاح.');
        return redirect()->route('staff.index');
    }

    public function show(string $id, FlasherInterface $flasher)
    {
        $staff = Staff::find($id);

        if (!$staff) {
            $flasher->addError('الموظف غير موجود.');
            return redirect()->route('staff.index');
        }

        return view('staff.show', compact('staff'));
    }

    public function edit(string $id, FlasherInterface $flasher)
    {
        $staff = Staff::find($id);

        if (!$staff) {
            $flasher->addError('الموظف غير موجود.');
            return redirect()->route('staff.index');
        }

        $departments = Department::where('type','قسم')->get();
        $colleges = Department::where('type','كلية')->get();
        $engineers = Engineer::all();

        return view('staff.edit', compact('staff', 'departments', 'colleges','engineers'));
    }

    public function update(Request $request, $id, FlasherInterface $flasher)
    {
        $staff = Staff::find($id);

        if (!$staff) {
            $flasher->addError('الموظف غير موجود.');
            return redirect()->route('staff.index');
        }

        $validator = Validator::make($request->all(), [
            'engineer_id' => 'required|integer|exists:engineers,id',
            'college_id' => 'required|exists:departments,id',
            'department_id' => 'required|exists:departments,id',
            'date' => 'required|date',
            'img' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ], [
            'engineer_id.required' => 'حقل مهندس مطلوب.',
            'college_id.required' => 'حقل كلية مطلوب.',
            'department_id.required' => 'حقل قسم مطلوب.',
            'date.required' => 'حقل تاريخ مطلوب.',
            'img.image' => 'يجب أن يكون الملف صورة.',
            'img.mimes' => 'يجب أن تكون الصورة بصيغة jpg, jpeg أو png.',
            'img.max' => 'يجب ألا يتجاوز حجم الصورة 2 ميجابايت.',
        ]);

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                $flasher->addError($error);
            }
            return redirect()->route('staff.edit', ['staff' => $staff->id])->withInput();
        }

        $data = $request->all();

        // Handle image upload and delete old image
        if ($request->hasFile('img')) {
            if ($staff->img && Storage::disk('public')->exists($staff->img)) {
                Storage::disk('public')->delete($staff->img);
            }

            $filename = time() . '_' . $request->file('img')->getClientOriginalName();
            $path = "staff";
            $data['img'] = $request->file('img')->storeAs($path, $filename, 'public');
        }

        $staff->update($data);

        $flasher->addSuccess('تم تحديث الموظف بنجاح.');
        return redirect()->route('staff.index');
    }

    public function destroy(Request $request, string $id, FlasherInterface $flasher)
    {
        $staff = Staff::find($request->staff_id);

        if (!$staff) {
            $flasher->addError('الموظف غير موجود.');
            return redirect()->route('staff.index');
        }

        // Delete the image if it exists
        if (Storage::disk('public')->exists($staff->img)) {
            Storage::disk('public')->delete($staff->img);
        }

        $staff->delete();

        $flasher->addSuccess('تم حذف الموظف بنجاح.');
        return redirect()->route('staff.index');
    }
}
