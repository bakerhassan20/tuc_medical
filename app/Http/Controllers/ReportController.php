<?php

namespace App\Http\Controllers;

use App\Models\Device;
use App\Models\Report;
use App\Models\Department;
use Illuminate\Http\Request;
use Flasher\Prime\FlasherInterface;
use Illuminate\Support\Facades\Validator;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $query = Report::query();

        if ($request->has('work_done') && $request->work_done != '') {
            $query->where('work_done', 'like', '%' . $request->work_done . '%');
        }

        if ($request->has('department_id') && $request->department_id != '' && $request->department_id != 'all') {
            $query->where('department_id', $request->department_id);
        }

        if ($request->has('device_id') && $request->device_id != '') {
            $query->where('device_id', $request->device_id);
        }

        $reports = $query->paginate(10);
        $reports->appends($request->all());
        $departments = Department::get();
        $devices = Device::get();
        return view('reports.index', compact('reports','departments','devices'));
    }

    public function create()
    {
        $departments = Department::get();
        $devices = Device::get();
        return view('reports.create',compact('departments','devices'));
    }

    public function store(Request $request, FlasherInterface $flasher)
    {
        $validator = Validator::make($request->all(), [
            'department_id' => 'required|exists:departments,id',
            'device_id' => 'required|exists:devices,id',
            'work_done' => 'required|string|max:255',
            'description' => 'nullable|string',
            'quantity' => 'required|integer|min:1',
        ], [
            'department_id.required' => 'حقل القسم مطلوب.',
            'department_id.exists' => 'القسم المحدد غير موجود.',
            'device_id.required' => 'حقل الجهاز مطلوب.',
            'device_id.exists' => 'الجهاز المحدد غير موجود.',
            'work_done.required' => 'حقل العمل المنجز مطلوب.',
            'work_done.string' => 'يجب أن يكون العمل المنجز نصًا.',
            'work_done.max' => 'لا يمكن أن يتجاوز العمل المنجز 255 حرفًا.',
            'description.string' => 'يجب أن يكون الوصف نصًا.',
            'quantity.required' => 'حقل الكمية مطلوب.',
            'quantity.integer' => 'يجب أن تكون الكمية رقمًا صحيحًا.',
            'quantity.min' => 'يجب أن تكون الكمية 1 على الأقل.',
        ]);


        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                $flasher->addError($error);
            }
            return redirect()->route('reports.create')->withInput();
        }

        Report::create($request->all());

        $flasher->addSuccess('تم اضافة التقرير بنجاح');
        return redirect()->route('reports.index');
    }

    public function show($id)
    {
        $report = Report::with('department','device')->findOrFail($id);
        return view('reports.show', compact('report'));
    }

    public function edit($id)
    {
        $report = Report::with('department','device')->findOrFail($id);
        $departments = Department::get();
        $devices = Device::where('department_id',$report->department_id)->get();
        return view('reports.edit', compact('report','departments','devices'));
    }

    public function update(Request $request, FlasherInterface $flasher, $id)
    {
        $validator = Validator::make($request->all(), [
            'department_id' => 'required|exists:departments,id',
            'device_id' => 'required|exists:devices,id',
            'work_done' => 'required|string|max:255',
            'description' => 'nullable|string',
            'quantity' => 'required|integer|min:1',
        ]);

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                $flasher->addError($error);
            }
            return redirect()->route('reports.edit', $id)->withInput();
        }

        $report = Report::findOrFail($id);
        $report->update($request->all());

        $flasher->addSuccess('تم تعديل التقرير بنجاح');
        return redirect()->route('reports.index');
    }

    public function destroy(Request $request, FlasherInterface $flasher)
    {
        $report = Report::findOrFail($request->report_id);

        try {
            $report->delete();
            $flasher->addError('تم حذف التقرير بنجاح');
        } catch (\Exception $e) {
            $flasher->addError('حدث خطا اثناء الحذف');
        }

        return redirect()->route('reports.index');
    }


    public function getDevicesByDepartment(Request $request)
    {
        $departmentId = $request->department_id;

        if ($departmentId) {
            $devices = Device::where('department_id', $departmentId)->get();

            return response()->json([
                'status' => 'success',
                'devices' => $devices
            ]);
        }

        return response()->json([
            'status' => 'error',
            'message' => 'القسم غير موجود'
        ], 400);
    }


}
