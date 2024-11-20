@extends('layouts.base')

@section('content')

    <section class="main-section report">
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
                    <h4 class="main-heading mt-5">إضافة تقرير جديد</h4>
                </div>
                <div class="col d-flex justify-content-end">
                    <a class="btn btn-primary btn-sm" style="margin-top: 21px; height: 35px;" href="{{ route('reports.index') }}">رجوع</a>
                </div>
            </div>

            <!-- row -->
            <div class="card">
                <div class="card-body">

                    <form class="parsley-style-1" id="reportForm" autocomplete="off" name="reportForm"
                        action="{{ route('reports.store') }}" method="post" enctype="multipart/form-data">
                        {{ csrf_field() }}

                        <div class="">

                            <!-- Department and Device -->
                            <div class="row mg-b-20">
                                <div class="parsley-input col-md-6" id="departmentWrapper">
                                    <label>الكلية او القسم</label>
                                    <select class="form-control" id="department_id" name="department_id" required>
                                        <option value="">اختر </option>
                                        @foreach ($departments as $department)
                                            <option value="{{ $department->id }}" {{ old('department_id') == $department->id ? 'selected' : '' }}>
                                                {{ $department->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="parsley-input col-md-6 mg-t-20 mg-md-t-0" id="deviceWrapper">
                                    <label>الجهاز</label>
                                    <select id="device_id" class="form-control" name="device_id" required>
                                        <option value="">اختر الجهاز</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Work Done and Description -->
                            <div class="row mg-b-20 mt-5">
                                <div class="parsley-input col-md-6" id="workDoneWrapper">
                                    <label>العمل المنجز</label>
                                    <input class="form-control" type="text" name="work_done" required value="{{ old('work_done') }}" placeholder="العمل المنجز"/>
                                </div>

                                <div class="parsley-input col-md-6 mg-t-20 mg-md-t-0" id="descriptionWrapper">
                                    <label>الوصف</label>
                                    <input class="form-control" type="text" name="description" value="{{ old('description') }}" placeholder="الوصف"/>
                                </div>
                            </div>

                            <!-- Quantity -->
                            <div class="row mg-b-20 mt-5">
                                <div class="parsley-input col-md-6" id="quantityWrapper">
                                    <label>الكمية</label>
                                    <input class="form-control" type="number" name="quantity" required value="{{ old('quantity') }}" placeholder="الكمية"/>
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
<script>
    $(document).ready(function () {
        $('#department_id').on('change', function () {
            var departmentId = $(this).val();

            if (departmentId) {
                $.ajax({
                    url: '{{ route("get.devices.by.department") }}', // Define the route for fetching devices
                    type: 'GET',
                    data: { department_id: departmentId },
                    success: function (response) {
                        $('#device_id').empty(); // Clear previous options
                        $('#device_id').append('<option value="">اختر الجهاز</option>'); // Default option

                        // Populate devices dropdown
                        $.each(response.devices, function (key, device) {
                            $('#device_id').append('<option value="' + device.id + '">' + device.name + '</option>');
                        });
                    },
                    error: function () {
                        alert('حدث خطأ أثناء جلب الأجهزة');
                    }
                });
            } else {
                $('#device_id').empty().append('<option value="">اختر الجهاز</option>'); // Reset if no department is selected
            }
        });
    });
</script>
@endsection
