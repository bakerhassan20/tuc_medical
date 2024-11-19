<?php

namespace App\Http\Controllers;

use App\Models\Engineer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Flasher\Prime\FlasherInterface;

class EngineerController extends Controller
{
    public function index(Request $request)
    {
        $query = Engineer::query();

        if ($request->has('name') && $request->name != '') {
            $query->where('name', 'like', '%' . $request->name . '%');
        }

        $engineers = $query->paginate(10);
        $engineers->appends($request->all());

        return view('engineers.index', compact('engineers'));
    }

    public function store(Request $request)
    {
        $inputs = $request->all();

        $validator = Validator::make($inputs, [
            'name' => 'required|string|max:255',
        ], [
            'name.required' => 'اسم المهندس مطلوب.',
            'name.max' => 'اسم المهندس يجب أن يكون أقل من 255 حرفًا.',
        ]);

        if ($validator->fails()) {
            return redirect()->route('engineers.index')->withErrors($validator)->withInput();
        }

        Engineer::create($inputs);

        return redirect()->route('engineers.index')->with('success', 'تم إضافة المهندس بنجاح.');
    }

    public function update(Request $request, string $id, FlasherInterface $flasher)
    {
        $inputs = $request->all();
        $engineer = Engineer::findOrFail($request->engineer_id);

        $validator = Validator::make($inputs, [
            'name' => 'required|string|max:255',
        ], [
            'name.required' => 'اسم المهندس مطلوب.',
            'name.max' => 'اسم المهندس يجب أن يكون أقل من 255 حرفًا.',
        ]);

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                $flasher->addError($error);
            }
            return redirect()->route('engineers.index')->withInput();
        }

        $engineer->update($inputs);

        return redirect()->route('engineers.index')->with('success', 'تم تعديل بيانات المهندس بنجاح.');
    }

    public function destroy(Request $request, string $id, FlasherInterface $flasher)
    {
        Engineer::findOrFail($request->engineer_id)->delete();
        $flasher->addError('تم حذف المهندس بنجاح.');
        return redirect()->route('engineers.index');
    }
}
