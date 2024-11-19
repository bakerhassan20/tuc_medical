@extends('layouts.base')

@section('content')
<section class="main-section users">
    <div class="container">

        <div class="row mb-5">
            <div class="col d-flex justify-content-start">
                <h4 class="main-heading mt-5">تفاصيل الحضور: {{ $attendance->engineer->name ?? 'غير محدد' }}</h4>
            </div>
            <div class="col d-flex justify-content-end">
                <a class="btn btn-primary btn-sm " style="margin-top: 21px;height: 35px;" href="{{ route('attendances.index') }}">رجوع</a>
            </div>
        </div>

        <div class="card mt-4">
            <div class="card-body">
                <table class="table table-bordered">
                    <tbody>
                        <tr>
                            <th>اسم المهندس</th>
                            <td>{{ $attendance->engineer->name ?? 'غير محدد' }}</td>
                        </tr>
                        <tr>
                            <th>اليوم</th>
                            <td>{{ $attendance->day ?? 'غير محدد' }}</td>
                        </tr>
                        <tr>
                            <th>وقت الحضور</th>
                            <td>
                                {{ \Carbon\Carbon::parse($attendance->attendance_time)->format('h:i A') ?? 'غير محدد' }}
                            </td>
                        </tr>
                        <tr>
                            <th>وقت الانصراف</th>
                            <td>
                                {{ \Carbon\Carbon::parse($attendance->departure_time)->format('h:i A') ?? 'غير محدد' }}
                            </td>
                        </tr>
                        <tr>
                            <th>وقت الاستراحة</th>
                            <td>
                                {{ \Carbon\Carbon::parse($attendance->break_time)->format('h:i A') ?? 'غير محدد' }}
                            </td>
                        </tr>
                        <tr>
                            <th>التاريخ</th>
                            <td>{{ $attendance->date ?? 'غير محدد' }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>
@endsection
