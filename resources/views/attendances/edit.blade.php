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
                <h4 class="main-heading mt-5">تعديل الحضور</h4>
            </div>
            <div class="col d-flex justify-content-end">
                <a class="btn btn-primary btn-sm " style="margin-top: 21px;height: 35px;" href="{{ route('attendances.index') }}">رجوع</a>
            </div>
        </div>

        <!-- row -->
        <div class="card">
            <div class="card-body">

                <form class="parsley-style-1" id="attendanceForm" autocomplete="off" name="attendanceForm"
                    action="{{ route('attendances.update', $attendance->id) }}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="">
                        <!-- Engineer and Day -->
                        <div class="row mg-b-20">
                            <div class="parsley-input col-md-6" id="fnWrapper">
                                <label>اسم المهندس</label>
                                <select class="form-control" name="engineer_id" required>
                                    <option value="">اختر المهندس</option>
                                    @foreach ($engineers as $engineer)
                                        <option value="{{ $engineer->id }}" {{ old('engineer_id', $attendance->engineer_id) == $engineer->id ? 'selected' : '' }}>
                                            {{ $engineer->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="parsley-input col-md-6 mg-t-20 mg-md-t-0" id="lnWrapper">
                                <label>اليوم</label>
                                <select class="form-control" name="day" required>
                                    <option value="">اختر اليوم</option>
                                    <option value="السبت" {{ old('day', $attendance->day) == 'السبت' ? 'selected' : '' }}>السبت</option>
                                    <option value="الأحد" {{ old('day', $attendance->day) == 'الأحد' ? 'selected' : '' }}>الأحد</option>
                                    <option value="الاثنين" {{ old('day', $attendance->day) == 'الاثنين' ? 'selected' : '' }}>الاثنين</option>
                                    <option value="الثلاثاء" {{ old('day', $attendance->day) == 'الثلاثاء' ? 'selected' : '' }}>الثلاثاء</option>
                                    <option value="الأربعاء" {{ old('day', $attendance->day) == 'الأربعاء' ? 'selected' : '' }}>الأربعاء</option>
                                    <option value="الخميس" {{ old('day', $attendance->day) == 'الخميس' ? 'selected' : '' }}>الخميس</option>
                                    <option value="الجمعة" {{ old('day', $attendance->day) == 'الجمعة' ? 'selected' : '' }}>الجمعة</option>
                                </select>
                            </div>
                        </div>

                        <!-- Attendance Times -->
                        <div class="row mg-b-20 mt-5">
                            <div class="parsley-input col-md-6" id="fnWrapper">
                                <label>وقت الحضور</label>
<input class="form-control" type="time" name="attendance_time" required
value="{{ old('attendance_time', \Carbon\Carbon::parse($attendance->attendance_time)->format('h:i') ) }}" placeholder=""/>
                            </div>

                            <div class="parsley-input col-md-6 mg-t-20 mg-md-t-0" id="lnWrapper">
                                <label>وقت الانصراف</label>
                                <input class="form-control" type="time" name="departure_time" required value="{{ old('departure_time',  \Carbon\Carbon::parse($attendance->departure_time)->format('h:i') ) }}" placeholder=""/>
                            </div>
                        </div>

                        <!-- Break Time and Date -->
                        <div class="row mg-b-20 mt-5">
                            <div class="parsley-input col-md-6" id="fnWrapper">
                                <label>وقت الاستراحة</label>
                                <input class="form-control" type="time" name="break_time" required value="{{ old('break_time', \Carbon\Carbon::parse($attendance->break_time)->format('h:i')) }}" placeholder=""/>
                            </div>

                            <div class="parsley-input col-md-6 mg-t-20 mg-md-t-0" id="lnWrapper">
                                <label>التاريخ</label>
                                <input class="form-control" type="date" name="date" required value="{{ old('date', $attendance->date) }}" placeholder=""/>
                            </div>
                        </div>

                    </div><br><br>
                    <div class="mg-t-30 text-center">
                        <button class="btn btn-primary pd-x-20" type="submit">حفظ التعديلات</button>
                    </div>
                </form>
            </div>
        </div>

    </div>
</section>

@endsection
