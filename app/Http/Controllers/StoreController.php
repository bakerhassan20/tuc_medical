<?php

namespace App\Http\Controllers;

use App\Models\Store;
use Flasher\Prime\FlasherInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class StoreController extends Controller
{
    public function index(Request $request)
    {
        $query = Store::query();

        // Filter by name (if provided)
        if ($request->has('name') && $request->name != '') {
            $query->where('name', 'like', '%' . $request->name . '%');
        }

        // Filter by location (if provided)
        if ($request->has('location') && $request->location != '') {
            $query->where('location', 'like', '%' . $request->location . '%');
        }

        // Filter by date (if provided)
        if ($request->has('date') && $request->date != '') {
            $query->whereDate('date', $request->date);
        }

        // Paginate the results
        $stores = $query->paginate(10);
        $stores->appends($request->all());

        return view('stores.index', compact('stores'));
    }

    public function create()
    {
        return view('stores.create');
    }

    public function store(Request $request, FlasherInterface $flasher)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'quantity' => 'required|integer',
            'location' => 'required|string|max:255',
            'date' => 'required|date',
            'notes' => 'nullable|string',
        ], [
            'name.required' => 'اسم المخزن مطلوب.',
            'quantity.required' => 'الكمية مطلوبة.',
            'location.required' => 'الموقع مطلوب.',
            'date.required' => 'التاريخ مطلوب.',
            'date.date' => 'يرجى إدخال تاريخ صالح.',
        ]);

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                $flasher->addError($error);
            }
            return redirect()->route('stores.create')->withInput();
        }

        Store::create([
            'name' => $request->input('name'),
            'description' => $request->input('description'),
            'quantity' => $request->input('quantity'),
            'location' => $request->input('location'),
            'date' => $request->input('date'),
            'notes' => $request->input('notes'),
        ]);

        $flasher->addSuccess('تم إضافة المخزن بنجاح.');
        return redirect()->route('stores.index');
    }

    public function show(string $id)
    {
        $store = Store::findOrFail($id);
        return view('stores.show', compact('store'));
    }

    public function edit(string $id, FlasherInterface $flasher)
    {
        $store = Store::find($id);

        if (!$store) {
            $flasher->addError('السجل غير موجود.');
            return redirect()->route('stores.index');
        }

        return view('stores.edit', compact('store'));
    }

    public function update(Request $request, FlasherInterface $flasher, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'quantity' => 'required|integer',
            'location' => 'required|string|max:255',
            'date' => 'required|date',
            'notes' => 'nullable|string',
        ], [
            'name.required' => 'اسم المخزن مطلوب.',
            'quantity.required' => 'الكمية مطلوبة.',
            'location.required' => 'الموقع مطلوب.',
            'date.required' => 'التاريخ مطلوب.',
            'date.date' => 'يرجى إدخال تاريخ صالح.',
        ]);

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                $flasher->addError($error);
            }
            return redirect()->route('stores.edit', $id)->withInput();
        }

        // Update the store record
        $store = Store::findOrFail($id);
        $store->update([
            'name' => $request->input('name'),
            'description' => $request->input('description'),
            'quantity' => $request->input('quantity'),
            'location' => $request->input('location'),
            'date' => $request->input('date'),
            'notes' => $request->input('notes'),
        ]);

        $flasher->addSuccess('تم تحديث المخزن بنجاح.');
        return redirect()->route('stores.index');
    }

    public function destroy(Request $request, FlasherInterface $flasher)
    {
        $store = Store::findOrFail($request->store_id);

        try {
            $store->delete();
            $flasher->addSuccess('تم حذف المخزن بنجاح.');
        } catch (\Exception $e) {
            $flasher->addError('حدث خطأ أثناء حذف المخزن.');
        }

        return redirect()->route('stores.index');
    }
}
