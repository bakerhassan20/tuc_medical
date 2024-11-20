@extends('layouts.base')

@section('content')
@can("عرض كتاب")
<section class="main-section book">
    <div class="container">

        <div class="row mb-5">
            <div class="col d-flex justify-content-start">
                <h4 class="main-heading mt-5">تفاصيل الكتاب : {{ $book->type ?? 'غير محدد' }}</h4>
            </div>
            <div class="col d-flex justify-content-end">
                <a class="btn btn-primary btn-sm" style="margin-top: 21px; height: 35px;" href="{{ route('books.index') }}">رجوع</a>
            </div>
        </div>

        <div class="card mt-4">
            <div class="card-body">
                <table class="table table-bordered">
                    <tbody>
                        <tr>
                            <th>القسم</th>
                            <td>{{ $book->department->name ?? 'غير محدد' }}</td>
                        </tr>
                        <tr>
                            <th>المهندس</th>
                            <td>{{ $book->engineer->name ?? 'غير محدد' }}</td>
                        </tr>
                        <tr>
                            <th>نوع الكتاب</th>
                            <td>{{ $book->type ?? 'غير محدد' }}</td>
                        </tr>
                        <tr>
                            <th>حالة الكتاب</th>
                            <td>{{ $book->status ?? 'غير محدد' }}</td>
                        </tr>
                        <tr>
                            <th>التاريخ</th>
                            <td>{{ \Carbon\Carbon::parse($book->date)->format('Y/m/d') ?? 'غير محدد' }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>
@endcan
@cannot('عرض كتاب')
    <div class="col-md-offset-1 col-md-10 alert alert-danger can">
        ليس لديك صلاحية يرجي مراجعة المسؤول
    </div>
@endcannot
@endsection
