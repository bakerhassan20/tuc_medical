<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Engineer;
use App\Models\Department;
use Illuminate\Http\Request;
use Flasher\Prime\FlasherInterface;
use Illuminate\Support\Facades\Validator;

class TaskController extends Controller
{
    public function index(Request $request)
{
    $query = Task::query();

    // Replace the filter for name with engineer_id
    if ($request->has('engineer_id') && $request->engineer_id != ''&& $request->engineer_id != 'all') {
        $query->where('engineer_id', $request->engineer_id);
    }

    // Existing filters
    if ($request->has('department_id') && $request->department_id != '' && $request->department_id != 'all') {
        $query->where('department_id', $request->department_id);
    }

    if ($request->has('priority') && $request->priority != '' && $request->priority != 'all') {
        $query->where('priority', $request->priority);
    }

    if ($request->has('status') && $request->status != '' && $request->status != 'all') {
        $query->where('status', $request->status);
    }

    $tasks = $query->paginate(10);
    $tasks->appends($request->all());
    $departments = Department::where('type','قسم')->get();
    $engineers = Engineer::all();

    return view('tasks.index', compact('tasks', 'departments','engineers'));
}




    public function create()
    {
        $departments = Department::where('type','قسم')->get();
        $engineers = Engineer::get();
        return view('tasks.create',compact('departments','engineers'));

    }



    public function store(Request $request, FlasherInterface $flasher)
    {
        $validator = Validator::make($request->all(), [
            'engineer_id' => 'required|exists:engineers,id', // Validate engineer_id
            'department_id' => 'required|exists:departments,id',
            'errands' => 'required|string|max:1000',
            'status' => 'required|in:مكتملة,غير مكتملة,قيد العمل',
            'priority' => 'required|in:عالية,متوسطة,منخفضة',
            'date' => 'required|date',
        ], [
            'engineer_id.required' => ' اسم المهندس مطلوب.',
            'engineer_id.exists' => '  اسم المهندس غير موجود.',

            'department_id.required' => 'القسم مطلوب.',
            'department_id.exists' => 'القسم المحدد غير موجود.',

            'errands.required' => 'المهام مطلوبة.',
            'errands.string' => 'المهام يجب أن تكون نصًا.',
            'errands.max' => 'المهام يجب أن تكون أقل من 1000 حرف.',

            'status.required' => 'الحالة مطلوبة.',
            'status.in' => 'الحالة يجب أن تكون مكتملة، غير مكتملة، أو قيد العمل.',

            'priority.required' => 'الأولوية مطلوبة.',
            'priority.in' => 'الأولوية يجب أن تكون عالية، متوسطة، أو منخفضة.',

            'date.required' => 'التاريخ مطلوب.',
            'date.date' => 'يرجى إدخال تاريخ صالح.',
        ]);

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                $flasher->addError($error);
            }
            return redirect()->route('tasks.create')->withInput();
        }

        Task::create([
            'engineer_id' => $request->input('engineer_id'),
            'department_id' => $request->input('department_id'),
            'errands' => $request->input('errands'),
            'status' => $request->input('status'),
            'priority' => $request->input('priority'),
            'date' => $request->input('date'),
        ]);

        $flasher->addSuccess('تم إنشاء المهمة بنجاح.');
        return redirect()->route('tasks.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id, FlasherInterface $flasher)
    {
        $task = Task::with('department','engineer')->findOrFail($id);
        return view('tasks.show', compact('task'));
    }



    public function edit(string $id, FlasherInterface $flasher)
    {
        $task = Task::find($id);

        if (!$task) {
            $flasher->addError('المهام غير موجودة.');
            return redirect()->route('tasks.index');
        }

        $departments = Department::where('type','قسم')->get();
        $engineers = Engineer::all(); // Assuming you have an Engineer model
        return view('tasks.edit', compact('departments', 'engineers', 'task'));
    }




    public function update(Request $request, FlasherInterface $flasher, $id)
    {
        $validator = Validator::make($request->all(), [
            'engineer_id' => 'required|exists:engineers,id', // Validate engineer_id
            'department_id' => 'required|exists:departments,id',
            'errands' => 'required|string|max:1000',
            'status' => 'required|in:مكتملة,غير مكتملة,قيد العمل',
            'priority' => 'required|in:عالية,متوسطة,منخفضة',
            'date' => 'required|date',
        ], [
            'engineer_id.required' => 'الرقم التعريفي للمهندس مطلوب.',
            'engineer_id.exists' => 'الرقم التعريفي للمهندس غير موجود.',

            'department_id.required' => 'القسم مطلوب.',
            'department_id.exists' => 'القسم المحدد غير موجود.',

            'errands.required' => 'المهام مطلوبة.',
            'errands.string' => 'المهام يجب أن تكون نصًا.',
            'errands.max' => 'المهام يجب أن تكون أقل من 1000 حرف.',

            'status.required' => 'الحالة مطلوبة.',
            'status.in' => 'الحالة يجب أن تكون مكتملة، غير مكتملة، أو قيد العمل.',

            'priority.required' => 'الأولوية مطلوبة.',
            'priority.in' => 'الأولوية يجب أن تكون عالية، متوسطة، أو منخفضة.',

            'date.required' => 'التاريخ مطلوب.',
            'date.date' => 'يرجى إدخال تاريخ صالح.',
        ]);

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                $flasher->addError($error);
            }
            return redirect()->route('tasks.edit', $id)->withInput();
        }

        // Update task with engineer_id
        $task = Task::findOrFail($id);
        $task->update([
            'engineer_id' => $request->input('engineer_id'),
            'department_id' => $request->input('department_id'),
            'errands' => $request->input('errands'),
            'status' => $request->input('status'),
            'priority' => $request->input('priority'),
            'date' => $request->input('date'),
        ]);

        $flasher->addSuccess('تم تحديث المهمة بنجاح.');
        return redirect()->route('tasks.index');
    }


    public function destroy(Request $request)
    {
        $task = Task::findOrFail($request->task_id);

        try {
            $task->delete();
            return redirect()->route('tasks.index')->with('error', 'تم حذف المهمة بنجاح.');
        } catch (\Exception $e) {
            return redirect()->route('tasks.index')->with('error', 'حدث خطأ أثناء حذف المهمة.');
        }
    }
}
