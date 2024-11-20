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
                <h4 class="main-heading mt-5">تعديل العيادة</h4>
            </div>
            <div class="col d-flex justify-content-end">
                <a class="btn btn-primary btn-sm" style="margin-top: 21px; height: 35px;" href="{{ route('clinics.index') }}">رجوع</a>
            </div>
        </div>

        <!-- row -->
        <div class="card">
            <div class="card-body">

                <form id="clinicForm" autocomplete="off" name="clinicForm"
                    action="{{ route('clinics.update', $clinic->id) }}" method="post">
                    @csrf
                    @method('PUT')

                    <div class="">

                        <!-- Clinic Name -->
                        <div class="row mg-b-20">
                            <div class="parsley-input col-md-6" id="chairWrapper">
                                <label>الكرسي</label>
                                <input class="form-control" type="text" name="chair"
                                    value="{{ old('chair', $clinic->chair) }}" placeholder="الكرسي"/>
                            </div>
                            <div class="parsley-input col-md-6" id="clinicNameWrapper">
                                <label>اسم العيادة</label>
                                <input class="form-control" type="text" name="clinic_name" required
                                    value="{{ old('clinic_name', $clinic->clinic_name) }}" placeholder="اسم العيادة"/>
                            </div>
                        </div>

                        <!-- Chair and Floor -->
                        <div class="row mg-b-20 mt-5">


                            <div class="parsley-input col-md-6" id="floorWrapper">
                                <label>الطابق</label>
                                <input class="form-control" type="number" name="floor" required
                                    value="{{ old('floor', $clinic->floor) }}" placeholder="الطابق"/>
                            </div>

                            <div class="parsley-input col-md-6" id="statusWrapper">
                                <label>حالة العيادة</label>
                                <select class="form-control" name="status" required>
                                    <option value="يعمل" {{ old('status', $clinic->status) == 'يعمل' ? 'selected' : '' }}>يعمل</option>
                                    <option value="قيد الاصلاح" {{ old('status', $clinic->status) == 'قيد الاصلاح' ? 'selected' : '' }}>قيد الاصلاح</option>
                                    <option value="لا يعمل" {{ old('status', $clinic->status) == 'لا يعمل' ? 'selected' : '' }}>لا يعمل</option>
                                </select>
                            </div>
                        </div>

                        <!-- Date -->
                        <div class="row mg-b-20 mt-5">
                            <div class="parsley-input col-md-6" id="dateWrapper">
                                <label>التاريخ</label>
                                <input class="form-control" type="date" name="date" required
                                    value="{{ old('date', $clinic->date) }}"/>
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

@section('script')

@endsection
