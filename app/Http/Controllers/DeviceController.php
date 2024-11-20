<?php

namespace App\Http\Controllers;

use Storage;
use App\Models\Device;
use App\Models\Department;
use App\Models\DeviceDetail;
use Illuminate\Http\Request;
use Flasher\Prime\FlasherInterface;
use Illuminate\Support\Facades\Validator;

class DeviceController extends Controller
{

    public function index(Request $request)
    {
    $query = Device::query();
    if ($request->has('name') && $request->name != '') {
        $query->where('name', 'like', '%' . $request->name . '%');
    }
    if ($request->has('department_id') && $request->department_id != '' && $request->department_id != 'all') {
        $query->where('department_id', $request->department_id);
    }

    if ($request->has('periodic_maintenance') && $request->periodic_maintenance != '' && $request->periodic_maintenance != 'all') {
        $query->where('periodic_maintenance', $request->periodic_maintenance);
    }
    if ($request->has('status') && $request->status != '' && $request->status != 'all') {
        $query->where('status', $request->status);
    }

    $devices = $query->paginate(10);
    $devices->appends($request->all());
    $departments = Department::where('type','قسم')->get();
    return view('devices.index', compact('devices', 'departments'));
    }


    public function create()
    {
        $departments = Department::where('type','قسم')->get();
        return view('devices.create',compact('departments'));

    }


    public function store(Request $request, FlasherInterface $flasher)
    {


        $validator = Validator::make($request->all(),[
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'department_id' => 'required|exists:departments,id',
            'periodic_maintenance' => 'required|in:يوميا,اسبوعيا,شهريا,سنويا',
            'country' => 'required|string|max:255',
            'company' => 'required|string|max:255',
            'status' => 'required|in:يعمل,لا يعمل,قيد الاصلاح',
            'location' => 'required|string|max:255',
            'date' => 'required|date',
            'note' => 'nullable|string|max:1000',
            'photos.*' => 'required|mimes:jpg,jpeg,png,pdf,docx',

        ], [
            'name.required' => 'الاسم هو حقل مطلوب.',
            'name.string' => 'الاسم يجب أن يكون نصًا.',
            'name.max' => 'الاسم يجب أن يكون أقل من 255 حرفًا.',

            'description.string' => 'الوصف يجب أن يكون نصًا.',
            'description.max' => 'الوصف يجب أن يكون أقل من 1000 حرفًا.',

            'department_id.required' => 'القسم هو حقل مطلوب.',
            'department_id.exists' => 'القسم المحدد غير موجود.',

            'periodic_maintenance.required' => 'الصيانة الدورية هي حقل مطلوب.',
            'periodic_maintenance.in' => 'الصيانة الدورية يجب أن تكون من الخيارات المحددة.',

            'country.required' => 'بلد المنشأ هو حقل مطلوب.',
            'country.string' => 'بلد المنشأ يجب أن يكون نصًا.',
            'country.max' => 'بلد المنشأ يجب أن يكون أقل من 255 حرفًا.',

            'company.required' => 'الشركة المصنعة هي حقل مطلوب.',
            'company.string' => 'الشركة المصنعة يجب أن تكون نصًا.',
            'company.max' => 'الشركة المصنعة يجب أن تكون أقل من 255 حرفًا.',

            'status.required' => 'الحالة هي حقل مطلوب.',
            'status.in' => 'الحالة يجب أن تكون من الخيارات المحددة.',

            'location.required' => 'الموقع هو حقل مطلوب.',
            'location.string' => 'الموقع يجب أن يكون نصًا.',
            'location.max' => 'الموقع يجب أن يكون أقل من 255 حرفًا.',

            'date.required' => 'تاريخ الأرشفة هو حقل مطلوب.',
            'date.date' => 'يرجى إدخال تاريخ صالح.',

            'note.string' => 'الملاحظات يجب أن تكون نصًا.',
            'note.max' => 'الملاحظات يجب أن تكون أقل من 1000 حرفًا.',

            'photos.*.required' => 'يجب تحميل الصور أو الملفات.',
            'photos.*.mimes' => 'الملفات يجب أن تكون بصيغ jpg, jpeg, png',
        ]);

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                $flasher->addError($error);
            }
            return redirect()->route('devices.create')->withInput();
        }

        $userId = auth()->user();
        // Store the main document information

        $device = Device::create([
            'name' => $request->input('name'),  // Name of the device
            'description' => $request->input('description'),  // Device description
            'department_id' => $request->input('department_id'),  // Department ID (ensure it comes from the request)
            'periodic_maintenance' => $request->input('periodic_maintenance'),  // Maintenance period
            'country' => $request->input('country'),  // Country
            'company' => $request->input('company'),  // Manufacturer company
            'status' => $request->input('status', 'يعمل'),  // Default to 'يعمل' if not provided
            'location' => $request->input('location'),  // Location
            'date' => $request->input('date'),  // Date of the device
            'note' =>$request->note,  // Optional note
        ]);




        // Handle multiple file uploads
        if ($request->hasFile('photos')) {

            foreach ($request->file('photos') as $file) {
                $today = now();
                $filename = time() . '_' . $file->getClientOriginalName();
                $path = "devices/".$device->name;
                $path = $file->storeAs($path,$filename,'public');
                DeviceDetail::create([
                   'device_id' => $device->id,
                   'img' => $path,
                ]);
            }

            return redirect()->route('devices.index')->with('success','تم اضافة الجهاز بنجاح');
    }
}



    public function show(string $id, FlasherInterface $flasher)
    {
        $device = Device::find($id);

        if (!$device) {
            $flasher->addError('الجهاز غير موجود.');
            return redirect()->route('devices.index');
        }
        return view('devices.show',compact('device'));
    }

    public function edit(string $id, FlasherInterface $flasher)
    {
        $device = Device::find($id);

        if (!$device) {
            $flasher->addError('الجهاز غير موجود.');
            return redirect()->route('devices.index');
        }
        $departments = Department::where('type','قسم')->get();
        return view('devices.edit',compact('departments','device'));
    }


    public function update(Request $request, $id, FlasherInterface $flasher)
{
    // Fetch the device by its ID
    $device = Device::find($id);

    // If the device doesn't exist, redirect with error
    if (!$device) {
        $flasher->addError('الجهاز غير موجود.');
        return redirect()->route('devices.index');
    }

    // Validate the request input
    $validator = Validator::make($request->all(), [
        'name' => 'required|string|max:255',
        'description' => 'nullable|string|max:1000',
        'department_id' => 'required|exists:departments,id',
        'periodic_maintenance' => 'required|in:يوميا,اسبوعيا,شهريا,سنويا',
        'country' => 'required|string|max:255',
        'company' => 'required|string|max:255',
        'status' => 'required|in:يعمل,لا يعمل,قيد الاصلاح',
        'location' => 'required|string|max:255',
        'date' => 'required|date',
        'note' => 'nullable|string|max:1000',
        'photos.*' => 'nullable|mimes:jpg,jpeg,png,pdf,docx',  // Files are optional in update
    ], [
        'name.required' => 'الاسم هو حقل مطلوب.',
        'name.string' => 'الاسم يجب أن يكون نصًا.',
        'name.max' => 'الاسم يجب أن يكون أقل من 255 حرفًا.',

        'description.string' => 'الوصف يجب أن يكون نصًا.',
        'description.max' => 'الوصف يجب أن يكون أقل من 1000 حرفًا.',

        'department_id.required' => 'القسم هو حقل مطلوب.',
        'department_id.exists' => 'القسم المحدد غير موجود.',

        'periodic_maintenance.required' => 'الصيانة الدورية هي حقل مطلوب.',
        'periodic_maintenance.in' => 'الصيانة الدورية يجب أن تكون من الخيارات المحددة.',

        'country.required' => 'بلد المنشأ هو حقل مطلوب.',
        'country.string' => 'بلد المنشأ يجب أن يكون نصًا.',
        'country.max' => 'بلد المنشأ يجب أن يكون أقل من 255 حرفًا.',

        'company.required' => 'الشركة المصنعة هي حقل مطلوب.',
        'company.string' => 'الشركة المصنعة يجب أن تكون نصًا.',
        'company.max' => 'الشركة المصنعة يجب أن تكون أقل من 255 حرفًا.',

        'status.required' => 'الحالة هي حقل مطلوب.',
        'status.in' => 'الحالة يجب أن تكون من الخيارات المحددة.',

        'location.required' => 'الموقع هو حقل مطلوب.',
        'location.string' => 'الموقع يجب أن يكون نصًا.',
        'location.max' => 'الموقع يجب أن يكون أقل من 255 حرفًا.',

        'date.required' => 'تاريخ الأرشفة هو حقل مطلوب.',
        'date.date' => 'يرجى إدخال تاريخ صالح.',

        'note.string' => 'الملاحظات يجب أن تكون نصًا.',
        'note.max' => 'الملاحظات يجب أن تكون أقل من 1000 حرفًا.',

        'photos.*.required' => 'يجب تحميل الصور أو الملفات.',
        'photos.*.mimes' => 'الملفات يجب أن تكون بصيغ jpg, jpeg, png',

    ]);

    if ($validator->fails()) {
        foreach ($validator->errors()->all() as $error) {
            $flasher->addError($error);
        }
        return redirect()->route('devices.edit', ['device' => $device->id])->withInput();
    }

    // Update the device with the new data
    $device->update([
        'name' => $request->input('name'),
        'description' => $request->input('description'),
        'department_id' => $request->input('department_id'),
        'periodic_maintenance' => $request->input('periodic_maintenance'),
        'country' => $request->input('country'),
        'company' => $request->input('company'),
        'status' => $request->input('status', 'يعمل'),  // Default to 'يعمل' if not provided
        'location' => $request->input('location'),
        'date' => $request->input('date'),
        'note' => $request->input('note'),
    ]);

    // Handle file uploads (if new files are provided)
    if ($request->hasFile('photos')) {
        $deviceDetails = DeviceDetail::where('device_id', $device->id)->get();
        foreach ($deviceDetails as $detail) {
            if (\Storage::disk('public')->exists($detail->img)) {
                \Storage::disk('public')->delete($detail->img);
            }
            $detail->delete();
         }

        // Upload new photos
        foreach ($request->file('photos') as $file) {
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = "devices/" . $device->name;
            $path = $file->storeAs($path, $filename, 'public');
            DeviceDetail::create([
                'device_id' => $device->id,
                'img' => $path,
            ]);
        }
    }
    $flasher->addSuccess('تم تحديث الجهاز بنجاح.');
    return redirect()->route('devices.index');
}



    public function destroy(Request $request,string $id,FlasherInterface $flasher)
    {
    $device = Device::find($request->device_id);

    if (!$device) {
        $flasher->addError('الجهاز غير موجود.');
        return redirect()->route('devices.index');
    }

    $deviceDetails = DeviceDetail::where('device_id', $device->id)->get();

    foreach ($deviceDetails as $detail) {
        $detail->delete();
    }

    $folderPath = "devices/" . $device->name;
    if (\Storage::disk('public')->exists($folderPath)) {
        \Storage::disk('public')->deleteDirectory($folderPath);
    }

    $device->delete();

    $flasher->addError('تم حذف الجهاز بنجاح.');
    return redirect()->route('devices.index');
    }
}
