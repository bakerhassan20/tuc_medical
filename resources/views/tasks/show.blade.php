@extends('layouts.base')

@section('content')
<section class="main-section users">
    <div class="container">


        <div class="row mb-5">
            <div class="col d-flex justify-content-start">
                <h4 class="main-heading mt-5">تفاصيل المهمة: {{ $task->name }}</h4>
            </div>
            <div class="col d-flex justify-content-end">
                <a class="btn btn-primary btn-sm " style="margin-top: 21px;height: 35px;" href="{{ route('tasks.index') }}">رجوع</a> <!-- btn-lg for larger button -->
            </div>
        </div>

        <div class="card mt-4">
            <div class="card-body">
                <table class="table table-bordered">
                    <tbody>
                        <tr>
                            <th>اسم المهندس</th>
                            <td>{{ $task->engineer->name ?? 'غير محدد' }}</td>
                        </tr>
                        <tr>
                            <th>القسم</th>
                            <td>{{ $task->department->name ?? 'غير محدد' }}</td>
                        </tr>
                        <tr>
                            <th>المهام الموكلة إليه</th>
                            <td>{{ $task->errands }}</td>
                        </tr>
                        <tr>
                            <th>حالة المهام</th>
                            <td>
                                @if ($task->status == 'مكتملة')
                                    <span class="text-success">مكتملة</span>
                                @elseif ($task->status == 'غير مكتملة')
                                    <span class="text-danger">غير مكتملة</span>
                                @else
                                    <span class="text-warning">قيد العمل</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>الأولوية</th>
                            <td>
                                @if ($task->priority == 'عالية')
                                    <span class="text-danger">عالية</span>
                                @elseif ($task->priority == 'متوسطة')
                                    <span class="text-warning">متوسطة</span>
                                @else
                                    <span class="text-info">منخفضة</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>التاريخ</th>
                            <td>{{ $task->date }}</td>
                        </tr>
                 {{--        <tr>
                            <th>تاريخ الإنشاء</th>
                            <td>{{ $task->created_at->format('Y-m-d H:i') }}</td>
                        </tr>
                        <tr>
                            <th>آخر تعديل</th>
                            <td>{{ $task->updated_at->format('Y-m-d H:i') }}</td>
                        </tr> --}}
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>
@endsection
