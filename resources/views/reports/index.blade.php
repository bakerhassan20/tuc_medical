@extends('layouts.base')

@section('content')
@can("التقارير الشهرية")
<!-- Modal-delete -->
<div class="modal fade" id="modal-delete-report" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">حذف التقرير</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('reports.destroy', 'delete') }}" method="post">
                {{ method_field('delete') }}
                {{ csrf_field() }}
                <div class="modal-body">
                    <h6 class="text-center">هل أنت متأكد من إجراء عملية الحذف؟</h6>
                    <input type="hidden" name="report_id" id="report_id" value="">
                    <input class="form-control" required name="report_title" id="report_title" type="text" readonly>
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
    <h4 class="main-heading mt-5">التقارير الشهرية</h4>
</div>

<!-- Collapsible content (Initially hidden) -->
<div class="collapse" id="collapseExample">
    <div class="container">
        <form class="bg-white p-3 rounded-2 shadow" method="GET" action="{{ route('reports.index') }}">
            <div class="d-flex align-items-center flex-wrap justify-content-between mb-3">
                <div class="col-2">
                    <label for="name" class="form-label">القسم</label>
                    <select style="width:180px" class="form-control" name="department_id">
                        <option value="all">اختر القسم</option>
                        @foreach ($departments as $department)
                            <option value="{{ $department->id }}" {{ old('department_id') == $department->id ? 'selected' : '' }}>
                                {{ $department->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-6">
                    <label for="name" class="form-label">الجهاز</label>
                    <select style="width:180px" class="form-control" name="device_id">
                        <option value="all">اختر الجهاز</option>
                        @foreach ($devices as $device)
                            <option value="{{ $device->id }}" {{ old('device_id') == $device->id ? 'selected' : '' }}>
                                {{ $device->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="d-flex align-items-center gap-3 mt-3">
                    <button type="submit" class="btn btn-sm btn-info">تصفية</button>
                    <a href="{{ route('reports.index') }}" class="btn btn-sm btn-secondary">إعادة تعيين</a>
                </div>
            </div>
        </form>
    </div>
</div>

<section class="main-section report">
    <div class="container">
        <form class="bg-white p-3 rounded-2 shadow">

<!--***************************-->
            <div class="d-flex align-items-center flex-wrap justify-content-end mb-3">
                <button   title="فلتر" type="button" style="margin-left: 10px;" class="btn btn-primary btn-sm" data-bs-toggle="collapse" data-bs-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
            <i class="bx bx-filter-alt"></i>
                </button>
                <a href="{{ route('reports.create') }}" class="btn btn-success btn-sm" title ="إضافة تقرير جديد">
                <i class="bx bx-plus-circle"></i>
                </a>
                </div>
<!--***************************-->


            <div class="table-responsive">
                <table class="table main-table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>الكلية او القسم</th>
                            <th>الجهاز</th>
                            <th>العمل المنجز</th>
                            <th>الوصف</th>
                            <th>الكمية</th>
                            <th class="text-center">التحكم</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($reports as $report)
                            <tr>
                                <td>{{ ($reports->currentPage() - 1) * $reports->perPage() + $loop->iteration }}</td>
                                <td>{{ $report->department->name }}</td>
                                <td>{{ $report->device->name }}</td>
                                <td>{{ $report->work_done }}</td>
                                <td>{{ $report->description }}</td>
                                <td>{{ $report->quantity }}</td>

                                <td class="text-center">
                                    <div class="d-flex align-items-center justify-content-center gap-1">
                                    @can("عرض تقرير")
                                       {{--  <a class="btn btn-sm btn-info" href="{{ route('reports.show',$report->id) }}">
                                            عرض
                                        </a> --}}
                                    @endcan
                                    @can("تعديل تقرير")
                                    <a class="btn btn-sm btn-primary" href="{{ route('reports.edit', $report->id) }}">تعديل</a>
                                    @endcan
                                    @can("حذف تقرير")
                                    <div class="btn btn-sm btn-danger" data-bs-toggle="modal" data-report_id="{{ $report->id }}" data-report_title="{{ $report->device->name}}" data-bs-target="#modal-delete-report">
                                        حذف
                                    </div>
                                    @endcan

                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="pagination">
                    {{ $reports->links() }} <!-- This will render the pagination links -->
                </div>
            </div>
        </form>
    </div>
</section>
@endcan
@cannot('التقارير الشهرية')
    <div class="col-md-offset-1 col-md-10 alert alert-danger can">
        ليس لديك صلاحية يرجي مراجعة المسؤول
    </div>
@endcannot
@endsection

@section('script')

<script>
    $(document).ready(function() {
        $('#modal-delete-report').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var report_id = button.data('report_id')
            var report_title = button.data('report_title')
            var modal = $(this)

            modal.find('.modal-body #report_id').val(report_id);
            modal.find('.modal-body #report_title').val(report_title);
        });
    });
</script>

@endsection
