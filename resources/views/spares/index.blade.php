@extends('layouts.base')

@section('content')

<!-- Modal-delete -->
<div class="modal fade" id="modal-delete-spare" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">حذف قطعة الغيار</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('spares.destroy', 'delete') }}" method="POST">
                @csrf
                @method('DELETE')
                <div class="modal-body">
                    <p class="text-center">هل أنت متأكد من عملية الحذف؟</p>
                    <input type="hidden" name="spare_id" id="spare_id">
                    <input class="form-control" id="spare_name" type="text" readonly>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
                    <button type="submit" class="btn btn-danger">حذف</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Filter Section -->
<div class="container mb-5">
    <h4 class="main-heading mt-5">قطع الغيار</h4>
    <div class="row">
        <div class="d-flex align-items-center gap-3 mt-3">
            <button type="button" class="btn btn-primary" data-bs-toggle="collapse" data-bs-target="#filterCollapse" aria-expanded="false" aria-controls="filterCollapse">
                الفلتر
            </button>
        </div>
    </div>
</div>

<!-- Collapsible content (Initially hidden) -->
<div class="collapse" id="filterCollapse">
    <div class="container">
        <form class="bg-white p-3 rounded-2 shadow" method="GET" action="{{ route('spares.index') }}">
            <div class="d-flex align-items-center flex-wrap justify-content-between mb-3">
                <div>
                        <label for="name" class="form-label">اسم القطعة</label>
                        <input type="text" class="form-control" name="name" id="name" value="{{ request('name') }}">

                 </div>
                <div>
                    <label for="department_id" class="form-label">القسم</label>
                    <select class="form-select" name="department_id">
                        <option value="all">اختر القسم</option>
                        @foreach($departments as $department)
                            <option value="{{ $department->id }}" {{ request('department_id') == $department->id ? 'selected' : '' }}>
                                {{ $department->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="doctor_name" class="form-label">اسم الدكتور</label>
                    <input type="text" class="form-control" name="doctor_name" id="doctor_name" value="{{ request('doctor_name') }}">
                </div>
                <div class="d-flex align-items-center gap-3 mt-3">
                    <button type="submit" class="btn btn-sm btn-info">تصفية</button>
                    <a href="{{ route('spares.index') }}" class="btn btn-sm btn-secondary">إعادة تعيين</a>
                </div>
            </div>
        </form>
    </div>
</div>


<!-- Spare Parts Table -->
<section class="main-section spares">
    <div class="container">
        <div class="d-flex justify-content-end mb-3">
            <a href="{{ route('spares.create') }}" class="btn btn-success btn-sm">
                أضف قطعة جديدة
                <i class="menu-icon tf-plus bx bx-plus ms-2"></i>
            </a>
        </div>

        <div class="table-responsive">
            <table class="table main-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>اسم القطعة</th>
                        <th>الوصف</th>
                        <th>الكمية</th>
                        <th>القسم</th>
                        <th>اسم الدكتور</th>
                        <th>التاريخ</th>
                        <th class="text-center">التحكم</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($spares as $spare)
                        <tr>
                            <td>{{ ($spares->currentPage() - 1) * $spares->perPage() + $loop->iteration }}</td>
                            <td>{{ $spare->name }}</td>
                            <td>{{ $spare->description }}</td>
                            <td>{{ $spare->quantity }}</td>
                            <td>{{ $spare->department->name }}</td>
                            <td>{{ $spare->doctor_name }}</td>
                            <td>{{ \Carbon\Carbon::parse($spare->date)->format('Y/m/d') }}</td>
                            <td class="text-center">
                                <div class="d-flex justify-content-center gap-2">
                                    <a class="btn btn-sm btn-info" href="{{ route('spares.show', $spare->id) }}">عرض</a>
                                    <a href="{{ route('spares.edit', $spare->id) }}" class="btn btn-sm btn-primary">تعديل</a>
                                    <button class="btn btn-sm btn-danger"
                                            data-bs-toggle="modal"
                                            data-bs-target="#modal-delete-spare"
                                            data-spare_id="{{ $spare->id }}"
                                            data-spare_name="{{ $spare->name }}">
                                        حذف
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="mt-3">
                {{ $spares->links() }}
            </div>
        </div>
    </div>
</section>
@endsection

@section('script')
<script>
    $(document).ready(function () {
        $('#modal-delete-spare').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var spare_id = button.data('spare_id');
            var spare_name = button.data('spare_name');
            var modal = $(this);

            modal.find('#spare_id').val(spare_id);
            modal.find('#spare_name').val(spare_name);
        });
    });
</script>
@endsection
