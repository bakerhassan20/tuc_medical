@extends('layouts.base')

@section('content')
@can("اضافة وقت")
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

            <div class="row mb-5">
                <div class="col d-flex justify-content-start">
                    <h4 class="main-heading mt-5">إضافة حضور جديد</h4>
                </div>
                <div class="col d-flex justify-content-end">
                    <a class="btn btn-primary btn-sm " style="margin-top: 21px;height: 35px;" href="{{ route('attendances.index') }}">رجوع</a> <!-- btn-lg for larger button -->
                </div>
            </div>

            <!-- row -->
            <div class="card">
                <div class="card-body">

                    <form class="parsley-style-1" id="attendanceForm" autocomplete="off" name="attendanceForm"
                        action="{{ route('attendances.store') }}" method="post" enctype="multipart/form-data">
                        {{ csrf_field() }}

                        <div class="">

                            <div class="row mg-b-20">
                                <div class="parsley-input col-md-6" id="fnWrapper">
                                    <label>اسم المهندس</label>
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
                                    <label>اليوم</label>
                                    <select class="form-control" name="day" required>
                                        <option value="">اختر اليوم</option>
                                        <option value="السبت" {{ old('day') == 'السبت' ? 'selected' : '' }}>السبت</option>
                                        <option value="الأحد" {{ old('day') == 'الأحد' ? 'selected' : '' }}>الأحد</option>
                                        <option value="الاثنين" {{ old('day') == 'الاثنين' ? 'selected' : '' }}>الاثنين</option>
                                        <option value="الثلاثاء" {{ old('day') == 'الثلاثاء' ? 'selected' : '' }}>الثلاثاء</option>
                                        <option value="الأربعاء" {{ old('day') == 'الأربعاء' ? 'selected' : '' }}>الأربعاء</option>
                                        <option value="الخميس" {{ old('day') == 'الخميس' ? 'selected' : '' }}>الخميس</option>
                                        <option value="الجمعة" {{ old('day') == 'الجمعة' ? 'selected' : '' }}>الجمعة</option>
                                    </select>
                                </div>
                            </div>

                            <div class="row mg-b-20 mt-5">
                                <div class="parsley-input col-md-6" id="fnWrapper">
                                    <label>وقت الحضور</label>
                                    <input class="form-control" type="time" name="attendance_time" required value="{{ old('attendance_time') }}" placeholder=""/>
                                </div>

                                <div class="parsley-input col-md-6 mg-t-20 mg-md-t-0" id="lnWrapper">
                                    <label>وقت الانصراف</label>
                                    <input class="form-control" type="time" name="departure_time" required value="{{ old('departure_time') }}" placeholder=""/>
                                </div>
                            </div>

                            <div class="row mg-b-20 mt-5">
                                <div class="parsley-input col-md-6" id="fnWrapper">
                                    <label>وقت الاستراحة</label>
                                    <input class="form-control" type="time" name="break_time" required value="{{ old('break_time') }}" placeholder=""/>
                                </div>

                                <div class="parsley-input col-md-6 mg-t-20 mg-md-t-0" id="lnWrapper">
                                    <label>التاريخ</label>
                                    <input class="form-control" type="date" name="date" required value="{{ old('date') }}" placeholder=""/>
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
    @endcan
    @cannot('اضافة وقت')
        <div class="col-md-offset-1 col-md-10 alert alert-danger can">
            ليس لديك صلاحية يرجي مراجعة المسؤول
        </div>
    @endcannot
@endsection
