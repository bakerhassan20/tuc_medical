@extends('layouts.base')

@section('content')
<section class="main-section store">
    <div class="container">

        <div class="row mb-5">
            <div class="col d-flex justify-content-start">
                <h4 class="main-heading mt-5">تفاصيل مادة: {{ $store->name ?? 'غير محدد' }}</h4>
            </div>
            <div class="col d-flex justify-content-end">
                <a class="btn btn-primary btn-sm " style="margin-top: 21px; height: 35px;" href="{{ route('stores.index') }}">رجوع</a>
            </div>
        </div>

        <div class="card mt-4">
            <div class="card-body">
                <table class="table table-bordered">
                    <tbody>
                        <tr>
                            <th>اسم المادة</th>
                            <td>{{ $store->name ?? 'غير محدد' }}</td>
                        </tr>
                        <tr>
                            <th>الوصف</th>
                            <td>{{ $store->description ?? 'غير محدد' }}</td>
                        </tr>
                        <tr>
                            <th>الكمية</th>
                            <td>{{ $store->quantity ?? 'غير محدد' }}</td>
                        </tr>
                        <tr>
                            <th>الموقع</th>
                            <td>{{ $store->location ?? 'غير محدد' }}</td>
                        </tr>
                        <tr>
                            <th>التاريخ</th>
                            <td>{{ $store->date ?? 'غير محدد' }}</td>
                        </tr>
                        <tr>
                            <th>الملاحظات</th>
                            <td>{{ $store->notes ?? 'غير محدد' }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>
@endsection
