@extends('layouts.base')

@section('content')

    <section class="main-section book">
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
                    <h4 class="main-heading mt-5">إضافة كتاب جديد</h4>
                </div>
                <div class="col d-flex justify-content-end">
                    <a class="btn btn-primary btn-sm" style="margin-top: 21px; height: 35px;" href="{{ route('books.index') }}">رجوع</a>
                </div>
            </div>

            <!-- row -->
            <div class="card">
                <div class="card-body">

                    <form class="parsley-style-1" id="bookForm" autocomplete="off" name="bookForm"
                        action="{{ route('books.store') }}" method="post" enctype="multipart/form-data">
                        {{ csrf_field() }}

                        <div class="">

                            <!-- Department and Engineer -->
                            <div class="row mg-b-20">
                                <div class="parsley-input col-md-6" id="departmentWrapper">
                                    <label>الكلية او القسم</label>
                                    <select class="form-control" id="department_id" name="department_id" required>
                                        <option value="">اختر الكليه او القسم</option>
                                        @foreach ($departments as $department)
                                            <option value="{{ $department->id }}" {{ old('department_id') == $department->id ? 'selected' : '' }}>
                                                {{ $department->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="parsley-input col-md-6 mg-t-20 mg-md-t-0" id="engineerWrapper">
                                    <label>المهندس</label>
                                    <select id="engineer_id" class="form-control" name="engineer_id" required>
                                        <option value="">اختر المهندس</option>
                                        @foreach ($engineers as $engineer)
                                            <option value="{{ $engineer->id }}" {{ old('engineer_id') == $engineer->id ? 'selected' : '' }}>
                                                {{ $engineer->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <!-- Type and Status -->
                            <div class="row mg-b-20 mt-5">
                                <div class="parsley-input col-md-6" id="typeWrapper">
                                    <label>نوع الكتاب</label>
                                    <input class="form-control" type="text" name="type" required value="{{ old('type') }}" placeholder="النوع"/>
                                </div>

                                <div class="parsley-input col-md-6 mg-t-20 mg-md-t-0" id="statusWrapper">
                                    <label>حالة الكتاب</label>
                                    <select class="form-control" name="status" required>
                                        <option value="مستلم" {{ old('status') == 'مستلم' ? 'selected' : '' }}>مستلم</option>
                                        <option value="قيد المراجعة" {{ old('status') == 'قيد المراجعة' ? 'selected' : '' }}>قيد المراجعة</option>
                                        <option value="غير مستلم" {{ old('status') == 'غير مستلم' ? 'selected' : '' }}>غير مستلم</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Date -->
                            <div class="row mg-b-20 mt-5">
                                <div class="parsley-input col-md-6" id="dateWrapper">
                                    <label>التاريخ</label>
                                    <input class="form-control" type="date" name="date" required value="{{ old('date') }}"/>
                                </div>
                            </div>

                        </div><br><br>

                        <div class="mg-t-30 text-center">
                            <button class="btn btn-primary pd-x-20" type="submit">إضافة</button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </section>

@endsection

@section('script')

@endsection
