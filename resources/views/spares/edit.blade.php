@extends('layouts.base')

@section('content')
@can("تعديل قطعة")
<section class="main-section spares">
    <div class="container">
        @if (count($errors) > 0)
            <div class="alert alert-danger">
                <button aria-label="Close" class="close" data-dismiss="alert" type="button">
                    <span aria-hidden="true">&times;</span>
                </button>
                <strong>خطأ</strong>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif


        <div class="row mb-5">
            <div class="col d-flex justify-content-start">
                <!-- Device name at the start -->
                <h4 class="main-heading mt-5">{{ $spare->name }}</h4>
            </div>
            <div class="col d-flex justify-content-end">
                <!-- Back button with custom size -->
                <a class="btn btn-primary btn-sm " style="margin-top: 21px;height: 35px;" href="{{ route('spares.index') }}">رجوع</a> <!-- btn-lg for larger button -->
            </div>
        </div>


        <div class="card">
            <div class="card-body">

                <form class="parsley-style-1" id="editSpareForm" autocomplete="off" action="{{ route('spares.update', $spare->id) }}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('PUT') <!-- This is required for the update route in Laravel -->

                    <div class="row mg-b-20">
                        <div class="parsley-input col-md-6">
                            <label>اسم القطعة</label>
                            <input class="form-control" type="text" name="name" required value="{{ old('name', $spare->name) }}" placeholder="اسم القطعة" />
                        </div>

                        <div class="parsley-input col-md-6">
                            <label>القسم</label>
                            <select class="form-control" name="department_id" required>
                                <option value="">اختر القسم</option>
                                @foreach ($departments as $department)
                                    <option value="{{ $department->id }}" {{ old('department_id', $spare->department_id) == $department->id ? 'selected' : '' }}>
                                        {{ $department->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="row mg-b-20">
                        <div class="parsley-input col-md-6">
                            <label>اسم الدكتور</label>
                            <input class="form-control" type="text" name="doctor_name" required value="{{ old('doctor_name', $spare->doctor_name) }}" placeholder="اسم الدكتور" />
                        </div>

                        <div class="parsley-input col-md-6">
                            <label>الكمية</label>
                            <input class="form-control" type="number" name="quantity" required min="1" value="{{ old('quantity', $spare->quantity) }}" placeholder="الكمية" />
                        </div>
                    </div>

                    <div class="row mg-b-20">
                        <div class="parsley-input col-md-6">
                            <label>تاريخ الإضافة</label>
                            <input class="form-control" type="date" name="date" required value="{{ old('date', $spare->date) }}" />
                        </div>

                        <div class="parsley-input col-md-6">
                            <label>صورة القطعة</label>
                            <input class="form-control" type="file" name="img" accept=".jpg, .jpeg, .png" />
                        </div>
                    </div>

                    <div class="row mg-b-20">
                        <div class="parsley-input col">
                            <label>وصف القطعة</label>
                            <textarea name="description" class="form-control" rows="3" placeholder="وصف القطعة">{{ old('description', $spare->description) }}</textarea>
                        </div>
                    </div>

                    <!-- Display existing images (if any) -->
                    @if ($spare->img)
                        <div class="mt-5">
                            <label class="text-danger">الصورة الحالية:</label>
                            <div class="mt-5">
                                <img src="{{ asset('storage/' . $spare->img) }}" alt="spare part image" style="width: 50%; height: auto;">
                            </div>
                        </div>
                    @endif

                    <br><br>

                    <div class="mg-t-30 text-center">
                        <button class="btn btn-primary pd-x-20" type="submit">تعديل</button>
                    </div>
                </form>
            </div>
        </div>

    </div>
</section>
@endcan
@cannot('تعديل قطعة')
    <div class="col-md-offset-1 col-md-10 alert alert-danger can">
        ليس لديك صلاحية يرجي مراجعة المسؤول
    </div>
@endcannot
@endsection
