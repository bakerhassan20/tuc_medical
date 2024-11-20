@extends('layouts.base')

@section('content')
@can("عرض قطعة")
<section class="main-section spares">
    <div class="container">

        <div class="row mb-5">
            <div class="col d-flex justify-content-start">
                <!-- Spare part name at the start -->
                <h4 class="main-heading mt-5">{{ $spare->name }}</h4>
            </div>
            <div class="col d-flex justify-content-end">
                <!-- Back button with custom size -->
                <a class="btn btn-primary btn-sm" style="margin-top: 21px;height: 35px;" href="{{ route('spares.index') }}">رجوع</a>
            </div>
        </div>

        <!-- row -->
        <div class="card">
            <div class="card-body">

                <div class="spare-details">
                    <!-- Display spare part image -->
                    <div class="spare-image mb-4">
                        @if ($spare->img)
                            <img src="{{ asset('storage/' . $spare->img) }}" alt="Spare Part Image" class="img-thumbnail" style="width: 50%; height: auto;">
                        @else
                            <p>لا توجد صورة لهذه القطعة.</p>
                        @endif
                    </div>

                    <!-- Spare part name and description -->
                    <div class="spare-info">
                        <p><strong>الوصف:</strong></p>
                        <p>{{ $spare->description ?? 'لا يوجد وصف لهذه القطعة' }}</p>

                        <hr>

                        <!-- Additional spare part information (optional) -->
                        <div class="card mt-4">
                            <div class="card-body">
                                <h5>تفاصيل القطعة</h5>
                                <table class="table table-bordered">
                                    <tbody>
                                        <tr>
                                            <th>القسم</th>
                                            <td>{{ $spare->department->name ?? 'غير محدد' }}</td>
                                        </tr>
                                        <tr>
                                            <th>اسم الدكتور</th>
                                            <td>{{ $spare->doctor_name }}</td>
                                        </tr>
                                        <tr>
                                            <th>الكمية</th>
                                            <td>{{ $spare->quantity }}</td>
                                        </tr>
                                        <tr>
                                            <th>التاريخ</th>
                                            <td>{{ $spare->date }}</td>
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
</section>
@endcan
@cannot('عرض قطعة')
    <div class="col-md-offset-1 col-md-10 alert alert-danger can">
        ليس لديك صلاحية يرجي مراجعة المسؤول
    </div>
@endcannot
@endsection
