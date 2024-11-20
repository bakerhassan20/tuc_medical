@extends('layouts.base')

@section('content')

<!-- Modal-delete -->
<div class="modal fade" id="modal-delete-staff" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">حذف الموظف</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('staff.destroy', 'delete') }}" method="POST">
                @csrf
                @method('DELETE')
                <div class="modal-body">
                    <p class="text-center">هل أنت متأكد من عملية الحذف؟</p>
                    <input type="hidden" name="staff_id" id="staff_id">
                    <input class="form-control" id="staff_name" type="text" readonly>
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
    <h4 class="main-heading mt-5">الكادر الهندسي</h4>

</div>

<!-- Collapsible content (Initially hidden) -->
<div class="collapse" id="filterCollapse">
    <div class="container">
        <form class="bg-white p-3 rounded-2 shadow" method="GET" action="{{ route('staff.index') }}">
            <div class="d-flex align-items-center flex-wrap justify-content-between mb-3">
                <div>
                    <label for="engineer_id" class="form-label">اسم المهندس</label>
                    <select class="form-select" name="engineer_id">
                        <option value="all">اختر القسم</option>
                        @foreach($engineers as $engineer)
                            <option value="{{ $engineer->id }}" {{ request('engineer_id') == $engineer->id ? 'selected' : '' }}>
                                {{ $engineer->name }}
                            </option>
                        @endforeach
                    </select>                </div>
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
                    <label for="college_id" class="form-label">الكلية</label>
                    <select class="form-select" name="college_id">
                        <option value="all">اختر الكلية</option>
                        @foreach($colleges as $college)
                            <option value="{{ $college->id }}" {{ request('college_id') == $college->id ? 'selected' : '' }}>
                                {{ $college->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="d-flex align-items-center gap-3 mt-3">
                    <button type="submit" class="btn btn-sm btn-info">تصفية</button>
                    <a href="{{ route('staff.index') }}" class="btn btn-sm btn-secondary">إعادة تعيين</a>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Staff Table -->
<section class="main-section staff">
    <div class="container">


<!--***************************-->
<div class="d-flex align-items-center flex-wrap justify-content-end mb-3">
    <button   title="فلتر" type="button" style="margin-left: 10px;" class="btn btn-primary btn-sm" data-bs-toggle="collapse" data-bs-target="#filterCollapse" aria-expanded="false" aria-controls="filterCollapse">
<i class="bx bx-filter-alt"></i>
    </button>
    <a href="{{ route('staff.create') }}" class="btn btn-success btn-sm" title ="إضافة موظف جديد">
    <i class="bx bx-plus-circle"></i>
    </a>
    </div>
<!--***************************-->

        <div class="table-responsive">
            <table class="table main-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>اسم المهندس</th>
                        <th>القسم</th>
                        <th>الكلية</th>
                        <th>التاريخ</th>
                        <th class="text-center">التحكم</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($staff as $staffMember)
                        <tr>
                            <td>{{ ($staff->currentPage() - 1) * $staff->perPage() + $loop->iteration }}</td>
                            <td>{{ $staffMember->engineer->name }}</td>
                            <td>{{ $staffMember->department->name }}</td>
                            <td>{{ $staffMember->college->name }}</td>
                            <td>{{ \Carbon\Carbon::parse($staffMember->date)->format('Y/m/d') }}</td>
                            <td class="text-center">
                                <div class="d-flex justify-content-center gap-2">
                                    <a class="btn btn-sm btn-info" href="{{ route('staff.show', $staffMember->id) }}">عرض</a>
                                    <a href="{{ route('staff.edit', $staffMember->id) }}" class="btn btn-sm btn-primary">تعديل</a>
                                    <button class="btn btn-sm btn-danger"
                                            data-bs-toggle="modal"
                                            data-bs-target="#modal-delete-staff"
                                            data-staff_id="{{ $staffMember->id }}"
                                            data-staff_name="{{ $staffMember->engineer->name }}">
                                        حذف
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="mt-3">
                {{ $staff->links() }}
            </div>
        </div>
    </div>
</section>
@endsection

@section('script')
<script>
    $(document).ready(function () {
        $('#modal-delete-staff').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var staff_id = button.data('staff_id');
            var staff_name = button.data('staff_name');
            var modal = $(this);

            modal.find('#staff_id').val(staff_id);
            modal.find('#staff_name').val(staff_name);
        });
    });
</script>
@endsection
