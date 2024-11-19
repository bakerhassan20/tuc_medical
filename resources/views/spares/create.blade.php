@extends('layouts.base')

@section('content')

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
                <h4 class="main-heading mt-5">إضافة قطعة غيار جديدة</h4>
            </div>
            <div class="col d-flex justify-content-end">
                <a class="btn btn-primary btn-sm " style="margin-top: 21px;height: 35px;" href="{{ route('spares.index') }}">رجوع</a> <!-- btn-lg for larger button -->
            </div>
        </div>

        <div class="card">
            <div class="card-body">


                <form class="parsley-style-1" id="createSpareForm" autocomplete="off" action="{{ route('spares.store') }}" method="post" enctype="multipart/form-data">
                    @csrf

                    <div class="row mg-b-20 mt-5">
                        <div class="parsley-input col-md-6">
                            <label>اسم القطعة</label>
                            <input class="form-control" type="text" name="name" required value="{{ old('name') }}" placeholder="اسم القطعة" />
                        </div>

                        <div class="parsley-input col-md-6">
                            <label>القسم</label>
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
                        <div class="parsley-input col-md-6">
                            <label>اسم الدكتور</label>
                            <input class="form-control" type="text" name="doctor_name" required value="{{ old('doctor_name') }}" placeholder="اسم الدكتور" />
                        </div>

                        <div class="parsley-input col-md-6">
                            <label>الكمية</label>
                            <input class="form-control" type="number" name="quantity" required min="1" value="{{ old('quantity') }}" placeholder="الكمية" />
                        </div>
                    </div>

                    <div class="row mg-b-20 mt-5">
                        <div class="parsley-input col-md-6">
                            <label>تاريخ الإضافة</label>
                            <input class="form-control" type="date" name="date" required value="{{ old('date') }}" />
                        </div>

                        <div class="parsley-input col-md-6">
                            <label>صورة القطعة</label>
                            <input class="form-control" type="file" name="img" accept=".jpg, .jpeg, .png" />
                        </div>
                    </div>

                    <div class="row mg-b-20 mt-5">
                        <div class="parsley-input col">
                            <label>وصف القطعة</label>
                            <textarea name="description" class="form-control" rows="3" placeholder="وصف القطعة">{{ old('description') }}</textarea>
                        </div>
                    </div>

                    <div class="mg-t-30 text-center mt-5">
                        <button class="btn btn-primary pd-x-20" type="submit">إضافة</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

@endsection
