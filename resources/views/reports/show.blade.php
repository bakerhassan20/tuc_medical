@extends('layouts.base')

@section('content')
<section class="main-section report">
    <div class="container">

        <div class="row mb-5">
            <div class="col d-flex justify-content-start">
                <h4 class="main-heading mt-5">تفاصيل التقرير : {{ $report->device->name ?? 'غير محدد' }}</h4>
            </div>
            <div class="col d-flex justify-content-end">
                <a class="btn btn-primary btn-sm" style="margin-top: 21px; height: 35px;" href="{{ route('reports.index') }}">رجوع</a>
            </div>
        </div>

        <div class="card mt-4">
            <div class="card-body">
                <table class="table table-bordered">
                    <tbody>
                        <tr>
                            <th>القسم</th>
                            <td>{{ $report->department->name ?? 'غير محدد' }}</td>
                        </tr>
                        <tr>
                            <th>الجهاز</th>
                            <td>{{ $report->device->name ?? 'غير محدد' }}</td>
                        </tr>
                        <tr>
                            <th>الأعمال المنجزة</th>
                            <td>{{ $report->work_done ?? 'غير محدد' }}</td>
                        </tr>
                        <tr>
                            <th>الوصف</th>
                            <td>{{ $report->description ?? 'غير محدد' }}</td>
                        </tr>
                        <tr>
                            <th>الكمية</th>
                            <td>{{ $report->quantity ?? 'غير محدد' }}</td>
                        </tr>
                        <tr>
                            <th>تاريخ التقرير</th>
                            <td>{{ \Carbon\Carbon::parse($report->created_at)->format('Y/m/d') ?? 'غير محدد' }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>
@endsection
