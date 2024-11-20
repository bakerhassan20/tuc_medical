@extends('layouts.base')

@section('content')

<section class="main-section staff">
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
                <!-- Staff name at the start -->
                <h4 class="main-heading mt-5">تعديل بيانات مهندس: {{ $staff->engineer->name }}</h4>
            </div>
            <div class="col d-flex justify-content-end">
                <!-- Back button with custom size -->
                <a class="btn btn-primary btn-sm" style="margin-top: 21px;height: 35px;" href="{{ route('staff.index') }}">رجوع</a>
            </div>
        </div>

        <div class="card">
            <div class="card-body">

                <form class="parsley-style-1" id="editStaffForm" autocomplete="off" action="{{ route('staff.update', $staff->id) }}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('PUT') <!-- This is required for the update route in Laravel -->

                    <div class="row mg-b-20 mt-5">
                        <div class="parsley-input col-md-6">
                            <label>اسم المهندس</label>
                            <select class="form-control" name="engineer_id" required>
                                <option value="">اختر المهندس</option>
                                @foreach ($engineers as $engineer)
                                    <option value="{{ $engineer->id }}" {{ old('engineer_id', $staff->engineer_id) == $engineer->id ? 'selected' : '' }}>
                                        {{ $engineer->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="parsley-input col-md-6">
                            <label>القسم</label>
                            <select class="form-control" name="department_id" required>
                                <option value="">اختر القسم</option>
                                @foreach ($departments as $department)
                                    <option value="{{ $department->id }}" {{ old('department_id', $staff->department_id) == $department->id ? 'selected' : '' }}>
                                        {{ $department->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="row mg-b-20 mt-5">
                        <div class="parsley-input col-md-6">
                            <label>اسم الكلية</label>
                            <select class="form-control" name="college_id" required>
                                <option value="">اختر القسم</option>
                                @foreach ($colleges as $college)
                                    <option value="{{ $college->id }}" {{ old('college_id', $staff->college_id) == $college->id ? 'selected' : '' }}>
                                        {{ $college->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="parsley-input col-md-6">
                            <label>تاريخ المباشرة</label>
                            <input class="form-control" type="date" name="date" required value="{{ old('date', $staff->date) }}" />
                        </div>
                    </div>

                    <div class="row mg-b-20 mt-5">
                        <div class="parsley-input col-md-6">
                            <label>صورة الامر الاداري</label>
                            <input class="form-control" type="file" name="img" accept=".jpg, .jpeg, .png" />
                        </div>
                    </div>

                    <!-- Display existing image (if any) -->
                    @if ($staff->img)
                        <div class="mt-5 mt-5">
                            <label class="text-danger">الصورة الحالية:</label>
                            <div class="mt-5">
                                <img src="{{ asset('storage/' . $staff->img) }}" alt="staff image" style="width: 50%; height: auto;">
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

@endsection
