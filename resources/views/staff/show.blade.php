@extends('layouts.base')

@section('content')

<section class="main-section staff">
    <div class="container">

        <div class="row mb-5">
            <div class="col d-flex justify-content-start">
                <!-- Staff name at the start -->
                <h4 class="main-heading mt-5">{{ $staff->engineer_name }}</h4>
            </div>
            <div class="col d-flex justify-content-end">
                <!-- Back button with custom size -->
                <a class="btn btn-primary btn-sm" style="margin-top: 21px;height: 35px;" href="{{ route('staff.index') }}">رجوع</a>
            </div>
        </div>

        <!-- row -->
        <div class="card">
            <div class="card-body">

                <div class="staff-details">
                    <!-- Display staff image -->
                    <div class="staff-image mb-4">
                        @if ($staff->img)
                            <img src="{{ asset('storage/' . $staff->img) }}" alt="Staff Image" class="img-thumbnail" style="width: 50%; height: auto;">
                        @else
                            <p>لا توجد صورة للامر الاداري .</p>
                        @endif
                    </div>

                    <!-- Staff name and description -->
                    <div class="staff-info">

                        <hr>

                        <!-- Additional staff information -->
                        <div class="card mt-4">
                            <div class="card-body">
                                <h5>تفاصيل المهندس</h5>
                                <table class="table table-bordered">
                                    <tbody>
                                        <tr>
                                            <th>اسم المهندس</th>
                                            <td>{{ $staff->engineer->name ?? 'غير محدد' }}</td>
                                        </tr>
                                        <tr>
                                            <th>القسم</th>
                                            <td>{{ $staff->department->name ?? 'غير محدد' }}</td>
                                        </tr>
                                        <tr>
                                            <th>الكلية</th>
                                            <td>{{ $staff->college->name ?? 'غير محدد' }}</td>
                                        </tr>
                                        <tr>
                                            <th>تاريخ المباشرة</th>
                                            <td>{{ \Carbon\Carbon::parse($staff->hire_date)->format('Y/m/d') }}</td>
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

@endsection
