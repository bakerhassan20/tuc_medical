@extends('layouts.base')

@section('content')


    <section class="main-section users">
        <div class="container">
            @if (count($errors) > 0)
                <div class="alert alert-danger">
                    <button aria-label="Close" class="close" data-dismiss="alert" type="button">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <strong>خطا</strong>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <h4 class="main-heading mt-5">اضافة جهاز جديد</h4>
            <!-- row -->
            <div class="card">
                <div class="card-body">
                    <div class="col-lg-12 margin-tb">
                        <div class="al">
                            <a class="btn btn-primary btn-sm" href="{{ route('devices.index') }}">رجوع</a>
                        </div>
                    </div><br>

                    <form class="parsley-style-1" id="selectForm4" autocomplete="off" name="selectForm2"
                    action="{{ route('devices.store', 'store') }}" method="post" enctype="multipart/form-data">
                    {{ csrf_field() }}

                    <div class="">

                        <div class="row mg-b-20">
                            <div class="parsley-input col-md-6" id="fnWrapper">
                                <label>اسم الجهاز </label>
                                <input class="form-control" type="text" name="name" required=""
                                    value="{{ old('name') }}" placeholder="" />
                            </div>

                            <div class="parsley-input col-md-6 mg-t-20 mg-md-t-0" id="lnWrapper">
                                <label> القسم </label>
                                <select class="form-control" name="department_id" required>
                                    <option value="">اختر القسم</option>
                                    @foreach ($departments as $department)
                                        <option value="{{ $department->id }}" {{ old('department_id') == $department->id ? 'selected' : '' }}>
                                            {{ $department->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="row mg-b-20 mt-5">
                            <div class="parsley-input col-md-6" id="fnWrapper">
                                <label>الصيانه الدورية</label>
                                <select class="form-control" name="periodic_maintenance" required>
                                    <option disabled>اختر المدة</option>
                                    <option value="يوميا" {{ old('periodic_maintenance') == 'يوميا' ? 'selected' : '' }}>يوميا</option>
                                    <option value="اسبوعيا" {{ old('periodic_maintenance') == 'اسبوعيا' ? 'selected' : '' }}>اسبوعيا</option>
                                    <option value="شهريا" {{ old('periodic_maintenance') == 'شهريا' ? 'selected' : '' }}>شهريا</option>
                                    <option value="سنويا" {{ old('periodic_maintenance') == 'سنويا' ? 'selected' : '' }}>سنويا</option>
                                </select>
                            </div>

                            <div class="parsley-input col-md-6 mg-t-20 mg-md-t-0" id="lnWrapper">
                                <label> بلد المنشا </label>
                                <input class="form-control" type="text" name="country" required value="{{ old('country') }}" placeholder="" />
                            </div>
                        </div>

                        <div class="row mg-b-20 mt-5">
                            <div class="parsley-input col-md-6" id="fnWrapper">
                                <label>الشركة المصنعه </label>
                                <input class="form-control" required type="text" name="company" value="{{ old('company') }}" placeholder="" />
                            </div>

                            <div class="parsley-input col-md-6 mg-t-20 mg-md-t-0" id="lnWrapper">
                                <label> موقع الجهاز الفعلي </label>
                                <input class="form-control" type="text" name="location" required value="{{ old('location') }}" placeholder="" />
                            </div>
                        </div>

                        <div class="row mg-b-20 mt-5">
                            <div class="parsley-input col-md-6" id="fnWrapper">
                                <label> حاله الجهاز </label>
                                <select class="form-control" name="status" required>
                                    <option disabled >اختر الحالة</option>
                                    <option value="يعمل" {{ old('status') == 'يعمل' ? 'selected' : '' }}>يعمل</option>
                                    <option value="لا يعمل" {{ old('status') == 'لا يعمل' ? 'selected' : '' }}>لا يعمل</option>
                                    <option value="قيد الاصلاح" {{ old('status') == 'قيد الاصلاح' ? 'selected' : '' }}>قيد الاصلاح</option>
                                </select>
                            </div>

                            <div class="parsley-input col-md-6 mg-t-20 mg-md-t-0" id="lnWrapper">
                                <label> تاريخ الاضافة </label>
                                <input class="form-control" type="date" name="date" required value="{{ old('date') }}" placeholder="" />
                            </div>
                        </div>

                        <div class="row mg-b-20 mt-5">
                            <div class="parsley-input col" id="fnWrapper">
                                <label> وصف الجهاز</label>
                                <textarea name="description" class="form-control" cols="10" rows="3">{{ old('description') }}</textarea>
                            </div>
                        </div>

                        <div class="row mg-b-20 mt-5">
                            <div class="parsley-input col" id="fnWrapper">
                                <label> الملاحظات</label>
                                <textarea name="note" class="form-control" cols="30" rows="3">{{ old('note') }}</textarea>
                            </div>
                        </div>

                        <div class="row mt-5">
                            <div class="col" id="">
                                <label> اضافة الصور: </label>
                                <input class="form-control" type="file" required name="photos[]" accept=".jpg, .jpeg, .png," id="photos" multiple />
                            </div>
                        </div>

                    </div><br><br>
        

                        <div class="mg-t-30 text-center">
                            <button class="btn btn-primary pd-x-20" type="submit">اضافة</button>
                        </div>
                        {!! Form::close() !!}
                </div>
            </div>

        </div>
        </div>
    </section>
@endsection
