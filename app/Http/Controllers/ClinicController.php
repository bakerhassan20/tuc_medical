<?php

namespace App\Http\Controllers;

use App\Models\Clinic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ClinicController extends Controller
{

    public function index(Request $request)
    {
        $query = Clinic::query();

        if ($request->has('status') && $request->status != '' && $request->status != 'all') {
            $query->where('status', $request->status);
        }

        $clinics = $query->paginate(10);
        $clinics->appends($request->all());

        return view('clinics.index', compact('clinics'));
    }


    public function create()
    {
        return view('clinics.create');
    }


    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'chair' => 'required|string|max:255',
            'clinic_name' => 'required|string|max:255',
            'floor' => 'required|integer',
            'status' => 'required|in:يعمل,قيد الاصلاح,لا يعمل',
            'date' => 'required|date',
        ], [
            'chair.required' => 'حقل الكرسي مطلوب.',
            'chair.string' => 'يجب أن يكون حقل الكرسي نصًا.',
            'chair.max' => 'حقل الكرسي لا يجب أن يتجاوز 255 حرفًا.',

            'clinic_name.required' => 'حقل اسم العيادة مطلوب.',
            'clinic_name.string' => 'يجب أن يكون حقل اسم العيادة نصًا.',
            'clinic_name.max' => 'اسم العيادة لا يجب أن يتجاوز 255 حرفًا.',

            'floor.required' => 'حقل الطابق مطلوب.',
            'floor.integer' => 'يجب أن يكون حقل الطابق رقمًا صحيحًا.',

            'status.required' => 'حقل الحالة مطلوب.',
            'status.in' => 'قيمة الحالة غير صحيحة. يجب أن تكون: يعمل، قيد الإصلاح، أو لا يعمل.',

            'date.required' => 'حقل التاريخ مطلوب.',
            'date.date' => 'يجب أن يكون حقل التاريخ تاريخًا صحيحًا.',

        ]);


        if ($validator->fails()) {
            return redirect()->route('clinics.create')->withErrors($validator)->withInput();
        }

        Clinic::create($request->all());

        return redirect()->route('clinics.index')->with('success', 'تم إضافة العيادة بنجاح.');
    }

    public function show($id)
    {
        $clinic = Clinic::findOrFail($id);
        return view('clinics.show', compact('clinic'));
    }


    public function edit($id)
    {
        $clinic = Clinic::findOrFail($id);
        return view('clinics.edit', compact('clinic'));
    }


    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'chair' => 'required|string|max:255',
            'clinic_name' => 'required|string|max:255',
            'floor' => 'required|integer',
            'status' => 'required|in:يعمل,قيد الاصلاح,لا يعمل',
            'date' => 'required|date',
        ], [
            'chair.required' => 'حقل الكرسي مطلوب.',
            'chair.string' => 'يجب أن يكون حقل الكرسي نصًا.',
            'chair.max' => 'حقل الكرسي لا يجب أن يتجاوز 255 حرفًا.',

            'clinic_name.required' => 'حقل اسم العيادة مطلوب.',
            'clinic_name.string' => 'يجب أن يكون حقل اسم العيادة نصًا.',
            'clinic_name.max' => 'اسم العيادة لا يجب أن يتجاوز 255 حرفًا.',

            'floor.required' => 'حقل الطابق مطلوب.',
            'floor.integer' => 'يجب أن يكون حقل الطابق رقمًا صحيحًا.',

            'status.required' => 'حقل الحالة مطلوب.',
            'status.in' => 'قيمة الحالة غير صحيحة. يجب أن تكون: يعمل، قيد الإصلاح، أو لا يعمل.',

            'date.required' => 'حقل التاريخ مطلوب.',
            'date.date' => 'يجب أن يكون حقل التاريخ تاريخًا صحيحًا.',
        ]);


        if ($validator->fails()) {
            return redirect()->route('clinics.edit', $id)->withErrors($validator)->withInput();
        }

        $clinic = Clinic::findOrFail($id);
        $clinic->update($request->all());

        return redirect()->route('clinics.index')->with('success', 'تم تحديث العيادة بنجاح.');
    }


    public function destroy(Request $request)
    {
        $clinic = Clinic::findOrFail($request->clinic_id);

        try {
            $clinic->delete();
            return redirect()->route('clinics.index')->with('success', 'تم حذف العيادة بنجاح.');
        } catch (\Exception $e) {
            return redirect()->route('clinics.index')->with('error', 'حدث خطأ أثناء الحذف.');
        }
    }
}
