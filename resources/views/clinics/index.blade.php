@extends('layouts.base')

@section('content')

<!-- Modal-delete -->
<div class="modal fade" id="modal-delete-clinic" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">حذف العيادة</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('clinics.destroy', 'delete') }}" method="post">
                {{ method_field('delete') }}
                {{ csrf_field() }}
                <div class="modal-body">
                    <h6 class="text-center">هل أنت متأكد من إجراء عملية الحذف؟</h6>
                    <input type="hidden" name="clinic_id" id="clinic_id" value="">
                    <input class="form-control" required name="clinic_name" id="clinic_name" type="text" readonly>
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
    <h4 class="main-heading mt-5">العيادات</h4>


</div>

<!-- Filter Section -->
<div class="collapse" id="filterCollapse">
    <div class="container">
        <form class="bg-white p-3 rounded-2 shadow" method="GET" action="{{ route('clinics.index') }}">
            <div class="d-flex align-items-center flex-wrap justify-content-between mb-3">
                <div class="col-3">
                    <label for="status" class="form-label">الحالة</label>
                    <select class="form-control" name="status">
                        <option value="">اختر الحالة</option>
                        <option value="يعمل" {{ request('status') == 'يعمل' ? 'selected' : '' }}>يعمل</option>
                        <option value="قيد الاصلاح" {{ request('status') == 'قيد الاصلاح' ? 'selected' : '' }}>قيد الاصلاح</option>
                        <option value="لا يعمل" {{ request('status') == 'لا يعمل' ? 'selected' : '' }}>لا يعمل</option>
                    </select>
                </div>
                <div class="d-flex align-items-center gap-3 mt-3">
                    <button type="submit" class="btn btn-sm btn-info">تصفية</button>
                    <a href="{{ route('clinics.index') }}" class="btn btn-sm btn-secondary">إعادة تعيين</a>
                </div>
            </div>
        </form>
    </div>
</div>




<section class="main-section clinic">
    <div class="container">
        <form class="bg-white p-3 rounded-2 shadow">

<!--***************************-->
            <div class="d-flex align-items-center flex-wrap justify-content-end mb-3">
                <button   title="فلتر" type="button" style="margin-left: 10px;" class="btn btn-primary btn-sm" data-bs-toggle="collapse" data-bs-target="#filterCollapse" aria-expanded="false" aria-controls="filterCollapse">
            <i class="bx bx-filter-alt"></i>
                </button>
                <a href="{{ route('clinics.create') }}" class="btn btn-success btn-sm" title ="إضافة عيادة جديدة">
                <i class="bx bx-plus-circle"></i>
                </a>
                </div>
<!--***************************-->

            <div class="table-responsive">
                <table class="table main-table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>اسم العيادة</th>
                            <th>الكرسي</th>
                            <th>الطابق</th>
                            <th>الحالة</th>
                            <th>التاريخ</th>
                            <th class="text-center">التحكم</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($clinics as $clinic)
                            <tr>
                                <td>{{ ($clinics->currentPage() - 1) * $clinics->perPage() + $loop->iteration }}</td>
                                <td>{{ $clinic->clinic_name }}</td>
                                <td>{{ $clinic->chair ?? 'غير محدد' }}</td>
                                <td>{{ $clinic->floor }}</td>
                                <td>
                                    @if($clinic->status == 'يعمل')
                                        <span class="text-success">{{ $clinic->status }}</span>
                                    @elseif($clinic->status == 'قيد الاصلاح')
                                        <span class="text-warning">{{ $clinic->status }}</span>
                                    @else
                                        <span class="text-danger">{{ $clinic->status }}</span>
                                    @endif
                                </td>

                                <td>{{ $clinic->date }}</td>

                                <td class="text-center">
                                    <div class="d-flex align-items-center justify-content-center gap-1">
                                    {{--     <a class="btn btn-sm btn-info" href="{{ route('clinics.show', $clinic->id) }}">عرض</a> --}}
                                        <a class="btn btn-sm btn-primary" href="{{ route('clinics.edit', $clinic->id) }}">تعديل</a>
                                        <div class="btn btn-sm btn-danger" data-bs-toggle="modal" data-clinic_id="{{ $clinic->id }}" data-clinic_name="{{ $clinic->clinic_name }}" data-bs-target="#modal-delete-clinic">
                                            حذف
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="pagination">
                    {{ $clinics->links() }}
                </div>
            </div>
        </form>
    </div>
</section>

@endsection

@section('script')

<script>
    $(document).ready(function() {
        $('#modal-delete-clinic').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget);
            var clinic_id = button.data('clinic_id');
            var clinic_name = button.data('clinic_name');
            var modal = $(this);

            modal.find('.modal-body #clinic_id').val(clinic_id);
            modal.find('.modal-body #clinic_name').val(clinic_name);
        });
    });
</script>

@endsection
