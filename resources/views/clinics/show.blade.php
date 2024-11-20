@extends('layouts.base')

@section('content')

@can("عرض عيادة")
<section class="main-section clinic">
    <div class="container">

        <div class="row mb-5">
            <div class="col d-flex justify-content-start">
                <h4 class="main-heading mt-5">تفاصيل العيادة : {{ $clinic->clinic_name ?? 'غير محدد' }}</h4>
            </div>
            <div class="col d-flex justify-content-end">
                <a class="btn btn-primary btn-sm" style="margin-top: 21px; height: 35px;" href="{{ route('clinics.index') }}">رجوع</a>
            </div>
        </div>

        <div class="card mt-4">
            <div class="card-body">
                <table class="table table-bordered">
                    <tbody>
                        <tr>
                            <th>اسم العيادة</th>
                            <td>{{ $clinic->clinic_name ?? 'غير محدد' }}</td>
                        </tr>
                        <tr>
                            <th>الكرسي</th>
                            <td>{{ $clinic->chair ?? 'غير محدد' }}</td>
                        </tr>
                        <tr>
                            <th>الطابق</th>
                            <td>{{ $clinic->floor ?? 'غير محدد' }}</td>
                        </tr>
                        <tr>
                            <th>حالة العيادة</th>
                            <td>{{ $clinic->status ?? 'غير محدد' }}</td>
                        </tr>
                        <tr>
                            <th>التاريخ</th>
                            <td>{{ \Carbon\Carbon::parse($clinic->date)->format('Y/m/d') ?? 'غير محدد' }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>
@endcan
@cannot('عرض عيادة')
    <div class="col-md-offset-1 col-md-10 alert alert-danger can">
        ليس لديك صلاحية يرجي مراجعة المسؤول
    </div>
@endcannot
@endsection
