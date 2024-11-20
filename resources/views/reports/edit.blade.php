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
                <h4 class="main-heading mt-5">تعديل التقرير</h4>
            </div>
            <div class="col d-flex justify-content-end">
                <a class="btn btn-primary btn-sm" style="margin-top: 21px; height: 35px;" href="{{ route('reports.index') }}">رجوع</a>
            </div>
        </div>

        <!-- row -->
        <div class="card">
            <div class="card-body">

                <form id="reportForm" autocomplete="off" name="reportForm"
                    action="{{ route('reports.update', $report->id) }}" method="post">
                    @csrf
                    @method('PUT')

                    <div class="">

                        <!-- Department and Device -->
                        <div class="row mg-b-20">
                            <div class="parsley-input col-md-6" id="departmentWrapper">
                                <label>الكليه او القسم</label>
                                <select class="form-control" name="department_id" id="department_id" required>
                                    <option value="">اختر </option>
                                    @foreach ($departments as $department)
                                        <option value="{{ $department->id }}"
                                                {{ old('department_id', $report->department_id) == $department->id ? 'selected' : '' }}>
                                            {{ $department->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="parsley-input col-md-6" id="deviceWrapper">
                                <label>الجهاز</label>
                                <select class="form-control" name="device_id" id="device_id" required>
                                    <option value="">اختر الجهاز</option>
                                    @foreach ($devices as $device)
                                        <option value="{{ $device->id }}"
                                                {{ old('device_id', $report->device_id) == $device->id ? 'selected' : '' }}>
                                            {{ $device->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <!-- Work Done, Description, Quantity, Date -->
                        <div class="row mg-b-20">
                            <div class="parsley-input col-md-6" id="workDoneWrapper">
                                <label>الأعمال المنجزة</label>
                                <input class="form-control" type="text" name="work_done" required
                                    value="{{ old('work_done', $report->work_done) }}" placeholder="الأعمال المنجزة"/>
                            </div>

                            <div class="parsley-input col-md-6" id="descriptionWrapper">
                                <label>الوصف</label>
                                <input class="form-control" type="text" name="description" required
                                    value="{{ old('description', $report->description) }}" placeholder="الوصف"/>
                            </div>
                        </div>

                        <!-- Quantity and Date -->
                        <div class="row mg-b-20">
                            <div class="parsley-input col-md-6" id="quantityWrapper">
                                <label>الكمية</label>
                                <input class="form-control" type="number" name="quantity" required
                                    value="{{ old('quantity', $report->quantity) }}" placeholder="الكمية"/>
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
