<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;
use Flasher\Prime\FlasherInterface;
use Illuminate\Support\Facades\Validator;

class SettingController extends Controller
{

    public function getSettings()
    {
        $site_name = Setting::where('key','site_name')->first();
        $footer = Setting::where('key','footer')->first();
        return view('settings.index',compact('site_name','footer'));
    }



    public function setSettings(Request $request, FlasherInterface $flasher)
    {

        $validator = Validator::make($request->all(), [
            'site_name' => 'required|string|max:255',
            'footer' => 'required|string|max:255',
            'logo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ], [
            'site_name.required' => 'اسم الموقع مطلوب.',
            'site_name.string' => 'اسم الموقع يجب أن يكون نصاً.',
            'site_name.max' => 'اسم الموقع يجب ألا يزيد عن 255 حرفاً.',

            'footer.required' => 'نص الفوتر مطلوب.',
            'footer.string' => 'نص الفوتر يجب أن يكون نصاً.',
            'footer.max' => 'نص الفوتر يجب ألا يزيد عن 255 حرفاً.',

            'logo.image' => 'الملف المرفوع يجب أن يكون صورة.',
            'logo.mimes' => 'يجب أن تكون الصورة بصيغة jpg, jpeg, أو png.',
            'logo.max' => 'حجم الصورة يجب ألا يتجاوز 2 ميغابايت.',
        ]);


        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                $flasher->addError($error);
            }
            return redirect()->route('departments.index')->withInput();
        }




        if ($request->hasFile('logo')) {
            $setting_logo = Setting::where('key','logo')->first();

            // Delete old logo if exists
            if ($setting_logo && $setting_logo->value) {

                $oldLogoPath = public_path($setting_logo->value);  // Assuming logo is stored in 'public/settings/'
        
                if (file_exists($oldLogoPath)) {
                    unlink($oldLogoPath);  // Delete the old logo file
                }
            }

            foreach ($request->all() as $key => $value) {
                Setting::updateOrCreate(['key' => $key], ['value' => $value]);
            }

            // Upload new logo
            $logo = $request->file('logo');
            $logoName = time() . '.' . $logo->getClientOriginalExtension();
            $logoPath = 'settings/' . $logoName;

            // Move the uploaded file to the 'public/uploads/' directory
            $logo->move(public_path('settings'), $logoName);

            // Update the logo path in the settings table
            Setting::updateOrCreate(['key' => 'logo'], ['value' => $logoPath]);
        }


        $flasher->addSuccess('تم تحديث الاعدادات بنجاح.');
        return redirect()->route('get.settings');

    }

}
