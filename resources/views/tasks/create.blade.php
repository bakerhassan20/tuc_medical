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
            <h4 class="main-heading mt-5">اضافة مهام جديدة</h4>
            <!-- row -->
            <div class="card">
                <div class="card-body">
                    <div class="col-lg-12 margin-tb">
                        <div class="al">
                            <a class="btn btn-primary btn-sm" href="{{ route('tasks.index') }}">رجوع</a>
                        </div>
                    </div><br>

                    <form class="parsley-style-1" id="selectForm4" autocomplete="off" name="selectForm2"
                    action="{{ route('tasks.store', 'store') }}" method="post" enctype="multipart/form-data">
                    {{ csrf_field() }}

                    <div class="">

                        <div class="row mg-b-20">
                            <div class="parsley-input col-md-6" id="fnWrapper">
                                <label>اسم المهندس </label>
                                <select class="form-control" name="engineer_id" required>
                                    <option value="">اختر المهندس</option>
                                    @foreach ($engineers as $engineer)
                                        <option value="{{ $engineer->id }}" {{ old('engineer_id') == $engineer->id ? 'selected' : '' }}>
                                            {{ $engineer->name }}
                                        </option>
                                    @endforeach
                                </select>
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
                                <label>حالة المهام</label>
                                <select class="form-control" name="status" required>
                                    <option disabled>اختر الحالة</option>
        <option value="مكتملة" {{ old('status') == 'مكتملة' ? 'status' : '' }}>مكتملة</option>
        <option value="غير مكتملة" {{ old('status') == 'غير مكتملة' ? 'status' : '' }}>غير مكتملة</option>
        <option value="قيد العمل" {{ old('status') == 'قيد العمل' ? 'status' : '' }}>قيد العمل</option>
                                </select>
                            </div>

                            <div class="parsley-input col-md-6 mg-t-20 mg-md-t-0" id="lnWrapper">
                                <label>المهام الموكلة الية</label>
                                <input class="form-control" type="text" name="errands" required value="{{ old('errands') }}" placeholder="" />
                            </div>
                        </div>
                        <div class="row mg-b-20 mt-5">
                            <div class="parsley-input col-md-6" id="fnWrapper">
                                <label> الاولوية </label>
                                <select class="form-control" name="priority" required>
                                    <option disabled >اختر الاولوية</option>
                    <option value="عالية" {{ old('priority') == 'عالية' ? 'selected' : '' }}>عالية</option>
                    <option value="متوسطة" {{ old('priority') == 'متوسطة' ? 'selected' : '' }}>متوسطة</option>
                    <option value="منخفضة" {{ old('priority') == 'منخفضة' ? 'selected' : '' }}>منخفضة</option>
                                </select>
                            </div>

                            <div class="parsley-input col-md-6 mg-t-20 mg-md-t-0" id="lnWrapper">
                                <label>التاريخ</label>
                                <input class="form-control" type="date" name="date" required value="{{ old('date') }}" placeholder="" />
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
