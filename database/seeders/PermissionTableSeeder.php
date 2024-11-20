<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

            $permissions = [

                'الرئيسية',
                'الصلاحيات',
                'المستخدمين',
                'الاقسام والكليات',
                'المهندسين',
                'الاعدادات',



                'الاجهزة الطبية',
                'عرض جهاز',
                'تعديل جهاز',
                'حذف جهاز',


                'المهام اليومية',
                'عرض مهام',
                'تعديل مهام',
                'حذف مهام',



                'اوقات العمل',
                'عرض وقت',
                'تعديل وقت',
                'حذف وقت',


                'المخزن',
                'عرض مادة',
                'حذف مادة',
                'تعديل مادة',



                'قطع غيار',
                'عرض قطعة',
                'تعديل قطعة',
                'حذف قطعة',



                'الكادر الهندسي',
                'عرض مهندس',
                'تعديل مهندس',
                'حذف مهندس',



                'التقارير الشهرية',
                'عرض تقرير',
                'تعديل تقرير',
                'حذف تقرير',



                'الكتب',
                'عرض كتاب',
                'تعديل كتاب',
                'حذف كتاب',


                'عيادات',
                'عرض عيادة',
                'تعديل عيادة',
                'حذف عيادة',

            ];



            foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
            }

    }
}
