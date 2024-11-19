@extends('layouts.base')

@section('content')


    <section class="main-section users">
        <div class="container">


            <div class="row mb-5">
                <div class="col d-flex justify-content-start">
                    <!-- Device name at the start -->
                    <h4 class="main-heading mt-5">{{ $device->name }}</h4>
                </div>
                <div class="col d-flex justify-content-end">
                    <!-- Back button with custom size -->
                    <a class="btn btn-primary btn-sm " style="margin-top: 21px;height: 35px;" href="{{ route('devices.index') }}">رجوع</a> <!-- btn-lg for larger button -->
                </div>
            </div>


            <!-- row -->
            <div class="card">
                <div class="card-body">
                    <div class="col-lg-12 margin-tb">
                        <div class="al">
                        </div>
                    </div><br>
                    <div class="device-details">
                        <!-- Display device images -->
                        <div class="device-images mb-4">
                            @if ($device->details->count() > 0)
                                <div class="row">
                                    @foreach ($device->details as $detail)
                                        <div class="col-md-6 mb-3">
                                            <img src="{{ asset('storage/' . $detail->img) }}" alt="Device Image" class="img-thumbnail" style="width: 100%; height: auto;">
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <p>لا توجد صور لهذا الجهاز.</p>
                            @endif
                        </div>

                        <!-- Device name and description -->
                        <div class="device-info">
                            <p><strong>الوصف:</strong></p>
                            <p>{{ $device->description ?? 'لا يوجد وصف لهذا الجهاز' }}</p>

                            <hr>

                            <!-- Additional device information (optional) -->
                           <div class="card mt-4">
                                <div class="card-body">
                                    <h5>تفاصيل الجهاز</h5>
                                    <table class="table table-bordered">
                                        <tbody>
                                            <tr>
                                                <th>القسم</th>
                                                <td>{{ $device->department->name ?? 'غير محدد' }}</td>
                                            </tr>
                                            <tr>
                                                <th>بلد المنشأ</th>
                                                <td>{{ $device->country }}</td>
                                            </tr>
                                            <tr>
                                                <th>الشركة المصنعة</th>
                                                <td>{{ $device->company }}</td>
                                            </tr>
                                            <tr>
                                                <th>الموقع</th>
                                                <td>{{ $device->location }}</td>
                                            </tr>
                                            <tr>
                                                <th>تاريخ الإضافة</th>
                                                <td>{{ $device->date }}</td>
                                            </tr>
                                            <tr>
                                                <th>الملاحظات</th>
                                                <td>{{ $device->note ?? 'لا توجد ملاحظات' }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                        </div>


                    </div>

                </div>
            </div>

        </div>
        </div>
    </section>
@endsection
