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
                            <ul>
                                <li><strong>القسم:</strong> {{ $device->department->name }}</li>
                                <li><strong>بلد المنشأ:</strong> {{ $device->country }}</li>
                                <li><strong>الشركة المصنعة:</strong> {{ $device->company }}</li>
                                <li><strong>الموقع:</strong> {{ $device->location }}</li>
                                <li><strong>تاريخ الإضافة:</strong> {{ $device->date }}</li>
                                <li><strong>الملاحظات:</strong> {{ $device->note ?? 'لا توجد ملاحظات' }}</li>
                            </ul>
                        </div>


                    </div>

                </div>
            </div>

        </div>
        </div>
    </section>
@endsection
