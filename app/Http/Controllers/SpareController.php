<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Spare;
use App\Models\Department;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Flasher\Prime\FlasherInterface;

class SpareController extends Controller
{
    public function index(Request $request)
    {
        $query = Spare::query();

        if ($request->has('name') && $request->name != '') {
            $query->where('name', 'like', '%' . $request->name . '%');
        }

        if ($request->has('department_id') && $request->department_id != '' && $request->department_id != 'all') {
            $query->where('department_id', $request->department_id);
        }

        if ($request->has('doctor_name') && $request->doctor_name != '') {
            $query->where('doctor_name', 'like', '%' . $request->doctor_name . '%');
        }

        $spares = $query->paginate(10);
        $spares->appends($request->all());
        $departments = Department::all();

        return view('spares.index', compact('spares', 'departments'));
    }

    public function create()
    {
        $departments = Department::get();
        return view('spares.create', compact('departments'));
    }

    public function store(Request $request, FlasherInterface $flasher)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'department_id' => 'required|exists:departments,id',
            'quantity' => 'required|integer',
            'doctor_name' => 'required|string|max:255',
            'img' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'date' => 'required|date',
        ], [
            'name.required' => 'الاسم هو حقل مطلوب.',
            'name.string' => 'الاسم يجب أن يكون نصاً.',
            'name.max' => 'الاسم يجب ألا يزيد عن 255 حرفاً.',

            'description.string' => 'الوصف يجب أن يكون نصاً.',
            'description.max' => 'الوصف يجب ألا يزيد عن 1000 حرف.',

            'department_id.required' => 'القسم هو حقل مطلوب.',
            'department_id.exists' => 'القسم المحدد غير موجود.',

            'quantity.required' => 'الكمية هي حقل مطلوب.',
            'quantity.integer' => 'الكمية يجب أن تكون عدداً صحيحاً.',

            'doctor_name.required' => 'اسم الدكتور هو حقل مطلوب.',
            'doctor_name.string' => 'اسم الدكتور يجب أن يكون نصاً.',
            'doctor_name.max' => 'اسم الدكتور يجب ألا يزيد عن 255 حرفاً.',

            'img.image' => 'يجب أن يكون الملف صورة.',
            'img.mimes' => 'يجب أن تكون الصورة بصيغة: jpg, jpeg, أو png.',
            'img.max' => 'حجم الصورة يجب ألا يتجاوز 2 ميجابايت.',

            'date.required' => 'التاريخ هو حقل مطلوب.',
            'date.date' => 'يجب إدخال تاريخ صالح.',
        ]);


        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                $flasher->addError($error);
            }
            return redirect()->route('spares.create')->withInput();
        }

        $data = $request->all();

        // Handle single image upload
        if ($request->hasFile('img')) {
            $filename = time() . '_' . $request->file('img')->getClientOriginalName();
            $path = "spares/" . $request->name;
            $data['img'] = $request->file('img')->storeAs($path, $filename, 'public');
        }

        Spare::create($data);

        $flasher->addSuccess('تم إضافة القطعة بنجاح.');
        return redirect()->route('spares.index');
    }

    public function show(string $id, FlasherInterface $flasher)
    {
        $spare = Spare::find($id);

        if (!$spare) {
            $flasher->addError('القطعة غير موجودة.');
            return redirect()->route('spares.index');
        }

        return view('spares.show', compact('spare'));
    }

    public function edit(string $id, FlasherInterface $flasher)
    {
        $spare = Spare::find($id);

        if (!$spare) {
            $flasher->addError('القطعة غير موجودة.');
            return redirect()->route('spares.index');
        }

        $departments = Department::get();
        return view('spares.edit', compact('spare', 'departments'));
    }

    public function update(Request $request, $id, FlasherInterface $flasher)
    {
        $spare = Spare::find($id);

        if (!$spare) {
            $flasher->addError('القطعة غير موجودة.');
            return redirect()->route('spares.index');
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'department_id' => 'required|exists:departments,id',
            'quantity' => 'required|integer',
            'doctor_name' => 'required|string|max:255',
            'img' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'date' => 'required|date',
        ], [
            'name.required' => 'الاسم حقل مطلوب.',
            'name.string' => 'يجب أن يكون الاسم نصًا.',
            'name.max' => 'يجب ألا يزيد الاسم عن 255 حرفًا.',

            'description.string' => 'يجب أن يكون الوصف نصًا.',
            'description.max' => 'يجب ألا يزيد الوصف عن 1000 حرف.',

            'department_id.required' => 'القسم حقل مطلوب.',
            'department_id.exists' => 'القسم المحدد غير موجود.',

            'quantity.required' => 'الكمية حقل مطلوب.',
            'quantity.integer' => 'يجب أن تكون الكمية رقمًا صحيحًا.',

            'doctor_name.required' => 'اسم الدكتور حقل مطلوب.',
            'doctor_name.string' => 'يجب أن يكون اسم الدكتور نصًا.',
            'doctor_name.max' => 'يجب ألا يزيد اسم الدكتور عن 255 حرفًا.',

            'img.image' => 'يجب أن يكون الملف صورة.',
            'img.mimes' => 'يجب أن تكون الصورة بصيغة jpg أو jpeg أو png.',
            'img.max' => 'حجم الصورة يجب ألا يتجاوز 2 ميجابايت.',

            'date.required' => 'التاريخ حقل مطلوب.',
            'date.date' => 'يجب أن يكون التاريخ تاريخًا صالحًا.',
        ]);


        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                $flasher->addError($error);
            }
            return redirect()->route('spares.edit', ['spare' => $spare->id])->withInput();
        }

        $data = $request->all();

        // Handle image upload and delete the old image
        if ($request->hasFile('img')) {
            if ($spare->img && Storage::disk('public')->exists($spare->img)) {
                Storage::disk('public')->delete($spare->img);
            }


            $filename = time() . '_' . $request->file('img')->getClientOriginalName();
            $path = "spares/" . $request->name;
            $data['img'] = $request->file('img')->storeAs($path, $filename, 'public');
        }

        $spare->update($data);

        $flasher->addSuccess('تم تحديث القطعة بنجاح.');
        return redirect()->route('spares.index');
    }

    public function destroy(Request $request, string $id, FlasherInterface $flasher)
    {
        $spare = Spare::find($request->spare_id);

        if (!$spare) {
            $flasher->addError('القطعة غير موجودة.');
            return redirect()->route('spares.index');
        }
/*
        // Delete the image if it exists
        if (Storage::disk('public')->exists($spare->img)) {
            Storage::disk('public')->delete($spare->img);
 */
        $folderPath = "spares/" . $spare->name;
        if (\Storage::disk('public')->exists($folderPath)) {
            \Storage::disk('public')->deleteDirectory($folderPath);
        }

        $spare->delete();

        $flasher->addSuccess('تم حذف القطعة بنجاح.');
        return redirect()->route('spares.index');
    }
}
