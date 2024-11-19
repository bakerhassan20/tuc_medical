@extends('layouts.base')

@section('content')

<section class="main-section users">
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
                <h4 class="main-heading mt-5">تعديل المهمة</h4>
            </div>
            <div class="col d-flex justify-content-end">
                <a class="btn btn-primary btn-sm " style="margin-top: 21px;height: 35px;" href="{{ route('tasks.index') }}">رجوع</a> <!-- btn-lg for larger button -->
            </div>
        </div>
        <!-- row -->
        <div class="card">
            <div class="card-body">

                <form class="parsley-style-1" id="selectForm4" autocomplete="off" name="selectForm2"
                    action="{{ route('tasks.update', $task->id) }}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="">
                        <!-- Name and Department -->
                        <div class="row mg-b-20">
                            <div class="parsley-input col-md-6" id="fnWrapper">
                                <label>اسم المهندس</label>
                                <select class="form-control" name="engineer_id" required>
                                    <option value="">اختر المهندس</option>
                                    @foreach ($engineers as $engineer)
                                        <option value="{{ $engineer->id }}" {{ old('engineer_id', $task->engineer_id) == $engineer->id ? 'selected' : '' }}>
                                            {{ $engineer->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="parsley-input col-md-6 mg-t-20 mg-md-t-0" id="lnWrapper">
                                <label>القسم</label>
                                <select class="form-control" name="department_id" required>
                                    <option value="">اختر القسم</option>
                                    @foreach ($departments as $department)
                                        <option value="{{ $department->id }}" {{ old('department_id', $task->department_id) == $department->id ? 'selected' : '' }}>
                                            {{ $department->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <!-- Status and Errands -->
                        <div class="row mg-b-20 mt-5">
                            <div class="parsley-input col-md-6" id="fnWrapper">
                                <label>حالة المهام</label>
                                <select class="form-control" name="status" required>
                                    <option disabled>اختر الحالة</option>
                                    <option value="مكتملة" {{ old('status', $task->status) == 'مكتملة' ? 'selected' : '' }}>مكتملة</option>
                                    <option value="غير مكتملة" {{ old('status', $task->status) == 'غير مكتملة' ? 'selected' : '' }}>غير مكتملة</option>
                                    <option value="قيد العمل" {{ old('status', $task->status) == 'قيد العمل' ? 'selected' : '' }}>قيد العمل</option>
                                </select>
                            </div>

                            <div class="parsley-input col-md-6 mg-t-20 mg-md-t-0" id="lnWrapper">
                                <label>المهام الموكلة إليه</label>
                                <input class="form-control" type="text" name="errands" required value="{{ old('errands', $task->errands) }}" placeholder="" />
                            </div>
                        </div>

                        <!-- Priority and Date -->
                        <div class="row mg-b-20 mt-5">
                            <div class="parsley-input col-md-6" id="fnWrapper">
                                <label>الأولوية</label>
                                <select class="form-control" name="priority" required>
                                    <option disabled>اختر الأولوية</option>
                                    <option value="عالية" {{ old('priority', $task->priority) == 'عالية' ? 'selected' : '' }}>عالية</option>
                                    <option value="متوسطة" {{ old('priority', $task->priority) == 'متوسطة' ? 'selected' : '' }}>متوسطة</option>
                                    <option value="منخفضة" {{ old('priority', $task->priority) == 'منخفضة' ? 'selected' : '' }}>منخفضة</option>
                                </select>
                            </div>

                            <div class="parsley-input col-md-6 mg-t-20 mg-md-t-0" id="lnWrapper">
                                <label>التاريخ</label>
                                <input class="form-control" type="date" name="date" required value="{{ old('date', $task->date) }}" placeholder="" />
                            </div>
                        </div>
                    </div>
                    <br><br>
                    <div class="mg-t-30 text-center">
                        <button class="btn btn-primary pd-x-20" type="submit">حفظ التعديلات</button>
                    </div>
                </form>
            </div>
        </div>

    </div>
</section>
@endsection
