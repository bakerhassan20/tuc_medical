@extends('layouts.base')

@section('content')

    <section class="main-section clinic">
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
                    <h4 class="main-heading mt-5">إضافة عيادة جديدة</h4>
                </div>
                <div class="col d-flex justify-content-end">
                    <a class="btn btn-primary btn-sm" style="margin-top: 21px; height: 35px;" href="{{ route('clinics.index') }}">رجوع</a>
                </div>
            </div>

            <!-- row -->
            <div class="card">
                <div class="card-body">

                    <form class="parsley-style-1" id="clinicForm" autocomplete="off" name="clinicForm"
                        action="{{ route('clinics.store') }}" method="post" enctype="multipart/form-data">
                        {{ csrf_field() }}

                        <div class="">

                            <!-- Clinic Name -->
                            <div class="row mg-b-20">
                                <div class="parsley-input col-md-6" id="chairWrapper">
                                    <label>الكرسي</label>
                                    <input class="form-control" type="text" name="chair" value="{{ old('chair') }}" placeholder="الكرسي"/>
                                </div>
                                <div class="parsley-input col-md-6" id="clinicNameWrapper">
                                    <label>اسم العيادة</label>
                                    <input class="form-control" type="text" name="clinic_name" required value="{{ old('clinic_name') }}" placeholder="اسم العيادة"/>
                                </div>
                            </div>

                            <!-- Chair and Floor -->
                            <div class="row mg-b-20 mt-5">


                                <div class="parsley-input col-md-6 mg-t-20 mg-md-t-0" id="floorWrapper">
                                    <label>الطابق</label>
                                    <input class="form-control" type="number" name="floor" required value="{{ old('floor') }}" placeholder="الطابق"/>
                                </div>

                                <div class="parsley-input col-md-6" id="statusWrapper">
                                    <label>حالة العيادة</label>
                                    <select class="form-control" name="status" required>
                                        <option value="يعمل" {{ old('status') == 'يعمل' ? 'selected' : '' }}>يعمل</option>
                                        <option value="قيد الاصلاح" {{ old('status') == 'قيد الاصلاح' ? 'selected' : '' }}>قيد الاصلاح</option>
                                        <option value="لا يعمل" {{ old('status') == 'لا يعمل' ? 'selected' : '' }}>لا يعمل</option>
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
