<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Engineer;
use Flasher\Prime\FlasherInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AttendanceController extends Controller
{
    public function index(Request $request)
    {
        $query = Attendance::query();

        // Filter by engineer_id
        if ($request->has('engineer_id') && $request->engineer_id != '' && $request->engineer_id != 'all') {
            $query->where('engineer_id', $request->engineer_id);
        }

        // Filter by day (if provided)
        if ($request->has('day') && $request->day != '' && $request->day != 'all') {
            $query->where('day', $request->day);
        }

        // Filter by date (if provided)
        if ($request->has('date') && $request->date != '') {
            $query->whereDate('date', $request->date);
        }

        // Paginate the results
        $attendances = $query->paginate(10);
        $attendances->appends($request->all());

        // Get the engineers for the filter
        $engineers = Engineer::all();

        return view('attendances.index', compact('attendances', 'engineers'));
    }

    public function create()
    {
        $engineers = Engineer::all();
        return view('attendances.create', compact('engineers'));
    }

    public function store(Request $request, FlasherInterface $flasher)
    {
        $validator = Validator::make($request->all(), [
            'engineer_id' => 'required|exists:engineers,id',
            'attendance_time' => 'required|date_format:H:i',
            'departure_time' => 'required|date_format:H:i',
            'break_time' => 'required|date_format:H:i',
            'day' => 'required|in:السبت,الأحد,الاثنين,الثلاثاء,الأربعاء,الخميس,الجمعة',
            'date' => 'required|date',
        ], [
            'engineer_id.required' => 'اسم المهندس مطلوب.',
            'engineer_id.exists' => 'الرقم التعريفي للمهندس غير موجود.',
            'attendance_time.required' => 'وقت الحضور مطلوب.',
            'departure_time.required' => 'وقت المغادرة مطلوب.',
            'break_time.required' => 'وقت الاستراحة مطلوب.',
            'day.required' => 'اليوم مطلوب.',
            'day.in' => 'اليوم يجب أن يكون أحد الأيام من السبت إلى الجمعة.',
            'date.required' => 'التاريخ مطلوب.',
            'date.date' => 'يرجى إدخال تاريخ صالح.',
        ]);

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                $flasher->addError($error);
            }
            return redirect()->route('attendances.create')->withInput();
        }

        Attendance::create([
            'engineer_id' => $request->input('engineer_id'),
            'attendance_time' => $request->input('attendance_time'),
            'departure_time' => $request->input('departure_time'),
            'break_time' => $request->input('break_time'),
            'day' => $request->input('day'),
            'date' => $request->input('date'),
        ]);

        $flasher->addSuccess('تم إضافة الحضور بنجاح.');
        return redirect()->route('attendances.index');
    }

    public function show(string $id)
    {
        $attendance = Attendance::with('engineer')->findOrFail($id);
        return view('attendances.show', compact('attendance'));
    }

    public function edit(string $id, FlasherInterface $flasher)
    {
        $attendance = Attendance::find($id);

        if (!$attendance) {
            $flasher->addError('السجل غير موجود.');
            return redirect()->route('attendances.index');
        }

        $engineers = Engineer::all();
        return view('attendances.edit', compact('attendance', 'engineers'));
    }

    public function update(Request $request, FlasherInterface $flasher, $id)
    {
        $validator = Validator::make($request->all(), [
            'engineer_id' => 'required|exists:engineers,id',
            'attendance_time' => 'required|date_format:H:i',
            'departure_time' => 'required|date_format:H:i',
            'break_time' => 'required|date_format:H:i',
            'day' => 'required|in:السبت,الأحد,الاثنين,الثلاثاء,الأربعاء,الخميس,الجمعة',
            'date' => 'required|date',
        ], [
            'engineer_id.required' => 'اسم المهندس مطلوب.',
            'engineer_id.exists' => 'الرقم التعريفي للمهندس غير موجود.',
            'attendance_time.required' => 'وقت الحضور مطلوب.',
            'departure_time.required' => 'وقت المغادرة مطلوب.',
            'break_time.required' => 'وقت الاستراحة مطلوب.',
            'day.required' => 'اليوم مطلوب.',
            'day.in' => 'اليوم يجب أن يكون أحد الأيام من السبت إلى الجمعة.',
            'date.required' => 'التاريخ مطلوب.',
            'date.date' => 'يرجى إدخال تاريخ صالح.',
        ]);

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                $flasher->addError($error);
            }
            return redirect()->route('attendances.edit', $id)->withInput();
        }

        // Update the attendance record
        $attendance = Attendance::findOrFail($id);
        $attendance->update([
            'engineer_id' => $request->input('engineer_id'),
            'attendance_time' => $request->input('attendance_time'),
            'departure_time' => $request->input('departure_time'),
            'break_time' => $request->input('break_time'),
            'day' => $request->input('day'),
            'date' => $request->input('date'),
        ]);

        $flasher->addSuccess('تم تحديث الحضور بنجاح.');
        return redirect()->route('attendances.index');
    }

    public function destroy(Request $request, FlasherInterface $flasher)
    {
        $attendance = Attendance::findOrFail($request->attendance_id);

        try {
            $attendance->delete();
            $flasher->addError('تم حذف الحضور بنجاح.');
        } catch (\Exception $e) {
            $flasher->addError('حدث خطأ أثناء حذف الحضور.');
        }

        return redirect()->route('attendances.index');
    }
}
