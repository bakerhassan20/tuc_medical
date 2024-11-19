@extends('layouts.base')

@section('content')

 <!-- Modal-delete -->
<div class="modal fade" id="modal-delete-attendance" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">حذف الحضور</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('attendances.destroy', "delete") }}" method="post">
                {{ method_field('delete') }}
                {{ csrf_field() }}
                <div class="modal-body">
                    <h6 class="text-center">هل أنت متأكد من إجراء عملية الحذف؟</h6>
                    <input type="hidden" name="attendance_id" id="attendance_id" value="">
                    <input class="form-control" required name="attendance_name" id="attendance_name" type="text" readonly>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" style="font-size: 12px" data-bs-dismiss="modal">إلغاء</button>
                    <button type="submit" class="btn btn-danger">نعم</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="container mb-5">
    <h4 class="main-heading mt-5">حضور الموظفين</h4>

    <div class="row">
        <div class="d-flex align-items-center gap-3 mt-3">
            <!-- Button to toggle collapse -->
            <button type="button" class="btn btn-primary" data-bs-toggle="collapse" data-bs-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
                الفلتر
            </button>
        </div>
    </div>
</div>

<!-- Collapsible content (Initially hidden) -->
<div class="collapse" id="collapseExample">
    <div class="container">
        <form class="bg-white p-3 rounded-2 shadow" method="GET" action="{{ route('attendances.index') }}">
            <div class="d-flex align-items-center flex-wrap justify-content-between mb-3">
                <div>
                    <label for="engineer" class="form-label">اسم المهندس</label>
                    <select style="width:150px" class="form-control" name="engineer_id">
                        <option value="all">اختر المهندس</option>
                        @foreach ($engineers as $engineer)
                            <option value="{{ $engineer->id }}" {{ old('engineer_id') == $engineer->id ? 'selected' : '' }}>
                                {{ $engineer->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="day" class="form-label">اليوم</label>
                    <select style="width:150px" class="form-control" name="day">
                        <option value="all">اختر اليوم</option>
                        <option value="السبت" {{ old('day') == 'السبت' ? 'selected' : '' }}>السبت</option>
                        <option value="الأحد" {{ old('day') == 'الأحد' ? 'selected' : '' }}>الأحد</option>
                        <option value="الاثنين" {{ old('day') == 'الاثنين' ? 'selected' : '' }}>الاثنين</option>
                        <option value="الثلاثاء" {{ old('day') == 'الثلاثاء' ? 'selected' : '' }}>الثلاثاء</option>
                        <option value="الأربعاء" {{ old('day') == 'الأربعاء' ? 'selected' : '' }}>الأربعاء</option>
                        <option value="الخميس" {{ old('day') == 'الخميس' ? 'selected' : '' }}>الخميس</option>
                        <option value="الجمعة" {{ old('day') == 'الجمعة' ? 'selected' : '' }}>الجمعة</option>
                    </select>
                </div>
                <div>
                    <label for="date" class="form-label">التاريخ</label>
                    <input type="date" class="form-control" name="date" value="{{ old('date') }}">
                </div>
                <div class="d-flex align-items-center gap-3 mt-3">
                    <button type="submit" class="btn btn-sm btn-info">تصفية</button>
                    <a href="{{ route('attendances.index') }}" class="btn btn-sm btn-secondary">إعادة تعيين</a>
                </div>
            </div>
        </form>
    </div>
</div>

<section class="main-section attendance">
    <div class="container">
        <form class="bg-white p-3 rounded-2 shadow">
            <div class="d-flex align-items-center flex-wrap justify-content-end mb-2">
                <a href="{{ route('attendances.create') }}" class="btn btn-success btn-sm">
                    أضف حضور جديد
                    <i class="menu-icon tf-plus bx bx-plus ml-4"></i>
                </a>
            </div>

            <div class="table-responsive">
                <table class="table main-table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>اسم المهندس</th>
                            <th>اليوم</th>
                            <th>التاريخ</th>
                            <th>وقت الحضور</th>
                            <th>وقت الانصراف</th>
                            <th>وقت الاستراحة</th>
                            <th class="text-center">التحكم</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($attendances as $attendance)
                            <tr>
                                <td>{{ ($attendances->currentPage() - 1) * $attendances->perPage() + $loop->iteration }}</td>
                                <td>{{ $attendance->engineer->name }}</td>
                                <td>{{ $attendance->day }}</td>
                        <td>{{ \Carbon\Carbon::parse($attendance->date)->format('Y/m/d') }}</td>
                                <td>{{ \Carbon\Carbon::parse($attendance->attendance_time)->format('h:i A') }}</td>
                                <td>{{ \Carbon\Carbon::parse($attendance->departure_time)->format('h:i A') }}</td>
                                <td>{{ \Carbon\Carbon::parse($attendance->break_time)->format('h:i A') }}</td>

                                <td class="text-center">
                                    <div class="d-flex align-items-center justify-content-center gap-1">
                                        <a class="btn btn-sm btn-info" href="{{ route('attendances.show', $attendance->id) }}">عرض</a>
                                        <a class="btn btn-sm btn-primary" href="{{ route('attendances.edit', $attendance->id) }}">تعديل</a>
                                        <div class="btn btn-sm btn-danger" data-bs-toggle="modal" data-attendance_id="{{ $attendance->id }}" data-attendance_name="{{ $attendance->engineer->name }}" data-bs-target="#modal-delete-attendance">
                                            حذف
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="pagination">
                    {{ $attendances->links() }} <!-- This will render the pagination links -->
                </div>
            </div>
        </form>
    </div>
</section>

@endsection

@section('script')

<script>
    $(document).ready(function() {
        $('#modal-delete-attendance').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var attendance_id = button.data('attendance_id')
            var attendance_name = button.data('attendance_name')
            var modal = $(this)

            modal.find('.modal-body #attendance_id').val(attendance_id);
            modal.find('.modal-body #attendance_name').val(attendance_name);
        });
    });
</script>

@endsection
